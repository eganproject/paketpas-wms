<?php

namespace App\Services;

/**
 * Membaca berkas eksport pesanan Shopee (Seller Centre > Pesanan Saya >
 * Export) menjadi data resi, lewat alur yang sama dengan TikTok Shop:
 * resi digabung per nomor resi, SKU dicocokkan ke master barang, resi yang
 * sudah ada dilewati, dan pesanan batal ikut ditandai batal.
 *
 * Eksport Shopee berbahasa Indonesia atau Inggris tergantung bahasa Seller
 * Centre, jadi keduanya dikenali. Data pembeli (nama, telepon, alamat) tidak
 * dibaca.
 *
 * Bedanya dengan TikTok: Shopee menulis batas kirimnya sendiri ("Pesanan
 * Harus Dikirimkan Sebelum"). Batas itu dipakai apa adanya dan dikunci.
 */
class ShopeeImportService extends TikTokImportService
{
    public const MARKETPLACE = 'Shopee';

    public const SOURCE = 'shopee';

    protected string $trackingLabel = 'No. Resi';

    protected string $skuLabel = 'Nomor Referensi SKU';

    /**
     * Judul kolom Shopee yang dibaca, dalam huruf kecil tanpa spasi dan
     * tanda baca. Judul yang sama bisa berbeda sedikit antar versi eksport.
     *
     * @var array<string, array<int, string>>
     */
    protected array $columns = [
        'tracking_number' => ['noresi', 'nomorresi', 'trackingnumber', 'trackingno'],
        'order_number' => ['nopesanan', 'nomorpesanan', 'orderid', 'ordersn'],
        // SKU variasi; produk tanpa variasi memakai SKU Induk (lihat rowSku).
        'sku' => ['nomorreferensisku', 'skureferenceno', 'skureferencenumber'],
        'parent_sku' => ['skuinduk', 'parentskureferenceno', 'parentskureferencenumber'],
        'variation' => ['namavariasi', 'variationname'],
        'product_name' => ['namaproduk', 'productname'],
        'quantity' => ['jumlah', 'quantity'],
        // Harga setelah diskon × jumlah, per baris produk.
        'amount' => ['totalhargaproduk', 'productsubtotal'],
        'order_status' => ['statuspesanan', 'orderstatus'],
        'courier' => ['opsipengiriman', 'shippingoption', 'shipmentmethod'],
        'shipping_method' => ['opsipengiriman', 'shippingoption', 'shipmentmethod'],
        'order_date' => ['waktupesanandibuat', 'ordercreationdate', 'ordercreationtime'],
        'paid_at' => ['waktupembayarandilakukan', 'orderpaidtime', 'paymenttime'],
        'ship_by' => [
            'pesananharusdikirimkansebelummenghindariketerlambatan',
            'pesananharusdikirimkansebelum',
            'shipbydate',
            'estimatedshipoutdate',
        ],
        'buyer_note' => ['catatandaripembeli', 'remarkfrombuyer', 'buyernote'],
    ];

    /**
     * Satu judul boleh mengisi beberapa kolom: "Opsi Pengiriman" dipakai
     * sebagai ekspedisi sekaligus metode kirim (mis. "Instant-GoSend").
     *
     * @param  array<int, string>  $headerRow
     * @return array<string, int>
     */
    protected function mapHeader(array $headerRow): array
    {
        $map = [];

        foreach ($headerRow as $index => $title) {
            $key = $this->slug($title);

            foreach ($this->columns as $field => $names) {
                if (! isset($map[$field]) && in_array($key, $names, true)) {
                    $map[$field] = $index;
                }
            }
        }

        return $map;
    }

    /**
     * Shopee tidak punya baris keterangan kolom.
     *
     * @param  array<int, string>  $row
     * @param  array<string, int>  $header
     */
    protected function isDescriptionRow(array $row, array $header): bool
    {
        return false;
    }

    /**
     * Nomor Referensi SKU (SKU variasi) lebih dulu; produk tanpa variasi
     * hanya punya SKU Induk.
     *
     * @param  array<int, string>  $row
     * @param  array<string, int>  $header
     */
    protected function rowSku(array $row, array $header): ?string
    {
        return $this->value($row, $header, 'sku') ?? $this->value($row, $header, 'parent_sku');
    }

    public function recognizes(\Illuminate\Support\Collection $top): bool
    {
        [$header] = $this->locateHeader($top);

        return isset($header['tracking_number']) && (isset($header['sku']) || isset($header['parent_sku']));
    }

    protected function noTrackingDetail(): string
    {
        return 'No. Resi Shopee baru terbit setelah pesanan diatur pengirimannya (Atur Pengiriman). Pesanan Belum Bayar juga belum punya resi. Ekspor ulang setelah itu.';
    }

    protected function noSkuDetail(): string
    {
        return 'Nomor Referensi SKU dan SKU Induk sama-sama kosong, jadi barangnya tidak bisa dikenali. Isi SKU produk ini di Shopee Seller Centre.';
    }

    protected function shipBySource(): ?string
    {
        return OrderPlanner::SOURCE_SHOPEE;
    }

    /**
     * Shopee menulis tanggal sebagai tahun-bulan-hari, mis. 2026-11-15 10:23.
     */
    protected function parseDate(?string $value): ?string
    {
        if (! blank($value)) {
            foreach (['!Y-m-d H:i:s', '!Y-m-d H:i', '!Y-m-d'] as $format) {
                try {
                    return \Illuminate\Support\Carbon::createFromFormat($format, trim($value))->toDateTimeString();
                } catch (\Throwable) {
                    // Coba format berikutnya.
                }
            }
        }

        return parent::parseDate($value);
    }
}

<?php

namespace Tests\Feature\Admin;

use App\Models\Product;
use App\Models\ShipmentImport;
use App\Models\ShipmentOrder;
use App\Models\User;
use App\Services\OrderPlanner;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tests\TestCase;

/**
 * Berkas eksport Shopee (Seller Centre > Pesanan Saya > Export) diunggah
 * lewat form yang sama dengan TikTok Shop dan dikenali dari judul kolomnya.
 */
class ShopeeImportTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    /**
     * Judul kolom eksport Shopee berbahasa Indonesia, urutan aslinya
     * (sebagian kolom tengah dihilangkan).
     */
    protected const HEADER = [
        'No. Pesanan', 'Status Pesanan', 'Alasan Pembatalan', 'Status Pembatalan/ Pengembalian',
        'No. Resi', 'Opsi Pengiriman', 'Antar ke counter/ pick-up',
        'Pesanan Harus Dikirimkan Sebelum (Menghindari keterlambatan)', 'Waktu Pengiriman Diatur',
        'Waktu Pesanan Dibuat', 'Waktu Pembayaran Dilakukan', 'Metode Pembayaran',
        'SKU Induk', 'Nama Produk', 'Nomor Referensi SKU', 'Nama Variasi',
        'Harga Awal', 'Harga Setelah Diskon', 'Jumlah', 'Returned quantity', 'Total Harga Produk',
        'Catatan dari Pembeli', 'Username (Pembeli)', 'Nama Penerima', 'No. Telepon', 'Alamat Pengiriman',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        $this->admin = User::where('email', 'admin@paketpas.test')->firstOrFail();

        Product::create(['sku' => 'FLT-OLI-STD', 'barcode' => '8991234500035', 'name' => 'Filter Oli Standar', 'unit' => 'pcs', 'min_stock' => 5]);
        Product::create(['sku' => 'BSI-IRIDIUM', 'barcode' => '8991234500073', 'name' => 'Busi Iridium', 'unit' => 'pcs', 'min_stock' => 10]);
        Product::create(['sku' => 'KAMPAS-REM', 'barcode' => '8991234500080', 'name' => 'Kampas Rem', 'unit' => 'pcs', 'min_stock' => 10]);
    }

    /**
     * @return array<int, string|int>
     */
    protected function row(array $values): array
    {
        $row = array_fill_keys(self::HEADER, '');

        foreach ($values as $column => $value) {
            $this->assertArrayHasKey($column, $row);
            $row[$column] = $value;
        }

        return array_values($row);
    }

    public function test_a_shopee_xlsx_export_is_recognised_and_imported(): void
    {
        $this->uploadXlsx([
            self::HEADER,
            $this->row([
                'No. Pesanan' => '2611150AB1CD2E', 'Status Pesanan' => 'Perlu Dikirim', 'No. Resi' => 'SPXID0123456789',
                'Opsi Pengiriman' => 'SPX Standard', 'Pesanan Harus Dikirimkan Sebelum (Menghindari keterlambatan)' => '2026-11-17 23:59',
                'Waktu Pesanan Dibuat' => '2026-11-15 09:12', 'Waktu Pembayaran Dilakukan' => '2026-11-15 09:13',
                'SKU Induk' => 'FLT', 'Nama Produk' => 'Filter Oli', 'Nomor Referensi SKU' => 'FLT-OLI-STD', 'Nama Variasi' => 'Standar',
                'Harga Setelah Diskon' => '25.000', 'Jumlah' => 2, 'Total Harga Produk' => '50.000',
                'Catatan dari Pembeli' => 'Bungkus rapi', 'Nama Penerima' => 'Andi', 'No. Telepon' => '0812', 'Alamat Pengiriman' => 'Jl. Mawar',
            ]),
            // Pesanan yang sama, produk kedua: baris terpisah, resi sama.
            $this->row([
                'No. Pesanan' => '2611150AB1CD2E', 'Status Pesanan' => 'Perlu Dikirim', 'No. Resi' => 'SPXID0123456789',
                'Opsi Pengiriman' => 'SPX Standard', 'Pesanan Harus Dikirimkan Sebelum (Menghindari keterlambatan)' => '2026-11-17 23:59',
                'Waktu Pembayaran Dilakukan' => '2026-11-15 09:13',
                // Produk tanpa variasi: hanya SKU Induk.
                'SKU Induk' => 'BSI-IRIDIUM', 'Nama Produk' => 'Busi Iridium', 'Jumlah' => 3, 'Total Harga Produk' => '90.000',
            ]),
            // Pesanan batal.
            $this->row([
                'No. Pesanan' => '2611150XY9ZZ1A', 'Status Pesanan' => 'Batal', 'Alasan Pembatalan' => 'Dibatalkan pembeli',
                'No. Resi' => 'JX0099887766', 'Opsi Pengiriman' => 'J&T Express',
                'Nomor Referensi SKU' => 'KAMPAS-REM', 'Jumlah' => 1,
            ]),
            // Belum bayar: belum punya resi.
            $this->row([
                'No. Pesanan' => '2611150BELUM01', 'Status Pesanan' => 'Belum Bayar',
                'Nomor Referensi SKU' => 'FLT-OLI-STD', 'Jumlah' => 1,
            ]),
        ])->assertSessionHas('error'); // ada satu baris gagal (belum ada resi)

        $import = ShipmentImport::firstOrFail();
        $this->assertSame('shopee', $import->source);
        $this->assertSame(2, $import->order_count);
        $this->assertSame(1, $import->failed_row_count);
        $this->assertSame(0, $import->unmatched_sku_count);

        $order = ShipmentOrder::where('tracking_number', 'SPXID0123456789')->firstOrFail();
        $this->assertSame('Shopee', $order->marketplace);
        $this->assertSame('2611150AB1CD2E', $order->order_number);
        $this->assertSame('SPX Standard', $order->courier);
        $this->assertSame('Bungkus rapi', $order->buyer_note);
        $this->assertSame('2026-11-15 09:13:00', $order->paid_at->toDateTimeString());
        $this->assertNull($order->buyer_name);
        $this->assertSame(5, $order->totalQuantity());
        $this->assertTrue($order->isFullyMatched());
        $this->assertEquals(50000, $order->items->firstWhere('sku', 'FLT-OLI-STD')->amount);
        $this->assertEquals(90000, $order->items->firstWhere('sku', 'BSI-IRIDIUM')->amount);

        // Batas kirim dari Shopee dipakai apa adanya dan tidak ditimpa planner.
        $order->refresh();
        $this->assertSame('2026-11-17 23:59:00', $order->ship_by->toDateTimeString());
        $this->assertSame(OrderPlanner::SOURCE_SHOPEE, $order->ship_by_source);

        $this->assertTrue(ShipmentOrder::where('tracking_number', 'JX0099887766')->firstOrFail()->isCancelled());
        $this->assertSame('2611150BELUM01', $import->failures()->first()->order_number);
    }

    public function test_an_english_shopee_csv_export_is_recognised(): void
    {
        $this->uploadCsv([
            ['Order ID', 'Order Status', 'Tracking Number*', 'Shipping Option', 'Parent SKU Reference No.', 'Product Name', 'SKU Reference No.', 'Variation Name', 'Quantity'],
            ['2611150EN0001', 'To ship', 'SPXID55500011', 'Instant-GoSend', 'FLT', 'Filter Oli', 'FLT-OLI-STD', 'Standar', '4'],
        ])->assertSessionHas('success');

        $order = ShipmentOrder::firstOrFail();
        $this->assertSame('Shopee', $order->marketplace);
        $this->assertSame('Instant-GoSend', $order->shipping_method);
        $this->assertSame(4, $order->totalQuantity());
        $this->assertSame('shopee', ShipmentImport::firstOrFail()->source);
    }

    public function test_reuploading_an_overlapping_shopee_export_skips_known_waybills(): void
    {
        $rows = [
            self::HEADER,
            $this->row(['No. Pesanan' => '2611150AB1CD2E', 'Status Pesanan' => 'Perlu Dikirim', 'No. Resi' => 'SPXID0123456789', 'Nomor Referensi SKU' => 'FLT-OLI-STD', 'Jumlah' => 1]),
        ];

        $this->uploadXlsx($rows)->assertSessionHas('success');
        $this->uploadXlsx($rows)->assertSessionHas('success');

        $this->assertDatabaseCount('shipment_orders', 1);
        $this->assertSame(1, ShipmentImport::latest('id')->first()->skipped_count);
    }

    public function test_a_shopee_file_without_a_sku_column_is_rejected_with_a_shopee_message(): void
    {
        $this->uploadXlsx([
            ['No. Pesanan', 'No. Resi', 'Nama Produk', 'Jumlah'],
            ['2611150AB1CD2E', 'SPXID0123456789', 'Filter Oli', 1],
        ])->assertSessionHasErrors(['file' => 'Kolom Nomor Referensi SKU tidak ditemukan. Pastikan berkas adalah eksport pesanan Shopee.']);

        $this->assertDatabaseCount('shipment_orders', 0);
    }

    public function test_tiktok_exports_still_go_to_the_tiktok_reader(): void
    {
        $this->uploadXlsx([
            ['Order ID', 'Tracking ID', 'Seller SKU', 'Quantity'],
            ['INV-001', 'TT111', 'FLT-OLI-STD', 2],
        ])->assertSessionHas('success');

        $this->assertSame('TikTok Shop', ShipmentOrder::firstOrFail()->marketplace);
        $this->assertSame('tiktok', ShipmentImport::firstOrFail()->source);
    }

    /* --------------------------------------------------- helpers --------- */

    protected function uploadXlsx(array $rows)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($rows as $rowIndex => $row) {
            foreach ($row as $columnIndex => $value) {
                if ($value !== '') {
                    $sheet->setCellValueExplicit([$columnIndex + 1, $rowIndex + 1], (string) $value,
                        is_int($value) ? \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC : \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                }
            }
        }

        $path = tempnam(sys_get_temp_dir(), 'shopee').'.xlsx';
        (new Xlsx($spreadsheet))->save($path);

        return $this->actingAs($this->admin)->post(route('admin.imports.store'), [
            'file' => new UploadedFile($path, 'Order.all.20261115.xlsx', null, null, true),
        ]);
    }

    protected function uploadCsv(array $rows)
    {
        $path = tempnam(sys_get_temp_dir(), 'shopee').'.csv';
        file_put_contents($path, collect($rows)->map(fn (array $row) => implode(',', $row))->implode("\n"));

        return $this->actingAs($this->admin)->post(route('admin.imports.store'), [
            'file' => new UploadedFile($path, 'shopee.csv', 'text/csv', null, true),
        ]);
    }
}

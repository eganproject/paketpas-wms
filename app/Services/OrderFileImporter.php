<?php

namespace App\Services;

use App\Models\ShipmentImport;
use Illuminate\Http\UploadedFile;

/**
 * Satu pintu unggah berkas pesanan: asal berkas (TikTok Shop atau Shopee)
 * dikenali dari judul kolomnya, lalu diteruskan ke pembaca yang sesuai.
 * Admin tidak perlu memilih marketplace lebih dulu.
 */
class OrderFileImporter
{
    public function __construct(
        protected TikTokImportService $tiktok,
        protected ShopeeImportService $shopee,
    ) {
    }

    public function import(UploadedFile $file): ShipmentImport
    {
        return $this->importerFor($file)->import($file);
    }

    /**
     * Berkas yang belum lengkap kolomnya diteruskan ke pembaca yang paling
     * mirip (kolom resinya dikenali), lalu ditolak di sana dengan pesan yang
     * menjelaskan kolom apa yang kurang. Selebihnya ke pembaca TikTok.
     */
    public function importerFor(UploadedFile $file): TikTokImportService
    {
        $top = $this->tiktok->peek($file);

        foreach ([$this->tiktok, $this->shopee] as $importer) {
            if ($importer->recognizes($top)) {
                return $importer;
            }
        }

        return $this->shopee->hasTrackingColumn($top) ? $this->shopee : $this->tiktok;
    }
}

<?php

/*
 * Kontak yang dipakai tombol ajakan di landing page (halaman depan).
 *
 * LANDING_WHATSAPP boleh ditulis seperti biasa (08975568102) atau format
 * internasional (628975568102); awalan 0 otomatis diubah menjadi 62.
 * Bila nomor dikosongkan, tombol ajakan mengarah ke LANDING_EMAIL; bila
 * keduanya kosong, ke halaman masuk.
 */
$whatsapp = preg_replace('/\D+/', '', (string) env('LANDING_WHATSAPP', '08975568102'));

if (str_starts_with($whatsapp, '0')) {
    $whatsapp = '62'.substr($whatsapp, 1);
}

return [
    'whatsapp' => $whatsapp,
    'contact_name' => env('LANDING_CONTACT_NAME', 'Ega Nugraha'),
    'whatsapp_message' => env('LANDING_WHATSAPP_MESSAGE', 'Halo Kak Ega, saya tertarik dengan Paketpas dan ingin lihat demo WMS untuk toko saya.'),
    'email' => env('LANDING_EMAIL', ''),

    /*
     * Harga di bagian "Harga" landing page. Ubah angka atau isi di sini saja,
     * tampilan mengikuti. 'wa' adalah pesan pembuka WhatsApp untuk paket itu.
     */
    'pricing' => [
        'rent' => [
            'name' => 'Sewa',
            'tagline' => 'Mulai ringan, langsung jalan.',
            'price' => 'Rp 750 rb',
            'period' => '/ bulan',
            'note' => 'Minimal 6 bulan, atau Rp 7,5 juta per tahun (hemat Rp 1,5 juta).',
            'features' => [
                'Semua fitur web dan aplikasi Android Paketpas Scan',
                'Import pesanan, QC kemas, serah terima, retur, stok, dan laporan',
                'Pembaruan sistem dan perbaikan rutin',
                'Bantuan via WhatsApp',
            ],
            'wa' => 'Halo Kak Ega, saya tertarik dengan paket Sewa Paketpas.',
        ],
        'setup' => [
            'name' => 'Implementasi & Kustomisasi',
            'tagline' => 'Biaya awal paket sewa, dikerjakan jarak jauh di bulan pertama.',
            'price' => 'Rp 7 juta',
            'period' => 'sekali bayar',
            'features' => [
                'Analisis alur gudang kamu sekarang',
                'Penyesuaian sistem selama bulan pertama sesuai proses bisnis',
                'Migrasi data produk dan stok awal',
                'Pelatihan tim secara online',
            ],
        ],
        'buy' => [
            'name' => 'Beli Putus',
            'tagline' => 'Sekali bayar, sistem jadi milikmu.',
            'price' => 'Rp 30 juta',
            'period' => 'sekali bayar',
            'note' => 'Maintenance opsional Rp 5 juta per tahun.',
            'features' => [
                'Semua fitur web dan aplikasi Android Paketpas Scan',
                'Implementasi dan kustomisasi bulan pertama sudah termasuk',
                'Migrasi data dan pelatihan tim online',
                'Tanpa biaya bulanan',
            ],
            'wa' => 'Halo Kak Ega, saya tertarik dengan paket Beli Putus Paketpas.',
        ],
    ],

    /*
     * Produk kedua: Santap POS, sistem kasir untuk restoran & kafe
     * (repo eganproject/POSFnB). Bagian ini hilang bila 'url' dikosongkan.
     */
    'pos' => [
        'url' => env('LANDING_POS_URL', 'https://pos.paketpas.tech'),
        'wa' => 'Halo Kak Ega, saya punya usaha kuliner dan tertarik dengan Santap POS.',
    ],

    /*
     * Jasa development: contoh hasil kerja yang tampil di landing page.
     * Tambah atau hapus entri di sini saja; 'type' tampil sebagai label kecil,
     * 'points' adalah hal yang benar-benar ada di situs itu.
     */
    'services_wa' => 'Halo Kak Ega, saya ingin dibuatkan website / sistem untuk usaha saya.',
    'portfolio' => [
        [
            'name' => 'Cheery Chic',
            'url' => 'https://cheery-chic.com',
            'type' => 'Website toko online',
            'summary' => 'Toko online daster dan one set rayon, lengkap dengan katalog per koleksi dan harga promo.',
            'points' => ['Katalog per koleksi', 'Pilihan motif tiap produk', 'Harga grosir & flash sale'],
            'accent' => '#E86A92',
        ],
        [
            'name' => 'Albaniah Mukena',
            'url' => 'https://albaniah.optisync.tech',
            'type' => 'Website toko online',
            'summary' => 'Toko online mukena dengan koleksi renda, bordir, travel, dan tutup dagu.',
            'points' => ['Belanja per koleksi', 'Pilihan warna & motif', 'Promo dan ulasan produk'],
            'accent' => '#2F7D6B',
        ],
    ],
];

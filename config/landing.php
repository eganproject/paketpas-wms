<?php

/*
 * Kontak yang dipakai tombol ajakan di landing page (halaman depan).
 *
 * Isi LANDING_WHATSAPP dengan nomor WhatsApp berformat internasional tanpa
 * tanda plus, mis. 6281234567890. Bila kosong, tombol ajakan mengarah ke
 * LANDING_EMAIL; bila keduanya kosong, ke halaman masuk.
 */
return [
    'whatsapp' => preg_replace('/\D+/', '', (string) env('LANDING_WHATSAPP', '')),
    'whatsapp_message' => env('LANDING_WHATSAPP_MESSAGE', 'Halo Paketpas, saya ingin lihat demo WMS untuk toko saya.'),
    'email' => env('LANDING_EMAIL', ''),
];

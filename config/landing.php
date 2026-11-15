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
];

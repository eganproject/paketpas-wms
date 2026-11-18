# Menaikkan Paketpas ke VPS (paketpas.tech)

Panduan ini untuk VPS Ubuntu yang sudah menjalankan aplikasi lain
(`cheery-chic.com` dan `wms.cheery-chic.com`). Polanya sama: Paketpas
mendapat **user Linux, database, pool PHP-FPM, situs Nginx, dan worker
Supervisor sendiri**, sehingga tidak menyentuh aplikasi yang sudah jalan.

| Bagian | Nilai |
|---|---|
| Domain | `paketpas.tech` dan `www.paketpas.tech` |
| User Linux | `paketpas` |
| Folder | `/var/www/paketpas` |
| Database / user DB | `paketpas` / `paketpas` |
| Socket PHP-FPM | `/run/php/paketpas.sock` |
| Catatan kredensial | `/root/paketpas-credentials.txt` |

Semua perintah dijalankan sebagai `root` setelah `ssh root@IP-VPS`, kecuali
yang tertulis `sudo -u paketpas`. Kerjakan berurutan.

---

## 0. DNS (kerjakan paling awal)

Di panel tempat domain `paketpas.tech` dibeli, buat dua record:

| Tipe | Nama | Nilai | TTL |
|---|---|---|---|
| A | `@` | IP VPS | 300 / Auto |
| A | `www` | IP VPS | 300 / Auto |

Hapus record A/AAAA/CNAME lama untuk `@` dan `www` bila ada (mis. parkir
bawaan registrar). Bila VPS tidak punya IPv6, jangan buat record AAAA.

Cek dari VPS (boleh sambil mengerjakan langkah lain, propagasi bisa
beberapa menit sampai beberapa jam):

```bash
dig +short paketpas.tech
dig +short www.paketpas.tech
```

Keduanya harus menampilkan IP VPS sebelum langkah 9 (SSL).

## 1. Tentukan versi PHP

Server punya beberapa versi PHP. Pakai versi yang sama dengan WMS lama
agar ekstensinya sudah pasti lengkap:

```bash
ls /etc/php/
grep -l "\[wms\]" /etc/php/*/fpm/pool.d/*.conf
```

Baris kedua menunjukkan folder versi yang dipakai WMS, mis.
`/etc/php/8.4/fpm/pool.d/wms.conf` berarti `8.4`. Simpan ke variabel
(ganti angkanya sesuai hasil di atas). **Variabel ini hilang bila sesi SSH
terputus — jalankan lagi baris ini setelah masuk ulang.**

```bash
PHPV=8.4
php$PHPV -v                       # harus 8.2 ke atas
php$PHPV -m | grep -Ei "pdo_mysql|mbstring|xml|curl|zip|gd|intl|bcmath|fileinfo"
```

## 2. User Linux dan folder

```bash
adduser --disabled-password --gecos "" paketpas
mkdir -p /var/www/paketpas
chown paketpas:paketpas /var/www/paketpas
chmod 750 /var/www/paketpas
usermod -aG paketpas www-data     # Nginx perlu membaca folder public/
```

## 3. Database

Buat sandi acak lalu catat di file khusus root (sama seperti pola
`/root/cheerychic-credentials.txt`). Sandi tidak perlu diketik ulang di
mana pun selain `.env` nanti.

```bash
DBPASS=$(openssl rand -base64 24 | tr -d '/+=' | cut -c1-24)

mysql <<SQL
CREATE DATABASE paketpas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'paketpas'@'localhost' IDENTIFIED BY '${DBPASS}';
GRANT ALL PRIVILEGES ON paketpas.* TO 'paketpas'@'localhost';
FLUSH PRIVILEGES;
SQL

printf "Paketpas (paketpas.tech)\nDB_DATABASE=paketpas\nDB_USERNAME=paketpas\nDB_PASSWORD=%s\n" "$DBPASS" > /root/paketpas-credentials.txt
chmod 600 /root/paketpas-credentials.txt
```

Bila `mysql` meminta sandi root, pakai `mysql -u root -p` dan isi sandi
root MySQL yang sudah ada.

## 4. Ambil kode dari GitHub

Pakai *deploy key*: kunci SSH khusus yang hanya bisa **membaca** repo ini.
Cara ini jalan baik repo publik maupun privat, dan tidak memakai akun
GitHub pribadi di server.

```bash
sudo -u paketpas mkdir -p -m 700 /home/paketpas/.ssh
sudo -u paketpas ssh-keygen -t ed25519 -N "" -C "paketpas-vps" -f /home/paketpas/.ssh/id_ed25519
cat /home/paketpas/.ssh/id_ed25519.pub
```

Salin satu baris yang tampil, lalu di GitHub buka repo
`eganproject/paketpas-wms` → **Settings → Deploy keys → Add deploy key**.
Judul bebas (mis. `VPS paketpas.tech`), tempel kuncinya, **jangan**
centang *Allow write access*, lalu simpan.

Kemudian:

```bash
sudo -u paketpas ssh -o StrictHostKeyChecking=accept-new -T git@github.com   # "successfully authenticated" = beres
sudo -u paketpas git clone git@github.com:eganproject/paketpas-wms.git /var/www/paketpas
```

## 5. Dependensi PHP

```bash
cd /var/www/paketpas
sudo -u paketpas composer install --no-dev --optimize-autoloader
```

Hasil build CSS/JS (`public/build/`) sudah ikut di repo, jadi **tidak perlu
`npm`** di server.

## 6. Berkas `.env`

```bash
cd /var/www/paketpas
sudo -u paketpas cp .env.example .env
chmod 640 .env
```

Ubah nilai berikut. Cara tercepat, tempel blok ini utuh (sandi DB diambil
dari variabel `DBPASS` langkah 3; bila sesi SSH sempat terputus, jalankan
dulu `DBPASS=$(grep DB_PASSWORD /root/paketpas-credentials.txt | cut -d= -f2)`):

```bash
cd /var/www/paketpas
sed -i \
  -e 's|^APP_ENV=.*|APP_ENV=staging|' \
  -e 's|^APP_DEBUG=.*|APP_DEBUG=false|' \
  -e 's|^APP_URL=.*|APP_URL=https://paketpas.tech|' \
  -e 's|^LOG_LEVEL=.*|LOG_LEVEL=warning|' \
  -e 's|^DB_CONNECTION=.*|DB_CONNECTION=mysql|' \
  -e 's|^# DB_HOST=.*|DB_HOST=127.0.0.1|' \
  -e 's|^# DB_PORT=.*|DB_PORT=3306|' \
  -e 's|^# DB_DATABASE=.*|DB_DATABASE=paketpas|' \
  -e 's|^# DB_USERNAME=.*|DB_USERNAME=paketpas|' \
  -e "s|^# DB_PASSWORD=.*|DB_PASSWORD=${DBPASS}|" \
  -e 's|^SESSION_ENCRYPT=.*|SESSION_ENCRYPT=false\nSESSION_SECURE_COOKIE=true|' \
  -e 's|^MAIL_FROM_ADDRESS=.*|MAIL_FROM_ADDRESS="noreply@paketpas.tech"|' \
  .env

# Token acak untuk kiriman APK otomatis dan API stok
echo "MOBILE_APP_PUBLISH_TOKEN=$(openssl rand -hex 32)" >> .env
sed -i "s|^STOCK_API_TOKEN=.*|STOCK_API_TOKEN=$(openssl rand -hex 32)|" .env

grep -E "^(APP_|DB_|SESSION_SECURE|LANDING_|MOBILE_APP_PUBLISH)" .env   # periksa hasilnya
```

Yang perlu dipastikan:

- `APP_ENV=staging` dipakai selama masa uji. `reset:data` tetap meminta konfirmasi.
- `APP_DEBUG=false` — wajib. Bila `true`, galat menampilkan isi konfigurasi
  ke siapa pun.
- `LANDING_WHATSAPP=08975568102` dan `LANDING_CONTACT_NAME` sudah terisi
  dari `.env.example`; ubah bila nomornya ganti.
- `MAIL_MAILER=log` dibiarkan dulu: aplikasi belum mengirim email. Isi
  SMTP nanti bila dibutuhkan.
- `QUEUE_CONNECTION=database` dan `CACHE_STORE=database` sudah benar.

## 7. Kunci aplikasi, tabel, data awal

```bash
cd /var/www/paketpas
sudo -u paketpas php$PHPV artisan key:generate --force
sudo -u paketpas php$PHPV artisan migrate --force
sudo -u paketpas php$PHPV artisan db:seed --force
sudo -u paketpas php$PHPV artisan storage:link

chmod -R ug+rwX storage bootstrap/cache
```

`db:seed` membuat izin, tiga role, daftar supplier awal, dan akun
**`admin@paketpas.test` dengan sandi `password`** — ganti di langkah 12.

## 8. Pool PHP-FPM sendiri

```bash
cat > /etc/php/$PHPV/fpm/pool.d/paketpas.conf <<'EOF'
[paketpas]
user = paketpas
group = paketpas

listen = /run/php/paketpas.sock
listen.owner = www-data
listen.group = www-data
listen.mode = 0660

pm = ondemand
pm.max_children = 8
pm.process_idle_timeout = 30s
pm.max_requests = 500

php_admin_value[upload_max_filesize] = 100M
php_admin_value[post_max_size] = 110M
php_admin_value[memory_limit] = 512M
php_admin_value[max_execution_time] = 300
php_admin_value[date.timezone] = Asia/Jakarta
php_admin_value[error_log] = /var/www/paketpas/storage/logs/php-error.log
php_admin_flag[log_errors] = on
EOF

php-fpm$PHPV -t && systemctl reload php$PHPV-fpm
ls -l /run/php/paketpas.sock     # socket harus muncul
```

`memory_limit` dan `max_execution_time` dinaikkan karena import Excel
pesanan dan cetak PDF bisa berat. Bila RAM VPS kecil (≤ 2 GB), turunkan
`pm.max_children` ke `5`.

## 9. Situs Nginx

```bash
cat > /etc/nginx/sites-available/paketpas <<'EOF'
server {
    listen 80;
    listen [::]:80;
    server_name paketpas.tech www.paketpas.tech;

    root /var/www/paketpas/public;
    index index.php;
    charset utf-8;

    client_max_body_size 100M;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/paketpas.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_read_timeout 300;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    access_log /var/log/nginx/paketpas.access.log;
    error_log  /var/log/nginx/paketpas.error.log;
}
EOF

ln -s /etc/nginx/sites-available/paketpas /etc/nginx/sites-enabled/paketpas
nginx -t && systemctl reload nginx
```

Coba buka `http://paketpas.tech` — landing page harus tampil (masih tanpa
gembok). Bila muncul situs lain, DNS belum mengarah atau `server_name`
salah ketik.

## 10. SSL Let's Encrypt

Pastikan `dig +short paketpas.tech` sudah menampilkan IP VPS, lalu:

```bash
certbot --nginx -d paketpas.tech -d www.paketpas.tech --redirect
certbot renew --dry-run          # memastikan perpanjangan otomatis jalan
```

Certbot menambahkan blok `listen 443` dan pengalihan HTTP → HTTPS ke file
situs tadi. Sertifikat diperpanjang otomatis oleh timer yang sama dengan
dua aplikasi lain.

## 11. Worker antrean (Supervisor) dan scheduler (cron)

Saat ini Paketpas belum memakai job antrean maupun jadwal, tetapi keduanya
dipasang sekarang agar fitur berikutnya langsung jalan tanpa mengubah
server lagi. Bebannya nyaris nol.

```bash
cat > /etc/supervisor/conf.d/paketpas-worker.conf <<EOF
[program:paketpas-worker]
process_name=%(program_name)s_%(process_num)02d
command=/usr/bin/php$PHPV /var/www/paketpas/artisan queue:work --sleep=3 --tries=3 --max-time=3600
user=paketpas
numprocs=1
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
stopwaitsecs=3600
redirect_stderr=true
stdout_logfile=/var/www/paketpas/storage/logs/worker.log
EOF

supervisorctl reread
supervisorctl update
supervisorctl status paketpas-worker:*      # harus RUNNING

# Scheduler Laravel, tiap menit, sebagai user paketpas
echo "* * * * * cd /var/www/paketpas && /usr/bin/php$PHPV artisan schedule:run >> /dev/null 2>&1" | crontab -u paketpas -
crontab -u paketpas -l
```

## 12. Cache produksi, lalu masuk

```bash
cd /var/www/paketpas
sudo -u paketpas php$PHPV artisan config:cache
sudo -u paketpas php$PHPV artisan route:cache
sudo -u paketpas php$PHPV artisan view:cache
```

Buka:

- `https://paketpas.tech` — landing page
- `https://paketpas.tech/login` → masuk dengan `admin@paketpas.test` /
  `password` → diarahkan ke `/admin`
- `https://paketpas.tech/unduh-aplikasi` — halaman unduh APK

**Segera ganti sandi admin** lewat menu profil. Lebih baik lagi: buat akun
Super Admin baru dengan email asli Anda, lalu nonaktifkan
`admin@paketpas.test`. Ingat, menjalankan `db:seed` lagi akan
mengembalikan sandi akun itu menjadi `password` (lihat `DEPLOY.md` bagian 8).

## 13. Kiriman APK Android otomatis (opsional)

Agar setiap build Android dari GitHub Actions langsung masuk ke server:

```bash
grep MOBILE_APP_PUBLISH_TOKEN /var/www/paketpas/.env
```

Di GitHub repo → **Settings → Secrets and variables → Actions**, isi:

- `WMS_PUBLISH_URL` = `https://paketpas.tech`
- `WMS_PUBLISH_TOKEN` = nilai token di atas
- secret kunci tanda tangan `WMS_KEYSTORE_*` (lihat `android/README.md`)

Batas unggah 100 MB sudah diatur di Nginx (langkah 9) dan pool PHP
(langkah 8). Hasilnya terlihat di *Pengaturan → Aplikasi Android*.

---

## Memperbarui aplikasi

Setiap ada perubahan di `main`:

```bash
PHPV=8.4      # sesuaikan dengan langkah 1
cd /var/www/paketpas
sudo -u paketpas php$PHPV artisan down
sudo -u paketpas git pull --ff-only
sudo -u paketpas composer install --no-dev --optimize-autoloader
sudo -u paketpas php$PHPV artisan migrate --force
sudo -u paketpas php$PHPV artisan optimize:clear
sudo -u paketpas php$PHPV artisan config:cache
sudo -u paketpas php$PHPV artisan route:cache
sudo -u paketpas php$PHPV artisan view:cache
supervisorctl restart paketpas-worker:*
systemctl reload php$PHPV-fpm
sudo -u paketpas php$PHPV artisan up
```

Bila pembaruan membawa izin baru, jalankan juga
`sudo -u paketpas php$PHPV artisan db:seed --class=RolePermissionSeeder --force`
(baca dulu akibat sampingnya di `DEPLOY.md` bagian 8).

## Bila ada masalah

| Gejala | Periksa |
|---|---|
| 502 Bad Gateway | `systemctl status php$PHPV-fpm`, `ls -l /run/php/paketpas.sock`, `tail /var/www/paketpas/storage/logs/php-error.log` |
| 500 / halaman putih | `tail -50 /var/www/paketpas/storage/logs/laravel.log` |
| 403 / *Permission denied* | `id www-data` harus memuat grup `paketpas`; `chmod -R ug+rwX storage bootstrap/cache` |
| Perubahan `.env` tidak berpengaruh | `sudo -u paketpas php$PHPV artisan config:cache` |
| 413 saat unggah APK/Excel | `client_max_body_size` di Nginx dan `upload_max_filesize` di pool |
| Certbot gagal | DNS belum mengarah: `dig +short paketpas.tech` |
| Situs lain ikut terganggu | Tidak seharusnya — Paketpas punya pool & situs sendiri. `nginx -t` dulu sebelum reload. |

**Mesin absen ZKTeco**: bila nanti memakai mesin fingerprint yang mengirim
lewat `http://` (bukan https) ke `/iclock/...`, pengalihan HTTPS dari
Certbot bisa membuat mesin gagal mengirim. Atur mesinnya memakai port 443
bila didukung; bila tidak, tambahkan pengecualian `location /iclock/` di
blok `listen 80`.

Log penting:

- Aplikasi: `/var/www/paketpas/storage/logs/laravel.log`
- Worker: `/var/www/paketpas/storage/logs/worker.log`
- Nginx: `/var/log/nginx/paketpas.error.log`
- PHP-FPM: `/var/www/paketpas/storage/logs/php-error.log`

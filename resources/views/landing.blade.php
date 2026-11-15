@php
    // Ikon garis sederhana (24×24, stroke).
    $icons = [
        'upload' => '<path d="M12 15V4m0 0-4 4m4-4 4 4"/><path d="M4 15v3a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-3"/>',
        'scan' => '<path d="M4 8V6a2 2 0 0 1 2-2h2M16 4h2a2 2 0 0 1 2 2v2M20 16v2a2 2 0 0 1-2 2h-2M8 20H6a2 2 0 0 1-2-2v-2"/><path d="M7 12h10"/>',
        'truck' => '<path d="M3 6h11v10H3z"/><path d="M14 9h4l3 3v4h-7"/><circle cx="7" cy="18" r="1.8"/><circle cx="17" cy="18" r="1.8"/>',
        'box' => '<path d="m21 8-9-5-9 5 9 5 9-5Z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/>',
        'clipboard' => '<rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4V3h6v1"/><path d="m9 13 2 2 4-4"/>',
        'calendar' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/>',
        'qr' => '<rect x="4" y="4" width="6" height="6" rx="1"/><rect x="14" y="4" width="6" height="6" rx="1"/><rect x="4" y="14" width="6" height="6" rx="1"/><path d="M14 14h2v2h-2zM18 18h2v2h-2zM14 18h2M18 14h2"/>',
        'user' => '<circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/>',
        'shield' => '<path d="M12 3 4 6v6c0 5 3.5 8 8 9 4.5-1 8-4 8-9V6l-8-3Z"/><path d="m9 12 2 2 4-4"/>',
        'return' => '<path d="M9 14 4 9l5-5"/><path d="M4 9h10.5a5.5 5.5 0 0 1 0 11H11"/>',
        'plug' => '<path d="M9 2v6M15 2v6"/><path d="M6 8h12v4a6 6 0 0 1-12 0V8Z"/><path d="M12 18v4"/>',
        'check' => '<path d="m5 12 5 5L20 7"/>',
        'arrow' => '<path d="M5 12h14m-6-6 6 6-6 6"/>',
        'plus' => '<path d="M12 5v14M5 12h14"/>',
        'spark' => '<path d="M12 3v4M12 17v4M3 12h4M17 12h4M6 6l2.5 2.5M15.5 15.5 18 18M6 18l2.5-2.5M15.5 8.5 18 6"/>',
    ];
    $icon = fn (string $name, string $class = 'h-5 w-5') => '<svg class="'.$class.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.$icons[$name].'</svg>';

    $ctaAttributes = $contactIsExternal ? 'target="_blank" rel="noopener"' : '';
    $img = fn (string $file) => asset('images/landing/'.$file);

    // Pita berjalan di bawah hero: janji-janji singkat berima "-as".
    $ticker = ['Resi tercatat jelas', 'Packing tanpa was-was', 'Stok selalu pas', 'Retur beres tuntas', 'Serah terima, bukti jelas', 'Laporan ringkas', 'Pembeli puas', 'Bisnis naik kelas'];

    // Babak presentasi. Setiap babak: judul berima, poin manfaat, dan screenshot asli aplikasi.
    $chapters = [
        [
            'id' => 'babak-pesanan', 'no' => '01', 'tag' => 'Pesanan masuk',
            'title' => 'Pesanan masuk, langsung tertata jelas.',
            'lead' => 'Unggah file pesanan TikTok Shop atau Shopee sekali, Paketpas yang memilah. Kamu langsung tahu mana yang belum dikemas, mana yang harus kirim hari ini, dan mana yang batal.',
            'points' => ['Resi ganda dan pesanan batal langsung ditandai', 'Tab Belum QC, Sudah QC, Dikirim dengan jumlah di tiap tab', 'Filter prioritas: lewat batas kirim, tunggu stok, pre-order'],
            'web' => ['web-orders.webp', 'paketpas.id/admin/orders', 'Halaman Pesanan: setiap resi hasil import dengan posisinya di gudang'],
            'phones' => [],
        ],
        [
            'id' => 'babak-kemas', 'no' => '02', 'tag' => 'QC kemas',
            'title' => 'Scan dulu baru kemas, salah kirim pun lepas.',
            'lead' => 'Scan resi, lalu scan setiap barang yang masuk kardus. Barang yang salah langsung ditolak, dan paket baru dianggap lengkap kalau semua barangnya sudah cocok.',
            'points' => ['Daftar barang lengkap dengan foto, SKU, dan jumlahnya', 'Bisa dari komputer dengan scanner, atau dari HP dengan kamera', 'Selesai satu paket, layar langsung siap untuk resi berikutnya'],
            'web' => ['web-qc.webp', 'paketpas.id/admin/outbounds/marketplace', 'QC Kemas di web: barang pertama sudah cocok, tinggal satu lagi'],
            'phones' => [['app-lengkap.webp', 'Aplikasi Android: paket lengkap, lanjut resi berikutnya']],
        ],
        [
            'id' => 'babak-serah', 'no' => '03', 'tag' => 'Serah terima kurir',
            'title' => 'Paket diserahkan, buktinya tetap jelas.',
            'lead' => 'Setiap paket yang diambil kurir di-scan dulu. Tidak ada lagi perdebatan "sudah diambil atau belum", karena semuanya tercatat jam dan petugasnya.',
            'points' => ['Antrean paket siap kirim per ekspedisi', 'Paket yang belum selesai QC tidak bisa ikut terkirim', 'Stok berkurang otomatis saat paket diserahkan'],
            'web' => ['web-handover.webp', 'paketpas.id/admin/outbounds/handover', 'Serah Terima Paket: antrean paket yang lolos QC'],
            'phones' => [['app-serah-terima.webp', 'Serah terima dari HP, dengan riwayat sesi']],
        ],
        [
            'id' => 'babak-hp', 'no' => '04', 'tag' => 'Aplikasi Android',
            'title' => 'Gudang di genggaman, kerja makin tangkas.',
            'lead' => 'Tim gudang tidak perlu duduk di depan komputer. Aplikasi Paketpas Scan mengubah HP Android biasa jadi alat kerja: target hari ini, scan kemas, serah terima, sampai rincian tiap resi.',
            'points' => ['Beranda dengan target kirim hari ini dan yang lewat batas', 'Daftar pesanan dengan filter prioritas', 'Pembaruan aplikasi langsung dari server sendiri'],
            'web' => null,
            'phones' => [['app-beranda.webp', 'Beranda: target kirim hari ini'], ['app-pesanan.webp', 'Pesanan prioritas'], ['app-rincian.webp', 'Rincian resi dan isi paket']],
        ],
        [
            'id' => 'babak-stok', 'no' => '05', 'tag' => 'Stok & restock',
            'title' => 'Stok terbaca jelas, restock tak kebablasan.',
            'lead' => 'Setiap barang masuk, keluar, retur, dan koreksi tercatat. Paketpas membaca laju jual tiap barang lalu memberi tahu apa yang perlu dipesan, berapa banyak, dan seberapa mendesak.',
            'points' => ['Kebutuhan restock dengan saran jumlah pesan', 'Stok terikat pesanan dihitung, jadi tidak oversell', 'Master barang dengan foto, lokasi rak, dan batas menipis'],
            'web' => ['web-restock.webp', 'paketpas.id/admin/reports/restock', 'Kebutuhan Restock: barang yang perlu dipesan dan jumlahnya'],
            'web2' => ['web-products.webp', 'Master barang dengan foto, stok, dan status'],
            'phones' => [],
        ],
        [
            'id' => 'babak-laporan', 'no' => '06', 'tag' => 'Untuk pemilik',
            'title' => 'Laporan ringkas, keputusan pun tegas.',
            'lead' => 'Buka satu halaman dan langsung tahu omzet, jumlah pesanan per hari, beban tiap ekspedisi, sampai kinerja tim. Tidak perlu lagi menyusun spreadsheet sendiri di akhir bulan.',
            'points' => ['Ringkasan bisnis harian, mingguan, dan bulanan', 'Resi per ekspedisi dan per hari, lengkap dengan kesiapannya', 'Semua laporan bisa diekspor ke Excel'],
            'web' => ['web-owner.webp', 'paketpas.id/admin/reports/ringkasan-bisnis', 'Ringkasan Bisnis: omzet dan pesanan per hari'],
            'web2' => ['web-couriers.webp', 'Beban per ekspedisi hari ini'],
            'phones' => [],
        ],
    ];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Paketpas — Paket pas, pembeli puas, bisnis naik kelas</title>
    <meta name="description" content="Paketpas adalah WMS untuk seller marketplace: import pesanan, packing dengan scan, serah terima kurir, retur, stok, dan laporan dalam satu alur yang ringkas dan jelas.">
    <meta name="theme-color" content="#111827">

    <meta property="og:title" content="Paketpas — Paket pas, pembeli puas, bisnis naik kelas">
    <meta property="og:description" content="WMS untuk seller marketplace. Dari pesanan masuk sampai paket di tangan kurir, semuanya tercatat jelas dan dicek scan.">
    <meta property="og:image" content="{{ $img('web-dashboard.webp') }}">
    <meta property="og:type" content="website">

    <link rel="icon" href="{{ asset('favicon-32x32.png') }}" type="image/png" sizes="32x32">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    {{-- Tanpa JavaScript, semua konten langsung tampil; animasi muncul hanya bila skrip jalan. --}}
    <script>document.documentElement.classList.add('js');</script>
    @vite(['resources/css/landing.css', 'resources/js/landing.js'])
</head>
<body class="bg-[#FBF8EF] font-sans text-[16px] leading-relaxed text-night antialiased">

{{-- Bilah kemajuan baca di paling atas, seperti penanda slide presentasi. --}}
<div class="fixed inset-x-0 top-0 z-50 h-[3px]" aria-hidden="true"><div data-progress class="h-full w-0 bg-brand-500"></div></div>

{{-- ===================== Navigasi ===================== --}}
<header data-header class="lp-header sticky top-0 z-40 border-b border-transparent bg-[#FBF8EF]/85 backdrop-blur">
    <nav class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-4 px-4 sm:px-6" aria-label="Utama">
        <a href="{{ route('landing') }}" class="flex shrink-0 items-center" aria-label="Paketpas, ke halaman depan">
            <x-application-logo class="h-8 w-auto" />
        </a>
        <div class="hidden items-center gap-8 text-[15px] font-medium text-night/70 md:flex">
            <a href="#masalah" class="lp-link hover:text-night">Kenapa Paketpas</a>
            <a href="#presentasi" class="lp-link hover:text-night">Tur aplikasi</a>
            <a href="#fitur" class="lp-link hover:text-night">Fitur</a>
            <a href="#harga" class="lp-link hover:text-night">Harga</a>
            <a href="#tanya" class="lp-link hover:text-night">Tanya jawab</a>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('login') }}" class="hidden rounded-[10px] px-4 py-2.5 text-[15px] font-medium text-night/80 hover:bg-night/5 hover:text-night sm:inline-flex">Masuk</a>
            <a href="{{ $contactUrl }}" {!! $ctaAttributes !!} class="lp-btn inline-flex items-center gap-2 rounded-[10px] bg-night px-4 py-2.5 text-[15px] font-semibold text-white hover:bg-black">
                Coba Paketpas
            </a>
        </div>
    </nav>
</header>

<main>

{{-- ===================== Hero ===================== --}}
<section class="relative overflow-hidden">
    <div class="lp-blob pointer-events-none absolute -left-32 top-24 h-80 w-80 rounded-full bg-brand-200/50 blur-3xl" aria-hidden="true"></div>
    <div class="relative mx-auto max-w-6xl px-4 pt-14 text-center sm:px-6 lg:pt-20">
        <p data-reveal class="inline-flex items-center gap-2 rounded-full border border-night/10 bg-white px-3 py-1 text-[13px] font-medium text-night/70">
            <span class="lp-ping relative flex h-2 w-2"><span class="absolute inline-flex h-full w-full rounded-full bg-brand-400"></span><span class="relative inline-flex h-2 w-2 rounded-full bg-brand-500"></span></span>
            WMS untuk seller marketplace · web &amp; Android
        </p>
        <h1 class="mx-auto mt-6 max-w-4xl font-display text-[40px] font-bold leading-[1.08] tracking-[-0.03em] sm:text-[64px]">
            <span data-reveal style="--d: 80ms" class="inline-block">Paket keluar pas.</span>
            <span data-reveal style="--d: 200ms" class="inline-block">Stok tercatat jelas.</span>
            <span data-reveal style="--d: 320ms" class="relative inline-block">
                <span class="relative z-10">Bisnis naik kelas.</span>
                <span class="lp-highlight absolute inset-x-0 bottom-1 z-0 h-4 rounded-sm bg-brand-400/70 sm:bottom-2" aria-hidden="true"></span>
            </span>
        </h1>
        <p data-reveal style="--d: 440ms" class="mx-auto mt-6 max-w-2xl text-[18px] text-night/70">
            Paketpas merapikan gudang online shop kamu, dari pesanan masuk, packing yang dicek dengan scan,
            sampai paket diserahkan ke kurir. Kerja tim jadi tangkas, kamu pun lepas dari rasa cemas.
        </p>
        <div data-reveal style="--d: 560ms" class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ $contactUrl }}" {!! $ctaAttributes !!} class="lp-btn group inline-flex items-center justify-center gap-2 rounded-[12px] bg-night px-6 py-3.5 text-[16px] font-semibold text-white hover:bg-black">
                {{ $contactName ? 'Minta demo via WhatsApp' : 'Lihat demo untuk toko saya' }} <span class="transition-transform group-hover:translate-x-1">{!! $icon('arrow', 'h-4 w-4') !!}</span>
            </a>
            <a href="#presentasi" class="lp-btn inline-flex items-center justify-center rounded-[12px] border border-night/15 bg-white px-6 py-3.5 text-[16px] font-semibold text-night hover:border-night/30">
                Ikuti tur aplikasinya
            </a>
        </div>

        {{-- Panggung hero: layar web asli + HP asli --}}
        <div data-reveal="zoom" style="--d: 300ms" class="relative mx-auto mt-14 max-w-5xl pb-12 sm:pb-24">
            <div class="lp-blob lp-blob--slow absolute -right-10 top-10 h-72 w-72 rounded-full bg-brand-300/40 blur-3xl" aria-hidden="true"></div>
            <figure class="lp-browser relative mx-auto sm:mr-[110px] lg:mr-[150px]">
                <div class="lp-browser-bar"><span></span><span></span><span></span><em>paketpas.id/admin</em></div>
                <img src="{{ $img('web-dashboard.webp') }}" width="1600" height="1000" alt="Beranda panel web Paketpas: ringkasan stok, pesanan belum QC, dan pergerakan stok terbaru" class="block w-full">
            </figure>
            <figure class="lp-phone lp-float absolute bottom-0 right-0 w-[24%] max-w-[220px] sm:w-[25%]">
                <img src="{{ $img('app-beranda.webp') }}" width="540" height="1200" alt="Aplikasi Android Paketpas Scan: beranda dengan target kirim hari ini">
            </figure>
        </div>
    </div>
</section>

{{-- ===================== Pita berjalan ===================== --}}
<div class="overflow-hidden border-y border-night/10 bg-night py-4 text-white" aria-hidden="true">
    <div class="lp-marquee flex w-max gap-10">
        @foreach ([1, 2] as $copy)
            @foreach ($ticker as $t)
                <span class="flex items-center gap-10 whitespace-nowrap font-display text-[18px] font-semibold">
                    {{ $t }} <span class="text-brand-400">{!! $icon('spark', 'h-4 w-4') !!}</span>
                </span>
            @endforeach
        @endforeach
    </div>
</div>

{{-- ===================== Masalah (empati) ===================== --}}
<section id="masalah" class="bg-white py-20 lg:py-28">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="max-w-2xl">
            <p data-reveal class="text-[14px] font-semibold uppercase tracking-[0.12em] text-brand-700">Sebelum kita mulai, kenal rasanya?</p>
            <h2 data-reveal style="--d: 100ms" class="mt-3 font-display text-[32px] font-bold leading-tight tracking-[-0.02em] sm:text-[40px]">
                Jualan makin deras, tapi gudang bikin cemas.
            </h2>
            <p data-reveal style="--d: 200ms" class="mt-4 text-[17px] text-night/65">
                Di awal, semua masih bisa dicatat di kepala dan di spreadsheet. Begitu pesanan naik, celah-celah kecil mulai terasa jelas.
            </p>
        </div>

        <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ([
                ['Jam sembilan malam, resi belum tuntas', 'Satu per satu dicentang di kertas, sambil berharap tidak ada yang terlewat sebelum kurir datang besok pagi.'],
                ['“Kak, warnanya kok beda?” Bikin lemas', 'Satu barang salah ambil berujung retur, ongkir hangus, dan bintang yang turun. Padahal timnya sudah teliti.'],
                ['Di toko masih ada, di rak sudah lepas', 'Pesanan masuk untuk barang yang ternyata kosong. Ujung-ujungnya dibatalkan dan reputasi toko ikut kena.'],
                ['Paket hilang, buktinya tidak jelas', 'Kurir bilang sudah diambil semua, gudang bilang sudah diserahkan semua. Tidak ada catatan yang bisa dicocokkan.'],
                ['Retur menumpuk, tak kunjung beres', 'Mana yang sudah dicek, mana yang rusak, mana yang bisa dijual lagi, tidak ada yang benar-benar tahu.'],
                ['Semua harus tanya ke kamu, tak pernah bebas', 'Stok berapa, pesanan mana yang telat, siapa yang packing tadi. Kamu jadi tidak bisa jauh dari gudang.'],
            ] as $i => [$title, $body])
                <div data-reveal style="--d: {{ ($i % 3) * 100 }}ms" class="lp-card rounded-[16px] border border-night/10 bg-[#FBF8EF] p-6">
                    <h3 class="font-display text-[18px] font-semibold leading-snug">{{ $title }}</h3>
                    <p class="mt-2 text-[15px] text-night/65">{{ $body }}</p>
                </div>
            @endforeach
        </div>

        <div data-reveal="zoom" class="relative mt-12 overflow-hidden rounded-[20px] bg-night p-8 text-white sm:p-10">
            <div class="lp-blob absolute -right-16 -top-16 h-56 w-56 rounded-full bg-brand-500/20 blur-3xl" aria-hidden="true"></div>
            <div class="relative grid items-center gap-6 lg:grid-cols-[1fr_auto]">
                <p class="font-display text-[22px] font-semibold leading-snug sm:text-[26px]">
                    Ini bukan karena timmu kurang cerdas.<br class="hidden sm:block">
                    <span class="text-brand-400">Gudang yang tumbuh cepat butuh sistem yang tegas, bukan begadang tanpa batas.</span>
                </p>
                <a href="#presentasi" class="lp-btn group inline-flex items-center justify-center gap-2 rounded-[12px] bg-brand-500 px-6 py-3.5 font-semibold text-night hover:bg-brand-400">
                    Lihat Paketpas bekerja <span class="transition-transform group-hover:translate-x-1">{!! $icon('arrow', 'h-4 w-4') !!}</span>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ===================== Presentasi: tur aplikasi per babak ===================== --}}
<section id="presentasi" class="relative py-20 lg:py-28">
    {{-- Penunjuk babak di sisi kiri (layar lebar), aktif mengikuti babak yang sedang dibaca. --}}
    <nav class="lp-chapters pointer-events-auto fixed left-6 top-1/2 z-30 hidden -translate-y-1/2 flex-col gap-3 2xl:flex" aria-label="Babak tur aplikasi" data-chapter-nav>
        @foreach ($chapters as $c)
            <a href="#{{ $c['id'] }}" data-chapter-link="{{ $c['id'] }}" class="group flex items-center gap-3 text-[13px] font-semibold text-night/35 hover:text-night">
                <span class="lp-chapter-dot h-2 w-2 rounded-full bg-night/20 transition-all"></span>
                <span class="opacity-0 transition-opacity group-hover:opacity-100">{{ $c['no'] }} · {{ $c['tag'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="mx-auto max-w-2xl text-center">
            <p data-reveal class="text-[14px] font-semibold uppercase tracking-[0.12em] text-brand-700">Tur aplikasi · 6 babak</p>
            <h2 data-reveal style="--d: 100ms" class="mt-3 font-display text-[32px] font-bold leading-tight tracking-[-0.02em] sm:text-[44px]">
                Izinkan Paketpas memperkenalkan diri, satu babak demi satu babak yang jelas.
            </h2>
            <p data-reveal style="--d: 200ms" class="mt-4 text-[17px] text-night/65">
                Semua gambar di bawah ini adalah layar asli Paketpas, versi web dan aplikasi Android, diisi data contoh.
                Ikuti perjalanan satu pesanan dari masuk sampai jadi laporan.
            </p>
        </div>

        <div class="mt-16 space-y-28 lg:mt-24 lg:space-y-36">
            @foreach ($chapters as $i => $c)
                @php $flip = $i % 2 === 1; @endphp
                <article id="{{ $c['id'] }}" data-chapter="{{ $c['id'] }}" class="grid items-center gap-10 lg:grid-cols-12 lg:gap-14">
                    {{-- Teks babak --}}
                    <div class="lg:col-span-5 {{ $flip ? 'lg:order-2' : '' }}">
                        <div data-reveal class="flex items-center gap-3">
                            <span class="font-display text-[56px] font-bold leading-none text-brand-500">{{ $c['no'] }}</span>
                            <span class="rounded-full bg-night px-3 py-1 text-[12px] font-semibold uppercase tracking-[0.1em] text-white">{{ $c['tag'] }}</span>
                        </div>
                        <h3 data-reveal style="--d: 100ms" class="mt-5 font-display text-[28px] font-bold leading-tight tracking-[-0.02em] sm:text-[36px]">{{ $c['title'] }}</h3>
                        <p data-reveal style="--d: 200ms" class="mt-4 text-[17px] text-night/65">{{ $c['lead'] }}</p>
                        <ul class="mt-6 space-y-3">
                            @foreach ($c['points'] as $k => $pt)
                                <li data-reveal style="--d: {{ 280 + $k * 90 }}ms" class="flex gap-3 text-[15px]">
                                    <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-brand-100 text-brand-800">{!! $icon('check', 'h-4 w-4') !!}</span>
                                    {{ $pt }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Panggung screenshot --}}
                    <div class="relative lg:col-span-7 {{ $flip ? 'lg:order-1' : '' }}">
                        <div class="lp-blob absolute {{ $flip ? '-left-10' : '-right-10' }} top-6 h-64 w-64 rounded-full bg-brand-300/30 blur-3xl" aria-hidden="true"></div>

                        @if ($c['web'])
                            @php
                                $overlay = $c['phones'][0] ?? null;
                                $gap = ($overlay || ! empty($c['web2'])) ? ($flip ? 'sm:ml-[110px]' : 'sm:mr-[110px]') : '';
                            @endphp
                            <p data-reveal class="mb-3 flex items-center gap-2 text-[13px] text-night/50 {{ $flip ? 'sm:justify-end' : '' }}">
                                <span class="h-1.5 w-1.5 rounded-full bg-brand-500"></span>{{ $c['web'][2] }}
                            </p>
                            <div class="relative sm:pb-16">
                                <figure data-reveal="{{ $flip ? 'left' : 'right' }}" style="--d: 150ms" class="lp-browser lp-tilt relative {{ $gap }}">
                                    <div class="lp-browser-bar"><span></span><span></span><span></span><em>{{ $c['web'][1] }}</em></div>
                                    <img src="{{ $img($c['web'][0]) }}" width="1600" height="1000" loading="lazy" alt="{{ $c['web'][2] }}" class="block w-full">
                                </figure>

                                @if ($overlay)
                                    <figure data-reveal="zoom" style="--d: 400ms" class="lp-phone lp-float mx-auto mt-6 w-[46%] max-w-[200px] sm:absolute sm:bottom-0 sm:mt-0 sm:w-[160px] {{ $flip ? 'sm:left-0' : 'sm:right-0' }}">
                                        <img src="{{ $img($overlay[0]) }}" width="540" height="1200" loading="lazy" alt="{{ $overlay[1] }}">
                                    </figure>
                                @elseif (! empty($c['web2']))
                                    <figure data-reveal="zoom" style="--d: 400ms" class="lp-browser lp-float absolute bottom-0 hidden w-[46%] sm:block {{ $flip ? 'sm:left-0' : 'sm:right-0' }}">
                                        <div class="lp-browser-bar"><span></span><span></span><span></span></div>
                                        <img src="{{ $img($c['web2'][0]) }}" width="1600" height="1000" loading="lazy" alt="{{ $c['web2'][1] }}" class="block w-full">
                                    </figure>
                                @endif
                            </div>
                        @elseif (! $c['web'])
                            {{-- Babak khusus Android: tiga HP berjajar --}}
                            <div class="flex items-end justify-center gap-3 sm:gap-6">
                                @foreach ($c['phones'] as $k => [$file, $alt])
                                    <figure data-reveal="zoom" style="--d: {{ 120 + $k * 150 }}ms" class="lp-phone {{ $k === 1 ? 'lp-float w-[36%] max-w-[240px]' : 'lp-float lp-float--alt w-[30%] max-w-[200px] mb-8' }}">
                                        <img src="{{ $img($file) }}" width="540" height="1200" loading="lazy" alt="{{ $alt }}">
                                        <figcaption class="sr-only">{{ $alt }}</figcaption>
                                    </figure>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ===================== Sebelum dan sesudah ===================== --}}
<section class="bg-white py-20 lg:py-28">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="mx-auto max-w-2xl text-center">
            <p data-reveal class="text-[14px] font-semibold uppercase tracking-[0.12em] text-brand-700">Rangkuman tur</p>
            <h2 data-reveal style="--d: 100ms" class="mt-3 font-display text-[32px] font-bold leading-tight tracking-[-0.02em] sm:text-[40px]">Dari serba was-was, jadi serba jelas.</h2>
        </div>
        <div class="mt-12 grid gap-5 lg:grid-cols-2">
            <div data-reveal="left" class="rounded-[18px] border border-night/10 bg-[#FBF8EF] p-7">
                <p class="text-[14px] font-semibold text-night/50">Tanpa sistem: serba was-was</p>
                <ul class="mt-4 space-y-3 text-[15px] text-night/70">
                    @foreach ([
                        'Mencocokkan resi dengan mata dan centang di kertas',
                        'Salah kirim baru ketahuan setelah pembeli komplain',
                        'Stok dihitung ulang tiap minggu dan hasilnya selalu beda',
                        'Bukti serah terima hanya ingatan masing-masing',
                        'Laporan disusun manual di akhir bulan',
                    ] as $line)
                        <li class="flex gap-3"><span class="mt-2.5 h-1.5 w-1.5 shrink-0 rounded-full bg-night/30"></span>{{ $line }}</li>
                    @endforeach
                </ul>
            </div>
            <div data-reveal="right" class="rounded-[18px] bg-night p-7 text-white">
                <p class="text-[14px] font-semibold text-brand-400">Dengan Paketpas: semua jelas</p>
                <ul class="mt-4 space-y-3 text-[15px] text-white/85">
                    @foreach ([
                        'Resi dan barang dicocokkan otomatis lewat scan',
                        'Salah ambil tertahan di meja packing, bukan di rumah pembeli',
                        'Stok bergerak setiap kali barang masuk, keluar, atau retur',
                        'Setiap paket yang diambil kurir punya catatan scan',
                        'Ringkasan bisnis bisa dilihat kapan saja',
                    ] as $i => $line)
                        <li data-reveal style="--d: {{ 200 + $i * 110 }}ms" class="flex gap-3"><span class="mt-0.5 text-brand-400">{!! $icon('check', 'h-5 w-5') !!}</span>{{ $line }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ===================== Fitur pendukung ===================== --}}
<section id="fitur" class="py-20 lg:py-28">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="max-w-2xl">
            <p data-reveal class="text-[14px] font-semibold uppercase tracking-[0.12em] text-brand-700">Dan masih ada lagi</p>
            <h2 data-reveal style="--d: 100ms" class="mt-3 font-display text-[32px] font-bold leading-tight tracking-[-0.02em] sm:text-[40px]">
                Toko makin luas, sistem tetap pas.
            </h2>
            <p data-reveal style="--d: 200ms" class="mt-4 text-[17px] text-night/65">
                Saat toko naik kelas, fitur pendukungnya sudah siap, tanpa perlu pindah sistem atau mulai dari awal lagi.
            </p>
        </div>

        <div class="mt-12 grid gap-x-8 gap-y-10 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ([
                ['return', 'Retur beres tuntas', 'Paket retur di-scan saat kembali, kondisinya dicatat, dan barang yang layak jual kembali ke stok.'],
                ['clipboard', 'Stok opname cepat dan jelas', 'Hitung fisik rak dengan scan, bandingkan dengan catatan, dan selisihnya langsung terlihat.'],
                ['calendar', 'Pre-order tanpa was-was', 'Pesanan PO dipantau tenggat kirimnya, jadi tidak ada yang telat karena terlupa.'],
                ['qr', 'Label QR serba praktis', 'Cetak label QR tiap barang, siap untuk printer thermal maupun kertas A4.'],
                ['user', 'Absensi karyawan rapi dan jelas', 'Absen dengan selfie dan lokasi, lengkap dengan izin, cuti, dan rekap kehadiran.'],
                ['shield', 'Hak akses yang tegas', 'Atur siapa boleh melakukan apa. Koreksi stok bisa dibuat perlu persetujuan dulu.'],
            ] as $i => [$ic, $title, $body])
                <div data-reveal style="--d: {{ ($i % 3) * 100 }}ms" class="lp-feature group">
                    <span class="lp-icon flex h-11 w-11 items-center justify-center rounded-[12px] bg-brand-100 text-brand-800 transition-colors group-hover:bg-night group-hover:text-brand-400">{!! $icon($ic, 'h-5 w-5') !!}</span>
                    <h3 class="mt-4 font-display text-[18px] font-semibold">{{ $title }}</h3>
                    <p class="mt-2 text-[15px] text-night/65">{{ $body }}</p>
                </div>
            @endforeach
        </div>

        <div data-reveal class="mt-14 flex items-center gap-4 rounded-[18px] border border-night/10 bg-white p-6">
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-[12px] bg-night text-brand-400">{!! $icon('plug', 'h-5 w-5') !!}</span>
            <p class="text-[15px] text-night/75"><span class="font-semibold text-night">Punya sistem lain? Tetap bisa terhubung bebas.</span> Data stok Paketpas bisa dibaca lewat API, aman dengan token dan daftar IP yang diizinkan.</p>
        </div>
    </div>
</section>

{{-- ===================== Harga ===================== --}}
@if ($pricing)
@php [$rent, $setup, $buy] = [$pricing['rent'], $pricing['setup'], $pricing['buy']]; @endphp
<section id="harga" class="relative overflow-hidden bg-white py-20 lg:py-28">
    <div class="lp-blob pointer-events-none absolute -right-24 top-20 h-80 w-80 rounded-full bg-brand-200/40 blur-3xl" aria-hidden="true"></div>
    <div class="relative mx-auto max-w-6xl px-4 sm:px-6">
        <div class="mx-auto max-w-2xl text-center">
            <p data-reveal class="text-[14px] font-semibold uppercase tracking-[0.12em] text-brand-700">Investasi</p>
            <h2 data-reveal style="--d: 100ms" class="mt-3 font-display text-[32px] font-bold leading-tight tracking-[-0.02em] sm:text-[44px]">
                Harga jelas, tanpa biaya tersembunyi yang bikin <span class="whitespace-nowrap">was-was.</span>
            </h2>
            <p data-reveal style="--d: 200ms" class="mt-4 text-[17px] text-night/65">
                Coba ingat bulan lalu: berapa paket yang salah kirim? Ongkir balik, barang yang tertahan, dan bintang yang turun
                sering kali sudah lebih mahal dari sewa sebulan. Sewanya pun lebih ringan dari gaji satu admin tambahan, dan tidak kenal lembur.
            </p>
        </div>

        <div class="mt-14 grid items-stretch gap-5 lg:grid-cols-3">
            {{-- Sewa --}}
            <div data-reveal style="--d: 0ms" class="lp-card relative flex flex-col rounded-[22px] border border-night/10 bg-[#FBF8EF] p-7">
                <span class="absolute -top-3 left-7 rounded-full bg-brand-500 px-3 py-1 text-[12px] font-semibold text-night">Paling fleksibel</span>
                <h3 class="font-display text-[22px] font-bold">{{ $rent['name'] }}</h3>
                <p class="mt-1 text-[14px] text-night/60">{{ $rent['tagline'] }}</p>
                <p class="mt-6 flex items-baseline gap-2"><span class="font-display text-[40px] font-bold tracking-[-0.02em]">{{ $rent['price'] }}</span><span class="text-[15px] text-night/55">{{ $rent['period'] }}</span></p>
                <p class="mt-1 text-[13px] text-night/60">{{ $rent['note'] }}</p>
                <ul class="mt-6 flex-1 space-y-3 text-[15px]">
                    @foreach ($rent['features'] as $f)
                        <li class="flex gap-3"><span class="mt-0.5 text-brand-600">{!! $icon('check', 'h-5 w-5') !!}</span>{{ $f }}</li>
                    @endforeach
                </ul>
                <a href="{{ $planUrl($rent['wa'] ?? null) }}" {!! $ctaAttributes !!} class="lp-btn mt-8 inline-flex items-center justify-center gap-2 rounded-[12px] bg-night px-6 py-3.5 font-semibold text-white hover:bg-black">
                    Tanya paket {{ $rent['name'] }} {!! $icon('arrow', 'h-4 w-4') !!}
                </a>
            </div>

            {{-- Implementasi & kustomisasi (biaya awal paket sewa) --}}
            <div data-reveal style="--d: 120ms" class="lp-card relative flex flex-col rounded-[22px] border border-dashed border-night/20 bg-white p-7">
                <span class="absolute -left-4 top-1/2 hidden h-8 w-8 -translate-y-1/2 items-center justify-center rounded-full bg-night text-brand-400 lg:flex" aria-hidden="true">{!! $icon('plus', 'h-4 w-4') !!}</span>
                <h3 class="font-display text-[22px] font-bold">{{ $setup['name'] }}</h3>
                <p class="mt-1 text-[14px] text-night/60">{{ $setup['tagline'] }}</p>
                <p class="mt-6 flex items-baseline gap-2"><span class="font-display text-[40px] font-bold tracking-[-0.02em]">{{ $setup['price'] }}</span><span class="text-[15px] text-night/55">{{ $setup['period'] }}</span></p>
                <p class="mt-1 inline-flex items-center gap-1.5 text-[13px] text-night/60"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Online, tidak perlu datang ke gudang</p>
                <ul class="mt-6 flex-1 space-y-3 text-[15px]">
                    @foreach ($setup['features'] as $f)
                        <li class="flex gap-3"><span class="mt-0.5 text-brand-600">{!! $icon('check', 'h-5 w-5') !!}</span>{{ $f }}</li>
                    @endforeach
                </ul>
                <p class="mt-8 rounded-[12px] bg-[#FBF8EF] px-4 py-3 text-[13px] text-night/65">Supaya Paketpas pas dengan cara kerja gudangmu sejak hari pertama, bukan gudangmu yang dipaksa menyesuaikan.</p>
            </div>

            {{-- Beli putus --}}
            <div data-reveal style="--d: 240ms" class="lp-card relative flex flex-col rounded-[22px] bg-night p-7 text-white">
                <span class="absolute -top-3 left-7 rounded-full bg-white px-3 py-1 text-[12px] font-semibold text-night">Jangka panjang</span>
                <h3 class="font-display text-[22px] font-bold">{{ $buy['name'] }}</h3>
                <p class="mt-1 text-[14px] text-white/60">{{ $buy['tagline'] }}</p>
                <p class="mt-6 flex items-baseline gap-2"><span class="font-display text-[40px] font-bold tracking-[-0.02em] text-brand-400">{{ $buy['price'] }}</span><span class="text-[15px] text-white/55">{{ $buy['period'] }}</span></p>
                <p class="mt-1 text-[13px] text-white/60">{{ $buy['note'] }}</p>
                <ul class="mt-6 flex-1 space-y-3 text-[15px] text-white/85">
                    @foreach ($buy['features'] as $f)
                        <li class="flex gap-3"><span class="mt-0.5 text-brand-400">{!! $icon('check', 'h-5 w-5') !!}</span>{{ $f }}</li>
                    @endforeach
                </ul>
                <a href="{{ $planUrl($buy['wa'] ?? null) }}" {!! $ctaAttributes !!} class="lp-btn mt-8 inline-flex items-center justify-center gap-2 rounded-[12px] bg-brand-500 px-6 py-3.5 font-semibold text-night hover:bg-brand-400">
                    Tanya paket {{ $buy['name'] }} {!! $icon('arrow', 'h-4 w-4') !!}
                </a>
            </div>
        </div>

        <p data-reveal class="mt-8 text-center text-[14px] text-night/55">Belum yakin paket mana yang pas? Ceritakan kondisi gudangmu, kami bantu hitung yang paling masuk akal.</p>
    </div>
</section>
@endif

{{-- ===================== Tanya jawab ===================== --}}
<section id="tanya" class="bg-white py-20 lg:py-28">
    <div class="mx-auto max-w-3xl px-4 sm:px-6">
        <p data-reveal class="text-center text-[14px] font-semibold uppercase tracking-[0.12em] text-brand-700">Sesi tanya jawab</p>
        <h2 data-reveal style="--d: 100ms" class="mt-3 text-center font-display text-[32px] font-bold leading-tight tracking-[-0.02em] sm:text-[40px]">Yang sering ditanyakan, kami jawab tuntas.</h2>

        <div class="mt-10 divide-y divide-night/10 border-y border-night/10">
            @foreach ([
                ['Paketpas cocok untuk toko seperti apa?', 'Untuk seller marketplace yang punya gudang atau ruang stok sendiri dan mulai merasa kewalahan mengurus packing, pengiriman, dan stok. Baik tim gudang dua orang maupun puluhan orang.'],
                ['Marketplace apa saja yang didukung?', 'Import otomatis membaca file pesanan TikTok Shop dan Shopee, cukup unggah file eksportnya dan Paketpas mengenali sendiri asalnya. Penjualan dari marketplace lain seperti Tokopedia atau Lazada tetap bisa dicatat sebagai penjualan manual, jadi stoknya tetap satu.'],
                ['Apakah harus membeli alat scanner?', 'Tidak harus. Aplikasi Android Paketpas Scan memakai kamera HP sebagai pemindai. Kalau kamu sudah punya scanner barcode, itu juga bisa dipakai di versi web.'],
                ['Tim gudang saya tidak terlalu paham teknologi. Bisa?', 'Bisa. Alurnya dibuat sederhana: scan, lihat tanda cocok atau tidak, lanjut. Layar aplikasinya besar dan jelas supaya nyaman dipakai sambil bekerja.'],
                ['Bagaimana dengan data stok yang sudah ada?', 'Data barang bisa diimpor dari Excel, lalu stok awal dicatat lewat penerimaan barang atau stok opname. Setelah itu stok bergerak sendiri mengikuti aktivitas gudang.'],
                ['Apakah implementasinya harus datang ke gudang?', 'Tidak. Implementasi dan kustomisasi dikerjakan jarak jauh: analisis alur lewat panggilan video, penyesuaian sistem dari tempat kami, dan pelatihan tim secara online.'],
                ['Bagaimana cara mulai?', 'Hubungi kami lewat tombol di halaman ini. Kami bantu lihat alur gudang kamu sekarang dan tunjukkan bagaimana Paketpas bisa dipakai di sana.'],
            ] as $i => [$q, $a])
                <details data-reveal style="--d: {{ $i * 60 }}ms" class="lp-faq group py-5">
                    <summary class="flex cursor-pointer items-center justify-between gap-4 text-left font-display text-[17px] font-semibold">
                        {{ $q }}
                        <span class="shrink-0 text-night/40 transition-transform duration-300 group-open:rotate-45">{!! $icon('plus', 'h-5 w-5') !!}</span>
                    </summary>
                    <p class="lp-faq-body mt-3 text-[15px] text-night/65">{{ $a }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

{{-- ===================== Ajakan penutup ===================== --}}
<section class="px-4 py-20 sm:px-6 lg:py-28">
    <div data-reveal="zoom" class="relative mx-auto max-w-5xl overflow-hidden rounded-[28px] bg-night px-6 py-14 text-center text-white sm:px-12 sm:py-20">
        <div class="lp-blob absolute -right-20 -top-20 h-72 w-72 rounded-full bg-brand-500/25 blur-3xl" aria-hidden="true"></div>
        <div class="lp-blob lp-blob--slow absolute -bottom-24 -left-16 h-72 w-72 rounded-full bg-brand-500/10 blur-3xl" aria-hidden="true"></div>
        <div class="relative">
            <p class="text-[14px] font-semibold uppercase tracking-[0.12em] text-brand-400">Penutup presentasi</p>
            <h2 class="mx-auto mt-4 max-w-2xl font-display text-[30px] font-bold leading-tight tracking-[-0.02em] sm:text-[44px]">
                Paket pas, pembeli puas,<br>
                <span class="text-brand-400">bisnis naik kelas.</span>
            </h2>
            <p class="mx-auto mt-4 max-w-xl text-[17px] text-white/70">
                Mulai dari ngobrol santai soal gudang kamu sekarang, tanpa kewajiban apa pun, supaya langkah berikutnya terasa jelas.
            </p>
            @if ($contactName)
                <p class="mx-auto mt-6 inline-flex items-center gap-3 rounded-full bg-white/5 py-1.5 pl-1.5 pr-4 text-[14px] text-white/80 ring-1 ring-white/10">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brand-500 font-display text-[13px] font-bold text-night">{{ \Illuminate\Support\Str::of($contactName)->explode(' ')->map(fn ($w) => mb_substr($w, 0, 1))->take(2)->implode('') }}</span>
                    Ngobrol langsung via WhatsApp dengan <span class="font-semibold text-white">{{ $contactName }}</span>
                </p>
            @endif
            <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                <a href="{{ $contactUrl }}" {!! $ctaAttributes !!} class="lp-btn lp-glow group inline-flex items-center justify-center gap-2 rounded-[12px] bg-brand-500 px-7 py-4 text-[16px] font-semibold text-night hover:bg-brand-400">
                    {{ $contactName ? 'Chat via WhatsApp' : 'Lihat demo untuk toko saya' }} <span class="transition-transform group-hover:translate-x-1">{!! $icon('arrow', 'h-4 w-4') !!}</span>
                </a>
                <a href="{{ route('login') }}" class="lp-btn inline-flex items-center justify-center rounded-[12px] border border-white/20 px-7 py-4 text-[16px] font-semibold text-white hover:bg-white/10">
                    Sudah punya akun? Masuk
                </a>
            </div>
        </div>
    </div>
</section>

</main>

{{-- ===================== Footer ===================== --}}
<footer class="border-t border-night/10">
    <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 px-4 py-8 text-[14px] text-night/55 sm:flex-row sm:px-6">
        <div class="flex items-center gap-3">
            <x-application-logo variant="mark" class="h-7 w-auto" />
            <span>&copy; {{ date('Y') }} Paketpas · Paket pas, pembeli puas</span>
        </div>
        <div class="flex gap-6">
            <a href="#presentasi" class="hover:text-night">Tur aplikasi</a>
            <a href="{{ route('app.download-page') }}" class="hover:text-night">Aplikasi Android</a>
            <a href="{{ route('login') }}" class="hover:text-night">Masuk</a>
        </div>
    </div>
</footer>

</body>
</html>

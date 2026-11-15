@php
    // Ikon garis sederhana (24×24, stroke). Dipakai di kartu fitur dan langkah alur.
    $icons = [
        'upload' => '<path d="M12 15V4m0 0-4 4m4-4 4 4"/><path d="M4 15v3a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-3"/>',
        'scan' => '<path d="M4 8V6a2 2 0 0 1 2-2h2M16 4h2a2 2 0 0 1 2 2v2M20 16v2a2 2 0 0 1-2 2h-2M8 20H6a2 2 0 0 1-2-2v-2"/><path d="M7 12h10"/>',
        'truck' => '<path d="M3 6h11v10H3z"/><path d="M14 9h4l3 3v4h-7"/><circle cx="7" cy="18" r="1.8"/><circle cx="17" cy="18" r="1.8"/>',
        'return' => '<path d="M9 14 4 9l5-5"/><path d="M4 9h10.5a5.5 5.5 0 0 1 0 11H11"/>',
        'box' => '<path d="m21 8-9-5-9 5 9 5 9-5Z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/>',
        'clipboard' => '<rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4V3h6v1"/><path d="m9 13 2 2 4-4"/>',
        'trend' => '<path d="M3 17 9 11l4 4 8-8"/><path d="M15 7h6v6"/>',
        'calendar' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/>',
        'qr' => '<rect x="4" y="4" width="6" height="6" rx="1"/><rect x="14" y="4" width="6" height="6" rx="1"/><rect x="4" y="14" width="6" height="6" rx="1"/><path d="M14 14h2v2h-2zM18 18h2v2h-2zM14 18h2M18 14h2"/>',
        'phone' => '<rect x="7" y="2" width="10" height="20" rx="2"/><path d="M11 18h2"/>',
        'user' => '<circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/>',
        'shield' => '<path d="M12 3 4 6v6c0 5 3.5 8 8 9 4.5-1 8-4 8-9V6l-8-3Z"/><path d="m9 12 2 2 4-4"/>',
        'chart' => '<path d="M4 20V10M10 20V4M16 20v-7M22 20H2"/>',
        'plug' => '<path d="M9 2v6M15 2v6"/><path d="M6 8h12v4a6 6 0 0 1-12 0V8Z"/><path d="M12 18v4"/>',
        'check' => '<path d="m5 12 5 5L20 7"/>',
        'arrow' => '<path d="M5 12h14m-6-6 6 6-6 6"/>',
        'plus' => '<path d="M12 5v14M5 12h14"/>',
        'spark' => '<path d="M12 3v4M12 17v4M3 12h4M17 12h4M6 6l2.5 2.5M15.5 15.5 18 18M6 18l2.5-2.5M15.5 8.5 18 6"/>',
    ];
    $icon = fn (string $name, string $class = 'h-5 w-5') => '<svg class="'.$class.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.$icons[$name].'</svg>';

    $ctaAttributes = $contactIsExternal ? 'target="_blank" rel="noopener"' : '';

    // Pita berjalan di bawah hero: janji-janji singkat berima "-as".
    $ticker = ['Resi tercatat jelas', 'Packing tanpa was-was', 'Stok selalu pas', 'Retur beres tuntas', 'Serah terima, bukti jelas', 'Laporan ringkas', 'Pembeli puas', 'Bisnis naik kelas'];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Paketpas — Paket pas, pembeli puas, bisnis naik kelas</title>
    <meta name="description" content="Paketpas adalah WMS untuk seller Shopee dan TikTok Shop: import pesanan, packing dengan scan, serah terima kurir, retur, dan stok dalam satu alur yang ringkas dan jelas.">
    <meta name="theme-color" content="#111827">

    <meta property="og:title" content="Paketpas — Paket pas, pembeli puas, bisnis naik kelas">
    <meta property="og:description" content="WMS untuk seller Shopee dan TikTok Shop. Dari pesanan masuk sampai paket di tangan kurir, semuanya tercatat jelas dan dicek scan.">
    <meta property="og:image" content="{{ asset('images/paketpas-icon-512.png') }}">
    <meta property="og:type" content="website">

    <link rel="icon" href="{{ asset('favicon-32x32.png') }}" type="image/png" sizes="32x32">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    {{-- Tanpa JavaScript, semua konten langsung tampil; animasi muncul hanya bila skrip jalan. --}}
    <script>document.documentElement.classList.add('js');</script>
    @vite(['resources/css/landing.css', 'resources/js/landing.js'])
</head>
<body class="bg-[#FBF8EF] font-sans text-[16px] leading-relaxed text-night antialiased">

{{-- ===================== Navigasi ===================== --}}
<header data-header class="lp-header sticky top-0 z-30 border-b border-transparent bg-[#FBF8EF]/85 backdrop-blur">
    <nav class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-4 px-4 sm:px-6" aria-label="Utama">
        <a href="{{ route('landing') }}" class="flex shrink-0 items-center" aria-label="Paketpas, ke halaman depan">
            <x-application-logo class="h-8 w-auto" />
        </a>
        <div class="hidden items-center gap-8 text-[15px] font-medium text-night/70 md:flex">
            <a href="#masalah" class="lp-link hover:text-night">Kenapa Paketpas</a>
            <a href="#alur" class="lp-link hover:text-night">Cara kerja</a>
            <a href="#fitur" class="lp-link hover:text-night">Fitur</a>
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
    <div class="mx-auto grid max-w-6xl items-center gap-14 px-4 pb-24 pt-14 sm:px-6 lg:grid-cols-[1.05fr_1fr] lg:pb-32 lg:pt-20">
        <div class="relative">
            <p data-reveal class="inline-flex items-center gap-2 rounded-full border border-night/10 bg-white px-3 py-1 text-[13px] font-medium text-night/70">
                <span class="lp-ping relative flex h-2 w-2"><span class="absolute inline-flex h-full w-full rounded-full bg-brand-400"></span><span class="relative inline-flex h-2 w-2 rounded-full bg-brand-500"></span></span>
                WMS untuk seller Shopee &amp; TikTok Shop
            </p>
            <h1 class="mt-6 font-display text-[40px] font-bold leading-[1.08] tracking-[-0.03em] sm:text-[56px]">
                <span data-reveal style="--d: 80ms" class="block">Paket keluar pas.</span>
                <span data-reveal style="--d: 200ms" class="block">Stok tercatat jelas.</span>
                <span data-reveal style="--d: 320ms" class="relative inline-block">
                    <span class="relative z-10">Bisnis naik kelas.</span>
                    <span class="lp-highlight absolute inset-x-0 bottom-1 z-0 h-4 rounded-sm bg-brand-400/70 sm:bottom-2" aria-hidden="true"></span>
                </span>
            </h1>
            <p data-reveal style="--d: 440ms" class="mt-6 max-w-xl text-[18px] text-night/70">
                Paketpas merapikan gudang online shop kamu, dari pesanan masuk, packing yang dicek dengan scan,
                sampai paket diserahkan ke kurir. Kerja tim jadi tangkas, kamu pun lepas dari rasa cemas.
            </p>
            <div data-reveal style="--d: 560ms" class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ $contactUrl }}" {!! $ctaAttributes !!} class="lp-btn group inline-flex items-center justify-center gap-2 rounded-[12px] bg-night px-6 py-3.5 text-[16px] font-semibold text-white hover:bg-black">
                    {{ $contactName ? 'Minta demo via WhatsApp' : 'Lihat demo untuk toko saya' }} <span class="transition-transform group-hover:translate-x-1">{!! $icon('arrow', 'h-4 w-4') !!}</span>
                </a>
                <a href="#alur" class="lp-btn inline-flex items-center justify-center rounded-[12px] border border-night/15 bg-white px-6 py-3.5 text-[16px] font-semibold text-night hover:border-night/30">
                    Lihat cara kerjanya
                </a>
            </div>
            <ul data-reveal style="--d: 680ms" class="mt-8 flex flex-wrap gap-x-6 gap-y-2 text-[14px] text-night/60">
                <li class="flex items-center gap-1.5">{!! $icon('check', 'h-4 w-4 text-brand-600') !!} Mulai dari Excel pesanan yang sudah ada</li>
                <li class="flex items-center gap-1.5">{!! $icon('check', 'h-4 w-4 text-brand-600') !!} Scan cukup dengan kamera HP</li>
            </ul>
        </div>

        {{-- Ilustrasi: kartu ringkasan hari ini + layar aplikasi scan. --}}
        <div data-reveal="zoom" style="--d: 250ms" class="relative mx-auto w-full max-w-[520px]" aria-hidden="true">
            <div class="lp-blob lp-blob--slow absolute -right-10 -top-10 h-64 w-64 rounded-full bg-brand-300/40 blur-3xl"></div>
            <div class="lp-float relative rounded-[20px] border border-night/10 bg-white p-5 shadow-[0_30px_60px_-20px_rgba(17,24,39,0.25)] sm:mr-20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[13px] text-night/50">Hari ini</p>
                        <p class="font-display text-[20px] font-semibold">Pesanan siap kirim</p>
                    </div>
                    <span class="lp-pulse rounded-full bg-emerald-50 px-2.5 py-1 text-[12px] font-semibold text-emerald-700">Semua tercatat</span>
                </div>
                <div class="mt-5 grid grid-cols-3 gap-3">
                    @foreach ([['Diimpor', 'Shopee', '+ TikTok Shop'], ['Dikemas', 'Scan', 'resi + barang'], ['Diserahkan', 'Kurir', 'per ekspedisi']] as $i => [$k, $v, $n])
                        <div data-reveal style="--d: {{ 450 + $i * 120 }}ms" class="rounded-[12px] bg-[#FBF8EF] p-3">
                            <p class="text-[12px] text-night/50">{{ $k }}</p>
                            <p class="mt-1 font-display text-[22px] font-bold">{{ $v }}</p>
                            <p class="text-[12px] text-night/50">{{ $n }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="mt-5 space-y-2.5 sm:pr-14">
                    <div data-reveal="left" style="--d: 800ms" class="flex items-center gap-3 rounded-[12px] border border-night/10 p-3">
                        <span class="lp-pop flex h-9 w-9 items-center justify-center rounded-[10px] bg-emerald-50 text-emerald-600" style="--pop: 1.3s">{!! $icon('check', 'h-5 w-5') !!}</span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-[14px] font-semibold">SPX · resi SPXID0…4821</p>
                            <p class="text-[12px] text-night/50">3 dari 3 barang cocok · siap serah terima</p>
                        </div>
                    </div>
                    <div data-reveal="left" style="--d: 950ms" class="lp-shake flex items-center gap-3 rounded-[12px] border border-rose-200 bg-rose-50/60 p-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-[10px] bg-rose-100 text-[18px] font-bold text-rose-600">!</span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-[14px] font-semibold">J&amp;T · resi JX0…1193</p>
                            <p class="text-[12px] text-rose-700">Tertahan: warna Hitam, bukan Navy</p>
                        </div>
                    </div>
                    <div data-reveal="left" style="--d: 1100ms" class="flex items-center gap-3 rounded-[12px] border border-night/10 p-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-[10px] bg-amber-50 text-amber-600">{!! $icon('box', 'h-5 w-5') !!}</span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-[14px] font-semibold">Stok menipis: Kaos Basic Navy L</p>
                            <p class="text-[12px] text-night/50">Masuk daftar kebutuhan restock</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Layar HP aplikasi scan --}}
            <div class="lp-float lp-float--alt absolute -bottom-16 -right-6 hidden w-[180px] rounded-[30px] border-[6px] border-night bg-night shadow-[0_25px_50px_-15px_rgba(17,24,39,0.45)] sm:block">
                <div class="overflow-hidden rounded-[24px] bg-white">
                    <div class="bg-night px-4 pb-4 pt-5 text-white">
                        <p class="text-[11px] text-white/60">Paketpas Scan</p>
                        <p class="font-display text-[15px] font-semibold">QC Kemas</p>
                    </div>
                    <div class="p-3">
                        <div class="relative h-24 overflow-hidden rounded-[14px] bg-night/90">
                            <span class="absolute inset-4 rounded-[8px] border-2 border-brand-400"></span>
                            <span class="lp-laser absolute left-6 right-6 top-6 h-0.5 bg-brand-400 shadow-[0_0_12px_2px_rgba(255,198,31,0.7)]"></span>
                        </div>
                        <div class="lp-pulse mt-3 rounded-[12px] bg-emerald-50 p-2.5 text-center">
                            <p class="text-[12px] font-bold text-emerald-700">Cocok ✓</p>
                            <p class="text-[11px] text-emerald-700/80">Barang <span data-count-loop="1,2,3">2</span> dari 3</p>
                        </div>
                        <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-night/10"><div class="lp-progress h-full rounded-full bg-brand-500"></div></div>
                    </div>
                </div>
            </div>
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
            <p data-reveal class="text-[14px] font-semibold uppercase tracking-[0.12em] text-brand-700">Kenal rasanya?</p>
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
                ['Di toko masih ada, di rak sudah habis tak berbekas', 'Pesanan masuk untuk barang yang ternyata kosong. Ujung-ujungnya dibatalkan dan reputasi toko ikut kena.'],
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
                <a href="#alur" class="lp-btn group inline-flex items-center justify-center gap-2 rounded-[12px] bg-brand-500 px-6 py-3.5 font-semibold text-night hover:bg-brand-400">
                    Cari jalan yang pas <span class="transition-transform group-hover:translate-x-1">{!! $icon('arrow', 'h-4 w-4') !!}</span>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ===================== Alur kerja ===================== --}}
<section id="alur" class="py-20 lg:py-28">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="max-w-2xl">
            <p data-reveal class="text-[14px] font-semibold uppercase tracking-[0.12em] text-brand-700">Cara kerja Paketpas</p>
            <h2 data-reveal style="--d: 100ms" class="mt-3 font-display text-[32px] font-bold leading-tight tracking-[-0.02em] sm:text-[40px]">
                Satu alur yang ringkas, setiap paket tercatat jelas.
            </h2>
            <p data-reveal style="--d: 200ms" class="mt-4 text-[17px] text-night/65">
                Tak perlu mengubah cara berjualan. Paketpas mulai dari file pesanan yang biasa kamu unduh dari marketplace, lalu semuanya bergerak sampai tuntas.
            </p>
        </div>

        <ol class="lp-steps relative mt-14 grid gap-5 md:grid-cols-2 lg:grid-cols-4">
            <span class="lp-steps-line pointer-events-none absolute left-6 right-6 top-[46px] hidden h-0.5 bg-brand-400 lg:block" aria-hidden="true"></span>
            @foreach ([
                ['upload', 'Import pesanan', 'Unggah file Excel pesanan dari Shopee atau TikTok Shop. Resi ganda langsung ketahuan dan pesanan yang batal ikut ditandai, jadi tidak ada yang terkirim percuma.'],
                ['scan', 'Packing dengan scan', 'Scan resi, lalu scan setiap barang yang dimasukkan. Kalau ada yang salah ambil, Paketpas langsung memberi tahu sebelum paket ditutup.'],
                ['truck', 'Serah terima ke kurir', 'Setiap paket di-scan saat diserahkan, dikelompokkan per ekspedisi. Ada catatan jelas berapa paket yang benar-benar diambil kurir hari itu.'],
                ['return', 'Retur tercatat', 'Paket retur di-scan saat kembali, kondisi barangnya dicatat, dan stok yang masih layak jual kembali ke rak dengan sendirinya.'],
            ] as $i => [$ic, $title, $body])
                <li data-reveal style="--d: {{ $i * 150 }}ms" class="lp-card relative rounded-[18px] border border-night/10 bg-white p-6">
                    <div class="flex items-center justify-between">
                        <span class="lp-icon flex h-11 w-11 items-center justify-center rounded-[12px] bg-night text-brand-400">{!! $icon($ic, 'h-5 w-5') !!}</span>
                        <span class="font-display text-[34px] font-bold text-night/10">0{{ $i + 1 }}</span>
                    </div>
                    <h3 class="mt-5 font-display text-[19px] font-semibold">{{ $title }}</h3>
                    <p class="mt-2 text-[15px] text-night/65">{{ $body }}</p>
                </li>
            @endforeach
        </ol>

        {{-- Sebelum dan sesudah --}}
        <div class="mt-16 grid gap-5 lg:grid-cols-2">
            <div data-reveal="left" class="rounded-[18px] border border-night/10 bg-white p-7">
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

{{-- ===================== Fitur ===================== --}}
<section id="fitur" class="bg-white py-20 lg:py-28">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="max-w-2xl">
            <p data-reveal class="text-[14px] font-semibold uppercase tracking-[0.12em] text-brand-700">Semua yang dibutuhkan gudang</p>
            <h2 data-reveal style="--d: 100ms" class="mt-3 font-display text-[32px] font-bold leading-tight tracking-[-0.02em] sm:text-[40px]">
                Toko makin luas, sistem tetap pas.
            </h2>
            <p data-reveal style="--d: 200ms" class="mt-4 text-[17px] text-night/65">
                Mulai dari yang paling terasa, yaitu packing dan pengiriman. Saat toko naik kelas, fitur lainnya sudah siap, tanpa perlu pindah sistem atau mulai dari awal lagi.
            </p>
        </div>

        <div class="mt-12 grid gap-x-8 gap-y-10 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ([
                ['box', 'Stok selalu pas', 'Barang masuk, keluar, retur, dan koreksi tercatat sebagai mutasi. Saldo stok bisa dilihat per barang kapan saja.'],
                ['clipboard', 'Stok opname cepat dan jelas', 'Hitung fisik rak dengan scan, lalu bandingkan dengan catatan. Selisih langsung terlihat dan bisa disesuaikan.'],
                ['trend', 'Restock tepat, tidak kebablasan', 'Paketpas membaca kecepatan jual tiap barang dan memberi tahu mana yang perlu segera dipesan ulang.'],
                ['calendar', 'Pre-order tanpa was-was', 'Pesanan PO dipantau tenggat kirimnya, jadi tidak ada pesanan yang telat karena terlupa.'],
                ['qr', 'Label QR serba praktis', 'Cetak label QR untuk setiap barang, siap untuk printer thermal maupun kertas A4.'],
                ['phone', 'Aplikasi Android, kerja makin tangkas', 'Tim gudang cukup memakai HP. Kamera jadi pemindai untuk packing, serah terima, dan cek pesanan.'],
                ['user', 'Absensi karyawan rapi dan jelas', 'Absen dengan selfie dan lokasi dari aplikasi yang sama, lengkap dengan izin, cuti, dan rekap kehadiran.'],
                ['shield', 'Hak akses yang tegas', 'Atur siapa boleh melakukan apa. Perubahan penting seperti koreksi stok bisa dibuat perlu persetujuan dulu.'],
                ['chart', 'Laporan ringkas untuk pemilik', 'Ringkasan bisnis, laporan penjualan, resi per hari, dan resi per ekspedisi, tanpa menyusun spreadsheet sendiri.'],
            ] as $i => [$ic, $title, $body])
                <div data-reveal style="--d: {{ ($i % 3) * 100 }}ms" class="lp-feature group">
                    <span class="lp-icon flex h-11 w-11 items-center justify-center rounded-[12px] bg-brand-100 text-brand-800 transition-colors group-hover:bg-night group-hover:text-brand-400">{!! $icon($ic, 'h-5 w-5') !!}</span>
                    <h3 class="mt-4 font-display text-[18px] font-semibold">{{ $title }}</h3>
                    <p class="mt-2 text-[15px] text-night/65">{{ $body }}</p>
                </div>
            @endforeach
        </div>

        <div data-reveal class="mt-14 flex flex-col items-start gap-4 rounded-[18px] border border-night/10 bg-[#FBF8EF] p-6 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-[12px] bg-night text-brand-400">{!! $icon('plug', 'h-5 w-5') !!}</span>
                <p class="text-[15px] text-night/75"><span class="font-semibold text-night">Punya sistem lain? Tetap bisa terhubung bebas.</span> Data stok Paketpas bisa dibaca lewat API, aman dengan token dan daftar IP yang diizinkan.</p>
            </div>
        </div>
    </div>
</section>

{{-- ===================== Untuk pemilik ===================== --}}
<section class="py-20 lg:py-28">
    <div class="mx-auto grid max-w-6xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-2">
        <div>
            <p data-reveal class="text-[14px] font-semibold uppercase tracking-[0.12em] text-brand-700">Untuk kamu, pemilik toko</p>
            <h2 data-reveal style="--d: 100ms" class="mt-3 font-display text-[32px] font-bold leading-tight tracking-[-0.02em] sm:text-[40px]">
                Gudang terpantau jelas, akhir pekan pun bebas.
            </h2>
            <p data-reveal style="--d: 200ms" class="mt-4 text-[17px] text-night/65">
                Bayangkan bisa membuka satu halaman dan langsung tahu berapa paket yang sudah keluar hari ini, barang apa yang hampir habis,
                dan pesanan mana yang perlu perhatian. Keputusan jadi lebih cepat, dan liburmu benar-benar lepas.
            </p>
            <ul class="mt-6 space-y-3 text-[15px]">
                @foreach ([
                    'Semua aktivitas tercatat siapa dan kapan',
                    'Tim baru cepat paham karena alurnya dipandu scan',
                    'Data tetap milikmu dan bisa diekspor ke Excel',
                ] as $i => $line)
                    <li data-reveal style="--d: {{ 300 + $i * 100 }}ms" class="flex gap-3"><span class="text-brand-600">{!! $icon('check', 'h-5 w-5') !!}</span>{{ $line }}</li>
                @endforeach
            </ul>
        </div>

        <div data-reveal="zoom" class="lp-chart rounded-[20px] border border-night/10 bg-white p-6 shadow-[0_30px_60px_-25px_rgba(17,24,39,0.25)]" aria-hidden="true">
            <div class="flex items-center justify-between">
                <p class="font-display text-[17px] font-semibold">Ringkasan bisnis</p>
                <span class="rounded-full bg-night/5 px-3 py-1 text-[12px] text-night/60">Minggu ini</span>
            </div>
            <div class="mt-6 flex h-40 items-end gap-3">
                @foreach ([45, 62, 55, 78, 70, 92, 84] as $h)
                    <div class="lp-bar flex-1 rounded-t-[6px] {{ $loop->last ? 'bg-brand-500' : 'bg-night/80' }}" style="height: {{ $h }}%; --d: {{ $loop->index * 90 }}ms"></div>
                @endforeach
            </div>
            <div class="mt-2 flex gap-3 text-center text-[11px] text-night/45">
                @foreach (['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $d)
                    <span class="flex-1">{{ $d }}</span>
                @endforeach
            </div>
            <div class="mt-6 grid grid-cols-2 gap-3">
                <div class="rounded-[12px] bg-[#FBF8EF] p-4">
                    <p class="text-[12px] text-night/50">Resi per ekspedisi</p>
                    <div class="mt-3 space-y-2">
                        @foreach ([['SPX', 'w-[80%]'], ['J&T', 'w-[55%]'], ['JNE', 'w-[35%]']] as [$c, $w])
                            <div class="flex items-center gap-2 text-[12px]"><span class="w-8 font-semibold">{{ $c }}</span><span class="lp-hbar h-2 {{ $w }} rounded-full bg-night/70" style="--d: {{ 500 + $loop->index * 120 }}ms"></span></div>
                        @endforeach
                    </div>
                </div>
                <div class="rounded-[12px] bg-[#FBF8EF] p-4">
                    <p class="text-[12px] text-night/50">Perlu restock</p>
                    <ul class="mt-3 space-y-1.5 text-[12px]">
                        <li class="flex justify-between"><span>Kaos Basic Navy L</span><span class="font-semibold text-rose-600">Habis</span></li>
                        <li class="flex justify-between"><span>Hoodie Abu M</span><span class="font-semibold text-amber-600">Menipis</span></li>
                        <li class="flex justify-between"><span>Tote Bag Krem</span><span class="font-semibold text-amber-600">Menipis</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===================== Tanya jawab ===================== --}}
<section id="tanya" class="bg-white py-20 lg:py-28">
    <div class="mx-auto max-w-3xl px-4 sm:px-6">
        <p data-reveal class="text-center text-[14px] font-semibold uppercase tracking-[0.12em] text-brand-700">Tanya jawab</p>
        <h2 data-reveal style="--d: 100ms" class="mt-3 text-center font-display text-[32px] font-bold leading-tight tracking-[-0.02em] sm:text-[40px]">Yang sering ditanyakan, kami jawab tuntas.</h2>

        <div class="mt-10 divide-y divide-night/10 border-y border-night/10">
            @foreach ([
                ['Paketpas cocok untuk toko seperti apa?', 'Untuk seller marketplace yang punya gudang atau ruang stok sendiri dan mulai merasa kewalahan mengurus packing, pengiriman, dan stok. Baik tim gudang dua orang maupun puluhan orang.'],
                ['Marketplace apa saja yang didukung?', 'Saat ini Paketpas membaca file pesanan dari Shopee dan TikTok Shop. Penjualan di luar marketplace juga bisa dicatat sebagai penjualan manual, jadi stoknya tetap satu.'],
                ['Apakah harus membeli alat scanner?', 'Tidak harus. Aplikasi Android Paketpas memakai kamera HP sebagai pemindai. Kalau kamu sudah punya scanner barcode, itu juga bisa dipakai di versi web.'],
                ['Tim gudang saya tidak terlalu paham teknologi. Bisa?', 'Bisa. Alurnya dibuat sederhana: scan, lihat tanda cocok atau tidak, lanjut. Layar aplikasinya besar dan jelas supaya nyaman dipakai sambil bekerja.'],
                ['Bagaimana dengan data stok yang sudah ada?', 'Data barang bisa diimpor dari Excel, lalu stok awal dicatat lewat penerimaan barang atau stok opname. Setelah itu stok bergerak sendiri mengikuti aktivitas gudang.'],
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
            <x-application-logo variant="mark" class="lp-bob mx-auto h-14 w-auto" />
            <h2 class="mx-auto mt-6 max-w-2xl font-display text-[30px] font-bold leading-tight tracking-[-0.02em] sm:text-[44px]">
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
            <a href="#fitur" class="hover:text-night">Fitur</a>
            <a href="{{ route('app.download-page') }}" class="hover:text-night">Aplikasi Android</a>
            <a href="{{ route('login') }}" class="hover:text-night">Masuk</a>
        </div>
    </div>
</footer>

</body>
</html>

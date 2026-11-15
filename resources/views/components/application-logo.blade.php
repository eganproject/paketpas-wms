@props(['variant' => 'horizontal'])
{{--
    Logo Paketpas.

    variant="horizontal" (bawaan): monogram P di samping tulisan, untuk navbar
    dan menu samping.
    variant="full": monogram di atas tulisan "Paketpas", untuk halaman masuk.
    variant="mark": monogram P saja.

    Berkasnya PNG berlatar transparan di public/images, sementara (placeholder) sampai logo resmi Paketpas tersedia.
    Tinggi diatur lewat class (mis. h-7); lebarnya mengikuti (w-auto).
--}}
@php
    $src = match ($variant) {
        'full' => 'images/paketpas-logo.png',
        'mark' => 'images/paketpas-mark.png',
        default => 'images/paketpas-horizontal.png',
    };
@endphp
<img src="{{ asset($src) }}" alt="{{ config('app.name', 'Paketpas') }}"
     {{ $attributes->merge(['class' => 'select-none']) }} draggable="false">

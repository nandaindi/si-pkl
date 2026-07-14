<!DOCTYPE html>
{{-- Mengatur bahasa dokumen HTML sesuai dengan locale (bahasa) yang dikonfigurasi di aplikasi Laravel --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    {{-- Menampilkan nama aplikasi dari file konfigurasi (config/app.php), atau defaultnya 'Sistem Informasi PKL' --}}
    <title>{{ config('app.name', 'Sistem Informasi PKL') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logosmk.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    {{-- @vite memanggil file CSS dan JS yang dikompilasi menggunakan Vite bundler bawaan Laravel --}}
    @vite (['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    {{-- @yield menyediakan tempat khusus yang bisa diisi (di-inject) oleh view lain yang melakukan @extends layout ini --}}
    @yield ('styles')
</head>
<body class="selection:bg-black selection:text-white bg-slate-50">
    {{-- Area utama untuk menampilkan isi halaman dari view turunan (seperti form login/register) --}}
    @yield ('content')
    
    {{-- Area untuk menempatkan script JS khusus dari view turunan --}}
    @yield ('scripts')
</body>
</html>

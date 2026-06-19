<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'SIPKL') }}</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Poppins:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap"
        rel="stylesheet"
    />

    <!-- Ikon Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Skrip -->
    @vite (['resources/css/app.css', 'resources/js/app.js'])

    <!-- Transisi Halaman -->

    <style>
        :root {
            --font-body: 'Plus Jakarta Sans', sans-serif;
            --font-display: 'Poppins', sans-serif;
            --font-label: 'JetBrains Mono', monospace;

            /* Senior Developer - Clean Dashboard Theme Colors (OKLCH based) */
            --color-paper: oklch(98.5% 0.003 240); /* extremely soft slate-50 background */
            --color-paper-2: #ffffff; /* crisp white for cards */
            --color-paper-3: oklch(95.5% 0.005 240); /* subtle slate-100 hover */
            --color-ink: oklch(25% 0.01 240); /* deep charcoal slate-900 text */
            --color-ink-muted: oklch(55% 0.01 240); /* secondary slate-500 text */

            --color-accent: oklch(50% 0.16 250); /* Royal Indigo accent */
            --color-accent-deep: oklch(40% 0.16 250);

            --color-accent-2: oklch(60% 0.16 150); /* Emerald Green success accent */
            --color-accent-2-deep: oklch(50% 0.16 150);

            --color-accent-3: oklch(60% 0.18 28); /* Coral Red danger accent */
            --color-accent-3-deep: oklch(50% 0.18 28);

            --color-mint: oklch(80% 0.16 150);

            --color-border: oklch(92% 0.005 240); /* clean border line */

            --radius-card: 20px;
            --radius-pill: 999px;
            --radius-input: 12px;

            --ease-spring: cubic-bezier(0.16, 1, 0.3, 1);

            --shadow-clay:
                0 12px 32px -12px oklch(20% 0.012 250 / 0.12), inset -6px -6px 12px oklch(20% 0.012 250 / 0.04),
                inset 6px 6px 12px oklch(100% 0 0 / 0.85);
            --shadow-clay-hover:
                0 20px 40px -16px oklch(20% 0.012 250 / 0.18), inset -8px -8px 16px oklch(20% 0.012 250 / 0.06),
                inset 8px 8px 16px oklch(100% 0 0 / 0.95);
        }

        body {
            font-family: var(--font-body);
            background-color: var(--color-paper);
            color: var(--color-ink);
        }
        .font-display {
            font-family: var(--font-display);
        }
        .font-label {
            font-family: var(--font-label);
        }
        .glass-sidebar {
            background: var(--color-paper-2);
            border-right: 1px solid var(--color-border);
        }
        .glass-topbar {
            background: color-mix(in oklch, var(--color-paper-2) 90%, transparent);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--color-border);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: var(--color-border);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--color-accent);
        }

        #page-content {
            opacity: 0;
        } /* Initial state for GSAP */

        /* Nav Link Overrides */
        .nav-items a {
            transition: all 200ms;
        }
        .nav-items a.bg-slate-50 {
            background-color: color-mix(in oklch, var(--color-accent) 10%, transparent) !important;
            color: var(--color-accent) !important;
            border-radius: var(--radius-input) !important;
            font-weight: 700 !important;
        }
        .nav-items a.bg-slate-50 svg {
            color: var(--color-accent) !important;
        }
        .nav-items a:hover:not(.bg-slate-50) {
            background-color: var(--color-paper-3) !important;
            color: var(--color-accent) !important;
        }

        /* Global UI element overrides to apply Hum theme style automatically */

        /* Claymorphic Bento Card Override */
        .bg-white.border.border-slate-300.rounded-xl,
        .bg-white.border-2.border-slate-200.rounded-3xl,
        .bg-white.border-2.border-slate-200,
        .bg-white.border.border-slate-200,
        .bg-white.rounded-3xl.border-2.border-slate-200 {
            background-color: var(--color-paper-2) !important;
            border: 2px solid var(--color-border) !important;
            border-radius: var(--radius-card) !important;
            box-shadow: var(--shadow-clay) !important;
            transition:
                border-color 250ms ease-out,
                box-shadow 250ms ease-out !important;
        }

        /* Translate hover effect only for links (cards) to prevent unstable form inputs */
        a.bg-white.border.border-slate-300.rounded-xl:hover,
        a.bg-white.border-2.border-slate-200.rounded-3xl:hover,
        a.bg-white.border-2.border-slate-200:hover,
        a.bg-white.border.border-slate-200:hover,
        a.bg-white.rounded-3xl.border-2.border-slate-200:hover {
            border-color: var(--color-border) !important;
            box-shadow: var(--shadow-clay-hover) !important;
        }

        /* Buttons overriding Tailwind standard classes */
        .bg-slate-900,
        .bg-blue-600,
        .bg-blue-800,
        .bg-slate-500 {
            background-color: var(--color-accent) !important;
            color: #ffffff !important;
            border-radius: var(--radius-pill) !important;
            border: none !important;
            font-weight: 600 !important;
        }
        .bg-slate-900:hover,
        .bg-blue-600:hover,
        .bg-blue-800:hover,
        .bg-slate-500:hover {
            background-color: var(--color-accent-deep) !important;
            color: #ffffff !important;
        }
        .bg-slate-900:active,
        .bg-blue-600:active,
        .bg-blue-800:active,
        .bg-slate-500:active {
            background-color: var(--color-accent-deep) !important;
            color: #ffffff !important;
        }

        /* Success green buttons (like Setujui) */
        .bg-green-700,
        .bg-green-600 {
            background-color: var(--color-accent-2) !important;
            color: #ffffff !important;
            border-radius: var(--radius-pill) !important;
            box-shadow:
                0 4px 0 0 var(--color-accent-2-deep),
                0 4px 10px -3px oklch(60% 0.16 150 / 0.15) !important;
            transition:
                transform 140ms cubic-bezier(0.2, 0.7, 0.3, 1),
                box-shadow 140ms !important;
            transform: translateY(0) !important;
            border: none !important;
        }
        .bg-green-700:hover,
        .bg-green-600:hover {
            transform: translateY(-2px) !important;
            background-color: var(--color-accent-2-deep) !important;
            color: #ffffff !important;
            box-shadow:
                0 6px 0 0 var(--color-accent-2-deep),
                0 8px 16px -4px oklch(60% 0.16 150 / 0.2) !important;
        }
        .bg-green-700:active,
        .bg-green-600:active {
            transform: translateY(2px) !important;
            background-color: var(--color-accent-2-deep) !important;
            color: #ffffff !important;
            box-shadow:
                0 1px 0 0 var(--color-accent-2-deep),
                0 2px 6px -2px oklch(60% 0.16 150 / 0.1) !important;
        }

        /* Apply paper background to white elements to maintain theme */
        .bg-white {
            background-color: var(--color-paper) !important;
        }

        /* Form Controls overriding */
        input[type='text'],
        input[type='email'],
        input[type='password'],
        input[type='date'],
        input[type='number'],
        select,
        textarea {
            background-color: var(--color-paper) !important;
            border: 2px solid var(--color-border) !important;
            border-radius: var(--radius-input) !important;
            color: var(--color-ink) !important;
            outline: none !important;
            box-shadow: inset 2px 2px 4px oklch(20% 0.012 250 / 0.05) !important;
            transition: all 250ms var(--ease-spring) !important;
        }
        input[type='text']:focus,
        input[type='email']:focus,
        input[type='password']:focus,
        input[type='date']:focus,
        input[type='number']:focus,
        select:focus,
        textarea:focus {
            border-color: var(--color-border) !important;
            box-shadow: none !important;
            outline: none !important;
            transform: translateY(-1px);
        }

        /* Clean Alert/Locked Warning Card Override */
        .bg-amber-50.border-2.border-amber-200.rounded-3xl {
            background-color: var(--color-paper-2) !important;
            border: 2px solid oklch(78% 0.12 80) !important; /* Premium soft amber border */
            border-radius: var(--radius-card) !important;
            box-shadow: var(--shadow-clay) !important;
        }

        /* Page content background pattern */
        .content-area-bg {
            background-color: #f8fafc !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:svgjs='http://svgjs.dev/svgjs' width='1440' height='560' preserveAspectRatio='none' viewBox='0 0 1440 560'%3e%3cg mask='url(%23SvgjsMask1002)' fill='none'%3e%3crect width='1440' height='560' x='0' y='0' fill='url(%23SvgjsLinearGradient1003)'/%3e%3cpath d='M1440 0L1194.03 0L1440 270.13z' fill='rgba(255%2c255%2c255%2c.1)'/%3e%3cpath d='M1194.03 0L1440 270.13L1440 368.44L1078.57 0z' fill='rgba(255%2c255%2c255%2c.075)'/%3e%3cpath d='M1078.57 0L1440 368.44L1440 466.66L981.18 0z' fill='rgba(255%2c255%2c255%2c.05)'/%3e%3cpath d='M981.18 0L1440 466.66L1440 527.48L872.4 0z' fill='rgba(255%2c255%2c255%2c.025)'/%3e%3cpath d='M0 560L297.71 560L0 318.88z' fill='rgba(0%2c0%2c0%2c.1)'/%3e%3cpath d='M0 318.88L297.71 560L618.84 560L0 205.77z' fill='rgba(0%2c0%2c0%2c.075)'/%3e%3cpath d='M0 205.77L618.84 560L958.67 560L0 143.91z' fill='rgba(0%2c0%2c0%2c.05)'/%3e%3cpath d='M0 143.91L958.67 560L1016.92 560L0 118.73z' fill='rgba(0%2c0%2c0%2c.025)'/%3e%3c/g%3e%3cdefs%3e%3cmask id='SvgjsMask1002'%3e%3crect width='1440' height='560' fill='white'/%3e%3c/mask%3e%3clinearGradient x1='15.28%25' y1='-39.29%25' x2='84.72%25' y2='139.29%25' gradientUnits='userSpaceOnUse' id='SvgjsLinearGradient1003'%3e%3cstop stop-color='%230e2a47' offset='0'/%3e%3cstop stop-color='%2300459e' offset='1'/%3e%3c/linearGradient%3e%3c/defs%3e%3c/svg%3e") !important;
            background-size: cover !important;
            background-position: center !important;
        }

        /* Focus rings for keyboard navigation */
        a:focus-visible,
        button:focus-visible {
            outline: 3px solid var(--color-accent-2) !important;
            outline-offset: 3px !important;
        }
    </style>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body
    class="font-sans antialiased selection:bg-slate-900 selection:text-white relative min-h-screen overflow-hidden flex"
>
    <!-- Bilah Samping -->
    <aside class="w-72 glass-sidebar flex flex-col z-20 shadow-sm">
        <!-- Logo -->
        <div class="h-24 flex items-center px-8 border-b border-slate-200">
            <div class="flex items-center gap-3 cursor-default">
                <img src="{{ asset('images/logosmk.png') }}" alt="Logo" class="w-12 h-12 object-contain shrink-0" />
                <div class="flex flex-col justify-center overflow-hidden">
                    <span
                        class="font-display text-slate-900 font-extrabold text-[14px] tracking-tight leading-tight mb-0.5 truncate"
                        >SISTEM INFORMASI PKL</span
                    >
                    <span
                        class="font-label text-[9.5px] text-slate-500 font-bold tracking-[0.08em] leading-none uppercase truncate mt-0.5"
                        >SMK Mandiri 01 Panongan</span
                    >
                </div>
            </div>
        </div>

        <!-- Tautan Navigasi -->
        <div class="flex-1 overflow-y-auto py-8 px-6 space-y-2 nav-items">
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mb-4 px-2">Menu Utama</div>

            <a href="/dashboard"
                        class="group flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('dashboard', '*.dashboard') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600 font-medium' }} transition-all"
            >
                <svg class="w-5 h-5 {{ request()->routeIs('dashboard', '*.dashboard') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>

            @if (Auth::check())
                @hasrole ('admin')
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mt-8 mb-4 px-2">
                        Admin Panel
                    </div>
                    <a href="{{ route('admin.siswa.index') }}"
                        class="group flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('admin.siswa.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600 font-medium' }} transition-all"
                    >
                        <!-- Ikon Pengguna -->
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.siswa.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Kelola Data Siswa
                    </a>
                    <a href="{{ route('admin.guru-pembimbing.index') }}"
                        class="group flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('admin.guru-pembimbing.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600 font-medium' }} transition-all"
                    >
                        <!-- Ikon Koper -->
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.guru-pembimbing.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Kelola Data Guru Pembimbing
                    </a>
                    <a href="{{ route('admin.guru-penguji.index') }}"
                        class="group flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('admin.guru-penguji.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600 font-medium' }} transition-all"
                    >
                        <!-- Icon Book Open (for Penguji/Academic) -->
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.guru-penguji.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Kelola Data Guru Penguji
                    </a>
                    <a href="{{ route('admin.tempat-pkl.index') }}"
                        class="group flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('admin.tempat-pkl.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600 font-medium' }} transition-all"
                    >
                        <!-- Ikon Gedung Kantor -->
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.tempat-pkl.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Kelola Data PKL
                    </a>
                @endhasrole
                @hasrole ('pembimbing')
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mt-8 mb-4 px-2">
                        Bimbingan
                    </div>
                    <a href="{{ route('pembimbing.pengajuan.index') }}"
                        class="group flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('pembimbing.pengajuan.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600 font-medium' }} transition-all"
                    >
                        <!-- Ikon Lingkaran Centang -->
                        <svg class="w-5 h-5 {{ request()->routeIs('pembimbing.pengajuan.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Verifikasi Pengajuan PKL
                    </a>
                    <a href="{{ route('pembimbing.laporan-harian.index') }}"
                        class="group flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('pembimbing.laporan.*') || request()->routeIs('pembimbing.laporan-harian.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600 font-medium' }} transition-all"
                    >
                        <!-- Ikon Papan Ujian Centang -->
                        <svg class="w-5 h-5 {{ request()->routeIs('pembimbing.laporan.*') || request()->routeIs('laporan-harian.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        Monitoring Laporan PKL
                    </a>
                    <a href="{{ route('pembimbing.jadwal-sidang.index') }}"
                        class="group flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('pembimbing.jadwal-sidang.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600 font-medium' }} transition-all"
                    >
                        <!-- Ikon Kalender -->
                        <svg class="w-5 h-5 {{ request()->routeIs('pembimbing.jadwal-sidang.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Kelola Jadwal Sidang
                    </a>
                    <a href="{{ route('pembimbing.nilai.index') }}"
                        class="group flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('pembimbing.nilai.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600 font-medium' }} transition-all"
                    >
                        <!-- Ikon Grafik Batang -->
                        <svg class="w-5 h-5 {{ request()->routeIs('pembimbing.nilai.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Rekap Nilai PKL
                    </a>
                    <a href="{{ route('pembimbing.sertifikat.index') }}"
                        class="group flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('pembimbing.sertifikat.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600 font-medium' }} transition-all"
                    >
                        <!-- Icon Badge Check (Award) -->
                        <svg class="w-5 h-5 {{ request()->routeIs('pembimbing.sertifikat.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                        Kelola Sertifikat PKL
                    </a>
                @endhasrole
                @hasrole ('penguji')
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mt-8 mb-4 px-2">
                        Pengujian
                    </div>
                    <a href="{{ route('penguji.jadwal-sidang.index') }}"
                        class="group flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('penguji.jadwal-sidang.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600 font-medium' }} transition-all"
                    >
                        <!-- Ikon Kalender -->
                        <svg class="w-5 h-5 {{ request()->routeIs('penguji.jadwal-sidang.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Lihat Jadwal Sidang
                    </a>
                    <a href="{{ route('penguji.input-nilai.index') }}"
                        class="group flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('penguji.input-nilai.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600 font-medium' }} transition-all"
                    >
                        <svg class="w-5 h-5 {{ request()->routeIs('penguji.input-nilai.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Input Nilai Sidang
                    </a>
                @endhasrole
                @hasrole ('siswa')
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mt-8 mb-4 px-2">
                        Aktivitas PKL
                    </div>
                    <a href="{{ route('siswa.pengajuan.index') }}"
                        class="group flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('siswa.pengajuan.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600 font-medium' }} transition-all"
                    >
                        <!-- Icon Mail (Surat) -->
                        <svg class="w-5 h-5 {{ request()->routeIs('siswa.pengajuan.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Mengajukan PKL
                    </a>
                    <a href="{{ route('siswa.surat-pengantar.index') }}"
                        class="group flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('siswa.surat-pengantar.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600 font-medium' }} transition-all"
                    >
                        <!-- Icon Mail (Surat) -->
                        <svg class="w-5 h-5 {{ request()->routeIs('siswa.surat-pengantar.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Unduh Surat Pengantar PKL
                    </a>
                    <a href="{{ route('siswa.jurnal-harian.index') }}"
                        class="group flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('siswa.jurnal-harian.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600 font-medium' }} transition-all"
                    >
                        <!-- Icon Pencil Edit (Laporan) -->
                        <svg class="w-5 h-5 {{ request()->routeIs('siswa.jurnal-harian.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Mengisi Laporan Harian PKL
                    </a>
                    <a href="{{ route('siswa.laporan-akhir.index') }}"
                        class="group flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('siswa.laporan-akhir.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600 font-medium' }} transition-all"
                    >
                        <!-- Ikon Papan Ujian Centang -->
                        <svg class="w-5 h-5 {{ request()->routeIs('siswa.laporan-akhir.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        Mengumpulkan Laporan Akhir PKL
                    </a>
                    <a href="{{ route('siswa.jadwal-sidang.index') }}"
                        class="group flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('siswa.jadwal-sidang.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600 font-medium' }} transition-all"
                    >
                        <!-- Ikon Kalender -->
                        <svg class="w-5 h-5 {{ request()->routeIs('siswa.jadwal-sidang.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Lihat Jadwal Sidang
                    </a>
                    <a href="{{ route('siswa.sertifikat.index') }}"
                        class="group flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('siswa.sertifikat.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600 font-medium' }} transition-all"
                    >
                        <!-- Icon Download (Unduh) -->
                        <svg class="w-5 h-5 {{ request()->routeIs('siswa.sertifikat.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Unduh Sertifikat PKL
                    </a>
                @endhasrole
            @endif
        </div>
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 flex flex-col h-screen z-10 relative">
        <!-- Bilah Atas -->
        <header class="h-24 glass-topbar flex items-center justify-end px-10 z-20">
            <div class="flex items-center gap-6">
                <!-- Dropdown Notifikasi -->
                <div class="relative" id="notification-dropdown-trigger">
                    <button
                        class="p-2.5 bg-white border border-slate-200 rounded-full text-slate-500 shadow-sm relative focus:outline-none"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        @if (auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                            <span
                                class="absolute top-1 right-1 w-2.5 h-2.5 bg-rose-500 rounded-full border-2 border-white"
                            ></span>
                        @endif
                    </button>

                    <div
                        id="notification-dropdown-menu"
                        class="absolute right-0 top-full mt-2 w-80 bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-slate-100 opacity-0 invisible transform origin-top-right translate-y-2 z-50 flex flex-col transition-all duration-200"
                    >
                        <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                            <h3 class="font-bold text-sm text-slate-900">Notifikasi</h3>
                            @if (auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                                <form method="POST" action="{{ route('notifications.read') }}" class="m-0">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="text-[10px] font-bold text-slate-900 hover:text-slate-900"
                                    >
                                        Tandai semua dibaca
                                    </button>
                                </form>
                            @endif
                        </div>
                        <div class="max-h-[60vh] overflow-y-auto">
                            @if (auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                                @foreach (auth()->user()->unreadNotifications->take(5) as $notification)
                                    <div class="p-4 border-b border-slate-50 hover:text-slate-900 transition-colors">
                                        <p class="text-xs text-slate-700 leading-relaxed">{{
                                            $notification->data['message'] ??
                                                'Ada pemberitahuan baru'
                                        }}</p>
                                        <span
                                            class="text-[10px] text-slate-400 mt-1.5 block"
                                            >{{ $notification->created_at->diffForHumans() }}</span
                                        >
                                    </div>
                                @endforeach
                            @else
                                <div
                                    class="p-6 text-center text-slate-500 flex flex-col items-center justify-center h-32"
                                >
                                    <svg class="w-8 h-8 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    <p class="text-xs font-medium">Tidak ada notifikasi baru</p>
                                </div>
                            @endif
                        </div>
                        @if (auth()->check() && auth()->user()->unreadNotifications->count() > 5)
                            <div class="p-3 border-t border-slate-100 text-center bg-slate-50 rounded-b-2xl">
                                <span class="text-[10px] font-bold text-slate-500"
                                    >+{{ auth()->user()->unreadNotifications->count() - 5 }} notifikasi lainnya</span
                                >
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Pemisah -->
                <div class="h-8 w-px bg-slate-200 hidden sm:block mx-4"></div>

                <!-- User Profile & Dropdown -->
                <div class="relative cursor-pointer py-2 px-3 rounded-xl" id="profile-dropdown-trigger">
                    <div class="flex items-center gap-4">
                        <div class="hidden sm:flex flex-col items-end">
                            <span
                                class="text-sm font-bold truncate text-slate-900"
                                >{{ Auth::check() ? Auth::user()->name : 'Guest' }}</span
                            >
                            <span
                                class="text-[9px] text-slate-500 font-bold tracking-wider truncate uppercase font-label"
                                >{{
                                    Auth::check()
                                        ? Auth::user()->roles->pluck('name')->implode(', ')
                                        : ''
                                }}</span
                            >
                        </div>
                        @php
                            $name = Auth::check() ? Auth::user()->name : 'guest';
                            $urlName = urlencode($name);
                            $avatarUrl = "https://ui-avatars.com/api/?name={$urlName}&background=random&color=fff&bold=true";
                        @endphp
                        <div
                            class="w-11 h-11 rounded-full bg-slate-100 border-2 border-white shadow-sm flex items-center justify-center overflow-hidden"
                            id="profile-avatar"
                        >
                            <img src="{{ $avatarUrl }}" alt="Profile" class="w-full h-full object-cover" />
                        </div>
                        <svg class="w-4 h-4 text-slate-400" id="profile-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>

                    <!-- Dropdown Menu -->
                    <div
                        id="profile-dropdown-menu"
                        class="absolute right-0 top-full mt-2 w-56 bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-slate-100 opacity-0 invisible transform origin-top-right translate-y-2 z-50"
                    >
                        <div class="p-2">
                            <a
                                href="{{ route('profile.edit') }}"
                                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:text-slate-900 rounded-lg transition-colors text-left mb-1"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Pengaturan Profil
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50 rounded-lg transition-colors text-left"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Keluar Sistem
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="flex-1 overflow-y-auto p-6 sm:p-10" style="background-color: #ffffff">
            @yield ('content')
        </div>
    </main>

    <!-- Page Entrance Animation -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const pageContent = document.querySelector('main > div.overflow-y-auto');
            if (pageContent) {
                pageContent.style.opacity = '0';
                pageContent.style.transform = 'translateY(10px)';
                requestAnimationFrame(() => {
                    pageContent.style.transition = 'all 0.6s cubic-bezier(0.16, 1, 0.3, 1)';
                    pageContent.style.opacity = '1';
                    pageContent.style.transform = 'translateY(0)';
                });
            }

            const trigger = document.getElementById('profile-dropdown-trigger');
            const menu = document.getElementById('profile-dropdown-menu');
            const arrow = document.getElementById('profile-arrow');
            const avatar = document.getElementById('profile-avatar');

            const notifTrigger = document.getElementById('notification-dropdown-trigger');
            const notifMenu = document.getElementById('notification-dropdown-menu');

            if (trigger && menu) {
                trigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isOpen = menu.classList.contains('opacity-100');

                    if (notifMenu) {
                        notifMenu.classList.add('opacity-0', 'invisible', 'translate-y-2');
                        notifMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                    }

                    if (isOpen) {
                        menu.classList.add('opacity-0', 'invisible', 'translate-y-2');
                        menu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                        arrow?.classList.remove('text-slate-900', 'rotate-180');
                        avatar?.classList.remove('ring-4', 'ring-slate-100');
                    } else {
                        menu.classList.remove('opacity-0', 'invisible', 'translate-y-2');
                        menu.classList.add('opacity-100', 'visible', 'translate-y-0');
                        arrow?.classList.add('text-slate-900', 'rotate-180');
                        avatar?.classList.add('ring-4', 'ring-slate-100');
                    }
                });
            }

            if (notifTrigger && notifMenu) {
                notifTrigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isOpen = notifMenu.classList.contains('opacity-100');

                    if (menu) {
                        menu.classList.add('opacity-0', 'invisible', 'translate-y-2');
                        menu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                        arrow?.classList.remove('text-slate-900', 'rotate-180');
                        avatar?.classList.remove('ring-4', 'ring-slate-100');
                    }

                    if (isOpen) {
                        notifMenu.classList.add('opacity-0', 'invisible', 'translate-y-2');
                        notifMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                    } else {
                        notifMenu.classList.remove('opacity-0', 'invisible', 'translate-y-2');
                        notifMenu.classList.add('opacity-100', 'visible', 'translate-y-0');
                    }
                });
            }

            document.addEventListener('click', () => {
                if (menu) {
                    menu.classList.add('opacity-0', 'invisible', 'translate-y-2');
                    menu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                    arrow?.classList.remove('text-slate-900', 'rotate-180');
                    avatar?.classList.remove('ring-4', 'ring-slate-100');
                }
                if (notifMenu) {
                    notifMenu.classList.add('opacity-0', 'invisible', 'translate-y-2');
                    notifMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                }
            });
        });
    </script>

    <!-- Global SweetAlert2 Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                },
            });

            @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}',
            });
            @endif

            @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#1d4ed8',
            });
            @endif

            @if (session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian!',
                text: '{{ session('warning') }}',
                confirmButtonColor: '#1d4ed8',
            });
            @endif

            document.querySelectorAll('form[data-confirm]').forEach((form) => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: this.getAttribute('data-confirm'),
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, Lanjutkan!',
                        cancelButtonText: 'Batal',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.removeAttribute('data-confirm');
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>

@extends ('layouts.guest')
@section ('styles')
    <style>
        /* Hallmark · genre: playful · macrostructure: Bento Grid · theme: Hum · enrichment: none · nav: N1b · footer: Ft8 */
        :root {
        --font-body: 'Plus Jakarta Sans', sans-serif;
        --font-display: 'Poppins', sans-serif;
        --font-label: 'JetBrains Mono', monospace;
        /* Senior Developer - Clean Theme Colors (OKLCH based) */
        --color-paper: oklch(98.5% 0.003 240); /* extremely soft slate-50 background */
        --color-paper-2: #ffffff; /* crisp white for cards */
        --color-paper-3: oklch(95.5% 0.005 240); /* subtle slate-100 hover */
        --color-ink: oklch(25% 0.01 240); /* deep charcoal slate-900 text */
        --color-ink-muted: oklch(55% 0.01 240);/* secondary slate-500 text */
        --color-accent: oklch(50% 0.16 250); /* Royal Indigo accent */
        --color-accent-deep: oklch(40% 0.16 250);
        --color-accent-2: oklch(60% 0.16 150); /* Emerald Green success accent */
        --color-accent-2-deep: oklch(50% 0.16 150);
        --color-accent-3: oklch(60% 0.18 28); /* Coral Red danger accent */
        --color-accent-3-deep: oklch(50% 0.18 28);
        --color-mint: oklch(80% 0.16 150);
        --color-mint-deep: oklch(50% 0.16 150);
        --color-border: oklch(92% 0.005 240);
        --radius-card: 20px;
        --radius-pill: 999px;
        --radius-input: 12px;
        --ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);
        --ease-snap: cubic-bezier(0.22, 1, 0.36, 1);
        --text-xs: 0.75rem;
        --text-sm: 0.875rem;
        --text-base: 1rem;
        --text-md: 1.25rem;
        --text-lg: 1.5rem;
        }
        html, body {
        overflow-x: clip;
        font-family: var(--font-body);
        background-color: var(--color-paper);
        color: var(--color-ink);
        -webkit-font-smoothing: antialiased;
        }
        .font-display {
        font-family: var(--font-display);
        }
        .font-label {
        font-family: var(--font-label);
        }
        .mono-label {
        font-family: var(--font-label);
        font-size: 11px;
        letter-spacing: 0.10em;
        text-transform: uppercase;
        color: var(--color-ink-muted);
        font-weight: 600;
        }
        /* Nav N1b Style overrides */
        .nav-hum {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 500;
        background: transparent;
        border-bottom: 1px solid transparent;
        transition: background 240ms, border-color 240ms, box-shadow 240ms;
        }
        .nav-hum.is-scrolled {
        background: color-mix(in oklch, var(--color-paper) 85%, transparent);
        backdrop-filter: blur(16px);
        border-bottom-color: var(--color-border);
        box-shadow: 0 8px 30px -15px oklch(20% 0.012 250 / 0.1);
        }
        /* Button System (Chunky Push Feedback) */
        .btn {
        --btn-face: var(--color-accent);
        --btn-ink: #ffffff;
        --btn-edge: var(--color-accent-deep);
        --btn-cast: oklch(50% 0.16 250 / 0.2);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5em;
        padding: 0.8rem 1.5rem;
        font-weight: 600;
        border: 0;
        border-radius: var(--radius-pill);
        color: var(--btn-ink);
        background: var(--btn-face);
        cursor: pointer;
        position: relative;
        isolation: isolate;
        transform: none;
        transition: background-color 160ms, opacity 160ms;
        font-size: var(--text-sm);
        }
        .btn:hover {
            opacity: 0.9;
        }
        .btn:focus-visible {
        outline: 3px solid var(--color-accent-2);
        outline-offset: 3px;
        }
        .btn:active {
            opacity: 0.8;
        }
        .btn--sm {
        padding: 0.5rem 1.1rem;
        font-size: 13px;
        }
        .btn--cyan {
        --btn-face: var(--color-accent-2);
        --btn-edge: var(--color-accent-2-deep);
        --btn-cast: oklch(60% 0.16 150 / 0.2);
        --btn-ink: #ffffff;
        }
        .btn--coral {
        --btn-face: var(--color-accent-3);
        --btn-edge: var(--color-accent-3-deep);
        --btn-cast: oklch(60% 0.18 28 / 0.2);
        --btn-ink: #ffffff;
        }
        .btn--soft {
        --btn-face: var(--color-paper-2);
        --btn-ink: var(--color-ink);
        --btn-edge: var(--color-border);
        --btn-cast: transparent;
        border: 1px solid var(--color-border);
        }
        .btn--soft:hover {
        --btn-face: var(--color-paper-3);
        }
        .btn--soft:active {
        transform: none;
        }
        /* Headline & Highlights (Signature #2) */
        .hero__title {
        font-family: var(--font-display);
        font-weight: 700;
        font-size: clamp(2.25rem, 5vw + 1rem, 3.75rem);
        line-height: 1.05;
        letter-spacing: -0.025em;
        max-width: 20ch;
        margin: 0 auto;
        overflow-wrap: anywhere;
        min-width: 0;
        }
        .hero__title em {
        font-style: normal;
        color: inherit;
        position: relative;
        background-image: linear-gradient(var(--color-accent-2) 0 0);
        background-repeat: no-repeat;
        background-size: 100% 0.28em;
        background-position: 0 88%;
        -webkit-box-decoration-break: clone;
        box-decoration-break: clone;
        padding-bottom: 0.02em;
        }
        /* Bento Grid (F1 Bento Grid) */
        .bento-shell {
        max-width: 1200px;
        margin: 0 auto;
        padding-inline: 1.5rem;
        padding-bottom: 6rem;
        }
        /* Bento Grid (F1 Bento Grid) */
        .bento-shell {
        max-width: 1200px;
        margin: 0 auto;
        padding-inline: 1.5rem;
        padding-bottom: 6rem;
        }
        .bento-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-auto-rows: minmax(13rem, auto);
        gap: 1.5rem;
        }
        /* Claymorphic shadows and variables */
        :root {
            --shadow-clay: 0 12px 32px -12px oklch(20% 0.012 250 / 0.12),
                           inset -6px -6px 12px oklch(20% 0.012 250 / 0.04),
                           inset 6px 6px 12px oklch(100% 0 0 / 0.85);
            --shadow-clay-hover: 0 20px 40px -16px oklch(20% 0.012 250 / 0.18),
                                 inset -8px -8px 16px oklch(20% 0.012 250 / 0.06),
                                 inset 8px 8px 16px oklch(100% 0 0 / 0.95);
        }
        .card-bento {
        background: var(--color-paper-2);
        border: 2px solid var(--color-border);
        border-radius: var(--radius-card);
        padding: 1.75rem;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: border-color 250ms ease-out, box-shadow 250ms ease-out;
        box-shadow: var(--shadow-clay);
        }
        .card-bento:hover {
        box-shadow: var(--shadow-clay-hover);
        border-color: var(--color-border);
        }
        /* Asymmetric spans */
        .span-2x2 { grid-column: span 2; grid-row: span 2; }
        .span-2x1 { grid-column: span 2; }
        .span-1x2 { grid-row: span 2; }
        @media (max-width: 64rem)
        {
        .bento-grid {
        grid-template-columns: repeat(2, 1fr);
        }
        .span-2x2 { grid-column: span 2; grid-row: span 2; }
        .span-2x1 { grid-column: span 2; }
        .span-1x2 { grid-row: span 2; }
        }
        @media (max-width: 40rem)
        {
        .bento-grid {
        grid-template-columns: 1fr;
        grid-auto-rows: auto;
        }
        .span-2x2, .span-2x1, .span-1x2 {
        grid-column: span 1 !important;
        grid-row: span 1 !important;
        }
        }
        /* Interactive Mascot (Signature #5 with 3D details & Speech Bubble) */
        .mascot-box {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        min-height: 110px;
        position: relative;
        }
        .mascot-face {
        width: 85px;
        height: 85px;
        background: oklch(84% 0.18 90); /* Beautiful vibrant yellow mascot */
        border-radius: var(--radius-pill);
        border: 3px solid var(--color-ink);
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        box-shadow: 0 8px 24px oklch(20% 0.012 250 / 0.15),
                    inset -4px -4px 10px oklch(78% 0.18 95 / 0.5),
                    inset 4px 4px 10px oklch(100% 0 0 / 0.8);
        cursor: pointer;
        transition: all 300ms var(--ease-spring);
        animation: mascot-float 4s ease-in-out infinite;
        }
        .mascot-face:hover {
        background: oklch(76% 0.20 25); /* Red hover */
        transform: scale(1.15) rotate(12deg);
        box-shadow: 0 12px 32px oklch(68% 0.24 25 / 0.3),
                    inset -4px -4px 10px oklch(60% 0.24 25 / 0.5),
                    inset 4px 4px 10px oklch(100% 0 0 / 0.8);
        }
        .mascot-eyes {
        display: flex;
        gap: 16px;
        margin-top: -6px;
        }
        .mascot-eye {
        width: 14px;
        height: 14px;
        background: white;
        border: 2px solid var(--color-ink);
        border-radius: var(--radius-pill);
        position: relative;
        overflow: hidden;
        }
        .mascot-pupil {
        width: 6px;
        height: 6px;
        background: var(--color-ink);
        border-radius: var(--radius-pill);
        position: absolute;
        top: 2px;
        left: 2px;
        transition: all 100ms ease-out;
        }
        .mascot-mouth {
        width: 22px;
        height: 10px;
        border-bottom: 4px solid var(--color-ink);
        border-radius: 0 0 12px 12px;
        margin-top: 10px;
        transition: all 200ms ease;
        }
        .mascot-face:hover .mascot-mouth {
        height: 14px;
        width: 14px;
        background: var(--color-ink);
        border-radius: var(--radius-pill);
        }
        /* Speech Bubble */
        .speech-bubble {
        position: absolute;
        top: -24px;
        background: white;
        border: 2px solid var(--color-ink);
        border-radius: 12px;
        padding: 6px 12px;
        font-size: 11px;
        font-weight: 800;
        color: var(--color-ink);
        white-space: nowrap;
        box-shadow: 4px 4px 0px var(--color-ink);
        opacity: 0;
        transform: scale(0.8) translateY(10px);
        transition: all 250ms var(--ease-spring);
        pointer-events: none;
        z-index: 50;
        }
        .speech-bubble.is-visible {
        opacity: 1;
        transform: scale(1) translateY(0);
        }
        .speech-bubble::after {
        content: '';
        position: absolute;
        bottom: -7px;
        left: 50%;
        transform: translateX(-50%) rotate(45deg);
        width: 10px;
        height: 10px;
        background: white;
        border-right: 2px solid var(--color-ink);
        border-bottom: 2px solid var(--color-ink);
        }
        @keyframes
        mascot-float {
        0%, 100% { transform: none; }
        50% { transform: none; }
        }
        @media (prefers-reduced-motion: reduce)
        {
        .mascot-face {
        animation: none;
        }
        }
        /* Star-burst effect (Signature #7) */
        .star-burst {
        position: absolute;
        width: 24px;
        height: 24px;
        background:
        linear-gradient(90deg, transparent 46%, var(--color-accent-3) 46% 54%, transparent 54%),
        linear-gradient(0deg, transparent 46%, var(--color-accent-3) 46% 54%, transparent 54%);
        animation: star-burst-anim 420ms ease-out forwards;
        pointer-events: none;
        z-index: 1000;
        }
        @keyframes
        star-burst-anim {
        0% { transform: translate(-50%, -50%) scale(0) rotate(0deg); opacity: 1; }
        60% { transform: translate(-50%, -50%) scale(1.2) rotate(35deg); opacity: 0.9; }
        100% { transform: translate(-50%, -50%) scale(1.4) rotate(45deg); opacity: 0; }
        }
        /* Success tick-up completion scale pulse */
        .pulse-celebrate {
        animation: pulse-celebrate-anim 400ms var(--ease-spring);
        }
        @keyframes
        pulse-celebrate-anim {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.06); }
        }
        /* Footer Marquee Scroll (Ft8) */
        .foot-marquee {
        overflow: hidden;
        border-top: 1px solid var(--color-border);
        background: var(--color-paper);
        }
        .foot-marquee__track {
        display: flex;
        gap: 2.5rem;
        white-space: nowrap;
        padding-block: 1.25rem;
        animation: foot-marquee 35s linear infinite;
        }
        .foot-marquee__track span {
        font-family: var(--font-label);
        font-weight: 600;
        letter-spacing: 0.1em;
        font-size: 11px;
        text-transform: uppercase;
        color: var(--color-ink-muted);
        }
        @keyframes
        foot-marquee {
        from { transform: translateX(0); }
        to { transform: translateX(-50%); }
        }
        @media (prefers-reduced-motion: reduce)
        {
        .foot-marquee__track { animation: none; }
        }
        /* Standardized scroll reveals */
        .gsap-reveal {
        opacity: 0;
        transform: none;
        }
        /* 01 Connector decoration rules */
        .connector-line {
            position: absolute;
            background: linear-gradient(90deg, var(--color-accent-2) 0%, transparent 100%);
            height: 2px;
            opacity: 0.4;
            animation: pulse-line 3s infinite ease-in-out;
        }
        @keyframes
        pulse-line {
                   0%, 100% { opacity: 0.2; transform: scaleX(0.9); }
                   50% { opacity: 0.7; transform: scaleX(1.1); }
               }
               /* 02 Log typing simulation rules */
               .typing-cursor {
                   display: inline-block;
                   width: 2.5px;
                   height: 12px;
                   background: var(--color-accent-2-deep);
                   animation: blink-cursor 800ms infinite step-end;
                   vertical-align: middle;
                   margin-left: 2px;
               }
        @keyframes
        blink-cursor {
                   from, to { background-color: transparent }
                   50% { background-color: var(--color-accent-2-deep) }
               }
               /* 03 Radial Progress Ring rules */
               .radial-stat {
                   position: relative;
                   width: 60px;
                   height: 60px;
                   display: flex;
                   align-items: center;
                   justify-content: center;
               }
               .radial-circle-bg {
                   fill: none;
                   stroke: var(--color-border);
                   stroke-width: 5;
               }
               .radial-circle-fill {
                   fill: none;
                   stroke: var(--color-accent-2);
                   stroke-width: 5;
                   stroke-linecap: round;
                   stroke-dasharray: 170;
                   stroke-dashoffset: 170;
                   transform: rotate(-90deg);
                   transform-origin: 50% 50%;
                   transition: stroke-dashoffset 1.5s var(--ease-spring);
               }
               /* 05 Touch Approval Swipe Card rules */
               .swipe-card-container {
                   position: relative;
                   height: 80px;
                   perspective: 1000px;
               }
               .swipe-card {
                   transition: transform 300ms var(--ease-spring), background-color 300ms, border-color 300ms;
                   will-change: transform;
                   cursor: grab;
               }
               .swipe-card:active {
                   cursor: grabbing;
               }
               .swipe-action-indicator {
                   position: absolute;
                   top: 50%;
                   transform: translateY(-50%);
                   font-size: 10px;
                   font-weight: 800;
                   text-transform: uppercase;
                   opacity: 0;
                   transition: opacity 200ms;
                   pointer-events: none;
               }
               .swipe-action-left {
                   left: 14px;
                   color: var(--color-accent-3-deep);
               }
               .swipe-action-right {
                   right: 14px;
                   color: var(--color-mint-deep);
               }
               /* 06 Live blink dot */
               .live-dot {
                   display: inline-block;
                   width: 8px;
                   height: 8px;
                   background-color: var(--color-accent-3);
                   border-radius: 50%;
                   animation: blink-live 1s infinite alternate;
               }
        @keyframes
        blink-live {
                   from { opacity: 0.3; transform: scale(0.8); }
                   to { opacity: 1; transform: scale(1.2); }
               }
               /* 07 Holographic Glare Certificate card rules */
               .certificate-card {
                   transform-style: preserve-3d;
                   transition: transform 250ms var(--ease-spring), box-shadow 250ms;
                   position: relative;
                   background: linear-gradient(135deg, #ffffff 0%, var(--color-paper-2) 100%);
                   border: 2px solid var(--color-border);
                   border-radius: var(--radius-card);
                   box-shadow: var(--shadow-clay);
               }
               .certificate-hologram {
                   position: absolute;
                   inset: 0;
                   background: linear-gradient(
                       125deg,
                       rgba(255, 255, 255, 0) 0%,
                       rgba(255, 255, 255, 0.4) 30%,
                       rgba(66, 180, 235, 0.2) 40%,
                       rgba(220, 100, 150, 0.2) 60%,
                       rgba(255, 255, 255, 0) 100%
                   );
                   mix-blend-mode: color-dodge;
                   opacity: 0;
                   transition: opacity 300ms;
                   background-size: 200% 200%;
                   background-position: 0% 0%;
                   pointer-events: none;
                   border-radius: inherit;
               }
               .certificate-card:hover .certificate-hologram {
                   opacity: 1;
               }
               /* 08 Infinite marquee partner logo rules */
               .marquee-logo-container {
                   overflow: hidden;
                   display: flex;
                   width: 100%;
                   position: relative;
                   mask-image: linear-gradient(to right, transparent, white 15%, white 85%, transparent);
                   -webkit-mask-image: linear-gradient(to right, transparent, white 15%, white 85%, transparent);
                   padding-block: 0.5rem;
               }
               .marquee-logo-track {
                   display: flex;
                   gap: 1.25rem;
                   width: max-content;
                   animation: marquee-scroll 25s linear infinite;
               }
               .marquee-logo-track:hover {
                   animation-play-state: paused;
               }
        @keyframes
        marquee-scroll {
                   0% { transform: translateX(0); }
                   100% { transform: translateX(-50%); }
               }
               /* Slider component rules */
               .slider-container {
                   box-shadow: var(--shadow-clay);
                   border: 2px solid var(--color-border);
                   background: var(--color-paper-2);
               }
               .slider-dot.is-active {
                   background-color: var(--color-accent-2-deep) !important;
                   width: 24px !important;
                   border-radius: var(--radius-pill);
                   transition: width 200ms ease, background-color 200ms;
               }
    </style>
@endsection
@section ('content')
    <div class="selection:bg-black selection:text-white">
        <header class="nav-hum" id="nav-hum">
            <nav class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
                <div class="flex items-center gap-3.5">
                    <img
                        src="{{ asset('images/logosmk.png') }}"
                        alt="Logo"
                        class="w-14 h-14 md:w-16 md:h-16 object-contain"
                    />
                    <div class="flex flex-col justify-center">
                        <span
                            class="font-display text-slate-900 font-extrabold text-lg md:text-xl tracking-tight leading-tight"
                            >SISTEM INFORMASI PKL</span
                        >
                        <span
                            class="mono-label text-slate-500 font-bold text-[10px] md:text-xs tracking-wider uppercase leading-tight mt-0.5"
                            >SMK Mandiri 01 Panongan</span
                        >
                    </div>
                </div>
                <div>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn--soft btn--sm">Masuk Dasbor</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn--sm">Login Portal</a>
                    @endauth
                </div>
            </nav>
        </header>
        <main class="pt-24">
            <section class="max-w-7xl mx-auto text-center px-4 sm:px-6 mb-16 relative">
                <div class="absolute inset-0 bg-slate-100 rounded-[2.5rem] blur-3xl opacity-40 -z-10"></div>
                <div
                    class="relative w-full overflow-hidden rounded-2xl drop-shadow-xl gsap-reveal slider-container"
                    style="animation-delay: 0.2s"
                >
                    <div
                        class="flex transition-transform duration-500 ease-out cursor-grab active:cursor-grabbing"
                        id="hero-slider-track"
                    >
                        <div class="min-w-full flex justify-center items-center select-none">
                            <img
                                src="{{ asset('images/visimissi.png') }}"
                                alt="Visi Misi"
                                class="w-full h-auto object-contain rounded-2xl pointer-events-none"
                            />
                        </div>
                        <div class="min-w-full flex justify-center items-center select-none">
                            <img
                                src="{{ asset('images/banner2.png') }}"
                                alt="Banner 2"
                                class="w-full h-auto object-contain rounded-2xl pointer-events-none"
                            />
                        </div>
                    </div>
                    <button
                        id="slider-prev"
                        class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/85 hover:bg-white text-slate-800 p-2.5 rounded-full shadow-md border border-slate-200/50 backdrop-blur-sm z-30 transition-all cursor-pointer select-none"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button
                        id="slider-next"
                        class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/85 hover:bg-white text-slate-800 p-2.5 rounded-full shadow-md border border-slate-200/50 backdrop-blur-sm z-30 transition-all cursor-pointer select-none"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-30">
                        <button
                            class="w-2.5 h-2.5 rounded-full bg-slate-900/50 border border-white/40 cursor-pointer slider-dot is-active"
                            data-index="0"
                            aria-label="Slide 1"
                        ></button>
                        <button
                            class="w-2.5 h-2.5 rounded-full bg-white/50 border border-slate-900/20 cursor-pointer slider-dot"
                            data-index="1"
                            aria-label="Slide 2"
                        ></button>
                    </div>
                </div>
            </section>
            <section class="bento-shell">
                <div class="bento-grid">
                    <article
                        class="card-bento span-2x2 !bg-white gsap-reveal relative overflow-hidden"
                        style="box-shadow: var(--shadow-clay)"
                    >
                        <div class="connector-line" style="top: 25%; left: 0; width: 60%"></div>
                        <div class="connector-line" style="top: 60%; right: 0; width: 40%; animation-delay: 1.5s"></div>
                        <div
                            class="absolute inset-0 pointer-events-none opacity-[0.03]"
                            style="
                                background-image: radial-gradient(var(--color-ink) 1.5px, transparent 1.5px);
                                background-size: 20px 20px;
                            "
                        ></div>
                        <div class="relative z-10 w-full md:w-5/6">
                            <span class="mono-label block mb-4">01 · HUB KOORDINASI</span>
                            <h2 class="font-extrabold text-2xl tracking-tight leading-snug mb-4 text-slate-900">
                                Koordinasi magang terpusat untuk seluruh aktivitas akademik.
                            </h2>
                            <p class="text-slate-500 text-sm leading-relaxed mb-8">Lakukan pengajuan industri, pelaporan harian, dan evaluasi hasil kerja lapangan secara langsung tanpa birokrasi kertas.</p>
                        </div>
                        <div class="relative z-10 mt-auto">
                            @auth
                                <a
                                    href="{{ url('/dashboard') }}"
                                    class="bg-yellow-400 hover:bg-yellow-500 text-slate-900 font-bold py-3.5 px-7 rounded-full inline-flex items-center gap-2 shadow-md hover:scale-[1.03] transition-transform duration-200"
                                    style="
                                        border: 2.5px solid var(--color-ink);
                                        box-shadow: 4px 4px 0px var(--color-ink);
                                    "
                                >
                                    Buka Dasbor Anda
                                    <svg class="w-5 h-5 ml-1 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            @else
                                <a
                                    href="{{ route('login') }}"
                                    class="bg-yellow-400 hover:bg-yellow-500 text-slate-900 font-bold py-3.5 px-7 rounded-full inline-flex items-center gap-2 shadow-md hover:scale-[1.03] transition-transform duration-200"
                                    style="
                                        border: 2.5px solid var(--color-ink);
                                        box-shadow: 4px 4px 0px var(--color-ink);
                                    "
                                >
                                    Masuk ke Portal Magang
                                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            @endauth
                        </div>
                    </article>
                    <article class="card-bento span-1x2 tint-cyan gsap-reveal" id="portal-siswa">
                        <div>
                            <span class="mono-label block mb-4">02 · AKTIVITAS SISWA</span>
                            <h2 class="font-bold text-xl tracking-tight leading-snug mb-6">
                                Pencacatan Laporan Harian
                            </h2>
                            <div class="space-y-4">
                                @forelse ($laporan_terbaru as $laporan)
                                <div class="card-glass p-3.5 rounded-xl flex flex-col gap-2">
                                    <div class="flex justify-between items-center">
                                        <span class="mono-label text-[9px]">{{ $laporan->siswa->user->name ?? '-' }}</span>
                                        <span class="px-2 py-0.5 bg-emerald-500/10 text-emerald-800 text-[9px] font-bold rounded-full border border-emerald-500/20">Disetujui</span>
                                    </div>
                                    <p class="text-xs font-semibold text-slate-700 leading-normal">{{ \Illuminate\Support\Str::limit($laporan->kegiatan, 60) }}</p>
                                </div>
                                @empty
                                <div class="card-glass p-3.5 rounded-xl flex flex-col gap-2 border-dashed border-sky-400">
                                    <div class="flex justify-between items-center">
                                        <span class="mono-label text-[9px] text-sky-700 font-bold">LOG SISWA / LIVE DEMO</span>
                                        <span class="px-2 py-0.5 bg-sky-500/10 text-sky-800 text-[9px] font-bold rounded-full border border-sky-500/20 animate-pulse">Proses</span>
                                    </div>
                                    <p class="text-xs font-semibold text-slate-700 leading-normal">
                                        <span id="autotyping-log"></span><span class="typing-cursor"></span>
                                    </p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="pt-6">
                            <span class="text-xs font-bold text-sky-800 flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-sky-500 animate-ping"></span>
                                Laporan harian mewakili semua kompetensi keahlian.
                            </span>
                        </div>
                    </article>
                    <article class="card-bento span-1x1 tint-coral gsap-reveal flex flex-col justify-between">
                        <div>
                            <span class="mono-label block mb-2">03 · STATISTIK AKTIF</span>
                            <h3 class="text-slate-500 text-xs font-semibold">Siswa Magang</h3>
                        </div>
                        <div class="flex items-center justify-between gap-2 my-auto">
                            <div>
                                <span
                                    class="text-5xl font-bold tracking-tight text-ink font-display stat-count"
                                    data-target="{{ $siswa_count }}"
                                    >0</span
                                >
                                <span class="text-xs font-bold text-slate-600 block mt-1">Siswa Tersebar</span>
                            </div>
                            <div class="radial-stat">
                                <svg width="60" height="60" viewBox="0 0 60 60">
                                    <circle class="radial-circle-bg" cx="30" cy="30" r="27" />
                                    <circle id="radial-progress-circle" class="radial-circle-fill" cx="30" cy="30" r="27" />
                                </svg>
                                <span class="absolute text-[10px] font-bold text-slate-800">85%</span>
                            </div>
                        </div>
                        <div>
                            <span class="mono-label text-[10px] text-slate-500 block">TKR · MP · DKV · TKJ</span>
                        </div>
                    </article>
                    <article class="card-bento span-1x1 gsap-reveal flex flex-col justify-between" id="mascot-tile">
                        <div>
                            <span class="mono-label block mb-2">04 · INTERAKSI</span>
                            <h3 class="text-slate-500 text-xs font-semibold">Maskot SI-PKL</h3>
                        </div>
                        <div class="mascot-box">
                            <div class="speech-bubble" id="mascot-speech">Hai! Tetap semangat ya!</div>
                            <div class="mascot-face" id="mascot-face-interactive">
                                <div class="mascot-eyes">
                                    <div class="mascot-eye">
                                        <div class="mascot-pupil" id="pupil-left"></div>
                                    </div>
                                    <div class="mascot-eye">
                                        <div class="mascot-pupil" id="pupil-right"></div>
                                    </div>
                                </div>
                                <div class="mascot-mouth"></div>
                            </div>
                        </div>
                        <div class="text-center">
                            <span class="text-[11px] font-bold text-slate-500 animate-pulse"
                                >Klik maskot atau dekati kursor</span
                            >
                        </div>
                    </article>
                    <article
                        class="card-bento span-2x1 tint-cyan gsap-reveal flex flex-col justify-between"
                        id="portal-guru"
                    >
                        <div>
                            <span class="mono-label block mb-2">05 · SUPERVISI GURU</span>
                            <h2 class="font-bold text-lg tracking-tight leading-snug mb-1">
                                Verifikasi & Validasi Laporan
                            </h2>
                            <p class="text-slate-500 text-[11px] leading-relaxed max-w-md">Guru memonitor keaslian aktivitas kerja lapangan seluruh jurusan secara langsung.</p>
                        </div>
                        <div
                            class="swipe-card-container bg-slate-100/60 rounded-2xl border border-slate-200/60 p-1 relative overflow-hidden flex items-center justify-center"
                        >
                            <div class="swipe-action-indicator swipe-action-left">Revisi ✗</div>
                            <div class="swipe-action-indicator swipe-action-right">Setuju ✓</div>
                            <div
                                id="interactive-swipe-card"
                                class="swipe-card absolute inset-x-2 bg-white p-3 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between z-20"
                            >
                                <div class="flex flex-col gap-0.5">
                                    <span id="swipe-student-name" class="text-xs font-bold text-slate-800">
                                        {{ $laporan_terbaru->first()?->siswa?->user?->name ?? 'Nama Siswa' }}
                                    </span>
                                    <span id="swipe-student-log" class="text-[10px] text-slate-500 font-medium">
                                        {{ \Illuminate\Support\Str::limit($laporan_terbaru->first()?->kegiatan ?? 'Kegiatan PKL', 55) }}
                                    </span>
                                </div>
                                <div class="flex gap-1.5 relative z-30">
                                    <button
                                        id="btn-simulate-revisi"
                                        class="btn btn--soft btn--sm !py-1 !px-2.5 !text-[10px] btn-star"
                                    >
                                        Revisi
                                    </button>
                                    <button
                                        id="btn-simulate-setujui"
                                        class="btn btn--sm !py-1 !px-2.5 !text-[10px] btn-star"
                                    >
                                        Setujui
                                    </button>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article class="card-bento span-1x1 tint-pear gsap-reveal flex flex-col justify-between">
                        <div>
                            <span class="mono-label block mb-2">06 · EVALUASI</span>
                            <h3 class="text-slate-800 font-bold text-sm">Sidang Laporan</h3>
                        </div>
                        @if (isset($jadwal_sidang_terbaru) && $jadwal_sidang_terbaru)
                        <div
                            class="bg-white/80 p-2.5 rounded-xl border border-slate-200 shadow-sm my-auto flex gap-3 items-center"
                        >
                            <div
                                class="bg-rose-500 text-white p-1.5 rounded-lg flex flex-col items-center justify-center min-w-[36px] min-h-[36px] shadow-sm"
                            >
                                <span class="text-[8px] font-bold uppercase leading-none">{{ \Carbon\Carbon::parse($jadwal_sidang_terbaru->waktu)->locale('id')->isoFormat('MMM') }}</span>
                                <span class="text-base font-extrabold leading-none">{{ \Carbon\Carbon::parse($jadwal_sidang_terbaru->waktu)->format('d') }}</span>
                            </div>
                            <div class="space-y-0.5">
                                <div id="sidang-room" class="text-[11px] font-extrabold text-slate-800 leading-none">
                                    {{ $jadwal_sidang_terbaru->ruangan }}
                                </div>
                                <div id="sidang-time" class="text-[9px] font-bold text-slate-500">
                                    {{ \Carbon\Carbon::parse($jadwal_sidang_terbaru->waktu)->locale('id')->isoFormat('D MMM') }} · Pukul: {{ \Carbon\Carbon::parse($jadwal_sidang_terbaru->waktu)->format('H:i') }} WIB
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-400">{{ $jadwal_sidang_terbaru->penguji->user->name ?? 'Guru Penguji' }}</span>
                        </div>
                        @else
                        <div class="my-auto text-center">
                            <span class="text-[11px] text-slate-400 font-medium">Belum ada jadwal sidang</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-400">Guru Penguji</span>
                        </div>
                        @endif
                    </article>
                    <article class="card-bento span-1x1 tint-coral gsap-reveal flex flex-col justify-between">
                        <div>
                            <span class="mono-label block mb-2">07 · KELULUSAN</span>
                            <h3 class="text-slate-800 font-bold text-sm">Dokumentasi Resmi</h3>
                        </div>
                        <div
                            id="holographic-cert"
                            class="certificate-card p-3 flex flex-col items-center justify-center text-center aspect-[4/3] w-full mt-1"
                        >
                            <div class="certificate-hologram" id="cert-glare"></div>
                            <svg class="w-7 h-7 text-amber-500 mb-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H7c0-2.76 2.24-5 5-5s5 2.24 5 5c0 1.04-.42 1.99-1.07 2.75z" />
                            </svg>
                            <span class="text-[10px] font-extrabold text-slate-800">E-Sertifikat Digital</span>
                            <span class="text-[8px] text-slate-400 font-mono mt-0.5">ID: CERT-MANDIRI-01</span>
                        </div>
                        <div class="pt-2">
                            <a
                                href="{{ route('login') }}"
                                class="text-xs font-bold text-rose-600 hover:text-rose-800 transition-colors inline-flex items-center gap-1 btn-star"
                            >
                                Unduh Dokumen
                                <span>→</span>
                            </a>
                        </div>
                    </article>
                    <article
                        class="card-bento span-2x1 gsap-reveal flex flex-col justify-between"
                        id="portal-mitra"
                        style="box-shadow: var(--shadow-clay)"
                    >
                        <div>
                            <span class="mono-label block mb-2">08 · MITRA INDUSTRI</span>
                            <h2 class="font-bold text-lg tracking-tight leading-snug mb-1">Kemitraan Aktif PKL</h2>
                            <p class="text-slate-500 text-xs leading-relaxed max-w-md">Kemitraan resmi dengan dunia usaha & industri (DUDI) untuk seluruh kompetensi keahlian.</p>
                        </div>
                        <div class="marquee-logo-container">
                            <div class="marquee-logo-track animate-marquee">
                                @foreach ($mitra_list as $mitra)
                                <div class="bg-white/80 py-2 px-3.5 rounded-xl border border-slate-200/80 shadow-sm text-center font-bold text-[9px] text-slate-700">
                                    {{ $mitra->nama_instansi }}
                                </div>
                                @endforeach
                                @foreach ($mitra_list as $mitra)
                                <div class="bg-white/80 py-2 px-3.5 rounded-xl border border-slate-200/80 shadow-sm text-center font-bold text-[9px] text-slate-700">
                                    {{ $mitra->nama_instansi }}
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </article>
                </div>
            </section>
        </main>
        <footer
            class="border-t"
            style="
                background-color: var(--color-paper-2);
                border-color: var(--color-border);
                color: var(--color-ink-muted);
            "
            aria-label="Footer"
        >
            <div class="max-w-7xl mx-auto px-6 py-12 md:py-16 grid grid-cols-1 md:grid-cols-4 gap-8 md:gap-12">
                <div class="col-span-1 md:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logosmk.png') }}" alt="Logo" class="w-12 h-12 object-contain" />
                        <div>
                            <h4
                                class="font-display font-extrabold text-base tracking-tight leading-tight"
                                style="color: var(--color-ink)"
                            >
                                SISTEM INFORMASI PKL
                            </h4>
                            <p
                                class="mono-label font-bold text-[10px] tracking-wider uppercase mt-0.5"
                                style="color: var(--color-ink-muted)"
                            >SMK Mandiri 01 Panongan</p>
                        </div>
                    </div>
                    <p
                        class="text-xs leading-relaxed max-w-sm"
                        style="color: var(--color-ink-muted)"
                    >Jl. Raya Panongan No.01, Kec. Panongan, Kabupaten Tangerang, Banten. Portal digital monitoring & verifikasi Praktik Kerja Lapangan (PKL) siswa.</p>
                </div>
                <div class="space-y-3">
                    <h5
                        class="text-[10px] font-extrabold tracking-widest uppercase font-mono"
                        style="color: var(--color-ink)"
                    >
                        Kompetensi Keahlian
                    </h5>
                    <ul class="text-xs space-y-2 font-medium" style="color: var(--color-ink-muted)">
                        <li>
                            <span class="hover:text-slate-900 transition-colors duration-150 cursor-pointer"
                                >Teknik Komputer & Jaringan (TKJ)</span
                            >
                        </li>
                        <li>
                            <span class="hover:text-slate-900 transition-colors duration-150 cursor-pointer"
                                >Teknik Kendaraan Ringan (TKR)</span
                            >
                        </li>
                        <li>
                            <span class="hover:text-slate-900 transition-colors duration-150 cursor-pointer"
                                >Desain Komunikasi Visual (DKV)</span
                            >
                        </li>
                        <li>
                            <span class="hover:text-slate-900 transition-colors duration-150 cursor-pointer"
                                >Manajemen Perkantoran (MP)</span
                            >
                        </li>
                    </ul>
                </div>
                <div class="space-y-3">
                    <h5
                        class="text-[10px] font-extrabold tracking-widest uppercase font-mono"
                        style="color: var(--color-ink)"
                    >
                        Hubungi Hubin
                    </h5>
                    <ul class="text-xs space-y-2 font-medium" style="color: var(--color-ink-muted)">
                        <li class="flex items-center gap-2">
                            <span>📞</span>
                            <span class="hover:text-slate-900 transition-colors duration-150">+62 812-3456-7890</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span>✉️</span>
                            <a
                                href="mailto:hubin@smkmandiri01.sch.id"
                                class="hover:text-slate-900 transition-colors duration-150"
                                >hubin@smkmandiri01.sch.id</a
                            >
                        </li>
                        <li class="flex items-center gap-2">
                            <span>🌐</span>
                            <a
                                href="https://smkmandiri01.sch.id"
                                target="_blank"
                                rel="noopener"
                                class="hover:text-slate-900 transition-colors duration-150"
                                >smkmandiri01.sch.id</a
                            >
                        </li>
                    </ul>
                </div>
            </div>
            <div
                class="border-t py-6 px-6"
                style="border-color: var(--color-border); background-color: var(--color-paper-3)"
            >
                <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-3">
                    <p
                        class="text-[10px] font-bold tracking-wide font-mono uppercase text-center md:text-left"
                        style="color: var(--color-ink-muted)"
                    >&copy; SMK Mandiri 01 Panongan · Hak Cipta Dilindungi.</p>
                    <p
                        class="text-[10px] font-bold tracking-wide font-mono uppercase text-center md:text-right"
                        style="color: var(--color-ink-muted)"
                    >Powered by Hubin Digital SI-PKL</p>
                </div>
            </div>
        </footer>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const nav = document.getElementById('nav-hum');
                window.addEventListener(
                    'scroll',
                    () => {
                        if (window.scrollY > 24) {
                            nav.classList.add('is-scrolled');
                        } else {
                            nav.classList.remove('is-scrolled');
                        }
                    },
                    { passive: true },
                );
                if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                    gsap.set('.gsap-reveal', { opacity: 1, y: 0 });
                } else {
                    gsap.fromTo(
                        '.gsap-reveal',
                        { opacity: 0, y: 30 },
                        { opacity: 1, y: 0, duration: 0.8, ease: 'power2.out', stagger: 0.1 },
                    );
                }
                const counters = document.querySelectorAll('.stat-count');
                const countUp = (el) => {
                    const target = parseInt(el.getAttribute('data-target'), 10);
                    let current = 0;
                    const duration = 1200; // ms
                    const startTime = performance.now();
                    const update = (now) => {
                        const progress = Math.min((now - startTime) / duration, 1);
                        const ease = 1 - Math.pow(2, -10 * progress); // easeOutExpo
                        const val = Math.floor(ease * target);
                        el.textContent = val;
                        if (progress < 1) {
                            requestAnimationFrame(update);
                        } else {
                            el.textContent = target;
                            const card = el.closest('.card-bento');
                            if (card) {
                                card.classList.add('pulse-celebrate');
                                setTimeout(() => card.classList.remove('pulse-celebrate'), 400);
                            }
                        }
                    };
                    requestAnimationFrame(update);
                };
                const obs = new IntersectionObserver(
                    (entries) => {
                        entries.forEach((e) => {
                            if (e.isIntersecting) {
                                countUp(e.target);
                                obs.unobserve(e.target);
                            }
                        });
                    },
                    { threshold: 0.2 },
                );
                counters.forEach((c) => obs.observe(c));
                document.addEventListener('click', (e) => {
                    const btn = e.target.closest('.btn, .btn-star');
                    if (btn) {
                        const rect = btn.getBoundingClientRect();
                        const star = document.createElement('div');
                        star.className = 'star-burst';
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;
                        star.style.left = `${x}px`;
                        star.style.top = `${y}px`;
                        btn.style.position = btn.style.position || 'relative';
                        btn.appendChild(star);
                        setTimeout(() => {
                            star.remove();
                        }, 450);
                    }
                });
                const typingLog = document.getElementById('autotyping-log');
                if (typingLog) {
                    const texts = [
                        'TKJ · Troubleshooting router Mikrotik & konfigurasi VLAN switch',
                        'TKR · Perbaikan sistem kelistrikan body & tune-up mesin EFI mobil',
                        'DKV · Desain infografis identitas visual & editing video marketing',
                        'MP · Pengarsipan surat masuk & penyusunan notulensi rapat pimpinan',
                    ];
                    let textIdx = 0;
                    let charIdx = 0;
                    let isDeleting = false;
                    function type() {
                        const currentText = texts[textIdx];
                        if (isDeleting) {
                            typingLog.textContent = currentText.substring(0, charIdx - 1);
                            charIdx--;
                        } else {
                            typingLog.textContent = currentText.substring(0, charIdx + 1);
                            charIdx++;
                        }
                        let delay = isDeleting ? 25 : 55;
                        if (!isDeleting && charIdx === currentText.length) {
                            delay = 2200; // Pause at end of text
                            isDeleting = true;
                        } else if (isDeleting && charIdx === 0) {
                            isDeleting = false;
                            textIdx = (textIdx + 1) % texts.length;
                            delay = 600; // Pause before starting next text
                        }
                        setTimeout(type, delay);
                    }
                    setTimeout(type, 1000);
                }
                const circle = document.getElementById('radial-progress-circle');
                if (circle) {
                    const progressObserver = new IntersectionObserver(
                        (entries) => {
                            entries.forEach((entry) => {
                                if (entry.isIntersecting) {
                                    circle.style.strokeDashoffset = '25.5';
                                    progressObserver.unobserve(entry.target);
                                }
                            });
                        },
                        { threshold: 0.1 },
                    );
                    progressObserver.observe(circle.closest('.card-bento'));
                }
                const mascotFace = document.getElementById('mascot-face-interactive');
                const speechBubble = document.getElementById('mascot-speech');
                const pupilLeft = document.getElementById('pupil-left');
                const pupilRight = document.getElementById('pupil-right');
                const mascotTile = document.getElementById('mascot-tile');
                if (mascotFace && pupilLeft && pupilRight) {
                    document.addEventListener('mousemove', (e) => {
                        const rect = mascotFace.getBoundingClientRect();
                        const faceX = rect.left + rect.width / 2;
                        const faceY = rect.top + rect.height / 2;
                        const angle = Math.atan2(e.clientY - faceY, e.clientX - faceX);
                        const distance = Math.min(4, Math.hypot(e.clientX - faceX, e.clientY - faceY) / 30);
                        const dx = Math.cos(angle) * distance;
                        const dy = Math.sin(angle) * distance;
                        pupilLeft.style.transform = `translate(${dx}px, ${dy}px)`;
                        pupilRight.style.transform = `translate(${dx}px, ${dy}px)`;
                    });
                    const quotes = [
                        'Sudahkah kamu mengisi laporan harian hari ini?',
                        'Aktivitas magang terpantau dengan aman!',
                        'Semangat belajar & kerja samanya, ya!',
                        'Jangan lupa verifikasi laporan ke guru!',
                        'PKL lancar, masa depan cemerlang!',
                        'Butuh bantuan? Silakan login terlebih dahulu.',
                    ];
                    let bubbleTimeout;
                    mascotFace.addEventListener('click', () => {
                        const randomQuote = quotes[Math.floor(Math.random() * quotes.length)];
                        speechBubble.textContent = randomQuote;
                        speechBubble.classList.add('is-visible');
                        const rect = mascotFace.getBoundingClientRect();
                        const cardRect = mascotTile.getBoundingClientRect();
                        const x = rect.left - cardRect.left + rect.width / 2;
                        const y = rect.top - cardRect.top + rect.height / 2;
                        createMascotParticles(x, y, mascotTile);
                        clearTimeout(bubbleTimeout);
                        bubbleTimeout = setTimeout(() => {
                            speechBubble.classList.remove('is-visible');
                        }, 2500);
                    });
                }
                function createMascotParticles(x, y, container) {
                    for (let i = 0; i < 8; i++) {
                        const p = document.createElement('div');
                        p.className = 'absolute w-1.5 h-1.5 rounded-full pointer-events-none z-30';
                        p.style.backgroundColor = [
                            'var(--color-accent-2)',
                            'var(--color-accent-3)',
                            'var(--color-mint)',
                        ][Math.floor(Math.random() * 3)];
                        p.style.left = `${x}px`;
                        p.style.top = `${y}px`;
                        container.appendChild(p);
                        const angle = Math.random() * Math.PI * 2;
                        const speed = 2 + Math.random() * 4;
                        const dx = Math.cos(angle) * speed;
                        const dy = Math.sin(angle) * speed;
                        let curX = x;
                        let curY = y;
                        let opacity = 1;
                        const anim = () => {
                            curX += dx;
                            curY += dy;
                            opacity -= 0.04;
                            p.style.left = `${curX}px`;
                            p.style.top = `${curY}px`;
                            p.style.opacity = opacity;
                            if (opacity > 0) {
                                requestAnimationFrame(anim);
                            } else {
                                p.remove();
                            }
                        };
                        requestAnimationFrame(anim);
                    }
                }
                const swipeCard = document.getElementById('interactive-swipe-card');
                const studentName = document.getElementById('swipe-student-name');
                const studentLog = document.getElementById('swipe-student-log');
                const btnRevisi = document.getElementById('btn-simulate-revisi');
                const btnSetujui = document.getElementById('btn-simulate-setujui');
                const swipeContainer = swipeCard ? swipeCard.closest('.swipe-card-container') : null;
                const indicatorLeft = swipeContainer ? swipeContainer.querySelector('.swipe-action-left') : null;
                const indicatorRight = swipeContainer ? swipeContainer.querySelector('.swipe-action-right') : null;
                if (swipeCard && swipeContainer) {
                    const students = [
                        { name: 'Ahmad Rifai (TKR)', log: 'Toyota Astra Motor · Tune-up mesin & kelistrikan bodi' },
                        { name: 'Dewi Lestari (MP)', log: 'PT Bank Mandiri · Tata kelola berkas & kearsipan digital' },
                        {
                            name: 'Rizky Saputra (DKV)',
                            log: 'Pixel Creative Agency · Ilustrasi maskot & video editing',
                        },
                        { name: 'Budi Santoso (TKJ)', log: 'Biznet Networks · Instalasi kabel FO & setup router core' },
                    ];
                    let currentStudentIdx = 0;
                    let startX = 0;
                    let currentX = 0;
                    let isDragging = false;
                    swipeCard.addEventListener('mousedown', (e) => {
                        if (e.target.closest('button')) return;
                        isDragging = true;
                        startX = e.clientX;
                        swipeCard.style.transition = 'none';
                    });
                    document.addEventListener('mousemove', (e) => {
                        if (!isDragging) return;
                        currentX = e.clientX - startX;
                        const dragOffset = currentX * 0.6;
                        swipeCard.style.transform = `translateX(${dragOffset}px) rotate(${dragOffset * 0.08}deg)`;
                        if (dragOffset > 0) {
                            if (indicatorRight) indicatorRight.style.opacity = Math.min(1, dragOffset / 50);
                            if (indicatorLeft) indicatorLeft.style.opacity = 0;
                        } else {
                            if (indicatorLeft) indicatorLeft.style.opacity = Math.min(1, -dragOffset / 50);
                            if (indicatorRight) indicatorRight.style.opacity = 0;
                        }
                    });
                    document.addEventListener('mouseup', () => {
                        if (!isDragging) return;
                        isDragging = false;
                        const dragOffset = currentX * 0.6;
                        if (dragOffset > 70) {
                            triggerAction(true);
                        } else if (dragOffset < -70) {
                            triggerAction(false);
                        } else {
                            resetCard();
                        }
                    });
                    swipeCard.addEventListener('touchstart', (e) => {
                        if (e.target.closest('button')) return;
                        isDragging = true;
                        startX = e.touches[0].clientX;
                        swipeCard.style.transition = 'none';
                    });
                    swipeCard.addEventListener('touchmove', (e) => {
                        if (!isDragging) return;
                        currentX = e.touches[0].clientX - startX;
                        const dragOffset = currentX * 0.6;
                        swipeCard.style.transform = `translateX(${dragOffset}px) rotate(${dragOffset * 0.08}deg)`;
                        if (dragOffset > 0) {
                            if (indicatorRight) indicatorRight.style.opacity = Math.min(1, dragOffset / 50);
                            if (indicatorLeft) indicatorLeft.style.opacity = 0;
                        } else {
                            if (indicatorLeft) indicatorLeft.style.opacity = Math.min(1, -dragOffset / 50);
                            if (indicatorRight) indicatorRight.style.opacity = 0;
                        }
                    });
                    swipeCard.addEventListener('touchend', () => {
                        if (!isDragging) return;
                        isDragging = false;
                        const dragOffset = currentX * 0.6;
                        if (dragOffset > 50) {
                            triggerAction(true);
                        } else if (dragOffset < -50) {
                            triggerAction(false);
                        } else {
                            resetCard();
                        }
                    });
                    btnSetujui.addEventListener('click', (e) => {
                        e.stopPropagation();
                        triggerAction(true);
                    });
                    btnRevisi.addEventListener('click', (e) => {
                        e.stopPropagation();
                        triggerAction(false);
                    });
                    function resetCard() {
                        swipeCard.style.transition = 'transform 300ms var(--ease-spring)';
                        swipeCard.style.transform = 'none';
                        if (indicatorLeft) indicatorLeft.style.opacity = 0;
                        if (indicatorRight) indicatorRight.style.opacity = 0;
                        currentX = 0;
                    }
                    function triggerAction(isApproved) {
                        swipeCard.style.transition = 'transform 300ms ease-in, opacity 300ms';
                        swipeCard.style.transform = `translateX(${isApproved ? 220 : -220}px) rotate(${isApproved ? 15 : -15}deg)`;
                        swipeCard.style.opacity = 0;
                        if (indicatorLeft) indicatorLeft.style.opacity = 0;
                        if (indicatorRight) indicatorRight.style.opacity = 0;
                        setTimeout(() => {
                            currentStudentIdx = (currentStudentIdx + 1) % students.length;
                            const nextStudent = students[currentStudentIdx];
                            studentName.textContent = nextStudent.name;
                            studentLog.textContent = nextStudent.log;
                            swipeCard.style.transition = 'none';
                            swipeCard.style.transform = `scale(0.9) translateY(10px)`;
                            swipeCard.style.opacity = 0;
                            swipeCard.offsetHeight; // force redraw
                            swipeCard.style.transition = 'transform 400ms var(--ease-spring), opacity 300ms';
                            swipeCard.style.transform = 'none';
                            swipeCard.style.opacity = 1;
                        }, 350);
                    }
                }
                const sidangRoom = document.getElementById('sidang-room');
                if (sidangRoom) {
                    const schedules = [
                        { room: 'LAB TKJ 1 (TKJ)', time: '12 Juni · Pukul: 09:00 WIB' },
                        { room: 'Bengkel Otomotif (TKR)', time: '13 Juni · Pukul: 08:30 WIB' },
                        { room: 'Studio DKV 2 (DKV)', time: '14 Juni · Pukul: 10:00 WIB' },
                        { room: 'LAB Perkantoran (MP)', time: '15 Juni · Pukul: 11:00 WIB' },
                    ];
                    let scheduleIdx = 0;
                    setInterval(() => {
                        scheduleIdx = (scheduleIdx + 1) % schedules.length;
                        sidangRoom.style.opacity = 0;
                        const timeEl = document.getElementById('sidang-time');
                        if (timeEl) timeEl.style.opacity = 0;
                        setTimeout(() => {
                            sidangRoom.textContent = schedules[scheduleIdx].room;
                            if (timeEl) timeEl.textContent = schedules[scheduleIdx].time;
                            sidangRoom.style.transition = 'opacity 300ms';
                            sidangRoom.style.opacity = 1;
                            if (timeEl) {
                                timeEl.style.transition = 'opacity 300ms';
                                timeEl.style.opacity = 1;
                            }
                        }, 300);
                    }, 4000);
                }
                const certContainer = document.getElementById('holographic-cert');
                const certGlare = document.getElementById('cert-glare');
                if (certContainer && certGlare) {
                    certContainer.addEventListener('mousemove', (e) => {
                        const rect = certContainer.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;
                        const px = x / rect.width - 0.5;
                        const py = y / rect.height - 0.5;
                        const rx = -py * 24;
                        const ry = px * 24;
                        certContainer.style.transform = `rotateX(${rx}deg) rotateY(${ry}deg) scale(1.03)`;
                        const percentageX = (x / rect.width) * 100;
                        const percentageY = (y / rect.height) * 100;
                        certGlare.style.backgroundPosition = `${percentageX}% ${percentageY}%`;
                    });
                    certContainer.addEventListener('mouseleave', () => {
                        certContainer.style.transform = 'none';
                        certGlare.style.backgroundPosition = '0% 0%';
                    });
                }
                const sliderTrack = document.getElementById('hero-slider-track');
                const btnPrev = document.getElementById('slider-prev');
                const btnNext = document.getElementById('slider-next');
                const sliderDots = document.querySelectorAll('.slider-dot');
                if (sliderTrack && btnPrev && btnNext) {
                    let slideIdx = 0;
                    const totalSlides = 2;
                    let slideStartX = 0;
                    let slideCurrentX = 0;
                    let isSlideDragging = false;
                    function updateSlider() {
                        sliderTrack.style.transition = 'transform 500ms cubic-bezier(0.25, 1, 0.5, 1)';
                        sliderTrack.style.transform = `translateX(-${slideIdx * 100}%)`;
                        sliderDots.forEach((dot, idx) => {
                            if (idx === slideIdx) {
                                dot.classList.add('is-active');
                            } else {
                                dot.classList.remove('is-active');
                            }
                        });
                    }
                    btnNext.addEventListener('click', () => {
                        slideIdx = (slideIdx + 1) % totalSlides;
                        updateSlider();
                    });
                    btnPrev.addEventListener('click', () => {
                        slideIdx = (slideIdx - 1 + totalSlides) % totalSlides;
                        updateSlider();
                    });
                    sliderDots.forEach((dot) => {
                        dot.addEventListener('click', () => {
                            slideIdx = parseInt(dot.getAttribute('data-index'), 10);
                            updateSlider();
                        });
                    });
                    sliderTrack.addEventListener('mousedown', (e) => {
                        isSlideDragging = true;
                        slideStartX = e.clientX;
                        sliderTrack.style.transition = 'none';
                    });
                    document.addEventListener('mousemove', (e) => {
                        if (!isSlideDragging) return;
                        slideCurrentX = e.clientX - slideStartX;
                        const offset = -slideIdx * sliderTrack.clientWidth + slideCurrentX;
                        sliderTrack.style.transform = `translateX(${offset}px)`;
                    });
                    document.addEventListener('mouseup', () => {
                        if (!isSlideDragging) return;
                        isSlideDragging = false;
                        const threshold = sliderTrack.clientWidth / 6;
                        if (slideCurrentX < -threshold) {
                            slideIdx = Math.min(totalSlides - 1, slideIdx + 1);
                        } else if (slideCurrentX > threshold) {
                            slideIdx = Math.max(0, slideIdx - 1);
                        }
                        updateSlider();
                        slideCurrentX = 0;
                    });
                    sliderTrack.addEventListener('touchstart', (e) => {
                        isSlideDragging = true;
                        slideStartX = e.touches[0].clientX;
                        sliderTrack.style.transition = 'none';
                    });
                    sliderTrack.addEventListener('touchmove', (e) => {
                        if (!isSlideDragging) return;
                        slideCurrentX = e.touches[0].clientX - slideStartX;
                        const offset = -slideIdx * sliderTrack.clientWidth + slideCurrentX;
                        sliderTrack.style.transform = `translateX(${offset}px)`;
                    });
                    sliderTrack.addEventListener('touchend', () => {
                        if (!isSlideDragging) return;
                        isSlideDragging = false;
                        const threshold = sliderTrack.clientWidth / 6;
                        if (slideCurrentX < -threshold) {
                            slideIdx = Math.min(totalSlides - 1, slideIdx + 1);
                        } else if (slideCurrentX > threshold) {
                            slideIdx = Math.max(0, slideIdx - 1);
                        }
                        updateSlider();
                        slideCurrentX = 0;
                    });
                    let autoSlideTimer = setInterval(() => {
                        slideIdx = (slideIdx + 1) % totalSlides;
                        updateSlider();
                    }, 8000);
                    const resetAutoSlide = () => {
                        clearInterval(autoSlideTimer);
                        autoSlideTimer = setInterval(() => {
                            slideIdx = (slideIdx + 1) % totalSlides;
                            updateSlider();
                        }, 8000);
                    };
                    btnPrev.addEventListener('click', resetAutoSlide);
                    btnNext.addEventListener('click', resetAutoSlide);
                    sliderDots.forEach((d) => d.addEventListener('click', resetAutoSlide));
                    sliderTrack.addEventListener('mousedown', resetAutoSlide);
                    sliderTrack.addEventListener('touchstart', resetAutoSlide);
                }
            });
        </script>
    </div>
@endsection

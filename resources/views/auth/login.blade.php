@extends ('layouts.guest')
@section ('styles')
    <style>
        :root {
            --font-body: 'Poppins';
            --font-display: 'Poppins';
            --font-label: 'Poppins';
            /* Clean Slate Theme Colors (OKLCH based) */
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
            --color-border: oklch(92% 0.005 240);
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
        /* Bento Grid Card */
        .card-bento {
            background: var(--color-paper-2);
            border: 2px solid var(--color-border);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-clay);
            transition: border-color 250ms ease-out, box-shadow 250ms ease-out;
        }
        .card-bento:hover {
            box-shadow: var(--shadow-clay-hover);
            border-color: var(--color-border);
        }
        /* Sleek Glassmorphism Card Style */
        .card-glass {
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1.5px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.04);
        }
        /* Form Inputs (Tactile Inset Shadow) */
        .input-academic {
            background: var(--color-paper-2);
            border: 1px solid var(--color-border);
            color: var(--color-ink);
            border-radius: var(--radius-input);
            outline: none;
            transition: all 250ms ease-out;
            box-shadow: none;
        }
        .input-academic::placeholder {
            color: #94a3b8;
        }
        .input-academic:focus {
            border-color: var(--color-border);
            box-shadow: none !important;
            outline: none !important;
            transform: translateY(-1px);
        }
        /* Button System (Chunky Push Feedback) */
        .btn {
            --btn-face: var(--color-accent);
            --btn-ink: #ffffff;
            --btn-edge: var(--color-accent-deep);
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
            transition: background-color 160ms, opacity 160ms;
            font-size: var(--text-sm);
        }
        .btn:hover {
            opacity: 0.9;
        }
        .btn:active {
            opacity: 0.8;
        }
        .mono-label {
            font-family: var(--font-label);
            font-size: 11px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--color-ink-muted);
            font-weight: 600;
        }
        /* Interactive Mascot (Signature #5 with Shy Mode & Speech Bubble) */
        #mascot-container {
            transition: all 300ms var(--ease-spring);
        }
        .mascot-face {
            width: 72px;
            height: 72px;
            background: oklch(84% 0.18 90); /* Yellow mascot background */
            border-radius: var(--radius-pill);
            border: 3px solid var(--color-ink);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow:
                0 8px 20px oklch(20% 0.012 250 / 0.15),
                inset -3px -3px 8px oklch(78% 0.18 95 / 0.5),
                inset 3px 3px 8px oklch(100% 0 0 / 0.8);
            cursor: pointer;
            transition: all 300ms var(--ease-spring);
        }
        .mascot-face:hover {
            background: oklch(76% 0.20 25); /* Red hover */
            transform: scale(1.1) rotate(8deg);
            box-shadow:
                0 12px 24px oklch(68% 0.24 25 / 0.3),
                inset -3px -3px 8px oklch(60% 0.24 25 / 0.5),
                inset 3px 3px 8px oklch(100% 0 0 / 0.8);
        }
        .mascot-eyes {
            display: flex;
            gap: 12px;
            margin-top: -4px;
            transition: all 200ms ease;
        }
        .mascot-eye {
            width: 12px;
            height: 12px;
            background: white;
            border: 2px solid var(--color-ink);
            border-radius: var(--radius-pill);
            position: relative;
            overflow: hidden;
            transition: all 200ms ease;
        }
        .mascot-pupil {
            width: 5px;
            height: 5px;
            background: var(--color-ink);
            border-radius: var(--radius-pill);
            position: absolute;
            top: 1.5px;
            left: 1.5px;
            transition: all 100ms ease-out;
        }
        .mascot-mouth {
            width: 18px;
            height: 8px;
            border-bottom: 3.5px solid var(--color-ink);
            border-radius: 0 0 10px 10px;
            margin-top: 8px;
            transition: all 200ms ease;
        }
        .mascot-face:hover .mascot-mouth {
            height: 12px;
            width: 12px;
            background: var(--color-ink);
            border-radius: var(--radius-pill);
        }
        /* Shy mode (when typing password) */
        .mascot-face.is-shy .mascot-eye {
            transform: scaleY(0.15);
            border-radius: 0;
            background: var(--color-ink);
            height: 3px;
            margin-top: 5px;
        }
        .mascot-face.is-shy .mascot-pupil {
            opacity: 0;
        }
        /* Mascot Hands */
        .mascot-hand {
            width: 22px;
            height: 22px;
            background: oklch(84% 0.18 90); /* Yellow hands background */
            border: 3px solid var(--color-ink);
            border-radius: var(--radius-pill);
            position: absolute;
            bottom: -6px;
            z-index: 10;
            transition: all 400ms var(--ease-spring);
            box-shadow: inset -2px -2px 5px oklch(78% 0.18 95 / 0.5), inset 2px 2px 5px oklch(100% 0 0 / 0.8);
        }
        .mascot-hand-left {
            left: -8px;
            transform: translateY(0) rotate(-15deg);
        }
        .mascot-hand-right {
            right: -8px;
            transform: translateY(0) rotate(15deg);
        }
        /* Shy mode: Hands cover eyes */
        .mascot-face.is-shy .mascot-hand-left {
            transform: translate(20px, -36px) scale(1.1) rotate(0deg);
        }
        .mascot-face.is-shy .mascot-hand-right {
            transform: translate(-20px, -36px) scale(1.1) rotate(0deg);
        }
        /* Speech Bubble */
        .speech-bubble {
            position: absolute;
            top: -36px;
            right: 0;
            background: white;
            border: 2px solid var(--color-ink);
            border-radius: 10px;
            padding: 4px 8px;
            font-size: 10px;
            font-weight: 800;
            color: var(--color-ink);
            white-space: nowrap;
            box-shadow: 3px 3px 0px var(--color-ink);
            opacity: 0;
            transform: scale(0.8) translateY(5px);
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
            bottom: -6px;
            left: 70%;
            transform: translateX(-50%) rotate(45deg);
            width: 8px;
            height: 8px;
            background: white;
            border-right: 2px solid var(--color-ink);
            border-bottom: 2px solid var(--color-ink);
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
        @keyframes star-burst-anim {
            0% {
                transform: translate(-50%, -50%) scale(0) rotate(0deg);
                opacity: 1;
            }
            60% {
                transform: translate(-50%, -50%) scale(1.2) rotate(35deg);
                opacity: 0.9;
            }
            100% {
                transform: translate(-50%, -50%) scale(1.4) rotate(45deg);
                opacity: 0;
            }
        }
    </style>
@endsection
@section ('content')
    <div class="antialiased min-h-screen w-full flex items-center justify-center p-4 sm:p-8 bg-[var(--color-paper)]">
        <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            <div
                class="hidden lg:flex lg:col-span-6 relative overflow-hidden card-bento p-0 aspect-[4/3] lg:aspect-auto min-h-[500px]"
            >
                <img
                    src="{{ asset('images/banner.png') }}"
                    class="absolute inset-0 w-full h-full object-cover opacity-90 transition-transform duration-700 hover:scale-105"
                    alt="School Banner"
                />
                <div
                    class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-slate-900/20 to-transparent mix-blend-multiply"
                ></div>
                <div
                    class="absolute bottom-6 left-6 right-6 p-6 rounded-2xl card-glass border border-white/20 backdrop-blur-md text-slate-800 z-10 shadow-lg"
                >
                    <div class="flex items-center gap-4">
                        <img
                            src="{{ asset('images/logosmk.png') }}"
                            alt="Logo SMK"
                            class="h-12 w-auto drop-shadow-md"
                        />
                        <div>
                            <h1 class="text-xl font-bold tracking-tight text-slate-900 leading-tight">
                                SISTEM INFORMASI PKL
                            </h1>
                            <p class="text-[11px] text-slate-600 font-semibold leading-relaxed mt-0.5">SMK Mandiri 01 Panongan</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full lg:col-span-6 flex items-center justify-center relative">
                <div
                    class="w-full max-w-md card-bento bg-white p-8 md:p-10 auth-container opacity-0 scale-95 relative"
                    style="background-color: var(--color-paper-2)"
                >
                    <div
                        class="absolute -top-[52px] right-8 w-20 h-20 select-none pointer-events-auto z-40 hidden sm:block"
                        id="mascot-container"
                    >
                        <div class="speech-bubble" id="mascot-speech">Hai! Siap masuk?</div>
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
                            <div class="mascot-hand mascot-hand-left" id="hand-left"></div>
                            <div class="mascot-hand mascot-hand-right" id="hand-right"></div>
                        </div>
                    </div>
                    <a
                        href="/"
                        class="absolute top-6 right-6 text-[10px] font-bold mono-label hover:text-rose-500 transition-colors"
                    >
                        ← Kembali
                    </a>
                    <div class="text-left mb-8 mt-2">
                        <h2 class="text-2xl font-bold tracking-tight leading-snug mb-2">Selamat Datang</h2>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">Silakan masukkan akun Anda untuk mengakses sistem informasi PKL.</p>
                    </div>
                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf
                        <div class="form-group opacity-0 translate-y-4">
                            <label
                                for="email"
                                class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-2"
                                >Email Akun</label
                            >
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                class="input-academic w-full px-4 py-3 text-sm outline-none"
                                placeholder="alamat@email.com"
                            />
                            @error ('email')
                                <p class="text-xs text-rose-600 mt-2 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group opacity-0 translate-y-4">
                            <label
                                for="password"
                                class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-2"
                                >Kata Sandi</label
                            >
                            <div class="relative">
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    class="input-academic w-full px-4 py-3 text-sm outline-none pr-10"
                                    placeholder="••••••••"
                                />
                                <button
                                    type="button"
                                    onclick="togglePassword()"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none"
                                >
                                    <svg id="eye-icon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            @error ('password')
                                <p class="text-xs text-rose-600 mt-2 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group opacity-0 translate-y-4 flex items-center justify-between mt-6">
                            <label for="remember_me" class="flex items-center cursor-pointer group select-none">
                                <input
                                    id="remember_me"
                                    type="checkbox"
                                    name="remember"
                                    class="w-4 h-4 rounded border-slate-300 text-slate-800 focus:ring-slate-800 cursor-pointer"
                                />
                                <span
                                    class="ml-2 text-xs text-slate-500 font-semibold group-hover:text-slate-900 transition-colors"
                                    >Ingat sesi saya</span
                                >
                            </label>
                        </div>
                        <div class="form-group opacity-0 translate-y-4 mt-6">
                            <button type="submit" class="w-full btn">Masuk Sistem</button>
                        </div>
                    </form>
                    <p class="text-center text-[10px] mono-label text-slate-400 mt-10">&copy; Sistem Informasi PKL SMK MANDIRI 01 PANONGAN.</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const mascotFace = document.getElementById('mascot-face-interactive');
            const speechBubble = document.getElementById('mascot-speech');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />`;
                mascotFace.classList.add('is-shy');
                speechBubble.textContent = 'Waduh, kelihatan! 🙈';
                speechBubble.classList.add('is-visible');
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
                mascotFace.classList.remove('is-shy');
                speechBubble.textContent = 'Tenang, aman terjaga! 🫡';
                if (document.activeElement !== passwordInput) {
                    speechBubble.classList.remove('is-visible');
                }
            }
        }
        document.addEventListener('DOMContentLoaded', () => {
            const tl = gsap.timeline();
            tl.to('.auth-container', {
                opacity: 1,
                scale: 1,
                duration: 0.6,
                ease: 'power2.out',
            }).to(
                '.form-group',
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.4,
                    stagger: 0.08,
                    ease: 'power2.out',
                },
                '-=0.2',
            );
            document.addEventListener('click', (e) => {
                const btn = e.target.closest('.btn');
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
            const mascotContainer = document.getElementById('mascot-container');
            const mascotFace = document.getElementById('mascot-face-interactive');
            const speechBubble = document.getElementById('mascot-speech');
            const pupilLeft = document.getElementById('pupil-left');
            const pupilRight = document.getElementById('pupil-right');
            const passwordInput = document.getElementById('password');
            if (mascotFace && pupilLeft && pupilRight) {
                document.addEventListener('mousemove', (e) => {
                    if (mascotFace.classList.contains('is-shy')) return;
                    const rect = mascotFace.getBoundingClientRect();
                    const faceX = rect.left + rect.width / 2;
                    const faceY = rect.top + rect.height / 2;
                    const angle = Math.atan2(e.clientY - faceY, e.clientX - faceX);
                    const distance = Math.min(3, Math.hypot(e.clientX - faceX, e.clientY - faceY) / 40);
                    const dx = Math.cos(angle) * distance;
                    const dy = Math.sin(angle) * distance;
                    pupilLeft.style.transform = `translate(${dx}px, ${dy}px)`;
                    pupilRight.style.transform = `translate(${dx}px, ${dy}px)`;
                });
                if (passwordInput) {
                    passwordInput.addEventListener('focus', () => {
                        if (passwordInput.type === 'text') {
                            mascotFace.classList.add('is-shy');
                            speechBubble.textContent = 'Waduh, kelihatan! 🙈';
                        } else {
                            mascotFace.classList.remove('is-shy');
                            speechBubble.textContent = 'Tenang, aman terjaga! 🫡';
                        }
                        speechBubble.classList.add('is-visible');
                    });
                    passwordInput.addEventListener('blur', () => {
                        if (passwordInput.type !== 'text') {
                            mascotFace.classList.remove('is-shy');
                            speechBubble.classList.remove('is-visible');
                        } else {
                            setTimeout(() => {
                                if (document.activeElement !== passwordInput && passwordInput.type === 'text') {
                                    speechBubble.classList.remove('is-visible');
                                }
                            }, 2000);
                        }
                        pupilLeft.style.transform = 'translate(0px, 0px)';
                        pupilRight.style.transform = 'translate(0px, 0px)';
                    });
                }
                const quotes = [
                    'Sudahkah kamu mengisi laporan harian hari ini?',
                    'Aktivitas magang terpantau dengan aman!',
                    'Semangat belajar & kerja samanya, ya!',
                    'Jangan lupa verifikasi laporan ke guru!',
                    'PKL lancar, masa depan cemerlang!',
                    'Butuh bantuan? Tanyakan ke admin ya!',
                ];
                let bubbleTimeout;
                mascotFace.addEventListener('click', () => {
                    if (mascotFace.classList.contains('is-shy')) return;
                    const randomQuote = quotes[Math.floor(Math.random() * quotes.length)];
                    speechBubble.textContent = randomQuote;
                    speechBubble.classList.add('is-visible');
                    const rect = mascotFace.getBoundingClientRect();
                    const containerRect = mascotContainer.getBoundingClientRect();
                    const x = rect.left - containerRect.left + rect.width / 2;
                    const y = rect.top - containerRect.top + rect.height / 2;
                    createMascotParticles(x, y, mascotContainer);
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
                    p.style.backgroundColor = ['var(--color-accent-2)', 'var(--color-accent-3)', 'var(--color-mint)'][
                        Math.floor(Math.random() * 3)
                    ];
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
        });
    </script>
@endsection

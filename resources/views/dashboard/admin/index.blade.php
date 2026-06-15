@extends ('layouts.app')

@section ('content')
    @section ('header')
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ __('Admin Dashboard') }}</h2>
    @endsection
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <!-- Bento Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Welcome Banner (Col Span 2) -->
                <div
                    class="md:col-span-2 bg-white border border-slate-300 rounded-xl p-6 flex flex-col justify-between relative overflow-hidden"
                >
                    <div class="relative z-10 w-full">
                        <h2 class="text-3xl font-extrabold text-slate-900 mb-4 tracking-tight font-display">
                            Halo, {{ Auth::user()->name }}
                        </h2>
                        <p class="text-slate-500 text-sm leading-relaxed mb-8 text-justify">Selamat datang di portal manajemen PKL SMK Mandiri 01 Panongan. Kelola siswa, pembimbing, penguji, dan tempat PKL dengan mudah melalui sistem bento terpusat ini.</p>
                    </div>
                </div>

                <!-- Clock & Info (Col Span 1) -->
                <div
                    class="bg-white border border-slate-300 rounded-xl p-6 flex flex-col justify-between relative overflow-hidden"
                >
                    <div>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-2"
                            >WAKTU AKTIF</span
                        >
                        <h3 class="text-4xl font-extrabold text-slate-900 tracking-tight font-label" id="clock-display">
                            00:00:00
                        </h3>
                        <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mt-1" id="date-display">SABTU, 6 JUNI 2026</p>
                    </div>
                </div>

                <!-- Bento Row 2: Stats cards -->
                <a
                    href="{{ route('admin.siswa.index') }}"
                    class="group bg-white hover:bg-slate-50 transition-colors border border-slate-300 rounded-xl p-6 flex flex-col justify-between relative overflow-hidden"
                >
                    <div class="mt-8">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-1"
                            >TOTAL SISWA PKL</span
                        >
                        <h4 class="text-5xl font-extrabold text-slate-900 tracking-tight font-label">
                            {{ $siswa_count }}
                        </h4>
                        <p class="text-slate-500 text-xs mt-2 font-medium group-hover:text-blue-700 transition-colors">Kelola direktori siswa &rarr;</p>
                    </div>
                </a>

                <a
                    href="{{ route('admin.guru-pembimbing.index') }}"
                    class="group bg-white hover:bg-slate-50 transition-colors border border-slate-300 rounded-xl p-6 flex flex-col justify-between relative overflow-hidden"
                >
                    <div class="mt-8">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-1"
                            >GURU PEMBIMBING</span
                        >
                        <h4 class="text-5xl font-extrabold text-slate-900 tracking-tight font-label">
                            {{ $pembimbing_count }}
                        </h4>
                        <p class="text-slate-500 text-xs mt-2 font-medium group-hover:text-emerald-700 transition-colors">Alokasi & kelola pembimbing &rarr;</p>
                    </div>
                </a>

                <a
                    href="{{ route('admin.guru-penguji.index') }}"
                    class="group bg-white hover:bg-slate-50 transition-colors border border-slate-300 rounded-xl p-6 flex flex-col justify-between relative overflow-hidden"
                >
                    <div class="mt-8">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-1"
                            >GURU PENGUJI</span
                        >
                        <h4 class="text-5xl font-extrabold text-slate-900 tracking-tight font-label">
                            {{ $penguji_count }}
                        </h4>
                        <p class="text-slate-500 text-xs mt-2 font-medium group-hover:text-purple-700 transition-colors">Kelola penguji sidang &rarr;</p>
                    </div>
                </a>

                <a
                    href="{{ route('admin.tempat-pkl.index') }}"
                    class="group bg-white hover:bg-slate-50 transition-colors border border-slate-300 rounded-xl p-6 flex flex-col justify-between relative overflow-hidden md:col-span-3 lg:col-span-1"
                >
                    <div class="mt-8">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-1"
                            >MITRA TEMPAT PKL</span
                        >
                        <h4 class="text-5xl font-extrabold text-slate-900 tracking-tight font-label">
                            {{ $tempat_pkl_count }}
                        </h4>
                        <p class="text-slate-500 text-xs mt-2 font-medium group-hover:text-amber-700 transition-colors">Kelola instansi & kuota &rarr;</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- Clock Update Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const clock = document.getElementById('clock-display');
            const dateDisplay = document.getElementById('date-display');

            function updateClock() {
                const now = new Date();
                clock.textContent = now.toTimeString().split(' ')[0];

                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                dateDisplay.textContent = now.toLocaleDateString('id-ID', options);
            }

            updateClock();
            setInterval(updateClock, 1000);
        });
    </script>
@endsection

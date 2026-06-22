@extends ('layouts.app')
@section ('content')
    @section ('header')
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ __('Mengisi Laporan Harian PKL') }}</h2>
    @endsection
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-slate-900 font-display">Mengisi Laporan Harian PKL</h2>
                <p class="text-slate-500 text-sm mt-1">Catat seluruh aktivitas harian magang Anda secara berkala beserta dokumentasi foto pendukung.</p>
            </div>
            @if (!$pengajuan_disetujui)
                <div class="bg-amber-50 border-2 border-amber-200 rounded-3xl p-8 text-center shadow-md">
                    <div
                        class="w-16 h-16 bg-amber-50 border border-amber-200 rounded-full flex items-center justify-center mx-auto mb-4"
                    >
                        <i class="fa-solid fa-lock text-amber-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 font-display">Fitur Terkunci</h3>
                    <p class="text-slate-500 text-sm mt-2 max-w-md mx-auto leading-relaxed">Pengisian laporan harian hanya dapat diakses setelah pengajuan tempat PKL Anda <strong>Disetujui</strong> oleh Guru Pembimbing. Silakan ajukan terlebih dahulu.</p>
                    <div class="mt-6">
                        <a
                            href="{{ route('siswa.pengajuan.index') }}"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-sm font-bold transition-colors"
                        >
                            Pergi ke Mengajukan PKL
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            @else
                <div class="space-y-12">
                    @if ($laporan_akhir_exists)
                        <div class="bg-white border-2 border-slate-200 p-8 rounded-3xl text-center py-12 shadow-sm">
                            <div
                                class="w-14 h-14 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-4 text-slate-400 border-2 border-slate-200"
                            >
                                <i class="fa-solid fa-lock text-slate-400 text-xl"></i>
                            </div>
                            <h4 class="font-extrabold text-slate-800 text-base">Laporan Harian Terkunci</h4>
                            <p class="text-xs text-slate-500 mt-3 leading-relaxed">Anda telah mengumpulkan **Laporan Akhir**. Secara administrasi, pengisian laporan harian telah ditutup secara permanen.</p>
                        </div>
                    @endif
                    <div class="border-b-2 border-slate-200">
                        <nav class="-mb-[2px] flex space-x-8" aria-label="Tabs">
                            <a href="?tab=tracking" class="{{ $tab == 'tracking' ? 'border-slate-900 text-slate-900' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors">
                                <i class="fa-solid fa-calendar-days mr-2"></i>Kalender Harian
                            </a>
                            <a href="?tab=riwayat" class="{{ $tab == 'riwayat' ? 'border-slate-900 text-slate-900' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors">
                                <i class="fa-solid fa-list-ul mr-2"></i>Riwayat Laporan
                            </a>
                        </nav>
                    </div>
                    <div class="space-y-6">
                        @if ($tab == 'tracking')
                            <div>
                            <div class="flex items-center justify-between mb-4 px-1">
                                <h3 class="font-bold text-slate-800 text-lg">Riwayat Laporan Harian</h3>
                                <span
                                    class="text-xs font-semibold text-slate-500"
                                    >{{ count($dates) }} Hari Berjalan</span
                                >
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                                @forelse ($dates as $date)
                                    @php
                                        $dateStr = $date->format('Y-m-d');
                                        $logs = $laporansGrouped->get($dateStr, collect());
                                        $isToday = $date->isToday();
                                        $isPast = $date->isPast() && !$isToday;
                                    @endphp
                                    <div
                                        class="bg-white rounded-3xl border-2 border-slate-200 p-5 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col h-full"
                                    >
                                        <div class="flex justify-between items-center mb-4">
                                            <h4 class="font-bold text-slate-800 text-base">
                                                {{ $date->locale('id')->isoFormat('dddd, D MMM Y') }}
                                            </h4>
                                        </div>
                                        <div class="flex-grow flex flex-col">
                                            @if ($logs->isNotEmpty())
                                                <details class="group mb-6">
                                                    <summary
                                                        class="text-sm font-bold text-slate-700 flex justify-between items-center cursor-pointer list-none select-none hover:text-slate-900 transition-colors"
                                                        style="list-style: none"
                                                    >
                                                        <div class="flex items-center gap-2">
                                                            Daftar kegiatan
                                                            <span class="text-slate-400 text-xs font-medium"
                                                                >({{ $logs->count() }})</span
                                                            >
                                                        </div>
                                                        <span
                                                            class="transition-transform duration-300 group-open:rotate-180 text-slate-400"
                                                        >
                                                            <i class="fa-solid fa-chevron-down text-xs"></i>
                                                        </span>
                                                    </summary>
                                                    <div class="mt-3 max-h-40 overflow-y-auto pr-2 space-y-2">
                                                        <ul class="text-sm text-slate-600 space-y-3">
                                                            @foreach ($logs as $log)
                                                                <li class="relative pl-4 break-words leading-relaxed">
                                                                    <span
                                                                        class="absolute left-0 top-2 w-1.5 h-1.5 bg-slate-300 rounded-full"
                                                                    ></span>
                                                                    {{ $log->kegiatan }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </details>
                                            @else
                                                <div
                                                    class="text-sm font-bold text-slate-700 mb-2 flex justify-between items-center"
                                                >
                                                    Daftar kegiatan
                                                </div>
                                                <div class="text-sm text-slate-400 italic mb-6">
                                                    Belum ada kegiatan.
                                                </div>
                                            @endif
                                        </div>
                                        <div class="mt-auto">
                                            @if ($laporan_akhir_exists)
                                                <button
                                                    disabled
                                                    class="w-full bg-slate-200 text-slate-400 px-4 py-2.5 rounded-xl text-xs font-bold flex items-center justify-center gap-2 cursor-not-allowed"
                                                >
                                                    LENGKAPI LAPORAN
                                                </button>
                                            @elseif ($isPast)
                                                @if ($logs->isNotEmpty())
                                                    <button
                                                        disabled
                                                        class="w-full bg-slate-200 text-slate-400 px-4 py-2.5 rounded-xl text-xs font-bold flex items-center justify-center gap-2 cursor-not-allowed"
                                                    >
                                                        LENGKAPI LAPORAN
                                                    </button>
                                                @else
                                                    <button
                                                        disabled
                                                        class="w-full bg-red-50 text-red-400 border border-red-100 px-4 py-2.5 rounded-xl text-xs font-bold flex items-center justify-center gap-2 cursor-not-allowed"
                                                    >
                                                        TERLEWAT
                                                    </button>
                                                @endif
                                            @else
                                                <a
                                                    href="{{ route('siswa.jurnal-harian.create') }}"
                                                    class="w-full bg-slate-900 hover:bg-slate-800 text-white px-4 py-2.5 rounded-xl text-xs font-bold flex items-center justify-center gap-2 transition-colors duration-200 shadow-sm"
                                                >
                                                    LENGKAPI LAPORAN
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div
                                        class="col-span-full bg-white rounded-3xl border-2 border-slate-200 p-12 text-center text-slate-500 shadow-sm"
                                    >
                                        <i class="fa-solid fa-book-open text-slate-300 text-4xl mb-3 block"></i>
                                        <h4 class="text-slate-900 font-bold mb-1">Belum Ada Hari Berjalan</h4>
                                        <p class="text-sm font-medium text-slate-400">Pengajuan Anda mungkin belum disetujui atau belum ada hari berjalan sejak disetujui.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        @elseif ($tab == 'riwayat')
                            <div class="space-y-6">
                                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
                                    <form action="{{ route('siswa.jurnal-harian.index') }}" method="GET" class="relative w-full max-w-md">
                                        <input type="hidden" name="tab" value="riwayat">
                                        <input
                                            type="text"
                                            name="search"
                                            value="{{ request('search') }}"
                                            placeholder="Cari kegiatan atau tanggal..."
                                            class="w-full pl-10 pr-4 py-2 border border-slate-100 rounded-xl focus:border-slate-300 text-sm bg-white shadow-sm"
                                        />
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                            <i class="fa-solid fa-magnifying-glass text-slate-400"></i>
                                        </div>
                                    </form>
                                    <div class="flex items-center gap-4">
                                        <span class="text-xs font-semibold text-slate-500">{{ $laporans->total() ?? 0 }} Laporan Terkirim</span>
                                        <a href="{{ route('siswa.jurnal-harian.export') }}" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-sm font-bold transition-colors shadow-sm inline-flex items-center gap-2">
                                            <i class="fa-solid fa-file-pdf"></i> Export PDF
                                        </a>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @forelse ($laporans as $log)
                                        <div class="bg-white rounded-3xl border-2 border-slate-200 p-5 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col h-full">
                                            <div class="flex justify-between items-center mb-4">
                                                <h4 class="font-bold text-slate-800 text-base">{{ \Carbon\Carbon::parse($log->tanggal)->locale('id')->isoFormat('dddd, D MMM Y') }}</h4>
                                                <span class="text-[11px] text-slate-400 font-medium">{{ $log->created_at->format('H:i') }} WIB</span>
                                            </div>
                                            <div class="flex-grow flex flex-col">
                                                <div class="text-sm font-bold text-slate-700 mb-2">Detail Kegiatan</div>
                                                <div class="text-sm text-slate-600 mb-6 whitespace-pre-wrap">{{ $log->kegiatan }}</div>
                                            </div>
                                            @if ($log->bukti_foto)
                                                <div class="mb-4 rounded-2xl overflow-hidden border-2 border-slate-200 bg-slate-50">
                                                    <a href="{{ Storage::url($log->bukti_foto) }}" target="_blank" class="block">
                                                        <img
                                                            src="{{ Storage::url($log->bukti_foto) }}"
                                                            alt="Bukti foto kegiatan"
                                                            class="w-full h-44 object-cover hover:opacity-90 transition-opacity cursor-pointer"
                                                            loading="lazy"
                                                        />
                                                    </a>
                                                </div>
                                            @endif
                                            <div class="mt-auto pt-4 border-t border-slate-100">
                                                @if (!$laporan_akhir_exists)
                                                    <div class="flex gap-2">
                                                        <a href="{{ route('siswa.jurnal-harian.edit', $log->id) }}" class="flex-1 bg-amber-50 hover:bg-amber-100 border border-amber-200 text-amber-700 px-4 py-2.5 rounded-xl text-xs font-bold flex items-center justify-center gap-2 transition-colors">
                                                            <i class="fa-solid fa-pen"></i> Edit
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-span-full bg-white rounded-3xl border-2 border-slate-200 p-12 text-center text-slate-500 shadow-sm">
                                            <i class="fa-solid fa-file-circle-xmark text-slate-300 text-4xl mb-3 block"></i>
                                            <h4 class="text-slate-900 font-bold mb-1">Riwayat Kosong</h4>
                                            <p class="text-sm font-medium text-slate-400">Tidak ada riwayat laporan yang ditemukan.</p>
                                        </div>
                                    @endforelse
                                </div>
                                @if ($laporans->hasPages())
                                    <div class="mt-6">
                                        {{ $laporans->appends(['tab' => 'riwayat', 'search' => request('search')])->links() }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

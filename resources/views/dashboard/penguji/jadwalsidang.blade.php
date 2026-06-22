@extends ('layouts.app')
@section ('content')
    @section ('header')
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ __('Jadwal Sidang') }}</h2>
    @endsection
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-slate-900 font-display">Jadwal Sidang Siswa</h2>
                <p class="text-slate-500 text-base mt-2">Daftar waktu dan tempat ujian presentasi siswa yang akan Anda uji.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($jadwals as $jadwal)
                    <div
                        class="bg-white p-6 rounded-3xl border-2 border-slate-200 transition-colors shadow-sm flex flex-col gap-4 relative overflow-hidden group"
                    >
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-12 h-12 rounded-full bg-purple-50 text-purple-700 flex items-center justify-center font-bold text-lg border border-purple-100 shrink-0"
                                >
                                    {{ substr($jadwal->siswa->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 text-base leading-tight">
                                        {{ $jadwal->siswa->user->name }}
                                    </h3>
                                    <p class="text-xs text-slate-500 font-medium mt-1">NISN: {{ $jadwal->siswa->nisn }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 mt-2">
                            <div class="flex items-center gap-3 mb-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-white flex items-center justify-center shadow-sm text-slate-400 shrink-0"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider mb-0.5">Tanggal</p>
                                    <p class="text-sm font-bold text-slate-700">{{
                                        \Carbon\Carbon::parse($jadwal->waktu)->isoFormat(
                                            'dddd, D MMM Y',
                                        )
                                    }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 mb-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-white flex items-center justify-center shadow-sm text-slate-400 shrink-0"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider mb-0.5">Waktu</p>
                                    <p class="text-sm font-bold text-slate-700">{{ \Carbon\Carbon::parse($jadwal->waktu)->isoFormat('HH:mm') }} WIB</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 mb-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-white flex items-center justify-center shadow-sm text-slate-400 shrink-0"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider mb-0.5">Ruangan</p>
                                    <p class="text-sm font-bold text-slate-700">{{ $jadwal->ruangan }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-white flex items-center justify-center shadow-sm text-slate-400 shrink-0"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider mb-0.5">Pembimbing</p>
                                    <p class="text-sm font-bold text-slate-700">{{ $jadwal->pembimbing->user->name ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div
                            class="bg-white p-10 rounded-3xl border-2 border-slate-200 text-center flex flex-col items-center justify-center shadow-sm"
                        >
                            <div
                                class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4"
                            >
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <h4 class="text-slate-900 font-bold text-lg mb-1">Belum Ada Jadwal</h4>
                            <p class="text-slate-500 max-w-sm mx-auto">Saat ini belum ada siswa yang dijadwalkan untuk sidang presentasi dengan Anda.</p>
                        </div>
                    </div>
                @endforelse
            </div>
            @if ($jadwals->hasPages())
                <div class="mt-6 p-4 bg-white rounded-2xl border-2 border-slate-200 shadow-sm">
                    {{ $jadwals->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

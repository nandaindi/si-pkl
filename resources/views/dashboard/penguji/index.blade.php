@extends ('layouts.app')
@section ('content')
    @section ('header')
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ __('Dashboard Guru Penguji') }}</h2>
    @endsection
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2 bg-white border border-slate-100 rounded-xl p-6 flex flex-col justify-center relative overflow-hidden">
                    <div class="relative z-10 w-full">
                        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight font-display">
                            Halo, {{ Auth::user()->name }}
                        </h2>
                        <p class="text-slate-500 text-sm mt-2">Selamat datang di Panel Guru Penguji.</p>
                    </div>
                </div>
                <div class="bg-white border border-slate-100 rounded-xl p-6 flex flex-col justify-center relative overflow-hidden">
                    <div class="relative z-10 w-full">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-3">Informasi Pegawai</span>
                        @if ($guru)
                            <div class="space-y-2 text-sm text-slate-600">
                                <div class="flex justify-between"><span class="text-slate-400">NIP/NUPTK:</span> <span class="font-bold text-slate-800 font-label">{{ $guru->nip ?? '-' }}</span></div>
                            </div>
                        @else
                            <p class="text-rose-600 text-xs font-semibold">Profil belum dibuat.</p>
                        @endif
                    </div>
                </div>

                <div
                    class="md:col-span-2 bg-white border border-slate-100 rounded-xl p-6 flex flex-col justify-between relative overflow-hidden"
                >
                    <div>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-2"
                            >PENGUJIAN SIDANG</span
                        >
                        <h3 class="text-4xl font-extrabold text-slate-900 tracking-tight font-label">
                            {{ $ujian_sidang_count }}
                        </h3>
                        <p class="text-slate-500 text-xs mt-2 font-medium text-justify">Jumlah siswa yang dijadwalkan untuk diuji oleh Anda pada sidang laporan akhir PKL.</p>
                    </div>
                </div>
                <div
                    class="bg-white border border-slate-100 rounded-xl p-6 flex flex-col justify-between relative overflow-hidden"
                >
                    <div>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-2"
                            >KOMPONEN PENILAIAN</span
                        >
                        <h4 class="text-lg font-extrabold text-slate-900 leading-snug">Aspek Sidang Laporan:</h4>
                        <ul class="text-slate-500 text-xs mt-3 space-y-1.5 list-disc pl-4 font-medium">
                            <li>Kerapian Penulisan Laporan PKL</li>
                            <li>Kesesuaian Materi & Kompetensi</li>
                            <li>Kemampuan Presentasi & Tanya Jawab</li>
                            <li>Sikap & Penampilan selama Sidang</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

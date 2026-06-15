@extends ('layouts.app')

@section ('content')
    @section ('header')
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ __('Jadwal Sidang PKL') }}</h2>
    @endsection
    <div class="py-6">
        <div class="max-w-4xl mx-auto space-y-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 font-display">Jadwal Sidang PKL</h2>
                <p class="text-slate-500 text-sm mt-1">Informasi jadwal presentasi laporan akhir PKL Anda.</p>
            </div>

            @if ($jadwal_sidang)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white border border-slate-200 rounded-xl p-5">
                        <p class="text-xs text-slate-400 uppercase tracking-wider mb-2">Hari & Tanggal</p>
                        <p class="text-base font-bold text-slate-900 leading-tight">
                            {{ \Carbon\Carbon::parse($jadwal_sidang->waktu)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                        </p>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-xl p-5">
                        <p class="text-xs text-slate-400 uppercase tracking-wider mb-2">Waktu Mulai</p>
                        <p class="text-base font-bold text-slate-900">
                            {{ \Carbon\Carbon::parse($jadwal_sidang->waktu)->isoFormat('HH:mm') }} WIB
                        </p>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-xl p-5">
                        <p class="text-xs text-slate-400 uppercase tracking-wider mb-2">Ruangan</p>
                        <p class="text-xl font-bold text-slate-900">{{ $jadwal_sidang->ruangan }}</p>
                    </div>
                </div>
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tim Akademik</p>
                    </div>
                    <div class="divide-y divide-slate-100">
                        <div class="px-6 py-4">
                            <p class="text-xs text-slate-400 mb-1">Guru Pembimbing</p>
                            <p class="text-sm font-semibold text-slate-900">{{ $jadwal_sidang->pembimbing->user->name }}</p>
                        </div>
                        <div class="px-6 py-4">
                            <p class="text-xs text-slate-400 mb-1">Guru Penguji</p>
                            <p class="text-sm font-semibold text-slate-900">{{ $jadwal_sidang->penguji->user->name }}</p>
                        </div>
                    </div>
                </div>

            @else
                <div class="bg-white border border-slate-200 rounded-xl p-12 text-center">
                    <i class="fa-regular fa-calendar-xmark text-slate-300 text-5xl mb-4 block"></i>
                    <h3 class="text-lg font-bold text-slate-800 font-display">Belum Ada Jadwal Sidang</h3>
                    <p class="text-slate-500 text-sm mt-2 max-w-sm mx-auto leading-relaxed">Jadwal sidang PKL Anda belum ditetapkan oleh panitia. Jadwal akan muncul di sini setelah laporan akhir Anda disetujui oleh guru pembimbing.</p>
                </div>

            @endif
        </div>
    </div>
@endsection

@extends ('layouts.app')
@section ('content')
    @section ('header')
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ __('Dashboard Guru Pembimbing') }}</h2>
    @endsection
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div
                    class="md:col-span-2 bg-white border border-slate-300 rounded-xl p-6 flex flex-col justify-between relative overflow-hidden"
                >
                    <div class="relative z-10 w-full">
                        <h2 class="text-3xl font-extrabold text-slate-900 mb-4 tracking-tight font-display">
                            Halo, {{ Auth::user()->name }}
                        </h2>
                        @if ($guru)
                            <div class="mt-6 border-t border-slate-100 pt-6">
                                <div class="inline-flex flex-col bg-slate-50/70 border border-slate-200/60 rounded-xl px-4 py-3">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">NIP / NUPTK</span>
                                    <span class="text-sm font-extrabold text-slate-800 mt-1 font-label">{{ $guru->nip ?? '-' }}</span>
                                </div>
                            </div>
                        @else
                            <p class="text-rose-600 text-sm mb-8 font-semibold">Profil data guru belum dibuat oleh Administrator. Silakan hubungi admin sekolah.</p>
                        @endif
                    </div>
                </div>
                <div
                    class="bg-white border border-slate-300 rounded-xl p-6 flex flex-col justify-between relative overflow-hidden"
                >
                    <div>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-2"
                            >ANTREAN VERIFIKASI</span
                        >
                        <h3 class="text-4xl font-extrabold text-slate-900 tracking-tight font-label">
                            {{ $pending_pengajuan_count }}
                        </h3>
                        <p class="text-slate-500 text-xs mt-2 font-medium text-justify">Pengajuan tempat PKL dari siswa yang memerlukan persetujuan Anda.</p>
                    </div>
                </div>
                <div
                    class="bg-white border border-slate-300 rounded-xl p-6 flex flex-col justify-between relative overflow-hidden"
                >
                    <div class="mt-8">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-1"
                            >SISWA BIMBINGAN</span
                        >
                        <h4 class="text-5xl font-extrabold text-slate-900 tracking-tight font-label">
                            {{ $bimbingan_sidang_count }}
                        </h4>
                        <p class="text-slate-500 text-xs mt-2 font-medium">Terkoneksi berdasarkan jadwal sidang PKL.</p>
                    </div>
                </div>
                <div class="md:col-span-2 bg-white border border-slate-300 rounded-xl p-6 relative overflow-hidden">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-4"
                        >DAFTAR SISWA SIDANG BIMBINGAN</span
                    >
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs font-sans">
                            <thead>
                                <tr class="text-slate-500 border-b border-slate-100 pb-2">
                                    <th class="py-2 font-semibold">Nama Siswa</th>
                                    <th class="py-2 font-semibold">NISN</th>
                                    <th class="py-2 font-semibold">Waktu Sidang</th>
                                    <th class="py-2 font-semibold text-right">Ruangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse ($bimbingans as $bimbingan)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="py-3 font-semibold text-slate-900">
                                            {{ $bimbingan->siswa->user->name }}
                                        </td>
                                        <td class="py-3 text-slate-500 font-label">{{ $bimbingan->siswa->nisn }}</td>
                                        <td class="py-3 text-slate-600">
                                            {{
                                                \Carbon\Carbon::parse($bimbingan->waktu)->isoFormat(
                                                    'D MMM Y, HH:mm',
                                                )
                                            }} WIB
                                        </td>
                                        <td class="py-3 text-slate-700 font-bold font-label text-right">
                                            {{ $bimbingan->ruangan }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-slate-400 font-medium">
                                            Belum ada siswa bimbingan sidang.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

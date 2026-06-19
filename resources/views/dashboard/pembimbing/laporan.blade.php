@extends ('layouts.app')
@section ('content')
    @section ('header')
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ __('Monitoring Laporan PKL') }}</h2>
    @endsection
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-slate-900 font-display">Monitoring Laporan Akhir Siswa</h2>
                <p class="text-slate-500 text-base mt-2">Verifikasi dokumen laporan akhir PKL (bukan laporan harian) yang diunggah oleh siswa bimbingan Anda.</p>
            </div>
            <div class="flex items-center gap-4 border-b border-slate-200 mb-6">
                <a href="{{ route('pembimbing.laporan-harian.index') }}" class="px-4 py-3 text-sm font-bold text-slate-500 hover:text-slate-900 border-b-2 border-transparent hover:border-slate-300 transition-all flex items-center gap-2">
                    Laporan Harian
                </a>
                <a href="{{ route('pembimbing.laporan.index') }}" class="px-4 py-3 text-sm font-bold text-slate-900 border-b-2 border-slate-900 transition-all">Laporan Akhir</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @php
                    $total = $laporan_akhirs->count();
                @endphp
                <div class="bg-white rounded-xl p-6 border border-slate-200  flex items-center gap-5">
                    <div>
                        <div class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-1">
                            Total Laporan Akhir
                        </div>
                        <div class="text-3xl font-black text-slate-900">{{ $total }}</div>
                    </div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
                <form action="{{ route('pembimbing.laporan.index') }}" method="GET" class="relative w-full sm:w-96">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..." class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:border-slate-300 text-sm" />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </form>
            </div>
            <div class="bg-white overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                        Daftar Laporan Akhir
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-white text-slate-400 text-[11px] font-bold uppercase tracking-widest border-b border-slate-100"
                            >
                                <th class="px-6 py-4 whitespace-nowrap">Siswa</th>
                                <th class="px-6 py-4 whitespace-nowrap">Dokumen PDF</th>
                                <th class="px-6 py-4 text-right whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($laporan_akhirs as $akhir)
                                <tr class="hover:bg-slate-50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-900 font-bold">
                                            {{ $akhir->siswa->user->name }}
                                        </div>
                                        <div class="text-xs text-slate-500 mt-1">
                                            NISN: {{ $akhir->siswa->nisn }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a
                                            href="{{ asset('storage/' . $akhir->file_laporan) }}"
                                            target="_blank"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-50 text-slate-600 hover:text-slate-900 rounded-xl font-bold text-xs transition-colors"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            Lihat Dokumen
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a
                                            href="{{ route('pembimbing.laporan-harian.show', $akhir->siswa->id) }}"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-slate-50 hover:bg-slate-100 text-slate-900 border border-blue-200 font-bold text-xs rounded-xl transition-colors"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Lengkap
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <h4 class="text-slate-900 font-bold mb-1">Belum Ada Dokumen</h4>
                                            <p class="text-sm font-medium text-slate-500 max-w-sm">Saat ini belum ada siswa bimbingan yang mengunggah Laporan Akhir PKL mereka.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

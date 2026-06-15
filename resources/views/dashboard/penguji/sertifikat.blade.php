@extends ('layouts.app')

@section ('content')
    @section ('header')
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ __('Sertifikat PKL Siswa') }}</h2>
    @endsection
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-slate-900 font-display">Tinjau Sertifikat Kelulusan</h2>
                <p class="text-slate-500 text-sm mt-1">Daftar sertifikat terbit untuk siswa yang diuji oleh Anda.</p>
            </div>

            <!-- Bilah Pencarian & Filter -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
                <form action="{{ route('penguji.sertifikat.index') }}" method="GET" class="relative w-full sm:w-96">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..." class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:ring-purple-700 focus:border-purple-700 text-sm" />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </form>
            </div>

            <!-- List Table -->
            <div class="bg-white overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200"
                            >
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">Nama Siswa</th>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">NISN</th>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">Nomor Sertifikat</th>
                                <th class="px-6 py-4 font-semibold text-right whitespace-nowrap">File Dokumen</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse ($jadwals as $jadwal)
                                @php
                                    $sertifikat = $jadwal->siswa->sertifikat;
                                @endphp
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 text-sm text-slate-900 font-semibold">
                                        {{ $jadwal->siswa->user->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-500 font-label">
                                        {{ $jadwal->siswa->nisn }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium font-label">
                                        {{ $sertifikat->nomor_sertifikat ?? 'Belum terbit' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-right">
                                        @if ($sertifikat)
                                            <a
                                                href="{{ route('sertifikat.cetak', $sertifikat->id) }}"
                                                target="_blank"
                                                class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-800 font-bold"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                                Cetak Sertifikat
                                            </a>
                                        @else
                                            <span class="text-slate-400 font-medium text-xs"
                                                >Belum diterbitkan pembimbing</span
                                            >
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                        <div class="flex flex-col items-center justify-center">
                                            
                                            <p class="text-sm font-medium">Belum ada siswa yang dijadwalkan sidang ujian dengan Anda.</p>
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

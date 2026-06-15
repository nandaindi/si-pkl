@extends ('layouts.app')

@section ('content')
    @section ('header')
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ __('Kelola Sertifikat PKL') }}</h2>
    @endsection
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-slate-900 font-display">Penerbitan Sertifikat PKL</h2>
                <p class="text-slate-500 text-base mt-2">Terbitkan sertifikat otomatis untuk siswa bimbingan Anda yang telah menyelesaikan sidang PKL.</p>
            </div>

            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-bold px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Bilah Pencarian & Filter -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
                <form action="{{ route('pembimbing.sertifikat.index') }}" method="GET" class="relative w-full sm:w-96">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..." class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:ring-blue-700 focus:border-blue-700 text-sm" />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </form>
            </div>

            <!-- List Table -->
            <div class="bg-white overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                        Daftar Penerbitan Sertifikat
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-white text-slate-400 text-[11px] font-bold uppercase tracking-widest border-b border-slate-100"
                            >
                                <th class="px-6 py-4 whitespace-nowrap">Siswa</th>
                                <th class="px-6 py-4 whitespace-nowrap">Nomor Sertifikat</th>
                                <th class="px-6 py-4 whitespace-nowrap">Periode PKL</th>
                                <th class="px-6 py-4 whitespace-nowrap">Nilai</th>
                                <th class="px-6 py-4 text-center whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($jadwals as $jadwal)
                                @php
                                    $siswa = $jadwal->siswa;
                                    $sertifikat = $siswa->sertifikat;
                                    $nilai = $siswa->nilaiPkls;
                                    $laporans = $siswa->laporanHarians->sortBy('tanggal');
                                    $tglMulai = $laporans->first()?->tanggal;
                                    $tglSelesai = $laporans->last()?->tanggal;
                                @endphp
                                <tr class="hover:bg-slate-50 transition-colors group">
                                    <!-- Siswa -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm shrink-0"
                                            >
                                                {{ substr($siswa->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-sm text-slate-900 font-bold">
                                                    {{ $siswa->user->name }}
                                                </div>
                                                <div class="text-[11px] text-slate-500 font-label tracking-wide">
                                                    NISN: {{ $siswa->nisn }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Nomor Sertifikat -->
                                    <td class="px-6 py-4">
                                        @if ($sertifikat)
                                            <span class="inline-flex items-center gap-2 text-slate-900 bg-emerald-50 px-3 py-1.5 rounded-xl font-bold font-label text-[11px] border border-emerald-200">
                                                <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                                {{ $sertifikat->nomor_sertifikat }}
                                            </span>
                                        @else
                                            <span class="text-[11px] text-slate-400 font-label italic">Belum diterbitkan</span>
                                        @endif
                                    </td>

                                    <!-- Periode PKL -->
                                    <td class="px-6 py-4">
                                        @if ($tglMulai && $tglSelesai)
                                            <div class="text-[11px] text-slate-700 font-bold font-label">
                                                {{ \Carbon\Carbon::parse($tglMulai)->translatedFormat('d M Y') }}
                                            </div>
                                            <div class="text-[10px] text-slate-400 font-label mt-0.5">
                                                s/d {{ \Carbon\Carbon::parse($tglSelesai)->translatedFormat('d M Y') }}
                                            </div>
                                        @else
                                            <span class="text-[11px] text-slate-400 italic">-</span>
                                        @endif
                                    </td>

                                    <!-- Nilai -->
                                    <td class="px-6 py-4">
                                        @if ($nilai && $nilai->nilai_akhir)
                                            <div class="text-sm font-bold text-slate-900">{{ $nilai->nilai_akhir }}</div>
                                            <div class="text-[10px] text-slate-400 font-label">
                                                @if ($nilai->nilai_akhir >= 90) Sangat Baik
                                                @elseif ($nilai->nilai_akhir >= 80) Baik
                                                @elseif ($nilai->nilai_akhir >= 70) Cukup
                                                @else Kurang
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-[11px] text-slate-400 italic">Belum dinilai</span>
                                        @endif
                                    </td>

                                    <!-- Aksi -->
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $has90Days = $laporans->count() >= 90;
                                            $hasApprovedLaporanAkhir = $siswa->laporanAkhir && $siswa->laporanAkhir->status_verifikasi === 'disetujui';
                                            $hasNilai = $nilai && $nilai->nilai_akhir;
                                            $isEligible = $has90Days && $hasApprovedLaporanAkhir && $hasNilai;
                                        @endphp
                                        
                                        @if ($sertifikat)
                                            <div class="flex flex-col items-center gap-2">
                                                <a
                                                    href="{{ route('sertifikat.cetak', $sertifikat->id) }}"
                                                    target="_blank"
                                                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-xl font-bold text-xs transition-colors"
                                                >
                                                    <i class="fa-solid fa-print"></i>
                                                    Cetak
                                                </a>
                                                
                                                @if($isEligible)
                                                    <form action="{{ route('pembimbing.sertifikat.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="siswa_id" value="{{ $siswa->id }}" />
                                                        <button
                                                            type="submit"
                                                            class="text-[10px] font-bold text-amber-600 hover:text-amber-700 hover:bg-amber-50 px-3 py-1 rounded-lg transition-colors"
                                                        >
                                                            <i class="fa-solid fa-rotate-right mr-1"></i>Generate Ulang
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-[10px] font-bold text-rose-500 bg-rose-50 px-2 py-1 rounded-lg">Tidak Memenuhi Syarat</span>
                                                @endif
                                            </div>
                                        @else
                                            @if($isEligible)
                                                <form action="{{ route('pembimbing.sertifikat.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="siswa_id" value="{{ $siswa->id }}" />
                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs rounded-xl shadow-sm hover:shadow transition-all"
                                                    >
                                                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                                                        Terbitkan Otomatis
                                                    </button>
                                                </form>
                                            @else
                                                <div class="flex flex-col items-center gap-1">
                                                    <button disabled class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-200 text-slate-400 font-bold text-xs rounded-xl shadow-sm cursor-not-allowed">
                                                        <i class="fa-solid fa-lock"></i>
                                                        Terkunci
                                                    </button>
                                                    <span class="text-[9px] text-slate-500 text-center max-w-[120px]">
                                                        Butuh 90 hari magang, laporan akhir, & nilai sidang
                                                    </span>
                                                </div>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <h4 class="text-slate-900 font-bold mb-1">Belum Ada Siswa</h4>
                                            <p class="text-sm font-medium text-slate-500 max-w-sm">Belum ada siswa bimbingan Anda yang terdaftar pada jadwal sidang kelulusan.</p>
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

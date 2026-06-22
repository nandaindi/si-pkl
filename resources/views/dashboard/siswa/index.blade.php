@extends ('layouts.app')
@section ('content')
    @section ('header')
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ __('Dashboard Siswa') }}</h2>
    @endsection
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            @if (isset($belum_isi_laporan_hari_ini) && $belum_isi_laporan_hari_ini)
                <div
                    class="mb-6 bg-rose-50 border border-rose-200 rounded-xl p-5 flex flex-col sm:flex-row items-start sm:items-center gap-4 shadow-sm"
                >
                    <div
                        class="w-12 h-12 rounded-full bg-white flex items-center justify-center shadow-sm shrink-0 border border-rose-100"
                    >
                        <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-bold text-rose-800">Peringatan: Belum Mengisi Laporan Harian!</h3>
                        <p class="text-xs text-rose-600 mt-1 max-w-2xl leading-relaxed">Sistem mendeteksi Anda belum mengisi laporan kegiatan PKL untuk hari ini. Jangan menunda, segera catat kegiatan Anda agar nilai kedisiplinan tetap maksimal.</p>
                    </div>
                    <a
                        href="{{ route('siswa.jurnal-harian.index') }}"
                        class="shrink-0 mt-3 sm:mt-0 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-lg transition-colors shadow-sm"
                    >
                        Isi Laporan Sekarang
                    </a>
                </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div
                    class="md:col-span-2 bg-white border border-slate-100 rounded-xl p-6 flex flex-col justify-center relative overflow-hidden"
                >
                    <div class="relative z-10 w-full">
                        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight font-display">
                            Halo, {{ Auth::user()->name }}
                        </h2>
                        <p class="text-slate-500 text-sm mt-2">Selamat datang di Panel Siswa.</p>
                    </div>
                </div>
                <div
                    class="bg-white border border-slate-100 rounded-xl p-6 flex flex-col justify-center relative overflow-hidden"
                >
                    <div class="relative z-10 w-full">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-3"
                            >Informasi Siswa</span
                        >
                        @if ($siswa)
                            <div class="space-y-2 text-sm text-slate-600">
                                <div class="flex justify-between">
                                    <span class="text-slate-400">NISN:</span>
                                    <span class="font-bold text-slate-800 font-label">{{ $siswa->nisn }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Kelas:</span>
                                    <span class="font-bold text-slate-800">{{ $siswa->kelas }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Jurusan:</span>
                                    <span class="font-bold text-slate-800">{{ $siswa->jurusan }}</span>
                                </div>
                            </div>
                        @else
                            <p class="text-rose-600 text-xs font-semibold">Profil belum dibuat.</p>
                        @endif
                    </div>
                </div>
                <div
                    class="bg-white border border-slate-100 rounded-xl p-6 flex flex-col justify-between relative overflow-hidden"
                >
                    <div>
                        <span class="text-xs font-semibold text-slate-400 block mb-1">Sertifikat Kelulusan</span>
                        @if ($sertifikat)
                            <h3 class="text-xl font-extrabold text-slate-900 leading-snug font-display">
                                Sertifikat PKL Tersedia!
                            </h3>
                            <p class="text-slate-500 text-xs mt-2 font-medium text-justify">Anda telah menyelesaikan program PKL dan lulus sidang laporan akhir.</p>
                        @else
                            <h3 class="text-xl font-extrabold text-slate-400 leading-snug font-display">
                                Belum Tersedia
                            </h3>
                            <p class="text-slate-400 text-xs mt-2 font-medium text-justify">Sertifikat akan terbit setelah Anda menyelesaikan sidang dan divalidasi oleh pembimbing.</p>
                        @endif
                    </div>
                </div>
                <div
                    class="bg-white border border-slate-100 rounded-xl p-6 flex flex-col justify-between relative overflow-hidden"
                >
                    <div class="mt-8">
                        <span class="text-xs font-semibold text-slate-400 block mb-1">Status Pengajuan PKL</span>
                        @if ($pengajuan_pkl)
                            <h4 class="text-xl font-extrabold text-slate-900 tracking-tight mt-1 font-display">
                                {{ $pengajuan_pkl->tempatPkl->nama_instansi }}
                            </h4>
                            @if ($pengajuan_pkl->status === 'disetujui')
                                <div class="text-xs font-bold text-slate-900 mt-2">Disetujui</div>
                            @elseif ($pengajuan_pkl->status === 'ditolak')
                                <div class="text-xs font-bold text-slate-500 mt-2">Ditolak</div>
                            @else
                                <div class="text-xs font-bold text-slate-500 mt-2">Pending / Diproses</div>
                            @endif
                        @else
                            <h4 class="text-xl font-extrabold text-slate-400 tracking-tight mt-1 font-display">
                                Belum Ada Pengajuan
                            </h4>
                            <div class="text-xs font-bold text-slate-500 mt-2">Tidak Aktif</div>
                        @endif
                    </div>
                </div>
                <a
                    href="{{ route('siswa.jurnal-harian.index') }}"
                    class="group bg-white hover:bg-slate-50 transition-colors border border-slate-100 rounded-xl p-6 flex flex-col justify-between relative overflow-hidden"
                >
                    <div class="mt-8">
                        <span class="text-xs font-semibold text-slate-400 block mb-1">Laporan Harian Terisi</span>
                        <h4 class="text-5xl font-extrabold text-slate-900 tracking-tight font-label">
                            {{ $laporan_harian_count }} <span class="text-lg text-slate-400 font-normal">Hari</span>
                        </h4>
                        <p class="text-slate-500 text-xs mt-2 font-medium group-hover:text-slate-900 transition-colors">Tulis & monitoring laporan harian &rarr;</p>
                    </div>
                </a>
                <a
                    href="{{ route('siswa.jadwal-sidang.index') }}"
                    class="group bg-white hover:bg-slate-50 transition-colors border border-slate-100 rounded-xl p-6 flex flex-col justify-between relative overflow-hidden"
                >
                    <div class="mt-8">
                        <span class="text-xs font-semibold text-slate-400 block mb-1">Jadwal Sidang Laporan</span>
                        @if ($jadwal_sidang)
                            <h4 class="text-lg font-extrabold text-slate-900 tracking-tight mt-1 font-display">
                                {{
                                    \Carbon\Carbon::parse($jadwal_sidang->waktu)->isoFormat(
                                        'dddd, D MMMM Y',
                                    )
                                }}
                            </h4>
                            <p class="text-slate-500 text-xs mt-1">Ruangan: <span class="font-bold font-label">{{ $jadwal_sidang->ruangan }}</span></p>
                        @else
                            <h4 class="text-xl font-extrabold text-slate-400 tracking-tight mt-1 font-display">
                                Belum Terjadwal
                            </h4>
                            <p class="text-slate-400 text-xs mt-1 text-justify">Jadwal akan diumumkan oleh Panitia PKL.</p>
                        @endif
                        <p class="text-slate-500 text-xs mt-2 font-medium group-hover:text-black transition-colors">Lihat detail sidang &rarr;</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection

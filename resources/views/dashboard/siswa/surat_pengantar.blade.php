{{-- 
    View: Siswa - Surat Pengantar PKL
    Fungsi: Antarmuka untuk melihat status surat pengantar ke instansi yang dapat dicetak/diunduh.
--}}
@extends ('layouts.app')
@section ('content')
    @section ('header')
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ __('Unduh Surat Pengantar PKL') }}</h2>
    @endsection
    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-slate-900 font-display">Unduh Surat Pengantar PKL</h2>
                <p class="text-slate-500 text-base mt-2">Dapatkan berkas Surat Pengantar resmi dari sekolah untuk diserahkan ke instansi/perusahaan tempat Anda melaksanakan PKL.</p>
            </div>
            @if (!$pengajuan)
                <div class="bg-white border-2 border-slate-200 rounded-3xl p-8 text-center shadow-md">
                    <div
                        class="w-16 h-16 bg-amber-50 border border-amber-200 rounded-full flex items-center justify-center mx-auto mb-4 text-amber-500"
                    >
                        <i class="fa-solid fa-lock text-amber-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 font-display">Belum Ada Pengajuan Disetujui</h3>
                    <p class="text-slate-500 text-sm mt-2 max-w-md mx-auto leading-relaxed">Anda belum memiliki pendaftaran tempat magang yang berstatus <strong>Disetujui</strong>. Silakan ajukan tempat magang terlebih dahulu dan tunggu verifikasi pembimbing.</p>
                    <div class="mt-6">
                        <a
                            href="{{ route('siswa.pengajuan.index') }}"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-sm font-bold transition-colors"
                        >
                            Menuju Halaman Pengajuan
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                    <div class="md:col-span-5 bg-white border-2 border-slate-200 rounded-3xl p-6 shadow-sm flex flex-col justify-between min-h-[240px]">
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-4"
                                >Detail Penempatan</span
                            >
                            <h4 class="font-black text-xl text-slate-900 leading-tight">
                                {{ $pengajuan->tempatPkl->nama_instansi }}
                            </h4>
                            <p class="text-xs text-slate-500 mt-2 leading-relaxed">{{ $pengajuan->tempatPkl->alamat }}</p>
                        </div>
                        <div class="border-t border-slate-100 pt-4 flex justify-between text-xs">
                            <span class="text-slate-400">Tanggal Disetujui:</span>
                            <span
                                class="font-bold text-slate-700"
                                >{{ $pengajuan->updated_at->isoFormat('D MMMM Y') }}</span
                            >
                        </div>
                    </div>
                    <div
                        class="md:col-span-7 bg-white border-2 border-slate-200 rounded-3xl p-6 shadow-sm flex flex-col justify-between min-h-[240px]"
                    >
                        <div class="flex-1 flex flex-col justify-between">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-14 h-14 bg-red-50 border border-red-200 rounded-2xl flex items-center justify-center text-red-500 shrink-0"
                                >
                                    <i class="fa-solid fa-file-pdf text-3xl"></i>
                                </div>
                                <div>
                                    <span
                                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest font-label"
                                        >Berkas Siap Cetak</span
                                    >
                                    <h4 class="font-bold text-base text-slate-900 leading-tight mt-1">
                                        Surat_Pengantar_PKL.pdf
                                    </h4>
                                    <p class="text-[11px] text-slate-500 mt-1 font-mono">Format: PDF Dokumen (Dihasilkan Otomatis)</p>
                                </div>
                            </div>
                            <div class="mt-8 flex flex-col sm:flex-row gap-3">
                                <a
                                    href="{{ route('siswa.surat-pengantar.cetak', $pengajuan->id) }}"
                                    target="_blank"
                                    class="flex-1 text-center px-5 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl flex items-center justify-center gap-2 transition-colors"
                                >
                                    <i class="fa-solid fa-print text-sm"></i>
                                    Cetak Surat Pengantar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

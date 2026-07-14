{{-- 
    View: Siswa - Unggah Laporan Akhir
    Fungsi: Halaman form bagi siswa untuk mengunggah file laporan akhir (PDF) jika persyaratan jurnal harian sudah terpenuhi.
--}}
@extends ('layouts.app')
@section ('content')
    @section ('header')
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ __('Mengumpulkan Laporan Akhir PKL') }}</h2>
    @endsection
    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-slate-900 font-display">Mengumpulkan Laporan Akhir PKL</h2>
                <p class="text-slate-500 text-sm mt-1">Unggah berkas dokumen laporan akhir magang Anda dalam format PDF setelah menyelesaikan laporan harian.</p>
            </div>
            @if (!$pengajuan_disetujui)
                <div class="bg-amber-50 border-2 border-amber-200 rounded-3xl p-8 text-center shadow-md">
                    <div class="w-16 h-16 rounded-full bg-amber-50 border border-amber-200/60 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-lock text-amber-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 font-display">Fitur Terkunci</h3>
                    <p class="text-slate-500 text-sm mt-2 max-w-md mx-auto leading-relaxed">
                        Pengunggahan laporan akhir hanya dapat diakses setelah pengajuan tempat PKL Anda <strong>Disetujui</strong> oleh Guru Pembimbing.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('siswa.pengajuan.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-sm font-bold transition-colors">
                            Pergi ke Mengajukan PKL
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            @else
                @php
                    $hasEnoughJournals = $dailyJournalCount >= $minDailyJournals;
                @endphp
                @if (!$hasEnoughJournals)
                    <div class="bg-amber-50 border-2 border-amber-200 rounded-3xl p-8 shadow-md text-center">
                        <div class="w-16 h-16 rounded-full bg-amber-50 border border-amber-200/60 flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-lock text-amber-500 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 font-display">Pengunggahan Terkunci</h3>
                        <p class="text-slate-500 text-sm mt-2 max-w-md mx-auto leading-relaxed">
                            Anda harus mengisi minimal <strong>{{ $minDailyJournals }} hari</strong> laporan harian sebelum diperkenankan mengunggah laporan akhir.
                        </p>
                        <div class="mt-6 bg-white border-2 border-slate-200 p-5 rounded-2xl max-w-sm mx-auto shadow-sm">
                            <div class="flex justify-between text-xs font-bold text-slate-700 mb-1.5 font-label">
                                <span>Progress Laporan Harian</span>
                                <span>{{ $dailyJournalCount }} / {{ $minDailyJournals }} Hari</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-amber-500 h-full rounded-full transition-all duration-500" style="width: {{ min(100, ($dailyJournalCount / $minDailyJournals) * 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                        <div class="md:col-span-5">
                            @if (!$laporan_akhir || $laporan_akhir->status_verifikasi !== 'disetujui')
                                <form action="{{ route('siswa.laporan-akhir.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-3xl border-2 border-slate-200 shadow-sm space-y-4">
                                    @csrf
                                    <h3 class="text-lg font-black text-slate-900 font-display">Unggah Laporan</h3>
                                    <div class="space-y-3">
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider font-label">Berkas Laporan Akhir (PDF, maks 10MB)</label>
                                        <input type="file" name="file_laporan" accept=".pdf" required class="w-full px-3 py-2 text-sm file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-50 file:text-slate-900 hover:file:bg-slate-100">
                                        @error('file_laporan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="pt-2">
                                        <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-xl text-sm font-bold flex items-center justify-center gap-2 transition-colors">
                                            Kirim Laporan Akhir
                                            <i class="fa-solid fa-paper-plane text-xs"></i>
                                        </button>
                                    </div>
                                </form>
                            @else
                                <div class="bg-white p-6 rounded-3xl border-2 border-slate-200 shadow-sm text-center py-8">
                                    <div class="w-14 h-14 rounded-full bg-emerald-50 border border-emerald-200/60 flex items-center justify-center mx-auto mb-3">
                                        <i class="fa-solid fa-circle-check text-emerald-500 text-2xl"></i>
                                    </div>
                                    <h4 class="font-extrabold text-slate-800 text-sm">Laporan Selesai</h4>
                                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                                        Laporan akhir Anda telah terkumpul. Terima kasih atas partisipasi Anda.
                                    </p>
                                </div>
                            @endif
                        </div>
                        <div class="md:col-span-7">
                            @if ($laporan_akhir)
                                <div class="bg-white rounded-3xl border-2 border-slate-200 p-6 shadow-sm space-y-6">
                                    <h3 class="text-lg font-black text-slate-900 border-b border-slate-100 pb-3 font-display">Status Verifikasi</h3>
                                    <div class="flex items-start gap-4">
                                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-200/60 flex items-center justify-center shrink-0">
                                            <i class="fa-solid fa-check text-emerald-500 text-xl"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-slate-900 text-base">Terkumpul & Siap Sidang</h4>
                                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">Laporan Akhir Anda telah terkirim. Anda kini siap untuk dijadwalkan sidang oleh pembimbing.</p>
                                        </div>
                                    </div>
                                    @if ($laporan_akhir->catatan_pembimbing)
                                        <div class="p-4 bg-slate-50 rounded-2xl border-2 border-slate-200 text-xs leading-relaxed text-slate-600 space-y-1">
                                            <span class="font-bold text-slate-800 font-label block">CATATAN PEMBIMBING:</span>
                                            <p class="italic">"{{ $laporan_akhir->catatan_pembimbing }}"</p>
                                        </div>
                                    @endif
                                    <div class="pt-2">
                                        <a href="{{ Storage::url($laporan_akhir->file_laporan) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-colors font-label">
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                            Lihat Dokumen Terkirim
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="bg-slate-50 rounded-3xl border-2 border-slate-200 border-dashed p-12 flex flex-col items-center justify-center text-center shadow-sm">
                                    <div class="w-16 h-16 rounded-full bg-slate-50 border border-blue-100 flex items-center justify-center mb-3">
                                        <i class="fa-solid fa-file-pdf text-slate-900 text-3xl"></i>
                                    </div>
                                    <h4 class="text-slate-800 font-bold mb-2 font-display">Belum Ada Dokumen Laporan</h4>
                                    <p class="text-xs text-slate-500 max-w-sm leading-relaxed">Anda belum mengunggah berkas laporan akhir. Silakan gunakan formulir unggah laporan di sisi kiri untuk memproses.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection

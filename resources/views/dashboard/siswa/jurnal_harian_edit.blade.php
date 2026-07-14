{{-- 
    View: Siswa - Edit Jurnal Harian
    Fungsi: Form bagi siswa untuk merevisi atau mengubah catatan kegiatan harian yang telah diinput sebelumnya.
--}}
@extends ('layouts.app')
@section ('content')
    @section ('header')
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ __('Edit Jurnal Harian') }}</h2>
    @endsection
    <div class="py-6">
        <div class="max-w-3xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('siswa.jurnal-harian.index', ['tab' => 'riwayat']) }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors mb-4">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Riwayat
                </a>
                <h2 class="text-3xl font-bold text-slate-900 font-display">Edit Laporan Harian</h2>
                <p class="text-slate-500 text-sm mt-1">Perbarui aktivitas harian magang Anda beserta dokumentasi foto pendukung.</p>
            </div>
            <div class="bg-white p-8 rounded-3xl border-2 border-slate-200 shadow-sm relative overflow-hidden">
                <form action="{{ route('siswa.jurnal-harian.update', $jurnal_harian->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="tanggal" class="block text-sm font-bold text-slate-700 mb-2">Tanggal Laporan <span class="text-rose-500">*</span></label>
                        <input
                            type="date"
                            id="tanggal"
                            name="tanggal"
                            value="{{ $jurnal_harian->tanggal }}"
                            class="w-full bg-slate-50 rounded-xl border-2 border-slate-200 px-4 py-3 text-slate-500 focus:outline-none cursor-not-allowed"
                            readonly
                            disabled
                        />
                        <p class="text-[11px] text-slate-400 mt-1.5"><i class="fa-solid fa-circle-info mr-1"></i>Tanggal laporan tidak dapat diubah.</p>
                    </div>
                    <div>
                        <label for="kegiatan" class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Kegiatan <span class="text-rose-500">*</span></label>
                        <textarea
                            id="kegiatan"
                            name="kegiatan"
                            rows="5"
                            placeholder="Ceritakan detail kegiatan magang yang Anda lakukan hari ini..."
                            class="w-full bg-white rounded-xl border-2 border-slate-200 px-4 py-3 text-slate-700 focus:border-slate-300 transition-all resize-y @error('kegiatan') border-rose-500 ring-rose-100 @enderror"
                            required
                        >{{ old('kegiatan', $jurnal_harian->kegiatan) }}</textarea>
                        @error ('kegiatan')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="bukti_foto" class="block text-sm font-bold text-slate-700 mb-2">Foto Dokumentasi (Opsional)</label>
                        @if ($jurnal_harian->bukti_foto)
                            <div class="mb-4">
                                <p class="text-xs text-slate-500 mb-2">Foto saat ini:</p>
                                <img src="{{ asset('storage/' . $jurnal_harian->bukti_foto) }}" alt="Bukti Foto" class="h-32 rounded-xl object-cover border-2 border-slate-200">
                            </div>
                        @endif
                        <input
                            type="file"
                            id="bukti_foto"
                            name="bukti_foto"
                            accept="image/*"
                            class="w-full bg-white rounded-xl border-2 border-slate-200 px-4 py-2.5 text-slate-700 focus:border-slate-300 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-50 file:text-slate-900 hover:file:bg-slate-100 @error('bukti_foto') border-rose-500 @enderror"
                        />
                        <p class="text-xs text-slate-500 mt-1.5">Format: JPG, PNG. Maks: 2MB. Biarkan kosong jika tidak ingin mengubah foto.</p>
                        @error ('bukti_foto')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex items-center gap-3">
                        <button
                            type="submit"
                            class="bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-8 rounded-xl shadow-sm transition-colors flex items-center gap-2"
                        >
                            <i class="fa-solid fa-save"></i>
                            Simpan Perubahan
                        </button>
                        <a
                            href="{{ route('siswa.jurnal-harian.index', ['tab' => 'riwayat']) }}"
                            class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3 px-6 rounded-xl transition-colors"
                        >
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

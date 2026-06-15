@extends ('layouts.app')

@section ('content')
    @section ('header')
        <div class="flex items-center gap-4">
            <a href="{{ route('siswa.jurnal-harian.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ __('Catat Aktivitas PKL') }}</h2>
        </div>
    @endsection

    <div class="py-6">
        <div class="max-w-3xl mx-auto">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-slate-900 font-display">Catat Aktivitas</h2>
                <p class="text-slate-500 text-sm mt-1">Isi formulir di bawah ini untuk mencatat kegiatan harian Anda. Pastikan detail kegiatan jelas dan foto bukti valid.</p>
            </div>

            <div class="bg-white rounded-3xl border-2 border-slate-200 shadow-sm p-6 sm:p-8">
                <form action="{{ route('siswa.jurnal-harian.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider font-label">Tanggal Laporan</label>
                        <div class="w-full px-4 py-3 text-sm bg-slate-50 text-slate-700 rounded-xl border border-slate-200 cursor-not-allowed font-bold flex items-center gap-3">
                            <i class="fa-regular fa-calendar text-slate-400"></i>
                            {{ \Carbon\Carbon::today()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                        </div>
                        <input type="hidden" name="tanggal" value="{{ \Carbon\Carbon::today()->toDateString() }}">
                        <p class="text-[10px] text-slate-400 mt-1.5 italic">Tanggal dikunci untuk hari ini. Laporan hari sebelumnya yang terlewat tidak dapat diisi.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider font-label">Detail Kegiatan</label>
                        <textarea
                            name="kegiatan"
                            rows="5"
                            required
                            class="w-full px-4 py-3 text-sm bg-white border-2 border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all duration-200"
                            placeholder="Jelaskan secara rinci apa saja yang Anda kerjakan, pelajari, atau temukan selama magang hari ini..."
                        >{{ old('kegiatan') }}</textarea>
                        @error('kegiatan')
                            <span class="text-red-500 text-xs mt-1 font-medium block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider font-label">Bukti Foto Kegiatan <span class="text-red-500">*</span></label>
                        
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors relative group">
                            <div class="space-y-2 text-center relative z-10">
                                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mx-auto shadow-sm border border-slate-200 group-hover:border-blue-200 group-hover:text-blue-600 transition-colors">
                                    <i class="fa-solid fa-cloud-arrow-up text-xl text-slate-400 group-hover:text-blue-500"></i>
                                </div>
                                <div class="flex text-sm text-slate-600 justify-center">
                                    <label for="file-upload" class="relative cursor-pointer rounded-md font-bold text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Unggah foto</span>
                                        <input id="file-upload" name="bukti_foto" type="file" class="sr-only" accept="image/*" required onchange="updateFileName(this)">
                                    </label>
                                    <p class="pl-1 hidden sm:block">atau klik area ini</p>
                                </div>
                                <p class="text-xs text-slate-500">PNG, JPG, JPEG maksimal 2MB</p>
                                <p id="file-name" class="text-[11px] font-bold text-blue-700 mt-3 hidden bg-blue-50 px-3 py-1.5 rounded-full border border-blue-100 inline-block"></p>
                            </div>
                        </div>
                        @error('bukti_foto')
                            <span class="text-red-500 text-xs mt-1 font-medium block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <a href="{{ route('siswa.jurnal-harian.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-100 transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold flex items-center justify-center gap-2 transition-all duration-200 shadow-sm hover:shadow">
                            Kirim Laporan
                            <i class="fa-solid fa-paper-plane text-xs"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const fileNameDisplay = document.getElementById('file-name');
            if (input.files && input.files[0]) {
                fileNameDisplay.textContent = 'File terpilih: ' + input.files[0].name;
                fileNameDisplay.classList.remove('hidden');
            } else {
                fileNameDisplay.classList.add('hidden');
            }
        }
    </script>
@endsection

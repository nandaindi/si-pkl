@extends ('layouts.app')
@section ('content')
    <div class="max-w-4xl mx-auto py-8">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-slate-900">Tambah Tempat PKL</h2>
            <p class="text-slate-500 text-sm mt-1">Daftarkan instansi atau perusahaan untuk tempat pelaksanaan PKL.</p>
        </div>
        <form
            action="{{ route('admin.tempat-pkl.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="bg-white p-8 rounded-xl  border border-slate-200"
        >
            @csrf
            <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Informasi Instansi</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Instansi / Perusahaan</label>
                    <input
                        type="text"
                        name="nama_instansi"
                        value="{{ old('nama_instansi') }}"
                        required
                        class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:border-slate-300"
                        placeholder="Contoh: PT. Teknologi Nusantara"
                    />
                    @error ('nama_instansi')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Alamat Lengkap</label>
                    <textarea
                        name="alamat"
                        rows="3"
                        required
                        class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:border-slate-300"
                        placeholder="Masukkan alamat lengkap instansi"
                        >{{ old('alamat') }}</textarea
                    >
                    @error ('alamat')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2"
                        >Foto Instansi / Perusahaan <span class="text-red-500">*</span></label
                    >
                    <input
                        type="file"
                        name="gambar"
                        accept="image/*"
                        required
                        class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:border-slate-300 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-50 file:text-slate-900 hover:file:bg-slate-100"
                    />
                    @error ('gambar')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kuota Siswa PKL</label>
                    <input
                        type="number"
                        name="kuota"
                        value="{{ old('kuota', 0) }}"
                        min="0"
                        required
                        class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:border-slate-300"
                        placeholder="Contoh: 5"
                    />
                    @error ('kuota')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="flex items-center justify-end gap-4 mt-8 pt-4 border-t border-slate-100">
                <a
                    href="{{ route('admin.tempat-pkl.index') }}"
                    class="px-6 py-2.5 text-slate-600 hover:text-slate-800 font-medium transition-colors"
                    >Batal</a
                >
                <button
                    type="submit"
                    class="bg-slate-900 hover:bg-slate-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold "
                >
                    Simpan Tempat PKL
                </button>
            </div>
        </form>
    </div>
@endsection

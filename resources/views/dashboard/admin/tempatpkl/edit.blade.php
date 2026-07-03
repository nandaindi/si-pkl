@extends ('layouts.app')
@section ('content')
    <div class="max-w-4xl mx-auto py-8">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-slate-900">Edit Tempat PKL</h2>
            <p class="text-slate-500 text-sm mt-1">Perbarui informasi instansi atau perusahaan tempat PKL.</p>
        </div>
        <form
            action="{{ route('admin.tempat-pkl.update', $tempat_pkl->id) }}"
            method="POST"
            enctype="multipart/form-data"
            class="bg-white p-8 rounded-xl  border-2 border-slate-200"
        >
            @csrf
            @method ('PUT')
            <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Informasi Instansi</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Instansi / Perusahaan</label>
                    <input
                        type="text"
                        name="nama_instansi"
                        value="{{ old('nama_instansi', $tempat_pkl->raw_nama_instansi) }}"
                        required
                        class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:border-slate-300"
                    />
                    @error ('nama_instansi')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Jurusan (Opsional - Jika khusus jurusan tertentu)</label>
                    <select
                        name="jurusan"
                        class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:border-slate-300 bg-white"
                    >
                        <option value="" {{ old('jurusan', $tempat_pkl->jurusan) ? '' : 'selected' }}>Semua Jurusan</option>
                        <option value="Teknik Kendaraan Ringan" {{ old('jurusan', $tempat_pkl->jurusan) == 'Teknik Kendaraan Ringan' ? 'selected' : '' }}>Teknik Kendaraan Ringan</option>
                        <option value="Manajemen Perkantoran" {{ old('jurusan', $tempat_pkl->jurusan) == 'Manajemen Perkantoran' ? 'selected' : '' }}>Manajemen Perkantoran</option>
                        <option value="Desain Komunikasi Visual" {{ old('jurusan', $tempat_pkl->jurusan) == 'Desain Komunikasi Visual' ? 'selected' : '' }}>Desain Komunikasi Visual</option>
                        <option value="Teknik Komputer Jaringan" {{ old('jurusan', $tempat_pkl->jurusan) == 'Teknik Komputer Jaringan' ? 'selected' : '' }}>Teknik Komputer Jaringan</option>
                    </select>
                    @error ('jurusan')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Alamat Lengkap</label>
                    <textarea
                        name="alamat"
                        rows="3"
                        required
                        class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:border-slate-300"
                        >{{ old('alamat', $tempat_pkl->alamat) }}</textarea
                    >
                    @error ('alamat')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2"
                        >Foto Instansi / Perusahaan
                        <span class="text-xs text-slate-400 font-normal">(Kosongkan jika tidak diubah)</span></label
                    >
                    @if ($tempat_pkl->gambar)
                        <div class="mb-3">
                            <img
                                src="{{ asset('storage/' . $tempat_pkl->gambar) }}"
                                alt="Foto {{ $tempat_pkl->nama_instansi }}"
                                class="h-32 w-auto object-cover rounded-xl border-2 border-slate-200"
                            />
                        </div>
                    @endif
                    <input
                        type="file"
                        name="gambar"
                        accept="image/*"
                        class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:border-slate-300 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-50 file:text-slate-900 hover:file:bg-slate-100"
                    />
                    @error ('gambar')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                    <p class="text-xs text-slate-500 mt-2">Biarkan kosong jika tidak ingin mengubah foto.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kuota Siswa PKL</label>
                    <input
                        type="number"
                        name="kuota"
                        value="{{ old('kuota', $tempat_pkl->kuota) }}"
                        min="0"
                        required
                        class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:border-slate-300"
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
                    Perbarui Tempat PKL
                </button>
            </div>
        </form>
    </div>
@endsection

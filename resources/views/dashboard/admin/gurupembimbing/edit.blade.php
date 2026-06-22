@extends ('layouts.app')
@section ('content')
    <div class="max-w-4xl mx-auto py-8">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-slate-900">Edit Guru Pembimbing</h2>
            <p class="text-slate-500 text-sm mt-1">Perbarui akun dan profil guru pembimbing.</p>
        </div>
        <form
            action="{{ route('admin.guru-pembimbing.update', $guru->id) }}"
            method="POST"
            class="bg-white p-8 rounded-xl  border-2 border-slate-200"
        >
            @csrf
            @method ('PUT')
            <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Informasi Akun (Login)</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap & Gelar</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $guru->user->name) }}"
                        required
                        class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:border-slate-300"
                    />
                    @error ('name')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Alamat Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $guru->user->email) }}"
                        required
                        class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:border-slate-300"
                    />
                    @error ('email')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div x-data="{ show: false }">
                    <label class="block text-sm font-medium text-slate-700 mb-2"
                        >Password Baru
                        <span class="text-xs text-slate-400 font-normal"
                            >(Kosongkan jika tidak ingin mengubah)</span
                        ></label
                    >
                    <div class="relative">
                        <input
                            :type="show ? 'text' : 'password'"
                            name="password"
                            class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:border-slate-300 pr-10"
                            placeholder="Minimal 8 karakter"
                        />
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                            <i class="fa-regular fa-eye" x-show="!show"></i>
                            <i class="fa-regular fa-eye-slash" x-show="show" x-cloak style="display: none;"></i>
                        </button>
                    </div>
                    @error ('password')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div x-data="{ show: false }">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password</label>
                    <div class="relative">
                        <input
                            :type="show ? 'text' : 'password'"
                            name="password_confirmation"
                            class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:border-slate-300 pr-10"
                            placeholder="Ulangi password"
                        />
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                            <i class="fa-regular fa-eye" x-show="!show"></i>
                            <i class="fa-regular fa-eye-slash" x-show="show" x-cloak style="display: none;"></i>
                        </button>
                    </div>
                </div>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Data Profil Guru</h3>
            <div class="grid grid-cols-1 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2"
                        >NIP / NUPTK <span class="text-red-500">*</span></label
                    >
                    <input
                        type="text"
                        name="nip"
                        value="{{ old('nip', $guru->nip) }}"
                        required
                        class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:border-slate-300"
                        placeholder="Masukkan NIP"
                    />
                    @error ('nip')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="flex items-center justify-end gap-4 mt-8 pt-4 border-t border-slate-100">
                <a
                    href="{{ route('admin.guru-pembimbing.index') }}"
                    class="px-6 py-2.5 text-slate-600 hover:text-slate-800 font-medium transition-colors"
                    >Batal</a
                >
                <button
                    type="submit"
                    class="bg-slate-900 hover:bg-slate-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold "
                >
                    Perbarui Guru Pembimbing
                </button>
            </div>
        </form>
    </div>
@endsection

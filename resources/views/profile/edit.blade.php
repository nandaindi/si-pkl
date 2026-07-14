@extends('layouts.app')
@section('content')
    @section('header')
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Pengaturan Profil') }}
        </h2>
    @endsection
    <div class="py-6">
        <div class="max-w-4xl mx-auto space-y-6">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-slate-900 font-display">Pengaturan Profil</h2>
                <p class="text-slate-500 text-sm mt-1">Perbarui informasi profil dan alamat email akun Anda.</p>
            </div>

            <div class="bg-white p-8 rounded-xl border border-slate-200">
                <h3 class="text-lg font-bold text-slate-900 mb-1 font-display">Informasi Profil</h3>
                <p class="text-slate-500 text-sm mb-6">Perbarui nama dan email Anda.</p>
                {{-- 
                   Form untuk update profil. 
                   action="{{ route('profile.update') }}" mengarahkan data form ke URL yang sesuai dengan route 'profile.update'.
                   enctype="multipart/form-data" diperlukan karena form ini menerima input file (gambar/foto profil).
                --}}
                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    {{-- @csrf (Cross-Site Request Forgery) token wajib ada di setiap form POST Laravel untuk keamanan --}}
                    @csrf
                    
                    {{-- @method('patch') digunakan untuk menimpa method POST menjadi PATCH (update data) sesuai route Laravel --}}
                    @method('patch')
                    <div class="max-w-xl flex items-center gap-6">
                        <div class="shrink-0">
                            {{-- Mengecek apakah user sudah mengupload avatar (foto profil) sebelumnya --}}
                            @if ($user->avatar)
                                <img class="h-20 w-20 object-cover rounded-full border-2 border-slate-200" src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" />
                            @else
                                <img class="h-20 w-20 object-cover rounded-full border-2 border-slate-200" src="{{ asset('images/default-profile.png') }}" alt="{{ $user->name }}" />
                            @endif
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wider">Foto Profil (Opsional)</label>
                            <input type="file" name="avatar" accept="image/jpeg, image/png, image/jpg" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-slate-50 file:text-slate-700 hover:file:bg-slate-100">
                            {{-- 
                               @error('avatar') menangkap dan menampilkan pesan error validasi 
                               jika file yang diupload tidak sesuai aturan (misal: bukan gambar atau ukuran terlalu besar).
                            --}}
                            @error('avatar')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="max-w-xl">
                        <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wider">Nama Lengkap</label>
                        {{-- value="{{ old('name', $user->name) }}" berarti form akan mengisi data lama (jika error) atau menampilkan nama saat ini --}}
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:border-slate-300 text-sm">
                        @error('name')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="max-w-xl">
                        <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wider">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:border-slate-300 text-sm">
                        @error('email')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition-colors">
                            Simpan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

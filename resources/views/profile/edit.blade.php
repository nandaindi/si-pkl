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

            @if (session('status') === 'profile-updated')
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="text-sm font-bold">Profil berhasil diperbarui.</span>
                </div>
            @endif

            <div class="bg-white p-8 rounded-xl border border-slate-200">
                <h3 class="text-lg font-bold text-slate-900 mb-1 font-display">Informasi Profil</h3>
                <p class="text-slate-500 text-sm mb-6">Perbarui nama dan email Anda.</p>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('patch')

                    <div class="max-w-xl">
                        <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wider">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-blue-700 focus:border-blue-700 text-sm">
                        @error('name')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="max-w-xl">
                        <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wider">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-blue-700 focus:border-blue-700 text-sm">
                        @error('email')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition-colors">
                            Simpan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

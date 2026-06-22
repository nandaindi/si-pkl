@extends ('layouts.app')
@section ('content')
    @section ('header')
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ __('Edit Jadwal Sidang') }}</h2>
    @endsection
    <div class="py-6">
        <div class="max-w-3xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('pembimbing.jadwal-sidang.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-900 font-bold text-sm transition-colors mb-4">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Jadwal
                </a>
                <h2 class="text-3xl font-bold text-slate-900 font-display">Edit Jadwal Sidang</h2>
                <p class="text-slate-500 text-sm mt-1">Perbarui informasi penguji, waktu, atau ruangan sidang untuk <strong>{{ $jadwal_sidang->siswa->user->name }}</strong>.</p>
            </div>
            
            <div class="bg-white rounded-3xl border-2 border-slate-200 p-8 shadow-sm">
                <form action="{{ route('pembimbing.jadwal-sidang.update', $jadwal_sidang->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider font-label mb-2">Siswa</label>
                        <input type="text" disabled value="{{ $jadwal_sidang->siswa->user->name }} (NISN: {{ $jadwal_sidang->siswa->nisn }})" class="w-full px-4 py-3 bg-slate-100 border border-slate-100 rounded-xl text-slate-500 text-sm font-semibold cursor-not-allowed">
                        <p class="text-[10px] text-slate-400 mt-1">*Siswa tidak dapat diubah setelah jadwal dibuat.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider font-label mb-2">Pilih Guru Penguji <span class="text-red-500">*</span></label>
                        <select name="penguji_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-slate-700 text-sm font-semibold appearance-none">
                            <option value="">-- Pilih Guru Penguji --</option>
                            @foreach($pengujis as $penguji)
                                <option value="{{ $penguji->id }}" {{ $jadwal_sidang->penguji_id == $penguji->id ? 'selected' : '' }}>{{ $penguji->user->name }}</option>
                            @endforeach
                        </select>
                        @error('penguji_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider font-label mb-2">Waktu Sidang <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="waktu" value="{{ date('Y-m-d\TH:i', strtotime($jadwal_sidang->waktu)) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-slate-700 text-sm font-semibold">
                            @error('waktu') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider font-label mb-2">Ruangan <span class="text-red-500">*</span></label>
                            <input type="text" name="ruangan" value="{{ $jadwal_sidang->ruangan }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-slate-700 text-sm font-semibold">
                            @error('ruangan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-sm font-bold flex items-center justify-center gap-2 transition-colors">
                            <i class="fa-solid fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

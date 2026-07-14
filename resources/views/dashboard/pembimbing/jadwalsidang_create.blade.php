{{-- 
    View: Pembimbing - Buat Jadwal Sidang
    Fungsi: Form antarmuka bagi pembimbing untuk menentukan waktu, ruangan, dan penguji sidang siswa.
--}}
@extends ('layouts.app')
@section ('content')
    @section ('header')
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ __('Buat Jadwal Sidang') }}</h2>
    @endsection
    <div class="py-6">
        <div class="max-w-3xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('pembimbing.jadwal-sidang.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-900 font-bold text-sm transition-colors mb-4">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Jadwal
                </a>
                <h2 class="text-3xl font-bold text-slate-900 font-display">Buat Jadwal Sidang</h2>
                <p class="text-slate-500 text-sm mt-1">Jadwalkan ujian presentasi untuk siswa bimbingan Anda yang laporan akhirnya sudah terkumpul.</p>
            </div>
            
            <div class="bg-white rounded-3xl border-2 border-slate-200 p-8 shadow-sm">
                <form action="{{ route('pembimbing.jadwal-sidang.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider font-label mb-2">Pilih Siswa <span class="text-red-500">*</span></label>
                        <select name="siswa_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-slate-700 text-sm font-semibold appearance-none">
                            <option value="">-- Pilih Siswa Bimbingan --</option>
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id }}">{{ $siswa->user->name }} (NISN: {{ $siswa->nisn }})</option>
                            @endforeach
                        </select>
                        @if($siswas->isEmpty())
                            <p class="text-amber-500 text-xs mt-2 font-medium"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Tidak ada siswa yang siap dijadwalkan (Laporan Akhir belum terkumpul atau sudah memiliki jadwal).</p>
                        @endif
                        @error('siswa_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider font-label mb-2">Pilih Guru Penguji <span class="text-red-500">*</span></label>
                        <select name="penguji_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-slate-700 text-sm font-semibold appearance-none">
                            <option value="">-- Pilih Guru Penguji --</option>
                            @foreach($pengujis as $penguji)
                                <option value="{{ $penguji->id }}">{{ $penguji->user->name }}</option>
                            @endforeach
                        </select>
                        @error('penguji_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider font-label mb-2">Waktu Sidang <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="waktu" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-slate-700 text-sm font-semibold">
                            @error('waktu') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider font-label mb-2">Ruangan <span class="text-red-500">*</span></label>
                            <input type="text" name="ruangan" placeholder="Contoh: LAB TKJ 1" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-slate-700 text-sm font-semibold">
                            @error('ruangan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-sm font-bold flex items-center justify-center gap-2 transition-colors">
                            <i class="fa-solid fa-calendar-check"></i> Simpan Jadwal Sidang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

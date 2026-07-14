{{-- 
    View: Pembimbing - Jadwal Sidang (Index)
    Fungsi: Menampilkan daftar jadwal sidang untuk siswa-siswa bimbingannya.
    Berisi tabel jadwal dan tombol aksi untuk membuat/edit jadwal.
--}}
@extends ('layouts.app')
@section ('content')
    @section ('header')
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ __('Jadwal Sidang Bimbingan') }}</h2>
    @endsection
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-slate-900 font-display">Jadwal Sidang Praktik Kerja Lapangan</h2>
                <p class="text-slate-500 text-base mt-2">Daftar jadwal presentasi laporan akhir praktek kerja lapangan.</p>
            </div>
            <div class="flex items-center justify-between mb-6">
                <form action="{{ route('pembimbing.jadwal-sidang.index') }}" method="GET" class="relative w-96">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..." class="w-full pl-10 pr-4 py-2 border border-slate-100 rounded-xl focus:border-slate-300 text-sm bg-white shadow-sm" />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </form>
                <a href="{{ route('pembimbing.jadwal-sidang.create') }}" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-sm font-bold flex items-center justify-center gap-2 transition-colors whitespace-nowrap">
                    <i class="fa-solid fa-plus"></i> Buat Jadwal Baru
                </a>
            </div>
            <div class="bg-white overflow-hidden rounded-2xl border-2 border-slate-200 shadow-sm">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">Jadwal Mendatang</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-white text-slate-400 text-[11px] font-bold uppercase tracking-widest border-b border-slate-100"
                            >
                                <th class="px-6 py-4 whitespace-nowrap">Siswa</th>
                                <th class="px-6 py-4 whitespace-nowrap">Waktu Sidang</th>
                                <th class="px-6 py-4 whitespace-nowrap">Ruangan</th>
                                <th class="px-6 py-4 whitespace-nowrap">Guru Penguji</th>
                                <th class="px-6 py-4 text-center whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($jadwals as $jadwal)
                                <tr class="hover:bg-slate-50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-900 font-bold">
                                            {{ $jadwal->siswa->user->name }}
                                        </div>
                                        <div class="text-xs text-slate-500 mt-1">
                                            {{ $jadwal->siswa->kelas }} - {{ $jadwal->siswa->jurusan }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 text-slate-700">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <div>
                                                <div class="text-sm font-bold">
                                                    {{
                                                        \Carbon\Carbon::parse($jadwal->waktu)->isoFormat(
                                                            'dddd, D MMM Y',
                                                        )
                                                    }}
                                                </div>
                                                <div class="text-xs text-slate-500">
                                                    {{ \Carbon\Carbon::parse($jadwal->waktu)->isoFormat('HH:mm') }} WIB
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 text-slate-700 font-bold text-sm">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                            {{ $jadwal->ruangan }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-900 font-bold">
                                            {{ $jadwal->penguji->user->name }}
                                        </div>
                                        <div class="text-xs text-slate-500 font-medium">Penguji Internal</div>
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('pembimbing.jadwal-sidang.edit', $jadwal->id) }}" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 flex items-center justify-center transition-colors" title="Edit Jadwal">
                                                <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                            </a>
                                            <form action="{{ route('pembimbing.jadwal-sidang.destroy', $jadwal->id) }}" method="POST" data-confirm="Apakah Anda yakin ingin menghapus jadwal sidang ini?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center transition-colors" title="Hapus Jadwal">
                                                    <i class="fa-solid fa-trash text-[10px]"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <h4 class="text-slate-900 font-bold mb-1">Belum Ada Jadwal Sidang</h4>
                                            <p class="text-sm font-medium text-slate-500 max-w-sm">Saat ini belum ada siswa bimbingan Anda yang dijadwalkan untuk sidang presentasi.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-slate-200">
                    {{ $jadwals->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@extends ('layouts.app')

@section ('content')
    <div>
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Kelola Tempat PKL</h2>
                    <p class="text-slate-500 text-sm mt-1">Daftar instansi atau perusahaan mitra kerja.</p>
                </div>
                <a
                    href="{{ route('admin.tempat-pkl.create') }}"
                    class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 "
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Tempat PKL
                </a>
            </div>

            <!-- Bilah Pencarian & Filter -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
                <form action="{{ route('admin.tempat-pkl.index') }}" method="GET" class="relative w-full sm:w-96">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama instansi atau alamat..."
                        class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:ring-blue-700 focus:border-blue-700 text-sm"
                    />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </form>
            </div>

            <!-- Tabel -->
            <div class="bg-white overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200"
                            >
                                <th class="px-6 py-4 font-semibold w-20 whitespace-nowrap">Foto</th>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">Nama Instansi</th>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">Alamat Lengkap</th>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">Kuota Tersedia</th>
                                <th class="px-6 py-4 font-semibold text-right whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse ($tempat_pkls as $tempat)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 text-sm">
                                        @if ($tempat->gambar)
                                            <a href="{{ asset('storage/' . $tempat->gambar) }}" target="_blank" class="block w-32 h-20 rounded-xl overflow-hidden shadow-sm border border-slate-200 hover:shadow-md transition-all hover:scale-105" title="Klik untuk perbesar">
                                                <img
                                                    src="{{ asset('storage/' . $tempat->gambar) }}"
                                                    alt="{{ $tempat->nama_instansi }}"
                                                    class="w-full h-full object-cover"
                                                />
                                            </a>
                                        @else
                                            <div class="w-32 h-20 rounded-xl bg-slate-50 border border-slate-200 flex flex-col items-center justify-center text-slate-300">
                                                <i class="fa-regular fa-image text-xl mb-1"></i>
                                                <span class="text-[9px] font-bold uppercase tracking-wider">Tanpa Foto</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-900 font-medium">
                                        {{ $tempat->nama_instansi }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-500">{{ $tempat->alamat }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-500">
                                        <span
                                            class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full font-bold text-xs font-label"
                                            >{{ $tempat->kuota }} Siswa</span
                                        >
                                    </td>
                                    <td class="px-6 py-4 text-sm text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a
                                                href="{{ route('admin.tempat-pkl.edit', $tempat->id) }}"
                                                class="p-1.5 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-lg transition-colors "
                                                title="Edit Data"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form
                                                action="{{ route('admin.tempat-pkl.destroy', $tempat->id) }}"
                                                method="POST"
                                                data-confirm="Yakin ingin menghapus tempat PKL ini?"
                                                class="inline"
                                            >
                                                @csrf
                                                @method ('DELETE')
                                                <button
                                                    type="submit"
                                                    class="p-1.5 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-lg transition-colors "
                                                    title="Hapus Data"
                                                >
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                        <div class="flex flex-col items-center justify-center">
                                            
                                            <p class="text-sm font-medium">Belum ada data tempat PKL yang didaftarkan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

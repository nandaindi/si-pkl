@extends ('layouts.app')
@section ('content')
    <div>
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Kelola Data Siswa</h2>
                    <p class="text-slate-500 text-sm mt-1">Manajemen direktori peserta didik PKL.</p>
                </div>
                <a
                    href="{{ route('admin.siswa.create') }}"
                    class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Siswa
                </a>
            </div>
            <form action="{{ route('admin.siswa.index') }}" method="GET" class="relative w-96 mb-6">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NISN atau nama siswa..." class="w-full pl-10 pr-4 py-2 border border-slate-100 rounded-xl focus:border-slate-300 text-sm bg-white shadow-sm" />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </form>
            <div class="bg-white overflow-hidden rounded-2xl border-2 border-slate-200 shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200"
                            >
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">NISN</th>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">Nama Siswa</th>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">Kelas</th>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">Jurusan</th>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">Email</th>
                                <th class="px-6 py-4 font-semibold text-center whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse ($siswas as $siswa)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 text-sm text-slate-900 font-label">{{ $siswa->nisn }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-900 font-medium">
                                        {{ $siswa->user->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-500">{{ $siswa->kelas }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-500">{{ $siswa->jurusan }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-500">{{ $siswa->user->email }}</td>
                                    <td class="px-6 py-4 text-sm text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a
                                                href="{{ route('admin.siswa.edit', $siswa->id) }}"
                                                class="p-1.5 bg-slate-50 text-slate-900 hover:bg-slate-200 hover:text-slate-900 rounded-lg transition-colors"
                                                title="Edit Data"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form
                                                action="{{ route('admin.siswa.destroy', $siswa->id) }}"
                                                method="POST"
                                                data-confirm="Yakin ingin menghapus data siswa ini?"
                                                class="inline"
                                            >
                                                @csrf
                                                @method ('DELETE')
                                                <button
                                                    type="submit"
                                                    class="p-1.5 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-lg transition-colors"
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
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <p class="text-sm font-medium">Belum ada data siswa.</p>
                                            <p class="text-xs text-slate-400 mt-1">Silakan tambah data siswa untuk memulai.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-slate-200">
                    {{ $siswas->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection

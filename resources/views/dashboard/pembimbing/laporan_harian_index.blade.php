@extends ('layouts.app')

@section ('content')
    @section ('header')
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ __('Monitoring Laporan PKL') }}</h2>
    @endsection
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-slate-900 font-display">Monitoring Laporan Harian Siswa</h2>
                <p class="text-slate-500 text-base mt-2">Pantau dan setujui laporan aktivitas harian yang diisi oleh siswa bimbingan Anda.</p>
            </div>

            <!-- Tab -->
            <div class="flex items-center gap-4 border-b border-slate-200 mb-6">
                <a
                    href="{{ route('pembimbing.laporan-harian.index') }}"
                    class="px-4 py-3 text-sm font-bold text-blue-700 border-b-2 border-blue-700 transition-all flex items-center gap-2"
                >
                    Laporan Harian
                </a>
                <a
                    href="{{ route('pembimbing.laporan.index') }}"
                    class="px-4 py-3 text-sm font-bold text-slate-500 hover:text-blue-700 border-b-2 border-transparent hover:border-blue-700 transition-all"
                    >Laporan Akhir</a
                >
            </div>

            <!-- Bilah Pencarian & Filter -->
            <div
                class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4 mb-6"
            >
                <form
                    action="{{ route('pembimbing.laporan-harian.index') }}"
                    method="GET"
                    class="relative w-full sm:w-96"
                >
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama siswa atau kegiatan..."
                        class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:ring-blue-700 focus:border-blue-700 text-sm"
                    />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </form>
            </div>

            <!-- Tabel Daftar Laporan Harian Dikelompokkan per Siswa -->
            <div class="bg-white overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">Daftar Laporan Siswa</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-white text-slate-400 text-[11px] font-bold uppercase tracking-widest border-b border-slate-100"
                            >
                                <th class="px-6 py-4 whitespace-nowrap">Siswa</th>
                                <th class="px-6 py-4 whitespace-nowrap">Tanggal & Kegiatan</th>
                                <th class="px-6 py-4 text-right whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($laporans as $harian)
                                <tr class="hover:bg-slate-50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm shrink-0"
                                            >
                                                {{ substr($harian->siswa->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-sm text-slate-900 font-bold">
                                                    {{ $harian->siswa->user->name }}
                                                </div>
                                                <div class="text-[11px] text-slate-500 font-label tracking-wide">
                                                    NISN: {{ $harian->siswa->nisn }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs font-bold text-slate-900">
                                            {{
                                                \Carbon\Carbon::parse($harian->tanggal)->translatedFormat(
                                                    'd M Y',
                                                )
                                            }}
                                        </div>
                                        <div class="text-xs text-slate-500 mt-1 line-clamp-2 max-w-sm">
                                            {{ $harian->kegiatan }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a
                                                href="{{ route('pembimbing.laporan-harian.show', $harian->siswa->id) }}"
                                                class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 font-bold text-xs rounded-lg transition-colors"
                                            >
                                                Lihat Lengkap
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <h4 class="text-slate-900 font-bold mb-1">Belum Ada Laporan Harian</h4>
                                            <p class="text-sm font-medium text-slate-500 max-w-sm">Saat ini belum ada siswa bimbingan yang mengisi laporan harian PKL.</p>
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

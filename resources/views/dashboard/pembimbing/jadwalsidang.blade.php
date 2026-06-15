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

            <!-- Bilah Pencarian & Filter -->
            <div
                class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4 mb-6"
            >
                <form
                    action="{{ route('pembimbing.jadwal-sidang.index') }}"
                    method="GET"
                    class="relative w-full sm:w-96"
                >
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama siswa..."
                        class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:ring-blue-700 focus:border-blue-700 text-sm"
                    />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </form>
            </div>

            <!-- List Table -->
            <div class="bg-white overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
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
                                <th class="px-6 py-4 text-right whitespace-nowrap">Guru Penguji</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($jadwals as $jadwal)
                                <tr class="hover:bg-slate-50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm shrink-0"
                                            >
                                                {{ substr($jadwal->siswa->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-sm text-slate-900 font-bold">
                                                    {{ $jadwal->siswa->user->name }}
                                                </div>
                                                <div class="text-[11px] text-slate-500 font-label tracking-wide">
                                                    {{ $jadwal->siswa->kelas }} - {{ $jadwal->siswa->jurusan }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div
                                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-blue-700 rounded-xl"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <div>
                                                <div class="text-sm font-bold">
                                                    {{
                                                        \Carbon\Carbon::parse($jadwal->waktu)->isoFormat(
                                                            'dddd, D MMM Y',
                                                        )
                                                    }}
                                                </div>
                                                <div class="text-xs font-label opacity-80">
                                                    {{ \Carbon\Carbon::parse($jadwal->waktu)->isoFormat('HH:mm') }} WIB
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div
                                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-100 text-slate-700 rounded-xl font-bold text-sm"
                                        >
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                            {{ $jadwal->ruangan }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="text-sm text-slate-900 font-bold">
                                            {{ $jadwal->penguji->user->name }}
                                        </div>
                                        <div class="text-xs text-slate-500 font-medium">Penguji Internal</div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-20 text-center">
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
            </div>
        </div>
    </div>
@endsection

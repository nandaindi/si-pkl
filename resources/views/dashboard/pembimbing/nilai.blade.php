@extends ('layouts.app')
@section ('content')
    @section ('header')
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ __('Rekap Nilai PKL') }}</h2>
    @endsection
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-slate-900 font-display">Rekap Nilai & Hasil Kelulusan</h2>
                <p class="text-slate-500 text-base mt-2">Input nilai pembimbing dan tinjau akumulasi nilai akhir setelah ujian sidang selesai.</p>
            </div>
            <form action="{{ route('pembimbing.nilai.index') }}" method="GET" class="relative w-96 mb-6">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..." class="w-full pl-10 pr-4 py-2 border border-slate-100 rounded-xl focus:border-slate-300 text-sm bg-white shadow-sm" />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </form>
            <div class="bg-white overflow-hidden rounded-2xl border-2 border-slate-200 shadow-sm">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                        Daftar Nilai Siswa
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-white text-slate-400 text-[11px] font-bold uppercase tracking-widest border-b border-slate-100"
                            >
                                <th class="px-6 py-4 whitespace-nowrap">Siswa</th>
                                <th class="px-3 py-4 text-center min-w-[130px] whitespace-nowrap">Nilai Pembimbing</th>
                                <th class="px-3 py-4 text-center min-w-[130px] whitespace-nowrap">Nilai Penguji</th>
                                <th class="px-3 py-4 text-center min-w-[130px] whitespace-nowrap">Nilai Akhir</th>
                                <th class="px-6 py-4 text-center whitespace-nowrap">Input Nilai</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($jadwals as $jadwal)
                                @php
                                    $nilai = $jadwal->siswa->nilaiPkls;
                                @endphp
                                <tr class="hover:bg-slate-50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-900 font-bold">
                                            {{ $jadwal->siswa->user->name }}
                                        </div>
                                        <div class="text-xs text-slate-500 mt-1">
                                            NISN: {{ $jadwal->siswa->nisn }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-4">
                                        <div
                                            class="text-center font-bold font-label {{ isset($nilai->nilai_pembimbing) ? 'text-slate-900 text-base' : 'text-slate-400 text-sm' }}"
                                        >
                                            {{ $nilai->nilai_pembimbing ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-4">
                                        <div
                                            class="text-center font-bold font-label {{ isset($nilai->nilai_penguji) ? 'text-slate-700 text-base' : 'text-slate-400 text-sm' }}"
                                        >
                                            {{ $nilai->nilai_penguji ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-4">
                                        <div
                                            class="text-center font-bold font-label {{ isset($nilai->nilai_akhir) ? 'text-slate-900 text-base' : 'text-slate-400 text-sm' }}"
                                        >
                                            {{ $nilai->nilai_akhir ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form
                                            action="{{ route('pembimbing.nilai.store') }}"
                                            method="POST"
                                            class="inline-flex items-center justify-center gap-2"
                                        >
                                            @csrf
                                            <input type="hidden" name="siswa_id" value="{{ $jadwal->siswa->id }}" />
                                            <input
                                                type="number"
                                                name="nilai_pembimbing"
                                                min="0"
                                                max="100"
                                                step="0.1"
                                                placeholder="0-100"
                                                required
                                                value="{{ $nilai->nilai_pembimbing ?? '' }}"
                                                class="px-3 py-2 text-xs border border-slate-100 rounded-xl w-24 text-center focus:border-slate-300 font-label font-bold"
                                            />
                                            <button
                                                type="submit"
                                                class="px-4 py-2 bg-blue-600 hover:bg-slate-900 text-white font-bold text-xs rounded-xl "
                                            >
                                                Simpan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <h4 class="text-slate-900 font-bold mb-1">Belum Ada Jadwal Sidang</h4>
                                            <p class="text-sm font-medium text-slate-500 max-w-sm">Belum ada siswa bimbingan Anda yang terdaftar pada jadwal sidang saat ini.</p>
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

@extends ('layouts.app')
@section ('content')
    @section ('header')
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ __('Laporan Harian Siswa') }}</h2>
    @endsection
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="mb-6">
                <a
                    href="{{ route('pembimbing.laporan-harian.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-slate-900 bg-white border border-slate-200 hover:bg-slate-50 px-4 py-2 rounded-xl transition-all shadow-sm"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar
                </a>
            </div>
            <div class="mb-8 bg-white p-6 rounded-xl border border-slate-200 flex items-center gap-5">
                <div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Riwayat Laporan Siswa</div>
                    <h2 class="text-xl font-bold text-slate-900 font-display">
                        {{ $siswa->user->name }}
                    </h2>
                    <div class="flex items-center gap-2 mt-1.5">
                        <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[11px] font-label font-bold tracking-wide">NISN: {{ $siswa->nisn }}</span>
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden sm:rounded-xl border border-slate-200">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-slate-50 text-slate-400 text-[11px] font-bold uppercase tracking-widest border-b border-slate-100"
                            >
                                <th class="px-6 py-4 whitespace-nowrap">Tanggal</th>
                                <th class="px-6 py-4">Kegiatan</th>
                                <th class="px-6 py-4 whitespace-nowrap text-center">Bukti Foto</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($laporans as $harian)
                                <tr class="hover:bg-slate-50 transition-colors group">
                                    <td class="px-6 py-4 align-top">
                                        <div class="text-xs font-bold text-slate-900">
                                            {{
                                                \Carbon\Carbon::parse($harian->tanggal)->translatedFormat(
                                                    'd M Y',
                                                )
                                            }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <div class="text-sm text-slate-700 whitespace-pre-wrap break-words">{{ $harian->kegiatan }}</div>
                                    </td>
                                    <td class="px-6 py-4 align-top text-center">
                                        @if ($harian->bukti_foto)
                                            <a
                                                href="{{ asset('storage/' . $harian->bukti_foto) }}"
                                                target="_blank"
                                                class="mx-auto block w-20 h-20 rounded-lg overflow-hidden border border-slate-200 hover:border-slate-300 transition-colors"
                                            >
                                                <img
                                                    src="{{ asset('storage/' . $harian->bukti_foto) }}"
                                                    alt="Bukti Foto"
                                                    class="w-full h-full object-cover"
                                                />
                                            </a>
                                        @else
                                            <span class="text-xs text-slate-400 italic">Tidak ada foto</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <h4 class="text-slate-900 font-bold mb-1">Belum Ada Riwayat</h4>
                                            <p class="text-sm font-medium text-slate-500 max-w-sm">Siswa ini belum memiliki catatan laporan harian.</p>
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

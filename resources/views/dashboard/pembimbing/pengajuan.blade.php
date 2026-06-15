@extends ('layouts.app')

@section ('content')
    @section ('header')
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ __('Verifikasi Pengajuan PKL') }}</h2>
    @endsection
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-slate-900 font-display">Verifikasi Pengajuan Tempat Magang</h2>
                <p class="text-slate-500 text-base mt-2">Tinjau permohonan PKL siswa dan tentukan kelayakan berdasarkan kuota industri.</p>
            </div>

            <!-- Dashboard Metric Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @php
                    $total = $pengajuans->count();
                    $disetujui = $pengajuans->where('status', 'disetujui')->count();
                    $ditolak = $pengajuans->where('status', 'ditolak')->count();
                    $pending = $total - $disetujui - $ditolak;
                @endphp

                <div class="bg-white rounded-xl p-6 border border-slate-200 flex items-center gap-5">
                    <div>
                        <div class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-1">
                            Total Pengajuan
                        </div>
                        <div class="text-3xl font-black text-slate-900">{{ $total }}</div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 border border-slate-200 flex items-center gap-5">
                    <div>
                        <div class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-1">
                            Telah Disetujui
                        </div>
                        <div class="text-3xl font-black text-slate-900">{{ $disetujui }}</div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 border border-slate-200 flex items-center gap-5">
                    <div>
                        <div class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-1">
                            Menunggu & Ditolak
                        </div>
                        <div class="text-3xl font-black text-slate-900">{{ $pending + $ditolak }}</div>
                    </div>
                </div>
            </div>

            <!-- Bilah Pencarian & Filter -->
            <div
                class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4 mb-6"
            >
                <form action="{{ route('pembimbing.pengajuan.index') }}" method="GET" class="relative w-full sm:w-96">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama siswa atau instansi..."
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
                    <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">Daftar Pengajuan Siswa</h3>
                </div>
                <div class="overflow-x-auto">
                    @php
                        $hasPending = false;
                        foreach ($pengajuans as $p) {
                            if ($p->status === 'pending') {
                                $hasPending = true;
                                break;
                            }
                        }
                    @endphp
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-white text-slate-400 text-[11px] font-bold uppercase tracking-widest border-b border-slate-100"
                            >
                                <th class="px-6 py-4 whitespace-nowrap">Siswa</th>
                                <th class="px-6 py-4 whitespace-nowrap">Instansi PKL</th>
                                <th class="px-6 py-4 whitespace-nowrap">Status</th>
                                <th class="px-6 py-4 text-right whitespace-nowrap {{ !$hasPending ? 'hidden' : '' }}">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($pengajuans as $pengajuan)
                                <tr class="hover:bg-slate-50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm shrink-0"
                                            >
                                                {{ substr($pengajuan->siswa->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-sm text-slate-900 font-bold">
                                                    {{ $pengajuan->siswa->user->name }}
                                                </div>
                                                <div class="text-[11px] text-slate-500 font-label tracking-wide">
                                                    NISN: {{ $pengajuan->siswa->nisn }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-900 font-bold">
                                            {{ $pengajuan->tempatPkl->nama_instansi }}
                                        </div>
                                        <div class="text-[11px] text-slate-500 font-medium">
                                            Kuota Sisa:
                                            <span
                                                class="{{ $pengajuan->tempatPkl->kuota > 0 ? 'text-green-600' : 'text-red-600' }} font-bold"
                                                >{{ $pengajuan->tempatPkl->kuota }}</span
                                            >
                                            Siswa
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($pengajuan->status === 'disetujui')
                                            <span class="text-xs font-bold text-slate-900">Disetujui</span>
                                        @elseif ($pengajuan->status === 'ditolak')
                                            <div class="flex flex-col items-start gap-0.5">
                                                <span class="text-xs font-bold text-slate-500">Ditolak</span>
                                                @if ($pengajuan->alasan_ditolak)
                                                    <p class="text-[10px] text-slate-500 italic max-w-[180px] leading-relaxed">Alasan: "{{ $pengajuan->alasan_ditolak }}"</p>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-xs font-bold text-slate-500">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right {{ !$hasPending ? 'hidden' : '' }}">
                                        @if ($pengajuan->status === 'pending')
                                            <div class="flex items-center justify-end gap-2">
                                                <form
                                                    id="reject-form-{{ $pengajuan->id }}"
                                                    action="{{ route('pembimbing.pengajuan.verifikasi', $pengajuan->id) }}"
                                                    method="POST"
                                                    class="inline"
                                                    onsubmit="confirmRejection(event, {{ $pengajuan->id }}, '{{ addslashes($pengajuan->siswa->user->name) }}')"
                                                >
                                                    @csrf
                                                    @method ('PATCH')
                                                    <input type="hidden" name="status" value="ditolak" />
                                                    <input
                                                        type="hidden"
                                                        name="alasan_ditolak"
                                                        id="alasan-ditolak-{{ $pengajuan->id }}"
                                                        value=""
                                                    />
                                                    <button
                                                        type="submit"
                                                        class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 font-bold text-xs rounded-xl transition-colors"
                                                    >
                                                        Tolak
                                                    </button>
                                                </form>
                                                <form
                                                    action="{{ route('pembimbing.pengajuan.verifikasi', $pengajuan->id) }}"
                                                    method="POST"
                                                    class="inline"
                                                >
                                                    @csrf
                                                    @method ('PATCH')
                                                    <input type="hidden" name="status" value="disetujui" />
                                                    <button
                                                        type="submit"
                                                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-bold text-xs rounded-xl"
                                                    >
                                                        Setujui
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ !$hasPending ? '4' : '5' }}" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <h4 class="text-slate-900 font-bold mb-1">Belum Ada Pengajuan</h4>
                                            <p class="text-sm font-medium text-slate-500 max-w-sm">Saat ini belum ada pengajuan tempat magang baru dari siswa.</p>
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
    <script>
        function confirmRejection(event, id, studentName) {
            event.preventDefault(); // Stop form submission

            Swal.fire({
                title: 'Alasan Penolakan',
                html: `<p class="text-sm text-slate-500 mb-3">Berikan alasan mengapa pengajuan magang <strong>${studentName}</strong> ditolak:</p>`,
                input: 'textarea',
                inputPlaceholder: 'Tulis alasan di sini...',
                inputAttributes: {
                    autocapitalize: 'off',
                    required: 'true',
                },
                showCancelButton: true,
                confirmButtonText: 'Tolak Pengajuan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                inputValidator: (value) => {
                    if (!value || value.trim() === '') {
                        return 'Alasan penolakan tidak boleh kosong!';
                    }
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('alasan-ditolak-' + id).value = result.value;
                    document.getElementById('reject-form-' + id).submit();
                }
            });
        }
    </script>
@endsection

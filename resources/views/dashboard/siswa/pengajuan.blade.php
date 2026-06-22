@extends ('layouts.app')
@section ('content')
    @section ('header')
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ __('Mengajukan PKL') }}</h2>
    @endsection
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 font-display">Mengajukan PKL</h2>
                    <p class="text-slate-500 text-sm mt-1">Daftar tempat magang yang diajukan beserta status verifikasinya.</p>
                </div>
                @if (!$has_approved && !$pengajuans->contains('status', 'pending'))
                    <a
                        href="{{ route('siswa.pengajuan.create') }}"
                        class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2"
                    >
                        <i class="fa-solid fa-plus text-xs"></i>
                        Ajukan Tempat Baru
                    </a>
                @endif
            </div>
            <div class="grid grid-cols-1 gap-6">
                @forelse ($pengajuans as $pengajuan)
                    <div
                        class="bg-white border {{ $pengajuan->status === 'disetujui' ?  : ($pengajuan->status === 'ditolak' ? 'border-rose-200' : 'border-slate-200') }} rounded-3xl p-8 min-h-[260px] flex flex-col shadow-sm relative overflow-hidden group hover:shadow-md transition-all"
                    >
                        <div class="flex flex-col md:flex-row justify-between gap-8 mb-8 relative z-10">
                            <div class="flex-1">
                                @if ($pengajuan->status !== 'disetujui')
                                    <div class="mb-4">
                                        @if ($pengajuan->status === 'ditolak')
                                            <span
                                                class="px-3 py-1.5 bg-rose-50 text-rose-700 text-[10px] uppercase font-black tracking-widest rounded-lg border border-rose-200/50"
                                                >Ditolak</span
                                            >
                                        @else
                                            <span
                                                class="px-3 py-1.5 bg-amber-50 text-amber-700 text-[10px] uppercase font-black tracking-widest rounded-lg border border-amber-200/50"
                                                >Menunggu</span
                                            >
                                        @endif
                                    </div>
                                @endif
                                <h3 class="text-2xl font-bold text-slate-900 font-display mb-2">
                                    {{ $pengajuan->tempatPkl->nama_instansi }}
                                </h3>
                                <div class="flex items-start gap-2.5 text-sm text-slate-500 mt-4 max-w-xl">
                                    <i class="fa-solid fa-location-dot mt-1 text-slate-400"></i>
                                    <span class="leading-relaxed">{{ $pengajuan->tempatPkl->alamat }}</span>
                                </div>
                            </div>
                            @if ($pengajuan->tempatPkl->gambar)
                                <div
                                    class="shrink-0 w-full md:w-64 h-40 rounded-2xl overflow-hidden border-2 border-slate-200 shadow-sm"
                                >
                                    <img
                                        src="{{ Storage::url($pengajuan->tempatPkl->gambar) }}"
                                        alt="Foto Tempat PKL"
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                                    />
                                </div>
                            @else
                                <div
                                    class="shrink-0 w-full md:w-64 h-40 rounded-2xl overflow-hidden border-2 border-slate-200 shadow-sm bg-slate-50 flex items-center justify-center"
                                >
                                    <i class="fa-solid fa-building text-4xl text-slate-300"></i>
                                </div>
                            @endif
                        </div>
                        @if ($pengajuan->status === 'ditolak' && $pengajuan->alasan_ditolak)
                            <div
                                class="mb-4 bg-rose-50 rounded-xl p-3.5 border border-rose-100/50 text-xs text-rose-700 leading-relaxed"
                            >
                                <strong class="block mb-1 font-bold text-rose-800">Alasan Penolakan:</strong>
                                {{ $pengajuan->alasan_ditolak }}
                            </div>
                        @endif
                        <div class="pt-6 border-t border-slate-100 flex items-center justify-between mt-auto">
                            <div class="flex items-center gap-2 text-xs text-slate-400 font-medium">
                                <i class="fa-regular fa-clock"></i>
                                Diajukan pada {{ $pengajuan->created_at->isoFormat('D MMMM Y') }}
                            </div>
                            @if ($pengajuan->status === 'pending')
                                <form
                                    action="{{ route('siswa.pengajuan.destroy', $pengajuan->id) }}"
                                    method="POST"
                                    data-confirm="Yakin ingin membatalkan pengajuan ini? Anda bisa mengajukan tempat lain setelahnya."
                                    class="inline-block"
                                >
                                    @csrf
                                    @method ('DELETE')
                                    <button
                                        type="submit"
                                        class="text-[11px] font-bold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 px-3.5 py-1.5 rounded-lg transition-colors flex items-center gap-1.5"
                                    >
                                        <i class="fa-solid fa-xmark"></i>
                                        Batalkan Pengajuan
                                    </button>
                                </form>
                            @endif
                        </div>
                        @if ($pengajuan->status === 'disetujui')
                            <div
                                class="absolute -right-8 -bottom-8 w-32 h-32 bg-green-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500 pointer-events-none"
                            ></div>
                            <i
                                class="fa-solid fa-circle-check absolute bottom-6 right-6 text-green-500 text-4xl opacity-10 pointer-events-none"
                            ></i>
                        @endif
                    </div>
                @empty
                    <div
                        class="col-span-full bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl p-12 text-center"
                    >
                        <div
                            class="w-16 h-16 bg-white border-2 border-slate-200 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm"
                        >
                            <i class="fa-solid fa-briefcase text-slate-400 text-2xl"></i>
                        </div>
                        <h4 class="text-slate-900 font-bold mb-1 text-lg">Belum Ada Pengajuan</h4>
                        <p class="text-sm font-medium text-slate-500 max-w-sm mx-auto">Anda belum pernah mengajukan tempat PKL. Silakan klik tombol "Ajukan Tempat Baru" di atas.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@extends ('layouts.app')
@section ('content')
    @section ('header')
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ __('Sertifikat PKL') }}</h2>
    @endsection
    <div class="py-6">
        <div class="max-w-xl mx-auto">
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-bold text-slate-900 font-display">Unduh Sertifikat PKL</h2>
                <p class="text-slate-500 text-sm mt-1">Sertifikat resmi tanda kelulusan magang industri.</p>
            </div>
            @if ($sertifikat)
                <div
                    class="bg-white p-8 rounded-xl border border-slate-200 relative overflow-hidden text-center"
                >
                    <i class="fa-solid fa-medal text-amber-500 text-5xl mb-4 block"></i>
                    <h3 class="text-xl font-extrabold text-slate-900 font-display">
                        Selamat! Sertifikat Anda Telah Terbit
                    </h3>
                    <p class="text-slate-500 text-xs mt-2 font-semibold">Nomor Sertifikat:</p>
                    <span
                        class="inline-block mt-1 px-4 py-1.5 bg-slate-100 text-slate-800 font-bold text-sm rounded-xl font-label"
                        >{{ $sertifikat->nomor_sertifikat }}</span
                    >
                    <div class="mt-8 pt-6 border-t border-slate-100">
                        <a
                            href="{{ route('sertifikat.cetak', $sertifikat->id) }}"
                            target="_blank"
                            class="w-full bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-xl text-sm font-bold flex items-center justify-center gap-2 shadow-sm hover:shadow transition-all"
                        >
                            <i class="fa-solid fa-print text-sm"></i>
                            Cetak Dokumen Sertifikat
                        </a>
                    </div>
                </div>
            @else
                <div
                    class="bg-white p-8 rounded-xl border border-slate-200 relative overflow-hidden text-center"
                >
                    <i class="fa-solid fa-award text-slate-300 text-5xl mb-4 block"></i>
                    <h3 class="text-xl font-extrabold text-slate-400 font-display">Sertifikat Belum Diterbitkan</h3>
                    <p class="text-slate-500 text-xs mt-3 leading-relaxed">Sertifikat magang Anda masih terkunci. Pembimbing akan menerbitkan berkas ini setelah Anda melaksanakan sidang laporan akhir dan memperoleh nilai kelulusan.</p>
                </div>
            @endif
        </div>
    </div>
@endsection

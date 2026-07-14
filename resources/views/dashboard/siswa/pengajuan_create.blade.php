{{-- 
    View: Siswa - Buat Pengajuan Tempat PKL
    Fungsi: Form bagi siswa untuk memilih tempat PKL dari daftar instansi yang masih memiliki kuota kosong.
--}}
@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6">
    <div class="mb-8 border-b border-gray-200 pb-5">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Eksplorasi Mitra Industri</h2>
        <p class="text-gray-500 mt-2 text-lg">Temukan dan pilih perusahaan terbaik untuk melaksanakan Praktik Kerja Lapangan (PKL) Anda.</p>
    </div>



    <form action="{{ route('siswa.pengajuan.store') }}" method="POST" id="form-pengajuan">
        @csrf

        <!-- Search & Filter Bar -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-8 flex flex-col sm:flex-row gap-4">
            <div class="relative flex-1">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                    <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                </div>
                <input type="text" id="search" placeholder="Cari nama perusahaan, kota, atau kata kunci..." class="block w-full rounded-lg border-0 py-3 pl-11 pr-4 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
            </div>
            <div class="relative sm:w-72">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                    <i class="fa-solid fa-filter text-gray-400"></i>
                </div>
                <select id="filter-jurusan" class="block w-full rounded-lg border-0 py-3 pl-11 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 appearance-none bg-white">
                    <option value="">Semua Jurusan</option>
                    <option value="Teknik Kendaraan Ringan">Teknik Kendaraan Ringan</option>
                    <option value="Manajemen Perkantoran">Manajemen Perkantoran</option>
                    <option value="Desain Komunikasi Visual">Desain Komunikasi Visual</option>
                    <option value="Teknik Komputer Jaringan">Teknik Komputer Jaringan</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4">
                    <i class="fa-solid fa-chevron-down text-gray-400 text-xs"></i>
                </div>
            </div>
        </div>

        @error('tempat_pkl_id')
            <div class="text-red-500 text-sm mb-6 bg-red-50 p-3 rounded-lg border border-red-100"><i class="fa-solid fa-circle-info mr-2"></i>{{ $message }}</div>
        @enderror

        <!-- Job Cards Grid (Ponytail mode: Native radio inputs, pure CSS state) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6" id="instansi-list">
            @foreach ($tempat_pkls as $tempat)
                <div class="instansi-card relative" 
                     data-name="{{ strtolower($tempat->nama_instansi) }}" 
                     data-alamat="{{ strtolower($tempat->alamat) }}" 
                     data-jurusan="{{ $tempat->jurusan ?? '' }}">
                     
                    <!-- Native Radio Input (Visible for HTML5 validation to work perfectly) -->
                    <input type="radio" name="tempat_pkl_id" value="{{ $tempat->id }}" id="pkl-{{ $tempat->id }}" class="peer absolute top-6 right-6 w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer z-10" required>
                    
                    <label for="pkl-{{ $tempat->id }}" class="flex flex-col w-full h-full cursor-pointer rounded-2xl border border-gray-200 bg-white shadow-sm hover:border-blue-400 peer-checked:border-blue-600 peer-checked:bg-blue-50/30 peer-checked:ring-2 peer-checked:ring-blue-100 transition-all duration-200 overflow-hidden">
                        
                        <!-- Card Banner Image -->
                        @if($tempat->gambar)
                            <div class="w-full h-48 bg-gray-100 border-b border-gray-100 shrink-0">
                                <img src="{{ asset('storage/' . $tempat->gambar) }}" alt="{{ $tempat->nama_instansi }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-blue-50 to-indigo-50 border-b border-gray-100 shrink-0 flex items-center justify-center">
                                <i class="fa-solid fa-building text-6xl text-blue-200 shadow-sm"></i>
                            </div>
                        @endif

                        <!-- Card Content -->
                        <div class="p-6 flex flex-col flex-1">
                            <!-- Card Header -->
                            <div class="mb-5 pr-8">
                                <h3 class="text-xl font-bold text-gray-900 leading-tight line-clamp-2">{{ $tempat->nama_instansi }}</h3>
                                <p class="text-sm text-gray-500 mt-2 flex items-center gap-1.5">
                                    <i class="fa-solid fa-building text-gray-400 w-3 text-center"></i> 
                                    Mitra Industri
                                </p>
                            </div>

                        <!-- Card Body (Text info without badges) -->
                        <div class="flex flex-col gap-2 mt-auto mb-5">
                            <span class="text-sm text-gray-600 flex items-center gap-2">
                                <i class="fa-solid fa-graduation-cap text-gray-400 w-4 text-center"></i>
                                {{ $tempat->jurusan ?: 'Semua Jurusan' }}
                            </span>
                            <span class="text-sm text-gray-600 flex items-start gap-2" title="{{ $tempat->alamat }}">
                                <i class="fa-solid fa-location-dot text-gray-400 w-4 text-center mt-0.5"></i>
                                <span class="line-clamp-2">{{ $tempat->alamat }}</span>
                            </span>
                        </div>

                        <!-- Card Footer -->
                        <div class="pt-4 border-t border-gray-100 flex items-center justify-between mt-auto">
                            <span class="text-sm font-medium text-gray-500">Sisa Kuota:</span>
                            <span class="text-sm font-extrabold {{ $tempat->sisa_kuota > 3 ? 'text-emerald-600' : 'text-orange-600' }}">
                                {{ $tempat->sisa_kuota }} Posisi
                            </span>
                        </div>
                        </div>
                    </label>
                </div>
            @endforeach
        </div>

        <div id="no-results" class="hidden text-center py-20 px-6 bg-white rounded-2xl border border-dashed border-gray-300 mt-6 shadow-sm">
            <div class="mx-auto h-24 w-24 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                <i class="fa-solid fa-magnifying-glass text-3xl text-gray-300"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Tidak ada lowongan ditemukan</h3>
            <p class="text-gray-500 mt-2 max-w-md mx-auto">Kami tidak dapat menemukan mitra industri yang cocok dengan pencarian atau filter Anda.</p>
        </div>

        <!-- Normal Submit Section (No sticky fixed positioning) -->
        <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-gray-500">Pilih satu instansi di atas sebelum mengajukan.</p>
            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <a href="{{ route('siswa.pengajuan.index') }}" class="px-5 py-3 rounded-xl text-sm font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors text-center w-full sm:w-auto">Batal</a>
                <button type="submit" class="px-8 py-3 rounded-xl text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-sm w-full sm:w-auto">
                    Ajukan Sekarang <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    // Hanya perlu sedikit Vanilla JS untuk search/filter. Form submit 100% Native HTML.
    const searchInput = document.getElementById('search');
    const filterJurusan = document.getElementById('filter-jurusan');
    const cards = document.querySelectorAll('.instansi-card');
    const list = document.getElementById('instansi-list');
    const noResults = document.getElementById('no-results');

    function filter() {
        const q = searchInput.value.toLowerCase();
        const j = filterJurusan.value;
        let visible = 0;

        cards.forEach(card => {
            const show = (card.dataset.name.includes(q) || card.dataset.alamat.includes(q)) && 
                         (j === "" || card.dataset.jurusan === j || card.dataset.jurusan === "");
            card.style.display = show ? 'block' : 'none';
            if (show) visible++;
        });

        noResults.classList.toggle('hidden', visible > 0);
        list.classList.toggle('hidden', visible === 0);
    }

    searchInput.addEventListener('input', filter);
    filterJurusan.addEventListener('change', filter);
</script>
@endsection

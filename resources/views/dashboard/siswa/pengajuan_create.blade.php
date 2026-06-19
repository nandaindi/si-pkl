@extends ('layouts.app')
@section ('content')
    <style>
        /* Card & Selection Layout Styling */
        .search-input {
            background-color: var(--color-paper-3);
            border: 2px solid var(--color-border);
            border-radius: var(--radius-input);
            color: var(--color-ink);
            transition: all 300ms var(--ease-spring);
        }
        .search-input:focus {
            border-color: var(--color-border);
            background-color: var(--color-paper);
            outline: none;
            box-shadow: none !important;
        }
        .company-card {
            background-color: var(--color-paper-2);
            border: 2px solid var(--color-border);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-clay);
            transition: border-color 200ms ease-out, box-shadow 200ms ease-out;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        .company-card:hover {
            box-shadow: var(--shadow-clay-hover);
            border-color: var(--color-border);
        }
        .company-card.is-active {
            border-color: var(--color-border);
            background-color: var(--color-paper);
            box-shadow:
                0 12px 32px -12px oklch(20% 0.012 250 / 0.15),
                inset -4px -4px 10px oklch(20% 0.012 250 / 0.02),
                inset 4px 4px 10px oklch(100% 0 0 / 0.95);
        }
        .company-logo-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.25rem;
            text-transform: uppercase;
            border: 2px solid var(--color-border);
            transition: all 300ms var(--ease-spring);
        }
        .company-card.is-active .company-logo-badge {
            border-color: var(--color-border);
        }
        /* Initial letter logo colors */
        .logo-mint {
            background-color: oklch(90% 0.1 140);
            color: oklch(35% 0.12 140);
        }
        .logo-cyan {
            background-color: oklch(90% 0.1 235);
            color: oklch(35% 0.12 235);
        }
        .logo-coral {
            background-color: oklch(90% 0.12 25);
            color: oklch(35% 0.12 25);
        }
        .logo-yellow {
            background-color: oklch(92% 0.12 95);
            color: oklch(35% 0.12 95);
        }
        /* Active Indicator */
        .active-indicator {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: var(--color-border);
            border: 2px solid var(--color-paper);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-ink);
            opacity: 0;
            transform: scale(0.5);
            transition: all 300ms var(--ease-spring);
            z-index: 10;
        }
        .company-card.is-active .active-indicator {
            opacity: 1;
            transform: scale(1);
        }
        /* Quota Badges */
        .quota-badge {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .quota-high {
            background-color: oklch(92% 0.08 140 / 0.6);
            color: oklch(35% 0.1 140);
            border: 1px solid oklch(85% 0.08 140 / 0.8);
        }
        .quota-low {
            background-color: oklch(92% 0.12 45 / 0.6);
            color: oklch(35% 0.12 45);
            border: 1px solid oklch(85% 0.12 45 / 0.8);
        }
        .form-box {
            background-color: var(--color-paper-2);
            border: 2px solid var(--color-border);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-clay);
        }
        /* Custom file dropzone */
        .file-dropzone {
            border: 2px dashed var(--color-border);
            border-radius: var(--radius-input);
            background-color: var(--color-paper-3);
            transition: all 300ms var(--ease-spring);
            cursor: pointer;
        }
        .file-dropzone:hover {
            border-color: var(--color-border);
            background-color: var(--color-paper-2);
        }
        .file-dropzone.has-file {
            border-color: var(--color-mint);
            background-color: oklch(96% 0.05 140 / 0.5);
            border-style: solid;
        }
    </style>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6">
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 font-display">Ajukan Instansi PKL Baru</h2>
                <p class="text-slate-500 text-sm mt-1">Pilih mitra perusahaan dan lampirkan surat pengantar resmi dari sekolah.</p>
            </div>
            <div class="w-full md:w-80 relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input
                    type="text"
                    id="search-instansi"
                    placeholder="Cari berdasarkan nama atau alamat..."
                    class="w-full pl-10 pr-4 py-2.5 search-input text-sm"
                />
            </div>
        </div>
        <form
            id="form-pengajuan"
            action="{{ route('siswa.pengajuan.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            <input
                type="hidden"
                name="tempat_pkl_id"
                id="selected-tempat-pkl-id"
                value="{{ old('tempat_pkl_id') }}"
                required
            />
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <div class="lg:col-span-7 xl:col-span-8 space-y-4">
                    <h3
                        class="text-xs font-bold uppercase tracking-wider text-slate-400 font-label flex items-center gap-2"
                    >
                        <i class="fa-solid fa-briefcase text-xs"></i>
                        Daftar Mitra Instansi / Perusahaan ({{ $tempat_pkls->count() }})
                    </h3>
                    <div
                        id="no-results-message"
                        class="hidden text-center py-12 p-6 rounded-2xl bg-white/40 border-2 border-dashed border-slate-200"
                    >
                        <i class="fa-solid fa-face-frown text-slate-300 text-4xl mb-3 block"></i>
                        <p class="text-sm font-semibold text-slate-600">Tidak ada instansi yang cocok</p>
                        <p class="text-xs text-slate-400 mt-1">Gunakan kata kunci pencarian yang berbeda.</p>
                    </div>
                    <div class="grid grid-cols-1 gap-4" id="instansi-grid">
                        @foreach ($tempat_pkls as $tempat)
                            @php
                                $firstLetter = strtoupper(substr($tempat->nama_instansi, 0, 1));
                                $ascii = ord($firstLetter);
                                $colorClass = 'logo-yellow';
                                if ($ascii % 4 === 0) {
                                    $colorClass = 'logo-mint';
                                } elseif ($ascii % 4 === 1) {
                                    $colorClass = 'logo-cyan';
                                } elseif ($ascii % 4 === 2) {
                                    $colorClass = 'logo-coral';
                                }
                            @endphp
                            <div
                                class="company-card p-5 flex flex-col justify-between gap-4"
                                data-id="{{ $tempat->id }}"
                                data-name="{{ strtolower($tempat->nama_instansi) }}"
                                data-address="{{ strtolower($tempat->alamat) }}"
                                onclick="selectCompany(this)"
                            >
                                <div class="active-indicator shadow-md">
                                    <i class="fa-solid fa-check text-slate-900 text-xs"></i>
                                </div>
                                <div class="flex items-start gap-4">
                                    @if ($tempat->gambar)
                                        <div
                                            class="w-12 h-12 rounded-xl border-2 border-slate-200 overflow-hidden flex-shrink-0 bg-white"
                                        >
                                            <img
                                                src="{{ asset('storage/' . $tempat->gambar) }}"
                                                alt="{{ $tempat->nama_instansi }}"
                                                class="w-full h-full object-cover"
                                            />
                                        </div>
                                    @else
                                        <div class="company-logo-badge w-12 h-12 flex-shrink-0 {{ $colorClass }}">
                                            {{ $firstLetter }}
                                        </div>
                                    @endif
                                    <div class="space-y-1 pr-6 flex-1 min-w-0">
                                        <h4 class="font-bold text-base text-slate-800 tracking-tight leading-tight line-clamp-1">
                                            {{ $tempat->nama_instansi }}
                                        </h4>
                                        <p class="text-xs text-slate-500 flex items-start gap-1.5 leading-normal">
                                            <i class="fa-solid fa-location-dot text-slate-400 text-xs mt-0.5 flex-shrink-0"></i>
                                            <span class="flex-1 text-justify leading-relaxed text-slate-500">{{ $tempat->alamat }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between border-t border-slate-100 pt-3 mt-1">
                                    <div class="text-xs font-bold font-label">
                                        @if ($tempat->kuota > 3)
                                            <span class="text-emerald-600">
                                                {{ $tempat->kuota }} Kuota
                                            </span>
                                        @else
                                            <span class="text-amber-600">
                                                Sisa {{ $tempat->kuota }} Kuota!
                                            </span>
                                        @endif
                                    </div>
                                    <span
                                        class="text-xs font-bold text-slate-900 flex items-center gap-1 group-hover:underline"
                                    >
                                        Pilih Instansi
                                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="lg:col-span-5 xl:col-span-4 space-y-6 lg:sticky lg:top-24">
                    <h3
                        class="text-xs font-bold uppercase tracking-wider text-slate-400 font-label flex items-center gap-2"
                    >
                        <i class="fa-solid fa-file-invoice text-xs"></i>
                        Detail Pengajuan
                    </h3>
                    <div class="form-box p-6 space-y-6">
                        <div
                            id="selection-status-card"
                            class="bg-white/40 p-5 border border-dashed border-slate-300 rounded-2xl text-center py-8"
                        >
                            <div
                                class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-3 text-slate-400"
                            >
                                <i class="fa-solid fa-city text-slate-400 text-xl"></i>
                            </div>
                            <h4 class="font-bold text-sm text-slate-700">Instansi Belum Dipilih</h4>
                            <p class="text-xs text-slate-400 mt-1 max-w-xs mx-auto">Silakan cari dan pilih salah satu perusahaan di sisi kiri untuk memproses pendaftaran.</p>
                        </div>
                        <div
                            id="selected-company-info"
                            class="hidden p-4 bg-white/70 rounded-2xl border-2 border-slate-200 space-y-3"
                        >
                            <div class="flex items-center gap-3">
                                <div
                                    id="selected-company-logo"
                                    class="w-10 h-10 rounded-lg flex items-center justify-center font-bold text-sm flex-shrink-0"
                                >
                                    --
                                </div>
                                <div class="overflow-hidden">
                                    <span
                                        class="text-[9px] uppercase font-bold text-slate-400 tracking-wider font-label"
                                        >Instansi Terpilih</span
                                    >
                                    <h4
                                        id="selected-company-name"
                                        class="font-bold text-sm text-slate-800 leading-tight truncate"
                                    >
                                        Nama Instansi
                                    </h4>
                                </div>
                            </div>
                            <p id="selected-company-address" class="text-xs text-slate-500 leading-normal flex items-start gap-1.5">
                                <i class="fa-solid fa-location-dot text-slate-400 text-xs mt-0.5 flex-shrink-0"></i>
                                <span class="flex-1 text-justify">Alamat Lengkap</span>
                            </p>
                        </div>
                        @error ('tempat_pkl_id')
                            <p class="text-red-500 text-xs mt-1 bg-red-50 p-2.5 rounded-xl border border-red-200">{{ $message }}</p>
                        @enderror
                        <div class="flex flex-col gap-2 pt-2">
                            <button
                                type="submit"
                                id="btn-submit-pengajuan"
                                disabled
                                class="w-full bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-xl text-sm font-bold flex items-center justify-center gap-2 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                Ajukan Tempat PKL
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </button>
                            <a
                                href="{{ route('siswa.pengajuan.index') }}"
                                class="w-full text-center px-5 py-2.5 text-xs text-slate-500 hover:text-slate-800 font-bold transition-colors uppercase tracking-wider font-label"
                            >
                                Batal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        const searchInput = document.getElementById('search-instansi');
        const instansiGrid = document.getElementById('instansi-grid');
        const noResultsMessage = document.getElementById('no-results-message');
        const cards = document.querySelectorAll('.company-card');
        searchInput.addEventListener('input', function () {
            const query = this.value.trim().toLowerCase();
            let matches = 0;
            cards.forEach((card) => {
                const name = card.getAttribute('data-name');
                const address = card.getAttribute('data-address');
                if (name.includes(query) || address.includes(query)) {
                    card.style.display = 'flex';
                    matches++;
                } else {
                    card.style.display = 'none';
                }
            });
            if (matches === 0) {
                noResultsMessage.classList.remove('hidden');
                instansiGrid.classList.add('hidden');
            } else {
                noResultsMessage.classList.add('hidden');
                instansiGrid.classList.remove('hidden');
            }
        });
        function selectCompany(cardElement) {
            cards.forEach((c) => c.classList.remove('is-active'));
            cardElement.classList.add('is-active');
            const companyId = cardElement.getAttribute('data-id');
            document.getElementById('selected-tempat-pkl-id').value = companyId;
            const companyName = cardElement.querySelector('h4').textContent.trim();
            const companyAddress = cardElement.querySelector('p').textContent.trim();
            const logoElement = cardElement.querySelector('.company-logo-badge') || cardElement.querySelector('img');
            const selectedCompanyInfo = document.getElementById('selected-company-info');
            const selectionStatusCard = document.getElementById('selection-status-card');
            selectionStatusCard.classList.add('hidden');
            selectedCompanyInfo.classList.remove('hidden');
            document.getElementById('selected-company-name').textContent = companyName;
            document.getElementById('selected-company-address').querySelector('span').textContent = companyAddress;
            const selectedLogoContainer = document.getElementById('selected-company-logo');
            if (logoElement.tagName === 'IMG') {
                selectedLogoContainer.innerHTML = `<img src="${logoElement.src}" class="w-full h-full object-cover rounded-lg" />`;
                selectedLogoContainer.className =
                    'w-10 h-10 rounded-lg flex-shrink-0 bg-white overflow-hidden border border-slate-200 shadow-sm';
            } else {
                selectedLogoContainer.innerHTML = `<span class="company-logo-badge w-full h-full flex items-center justify-center text-xs font-bold leading-none">${logoElement.textContent.trim()}</span>`;
                selectedLogoContainer.className =
                    'w-10 h-10 rounded-lg flex-shrink-0 overflow-hidden flex items-center justify-center ' +
                    Array.from(logoElement.classList)
                        .filter((c) => c.startsWith('logo-'))
                        .join(' ');
            }
            checkFormValidity();
        }
        function checkFormValidity() {
            const companyId = document.getElementById('selected-tempat-pkl-id').value;
            const btnSubmit = document.getElementById('btn-submit-pengajuan');
            if (companyId) {
                btnSubmit.removeAttribute('disabled');
            } else {
                btnSubmit.setAttribute('disabled', 'disabled');
            }
        }
        window.addEventListener('DOMContentLoaded', () => {
            const preselectedId = document.getElementById('selected-tempat-pkl-id').value;
            if (preselectedId) {
                const card = document.querySelector(`.company-card[data-id="${preselectedId}"]`);
                if (card) {
                    selectCompany(card);
                }
            }
        });
    </script>
@endsection

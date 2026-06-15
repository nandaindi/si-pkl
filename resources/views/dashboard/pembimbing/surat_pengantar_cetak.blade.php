<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Surat Pengantar PKL - {{ $pengajuan->tempatPkl->nama_instansi }}</title>

    <!-- Tailwind CSS (for layout helper) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Times New Roman is the formal font for letter documents */
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000000;
            background-color: #ffffff;
            line-height: 1.5;
        }

        /* Printable A4 margins */
        .print-page {
            width: 21cm;
            min-height: 29.7cm;
            padding: 3cm 2.5cm 2.5cm 2.5cm; /* standard formal margins */
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        /* Border styles for formal table */
        .formal-table th,
        .formal-table td {
            border: 1px solid #000000 !important;
            padding: 4px 6px !important;
            vertical-align: middle;
        }

        /* Print Specific Styling */
        @media print {
            body {
                background-color: #ffffff;
            }
            .print-page {
                box-shadow: none;
                padding: 0;
                margin: 0;
                width: 100%;
                min-height: auto;
            }
            .no-print {
                display: none !important;
            }
            @page {
                size: A4;
                margin: 2cm 2cm 2cm 2cm;
            }
        }
    </style>
    <!-- Auto-trigger print dialog on load -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 300);
        });
    </script>
</head>
<body class="bg-slate-100 py-10">
    @php
        $romanMonths = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII',
        ];
        $monthNum = date('n', strtotime($pengajuan->updated_at));
        $romanMonth = $romanMonths[$monthNum] ?? 'I';
        $year = date('Y', strtotime($pengajuan->updated_at));

        $nomorSurat = str_pad($pengajuan->id, 3, '0', STR_PAD_LEFT) . ' / SMK-M01 / PKL / ' . $romanMonth . ' / ' . $year;
    @endphp

    <!-- Printable Paper Sheet -->
    <div class="print-page text-[12pt]">
        <!-- Meta Info (Nomor, Lampiran, Perihal) aligned neatly with a table -->
        <table class="w-full text-[12pt] border-none">
            <tr class="align-top">
                <td class="w-20 py-0.5">Nomor</td>
                <td class="w-3 py-0.5">:</td>
                <td class="py-0.5">{{ $nomorSurat }}</td>
            </tr>
            <tr class="align-top">
                <td class="py-0.5">Lampiran</td>
                <td class="py-0.5">:</td>
                <td class="py-0.5">-</td>
            </tr>
            <tr class="align-top font-bold">
                <td class="py-0.5">Perihal</td>
                <td class="py-0.5">:</td>
                <td class="py-0.5 italic">Pengajuan Siswa dalam Pelaksanaan Praktek Kerja Lapangan.</td>
            </tr>
        </table>

        <!-- Recipient block -->
        <div class="mt-8 text-[12pt] space-y-0.5">
            <p>Kepada Yth.</p>
            <p>Bapak/Ibu Pimpinan</p>
            <p class="font-bold">{{ $pengajuan->tempatPkl->nama_instansi }}</p>
            <p>di Tempat</p>
        </div>

        <!-- Body Paragraph 1 -->
        <div class="mt-8 text-[12pt] text-justify space-y-4">
            <p>Disampaikan dengan hormat, berkaitan dengan permintaan siswa/i kami untuk melaksanakan Praktek Kerja Lapangan (PKL) di perusahaan/Lembaga yang Bapak/Ibu pimpin.</p>
            <p class="indent-10 leading-relaxed">Berkaitan dengan hal tersebut diatas, Maka Kami Panitia Praktek Kerja Lapangan SMK Mandiri 01 Panongan Memohon untuk diberikan kesempatan kepada Siswa / I kami untuk melaksanakan Praktek Kerja di perusahaan/Lembaga yang Bapak/Ibu pimpin.</p>
            <p class="indent-10 leading-relaxed">Waktu pelaksanaan disesuaikan dengan kesempatan Pelaksanaan Praktek Kerja yang diberikan oleh Perusahaan. ( Maksimal 3 Bulan )</p>
            <p>Adapun Nama Siswa / i yang kami Ajukan adalah Sebagai Berikut :</p>
        </div>

        <!-- Student Table (Word-like formal borders) -->
        <div class="mt-4">
            <table class="w-full text-left border-collapse text-[10pt] formal-table">
                <thead>
                    <tr class="text-center font-bold">
                        <th class="px-2 py-1 text-center w-[5%]">No</th>
                        <th class="px-2 py-1 w-[35%]">Nama Siswa</th>
                        <th class="px-2 py-1 w-[15%] text-center">NIS</th>
                        <th class="px-2 py-1 w-[15%] text-center">Kelas</th>
                        <th class="px-2 py-1 w-[30%]">Program Keahlian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siswa_list as $index => $s)
                        <tr>
                            <td class="px-2 py-1 text-center">{{ $index + 1 }}</td>
                            <td class="px-2 py-1">{{ ucwords(strtolower($s->user->name)) }}</td>
                            <td class="px-2 py-1 text-center">{{ $s->nisn }}</td>
                            <td class="px-2 py-1 text-center">{{ $s->kelas }}</td>
                            <td class="px-2 py-1">{{ $s->jurusan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Body Paragraph 2 -->
        <div class="mt-8 text-[12pt] text-justify">
            <p>Demikian Surat Permohonan ini disampaikan, atas perhatian serta kerjasamanya kami ucapkan banyak terima kasih.</p>
        </div>

        <!-- Signatures Aligned Perfectly using table layout -->
        <table class="w-full mt-16 text-[12pt] border-none">
            <tr class="align-top">
                <!-- Left Signature (Kepala Sekolah) -->
                <td class="w-1/2 text-center">
                    <p class="leading-normal">Mengetahui,</p>
                    <p class="font-bold leading-normal">Kepala Sekolah</p>
                    <div class="h-20 flex items-center justify-center">
                        <img
                            src="{{ asset('images/ttd_kepsek.png') }}"
                            class="h-20 object-contain mx-auto"
                            alt="Tanda Tangan Kepala Sekolah"
                        />
                    </div>
                    <p class="leading-normal">M.Apip Hafifi, S.Kom</p>
                </td>

                <!-- Right Signature (Ketua PKL) -->
                <td class="w-1/2 text-center">
                    <p class="leading-normal">Panongan, {{
                        \Carbon\Carbon::parse($pengajuan->updated_at)
                            ->locale('id')
                            ->isoFormat('D MMMM Y')
                    }}</p>
                    <p class="font-bold leading-normal">Ketua PKL</p>
                    <div class="h-20 flex items-center justify-center">
                        <img
                            src="{{ asset('images/ttd_ketuapanitia.png') }}"
                            class="h-20 object-contain mx-auto"
                            alt="Tanda Tangan Ketua PKL"
                        />
                    </div>
                    <p class="leading-normal">Marno, S.Pd</p>
                    <p class="text-[10pt] leading-normal mt-1 text-slate-700">Contact Person: 083897801814</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>

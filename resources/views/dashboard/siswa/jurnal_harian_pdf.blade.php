<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Riwayat Laporan Harian - {{ $siswa->user->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
        }
        .info {
            margin-bottom: 20px;
        }
        .info table {
            width: 100%;
            border: none;
        }
        .info td {
            padding: 3px 0;
            vertical-align: top;
        }
        .info .label {
            width: 150px;
            font-weight: bold;
        }
        .info .colon {
            width: 10px;
        }
        .laporan-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .laporan-table th,
        .laporan-table td {
            border: 1px solid #999;
            padding: 8px;
        }
        .laporan-table th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-align: left;
        }
        .laporan-table td {
            vertical-align: top;
        }
        .status-disetujui {
            color: #16a34a;
            font-weight: bold;
        }
        .status-revisi {
            color: #dc2626;
            font-weight: bold;
        }
        .status-pending {
            color: #ca8a04;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
            padding-right: 20px;
        }
        .footer p {
            margin: 5px 0;
        }
        .signature-space {
            height: 70px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Riwayat Laporan Harian Praktek Kerja Lapangan</h1>
        <p>Tahun Ajaran {{ date('Y') }} / {{ date('Y') + 1 }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td class="label">Nama Siswa</td>
                <td class="colon">:</td>
                <td>{{ $siswa->user->name }}</td>
            </tr>
            <tr>
                <td class="label">NISN</td>
                <td class="colon">:</td>
                <td>{{ $siswa->nisn }}</td>
            </tr>
            @php
                $pengajuan = \App\Models\PengajuanPkl::where('siswa_id', $siswa->id)->where('status', 'disetujui')->first();
            @endphp
            @if ($pengajuan && $pengajuan->tempatPkl)
                <tr>
                    <td class="label">Tempat PKL</td>
                    <td class="colon">:</td>
                    <td>{{ $pengajuan->tempatPkl->nama_instansi }}</td>
                </tr>
            @endif
            <tr>
                <td class="label">Guru Pembimbing</td>
                <td class="colon">:</td>
                <td>{{ $siswa->pembimbing->user->name ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <table class="laporan-table">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Tanggal</th>
                <th style="width: 80%">Uraian Kegiatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporans as $index => $laporan)
                <tr>
                    <td style="text-align: center">{{ $index + 1 }}</td>
                    <td>
                        {{
                            \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat(
                                'd F Y',
                            )
                        }}
                    </td>
                    <td>{{ $laporan->kegiatan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center">Tidak ada data laporan harian.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Tangerang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>Mengetahui,</p>
        <p>Guru Pembimbing</p>
        <div class="signature-space"></div>
        <p><strong><u>{{
                $siswa->pembimbing->user->name ??
                    '.....................................'
            }}</u></strong></p>
    </div>
</body>
</html>

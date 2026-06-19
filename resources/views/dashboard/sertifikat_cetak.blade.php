<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sertifikat PKL - {{ $siswa->user->name }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            background-color: #f1f5f9;
            font-family: 'Times New Roman', Times, serif;
            color: #000000;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .cert-container {
            width: 297mm;
            height: 210mm;
            margin: 20px auto;
            background-color: #ffffff;
            background-image: url('{{ asset('images/sertifpkl.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }
        .cert-text {
            position: absolute;
            font-family: 'Times New Roman', Times, serif;
            color: #000000;
            white-space: nowrap;
            line-height: 1.2;
        }
        /* Nomor Sertifikat — di atas garis nomor */
        .field-nomor {
            left: 43.5%;
            top: 33.6%;
            font-size: 11.5pt;
            letter-spacing: 0.3px;
        }
        /* Nama — di atas garis nama */
        .field-nama {
            left: 38.0%;
            top: 41.0%;
            font-size: 13pt;
            letter-spacing: 0.3px;
        }
        /* Tempat & Tanggal Lahir — di atas garis TTL */
        .field-ttl {
            left: 38.0%;
            top: 44.1%;
            font-size: 11.5pt;
        }
        /* NIS — di atas garis NIS */
        .field-nis {
            left: 38.0%;
            top: 47.4%;
            font-size: 11.5pt;
            letter-spacing: 0.3px;
        }
        /* Jurusan — di atas garis jurusan */
        .field-jurusan {
            left: 38.0%;
            top: 50.3%;
            font-size: 11.5pt;
        }
        /* Instansi — di atas garis instansi, centered */
        .field-instansi {
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            top: 58.4%;
            font-size: 13pt;
            font-weight: bold;
        }
        /* Tanggal Mulai — di atas garis mulai */
        .field-mulai {
            left: 30.5%;
            top: 64.0%;
            font-size: 11pt;
            font-weight: bold;
        }
        /* Tanggal Selesai — di atas garis selesai */
        .field-selesai {
            left: 53.5%;
            top: 64.0%;
            font-size: 11pt;
            font-weight: bold;
        }
        /* Hasil — di atas garis hasil */
        .field-hasil {
            left: 74.0%;
            top: 64.0%;
            font-size: 11pt;
            font-weight: bold;
        }
        /* Predikat Besar di tengah kutip */
        .field-predikat {
            left: 50%;
            transform: translateX(-50%);
            top: 68.8%;
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        /* Tanggal Tangerang — di atas garis tanggal */
        .field-tangerang {
            left: 74.8%;
            top: 77.4%;
            font-size: 11.5pt;
        }
        /* Nama Kepala Sekolah */
        .field-kepsek {
            left: 24.4%;
            top: 86.8%;
            transform: translateX(-50%);
            text-align: center;
            font-size: 11.5pt;
            font-weight: bold;
        }
        /* Nama Ketua Panitia */
        .field-panitia {
            left: 48.7%;
            top: 86.8%;
            transform: translateX(-50%);
            text-align: center;
            font-size: 11.5pt;
            font-weight: bold;
        }
        /* Nama Pimpinan Perusahaan */
        .field-pimpinan {
            left: 73.7%;
            top: 86.0%;
            transform: translateX(-50%);
            text-align: center;
            font-size: 11.5pt;
            font-weight: bold;
        }
        /* Signature Images */
        .sig-image-kepsek {
            position: absolute;
            left: 24.4%;
            top: 81.5%;
            height: 52px;
            width: auto;
            transform: translateX(-50%);
            object-fit: contain;
            mix-blend-mode: multiply;
        }
        .sig-image-panitia {
            position: absolute;
            left: 48.7%;
            top: 81.5%;
            height: 52px;
            width: auto;
            transform: translateX(-50%);
            object-fit: contain;
            mix-blend-mode: multiply;
        }
        @media print {
            body {
                background-color: #ffffff;
                margin: 0;
                padding: 0;
            }
            .cert-container {
                margin: 0;
                border: none;
                box-shadow: none;
                width: 297mm;
                height: 210mm;
                page-break-after: avoid;
            }
            @page {
                size: A4 landscape;
                margin: 0;
            }
        }
    </style>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 300);
        });
    </script>
</head>
<body>
    <div class="cert-container">
        <div class="cert-text field-nomor">{{ $sertifikat->nomor_sertifikat }}</div>
        <div class="cert-text field-nama">{{ ucwords(strtolower($siswa->user->name)) }}</div>
        <div class="cert-text field-ttl">
            {{ ucwords(strtolower($sertifikat->tempat_lahir)) }}, {{
                \Carbon\Carbon::parse($sertifikat->tanggal_lahir)
                    ->locale('id')
                    ->isoFormat('D MMMM Y')
            }}
        </div>
        <div class="cert-text field-nis">{{ $siswa->nisn }}</div>
        <div class="cert-text field-jurusan">{{ $siswa->jurusan }}</div>
        <div class="cert-text field-instansi">{{ $tempatPkl->nama_instansi }}</div>
        <div class="cert-text field-mulai">
            {{
                \Carbon\Carbon::parse($sertifikat->tanggal_mulai)
                    ->locale('id')
                    ->isoFormat('D MMMM Y')
            }}
        </div>
        <div class="cert-text field-selesai">
            {{
                \Carbon\Carbon::parse($sertifikat->tanggal_selesai)
                    ->locale('id')
                    ->isoFormat('D MMMM Y')
            }}
        </div>
        <div class="cert-text field-hasil">{{ $predikat }}</div>
        <div class="cert-text field-predikat">{{ $predikat }}</div>
        <div class="cert-text field-tangerang">
            {{
                \Carbon\Carbon::parse($sertifikat->updated_at)
                    ->locale('id')
                    ->isoFormat('D MMMM Y')
            }}
        </div>
        <img src="{{ asset('images/ttd_kepsek.png') }}" class="sig-image-kepsek" alt="Ttd Kepala Sekolah" />
        <img src="{{ asset('images/ttd_ketuapanitia.png') }}" class="sig-image-panitia" alt="Ttd Ketua Panitia" />
        <div class="cert-text field-kepsek">M. Apip Hafifi, S.Kom</div>
        <div class="cert-text field-panitia">Marno, S.Pd</div>
        <div class="cert-text field-pimpinan">&nbsp;</div>
    </div>
</body>
</html>

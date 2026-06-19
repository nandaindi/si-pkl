<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\PengajuanPkl;
use App\Models\LaporanHarian;
use App\Models\LaporanAkhir;
use App\Models\JadwalSidang;
use App\Models\NilaiPkl;
use App\Models\Sertifikat;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class SiswaSidangSeeder extends Seeder
{
    /**
     * Data siswa yang akan di-seed beserta stage-nya.
     */
    private array $studentsData = [
        [
            'name' => 'Ahmad Rizky Pratama',
            'email' => 'ahmad.rizky@pkl.com',
            'nisn' => '0051001001',
            'kelas' => 'XII TKJ 1',
            'jurusan' => 'Teknik Komputer Jaringan',
            'tempat_pkl_nama' => 'PT. Gajah Tunggal Tbk.',
            'stage' => 'siap_sidang',
            'pkl_start' => '2026-03-01',
        ],
        [
            'name' => 'Dewi Lestari',
            'email' => 'dewi.lestari@pkl.com',
            'nisn' => '0051001002',
            'kelas' => 'XII MP 1',
            'jurusan' => 'Manajemen Perkantoran',
            'tempat_pkl_nama' => 'PT. Ya Op',
            'stage' => 'siap_sidang',
            'pkl_start' => '2026-03-01',
        ],
        [
            'name' => 'Rizky Saputra',
            'email' => 'rizky.saputra@pkl.com',
            'nisn' => '0051001003',
            'kelas' => 'XII DKV 1',
            'jurusan' => 'Desain Komunikasi Visual',
            'tempat_pkl_nama' => 'PT. Korek',
            'stage' => 'siap_sidang',
            'pkl_start' => '2026-03-01',
        ],
        [
            'name' => 'Siti Nurhaliza',
            'email' => 'siti.nurhaliza@pkl.com',
            'nisn' => '0051001004',
            'kelas' => 'XII TKR 1',
            'jurusan' => 'Teknik Kendaraan Ringan',
            'tempat_pkl_nama' => 'PT. Gajah Tunggal Tbk.',
            'stage' => 'siap_sidang',
            'pkl_start' => '2026-03-01',
        ],

        [
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@pkl.com',
            'nisn' => '0051001005',
            'kelas' => 'XII TKJ 1',
            'jurusan' => 'Teknik Komputer Jaringan',
            'tempat_pkl_nama' => 'PT. Ya Op',
            'stage' => 'sudah_sidang',
            'pkl_start' => '2026-02-15',
        ],

        [
            'name' => 'Fitri Handayani',
            'email' => 'fitri.handayani@pkl.com',
            'nisn' => '0051001006',
            'kelas' => 'XII MP 1',
            'jurusan' => 'Manajemen Perkantoran',
            'tempat_pkl_nama' => 'PT. Korek',
            'stage' => 'laporan_selesai',
            'pkl_start' => '2026-03-10',
        ],

        [
            'name' => 'Andi Wijaya',
            'email' => 'andi.wijaya@pkl.com',
            'nisn' => '0051001007',
            'kelas' => 'XII DKV 1',
            'jurusan' => 'Desain Komunikasi Visual',
            'tempat_pkl_nama' => 'PT. Gajah Tunggal Tbk.',
            'stage' => 'pkl_berjalan',
            'pkl_start' => '2026-05-01',
        ],
    ];

    /**
     * Template kegiatan harian per jurusan.
     */
    private array $kegiatanTemplates = [
        'Teknik Komputer Jaringan' => [
            'Troubleshooting router Mikrotik & konfigurasi VLAN switch managed',
            'Instalasi kabel fiber optic & splicing konektor SC-LC di ruang server',
            'Setup firewall rules & NAT pada router core perusahaan',
            'Maintenance rutin server Linux & monitoring jaringan via Zabbix',
            'Konfigurasi DHCP server & DNS lokal untuk jaringan internal kantor',
            'Perbaikan access point & optimasi coverage WiFi area produksi',
            'Backup konfigurasi switch & router, dokumentasi topologi jaringan',
            'Testing throughput jaringan menggunakan iPerf & analisis bottleneck',
        ],
        'Manajemen Perkantoran' => [
            'Pengarsipan surat masuk & keluar menggunakan sistem e-office digital',
            'Penyusunan notulensi rapat koordinasi divisi & distribusi ke pimpinan',
            'Input data absensi karyawan & rekapitulasi lembur bulanan',
            'Penyusunan laporan keuangan petty cash & petty cash voucher',
            'Penerimaan tamu & handling telepon masuk ke kantor cabang',
            'Digitalisasi dokumen kontrak kerja & filing ke cloud storage',
            'Pembuatan presentasi meeting bulanan & koordinasi agenda rapat',
            'Pengelolaan inventaris ATK & pembuatan purchase requisition',
        ],
        'Desain Komunikasi Visual' => [
            'Desain banner promosi produk & mockup kemasan baru untuk launching',
            'Editing video company profile & color grading footage wawancara',
            'Pembuatan ilustrasi vektor untuk social media campaign bulanan',
            'Redesign layout brosur cetak & persiapan file pre-press CMYK',
            'Photoshoot produk & retouching foto katalog e-commerce',
            'Motion graphic sederhana untuk Instagram Reels & TikTok Ads',
            'Desain UI mockup halaman landing page website perusahaan',
            'Pembuatan infografis annual report & data visualization dashboard',
        ],
        'Teknik Kendaraan Ringan' => [
            'Tune-up mesin EFI & pengecekan sistem pengapian mobil penumpang',
            'Overhaul sistem transmisi manual & penggantian plat kopling',
            'Servis berkala 10.000 km: ganti oli, filter udara, cek rem',
            'Diagnosa kerusakan sistem kelistrikan bodi & perbaikan wiring harness',
            'Penggantian timing belt & penyetelan katup mesin 4 silinder',
            'Balancing & spooring roda, pengecekan tekanan ban & kondisi kampas rem',
            'Perbaikan sistem pendingin: radiator flush & penggantian thermostat',
            'Pengecekan sistem suspensi & penggantian shock absorber depan',
        ],
    ];

    public function run(): void
    {
        $pembimbing = Guru::find(1);
        $penguji = Guru::find(2);

        if (!$pembimbing || !$penguji) {
            $this->command->error('Guru pembimbing/penguji belum ada. Jalankan UserSeeder dulu.');
            return;
        }

        foreach ($this->studentsData as $data) {
            $this->createStudent($data, $pembimbing, $penguji);
        }

        $this->command->info('SiswaSidangSeeder: ' . count($this->studentsData) . ' siswa berhasil di-seed.');
    }

    private function createStudent(array $data, Guru $pembimbing, Guru $penguji): void
    {
        $user = User::firstOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'],
                'password' => bcrypt('password'),
            ]
        );
        $user->assignRole('siswa');

        $siswa = Siswa::firstOrCreate(
            ['nisn' => $data['nisn']],
            [
                'user_id' => $user->id,
                'kelas' => $data['kelas'],
                'jurusan' => $data['jurusan'],
                'pembimbing_id' => $pembimbing->id,
            ]
        );

        $tempatPkl = \App\Models\TempatPkl::firstOrCreate(
            ['nama_instansi' => $data['tempat_pkl_nama']],
            [
                'alamat' => 'Alamat ' . $data['tempat_pkl_nama'],
                'kuota' => 10,
            ]
        );

        $pengajuan = PengajuanPkl::firstOrCreate(
            ['siswa_id' => $siswa->id, 'tempat_pkl_id' => $tempatPkl->id],
            ['status' => 'disetujui']
        );
        if ($pengajuan->updated_at < Carbon::parse($data['pkl_start'])) {
            $pengajuan->update(['updated_at' => Carbon::parse($data['pkl_start'])]);
        }

        $pklStart = Carbon::parse($data['pkl_start']);
        $templates = $this->kegiatanTemplates[$data['jurusan']] ?? $this->kegiatanTemplates['Teknik Komputer Jaringan'];

        $daysCount = match ($data['stage']) {
            'siap_sidang', 'sudah_sidang' => 90,
            'laporan_selesai' => 90,
            'pkl_berjalan' => 45,
        };

        $inserted = 0;
        $currentDay = 0;
        while ($inserted < $daysCount) {
            $date = $pklStart->copy()->addDays($currentDay);
            $currentDay++;
            
            if ($date->isWeekend()) {
                continue;
            }

            $kegiatan = $templates[array_rand($templates)];

            LaporanHarian::firstOrCreate(
                [
                    'siswa_id' => $siswa->id,
                    'tanggal' => $date->toDateString(),
                ],
                [
                    'kegiatan' => $kegiatan,
                    'status' => 'disetujui',
                ]
            );
            $inserted++;
        }

        if (in_array($data['stage'], ['siap_sidang', 'sudah_sidang', 'laporan_selesai'])) {
            LaporanAkhir::firstOrCreate(
                ['siswa_id' => $siswa->id],
                [
                    'file_laporan' => 'laporan_akhir/placeholder_' . $data['nisn'] . '.pdf',
                    'status_verifikasi' => in_array($data['stage'], ['siap_sidang', 'sudah_sidang']) ? 'disetujui' : 'pending',
                ]
            );
        }

        if (in_array($data['stage'], ['siap_sidang', 'sudah_sidang'])) {
            $sidangDate = $pklStart->copy()->addMonths(3)->addDays(5);

            JadwalSidang::firstOrCreate(
                ['siswa_id' => $siswa->id],
                [
                    'penguji_id' => $penguji->id,
                    'pembimbing_id' => $pembimbing->id,
                    'waktu' => $sidangDate->setHour(9)->setMinute(0),
                    'ruangan' => $this->getRoomForJurusan($data['jurusan']),
                ]
            );
        }

        if ($data['stage'] === 'sudah_sidang') {
            $nilaiPembimbing = rand(75, 95);
            $nilaiPenguji = rand(70, 90);
            $nilaiAkhir = round(($nilaiPembimbing + $nilaiPenguji) / 2, 1);

            NilaiPkl::firstOrCreate(
                ['siswa_id' => $siswa->id],
                [
                    'nilai_pembimbing' => $nilaiPembimbing,
                    'nilai_penguji' => $nilaiPenguji,
                    'nilai_akhir' => $nilaiAkhir,
                ]
            );

            Sertifikat::firstOrCreate(
                ['siswa_id' => $siswa->id],
                [
                    'nomor_sertifikat' => 'CERT/MANDIRI/' . date('Y') . '/' . str_pad($siswa->id, 4, '0', STR_PAD_LEFT),
                    'tempat_lahir' => 'Tangerang',
                    'tanggal_lahir' => Carbon::parse('2008-' . rand(1, 12) . '-' . rand(1, 28))->toDateString(),
                    'tanggal_mulai' => $pklStart->toDateString(),
                    'tanggal_selesai' => $pklStart->copy()->addMonths(3)->toDateString(),
                ]
            );
        }
    }

    private function getRoomForJurusan(string $jurusan): string
    {
        return match ($jurusan) {
            'Teknik Komputer Jaringan' => 'LAB TKJ 1',
            'Manajemen Perkantoran' => 'LAB Perkantoran',
            'Desain Komunikasi Visual' => 'Studio DKV 2',
            'Teknik Kendaraan Ringan' => 'Bengkel Otomotif',
            default => 'Ruang Serbaguna',
        };
    }
}

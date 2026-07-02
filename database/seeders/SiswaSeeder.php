<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\JadwalSidang;
use App\Models\LaporanAkhir;
use App\Models\LaporanHarian;
use App\Models\NilaiPkl;
use App\Models\PengajuanPkl;
use App\Models\Siswa;
use App\Models\TempatPkl;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SiswaSeeder extends Seeder
{
    public function run()
    {
        $pembimbing = Guru::find(1);
        $penguji = Guru::find(2);

        // 1. Seed Mitra Industri yang bekerja sama
        $this->command->info('Seeding mitra industri/tempat PKL...');
        $this->seedMitraIndustri();

        // 2. Generate Siswa Asli dari Excel/Markdown
        $this->command->info('Seeding 90 siswa asli dari data Excel...');
        $this->seedRealStudents($pembimbing);

        // 3. Generate Siswa Dummy Khusus untuk Testing Alur Sidang & Laporan
        if ($pembimbing && $penguji) {
            $this->command->info('Seeding beberapa siswa dummy dengan status siap sidang...');
            $this->seedTestingWorkflowStudents($pembimbing, $penguji);
        }
    }

    private function seedRealStudents($pembimbing)
    {
        $data = [
            [
                'nama' => 'ADELIA GRACIA MAHARANI',
                'nisn' => '252610002',
                'kelas' => '10',
                'jurusan' => 'Manajemen Perkantoran',
            ],
            [
                'nama' => 'ALISYA PUTRI SYA\'BANI',
                'nisn' => '252610010',
                'kelas' => '10',
                'jurusan' => 'Manajemen Perkantoran',
            ],
            ['nama' => 'ARDI FRASETIO', 'nisn' => '252610013', 'kelas' => '10', 'jurusan' => 'Manajemen Perkantoran'],
            ['nama' => 'AURA SALSABILA', 'nisn' => '252610014', 'kelas' => '10', 'jurusan' => 'Manajemen Perkantoran'],
            [
                'nama' => 'DALFA NAYLA FAUZIAH',
                'nisn' => '252610021',
                'kelas' => '10',
                'jurusan' => 'Manajemen Perkantoran',
            ],
            [
                'nama' => 'DESI SITI MAHARANI',
                'nisn' => '252610022',
                'kelas' => '10',
                'jurusan' => 'Manajemen Perkantoran',
            ],
            ['nama' => 'DINI PAHRIYAH', 'nisn' => '252610023', 'kelas' => '10', 'jurusan' => 'Manajemen Perkantoran'],
            [
                'nama' => 'DZAKY ALMER FITRENDYA',
                'nisn' => '252610100',
                'kelas' => '10',
                'jurusan' => 'Manajemen Perkantoran',
            ],
            ['nama' => 'ERNA RAMADANI', 'nisn' => '252610025', 'kelas' => '10', 'jurusan' => 'Manajemen Perkantoran'],
            ['nama' => 'FADLA MUTMAINAH', 'nisn' => '252610066', 'kelas' => '10', 'jurusan' => 'Manajemen Perkantoran'],
            ['nama' => 'FERGINA ARIYANI', 'nisn' => '252610028', 'kelas' => '10', 'jurusan' => 'Manajemen Perkantoran'],
            ['nama' => 'FIRA MILANDITA', 'nisn' => '252610030', 'kelas' => '10', 'jurusan' => 'Manajemen Perkantoran'],
            [
                'nama' => 'HIFNI AINUL HAFIDJAH',
                'nisn' => '252610033',
                'kelas' => '10',
                'jurusan' => 'Manajemen Perkantoran',
            ],
            ['nama' => 'IZKIA ADISTI', 'nisn' => '252610034', 'kelas' => '10', 'jurusan' => 'Manajemen Perkantoran'],
            ['nama' => 'LITA WULANDARI', 'nisn' => '252610097', 'kelas' => '10', 'jurusan' => 'Manajemen Perkantoran'],
            ['nama' => 'MESI INDRIYANI', 'nisn' => '252610038', 'kelas' => '10', 'jurusan' => 'Manajemen Perkantoran'],
            [
                'nama' => 'MUHAMAD ALAN MAULANA',
                'nisn' => '252610042',
                'kelas' => '10',
                'jurusan' => 'Manajemen Perkantoran',
            ],
            [
                'nama' => 'MUHAMAD ANDRE HIDAYAT',
                'nisn' => '252610044',
                'kelas' => '10',
                'jurusan' => 'Manajemen Perkantoran',
            ],
            [
                'nama' => 'MUHAMAD ARDIO ABDUL MATIN',
                'nisn' => '252610045',
                'kelas' => '10',
                'jurusan' => 'Manajemen Perkantoran',
            ],
            ['nama' => 'MUHAMMAD ANWAR', 'nisn' => '252610095', 'kelas' => '10', 'jurusan' => 'Manajemen Perkantoran'],
            [
                'nama' => 'NABILA ROBIYATUL ADAWIYAH',
                'nisn' => '252610062',
                'kelas' => '10',
                'jurusan' => 'Manajemen Perkantoran',
            ],
            ['nama' => 'NURMA HERAH', 'nisn' => '252610065', 'kelas' => '10', 'jurusan' => 'Manajemen Perkantoran'],
            ['nama' => 'PARHA AULIA', 'nisn' => '252610067', 'kelas' => '10', 'jurusan' => 'Manajemen Perkantoran'],
            [
                'nama' => 'PUSPITA MAULIDIA',
                'nisn' => '252610068',
                'kelas' => '10',
                'jurusan' => 'Manajemen Perkantoran',
            ],
            ['nama' => 'PUTRI AULIA', 'nisn' => '252610069', 'kelas' => '10', 'jurusan' => 'Manajemen Perkantoran'],
            ['nama' => 'RIFQI ABRILANA', 'nisn' => '252610075', 'kelas' => '10', 'jurusan' => 'Manajemen Perkantoran'],
            [
                'nama' => 'RISKA MAULIDIYAWATI',
                'nisn' => '252610076',
                'kelas' => '10',
                'jurusan' => 'Manajemen Perkantoran',
            ],
            ['nama' => 'RIZKY ALANSAH', 'nisn' => '252610078', 'kelas' => '10', 'jurusan' => 'Manajemen Perkantoran'],
            [
                'nama' => 'SITI BAITI ROHMAH',
                'nisn' => '252610079',
                'kelas' => '10',
                'jurusan' => 'Manajemen Perkantoran',
            ],
            ['nama' => 'SITI HARTATI', 'nisn' => '252610098', 'kelas' => '10', 'jurusan' => 'Manajemen Perkantoran'],
            ['nama' => 'SITI HERLINAH', 'nisn' => '252610080', 'kelas' => '10', 'jurusan' => 'Manajemen Perkantoran'],
            [
                'nama' => 'SITI KHAERUN NISA',
                'nisn' => '252610081',
                'kelas' => '10',
                'jurusan' => 'Manajemen Perkantoran',
            ],
            [
                'nama' => 'SITI NABILLA SILVA',
                'nisn' => '252610082',
                'kelas' => '10',
                'jurusan' => 'Manajemen Perkantoran',
            ],
            [
                'nama' => 'SITI NASYAPA KAMILA UFIQ',
                'nisn' => '252610083',
                'kelas' => '10',
                'jurusan' => 'Manajemen Perkantoran',
            ],
            [
                'nama' => 'SITI NUR VANESSA MAHARANI',
                'nisn' => '252610084',
                'kelas' => '10',
                'jurusan' => 'Manajemen Perkantoran',
            ],
            [
                'nama' => 'SOLIHATUN HASANAH',
                'nisn' => '252610086',
                'kelas' => '10',
                'jurusan' => 'Manajemen Perkantoran',
            ],
            [
                'nama' => 'SYAIFA AMBAMI AL-AMIN',
                'nisn' => '252610087',
                'kelas' => '10',
                'jurusan' => 'Manajemen Perkantoran',
            ],
            ['nama' => 'TIARA', 'nisn' => '252610088', 'kelas' => '10', 'jurusan' => 'Manajemen Perkantoran'],
            [
                'nama' => 'TIARA PERMATASARI',
                'nisn' => '252610089',
                'kelas' => '10',
                'jurusan' => 'Manajemen Perkantoran',
            ],
            [
                'nama' => 'AHMAD KHAIRUL ANAM',
                'nisn' => '252610005',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ],
            [
                'nama' => 'AHMAD MUBAROK',
                'nisn' => '252610006',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ],
            [
                'nama' => 'ANDREYANSYAH',
                'nisn' => '252610011',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ],
            [
                'nama' => 'ARYA RIZKY PRAYUGA',
                'nisn' => '252610103',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ],
            [
                'nama' => 'BAYU STIA AJI',
                'nisn' => '252610018',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ],
            [
                'nama' => 'DIDO PITRIANSAH',
                'nisn' => '252610106',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ],
            [
                'nama' => 'FAREL WAHYU SYAPUTRA',
                'nisn' => '252610099',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ],
            [
                'nama' => 'FAUJI PAHMI',
                'nisn' => '252610100-2',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ], // duplicate NISN fixed
            [
                'nama' => 'HAIKAL KAMIL MUZAKI',
                'nisn' => '252610101',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ],
            [
                'nama' => 'MUHAMAD ABDULLAH AZSKA DIANDRA',
                'nisn' => '252610102',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ],
            [
                'nama' => 'MUHAMAD ADITIA AL HADADI',
                'nisn' => '252610103-2',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ], // duplicate NISN fixed
            [
                'nama' => 'MUHAMAD ALBIANSYAH',
                'nisn' => '252610104',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ],
            [
                'nama' => 'MUHAMAD DENIS',
                'nisn' => '252610105',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ],
            [
                'nama' => 'MUHAMAD FAZRI FERDIANSYAH',
                'nisn' => '252610106-2',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ], // duplicate NISN fixed
            [
                'nama' => 'MUHAMAD RAFLY ALRAKIP',
                'nisn' => '252610107',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ],
            [
                'nama' => 'MUHAMAD RIO AL FARISYI',
                'nisn' => '252610108',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ],
            [
                'nama' => 'MUHAMMAD ALHAKIM BAIER',
                'nisn' => '252610109',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ],
            [
                'nama' => 'MUHAMMAD APRIZAL',
                'nisn' => '252610110',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ],
            [
                'nama' => 'MUHAMMAD RIZKI RAMDHAN',
                'nisn' => '252610111',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ],
            [
                'nama' => 'PADLI PERMANA',
                'nisn' => '252610112',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ],
            [
                'nama' => 'QIANDRA AUDIA AKA',
                'nisn' => '252610113',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ],
            [
                'nama' => 'RIDHO MAHESA PUTRA',
                'nisn' => '252610114',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ],
            [
                'nama' => 'RIZKI RAMADAN',
                'nisn' => '252610115',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ],
            [
                'nama' => 'TUBAGUS RAFA AZZIKRI',
                'nisn' => '252610116',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ],
            [
                'nama' => 'ZAKI AUNUR ROFIQ',
                'nisn' => '252610117',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan B',
            ],
            [
                'nama' => 'ABI RAHMAT FAIRUS',
                'nisn' => '252610001',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'AHMAD DARIS',
                'nisn' => '252610002-2',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'AHMAD ROFID ALFAIZI',
                'nisn' => '252610003',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            ['nama' => 'AL PACHRI', 'nisn' => '252610004', 'kelas' => '11', 'jurusan' => 'Teknik Kendaraan Ringan A'],
            [
                'nama' => 'ALDIYANSYAH',
                'nisn' => '252610005-2',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'AZMIL UMRI',
                'nisn' => '252610006-2',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'DAFANO NUR ROKHIM',
                'nisn' => '252610007',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'EGIS MULYANA',
                'nisn' => '252610008',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'FION NOKI SAPUTRO',
                'nisn' => '252610009',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'GALANG ARDIANSYAH',
                'nisn' => '252610010-2',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'GIAST AL - GIFARI',
                'nisn' => '252610011-2',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            ['nama' => 'IBNU HAFIDZ', 'nisn' => '252610012', 'kelas' => '11', 'jurusan' => 'Teknik Kendaraan Ringan A'],
            [
                'nama' => 'IBRAHIM UMBARA',
                'nisn' => '252610013-2',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'MALIKAL MUKI',
                'nisn' => '252610014-2',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'MAULANA YUSUF',
                'nisn' => '252610015',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'MUHAMAD ADNAN',
                'nisn' => '252610016',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'MUHAMAD ARYA REGGISTIANA',
                'nisn' => '252610017',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'MUHAMAD LUCKY RIZALDI',
                'nisn' => '252610018-2',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'MUHAMMAD DAFFA ZAKILA',
                'nisn' => '252610019',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'MUHAMMAD RAFIDHAN ALHABBSY',
                'nisn' => '252610020',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'MUHAMMAD ZAKY ADE NAUFAL',
                'nisn' => '252610021-2',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'NAUFAL ASYURA PUTRA',
                'nisn' => '252610022-2',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'NAUVAL PERMANA',
                'nisn' => '252610023-2',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'RAFKY HILBRAM KAMIL',
                'nisn' => '252610024',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'RANDI SETIAWAN',
                'nisn' => '252610025-2',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'UNUS SUHERMAN',
                'nisn' => '252610026',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'WAHYU AGUNG PRATAMA',
                'nisn' => '252610027',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'YESAYA PARHOLASAN PURBA',
                'nisn' => '252610028-2',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
            [
                'nama' => 'YUDIKA ARKAN DEYA',
                'nisn' => '252610029',
                'kelas' => '11',
                'jurusan' => 'Teknik Kendaraan Ringan A',
            ],
        ];

        foreach ($data as $item) {
            if (Siswa::where('nisn', $item['nisn'])->exists()) {
                continue;
            }

            $clean_name = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '.', $item['nama']));
            $email = $clean_name.'@smkmandiri01panongan.sch.id';

            $originalEmail = $email;
            $counter = 1;
            while (User::where('email', $email)->exists()) {
                $email = $originalEmail.$counter;
                $counter++;
            }

            $user = User::create([
                'name' => $item['nama'],
                'email' => $email,
                'password' => bcrypt('password'),
            ]);
            $user->assignRole('siswa');

            Siswa::create([
                'user_id' => $user->id,
                'nisn' => $item['nisn'],
                'kelas' => $item['kelas'],
                'jurusan' => $item['jurusan'],
                'pembimbing_id' => $pembimbing ? $pembimbing->id : null,
            ]);
        }
    }

    private function seedMitraIndustri()
    {
        $mitras = [
            // TKR
            [
                'nama_instansi' => 'PT Astra International Tbk - Auto2000',
                'alamat' => 'Jl. Gaya Motor III No.3, Sunter II, Jakarta Utara',
                'kuota' => 5,
                'jurusan' => 'Teknik Kendaraan Ringan',
            ],
            [
                'nama_instansi' => 'PT Astra Daihatsu Motor',
                'alamat' => 'Jl. Gaya Motor III No.5, Sunter II, Jakarta Utara',
                'kuota' => 6,
                'jurusan' => 'Teknik Kendaraan Ringan',
            ],
            [
                'nama_instansi' => 'PT Honda Prospect Motor',
                'alamat' => 'Jl. Gaya Motor I No.2, Sunter II, Jakarta Utara',
                'kuota' => 4,
                'jurusan' => 'Teknik Kendaraan Ringan',
            ],
            [
                'nama_instansi' => 'PT Yamaha Indonesia Motor Mfg.',
                'alamat' => 'Jl. Laksana I, Sentul, Cibinong, Bogor',
                'kuota' => 8,
                'jurusan' => 'Teknik Kendaraan Ringan',
            ],
            [
                'nama_instansi' => 'PT Nusa Karya Artha (NKA) - NISSAN Datsun',
                'alamat' => 'Jl. H.R. Rasuna Said, Jakarta Selatan',
                'kuota' => 4,
                'jurusan' => 'Teknik Kendaraan Ringan',
            ],
            [
                'nama_instansi' => 'PT Mitra Pinasthika Mulia (Bosch Car Service)',
                'alamat' => 'Jl. Jend. Basuki Rachmad, Surabaya',
                'kuota' => 5,
                'jurusan' => 'Teknik Kendaraan Ringan',
            ],
            // OTKP
            [
                'nama_instansi' => 'PT Mayora Indah Tbk',
                'alamat' => 'Jl. Tomang Raya No.21-23, Jakarta Barat',
                'kuota' => 10,
                'jurusan' => 'Manajemen Perkantoran',
            ],
            [
                'nama_instansi' => 'PT Unilever Indonesia Tbk',
                'alamat' => 'BSD Green Office Park, Kavling 3, Tangerang',
                'kuota' => 8,
                'jurusan' => 'Manajemen Perkantoran',
            ],
            ['nama_instansi' => 'PT Sinar Sosro', 'alamat' => 'Jl. Raya Sultan Agung KM 28, Bekasi', 'kuota' => 6, 'jurusan' => 'Manajemen Perkantoran'],
            [
                'nama_instansi' => 'PT Gramedia Asri Media',
                'alamat' => 'Jl. Palmerah Barat No.29-37, Jakarta Pusat',
                'kuota' => 10,
                'jurusan' => null, // Berlaku untuk OTKP dan MM
            ],
            ['nama_instansi' => 'PT JNE Express', 'alamat' => 'Jl. Tomang Raya No.11, Jakarta Barat', 'kuota' => 12, 'jurusan' => 'Manajemen Perkantoran'],
            [
                'nama_instansi' => 'PT BFI Finance Indonesia Tbk',
                'alamat' => 'BFI Tower, Sunburst BSD, Tangerang',
                'kuota' => 5,
                'jurusan' => 'Manajemen Perkantoran',
            ],
            // AKL
            [
                'nama_instansi' => 'PT Smart Tbk (Sinar Mas Group)',
                'alamat' => 'Sinar Mas Land Plaza, Jakarta Pusat',
                'kuota' => 8,
            ],
            ['nama_instansi' => 'PT BCA Finance', 'alamat' => 'Wisma BCA Pondok Indah, Jakarta Selatan', 'kuota' => 6],
            [
                'nama_instansi' => 'PT Federal International Finance (FIFGROUP)',
                'alamat' => 'Jl. TB Simatupang No.15, Jakarta Selatan',
                'kuota' => 7,
            ],
            [
                'nama_instansi' => 'PT Bank Rakyat Indonesia (Persero) Tbk',
                'alamat' => 'Gedung BRI, Jl. Jend. Sudirman, Jakarta Pusat',
                'kuota' => 8,
            ],
            [
                'nama_instansi' => 'PT Bank Central Asia Tbk',
                'alamat' => 'Menara BCA, Grand Indonesia, Jakarta Pusat',
                'kuota' => 10,
            ],
            ['nama_instansi' => 'PT Pos Indonesia (Persero)', 'alamat' => 'Jl. Cilaki No.73, Bandung', 'kuota' => 5],
            // TKJ
            [
                'nama_instansi' => 'PT Telkom Indonesia (Persero) Tbk',
                'alamat' => 'Telkom Landmark Tower, Jl. Jend. Gatot Subroto, Jakarta Pusat',
                'kuota' => 10,
                'jurusan' => 'Teknik Komputer Jaringan',
            ],
            [
                'nama_instansi' => 'PT Indosat Tbk',
                'alamat' => 'Jl. Medan Merdeka Barat No.21, Jakarta Pusat',
                'kuota' => 8,
                'jurusan' => 'Teknik Komputer Jaringan',
            ],
            [
                'nama_instansi' => 'PT NTT Indonesia (Nusantara Data Center)',
                'alamat' => 'Jl. Kuningan Barat, Jakarta Selatan',
                'kuota' => 6,
                'jurusan' => 'Teknik Komputer Jaringan',
            ],
            [
                'nama_instansi' => 'PT Solusi Tunas Pratama (STP)',
                'alamat' => 'Menara Karya, Jl. HR Rasuna Said, Jakarta Selatan',
                'kuota' => 5,
                'jurusan' => 'Teknik Komputer Jaringan',
            ],
            [
                'nama_instansi' => 'PT XL Axiata Tbk',
                'alamat' => 'XL Axiata Tower, Jl. H.R. Rasuna Said, Jakarta Selatan',
                'kuota' => 8,
                'jurusan' => 'Teknik Komputer Jaringan',
            ],
            [
                'nama_instansi' => 'PT Biznet Gio Nusantara',
                'alamat' => 'MidPlaza 2, Jl. Jend. Sudirman, Jakarta Pusat',
                'kuota' => 5,
                'jurusan' => 'Teknik Komputer Jaringan',
            ],
            // MM
            [
                'nama_instansi' => 'PT Dwi Inti Selaras (DIGITAL PRINTING)',
                'alamat' => 'Ruko Panongan, Tangerang',
                'kuota' => 4,
                'jurusan' => 'Desain Komunikasi Visual',
            ],
            [
                'nama_instansi' => 'PT MNC Digital Entertainment Tbk',
                'alamat' => 'MNC Studios, Jl. Raya Pejuangan, Jakarta Barat',
                'kuota' => 6,
                'jurusan' => 'Desain Komunikasi Visual',
            ],
            [
                'nama_instansi' => 'PT Visinema Pictures',
                'alamat' => 'Jl. Cilandak Tengah No.3, Jakarta Selatan',
                'kuota' => 5,
                'jurusan' => 'Desain Komunikasi Visual',
            ],
            ['nama_instansi' => 'PT Creativera Indonesia', 'alamat' => 'Gading Serpong, Tangerang', 'kuota' => 4, 'jurusan' => 'Desain Komunikasi Visual'],
            [
                'nama_instansi' => 'PT Indofood',
                'alamat' => 'Jl. Sudirman Plaza, Indofood Tower, Jakarta',
                'kuota' => 10,
                'jurusan' => 'Desain Komunikasi Visual',
            ],
        ];

        $images = Storage::disk('public')->files('tempat_pkl');

        foreach ($mitras as $mitra) {
            $gambar = null;
            $normalizedMitraName = strtolower(preg_replace('/[^a-z0-9]/i', '', $mitra['nama_instansi']));

            foreach ($images as $imagePath) {
                $filename = pathinfo($imagePath, PATHINFO_FILENAME);
                // Extract original filename in case of hashed prefix, wait these are just filenames
                $normalizedFilename = strtolower(preg_replace('/[^a-z0-9]/i', '', $filename));

                if (
                    $normalizedFilename !== '' && $normalizedMitraName !== '' &&
                    (str_contains($normalizedFilename, $normalizedMitraName) || str_contains($normalizedMitraName, $normalizedFilename))
                ) {
                    $gambar = $imagePath;
                    break;
                }
            }

            TempatPkl::updateOrCreate(
                ['nama_instansi' => $mitra['nama_instansi']],
                [
                    'alamat' => $mitra['alamat'],
                    'kuota' => $mitra['kuota'],
                    'gambar' => $gambar,
                    'jurusan' => $mitra['jurusan'] ?? null,
                ]
            );
        }
    }

    private function seedTestingWorkflowStudents($pembimbing, $penguji)
    {
        $studentsData = [
            [
                'name' => 'Ahmad Rizky Pratama',
                'email' => 'ahmad.rizky@smkmandiri01panongan.sch.id',
                'nisn' => '0051001001',
                'kelas' => '12',
                'jurusan' => 'Teknik Komputer Jaringan',
                'tempat_pkl_nama' => 'PT Telkom Indonesia (Persero) Tbk',
                'stage' => 'siap_sidang',
                'pkl_start' => '2026-03-01',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@smkmandiri01panongan.sch.id',
                'nisn' => '0051001005',
                'kelas' => '12',
                'jurusan' => 'Teknik Komputer Jaringan',
                'tempat_pkl_nama' => 'PT Astra Daihatsu Motor',
                'stage' => 'mateng',
                'pkl_start' => '2026-02-15',
            ],
            [
                'name' => 'Cici Cahyati',
                'email' => 'cici.cahyati@smkmandiri01panongan.sch.id',
                'nisn' => '0051001009',
                'kelas' => '12',
                'jurusan' => 'Teknik Kendaraan Ringan',
                'tempat_pkl_nama' => 'PT Astra Daihatsu Motor',
                'stage' => 'sudah_sidang',
                'pkl_start' => '2026-01-10',
                'laporan_akhir' => 'JURNAL_CICI_CAHYATI.pdf',
            ],
        ];

        foreach ($studentsData as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                ['name' => $data['name'], 'password' => bcrypt('password')],
            );
            $user->assignRole('siswa');

            $siswa = Siswa::firstOrCreate(
                ['nisn' => $data['nisn']],
                [
                    'user_id' => $user->id,
                    'kelas' => $data['kelas'],
                    'jurusan' => $data['jurusan'],
                    'pembimbing_id' => $pembimbing->id,
                ],
            );

            $tempatPkl = TempatPkl::firstOrCreate(
                ['nama_instansi' => $data['tempat_pkl_nama']],
                ['alamat' => 'Alamat '.$data['tempat_pkl_nama'], 'kuota' => 10],
            );

            $pengajuan = PengajuanPkl::firstOrCreate(
                ['siswa_id' => $siswa->id, 'tempat_pkl_id' => $tempatPkl->id],
                ['status' => 'disetujui'],
            );

            if (in_array($data['stage'], ['mateng', 'siap_sidang', 'sudah_sidang'])) {
                for ($i = 0; $i < 90; $i++) {
                    LaporanHarian::firstOrCreate(
                        [
                            'siswa_id' => $siswa->id,
                            'tanggal' => Carbon::parse($data['pkl_start'])->addDays($i)->toDateString(),
                        ],
                        [
                            'kegiatan' => 'Kegiatan PKL Hari ke-'.($i + 1),
                            'status' => 'disetujui',
                            'bukti_foto' => null,
                        ],
                    );
                }

                LaporanAkhir::firstOrCreate(
                    ['siswa_id' => $siswa->id],
                    [
                        'file_laporan' => isset($data['laporan_akhir']) ? 'laporan_akhir/'.$data['laporan_akhir'] : 'laporan_akhir/'.$data['nisn'].'.pdf',
                        'status_verifikasi' => 'disetujui',
                    ],
                );
            } else {
                LaporanHarian::firstOrCreate(
                    ['siswa_id' => $siswa->id, 'tanggal' => Carbon::parse($data['pkl_start'])->toDateString()],
                    ['kegiatan' => 'Orientasi PKL', 'status' => 'disetujui', 'bukti_foto' => null],
                );
            }

            if (in_array($data['stage'], ['siap_sidang', 'sudah_sidang'])) {
                JadwalSidang::firstOrCreate(
                    ['siswa_id' => $siswa->id],
                    [
                        'penguji_id' => $penguji->id,
                        'pembimbing_id' => $pembimbing->id,
                        'waktu' => Carbon::parse($data['pkl_start'])
                            ->addMonths(3)
                            ->addDays(5)
                            ->setHour(9)
                            ->setMinute(0),
                        'ruangan' => 'LAB TKJ 1',
                    ],
                );
            }

            if ($data['stage'] === 'sudah_sidang') {
                NilaiPkl::firstOrCreate(
                    ['siswa_id' => $siswa->id],
                    ['nilai_pembimbing' => 85, 'nilai_penguji' => 88, 'nilai_akhir' => 86.5],
                );
            }
        }
    }
}

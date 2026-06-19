<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\TempatPkl;
use App\Models\PengajuanPkl;
use App\Models\LaporanHarian;
use App\Models\LaporanAkhir;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SiswaSiapSidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat User Siswa Matang
        $userSiswa = User::firstOrCreate(
            ['email' => 'siswasiap@example.com'],
            [
                'name' => 'Siswa Siap Sidang',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        
        // Ensure role exists and assigned
        if (!$userSiswa->hasRole('siswa')) {
            $userSiswa->assignRole('siswa');
        }

        // 2. Ambil Guru Pembimbing secara acak atau buat baru
        $guru = Guru::first();
        if (!$guru) {
            $userGuru = User::factory()->create(['name' => 'Guru Pembimbing Seeder', 'email' => 'pembimbingseeder@example.com']);
            $userGuru->assignRole('pembimbing');
            $guru = Guru::create([
                'user_id' => $userGuru->id,
                'nip' => '1234567890',
                'no_telepon' => '08123456789',
            ]);
        }

        // 3. Buat Profil Siswa
        $siswa = Siswa::firstOrCreate(
            ['user_id' => $userSiswa->id],
            [
                'nisn' => '9999999999',
                'kelas' => 'XII RPL 1',
                'jurusan' => 'Rekayasa Perangkat Lunak',
                'pembimbing_id' => $guru->id,
            ]
        );

        // 4. Ambil Tempat PKL pertama atau buat dengan field minimal
        $tempatPkl = TempatPkl::firstOrCreate(
            ['nama_instansi' => 'PT Teknologi Siap Sidang'],
            [
                'alamat' => 'Jl. Teknologi No. 1',
                'kuota' => 5,
            ]
        );

        // 5. Buat Pengajuan PKL Disetujui
        PengajuanPkl::firstOrCreate(
            ['siswa_id' => $siswa->id],
            [
                'tempat_pkl_id' => $tempatPkl->id,
                'status' => 'disetujui',
            ]
        );

        // 6. Buat 90 Laporan Harian (Mundur 90 hari ke belakang)
        $today = Carbon::today();
        for ($i = 90; $i >= 1; $i--) {
            $date = $today->copy()->subDays($i);
            
            // Skip weekends (optional, but let's just make 90 consecutive valid days to be safe)
            LaporanHarian::firstOrCreate(
                [
                    'siswa_id' => $siswa->id,
                    'tanggal' => $date->toDateString(),
                ],
                [
                    'kegiatan' => 'Melakukan pekerjaan pengembangan fitur hari ke-' . (91 - $i),
                    'bukti_foto' => 'bukti_kegiatan/dummy.png', // Assume dummy or null works
                    'status' => 'disetujui',
                ]
            );
        }

        // 7. Buat Laporan Akhir Disetujui
        LaporanAkhir::firstOrCreate(
            ['siswa_id' => $siswa->id],
            [
                'file_laporan' => 'laporan_akhir/dummy_laporan.pdf',
                'status_verifikasi' => 'disetujui',
                'catatan_pembimbing' => 'Laporan sudah sangat baik dan siap disidangkan.',
            ]
        );

        $this->command->info("Siswa Siap Sidang berhasil dibuat!");
        $this->command->info("Login: siswasiap@example.com | Password: password");
    }
}

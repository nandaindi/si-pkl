<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@smkmandiri01panongan.sch.id'],
            ['name' => 'Administrator', 'password' => bcrypt('password')],
        );
        $admin->assignRole('admin');

        $pembimbing = User::firstOrCreate(
            ['email' => 'marno@smkmandiri01panongan.sch.id'],
            ['name' => 'Marno, S.Pd., Gr', 'password' => bcrypt('password')],
        );
        $pembimbing->assignRole('pembimbing');
        $pembimbingGuru = \App\Models\Guru::firstOrCreate(['user_id' => $pembimbing->id], ['nip' => '198001012005011001']);

        $penguji = User::firstOrCreate(
            ['email' => 'zulfikar@smkmandiri01panongan.sch.id'],
            ['name' => 'Zulfikar, S.Pd., Gr, ', 'password' => bcrypt('password')],
        );
        $penguji->assignRole('penguji');
        \App\Models\Guru::firstOrCreate(['user_id' => $penguji->id], ['nip' => '198202022006021002']);

        $siswa = User::firstOrCreate(
            ['email' => 'nova@smkmandiri01panongan.sch.id'],
            ['name' => 'Nova', 'password' => bcrypt('password')],
        );
        $siswa->assignRole('siswa');
        \App\Models\Siswa::firstOrCreate(
            ['user_id' => $siswa->id],
            ['nisn' => '0051234567', 'kelas' => '12', 'jurusan' => 'Teknik Komputer Jaringan', 'pembimbing_id' => $pembimbingGuru->id],
        );
    }
}

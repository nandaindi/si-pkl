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
            ['email' => 'admin@pkl.com'],
            ['name' => 'Administrator', 'password' => bcrypt('password')]
        );
        $admin->assignRole('admin');

        $pembimbing = User::firstOrCreate(
            ['email' => 'pembimbing@pkl.com'],
            ['name' => 'Guru Pembimbing', 'password' => bcrypt('password')]
        );
        $pembimbing->assignRole('pembimbing');
        \App\Models\Guru::firstOrCreate(
            ['user_id' => $pembimbing->id],
            ['nip' => '198001012005011001']
        );

        $penguji = User::firstOrCreate(
            ['email' => 'penguji@pkl.com'],
            ['name' => 'Guru Penguji', 'password' => bcrypt('password')]
        );
        $penguji->assignRole('penguji');
        \App\Models\Guru::firstOrCreate(
            ['user_id' => $penguji->id],
            ['nip' => '198202022006021002']
        );

        $siswa = User::firstOrCreate(
            ['email' => 'siswa@pkl.com'],
            ['name' => 'Siswa PKL', 'password' => bcrypt('password')]
        );
        $siswa->assignRole('siswa');
        \App\Models\Siswa::firstOrCreate(
            ['user_id' => $siswa->id],
            ['nisn' => '0051234567', 'kelas' => 'XII TKJ 1', 'jurusan' => 'Teknik Komputer Jaringan']
        );
    }
}

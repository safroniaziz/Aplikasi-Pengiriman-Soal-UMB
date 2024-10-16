<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'kode_user' => 'ADM001',
            'nidn' => null, // Bisa null untuk admin jika tidak diperlukan
            'nama_lengkap' => 'Admin Fakultas',
            'email' => 'admin@fakultas.com',
            'prodi_id' => null, // Tidak terkait dengan prodi
            'password' => Hash::make('password'), // Ganti dengan password yang sesuai
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // User dengan role 'dosen'
        User::create([
            'kode_user' => 'DOS001',
            'nidn' => '1234567890',
            'nama_lengkap' => 'Dosen Pengajar',
            'email' => 'dosen@fakultas.com',
            'prodi_id' => 1, // Sesuaikan dengan id prodi yang ada
            'password' => Hash::make('password'), // Ganti dengan password yang sesuai
            'role' => 'dosen',
            'email_verified_at' => now(),
        ]);

        // User dengan role 'kaprodi'
        User::create([
            'kode_user' => 'KAP001',
            'nidn' => '0987654321',
            'nama_lengkap' => 'Kaprodi Fakultas',
            'email' => 'kaprodi@fakultas.com',
            'prodi_id' => 1, // Sesuaikan dengan id prodi yang ada
            'password' => Hash::make('password'), // Ganti dengan password yang sesuai
            'role' => 'kaprodi',
            'email_verified_at' => now(),
        ]);
    }
}

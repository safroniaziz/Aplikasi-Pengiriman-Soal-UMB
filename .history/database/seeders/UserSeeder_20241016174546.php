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
        $users = [
            [
                'kode_user' => 'ADM001',
                'nidn' => null,
                'nama_lengkap' => 'Dr. Hendra Saputra, M.Si.',
                'email' => 'admin@fakultas.com',
                'prodi_id' => null,
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
            [
                'kode_user' => 'DOS001',
                'nidn' => '1234567890',
                'nama_lengkap' => 'Prof. Dr. Budi Santoso, M.T.',
                'email' => 'dosen1@fakultas.com',
                'prodi_id' => 1,
                'password' => Hash::make('password'),
                'role' => 'dosen',
                'email_verified_at' => now(),
            ],
            [
                'kode_user' => 'DOS002',
                'nidn' => '2345678901',
                'nama_lengkap' => 'Dr. Rina Wahyuni, S.Kom., M.T.',
                'email' => 'dosen2@fakultas.com',
                'prodi_id' => 2,
                'password' => Hash::make('password'),
                'role' => 'dosen',
                'email_verified_at' => now(),
            ],
            [
                'kode_user' => 'DOS003',
                'nidn' => '3456789012',
                'nama_lengkap' => 'Dr. Irwan Setiawan, M.Kom.',
                'email' => 'dosen3@fakultas.com',
                'prodi_id' => 3,
                'password' => Hash::make('password'),
                'role' => 'dosen',
                'email_verified_at' => now(),
            ],
            [
                'kode_user' => 'DOS004',
                'nidn' => '4567890123',
                'nama_lengkap' => 'Dr. Siti Aisyah, S.T., M.T.',
                'email' => 'dosen4@fakultas.com',
                'prodi_id' => 4,
                'password' => Hash::make('password'),
                'role' => 'dosen',
                'email_verified_at' => now(),
            ],
            [
                'kode_user' => 'DOS005',
                'nidn' => '5678901234',
                'nama_lengkap' => 'Dr. Bambang Hartono, S.T., M.Eng.',
                'email' => 'dosen5@fakultas.com',
                'prodi_id' => 5,
                'password' => Hash::make('password'),
                'role' => 'dosen',
                'email_verified_at' => now(),
            ],
            [
                'kode_user' => 'KAP001',
                'nidn' => '0987654321',
                'nama_lengkap' => 'Dr. Agus Setiawan, M.Kom.',
                'email' => 'kaprodi@fakultas.com',
                'prodi_id' => 1,
                'password' => Hash::make('password'),
                'role' => 'kaprodi',
                'email_verified_at' => now(),
            ],
        ];

        User::insert($users);
    }
}

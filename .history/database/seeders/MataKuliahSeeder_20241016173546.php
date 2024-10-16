<?php

namespace Database\Seeders;

use App\Models\MataKuliah;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MataKuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dosens = User::where('role', 'dosen')->pluck('id')->toArray();

        $mataKuliahs = [
            ['prodi_id' => 1, 'kode_mata_kuliah' => 'IF101', 'nama_mata_kuliah' => 'Algoritma dan Pemrograman'],
            ['prodi_id' => 1, 'kode_mata_kuliah' => 'IF102', 'nama_mata_kuliah' => 'Basis Data'],
            ['prodi_id' => 1, 'kode_mata_kuliah' => 'IF103', 'nama_mata_kuliah' => 'Struktur Data'],
            ['prodi_id' => 2, 'kode_mata_kuliah' => 'SI201', 'nama_mata_kuliah' => 'Sistem Informasi Manajemen'],
            ['prodi_id' => 2, 'kode_mata_kuliah' => 'SI202', 'nama_mata_kuliah' => 'Pengembangan Sistem Informasi'],
            ['prodi_id' => 3, 'kode_mata_kuliah' => 'TK301', 'nama_mata_kuliah' => 'Teknik Jaringan Komputer'],
            ['prodi_id' => 3, 'kode_mata_kuliah' => 'TK302', 'nama_mata_kuliah' => 'Sistem Operasi'],
            ['prodi_id' => 4, 'kode_mata_kuliah' => 'EL401', 'nama_mata_kuliah' => 'Elektronika Dasar'],
            ['prodi_id' => 4, 'kode_mata_kuliah' => 'EL402', 'nama_mata_kuliah' => 'Sistem Digital'],
            ['prodi_id' => 5, 'kode_mata_kuliah' => 'MS501', 'nama_mata_kuliah' => 'Mekanika Teknik'],
        ];

        foreach ($mataKuliahs as $mataKuliah) {
            MataKuliah::create([
                'prodi_id' => $mataKuliah['prodi_id'],
                'pengupload_id' => $dosens[array_rand($dosens)],  // Pilih pengupload_id secara acak dari dosen
                'kode_mata_kuliah' => $mataKuliah['kode_mata_kuliah'],
                'nama_mata_kuliah' => $mataKuliah['nama_mata_kuliah'],
            ]);
        }
    }
}

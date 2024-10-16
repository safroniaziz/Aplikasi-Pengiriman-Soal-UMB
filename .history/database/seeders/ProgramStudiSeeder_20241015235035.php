<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProgramStudi::create([
            'kode_prodi' => 'TEK001',
            'nama_prodi' => 'Teknik Informatika',
            'jenjang' => 'S1',
            'visi' => 'Menjadi program studi unggulan dalam bidang teknologi informasi',
            'misi' => 'Menghasilkan lulusan yang kompeten di bidang teknologi informasi',
        ]);

        ProgramStudi::create([
            'kode_prodi' => 'TEK002',
            'nama_prodi' => 'Teknik Sipil',
            'jenjang' => 'S1',
            'visi' => 'Menjadi pusat unggulan dalam bidang rekayasa sipil dan lingkungan',
            'misi' => 'Menghasilkan lulusan yang mampu merancang infrastruktur yang berkelanjutan',
        ]);

        ProgramStudi::create([
            'kode_prodi' => 'TEK003',
            'nama_prodi' => 'Teknik Elektro',
            'jenjang' => 'S1',
            'visi' => 'Menjadi program studi terkemuka dalam bidang ketenagalistrikan',
            'misi' => 'Menghasilkan lulusan yang mampu bersaing dalam industri ketenagalistrikan',
        ]);

        ProgramStudi::create([
            'kode_prodi' => 'TEK004',
            'nama_prodi' => 'Teknik Mesin',
            'jenjang' => 'S1',
            'visi' => 'Menjadi pusat pengembangan teknologi mesin yang inovatif',
            'misi' => 'Menghasilkan lulusan yang mampu menciptakan inovasi di bidang teknik mesin',
        ]);

        ProgramStudi::create([
            'kode_prodi' => 'TEK005',
            'nama_prodi' => 'Teknik Kimia',
            'jenjang' => 'S1',
            'visi' => 'Menjadi program studi unggulan di bidang rekayasa kimia',
            'misi' => 'Menghasilkan lulusan yang kompeten dalam bidang industri kimia dan proses',
        ]);
    }
}

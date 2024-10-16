<?php

namespace Database\Seeders;

use App\Models\Ujian;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UjianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dosens = User::where('role', 'dosen')->pluck('id')->toArray();

        for ($i = 4; $i <= 20; $i++) {
            $ujians[] = [
                'mata_kuliah_id' => ($i % 5) + 1,  // Menggunakan id mata kuliah 1 hingga 5 secara bergantian
                'tanggal_dilaksanakan' => Carbon::parse('2024-01-15')->addDays($i),
                'waktu_mulai' => '08:00:00',
                'waktu_selesai' => '10:00:00',
                'ruangan' => 'Ruang ' . (100 + $i),
                'batas_waktu_upload_soal' => Carbon::parse('2024-01-10 17:00:00')->addDays($i),
            ];
        }

        // Looping untuk memasukkan data ke dalam database
        foreach ($ujians as $ujian) {
            Ujian::create([
                'mata_kuliah_id' => $ujian['mata_kuliah_id'],
                'tanggal_dilaksanakan' => $ujian['tanggal_dilaksanakan'],
                'pengupload_id' => $dosens[array_rand($dosens)],  // Pilih pengupload_id secara acak dari dosen
                'waktu_mulai' => $ujian['waktu_mulai'],
                'waktu_selesai' => $ujian['waktu_selesai'],
                'ruangan' => $ujian['ruangan'],
                'batas_waktu_upload_soal' => $ujian['batas_waktu_upload_soal'],
            ]);
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SoalUjian extends Model
{
    use HasFactory, LogsActivity;

    // Tentukan atribut yang akan dicatat log-nya
    protected static $logAttributes = ['dosen_id', 'mata_kuliah_id', 'kop_soal_id', 'file_soal', 'status_validasi'];

    // Nama log, bisa digunakan untuk mengelompokkan log aktivitas ini
    protected static $logName = 'soal_ujian';

    // Hanya mencatat jika ada perubahan pada atribut
    protected static $logOnlyDirty = true;

    // Mengoverride deskripsi event untuk log
    public function getDescriptionForEvent(string $eventName): string
    {
        switch ($eventName) {
            case 'created':
                return "Soal ujian telah ditambahkan";
            case 'updated':
                return "Soal ujian telah diperbarui";
            case 'deleted':
                return "Soal ujian telah dihapus";
            default:
                return "Soal ujian mengalami perubahan";
        }
    }

    // Definisi untuk log activity options (sejak versi 4.6)
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['dosen_id', 'mata_kuliah_id', 'kop_soal_id', 'file_soal', 'status_validasi'])
            ->useLogName('soal_ujian');
    }
}

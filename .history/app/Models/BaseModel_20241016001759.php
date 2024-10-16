<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class BaseModel extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // Mencatat semua atribut
            ->useLogName(class_basename($this)) // Nama log menggunakan nama model
            ->logOnlyDirty(); // Hanya mencatat perubahan yang berbeda
    }

    public function getDescriptionForEvent(string $eventName): string
{
    switch ($eventName) {
        case 'created':
            return class_basename($this) . " telah dibuat";
        case 'updated':
            return class_basename($this) . " telah diperbarui";
        case 'deleted':
            return class_basename($this) . " telah dihapus";
        default:
            return class_basename($this) . " mengalami perubahan";
    }
}

}

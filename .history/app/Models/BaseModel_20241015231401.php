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
        return class_basename($this) . " telah {$eventName}";
    }
}

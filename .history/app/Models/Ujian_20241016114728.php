<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ujian extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /**
     * Get the mataKuliah that owns the Ujian
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mataKuliah(): BelongsTo
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id', 'id');
    }

    public function kopSoalUjian(): HasOne
    {
        return $this->hasOne(KopSoalUjian::class, 'ujian_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SoalUjian extends BaseModel
{
    use HasFactory, SoftDeletes;

    /**
     * Get the ujian that owns the SoalUjian
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ujian(): BelongsTo
    {
        return $this->belongsTo(Ujian::class, 'ujian_id', 'other_key');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class KopSoalUjian extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /**
     * Get the ujian that owns the KopSoalUjian
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ujian(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ujian_id', 'id');
    }
}

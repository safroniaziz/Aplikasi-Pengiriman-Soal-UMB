<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MataKuliah extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'mata_kuliahs';

    protected $guarded = [];

    /**
     * Get the prodi that owns the MataKuliah
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prodi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'prodi_id', 'id');
    }
}

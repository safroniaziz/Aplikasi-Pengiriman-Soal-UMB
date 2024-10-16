<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramStudi extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /**
     * Get all of the dosens for the ProgramStudi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dosens(): HasMany
    {
        return $this->hasMany(User::class, 'prodi_id', 'id')
                    ->where('role', 'dosen');
    }
}

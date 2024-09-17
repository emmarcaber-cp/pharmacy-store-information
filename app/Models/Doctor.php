<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    use HasFactory;

    protected $primaryKey = 'phys_id';

    protected $fillable = [
        'd_name',
        'specialty',
    ];

    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class, 'doctor_id', 'phys_id');
    }
}

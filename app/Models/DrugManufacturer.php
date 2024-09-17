<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DrugManufacturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
    ];

    public function drugs(): HasMany
    {
        return $this->hasMany(Drug::class);
    }
}

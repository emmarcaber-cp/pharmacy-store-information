<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DrugManufacturer extends Model
{
    use HasFactory;

    protected $primaryKey = 'company_id';

    protected $fillable = [
        'name',
        'address',
    ];

    public function drugs(): HasMany
    {
        return $this->hasMany(Drug::class);
    }

    public function contracts(): BelongsToMany
    {
        return $this->belongsToMany(Pharmacy::class, 'contracts', 'drug_manufacturer_id', 'phar_id')
            ->withPivot('start_date', 'end_date')
            ->withTimestamps();
    }
}

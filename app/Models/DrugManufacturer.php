<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DrugManufacturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
    ];

    /**
     * Get the drugs for the drug manufacturer.
     * 
     * @return HasMany
     */
    public function drugs(): HasMany
    {
        return $this->hasMany(Drug::class);
    }

    /**
     * The pharmacies that the drug manufacturer has contracts with.
     * 
     * @return BelongsToMany
     */
    public function pharmacies(): BelongsToMany
    {
        return $this->belongsToMany(Pharmacy::class, 'contracts', 'drug_manufacturer_id', 'pharmacy_id')
            ->using(Contract::class)
            ->withPivot('start_date', 'end_date')
            ->withTimestamps();
    }
}

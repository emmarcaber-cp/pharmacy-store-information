<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\AutoCreatesAuthFields;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DrugManufacturer extends Model
{
    use HasFactory, AutoCreatesAuthFields;

    protected $fillable = [
        'name',
        'address',
    ];

    /**
     * The pharmacies that the drug manufacturer has contracts with.
     * 
     * @return BelongsToMany
     */
    public function pharmacies(): BelongsToMany
    {
        return $this->belongsToMany(Pharmacy::class, 'contracts')
            ->withTimestamps();
    }

    /**
     * Get the drugs for the drug manufacturer.
     * 
     * @return HasMany
     */
    public function drugs(): HasMany
    {
        return $this->hasMany(Drug::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'auth');
    }
}

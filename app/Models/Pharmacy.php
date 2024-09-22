<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\AutoCreatesAuthFields;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pharmacy extends Model
{
    use HasFactory, AutoCreatesAuthFields;

    protected $fillable = [
        'name',
        'address',
        'fax',
    ];

    /**
     * The drugs that are available in the pharmacy.
     *
     * @return BelongsToMany
     */
    public function drugs(): BelongsToMany
    {
        return $this->belongsToMany(Drug::class)
            ->withTimestamps();
    }

    /**
     * The drug manufacturers that the pharmacy has contracts with.
     *
     * @return BelongsToMany
     */
    public function drugManufacturers(): BelongsToMany
    {
        return $this->belongsToMany(DrugManufacturer::class, 'contracts')
            ->withTimestamps();
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function pharmacyDrugs(): HasMany
    {
        return $this->hasMany(PharmacyDrug::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'auth');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Drug extends Model
{
    use HasFactory;

    protected $fillable = [
        'drug_manufacturer_id',
        'trade_name',
    ];

    /**
     * Get the drug manufacturer that owns the Drug.
     * 
     * @return BelongsTo
     */
    public function drugManufacturer(): BelongsTo
    {
        return $this->belongsTo(DrugManufacturer::class);
    }

    /**
     * The patients that have been prescribed this drug.
     * 
     * @return BelongsToMany
     */
    public function patients(): BelongsToMany
    {
        return $this->belongsToMany(Patient::class, 'prescriptions')
            ->withTimestamps();
    }

    /**
     * The doctors that prescribes to this drug.
     */
    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(Doctor::class, 'prescriptions')
            ->withTimestamps();
    }

    /**
     * The pharmacies that sells this drugs.
     */
    public function pharmacies(): BelongsToMany
    {
        return $this->belongsToMany(Pharmacy::class, 'pharmacy_drugs')
            ->withTimestamps();
    }

    public function pharmacyDrugs(): HasMany
    {
        return $this->hasMany(PharmacyDrug::class);
    }
}

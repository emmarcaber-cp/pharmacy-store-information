<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Drug extends Model
{
    use HasFactory;

    protected $fillable = [
        'trade_name',
        'drug_manufacturer_id',
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
        return $this->belongsToMany(Patient::class, 'prescriptions', 'drug_id', 'patient_id')
            ->withPivot('prescribed_at', 'quantity')
            ->withTimestamps();
    }

    /**
     * The doctors that prescribes to this drug.
     */
    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(Doctor::class, 'prescriptions', 'drug_id', 'doctor_id')
            ->withPivot('prescribed_at', 'quantity')
            ->withTimestamps();
    }

    /**
     * The pharmacies that sells this drugs.
     */
    public function pharmacies()
    {
        return $this->belongsToMany(Pharmacy::class, 'pharmacy_drugs', 'drug_id', 'pharmacy_id')
            ->withPivot('price')
            ->withTimestamps();
    }
}

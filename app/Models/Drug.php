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

    public function drugManufacturer(): BelongsTo
    {
        return $this->belongsTo(DrugManufacturer::class);
    }

    public function patients(): BelongsToMany
    {
        return $this->belongsToMany(Patient::class, 'prescriptions', 'drug_id', 'patient_id')
            ->withPivot('date_prescribed', 'quantity')
            ->withTimestamps();
    }

    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(Doctor::class, 'prescriptions', 'drug_id', 'doctor_id')
            ->withPivot('date_prescribed', 'quantity')
            ->withTimestamps();
    }

    public function pharmacies()
    {
        return $this->belongsToMany(Pharmacy::class, 'pharmacy_drugs', 'drug_id', 'pharmacy_id')
            ->withPivot('price')
            ->withTimestamps();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'name',
        'sex',
        'address',
        'contact_no',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function drugs(): BelongsToMany
    {
        return $this->belongsToMany(Drug::class, 'prescriptions', 'patient_id', 'drug_id')
            ->withPivot('date_prescribed', 'quantity')
            ->withTimestamps();
    }
}

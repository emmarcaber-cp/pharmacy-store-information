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

    /**
     * Get the doctor that the patient is assigned to.
     *
     * @return BelongsTo
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * The drugs that have been prescribed to the patient.
     *
     * @return BelongsToMany
     */
    public function drugs(): BelongsToMany
    {
        return $this->belongsToMany(Drug::class, 'prescriptions')
            ->withTimestamps();
    }
}

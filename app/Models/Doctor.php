<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $phys_id
 * @property string $d_name
 * @property string $specialty
 */
class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'specialty',
    ];

    /**
     * Get the patients assigned to the doctor.
     *
     * @return HasMany
     */
    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class);
    }

    public function drugs(): BelongsToMany
    {
        return $this->belongsToMany(Drug::class, 'prescriptions', 'doctor_id', 'drug_manufacturer_id')
            ->withPivot('date_prescribed', 'quantity')
            ->withTimestamps();
    }
}

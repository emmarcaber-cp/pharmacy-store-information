<?php

namespace App\Models;

use App\Traits\AutoCreatesAuthFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property int $phys_id
 * @property string $d_name
 * @property string $specialty
 */
class Doctor extends Model
{
    use HasFactory, AutoCreatesAuthFields;

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

    /**
     * The drugs that the doctor has prescribed.
     *
     * @return BelongsToMany
     */
    public function drugs(): BelongsToMany
    {
        return $this->belongsToMany(Drug::class, 'prescriptions')
            ->withTimestamps();
    }

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'auth');
    }
}

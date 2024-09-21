<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\AutoCreatesAuthFields;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

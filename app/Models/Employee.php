<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\AutoCreatesAuthFields;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory, AutoCreatesAuthFields;

    protected $fillable = [
        'name',
    ];

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * The pharmacies that the employee is assigned to.
     * 
     * @return BelongsToMany
     */
    public function pharmacies(): BelongsToMany
    {
        return $this->belongsToMany(Pharmacy::class, 'schedules')
            ->withTimestamps();
    }

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'auth');
    }
}

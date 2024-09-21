<?php

namespace App\Models;

use App\Traits\AutoCreatesAuthFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends Model
{
    use HasFactory, AutoCreatesAuthFields;

    protected $fillable = [
        'name',
    ];

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

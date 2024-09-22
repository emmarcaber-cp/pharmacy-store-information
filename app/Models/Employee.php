<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\AutoCreatesAuthFields;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends Model
{
    use HasFactory, AutoCreatesAuthFields;

    protected $fillable = [
        'name',
    ];

    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'auth');
    }
}

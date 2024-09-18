<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function works(): BelongsToMany
    {
        return $this->belongsToMany(Pharmacy::class, 'works', 'employee_id', 'pharmacy_id')
            ->withPivot('shift_start', 'shift_end')
            ->withTimestamps();
    }
}

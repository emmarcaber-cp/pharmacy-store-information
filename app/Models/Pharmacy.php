<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pharmacy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'fax',
    ];

    public function drugs(): BelongsToMany
    {
        return $this->belongsToMany(Drug::class, 'pharmacy_drugs', 'pharmacy_id', 'drug_id')
            ->withPivot('price')
            ->withTimestamps();
    }

    public function contracts(): BelongsToMany
    {
        return $this->belongsToMany(DrugManufacturer::class, 'contracts', 'pharmacy_id', 'drug_manufacturer_id')
            ->withPivot('start_date', 'end_date')
            ->withTimestamps();
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'schedules', 'pharmacy_id', 'employee_id')
            ->withPivot('shift_start', 'shift_end')
            ->withTimestamps();
    }
}

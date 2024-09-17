<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pharmacy extends Model
{
    use HasFactory;

    protected $primaryKey = 'phar_id';

    protected $fillable = [
        'name',
        'address',
        'fax',
    ];

    public function contracts(): BelongsToMany
    {
        return $this->belongsToMany(DrugManufacturer::class, 'contracts', 'phar_id', 'drug_manufacturer_id')
            ->withPivot('start_date', 'end_date')
            ->withTimestamps();
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'works', 'pharmacy_id', 'employee_id')
            ->withPivot('shift_start', 'shift_end')
            ->withTimestamps();
    }
}

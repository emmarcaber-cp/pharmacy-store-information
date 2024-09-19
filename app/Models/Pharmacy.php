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

    /**
     * The drugs that are available in the pharmacy.
     *
     * @return BelongsToMany
     */
    public function drugs(): BelongsToMany
    {
        return $this->belongsToMany(Drug::class)
            ->withTimestamps();
    }

    /**
     * The drug manufacturers that the pharmacy has contracts with.
     *
     * @return BelongsToMany
     */
    public function drugManufacturers(): BelongsToMany
    {
        return $this->belongsToMany(DrugManufacturer::class, 'contracts')
            ->withTimestamps();
    }

    /**
     * The employees that are assigned to the pharmacy.
     * 
     * @return BelongsToMany
     */
    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'schedules')
            ->withTimestamps();
    }
}

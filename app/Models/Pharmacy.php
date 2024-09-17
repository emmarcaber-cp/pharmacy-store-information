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
}

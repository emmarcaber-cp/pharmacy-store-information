<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contract extends Pivot
{
    use HasFactory;

    protected $table = 'contracts';

    protected $fillable = [
        'pharmacy_id',
        'drug_manufacturer_id',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function drugManufacturer(): BelongsTo
    {
        return $this->belongsTo(DrugManufacturer::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PharmacyDrug extends Model
{
    use HasFactory;

    protected $table = 'pharmacy_drugs';

    protected $fillable = [
        'pharmacy_id',
        'drug_id',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function drug(): BelongsTo
    {
        return $this->belongsTo(Drug::class);
    }
}

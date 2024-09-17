<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Drug extends Model
{
    use HasFactory;

    protected $primaryKey = 'trade_name';
    protected $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'trade_name',
        'drug_manufacturer_id',
    ];

    public function drugManufacturer(): BelongsTo
    {
        return $this->belongsTo(DrugManufacturer::class);
    }

    public function prescriptions()
    {
        return $this->belongsToMany(Patient::class, 'prescriptions', 'trade_name', 'PID')
            ->withPivot('date_prescribed', 'quantity')
            ->withTimestamps();
    }
}

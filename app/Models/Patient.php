<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Patient extends Model
{
    use HasFactory;

    protected $primaryKey = 'PID';

    protected $fillable = [
        'name',
        'sex',
        'address',
        'contact_no',
        'doctor_id',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'phys_id');
    }

    public function prescriptions()
    {
        return $this->belongsToMany(Drug::class, 'prescriptions', 'PID', 'trade_name')
            ->withPivot('date_prescribed', 'quantity')
            ->withTimestamps();
    }
}

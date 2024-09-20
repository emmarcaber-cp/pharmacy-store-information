<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'auth_id',
        'auth_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function auth(): MorphTo
    {
        return $this->morphTo();
    }

    public function isDoctor(): Attribute
    {
        return new Attribute(
            get: fn() => $this->auth_type === Doctor::class
        );
    }

    public function isDrugManufacturer(): Attribute
    {
        return new Attribute(
            get: fn() => $this->auth_type === DrugManufacturer::class
        );
    }

    public function isEmployee(): Attribute
    {
        return new Attribute(
            get: fn() => $this->auth_type === Employee::class
        );
    }

    public function isPatient(): Attribute
    {
        return new Attribute(
            get: fn() => $this->auth_type === Patient::class
        );
    }

    public function isPharmacy(): Attribute
    {
        return new Attribute(
            get: fn() => $this->auth_type === Pharmacy::class
        );
    }
}

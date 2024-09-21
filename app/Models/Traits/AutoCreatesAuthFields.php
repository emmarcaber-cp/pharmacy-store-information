<?php

namespace App\Models\Traits;

use App\Models\User;

trait AutoCreatesAuthFields
{
    /**
     * Boot the trait. This will automatically create the auth_id and auth_type
     * whenever a model using this trait is created.
     */
    protected static function bootAutoCreatesAuthFields()
    {
        static::created(function ($model) {
            User::firstOrCreate([
                'name' => $model->name,
                'email' => strtolower(str_replace(' ', '_', $model->name)) . '@email.com',
                'auth_id' => $model->id,
                'auth_type' => get_class($model),
                'password' => bcrypt('pass123'),
            ]);
        });
    }
}

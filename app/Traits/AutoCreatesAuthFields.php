<?php

namespace App\Traits;

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
            User::create([
                'name' => $model->name,
                'email' => "{$model->name}@email.com",
                'auth_id' => $model->id,
                'auth_type' => get_class($model),
                'password' => bcrypt('password123'),
            ]);
        });
    }
}

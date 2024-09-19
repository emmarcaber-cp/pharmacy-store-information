<?php

namespace App\Policies;

use App\Models\DrugManufacturer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DrugManufacturerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view any drug manufacturer');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DrugManufacturer $drugManufacturer): bool
    {
        return $user->can('view drug manufacturer');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create drug manufacturer');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DrugManufacturer $drugManufacturer): bool
    {
        return $user->can('update drug manufacturer');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DrugManufacturer $drugManufacturer): bool
    {
        return $user->can('delete drug manufacturer');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DrugManufacturer $drugManufacturer): bool
    {
        return $user->can('restore drug manufacturer');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DrugManufacturer $drugManufacturer): bool
    {
        return $user->can('force delete drug manufacturer');
    }
}

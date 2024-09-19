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
        return $user->is_pharmacy || $user->is_drug_manufacturer;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DrugManufacturer $drugManufacturer): bool
    {
        return $user->is_pharmacy || $user->is_drug_manufacturer;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DrugManufacturer $drugManufacturer): bool
    {
        return $user->is_drug_manufacturer && $user->id === $drugManufacturer->user->auth_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DrugManufacturer $drugManufacturer): bool
    {
        return $user->id === $drugManufacturer->user->auth_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DrugManufacturer $drugManufacturer): bool
    {
        return $user->id === $drugManufacturer->user->auth_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DrugManufacturer $drugManufacturer): bool
    {
        return $user->id === $drugManufacturer->user->auth_id;
    }
}

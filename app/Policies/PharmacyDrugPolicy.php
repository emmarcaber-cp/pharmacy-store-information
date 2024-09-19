<?php

namespace App\Policies;

use App\Models\PharmacyDrug;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PharmacyDrugPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view any pharmacy drug');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PharmacyDrug $pharmacyDrug): bool
    {
        return $user->can('view pharmacy drug');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create pharmacy drug');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PharmacyDrug $pharmacyDrug): bool
    {
        return $user->can('update pharmacy drug');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PharmacyDrug $pharmacyDrug): bool
    {
        return $user->can('delete pharmacy drug');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PharmacyDrug $pharmacyDrug): bool
    {
        return $user->can('restore pharmacy drug');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PharmacyDrug $pharmacyDrug): bool
    {
        return $user->can('force delete pharmacy drug');
    }
}

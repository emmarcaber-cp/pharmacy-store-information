<?php

namespace App\Policies;

use App\Models\Prescription;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PrescriptionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->is_patient ||
            $user->is_doctor ||
            $user->is_pharmacy ||
            $user->is_employee;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Prescription $prescription): bool
    {
        return $user->is_patient ||
            $user->is_doctor ||
            $user->is_pharmacy ||
            $user->is_employee;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->is_doctor;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Prescription $prescription): bool
    {
        return $user->is_doctor && $user->auth_id === $prescription->doctor->user->auth_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Prescription $prescription): bool
    {
        return $user->is_doctor && $user->auth_id === $prescription->doctor->user->auth_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Prescription $prescription): bool
    {
        return $user->is_doctor && $user->auth_id === $prescription->doctor->user->auth_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Prescription $prescription): bool
    {
        return $user->is_doctor && $user->auth_id === $prescription->doctor->user->auth_id;
    }
}

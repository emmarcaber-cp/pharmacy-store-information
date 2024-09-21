<?php

namespace App\Policies;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ContractPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->is_drug_manufacturer || $user->is_pharmacy;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Contract $contract): bool
    {
        $contractPharmacyOwnerId = $contract->pharmacy->user->auth_id;
        $contractDrugManufacturerOwnerId = $contract->pharmacy->user->auth_id;

        return $user->auth_id === $contractPharmacyOwnerId ||
            $user->auth_id === $contractDrugManufacturerOwnerId;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->is_drug_manufacturer || $user->is_pharmacy;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Contract $contract): bool
    {
        $contractPharmacyOwnerId = $contract->pharmacy->user->auth_id;
        $contractDrugManufacturerOwnerId = $contract->pharmacy->user->auth_id;

        return $user->auth_id === $contractPharmacyOwnerId ||
            $user->auth_id === $contractDrugManufacturerOwnerId;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Contract $contract): bool
    {
        $contractPharmacyOwnerId = $contract->pharmacy->user->auth_id;
        $contractDrugManufacturerOwnerId = $contract->pharmacy->user->auth_id;

        return $user->auth_id === $contractPharmacyOwnerId ||
            $user->auth_id === $contractDrugManufacturerOwnerId;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Contract $contract): bool
    {
        $contractPharmacyOwnerId = $contract->pharmacy->user->auth_id;
        $contractDrugManufacturerOwnerId = $contract->pharmacy->user->auth_id;

        return $user->auth_id === $contractPharmacyOwnerId ||
            $user->auth_id === $contractDrugManufacturerOwnerId;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Contract $contract): bool
    {
        $contractPharmacyOwnerId = $contract->pharmacy->user->auth_id;
        $contractDrugManufacturerOwnerId = $contract->pharmacy->user->auth_id;

        return $user->auth_id === $contractPharmacyOwnerId ||
            $user->auth_id === $contractDrugManufacturerOwnerId;
    }
}

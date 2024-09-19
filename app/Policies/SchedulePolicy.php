<?php

namespace App\Policies;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SchedulePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->is_employee || $user->is_pharmacy;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Schedule $schedule): bool
    {
        return $user->is_employee || $user->is_pharmacy;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->is_employee || $user->is_pharmacy;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Schedule $schedule): bool
    {
        $schedulePharmacyOwnerId = $schedule->pharmacy->user->auth_id;
        $scheduleEmployeeOwnerId = $schedule->employee->user->auth_id;

        return $user->id === $schedulePharmacyOwnerId ||
            $user->id === $scheduleEmployeeOwnerId;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Schedule $schedule): bool
    {
        $schedulePharmacyOwnerId = $schedule->pharmacy->user->auth_id;
        $scheduleEmployeeOwnerId = $schedule->employee->user->auth_id;

        return $user->id === $schedulePharmacyOwnerId ||
            $user->id === $scheduleEmployeeOwnerId;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Schedule $schedule): bool
    {
        $schedulePharmacyOwnerId = $schedule->pharmacy->user->auth_id;
        $scheduleEmployeeOwnerId = $schedule->employee->user->auth_id;

        return $user->id === $schedulePharmacyOwnerId ||
            $user->id === $scheduleEmployeeOwnerId;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Schedule $schedule): bool
    {
        $schedulePharmacyOwnerId = $schedule->pharmacy->user->auth_id;
        $scheduleEmployeeOwnerId = $schedule->employee->user->auth_id;

        return $user->id === $schedulePharmacyOwnerId ||
            $user->id === $scheduleEmployeeOwnerId;
    }
}

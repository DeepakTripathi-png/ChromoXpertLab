<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait GuardFilterTrait
{
    protected function getCurrentGuard()
    {
        return collect(['master_admins', 'doctor', 'branch'])->first(fn($g) => Auth::guard($g)->check()) ?? 'master_admins';
    }

    protected function filterAppointmentQuery($query)
    {
        $guard = $this->getCurrentGuard();
        $user = Auth::guard($guard)->user();

        if ($guard === 'branch') {
            $query->where('lab_id', $user->id); // Use existing lab_id for branch filtering
        } elseif ($guard === 'doctor') {
            $query->where('internal_doctor_id', $user->id); // New field for doctor filtering
        }
        // Admins see all—no filter

        return $query;
    }
}
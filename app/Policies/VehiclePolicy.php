<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vehicle;

class VehiclePolicy
{
    public function view(User $user, Vehicle $vehicle): bool
    {
        return $user->isAdmin() || $user->id === $vehicle->user_id;
    }

    public function update(User $user, Vehicle $vehicle): bool
    {
        return $user->isAdmin() || $user->id === $vehicle->user_id;
    }
}

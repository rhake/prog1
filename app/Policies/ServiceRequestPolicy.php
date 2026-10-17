<?php

namespace App\Policies;

use App\Models\ServiceRequest;
use App\Models\User;

class ServiceRequestPolicy
{
    public function view(User $user, ServiceRequest $serviceRequest): bool
    {
        return $user->isAdmin() || $user->id === $serviceRequest->user_id;
    }

    public function update(User $user, ServiceRequest $serviceRequest): bool
    {
        return $user->isAdmin() || $user->id === $serviceRequest->user_id;
    }
}

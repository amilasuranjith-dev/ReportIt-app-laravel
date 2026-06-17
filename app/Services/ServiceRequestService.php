<?php

namespace App\Services;

use App\Models\User;
use App\Models\ServiceRequest;
use App\Enums\RequestStatus;

class ServiceRequestService
{
    public function createServiceRequest(User $user, array $data): ServiceRequest
    {
        $serviceRequest = $user->serviceRequests()->create([
            'title' => $data['title'],
            'category' => $data['category'],
            'description' => $data['description'],
            'location' => $data['location'] ?? null,
            'status' => RequestStatus::PENDING,
        ]);

        return $serviceRequest;
    }
}

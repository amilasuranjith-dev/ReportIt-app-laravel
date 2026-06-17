<?php

namespace App\Services;

use App\Models\User;
use App\Models\ServiceRequest;
use App\Enums\RequestStatus;

class ServiceRequestService
{
    public function createServiceRequest(User $user, array $data, array $images = []): ServiceRequest
    {
        $serviceRequest = $user->serviceRequests()->create([
            'title' => $data['title'],
            'category' => $data['category'],
            'description' => $data['description'],
            'location' => $data['location'] ?? null,
            'status' => RequestStatus::PENDING,
        ]);

        if (!empty($images)) {
            foreach ($images as $image) {
                $path = $image->store('service-requests', 'public');
                $serviceRequest->images()->create([
                    'image_path' => $path,
                    'original_filename' => $image->getClientOriginalName(),
                ]);
            }
        }

        return $serviceRequest;
    }

    public function updateServiceRequest(ServiceRequest $serviceRequest, array $data, array $images = []): ServiceRequest
    {
        $serviceRequest->update([
            'title' => $data['title'],
            'category' => $data['category'],
            'description' => $data['description'],
            'location' => $data['location'] ?? null,
        ]);

        if (!empty($images)) {
            foreach ($images as $image) {
                $path = $image->store('service-requests', 'public');
                $serviceRequest->images()->create([
                    'image_path' => $path,
                    'original_filename' => $image->getClientOriginalName(),
                ]);
            }
        }

        return $serviceRequest;
    }
}

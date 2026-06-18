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

    public function getAllRequests(string $statusFilter = 'all')
    {
        $query = ServiceRequest::with('user')->latest();

        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        return $query->paginate(10);
    }

    public function getSystemStats(): array
    {
        return [
            'total' => ServiceRequest::count(),
            'pending' => ServiceRequest::where('status', 'pending')->count(),
            'inProgress' => ServiceRequest::where('status', 'in_progress')->count(),
            'resolved' => ServiceRequest::where('status', 'resolved')->count(),
        ];
    }
}

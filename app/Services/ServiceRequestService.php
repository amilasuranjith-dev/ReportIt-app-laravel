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

    public function getAllRequests(string $statusFilter = 'all', string $searchQuery = '')
    {
        $query = ServiceRequest::with('user')->oldest();

        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        if (!empty($searchQuery)) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('title', 'like', '%' . $searchQuery . '%')
                  ->orWhere('id', 'like', '%' . $searchQuery . '%')
                  ->orWhereHas('user', function($userQuery) use ($searchQuery) {
                      $userQuery->where('name', 'like', '%' . $searchQuery . '%')
                                ->orWhere('email', 'like', '%' . $searchQuery . '%');
                  });
            });
        }

        return $query->paginate(10);
    }

    public function updateStatusAndNotes(ServiceRequest $serviceRequest, string $status, ?string $adminNotes): ServiceRequest
    {
        $serviceRequest->update([
            'status' => \App\Enums\RequestStatus::from($status),
            'admin_notes' => $adminNotes,
        ]);

        return $serviceRequest;
    }

    public function getSystemStats(): array
    {
        return [
            'total' => ServiceRequest::count(),
            'pending' => ServiceRequest::where('status', 'pending')->count(),
            'in_progress' => ServiceRequest::where('status', 'in_progress')->count(),
            'resolved' => ServiceRequest::where('status', 'resolved')->count(),
            'rejected' => ServiceRequest::where('status', 'rejected')->count(),
        ];
    }

    public function deleteRequest(ServiceRequest $serviceRequest): void
    {
        $serviceRequest->delete();
    }
}

<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\ServiceRequest;

new class extends Component
{
    use WithPagination;

    public $statusFilter = '';
    public ?ServiceRequest $selectedRequest = null;

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function viewDetails($id)
    {
        $this->selectedRequest = auth()->user()->serviceRequests()->with('images')->find($id);
        $this->dispatch('open-modal', 'view-details');
    }

    public function deleteRequest($id)
    {
        $request = auth()->user()->serviceRequests()->with('images')->find($id);

        if ($request && $request->status->value === 'pending') {
            // Delete associated images from storage
            foreach ($request->images as $image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image_path);
            }
            $request->delete();
            session()->flash('success', 'Request deleted successfully.');
        }
    }

    public function with(): array
    {
        $query = auth()->user()->serviceRequests()->latest();

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return [
            'requests' => $query->paginate(10),
        ];
    }
};
?>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative">
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition.duration.500ms class="absolute top-4 right-4 z-10 p-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200 shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col sm:flex-row items-center justify-between p-6 border-b border-gray-100 gap-4">
        <h3 class="text-lg font-bold text-gray-900">My Requests</h3>
        <div>
            <select wire:model.live="statusFilter" class="bg-white border border-gray-200 text-gray-700 py-2 pl-4 pr-8 rounded-lg leading-tight focus:outline-none focus:border-blue-500 font-medium text-sm cursor-pointer hover:border-gray-300 transition-colors">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="resolved">Resolved</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-100 text-sm font-semibold text-gray-900 bg-gray-50/50">
                    <th class="p-4 pl-6">#</th>
                    <th class="p-4">Issue Details</th>
                    <th class="p-4 text-center">Category</th>
                    <th class="p-4 text-center">Status</th>
                    <th class="p-4 text-center">Date Submitted</th>
                    <th class="p-4 pr-6 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($requests as $request)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="p-4 pl-6 font-semibold text-gray-900">{{ $loop->iteration + ($requests->currentPage() - 1) * $requests->perPage() }}</td>
                    <td class="p-4">
                        <div class="flex gap-4 items-start">
                            <div class="w-16 h-16 rounded-lg bg-gray-200 shrink-0 overflow-hidden flex items-center justify-center text-gray-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">{{ $request->title }}</h4>
                                <p class="text-sm text-gray-500 mt-1 max-w-xs line-clamp-2">{{ $request->description }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 text-center">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold text-blue-600 bg-blue-50 rounded-md border border-blue-100">
                            {{ ucfirst(str_replace('_', ' ', $request->category)) }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        @php
                            $statusColor = match($request->status->value) {
                                'pending' => 'orange',
                                'in_progress' => 'blue',
                                'resolved' => 'green',
                                default => 'gray'
                            };
                        @endphp
                        <span class="inline-flex items-center gap-1.5 font-medium text-{{ $statusColor }}-500 text-sm">
                            <span class="w-2 h-2 rounded-full bg-{{ $statusColor }}-500"></span> {{ ucfirst(str_replace('_', ' ', $request->status->value)) }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <div class="text-sm font-medium text-gray-900">{{ $request->created_at->format('M d, Y') }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ $request->created_at->format('h:i A') }}</div>
                    </td>
                    <td class="p-4 pr-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button wire:click="viewDetails({{ $request->id }})" class="px-3 py-1.5 text-xs font-semibold text-blue-600 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors">View Details</button>
                            
                            @if($request->status->value === 'pending')
                                <a href="{{ route('requests.edit', $request->id) }}" wire:navigate.hover class="px-3 py-1.5 text-xs font-semibold text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Edit</a>
                                <button wire:click="deleteRequest({{ $request->id }})" wire:confirm="Are you sure you want to delete this request?" class="px-3 py-1.5 text-xs font-semibold text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition-colors">Delete</button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-500">
                        No service requests found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($requests->hasPages())
    <div class="p-4 border-t border-gray-100">
        {{ $requests->links() }}
    </div>
    @endif

    <!-- View Details Modal -->
    <x-modal name="view-details" maxWidth="lg">
        @if($selectedRequest)
        <div class="bg-white rounded-xl overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h2 class="text-lg font-bold text-gray-900">Request Details</h2>
                <button x-on:click="$dispatch('close')" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 space-y-6">
                <!-- Title & Category/Status Badges -->
                <div>
                    <div class="flex justify-between items-start gap-4">
                        <h3 class="text-xl font-bold text-gray-900 leading-tight">{{ $selectedRequest->title }}</h3>
                        
                        <!-- Status Badge -->
                        @php
                            $statusColor = match($selectedRequest->status->value) {
                                'pending' => 'orange',
                                'in_progress' => 'blue',
                                'resolved' => 'green',
                                default => 'gray'
                            };
                        @endphp
                        <span class="shrink-0 inline-flex items-center gap-1.5 font-medium text-{{ $statusColor }}-600 text-xs bg-{{ $statusColor }}-50 px-3 py-1.5 rounded-full border border-{{ $statusColor }}-100 shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-{{ $statusColor }}-500 animate-pulse"></span> {{ ucfirst(str_replace('_', ' ', $selectedRequest->status->value)) }}
                        </span>
                    </div>
                    
                    <!-- Category Badge -->
                    <div class="mt-3 flex items-center gap-3">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-md border border-gray-200">
                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            {{ ucfirst(str_replace('_', ' ', $selectedRequest->category)) }}
                        </span>
                    </div>
                </div>
                
                <!-- Images -->
                @if($selectedRequest->images->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach($selectedRequest->images as $image)
                            <a href="{{ Storage::url($image->image_path) }}" target="_blank" class="block relative rounded-xl overflow-hidden border border-gray-200 aspect-video shadow-sm hover:opacity-90 transition-opacity">
                                <img src="{{ Storage::url($image->image_path) }}" alt="Request Image" class="w-full h-full object-cover bg-gray-100">
                            </a>
                        @endforeach
                    </div>
                @else
                    <!-- Image Placeholder -->
                    <div class="w-full h-32 bg-gray-50/80 rounded-xl flex flex-col items-center justify-center text-gray-400 border-2 border-dashed border-gray-200">
                        <svg class="w-8 h-8 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-sm font-medium text-gray-500">No images attached</span>
                    </div>
                @endif

                <!-- Description -->
                <div>
                    <h4 class="text-sm font-bold text-gray-900 mb-2">Description</h4>
                    <div class="bg-gray-50 rounded-xl p-4 text-gray-700 text-sm leading-relaxed border border-gray-100 shadow-inner">
                        {{ $selectedRequest->description }}
                    </div>
                </div>

                <!-- Location -->
                <div>
                    <h4 class="text-sm font-bold text-gray-900 mb-2 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Location Details
                    </h4>
                    <p class="text-gray-700 text-sm pl-6 bg-white border border-gray-100 rounded-lg p-3 shadow-sm">{{ $selectedRequest->location ?? 'Specific location not provided' }}</p>
                </div>

                <!-- Admin Notes -->
                @if($selectedRequest->admin_notes)
                <div class="bg-blue-50/50 rounded-xl p-4 border border-blue-100 relative overflow-hidden shadow-sm mt-4">
                    <div class="absolute top-0 left-0 w-1 h-full bg-blue-500"></div>
                    <h4 class="text-sm font-bold text-blue-900 flex items-center gap-1.5 mb-2">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Authority Feedback
                    </h4>
                    <p class="text-blue-800 text-sm pl-6">{{ $selectedRequest->admin_notes }}</p>
                </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/80 flex items-center justify-between">
                <div class="text-xs text-gray-500 flex items-center gap-1.5 font-medium">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Submitted: {{ $selectedRequest->created_at->format('M d, Y') }} at {{ $selectedRequest->created_at->format('h:i A') }}
                </div>
                <button x-on:click="$dispatch('close')" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold text-sm rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-1">
                    Close
                </button>
            </div>
        </div>
        @endif
    </x-modal>
</div>

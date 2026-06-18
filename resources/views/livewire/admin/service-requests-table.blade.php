<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\ServiceRequest;
use App\Services\ServiceRequestService;

new class extends Component
{
    use WithPagination;

    public $statusFilter = 'pending';
    public $searchQuery = '';
    public ?ServiceRequest $selectedRequest = null;
    
    // Slice 3 properties
    public $editingStatus = '';
    public $adminNotes = '';

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    public function viewDetails($id)
    {
        $this->selectedRequest = ServiceRequest::with(['images', 'user'])->find($id);
        $this->dispatch('open-modal', 'view-details');
    }

    public function manageRequest($id)
    {
        $this->selectedRequest = ServiceRequest::with(['images', 'user'])->find($id);
        $this->editingStatus = $this->selectedRequest->status->value;
        $this->adminNotes = $this->selectedRequest->admin_notes ?? '';
        $this->dispatch('open-modal', 'manage-request');
    }

    public function saveManagement(ServiceRequestService $service)
    {
        $this->validate([
            'editingStatus' => 'required|in:pending,in_progress,resolved',
            'adminNotes' => 'nullable|string|max:1000',
        ]);

        $service->updateStatusAndNotes($this->selectedRequest, $this->editingStatus, $this->adminNotes);
        
        $this->dispatch('close-modal', 'manage-request');
        session()->flash('success', 'Request #'.$this->selectedRequest->id.' updated successfully.');
    }

    public function with(ServiceRequestService $serviceRequestService): array
    {
        return [
            'requests' => $serviceRequestService->getAllRequests($this->statusFilter, $this->searchQuery),
        ];
    }
};
?>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative">
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition.duration.500ms class="fixed top-24 right-6 z-[100] p-4 text-sm font-medium text-green-800 rounded-xl bg-green-50 border border-green-200 shadow-xl flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col sm:flex-row items-center justify-between p-6 border-b border-gray-100 gap-4">
        <h3 class="text-lg font-bold text-gray-900">All System Requests</h3>
        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input wire:model.live.debounce.300ms="searchQuery" type="search" placeholder="Search by ID, Title or User..." class="w-full bg-white border border-gray-200 text-gray-700 py-2 pl-10 pr-4 rounded-lg leading-tight focus:outline-none focus:border-blue-500 font-medium text-sm transition-colors shadow-sm">
            </div>
            <select wire:model.live="statusFilter" class="w-full sm:w-auto bg-white border border-gray-200 text-gray-700 py-2 pl-4 pr-8 rounded-lg leading-tight focus:outline-none focus:border-blue-500 font-medium text-sm cursor-pointer hover:border-gray-300 transition-colors shadow-sm shrink-0">
                <option value="all">All Status</option>
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
                    <th class="p-4 text-center">Submitted By</th>
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
                            <div class="w-12 h-12 rounded-lg bg-gray-200 shrink-0 overflow-hidden flex items-center justify-center text-gray-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">{{ $request->title }}</h4>
                                <p class="text-sm text-gray-500 mt-1 max-w-xs line-clamp-1">{{ $request->description }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 text-center">
                        <div class="text-sm font-medium text-gray-900">{{ $request->user->name }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ $request->user->email }}</div>
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
                            <button wire:click="manageRequest({{ $request->id }})" class="px-3 py-1.5 text-xs font-bold text-white bg-indigo-600 border border-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">Manage</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-500">
                        No service requests found in the system.
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

    <!-- Manage Request Modal -->
    <x-modal name="manage-request" maxWidth="lg">
        @if($selectedRequest)
        <div class="bg-white rounded-xl overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Manage Request #{{ $selectedRequest->id }}
                </h2>
                <button x-on:click="$dispatch('close')" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
                <!-- User Details -->
                <div class="bg-indigo-50/50 rounded-xl p-4 border border-indigo-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-indigo-800 uppercase tracking-wider mb-1">Reported By</p>
                        <p class="text-sm font-bold text-gray-900">{{ $selectedRequest->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $selectedRequest->user->email }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-semibold text-indigo-800 uppercase tracking-wider mb-1">Date</p>
                        <p class="text-sm font-bold text-gray-900">{{ $selectedRequest->created_at->format('M d, Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $selectedRequest->created_at->format('h:i A') }}</p>
                    </div>
                </div>

                <!-- Issue Information -->
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-md border border-gray-200">
                            {{ ucfirst(str_replace('_', ' ', $selectedRequest->category)) }}
                        </span>
                        @php
                            $statusColor = match($selectedRequest->status->value) {
                                'pending' => 'orange',
                                'in_progress' => 'blue',
                                'resolved' => 'green',
                                default => 'gray'
                            };
                        @endphp
                        <span class="inline-flex items-center gap-1.5 font-medium text-{{ $statusColor }}-600 text-xs bg-{{ $statusColor }}-50 px-3 py-1 rounded-full border border-{{ $statusColor }}-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-{{ $statusColor }}-500"></span> {{ ucfirst(str_replace('_', ' ', $selectedRequest->status->value)) }}
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 leading-tight mb-2">{{ $selectedRequest->title }}</h3>
                    <div class="bg-gray-50 rounded-xl p-4 text-gray-700 text-sm leading-relaxed border border-gray-100">
                        {{ $selectedRequest->description }}
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
                @endif

                <!-- Location -->
                <div>
                    <h4 class="text-sm font-bold text-gray-900 mb-2 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Location Details
                    </h4>
                    <p class="text-gray-700 text-sm pl-6">{{ $selectedRequest->location ?? 'Specific location not provided' }}</p>
                </div>

                <!-- Admin Action Form -->
                <div class="border-t border-gray-200 pt-6 mt-6">
                    <h4 class="text-base font-bold text-gray-900 mb-4">Admin Action</h4>
                    
                    <form wire:submit="saveManagement" class="space-y-4 bg-white">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Update Status</label>
                            <select wire:model="editingStatus" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="resolved">Resolved</option>
                            </select>
                            @error('editingStatus') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Official Notes / Feedback</label>
                            <textarea wire:model="adminNotes" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Add resolution details or updates for the citizen..."></textarea>
                            <p class="mt-1 text-xs text-gray-500">These notes will be directly visible to the citizen who submitted the request.</p>
                            @error('adminNotes') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end gap-3 pt-4">
                            <button type="button" x-on:click="$dispatch('close')" class="px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 shadow-sm">Cancel</button>
                            <button type="submit" class="px-5 py-2.5 bg-indigo-600 border border-transparent rounded-lg text-sm font-semibold text-white hover:bg-indigo-700 shadow-sm flex items-center gap-2">
                                <svg wire:loading wire:target="saveManagement" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </x-modal>

    <!-- View Details Modal -->
    <x-modal name="view-details" maxWidth="lg">
        @if($selectedRequest)
        <div class="bg-white rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h2 class="text-lg font-bold text-gray-900">Request Details</h2>
                <button x-on:click="$dispatch('close')" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
                <div class="flex justify-between items-start gap-4">
                    <h3 class="text-xl font-bold text-gray-900 leading-tight">{{ $selectedRequest->title }}</h3>
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
                
                <div class="mt-3 flex items-center gap-4">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-md border border-gray-200">
                        {{ ucfirst(str_replace('_', ' ', $selectedRequest->category)) }}
                    </span>
                    <div class="flex items-center gap-1.5 text-xs text-gray-500">
                        Submitted by: <span class="font-bold text-gray-700">{{ $selectedRequest->user->name }}</span>
                    </div>
                </div>
                
                @if($selectedRequest->images->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach($selectedRequest->images as $image)
                            <a href="{{ Storage::url($image->image_path) }}" target="_blank" class="block relative rounded-xl overflow-hidden border border-gray-200 aspect-video shadow-sm hover:opacity-90 transition-opacity">
                                <img src="{{ Storage::url($image->image_path) }}" alt="Request Image" class="w-full h-full object-cover bg-gray-100">
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="w-full h-24 bg-gray-50/80 rounded-xl flex flex-col items-center justify-center text-gray-400 border-2 border-dashed border-gray-200">
                        <span class="text-xs font-medium text-gray-500">No images attached</span>
                    </div>
                @endif

                <div>
                    <h4 class="text-sm font-bold text-gray-900 mb-2">Description</h4>
                    <div class="bg-gray-50 rounded-xl p-4 text-gray-700 text-sm leading-relaxed border border-gray-100 shadow-inner">
                        {{ $selectedRequest->description }}
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-bold text-gray-900 mb-2">Location Details</h4>
                    <p class="text-gray-700 text-sm pl-6 bg-white border border-gray-100 rounded-lg p-3 shadow-sm">{{ $selectedRequest->location ?? 'Specific location not provided' }}</p>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/80 flex items-center justify-between">
                <div class="text-xs text-gray-500 flex items-center gap-1.5 font-medium">
                    Submitted: {{ $selectedRequest->created_at->format('M d, Y') }}
                </div>
                <button x-on:click="$dispatch('close')" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold text-sm rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm">
                    Close
                </button>
            </div>
        </div>
        @endif
    </x-modal>
</div>

<?php

use Livewire\Volt\Component;
use App\Services\ServiceRequestService;

new class extends Component
{
    public $title;
    public $category;
    public $description;
    public $location;

    public function saveRequest(ServiceRequestService $service)
    {   
        //validation
        $validatedData = $this->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'location' => 'required|string|max:500',
        ]);
        
        // pass data to service
        $service->createServiceRequest(auth()->user(), $validatedData);

        $this->reset();

        session()->flash('success', 'Service Request created successfully!');
    }
};
?>

<div>
   {{-- සාර්ථකව Save වුනාම පණිවිඩය පෙන්නන තැන --}}
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition.duration.500ms class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50">
            {{ session('success') }}
        </div>
    @endif
    {{-- Form එක --}}
    <form wire:submit="saveRequest" class="space-y-6">
        
        <!-- Title -->
        <div>
            <x-input-label for="title" :value="__('Title')" />
            <x-text-input wire:model="title" id="title" class="block mt-1 w-full" type="text" required />
            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <!-- Category -->
        <div>
            <x-input-label for="category" :value="__('Category')" />
            <select wire:model="category" id="category" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                <option value="">Select a Category...</option>
                <option value="street_light">Broken Street Light</option>
                <option value="road_damage">Damaged Road</option>
                <option value="garbage">Garbage Collection</option>
                <option value="water_leak">Water Leak</option>
                <option value="other">Other</option>
            </select>
            @error('category') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <!-- Description -->
        <div>
            <x-input-label for="description" :value="__('Description')" />
            <textarea wire:model="description" id="description" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" rows="4" required></textarea>
            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <!-- Location -->
        <div>
            <x-input-label for="location" :value="__('Location Address')" />
            <x-text-input wire:model="location" id="location" class="block mt-1 w-full" type="text" required />
            @error('location') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <!-- Submit Button -->
        <x-primary-button>
            {{ __('Submit Request') }}
        </x-primary-button>
        
    </form>
</div>
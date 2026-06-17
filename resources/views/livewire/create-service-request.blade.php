<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Services\ServiceRequestService;

new class extends Component
{
    use WithFileUploads;

    public $title;
    public $category;
    public $description;
    public $location;
    public $images = [];

    public function saveRequest(ServiceRequestService $service)
    {   
        //validation
        $validatedData = $this->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'location' => 'required|string|max:500',
            'images.*' => 'image|max:5120',
        ]);
        
        // pass data to service
        $service->createServiceRequest(auth()->user(), $validatedData, $this->images);

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

        <!-- Images -->
        <div>
            <x-input-label for="images" :value="__('Upload Images (Optional)')" />
            <div class="mt-1 flex items-center justify-center w-full">
                <label for="images" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-500">PNG, JPG up to 5MB</p>
                    </div>
                    <input id="images" type="file" wire:model="images" class="hidden" multiple accept="image/*" />
                </label>
            </div>
            @error('images.*') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror

            <!-- Previews -->
            @if ($images)
                <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($images as $image)
                        <div class="relative rounded-lg overflow-hidden border border-gray-200 aspect-square shadow-sm">
                            <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Submit Button -->
        <x-primary-button>
            {{ __('Submit Request') }}
        </x-primary-button>
        
    </form>
</div>
<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Models\ServiceRequest;
use App\Services\ServiceRequestService;
use Illuminate\Support\Facades\Storage;

new class extends Component
{
    use WithFileUploads;

    public ServiceRequest $serviceRequest;

    public $title;
    public $category;
    public $description;
    public $location;
    public $images = [];
    public $existingImages = [];

    public function mount(ServiceRequest $serviceRequest)
    {
        $this->serviceRequest = $serviceRequest;
        $this->title = $serviceRequest->title;
        $this->category = $serviceRequest->category;
        $this->description = $serviceRequest->description;
        $this->location = $serviceRequest->location;
        $this->existingImages = $serviceRequest->images;
    }

    public function deleteImage($imageId)
    {
        $image = $this->serviceRequest->images()->find($imageId);
        if ($image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
            $this->existingImages = $this->serviceRequest->images()->get();
        }
    }

    public function updateRequest(ServiceRequestService $service)
    {
        $validatedData = $this->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'location' => 'required|string|max:500',
            'images.*' => 'image|max:5120',
        ]);
        
        $service->updateServiceRequest($this->serviceRequest, $validatedData, $this->images);

        session()->flash('success', 'Service Request updated successfully!');
        return redirect()->route('dashboard');
    }
};
?>

<div>
    <form wire:submit="updateRequest" class="space-y-6">
        
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
            <x-input-label for="images" :value="__('Upload Additional Images (Optional)')" />
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

            <!-- Previews for newly uploaded images -->
            @if ($images)
                <h4 class="mt-4 text-sm font-semibold text-gray-700">New Images to Upload:</h4>
                <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($images as $image)
                        <div class="relative rounded-lg overflow-hidden border border-gray-200 aspect-square shadow-sm">
                            <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Existing Images -->
            @if(count($existingImages) > 0)
                <h4 class="mt-6 text-sm font-semibold text-gray-700">Existing Images:</h4>
                <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($existingImages as $image)
                        <div class="relative rounded-lg overflow-hidden border border-gray-200 aspect-square shadow-sm group">
                            <img src="{{ Storage::url($image->image_path) }}" class="w-full h-full object-cover">
                            <!-- Delete existing image button -->
                            <button type="button" wire:click="deleteImage({{ $image->id }})" wire:confirm="Delete this image?" class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Submit Button -->
        <x-primary-button>
            {{ __('Save Changes') }}
        </x-primary-button>
        
    </form>
</div>

<x-app-layout>
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Edit Service Request</h3>
                    <p class="text-sm text-gray-500 mt-1">Update the details of your pending request below.</p>
                </div>
                <a href="{{ route('dashboard') }}" wire:navigate.hover class="px-4 py-2 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Back to Dashboard</a>
            </div>
            
            <div class="p-6">
                <livewire:edit-service-request :serviceRequest="$serviceRequest" />
            </div>
        </div>
    </div>
</x-app-layout>

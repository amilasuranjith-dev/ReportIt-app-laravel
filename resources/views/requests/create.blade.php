<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden p-6 sm:p-10">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Submit a New Request</h2>
                <p class="text-sm text-gray-500 mt-1">Please provide details about the issue so we can resolve it as quickly as possible.</p>
            </div>
            
            <livewire:create-service-request />
        </div>
    </div>
</x-app-layout>

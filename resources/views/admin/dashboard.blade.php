<x-app-layout>
    <!-- Greeting -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">
            Admin Dashboard
        </h2>
        <p class="text-gray-500 mt-1">Manage all community service requests here.</p>
    </div>

    <livewire:admin.dashboard-stats />
    
    <livewire:admin.service-requests-table />
</x-app-layout>

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-xl font-bold text-gray-900">Admin Dashboard</h3>
                <p class="text-sm text-gray-500 mt-1">Manage all community service requests here.</p>
            </div>

            <livewire:admin.dashboard-stats />
            
            <div class="p-6">
                <livewire:admin.service-requests-table />
            </div>
        </div>
    </div>
</x-app-layout>

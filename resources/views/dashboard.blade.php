<x-app-layout>
    <!-- Greeting -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
            Welcome back, {{ Auth::user()->name }}! <span class="text-2xl">👋</span>
        </h2>
        <p class="text-gray-500 mt-1">Here's what's happening with your requests.</p>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Requests -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-gray-900">8</h3>
                <p class="text-sm font-semibold text-gray-900">Total Requests</p>
                <p class="text-xs text-gray-400 mt-0.5">All time requests</p>
            </div>
        </div>

        <!-- Pending -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5">
            <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-500 flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-gray-900">3</h3>
                <p class="text-sm font-semibold text-gray-900">Pending</p>
                <p class="text-xs text-gray-400 mt-0.5">Awaiting review</p>
            </div>
        </div>

        <!-- In Progress -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5">
            <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-gray-900">3</h3>
                <p class="text-sm font-semibold text-gray-900">In Progress</p>
                <p class="text-xs text-gray-400 mt-0.5">Being worked on</p>
            </div>
        </div>

        <!-- Resolved -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5">
            <div class="w-14 h-14 rounded-2xl bg-green-50 text-green-500 flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-gray-900">2</h3>
                <p class="text-sm font-semibold text-gray-900">Resolved</p>
                <p class="text-xs text-gray-400 mt-0.5">Successfully resolved</p>
            </div>
        </div>
    </div>

    <!-- My Requests Table Component -->
    <livewire:service-requests-table />
</x-app-layout>

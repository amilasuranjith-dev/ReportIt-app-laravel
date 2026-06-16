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

    <!-- My Requests Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex flex-col sm:flex-row items-center justify-between p-6 border-b border-gray-100 gap-4">
            <h3 class="text-lg font-bold text-gray-900">My Requests</h3>
            <div class="relative">
                <select class="appearance-none bg-white border border-gray-200 text-gray-700 py-2 pl-4 pr-10 rounded-lg leading-tight focus:outline-none focus:border-blue-500 font-medium text-sm">
                    <option>All Status</option>
                    <option>Pending</option>
                    <option>In Progress</option>
                    <option>Resolved</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
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
                    <!-- Row 1 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 pl-6 font-semibold text-gray-900">1</td>
                        <td class="p-4">
                            <div class="flex gap-4 items-start">
                                <div class="w-16 h-16 rounded-lg bg-gray-200 shrink-0 overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1519999482648-25049ddd37b1?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover" alt="Street Light">
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">Broken Street Light</h4>
                                    <p class="text-sm text-gray-500 mt-1 max-w-xs line-clamp-2">The street light outside my house is not working since last week. It is completely dark.</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-center">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold text-blue-600 bg-blue-50 rounded-md border border-blue-100">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                                Street Light
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <span class="inline-flex items-center gap-1.5 font-medium text-orange-500 text-sm">
                                <span class="w-2 h-2 rounded-full bg-orange-500"></span> Pending
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <div class="text-sm font-medium text-gray-900">May 20, 2024</div>
                            <div class="text-xs text-gray-500 mt-0.5">10:30 AM</div>
                        </td>
                        <td class="p-4 pr-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button class="px-3 py-1.5 text-xs font-semibold text-blue-600 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors">View Details</button>
                                <button class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 pl-6 font-semibold text-gray-900">2</td>
                        <td class="p-4">
                            <div class="flex gap-4 items-start">
                                <div class="w-16 h-16 rounded-lg bg-gray-200 shrink-0 overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover" alt="Road">
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">Damaged Road</h4>
                                    <p class="text-sm text-gray-500 mt-1 max-w-xs line-clamp-2">Large pothole on the main road causing traffic and vehicle damage.</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-center">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold text-purple-600 bg-purple-50 rounded-md border border-purple-100">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Road
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <span class="inline-flex items-center gap-1.5 font-medium text-blue-600 text-sm">
                                <span class="w-2 h-2 rounded-full bg-blue-600"></span> In Progress
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <div class="text-sm font-medium text-gray-900">May 19, 2024</div>
                            <div class="text-xs text-gray-500 mt-0.5">02:15 PM</div>
                        </td>
                        <td class="p-4 pr-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button class="px-3 py-1.5 text-xs font-semibold text-blue-600 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors">View Details</button>
                                <button class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 pl-6 font-semibold text-gray-900">3</td>
                        <td class="p-4">
                            <div class="flex gap-4 items-start">
                                <div class="w-16 h-16 rounded-lg bg-gray-200 shrink-0 overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover" alt="Garbage">
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">Garbage Collection Issue</h4>
                                    <p class="text-sm text-gray-500 mt-1 max-w-xs line-clamp-2">Garbage has not been collected in our area for 3 days.</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-center">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold text-green-600 bg-green-50 rounded-md border border-green-100">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Garbage
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <span class="inline-flex items-center gap-1.5 font-medium text-orange-500 text-sm">
                                <span class="w-2 h-2 rounded-full bg-orange-500"></span> Pending
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <div class="text-sm font-medium text-gray-900">May 18, 2024</div>
                            <div class="text-xs text-gray-500 mt-0.5">09:45 AM</div>
                        </td>
                        <td class="p-4 pr-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button class="px-3 py-1.5 text-xs font-semibold text-blue-600 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors">View Details</button>
                                <button class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 4 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 pl-6 font-semibold text-gray-900">4</td>
                        <td class="p-4">
                            <div class="flex gap-4 items-start">
                                <div class="w-16 h-16 rounded-lg bg-gray-200 shrink-0 overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1542013936693-884638332954?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover" alt="Water Leak">
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">Water Leak on Street</h4>
                                    <p class="text-sm text-gray-500 mt-1 max-w-xs line-clamp-2">Water leaking from pipe causing wastage and ponding on road.</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-center">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold text-cyan-600 bg-cyan-50 rounded-md border border-cyan-100">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg>
                                Water
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <span class="inline-flex items-center gap-1.5 font-medium text-green-500 text-sm">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span> Resolved
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <div class="text-sm font-medium text-gray-900">May 16, 2024</div>
                            <div class="text-xs text-gray-500 mt-0.5">11:20 AM</div>
                        </td>
                        <td class="p-4 pr-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button class="px-3 py-1.5 text-xs font-semibold text-blue-600 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors">View Details</button>
                                <button class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Placeholder -->
        <div class="p-4 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500">
            <div>Showing 1 to 4 of 4 requests</div>
            <div class="flex gap-1">
                <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded hover:bg-gray-50" disabled>&lt;</button>
                <button class="w-8 h-8 flex items-center justify-center border border-blue-600 bg-blue-600 text-white rounded">1</button>
                <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded hover:bg-gray-50" disabled>&gt;</button>
            </div>
        </div>
    </div>
</x-app-layout>

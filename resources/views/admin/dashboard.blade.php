<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Admin Headquarters') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <!-- Stat Cards -->
                <div class="bg-white rounded-3xl p-6 shadow-xl shadow-indigo-100/40 border border-gray-100 flex items-center gap-5 relative overflow-hidden group hover:-translate-y-1 transition-transform">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-indigo-200 relative z-10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Users</p>
                        <h3 class="text-4xl font-black text-gray-900">{{ $stats['total_users'] }}</h3>
                    </div>
                </div>
                
                <div class="bg-white rounded-3xl p-6 shadow-xl shadow-blue-100/40 border border-gray-100 flex items-center gap-5 relative overflow-hidden group hover:-translate-y-1 transition-transform">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center shadow-lg shadow-blue-200 relative z-10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Alumni</p>
                        <h3 class="text-4xl font-black text-gray-900">{{ $stats['total_alumni'] }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-6 shadow-xl shadow-green-100/40 border border-gray-100 flex items-center gap-5 relative overflow-hidden group hover:-translate-y-1 transition-transform">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 text-white flex items-center justify-center shadow-lg shadow-green-200 relative z-10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Students</p>
                        <h3 class="text-4xl font-black text-gray-900">{{ $stats['total_students'] }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-6 shadow-xl shadow-purple-100/40 border border-gray-100 flex items-center gap-5 relative overflow-hidden group hover:-translate-y-1 transition-transform">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 text-white flex items-center justify-center shadow-lg shadow-purple-200 relative z-10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Events</p>
                        <h3 class="text-4xl font-black text-gray-900">{{ $stats['total_events'] }}</h3>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl border border-gray-100">
                <div class="p-10">
                    <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-2">Administration Hub</h3>
                    <p class="text-gray-500 text-lg mb-8 max-w-2xl">Manage users, oversee posts, monitor events, and configure platform settings from your central command center.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="/admin/users" class="bg-gray-900 text-white px-8 py-3.5 rounded-xl font-bold hover:bg-indigo-600 transition-colors shadow-lg hover:shadow-indigo-500/30 transform hover:-translate-y-0.5">Manage Users</a>
                        <a href="/events" class="bg-white text-gray-900 border-2 border-gray-200 px-8 py-3.5 rounded-xl font-bold hover:border-gray-900 transition-colors">View All Events</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

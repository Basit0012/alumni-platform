<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Alumni Directory') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Search and Filter Bar -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8">
                <form method="GET" action="{{ route('alumni.index') }}" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <label for="search" class="sr-only">Search by name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-500 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="Search alumni by name...">
                        </div>
                    </div>
                    <div class="w-full md:w-64">
                        <select name="batch" class="block w-full py-3 pl-3 pr-10 border border-gray-200 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            <option value="">All Batches</option>
                            @foreach($batches as $batch)
                                <option value="{{ $batch }}" {{ request('batch') == $batch ? 'selected' : '' }}>Class of {{ $batch }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full md:w-auto px-8 py-3 border border-transparent rounded-xl shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        Filter
                    </button>
                    @if(request()->has('search') || request()->has('batch'))
                        <a href="{{ route('alumni.index') }}" class="w-full md:w-auto px-8 py-3 text-center border border-gray-300 rounded-xl shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">Clear</a>
                    @endif
                </form>
            </div>

            <!-- Alumni Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($alumni as $person)
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="h-24 bg-gradient-to-r from-indigo-500 to-purple-600 relative"></div>
                        <div class="px-6 pb-6 relative">
                            <div class="w-20 h-20 mx-auto -mt-10 rounded-full border-4 border-white bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-2xl shadow-sm overflow-hidden">
                                @if($person->profile && $person->profile->avatar)
                                    <img src="{{ asset('storage/' . $person->profile->avatar) }}" alt="{{ $person->name }}" class="w-full h-full object-cover">
                                @else
                                    {{ substr($person->name, 0, 1) }}
                                @endif
                            </div>
                            
                            <div class="text-center mt-3">
                                <h3 class="text-xl font-bold text-gray-900 leading-tight">
                                    <a href="{{ route('profile.show', $person) }}" class="hover:text-indigo-600 transition-colors">{{ $person->name }}</a>
                                </h3>
                                @if($person->profile)
                                    <p class="text-indigo-600 font-medium text-sm mt-1">{{ $person->profile->job_title ?? 'Alumni' }}</p>
                                    @if($person->profile->company)
                                        <p class="text-gray-500 text-sm mt-1 flex items-center justify-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                            {{ $person->profile->company }}
                                        </p>
                                    @endif
                                    @if($person->profile->graduation_year)
                                        <div class="mt-4 inline-block bg-gray-100 rounded-full px-3 py-1 text-xs font-semibold text-gray-600">
                                            Class of {{ $person->profile->graduation_year }}
                                        </div>
                                    @endif
                                @else
                                    <p class="text-gray-500 text-sm mt-1">Alumni Profile</p>
                                @endif
                            </div>

                            <div class="mt-6 flex flex-col gap-2">
                                @if(auth()->id() !== $person->id)
                                    <form action="{{ route('connections.send', $person) }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit" class="w-full py-2.5 px-4 border border-indigo-600 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white font-medium text-sm transition-colors text-center focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Connect
                                        </button>
                                    </form>
                                    
                                    @if(auth()->user()->role === 'student' && $person->role === 'alumni')
                                        <form action="{{ route('mentorship.request', $person) }}" method="POST" class="w-full">
                                            @csrf
                                            <button type="submit" class="w-full py-2.5 px-4 bg-purple-50 text-purple-700 rounded-xl hover:bg-purple-600 hover:text-white font-medium text-sm transition-colors text-center focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                                Request Mentorship
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 bg-white rounded-3xl border border-gray-100 text-center shadow-sm">
                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No alumni found</h3>
                        <p class="mt-1 text-gray-500">Try adjusting your search or filter criteria.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-8">
                {{ $alumni->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

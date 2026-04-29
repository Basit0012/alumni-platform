<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Alumni Directory') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Search / Filter -->
            <div class="bg-white rounded-3xl shadow-xl shadow-indigo-100/40 p-8 mb-10 border border-indigo-50 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-indigo-100 to-transparent rounded-full -mr-20 -mt-20 opacity-50"></div>
                <h3 class="text-lg font-bold text-gray-900 mb-4 relative z-10">Find Alumni</h3>
                <form method="GET" action="/alumni" class="flex flex-col sm:flex-row gap-4 relative z-10">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, company, major, or job title..." class="w-full pl-12 pr-4 py-4 rounded-2xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-gray-700 bg-gray-50 focus:bg-white transition-colors text-lg">
                    </div>
                    <button type="submit" class="bg-gray-900 text-white px-10 py-4 rounded-2xl font-bold shadow-lg hover:bg-indigo-600 hover:shadow-indigo-500/30 transform hover:-translate-y-0.5 transition-all text-lg tracking-wide">
                        Search
                    </button>
                </form>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($alumni as $alumnus)
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 border border-gray-100 group flex flex-col">
                    <div class="h-32 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 relative"></div>
                    <div class="px-6 pb-6 relative flex-1 flex flex-col">
                        <div class="w-24 h-24 mx-auto -mt-12 rounded-full border-4 border-white bg-white shadow-lg overflow-hidden flex items-center justify-center text-3xl font-black text-indigo-600 bg-indigo-50 relative z-10">
                            @if($alumnus->profile && $alumnus->profile->avatar)
                                <img src="{{ asset('storage/'.$alumnus->profile->avatar) }}" class="w-full h-full object-cover">
                            @else
                                {{ substr($alumnus->name, 0, 1) }}
                            @endif
                        </div>
                        <div class="text-center mt-5 flex-1">
                            <h3 class="text-xl font-bold text-gray-900 leading-tight group-hover:text-indigo-600 transition-colors">{{ $alumnus->name }}</h3>
                            <p class="text-indigo-600 font-semibold text-sm mt-1">
                                {{ $alumnus->profile->job_title ?? 'Alumni Member' }} 
                                @if($alumnus->profile && $alumnus->profile->company) 
                                    <span class="text-gray-500 font-normal">at</span> {{ $alumnus->profile->company }} 
                                @endif
                            </p>
                            <p class="text-xs text-gray-400 mt-2 font-medium tracking-wide uppercase">
                                {{ $alumnus->profile->major ?? 'Unknown Major' }} @if($alumnus->profile && $alumnus->profile->graduation_year) • '{{ substr($alumnus->profile->graduation_year, -2) }} @endif
                            </p>
                        </div>
                        <div class="mt-8 flex justify-center gap-3">
                            <a href="/alumni/{{ $alumnus->id }}" class="flex-1 bg-gray-50 text-gray-700 hover:bg-gray-100 border border-gray-200 py-2.5 rounded-xl font-semibold transition-colors text-center text-sm shadow-sm">View Profile</a>
                            <form action="/connections/{{ $alumnus->id }}" method="POST" class="flex-1">
                                @csrf
                                <button class="w-full bg-indigo-600 text-white hover:bg-indigo-700 py-2.5 rounded-xl font-semibold transition-colors text-sm shadow-md shadow-indigo-200">Connect</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-12">
                {{ $alumni->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Events & Networking') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('status'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg shadow-sm" role="alert">
                    <p class="font-bold">Success</p>
                    <p>{{ session('status') }}</p>
                </div>
            @endif

            <!-- Create Event (Only Alumni & Admin) -->
            @if(auth()->user()->role === 'alumni' || auth()->user()->role === 'admin')
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-bl-full -mr-16 -mt-16 z-0"></div>
                <div class="relative z-10">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Host a New Event
                    </h3>
                    <form action="{{ route('events.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Event Title</label>
                                <input type="text" name="title" required class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="e.g. Tech Industry Mixer">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date & Time</label>
                                <input type="datetime-local" name="event_date" required class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea name="description" rows="3" required class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="What is this event about?"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                <input type="text" name="location" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="Venue or City">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Meeting Link (If Online)</label>
                                <input type="url" name="meeting_link" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="https://zoom.us/...">
                            </div>
                            <div class="md:col-span-2 flex items-center gap-2">
                                <input type="checkbox" name="is_online" value="1" id="is_online" class="rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="is_online" class="text-sm font-medium text-gray-700">This is an online event</label>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all hover:-translate-y-0.5">
                                Create Event
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <!-- Events List -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($events as $event)
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl transition-shadow flex flex-col h-full">
                        <div class="relative h-48 bg-gray-200">
                            @if($event->cover_image)
                                <img src="{{ asset('storage/' . $event->cover_image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-indigo-600 opacity-90"></div>
                            @endif
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-lg shadow-sm">
                                <span class="text-sm font-bold text-indigo-600">{{ $event->event_date->format('M d') }}</span>
                                <span class="text-xs text-gray-500 block text-center">{{ $event->event_date->format('h:i A') }}</span>
                            </div>
                            @if($event->is_online)
                                <div class="absolute top-4 left-4 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span> Online
                                </div>
                            @endif
                        </div>
                        
                        <div class="p-6 flex-1 flex flex-col">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 leading-tight">{{ $event->title }}</h3>
                            
                            <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                                <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                                    {{ substr($event->organizer->name ?? 'A', 0, 1) }}
                                </div>
                                <span>Hosted by <span class="font-semibold text-gray-700">{{ $event->organizer->name ?? 'Unknown' }}</span></span>
                            </div>
                            
                            <p class="text-gray-600 text-sm mb-6 flex-1 line-clamp-3">{{ $event->description }}</p>
                            
                            <div class="space-y-3 mb-6">
                                @if(!$event->is_online && $event->location)
                                    <div class="flex items-start gap-2 text-sm text-gray-600">
                                        <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span>{{ $event->location }}</span>
                                    </div>
                                @endif
                                
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    <span>{{ $event->registrations()->count() }} attendees</span>
                                </div>
                            </div>
                            
                            <div class="mt-auto pt-4 border-t border-gray-100">
                                <form action="{{ route('events.register', $event) }}" method="POST">
                                    @csrf
                                    @if($event->isRegisteredBy(auth()->user()))
                                        <button type="submit" class="w-full bg-green-50 text-green-700 hover:bg-red-50 hover:text-red-600 hover:border-red-200 border border-green-200 font-bold py-3 px-4 rounded-xl transition-colors group flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5 group-hover:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            <svg class="w-5 h-5 hidden group-hover:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            <span class="group-hover:hidden">Registered</span>
                                            <span class="hidden group-hover:block">Unregister</span>
                                        </button>
                                        @if($event->is_online && $event->meeting_link)
                                            <a href="{{ $event->meeting_link }}" target="_blank" class="w-full mt-2 block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl transition-colors shadow-sm">
                                                Join Meeting
                                            </a>
                                        @endif
                                    @else
                                        <button type="submit" class="w-full bg-white border-2 border-indigo-600 text-indigo-600 hover:bg-indigo-600 hover:text-white font-bold py-2.5 px-4 rounded-xl transition-colors">
                                            Register for Event
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 bg-white rounded-3xl border border-gray-100 text-center shadow-sm">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">No Upcoming Events</h3>
                        <p class="mt-2 text-gray-500">Check back later or host your own event!</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-8">
                {{ $events->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

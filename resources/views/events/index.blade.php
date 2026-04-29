<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Events & Meetups') }}
            </h2>
            @if(auth()->user()->role !== 'student')
            <button x-data="" x-on:click="$dispatch('open-modal', 'create-event')" class="bg-gray-900 text-white px-6 py-2.5 rounded-full font-bold shadow-lg hover:shadow-xl hover:bg-indigo-600 transform hover:-translate-y-0.5 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Create Event
            </button>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($events as $event)
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 border border-gray-100 flex flex-col group">
                    <div class="h-56 bg-indigo-100 relative overflow-hidden">
                        @if($event->cover_image)
                            <img src="{{ asset('storage/'.$event->cover_image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-indigo-500 to-purple-600 opacity-90 group-hover:scale-105 transition-transform duration-700"></div>
                        @endif
                        <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-sm px-4 py-1.5 rounded-full text-xs font-bold {{ $event->is_online ? 'text-blue-600' : 'text-purple-600' }} uppercase tracking-wider shadow-sm">
                            {{ $event->is_online ? 'Online Event' : 'In-Person' }}
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="text-sm font-bold text-indigo-600 mb-3 flex items-center gap-2 bg-indigo-50 w-max px-3 py-1 rounded-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $event->event_date->format('M d, Y • h:i A') }}
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 leading-tight group-hover:text-indigo-600 transition-colors">{{ $event->title }}</h3>
                        <p class="text-gray-500 text-sm mb-6 line-clamp-3 leading-relaxed">{{ $event->description }}</p>
                        
                        <div class="mt-auto pt-5 border-t border-gray-100 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-100 to-purple-100 text-indigo-700 flex items-center justify-center text-sm font-bold border border-indigo-200">
                                    {{ substr($event->organizer->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-medium">Organizer</p>
                                    <span class="text-sm font-bold text-gray-700">{{ $event->organizer->name }}</span>
                                </div>
                            </div>
                            <form action="/events/{{ $event->id }}/register" method="POST">
                                @csrf
                                @if($event->isRegisteredBy(auth()->user()))
                                    <button class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-4 py-2 rounded-xl text-sm font-bold transition-colors">Unregister</button>
                                @else
                                    <button class="bg-gray-900 text-white hover:bg-indigo-600 px-5 py-2 rounded-xl text-sm font-bold transition-colors shadow-md">Register</button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-12">
                {{ $events->links() }}
            </div>
        </div>
    </div>

    <!-- Create Event Modal -->
    <x-modal name="create-event" focusable>
        <form method="post" action="/events" class="p-8">
            @csrf
            <h2 class="text-2xl font-black text-gray-900 mb-6">Create New Event</h2>
            <div class="space-y-5">
                <div>
                    <x-input-label for="title" value="Event Title" class="font-bold" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full rounded-xl" required />
                </div>
                <div>
                    <x-input-label for="description" value="Description" class="font-bold" />
                    <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm" rows="4" required></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="event_date" value="Date & Time" class="font-bold" />
                        <x-text-input id="event_date" name="event_date" type="datetime-local" class="mt-1 block w-full rounded-xl" required />
                    </div>
                    <div>
                        <x-input-label for="is_online" value="Format" class="font-bold" />
                        <select id="is_online" name="is_online" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm">
                            <option value="0">In-Person</option>
                            <option value="1">Online</option>
                        </select>
                    </div>
                </div>
                <div>
                    <x-input-label for="location" value="Location / Meeting Link" class="font-bold" />
                    <x-text-input id="location" name="location" type="text" class="mt-1 block w-full rounded-xl" placeholder="Zoom link or Physical Address" />
                </div>
            </div>
            <div class="mt-8 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-colors">Cancel</button>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 transition-colors">Publish Event</button>
            </div>
        </form>
    </x-modal>
</x-app-layout>

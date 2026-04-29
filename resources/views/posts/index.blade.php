<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
            {{ __('Community Feed') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Create Post -->
            <div class="bg-white overflow-hidden shadow-xl shadow-indigo-100/50 sm:rounded-3xl border border-gray-100 p-6 transition-all hover:shadow-2xl hover:shadow-indigo-100 relative">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
                <form action="/posts" method="POST" enctype="multipart/form-data">
                    @csrf
                    <textarea name="content" rows="3" class="w-full border-0 focus:ring-0 text-lg resize-none placeholder-gray-400 bg-transparent" placeholder="What's on your mind, {{ auth()->user()->name }}?" required></textarea>
                    
                    <div class="mt-4 flex justify-between items-center border-t border-gray-100 pt-4">
                        <input type="file" name="image" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all cursor-pointer"/>
                        <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-8 py-2.5 rounded-full font-bold shadow-lg hover:shadow-xl hover:from-indigo-700 hover:to-purple-700 transform hover:-translate-y-0.5 transition-all">Post</button>
                    </div>
                </form>
            </div>

            <!-- Feed -->
            @foreach($posts as $post)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-gray-100 hover:shadow-xl hover:shadow-gray-200/50 transition-all duration-300">
                <div class="p-6 md:p-8">
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 text-white flex items-center justify-center font-bold text-lg shadow-inner ring-4 ring-indigo-50">
                                {{ substr($post->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">{{ $post->user->name }}</h3>
                                <p class="text-sm text-gray-500 font-medium">{{ $post->created_at->diffForHumans() }} • <span class="text-indigo-600">{{ ucfirst($post->user->role) }}</span></p>
                            </div>
                        </div>
                        @if($post->user_id === auth()->id())
                        <form action="/posts/{{ $post->id }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-full transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                        @endif
                    </div>
                    
                    <p class="text-gray-800 text-lg mb-6 leading-relaxed">{{ $post->content }}</p>
                    
                    @if($post->image)
                        <div class="rounded-2xl overflow-hidden mb-6 ring-1 ring-gray-100 shadow-sm">
                            <img src="{{ asset('storage/' . $post->image) }}" class="w-full object-cover max-h-[500px] hover:scale-105 transition-transform duration-700" />
                        </div>
                    @endif

                    <div class="flex items-center gap-8 border-t border-gray-100 pt-5">
                        <form action="/posts/{{ $post->id }}/like" method="POST">
                            @csrf
                            <button class="flex items-center gap-2.5 {{ $post->isLikedBy(auth()->user()) ? 'text-pink-600' : 'text-gray-500 hover:text-pink-600' }} font-bold text-sm transition-colors group">
                                <div class="p-2 rounded-full group-hover:bg-pink-50 transition-colors {{ $post->isLikedBy(auth()->user()) ? 'bg-pink-50' : '' }}">
                                    <svg class="w-6 h-6 {{ $post->isLikedBy(auth()->user()) ? 'fill-current scale-110' : 'fill-none' }} transition-transform" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                </div>
                                {{ $post->likes->count() }}
                            </button>
                        </form>
                        <div class="flex items-center gap-2.5 text-gray-500 font-bold text-sm cursor-pointer group hover:text-indigo-600 transition-colors">
                            <div class="p-2 rounded-full group-hover:bg-indigo-50 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            {{ $post->comments->count() }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

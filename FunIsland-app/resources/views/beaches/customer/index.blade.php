<x-tropical-layout title="Beach Events">
    <x-slot name="header">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">🏖️ Beach Paradise</h1>
            <p class="text-xl md:text-2xl text-white/90">Sun, sand, and unforgettable experiences</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($beachEvents as $event)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all transform hover:scale-105">
                    @if($event->image_url)
                        <img src="{{ $event->image_url }}" alt="{{ $event->name }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-green-400 flex items-center justify-center">
                            <span class="text-6xl">
                                @if($event->type == 'beach_event')
                                    🏖️
                                @elseif($event->type == 'activity')
                                    🚤
                                @else
                                    🎵
                                @endif
                            </span>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-xl font-bold text-gray-900">{{ $event->name }}</h3>
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                {{ $event->type_display }}
                            </span>
                        </div>
                        <p class="text-gray-600 mb-4">{{ Str::limit($event->description, 100) }}</p>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="w-4 h-4 mr-2">📍</span>
                                {{ $event->location }}
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="w-4 h-4 mr-2">📅</span>
                                {{ $event->start_time->format('M d, Y \a\t g:i A') }}
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="w-4 h-4 mr-2">💰</span>
                                ${{ number_format($event->price, 2) }} per person
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="w-4 h-4 mr-2">👥</span>
                                {{ $event->available_spots }} spots available
                            </div>
                        </div>

                        <div class="flex space-x-3">
                            <a href="{{ route('beaches.show', $event->id) }}" 
                               class="flex-1 bg-blue-600 text-white text-center py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                                View Details
                            </a>
                            
                            @auth
                                <form method="POST" action="{{ route('beaches.book') }}" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    <input type="hidden" name="participants" value="1">
                                    <button type="submit" 
                                            class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                                        Quick Book
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="flex-1 bg-gray-600 text-white text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition-colors">
                                    Login to Book
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="bg-white rounded-2xl shadow-xl p-12">
                        <div class="text-6xl mb-4">🏖️</div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">No beach events available</h3>
                        <p class="text-gray-600">Check back later for upcoming beach activities and events</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Call to Action -->
        <div class="text-center mt-12">
            <div class="bg-gradient-to-r from-blue-500 to-green-500 rounded-2xl p-8 text-white">
                <h2 class="text-3xl font-bold mb-4">Ready for Beach Adventures?</h2>
                <p class="text-xl mb-6">Join us for unforgettable experiences by the crystal-clear waters</p>
                <a href="{{ route('browse.beaches') }}" 
                   class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Explore All Events
                </a>
            </div>
        </div>
    </div>
</x-tropical-layout> 
</x-tropical-layout> 
<x-tropical-layout title="Island Events">
    <x-slot name="header">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">🎪 Island Events & Shows</h1>
            <p class="text-xl md:text-2xl text-white/90">Live entertainment and spectacular experiences</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search and Filter -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Find Your Perfect Event</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Event Type</label>
                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option>All Events</option>
                        <option>Concerts</option>
                        <option>Shows</option>
                        <option>Cultural</option>
                        <option>Sports</option>
                        <option>Festivals</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                    <input type="date" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option>Any Price</option>
                        <option>Free</option>
                        <option>Under $25</option>
                        <option>$25 - $50</option>
                        <option>$50+</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors">
                        Search Events
                    </button>
                </div>
            </div>
        </div>

        <!-- Featured Events -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">🌟 Featured Events</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gradient-to-r from-red-500 to-pink-500 rounded-2xl p-6 text-white">
                    <h3 class="text-xl font-bold mb-2">🎵 Paradise Music Festival</h3>
                    <p class="mb-4">3-day music festival featuring international artists</p>
                    <p class="text-sm opacity-90">March 15-17 • From $89</p>
                </div>
                <div class="bg-gradient-to-r from-blue-500 to-purple-500 rounded-2xl p-6 text-white">
                    <h3 class="text-xl font-bold mb-2">🎭 Cultural Night Show</h3>
                    <p class="mb-4">Traditional island performances and cuisine</p>
                    <p class="text-sm opacity-90">Every Saturday • $35</p>
                </div>
            </div>
        </div>

        <!-- Events Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($events as $event)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all transform hover:scale-105">
                    <div class="h-48 bg-gradient-to-br from-red-400 to-orange-600 flex items-center justify-center">
                        <span class="text-6xl">
                            @if($event->type === 'concert') 🎵
                            @elseif($event->type === 'show') 🎭
                            @elseif($event->type === 'cultural') 🎨
                            @elseif($event->type === 'sports') ⚽
                            @else 🎪
                            @endif
                        </span>
                    </div>
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $event->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ $event->description ?? 'Exciting entertainment event' }}</p>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="w-4 h-4 mr-2">📍</span>
                                {{ $event->venue ?? 'Paradise Theater' }}
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="w-4 h-4 mr-2">📅</span>
                                {{ $event->event_date ? $event->event_date->format('M d, Y') : 'TBD' }}
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="w-4 h-4 mr-2">⏰</span>
                                {{ $event->start_time ?? '8:00 PM' }} - {{ $event->end_time ?? '10:00 PM' }}
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="w-4 h-4 mr-2">🎫</span>
                                {{ $event->available_seats ?? 'Limited' }} seats available
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="w-4 h-4 mr-2">💰</span>
                                @if($event->price == 0)
                                    Free Event
                                @else
                                    From ${{ number_format($event->price ?? 25, 2) }} per ticket
                                @endif
                            </div>
                        </div>

                        <!-- Event Tags -->
                        <div class="flex flex-wrap gap-2 mb-4">
                            @if($event->is_featured ?? false)
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">⭐ Featured</span>
                            @endif
                            @if($event->age_restriction === 'family')
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">👨‍👩‍👧‍👦 Family Friendly</span>
                            @endif
                            @if($event->type)
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ ucfirst($event->type) }}</span>
                            @endif
                        </div>

                        <div class="space-y-3">
                            <a href="{{ route('events.show', $event->id) }}" 
                               class="block w-full bg-red-600 text-white text-center py-2 px-4 rounded-lg hover:bg-red-700 transition-colors">
                                View Details & Schedule
                            </a>
                            
                            <form method="POST" action="{{ route('events.book', $event->id) }}">
                                @csrf
                                <input type="hidden" name="tickets" value="1">
                                <button type="submit" 
                                        class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                                    @if($event->price == 0)
                                        Reserve Free Tickets
                                    @else
                                        Buy Tickets
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="bg-white rounded-2xl shadow-xl p-12">
                        <div class="text-6xl mb-4">🎪</div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">No events scheduled</h3>
                        <p class="text-gray-600">Check back later for exciting entertainment</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Upcoming Highlights -->
        <div class="mt-12">
            <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl p-8 text-white">
                <h2 class="text-3xl font-bold mb-4">This Week's Highlights</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white/10 rounded-lg p-4">
                        <h3 class="font-bold mb-2">🎤 Comedy Night</h3>
                        <p>Stand-up comedy show</p>
                        <p class="text-sm opacity-90">Friday 9 PM</p>
                    </div>
                    <div class="bg-white/10 rounded-lg p-4">
                        <h3 class="font-bold mb-2">🕺 Dance Workshop</h3>
                        <p>Learn traditional island dances</p>
                        <p class="text-sm opacity-90">Saturday 3 PM</p>
                    </div>
                    <div class="bg-white/10 rounded-lg p-4">
                        <h3 class="font-bold mb-2">🎨 Art Exhibition</h3>
                        <p>Local artists showcase</p>
                        <p class="text-sm opacity-90">All week</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tropical-layout> 
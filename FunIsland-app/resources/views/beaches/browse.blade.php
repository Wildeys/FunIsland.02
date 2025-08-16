<x-tropical-layout title="Browse Beach Events">
    <x-slot name="header">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">🏖️ Beach Events</h1>
            <p class="text-xl md:text-2xl text-white/90">Discover amazing beach activities and events</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Filter Section -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Find Your Perfect Beach Experience</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Event Type</label>
                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option>All Events</option>
                        <option>Sports</option>
                        <option>Wellness</option>
                        <option>Entertainment</option>
                        <option>Adventure</option>
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
                        <option>Under $20</option>
                        <option>$20 - $40</option>
                        <option>$40+</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                        Search
                    </button>
                </div>
            </div>
        </div>

        <!-- Events Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($beachEvents as $event)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all transform hover:scale-105">
                    <img src="{{ $event['image'] }}" alt="{{ $event['name'] }}" class="w-full h-48 object-cover">
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $event['name'] }}</h3>
                        <p class="text-gray-600 mb-4">{{ $event['description'] }}</p>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="w-4 h-4 mr-2">📍</span>
                                {{ $event['location'] }}
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="w-4 h-4 mr-2">📅</span>
                                {{ date('M d, Y', strtotime($event['date'])) }} at {{ $event['time'] }}
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="w-4 h-4 mr-2">💰</span>
                                ${{ number_format($event['price'], 2) }} per person
                            </div>
                        </div>

                        <div class="space-y-3">
                            <a href="{{ route('beaches.show', $event['id']) }}" 
                               class="block w-full bg-blue-600 text-white text-center py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                                View Details
                            </a>
                            
                            @auth
                                <form method="POST" action="{{ route('beaches.book') }}">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{ $event['id'] }}">
                                    <input type="hidden" name="participants" value="1">
                                    <button type="submit" 
                                            class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                                        Book Now
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="block w-full bg-green-600 text-white text-center py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                                    Login to Book
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Call to Action -->
        <div class="text-center mt-12">
            <div class="bg-gradient-to-r from-yellow-400 to-orange-500 rounded-2xl p-8 text-white">
                <h2 class="text-3xl font-bold mb-4">Create Your Beach Memories</h2>
                <p class="text-xl mb-6">Join thousands of guests who have experienced our amazing beach events</p>
                @auth
                    <a href="{{ route('beaches.customer.index') }}" 
                       class="bg-white text-orange-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                        View My Events
                    </a>
                @else
                    <a href="{{ route('register') }}" 
                       class="bg-white text-orange-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                        Join Fun Island
                    </a>
                @endauth
            </div>
        </div>
    </div>
</x-tropical-layout> 
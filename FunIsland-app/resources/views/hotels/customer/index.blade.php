<x-tropical-layout title="Hotels">
    <x-slot name="header">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">🏨 Paradise Hotels</h1>
            <p class="text-xl md:text-2xl text-white/90">Discover your perfect island getaway</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Search Section -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-12 -mt-20 relative z-10">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Find Your Perfect Stay</h2>
            
            <form method="GET" action="{{ route('hotels.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Check-in Date -->
                <div>
                    <label for="check_in" class="block text-sm font-medium text-gray-700 mb-2">Check-in</label>
                    <input type="date" 
                           name="check_in" 
                           id="check_in"
                           value="{{ request('check_in') }}"
                           class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Check-out Date -->
                <div>
                    <label for="check_out" class="block text-sm font-medium text-gray-700 mb-2">Check-out</label>
                    <input type="date" 
                           name="check_out" 
                           id="check_out"
                           value="{{ request('check_out') }}"
                           class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Guests -->
                <div>
                    <label for="guests" class="block text-sm font-medium text-gray-700 mb-2">Guests</label>
                    <select name="guests" 
                            id="guests"
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="1" {{ request('guests') == '1' ? 'selected' : '' }}>1 Guest</option>
                        <option value="2" {{ request('guests') == '2' ? 'selected' : '' }}>2 Guests</option>
                        <option value="3" {{ request('guests') == '3' ? 'selected' : '' }}>3 Guests</option>
                        <option value="4" {{ request('guests') == '4' ? 'selected' : '' }}>4 Guests</option>
                        <option value="5+" {{ request('guests') == '5+' ? 'selected' : '' }}>5+ Guests</option>
                    </select>
                </div>

                <!-- Search Button -->
                <div class="flex items-end">
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 transition-all transform hover:scale-105 shadow-lg">
                        🔍 Search Hotels
                    </button>
                </div>
            </form>
        </div>

        <!-- Filter Options -->
        <div class="flex flex-wrap items-center justify-between mb-8">
            <div class="flex items-center space-x-4 mb-4 lg:mb-0">
                <span class="text-lg font-semibold text-gray-700">Filter by:</span>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('hotels.index', array_merge(request()->all(), ['rating' => '5'])) }}" 
                       class="px-4 py-2 bg-white border border-gray-300 rounded-full text-sm font-medium {{ request('rating') == '5' ? 'bg-blue-50 border-blue-300 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }} transition-colors">
                        ⭐ 5 Stars
                    </a>
                    <a href="{{ route('hotels.index', array_merge(request()->all(), ['rating' => '4'])) }}" 
                       class="px-4 py-2 bg-white border border-gray-300 rounded-full text-sm font-medium {{ request('rating') == '4' ? 'bg-blue-50 border-blue-300 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }} transition-colors">
                        ⭐ 4+ Stars
                    </a>
                    <a href="{{ route('hotels.index', array_merge(request()->all(), ['type' => 'luxury'])) }}" 
                       class="px-4 py-2 bg-white border border-gray-300 rounded-full text-sm font-medium {{ request('type') == 'luxury' ? 'bg-blue-50 border-blue-300 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }} transition-colors">
                        💎 Luxury
                    </a>
                    <a href="{{ route('hotels.index', array_merge(request()->all(), ['amenity' => 'beach'])) }}" 
                       class="px-4 py-2 bg-white border border-gray-300 rounded-full text-sm font-medium {{ request('amenity') == 'beach' ? 'bg-blue-50 border-blue-300 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }} transition-colors">
                        🏖️ Beachfront
                    </a>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-600">{{ $hotels->total() }} hotels found</span>
                <select onchange="location.href=this.value" 
                        class="border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="{{ route('hotels.index', array_merge(request()->all(), ['sort' => 'name'])) }}" {{ request('sort') == 'name' ? 'selected' : '' }}>
                        Sort by Name
                    </option>
                    <option value="{{ route('hotels.index', array_merge(request()->all(), ['sort' => 'rating'])) }}" {{ request('sort') == 'rating' ? 'selected' : '' }}>
                        Sort by Rating
                    </option>
                    <option value="{{ route('hotels.index', array_merge(request()->all(), ['sort' => 'price'])) }}" {{ request('sort') == 'price' ? 'selected' : '' }}>
                        Sort by Price
                    </option>
                </select>
            </div>
        </div>

        <!-- Hotels Grid -->
        @if($hotels->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach($hotels as $hotel)
                <x-cards.hotel-card :hotel="$hotel" />
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $hotels->withQueryString()->links() }}
        </div>
        @else
        <div class="text-center py-16">
            <div class="max-w-md mx-auto">
                <div class="mb-8">
                    🏨
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">No hotels found</h3>
                <p class="text-gray-600 mb-8">
                    @if(request()->hasAny(['check_in', 'check_out', 'guests', 'rating', 'type', 'amenity']))
                        We couldn't find any hotels matching your criteria. Try adjusting your search filters.
                    @else
                        It looks like there are no hotels available right now. Please check back later!
                    @endif
                </p>
                <a href="{{ route('hotels.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 transition-all transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Clear Filters
                </a>
            </div>
        </div>
        @endif

        <!-- Why Choose Us Section -->
        <div class="bg-gradient-to-r from-blue-50 to-green-50 rounded-2xl p-8 mt-16">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose FunIsland Hotels?</h2>
                <p class="text-lg text-gray-600">Experience the ultimate island paradise with our exclusive amenities</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🏖️</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Beachfront Access</h3>
                    <p class="text-gray-600">Direct access to pristine beaches with crystal clear waters</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🎢</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Theme Park Access</h3>
                    <p class="text-gray-600">Exclusive access to world-class theme parks and attractions</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🚤</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Ferry Services</h3>
                    <p class="text-gray-600">Seamless transportation between islands and attractions</p>
                </div>
            </div>
        </div>
    </div>
</x-tropical-layout>
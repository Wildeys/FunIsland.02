<x-tropical-layout title="Theme Parks">
    <x-slot name="header">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">🎢 Theme Park Adventures</h1>
            <p class="text-xl md:text-2xl text-white/90">Thrills, excitement, and unforgettable memories await</p>
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
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Find Your Perfect Adventure</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Park Type</label>
                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option>All Parks</option>
                        <option>Water Parks</option>
                        <option>Adventure Parks</option>
                        <option>Family Parks</option>
                        <option>Thrill Parks</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Age Group</label>
                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option>All Ages</option>
                        <option>Kids (3-12)</option>
                        <option>Teens (13-17)</option>
                        <option>Adults (18+)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option>Any Price</option>
                        <option>Under $30</option>
                        <option>$30 - $60</option>
                        <option>$60+</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition-colors">
                        Search Parks
                    </button>
                </div>
            </div>
        </div>

        <!-- Theme Parks -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($themeparks as $park)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all transform hover:scale-105">
                    <div class="h-48 bg-gradient-to-br from-purple-400 to-pink-600 flex items-center justify-center">
                        <span class="text-6xl">🎢</span>
                    </div>
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $park->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ $park->description ?? 'Exciting theme park with thrilling rides and attractions' }}</p>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="w-4 h-4 mr-2">📍</span>
                                {{ $park->location ?? 'Paradise Island' }}
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="w-4 h-4 mr-2">🎠</span>
                                {{ $park->total_rides ?? '15+' }} rides & attractions
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="w-4 h-4 mr-2">⏰</span>
                                Open {{ $park->opening_hours ?? '9 AM - 10 PM' }}
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="w-4 h-4 mr-2">💰</span>
                                From ${{ number_format($park->adult_price ?? 45, 2) }} per adult
                            </div>
                        </div>

                        <!-- Park Features -->
                        <div class="flex flex-wrap gap-2 mb-4">
                            @if($park->has_water_rides ?? true)
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">💦 Water Rides</span>
                            @endif
                            @if($park->has_roller_coasters ?? true)
                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">🎢 Roller Coasters</span>
                            @endif
                            @if($park->family_friendly ?? true)
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">👨‍👩‍👧‍👦 Family Friendly</span>
                            @endif
                        </div>

                        <div class="space-y-3">
                            <a href="{{ route('themeparks.show', $park->id) }}" 
                               class="block w-full bg-purple-600 text-white text-center py-2 px-4 rounded-lg hover:bg-purple-700 transition-colors">
                                View Attractions & Details
                            </a>
                            
                            <form method="POST" action="{{ route('themeparks.book') }}">
                                @csrf
                                <input type="hidden" name="themepark_id" value="{{ $park->id }}">
                                <input type="hidden" name="tickets" value="1">
                                <button type="submit" 
                                        class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                                    Buy Tickets
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="bg-white rounded-2xl shadow-xl p-12">
                        <div class="text-6xl mb-4">🎢</div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">No theme parks available</h3>
                        <p class="text-gray-600">Check back later for exciting adventures</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Special Offers -->
        <div class="mt-12">
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl p-8 text-white">
                <h2 class="text-3xl font-bold mb-4">Special Park Packages</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white/10 rounded-lg p-4">
                        <h3 class="font-bold mb-2">🎟️ Family Pass</h3>
                        <p>2 adults + 2 kids combo</p>
                        <p class="text-sm opacity-90">Save 25%</p>
                    </div>
                    <div class="bg-white/10 rounded-lg p-4">
                        <h3 class="font-bold mb-2">🌟 VIP Experience</h3>
                        <p>Skip lines + premium access</p>
                        <p class="text-sm opacity-90">Ultimate fun</p>
                    </div>
                    <div class="bg-white/10 rounded-lg p-4">
                        <h3 class="font-bold mb-2">🎂 Birthday Special</h3>
                        <p>Free entry for birthday child</p>
                        <p class="text-sm opacity-90">Make it memorable</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tropical-layout> 
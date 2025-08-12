<x-tropical-layout title="Ferry Services">
    <x-slot name="header">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">🚤 Island Ferry Services</h1>
            <p class="text-xl md:text-2xl text-white/90">Hop between paradise islands with ease</p>
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
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Find Your Ferry Route</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">From</label>
                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option>Select departure</option>
                        <option>Main Island</option>
                        <option>Paradise Cove</option>
                        <option>Sunset Bay</option>
                        <option>Crystal Waters</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">To</label>
                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option>Select destination</option>
                        <option>Main Island</option>
                        <option>Paradise Cove</option>
                        <option>Sunset Bay</option>
                        <option>Crystal Waters</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                    <input type="date" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div class="flex items-end">
                    <button class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                        Search Routes
                    </button>
                </div>
            </div>
        </div>

        <!-- Ferry Services -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($ferries as $ferry)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all transform hover:scale-105">
                    <div class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                        <span class="text-6xl">🚤</span>
                    </div>
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $ferry->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ $ferry->description ?? 'Comfortable ferry service between islands' }}</p>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="w-4 h-4 mr-2">📍</span>
                                {{ $ferry->departure_location ?? 'Main Island' }} → {{ $ferry->arrival_location ?? 'Paradise Cove' }}
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="w-4 h-4 mr-2">⏰</span>
                                {{ $ferry->duration ?? '45 minutes' }} journey
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="w-4 h-4 mr-2">👥</span>
                                Up to {{ $ferry->capacity ?? 100 }} passengers
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="w-4 h-4 mr-2">💰</span>
                                From ${{ number_format($ferry->price ?? 25, 2) }} per person
                            </div>
                        </div>

                        <div class="space-y-3">
                            <a href="{{ route('ferries.show', $ferry->id) }}" 
                               class="block w-full bg-blue-600 text-white text-center py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                                View Schedule & Details
                            </a>
                            
                            <form method="POST" action="{{ route('ferries.book') }}">
                                @csrf
                                <input type="hidden" name="ferry_id" value="{{ $ferry->id }}">
                                <input type="hidden" name="passengers" value="1">
                                <button type="submit" 
                                        class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                                    Quick Book
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="bg-white rounded-2xl shadow-xl p-12">
                        <div class="text-6xl mb-4">🚤</div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">No ferry services available</h3>
                        <p class="text-gray-600">Check back later for available routes</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Popular Routes -->
        <div class="mt-12">
            <div class="bg-gradient-to-r from-blue-500 to-green-500 rounded-2xl p-8 text-white">
                <h2 class="text-3xl font-bold mb-4">Popular Ferry Routes</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white/10 rounded-lg p-4">
                        <h3 class="font-bold mb-2">🏝️ Island Hopper</h3>
                        <p>Visit 3 islands in one day</p>
                        <p class="text-sm opacity-90">From $45</p>
                    </div>
                    <div class="bg-white/10 rounded-lg p-4">
                        <h3 class="font-bold mb-2">🌅 Sunset Cruise</h3>
                        <p>Evening ferry with dinner</p>
                        <p class="text-sm opacity-90">From $65</p>
                    </div>
                    <div class="bg-white/10 rounded-lg p-4">
                        <h3 class="font-bold mb-2">🏖️ Beach Express</h3>
                        <p>Direct to beach destinations</p>
                        <p class="text-sm opacity-90">From $30</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tropical-layout> 
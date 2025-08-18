@extends('layouts.tropical')

@section('title', 'Browse Ferry Services - FunIsland')

@section('content')
    <!-- Hero Section -->
    <div class="tropical-gradient py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                🚤 Island Ferry Services
            </h1>
            <p class="text-xl md:text-2xl text-white/90 mb-8 max-w-3xl mx-auto">
                Navigate between islands in style with our premium ferry services. Enjoy scenic routes and comfortable journeys across crystal-clear waters.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" 
                   class="bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-4 px-8 rounded-full text-lg transition-all transform hover:scale-105 shadow-xl">
                    🎫 Sign Up to Book Tickets
                </a>
                <a href="{{ route('login') }}" 
                   class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white font-bold py-4 px-8 rounded-full text-lg transition-all border-2 border-white/30">
                    🏖️ Already a Member?
                </a>
            </div>
        </div>
    </div>

    <!-- Featured Routes Section -->
    @if($featuredRoutes->count() > 0)
    <div class="py-16 bg-gradient-to-br from-blue-50 via-white to-green-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    ⭐ Popular Ferry Routes
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Our most scenic and convenient routes connecting the beautiful islands of our archipelago.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($featuredRoutes as $ferry)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-all duration-300">
                    <div class="h-48 bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center relative">
                        <span class="text-8xl">🚤</span>
                        <div class="absolute top-2 right-2 bg-yellow-400 text-gray-800 px-2 py-1 rounded-full text-xs font-bold">
                            POPULAR
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $ferry->name }}</h3>
                        <div class="flex items-center text-gray-600 mb-3">
                            <span class="text-sm">🚢 {{ $ferry->departure_location ?? 'Main Port' }}</span>
                            <span class="mx-2">→</span>
                            <span class="text-sm">🏝️ {{ $ferry->arrival_location ?? 'Island Port' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                ⏱️ {{ $ferry->duration ?? '45 min' }} journey
                            </div>
                            <div class="text-lg font-bold text-teal-600">
                                From ${{ number_format($ferry->price ?? 25, 0) }}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- All Ferry Services Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    🌊 All Ferry Services
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Explore all available ferry routes and schedules to plan your perfect island hopping adventure.
                </p>
            </div>

            @if($ferries->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($ferries as $ferry)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100">
                        <div class="h-48 bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center">
                            <span class="text-6xl">🚤</span>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-3">{{ $ferry->name }}</h3>
                            
                            <!-- Route Information -->
                            <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex items-center">
                                        <span class="w-2 h-2 bg-teal-500 rounded-full mr-2"></span>
                                        <span class="font-medium">{{ $ferry->departure_location ?? 'Main Port' }}</span>
                                    </div>
                                    <div class="text-gray-400">
                                        ⏱️ {{ $ferry->duration ?? '45 min' }}
                                    </div>
                                    <div class="flex items-center">
                                        <span class="font-medium">{{ $ferry->arrival_location ?? 'Island Port' }}</span>
                                        <span class="w-2 h-2 bg-blue-500 rounded-full ml-2"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Schedule Information -->
                            <div class="mb-4">
                                <div class="text-sm text-gray-600 mb-2">Daily Departures:</div>
                                <div class="flex flex-wrap gap-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        🌅 9:00 AM
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        ☀️ 1:00 PM
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        🌅 5:00 PM
                                    </span>
                                </div>
                            </div>

                            <!-- Features -->
                            <div class="mb-4">
                                <div class="flex flex-wrap gap-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-teal-100 text-teal-800">
                                        ❄️ Air Conditioned
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        🍹 Refreshments
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        📶 WiFi
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between mb-4">
                                <div class="text-sm text-gray-500">
                                    👥 Capacity: {{ $ferry->capacity ?? 150 }} passengers
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-teal-600">
                                        ${{ number_format($ferry->price ?? 25, 0) }}
                                    </div>
                                    <div class="text-xs text-gray-500">per person</div>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-gray-100">
                                <div class="flex gap-2">
                                    <a href="{{ route('register') }}" 
                                       class="flex-1 bg-gradient-to-r from-teal-500 to-teal-600 text-white py-2 px-4 rounded-lg font-semibold hover:from-teal-600 hover:to-teal-700 transition-all text-center text-sm">
                                        Sign Up to Book
                                    </a>
                                    <button class="px-3 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                                        ℹ️
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $ferries->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">🚤</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Ferry Services Available</h3>
                    <p class="text-gray-600">Check back soon for new routes and schedules!</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Ferry Information Section -->
    <div class="py-16 bg-gradient-to-br from-teal-50 via-blue-50 to-green-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    🌊 Why Choose Our Ferry Services?
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🛥️</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Modern Fleet</h3>
                    <p class="text-gray-600">State-of-the-art vessels with safety equipment and comfortable seating.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🗓️</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Regular Schedule</h3>
                    <p class="text-gray-600">Multiple daily departures to fit your travel plans.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🌟</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Premium Service</h3>
                    <p class="text-gray-600">Enjoy complimentary refreshments and stunning ocean views.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="py-20 bg-gradient-to-r from-teal-600 via-blue-600 to-cyan-600">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                🚢 Ready for Your Island Adventure?
            </h2>
            <p class="text-xl text-white/90 mb-8">
                Experience the magic of island hopping with our comfortable and reliable ferry services. 
                Book your tickets today and start exploring paradise!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" 
                   class="bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-4 px-8 rounded-full text-lg transition-all transform hover:scale-105 shadow-xl">
                    🎫 Join FunIsland Today
                </a>
                <a href="{{ route('login') }}" 
                   class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white font-bold py-4 px-8 rounded-full text-lg transition-all border-2 border-white/30">
                    🏖️ Sign In
                </a>
            </div>
        </div>
    </div>
@endsection 
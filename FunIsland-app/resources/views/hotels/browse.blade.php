@extends('layouts.tropical')

@section('title', 'Browse Hotels - FunIsland')

@section('content')
    <!-- Hero Section -->
    <div class="tropical-gradient py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                🏨 Discover Paradise Hotels
            </h1>
            <p class="text-xl md:text-2xl text-white/90 mb-8 max-w-3xl mx-auto">
                Experience luxury accommodations with breathtaking ocean views, world-class amenities, and unforgettable island hospitality.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" 
                   class="bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-4 px-8 rounded-full text-lg transition-all transform hover:scale-105 shadow-xl">
                    🎫 Sign Up to Book Now
                </a>
                <a href="{{ route('login') }}" 
                   class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white font-bold py-4 px-8 rounded-full text-lg transition-all border-2 border-white/30">
                    🏖️ Already a Member?
                </a>
            </div>
        </div>
    </div>

    <!-- Featured Hotels Section -->
    @if($featuredHotels->count() > 0)
    <div class="py-16 bg-gradient-to-br from-blue-50 via-white to-green-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    ⭐ Featured Hotels
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Our handpicked selection of premium accommodations for the ultimate island experience.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($featuredHotels as $hotel)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-all duration-300">
                    <div class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center relative">
                        <span class="text-8xl">🏨</span>
                        <div class="absolute top-2 right-2 bg-yellow-400 text-gray-800 px-2 py-1 rounded-full text-xs font-bold">
                            FEATURED
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $hotel->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($hotel->description, 100) }}</p>
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                📍 {{ $hotel->location->name ?? 'FunIsland' }}
                            </div>
                            <div class="text-lg font-bold text-blue-600">
                                From ${{ number_format($hotel->price_per_night, 0) }}/night
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- All Hotels Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    🏖️ All Hotels & Resorts
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Browse our complete collection of luxury hotels, beach resorts, and boutique accommodations.
                </p>
            </div>

            @if($hotels->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($hotels as $hotel)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100">
                        <div class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                            <span class="text-6xl">🏨</span>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-3">
                                <h3 class="text-lg font-bold text-gray-800">{{ $hotel->name }}</h3>
                                <div class="flex text-yellow-400">
                                    @for($i = 0; $i < 5; $i++)
                                        ⭐
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-600 mb-4 text-sm">{{ Str::limit($hotel->description, 120) }}</p>
                            
                            <!-- Features -->
                            <div class="mb-4">
                                <div class="flex flex-wrap gap-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        🏊 Pool
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        🌊 Beach Access
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        🍽️ Restaurant
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-500">
                                    📍 {{ $hotel->location->name ?? 'FunIsland' }}
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-blue-600">
                                        ${{ number_format($hotel->price_per_night, 0) }}
                                    </div>
                                    <div class="text-xs text-gray-500">per night</div>
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <div class="flex gap-2">
                                    @auth
                                        <a href="{{ route('hotels.show', $hotel) }}" 
                                           class="flex-1 bg-gradient-to-r from-green-500 to-green-600 text-white py-2 px-4 rounded-lg font-semibold hover:from-green-600 hover:to-green-700 transition-all text-center text-sm">
                                            Book Now
                                        </a>
                                    @else
                                        <a href="{{ route('register') }}" 
                                           class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white py-2 px-4 rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 transition-all text-center text-sm">
                                            Sign Up to Book
                                        </a>
                                    @endauth
                                    <button class="px-3 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                                        ❤️
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $hotels->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">🏨</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Hotels Available</h3>
                    <p class="text-gray-600">Check back soon for new accommodations!</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Call to Action -->
    <div class="py-20 bg-gradient-to-r from-blue-600 via-purple-600 to-teal-600">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                🌟 Ready to Book Your Dream Stay?
            </h2>
            <p class="text-xl text-white/90 mb-8">
                Join thousands of travelers who have made FunIsland their favorite tropical destination. 
                Your perfect vacation is just a click away!
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
@extends('layouts.tropical')

@section('title', 'Browse Theme Parks - FunIsland')

@section('content')
    <!-- Hero Section -->
    <div class="tropical-gradient py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                🎢 Epic Theme Parks
            </h1>
            <p class="text-xl md:text-2xl text-white/90 mb-8 max-w-3xl mx-auto">
                Get your adrenaline pumping at our world-class theme parks! From thrilling roller coasters to family-friendly attractions, adventure awaits at every turn.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" 
                   class="bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-4 px-8 rounded-full text-lg transition-all transform hover:scale-105 shadow-xl">
                    🎫 Sign Up for Park Tickets
                </a>
                <a href="{{ route('login') }}" 
                   class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white font-bold py-4 px-8 rounded-full text-lg transition-all border-2 border-white/30">
                    🏖️ Already a Member?
                </a>
            </div>
        </div>
    </div>

    <!-- Featured Parks Section -->
    @if($featuredParks->count() > 0)
    <div class="py-16 bg-gradient-to-br from-purple-50 via-white to-pink-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    ⭐ Featured Theme Parks
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Our most popular parks featuring heart-pounding rides, magical experiences, and endless entertainment.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($featuredParks as $park)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-all duration-300">
                    <div class="h-48 bg-gradient-to-br from-purple-400 to-pink-600 flex items-center justify-center relative">
                        <span class="text-8xl">🎢</span>
                        <div class="absolute top-2 right-2 bg-yellow-400 text-gray-800 px-2 py-1 rounded-full text-xs font-bold">
                            FEATURED
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $park->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($park->description ?? 'Experience thrilling rides and magical attractions!', 80) }}</p>
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                🎠 {{ $park->total_attractions ?? '15+' }} Attractions
                            </div>
                            <div class="text-lg font-bold text-purple-600">
                                From ${{ number_format($park->admission_price ?? 45, 0) }}/day
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- All Theme Parks Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    🎠 All Theme Parks & Attractions
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Discover all our amazing theme parks, each offering unique thrills and unforgettable experiences for the whole family.
                </p>
            </div>

            @if($themeparks->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($themeparks as $park)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100">
                        <div class="h-48 bg-gradient-to-br from-purple-400 to-pink-600 flex items-center justify-center">
                            <span class="text-6xl">🎢</span>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-3">{{ $park->name }}</h3>
                            
                            <p class="text-gray-600 mb-4 text-sm">{{ Str::limit($park->description ?? 'Amazing attractions and thrilling rides await you!', 100) }}</p>

                            <!-- Park Statistics -->
                            <div class="mb-4 p-3 bg-purple-50 rounded-lg">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div class="text-center">
                                        <div class="font-bold text-purple-600">{{ $park->total_attractions ?? '15+' }}</div>
                                        <div class="text-gray-600">Attractions</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="font-bold text-purple-600">{{ $park->operating_hours ?? '10-8' }}</div>
                                        <div class="text-gray-600">Operating Hours</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Attraction Types -->
                            <div class="mb-4">
                                <div class="text-sm text-gray-600 mb-2">Popular Attractions:</div>
                                <div class="flex flex-wrap gap-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        🎢 Roller Coasters
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        🎠 Family Rides
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        🎪 Shows
                                    </span>
                                </div>
                            </div>

                            <!-- Features -->
                            <div class="mb-4">
                                <div class="flex flex-wrap gap-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        🍿 Food Courts
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        🛍️ Gift Shops
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                        📸 Photo Ops
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between mb-4">
                                <div class="text-sm text-gray-500">
                                    📍 {{ $park->location->name ?? 'FunIsland' }}
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-purple-600">
                                        ${{ number_format($park->admission_price ?? 45, 0) }}
                                    </div>
                                    <div class="text-xs text-gray-500">day pass</div>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-gray-100">
                                <div class="flex gap-2">
                                    <a href="{{ route('register') }}" 
                                       class="flex-1 bg-gradient-to-r from-purple-500 to-pink-600 text-white py-2 px-4 rounded-lg font-semibold hover:from-purple-600 hover:to-pink-700 transition-all text-center text-sm">
                                        Sign Up to Buy Tickets
                                    </a>
                                    <button class="px-3 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                                        🗺️
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $themeparks->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">🎢</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Theme Parks Available</h3>
                    <p class="text-gray-600">New exciting parks are coming soon!</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Park Categories Section -->
    <div class="py-16 bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    🎭 Something for Everyone
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🎢</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Thrill Seekers</h3>
                    <p class="text-gray-600">Heart-pounding roller coasters and extreme rides for adrenaline junkies.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">👨‍👩‍👧‍👦</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Family Fun</h3>
                    <p class="text-gray-600">Gentle rides and attractions perfect for families with children.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🎪</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Live Shows</h3>
                    <p class="text-gray-600">Spectacular performances, concerts, and entertainment shows.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🍿</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Dining & Shopping</h3>
                    <p class="text-gray-600">Delicious food courts and unique souvenir shops.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="py-20 bg-gradient-to-r from-purple-600 via-pink-600 to-red-600">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                🎠 Ready for the Ultimate Thrill?
            </h2>
            <p class="text-xl text-white/90 mb-8">
                Experience heart-pounding excitement, magical moments, and unforgettable memories at our world-class theme parks. 
                Your adventure of a lifetime awaits!
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
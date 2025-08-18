@extends('layouts.tropical')

@section('title', 'Browse Beach Events & Activities - FunIsland')

@section('content')
    <!-- Hero Section -->
    <div class="tropical-gradient py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                🏖️ Beach Events & Activities
            </h1>
            <p class="text-xl md:text-2xl text-white/90 mb-8 max-w-3xl mx-auto">
                Join exciting beach events, water activities, and island adventures! From sunset yoga to deep sea fishing, create unforgettable memories in paradise.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" 
                   class="bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-4 px-8 rounded-full text-lg transition-all transform hover:scale-105 shadow-xl">
                    🎫 Sign Up to Join Events
                </a>
                <a href="{{ route('login') }}" 
                   class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white font-bold py-4 px-8 rounded-full text-lg transition-all border-2 border-white/30">
                    🏖️ Already a Member?
                </a>
            </div>
        </div>
    </div>

    <!-- Featured Events Section -->
    @if($featuredEvents->count() > 0)
    <div class="py-16 bg-gradient-to-br from-orange-50 via-white to-cyan-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    ⭐ Featured Events This Week
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Don't miss these spectacular upcoming events and activities happening around the island.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($featuredEvents as $event)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-all duration-300">
                    <div class="h-48 bg-gradient-to-br from-orange-400 to-pink-600 flex items-center justify-center relative">
                        <span class="text-8xl">
                            @if($event->type === 'beach_event')
                                🏖️
                            @elseif($event->type === 'activity')
                                🚤
                            @else
                                🎭
                            @endif
                        </span>
                        <div class="absolute top-2 right-2 bg-yellow-400 text-gray-800 px-2 py-1 rounded-full text-xs font-bold">
                            {{ strtoupper($event->type_display) }}
                        </div>
                        <div class="absolute bottom-2 left-2 bg-black/50 text-white px-2 py-1 rounded text-xs">
                            {{ $event->start_time->format('M j, g:i A') }}
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $event->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($event->description, 100) }}</p>
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                📍 {{ $event->location }}
                            </div>
                            <div class="text-lg font-bold text-orange-600">
                                {{ $event->formatted_price }}
                            </div>
                        </div>
                        <div class="mt-2 text-xs text-gray-500">
                            ⏱️ {{ $event->duration }} • {{ $event->available_spots }} spots left
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- All Events Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    🌊 All Upcoming Events & Activities
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Explore our complete calendar of beach events, water activities, and island adventures.
                </p>
            </div>

            <!-- Event Categories Filter -->
            <div class="flex justify-center mb-8">
                <div class="inline-flex bg-gray-100 rounded-full p-1">
                    <button class="px-4 py-2 rounded-full text-sm font-medium bg-white text-gray-900 shadow-sm">All Events</button>
                    <button class="px-4 py-2 rounded-full text-sm font-medium text-gray-600 hover:text-gray-900">🏖️ Beach Events</button>
                    <button class="px-4 py-2 rounded-full text-sm font-medium text-gray-600 hover:text-gray-900">🚤 Activities</button>
                    <button class="px-4 py-2 rounded-full text-sm font-medium text-gray-600 hover:text-gray-900">🎭 Entertainment</button>
                </div>
            </div>

            @if($events->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($events as $event)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100">
                        <div class="h-48 bg-gradient-to-br from-orange-400 to-pink-600 flex items-center justify-center relative">
                            <span class="text-6xl">
                                @if($event->type === 'beach_event')
                                    🏖️
                                @elseif($event->type === 'activity')
                                    🚤
                                @else
                                    🎭
                                @endif
                            </span>
                            <div class="absolute top-2 right-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                    @if($event->type === 'beach_event') bg-blue-100 text-blue-800
                                    @elseif($event->type === 'activity') bg-green-100 text-green-800
                                    @else bg-purple-100 text-purple-800
                                    @endif">
                                    {{ $event->type_display }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-3">
                                <h3 class="text-lg font-bold text-gray-800">{{ $event->name }}</h3>
                                @if($event->difficulty_level)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $event->difficulty_level }}
                                    </span>
                                @endif
                            </div>
                            
                            <p class="text-gray-600 mb-4 text-sm">{{ Str::limit($event->description, 120) }}</p>

                            <!-- Event Details -->
                            <div class="mb-4 space-y-2">
                                <div class="flex items-center text-sm text-gray-600">
                                    <span class="w-4">📅</span>
                                    <span class="ml-2">{{ $event->start_time->format('M j, Y') }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <span class="w-4">⏰</span>
                                    <span class="ml-2">{{ $event->start_time->format('g:i A') }} - {{ $event->end_time->format('g:i A') }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <span class="w-4">⏱️</span>
                                    <span class="ml-2">{{ $event->duration }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <span class="w-4">📍</span>
                                    <span class="ml-2">{{ $event->location }}</span>
                                </div>
                            </div>

                            <!-- Features -->
                            @if($event->features)
                            <div class="mb-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach(array_slice($event->features, 0, 3) as $feature)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            {{ $feature }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Availability & Price -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="text-sm">
                                    <span class="text-gray-500">Available spots:</span>
                                    <span class="font-medium 
                                        @if($event->available_spots <= 5) text-red-600 
                                        @elseif($event->available_spots <= 10) text-orange-600 
                                        @else text-green-600 
                                        @endif">
                                        {{ $event->available_spots }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-orange-600">
                                        {{ $event->formatted_price }}
                                    </div>
                                    <div class="text-xs text-gray-500">per person</div>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-gray-100">
                                <div class="flex gap-2">
                                    <a href="{{ route('register') }}" 
                                       class="flex-1 bg-gradient-to-r from-orange-500 to-pink-600 text-white py-2 px-4 rounded-lg font-semibold hover:from-orange-600 hover:to-pink-700 transition-all text-center text-sm">
                                        Sign Up to Join
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
                    {{ $events->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">🏖️</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Events Available</h3>
                    <p class="text-gray-600">Check back soon for exciting new events and activities!</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Event Types Section -->
    <div class="py-16 bg-gradient-to-br from-orange-50 via-pink-50 to-cyan-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    🌈 Adventure Types
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🏖️</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Beach Events</h3>
                    <p class="text-gray-600">Yoga sessions, volleyball tournaments, beach parties, and sunset gatherings on pristine beaches.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🚤</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Water Activities</h3>
                    <p class="text-gray-600">Snorkeling, jet skiing, deep sea fishing, kayaking, and other exciting water adventures.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🎭</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Entertainment</h3>
                    <p class="text-gray-600">Cultural shows, live music, fire dancing, and festivals celebrating island traditions.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="py-20 bg-gradient-to-r from-orange-600 via-pink-600 to-cyan-600">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                🌅 Ready for Your Island Adventure?
            </h2>
            <p class="text-xl text-white/90 mb-8">
                From sunrise yoga to moonlight parties, create unforgettable memories with our amazing beach events and activities. 
                Join the fun and meet fellow adventurers!
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
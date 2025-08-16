@extends('layouts.tropical')

@section('content')
    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="tropical-gradient py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="relative z-10">
                    <h1 class="text-5xl md:text-7xl font-bold text-white mb-6">
                        Welcome to <span class="text-yellow-300">Fun</span><span class="text-blue-200">Island</span>
                    </h1>
                    <p class="text-xl md:text-2xl text-white/90 mb-8 max-w-3xl mx-auto">
                        🌴 Your Ultimate Island Paradise Awaits! Discover luxury hotels, scenic ferry rides, 
                        and thrilling theme parks all in one magical destination.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @guest
                            <a href="{{ route('register') }}" 
                               class="bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-4 px-8 rounded-full text-lg transition-all transform hover:scale-105 shadow-xl">
                                🎫 Start Your Adventure
                            </a>
                            <a href="{{ route('login') }}" 
                               class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white font-bold py-4 px-8 rounded-full text-lg transition-all border-2 border-white/30">
                                🏖️ Already a Member?
                            </a>
                        @else
                            <a href="{{ route('hotels.customer.index') }}" 
                               class="bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-4 px-8 rounded-full text-lg transition-all transform hover:scale-105 shadow-xl">
                                🏨 Explore Hotels
                            </a>
                            <a href="{{ route('bookings.my') }}" 
                               class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white font-bold py-4 px-8 rounded-full text-lg transition-all border-2 border-white/30">
                                📋 My Bookings
                            </a>
                        @endguest
                    </div>
                </div>
                
                <!-- Floating Elements -->
                <div class="absolute top-10 left-10 text-6xl opacity-30 animate-bounce" style="animation-duration: 3s;">🌺</div>
                <div class="absolute top-20 right-20 text-4xl opacity-20 animate-pulse" style="animation-duration: 4s;">🦋</div>
                <div class="absolute bottom-10 left-1/4 text-5xl opacity-25 animate-bounce" style="animation-duration: 3.5s;">🐚</div>
                <div class="absolute bottom-20 right-1/3 text-3xl opacity-30 animate-pulse" style="animation-duration: 2.5s;">⭐</div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-20 bg-gradient-to-br from-blue-50 via-white to-green-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                    🏝️ Discover FunIsland
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    From luxurious accommodations to thrilling adventures, we've got everything you need for the perfect tropical getaway.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Hotels Section -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-all duration-300 group">
                    <div class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                        <span class="text-8xl">🏨</span>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">very Luxury Hotels</h3>
                        <p class="text-gray-600 mb-6">
                            Experience world-class comfort in our handpicked selection of premium hotels. 
                            From beachfront resorts to boutique hideaways, find your perfect stay.
                        </p>
                        <ul class="text-sm text-gray-600 mb-6 space-y-2">
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Ocean view rooms</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> 5-star amenities</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Spa & wellness</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Fine dining</li>
                        </ul>
                        <a href="{{ route('browse.hotels') }}" 
                           class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 px-6 rounded-full font-semibold hover:from-blue-600 hover:to-blue-700 transition-all inline-block text-center group-hover:shadow-lg">
                            Browse Hotels →
                        </a>
                    </div>
                </div>

                <!-- Ferries Section -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-all duration-300 group">
                    <div class="h-48 bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center">
                        <span class="text-8xl">🚤</span>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Island Ferries</h3>
                        <p class="text-gray-600 mb-6">
                            Navigate between islands in style with our premium ferry services. 
                            Enjoy scenic routes and comfortable journeys across crystal-clear waters.
                        </p>
                        <ul class="text-sm text-gray-600 mb-6 space-y-2">
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Scenic routes</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Modern vessels</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Multiple departures</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Island hopping</li>
                        </ul>
                        <a href="{{ route('browse.ferries') }}" 
                           class="w-full bg-gradient-to-r from-teal-500 to-teal-600 text-white py-3 px-6 rounded-full font-semibold hover:from-teal-600 hover:to-teal-700 transition-all inline-block text-center group-hover:shadow-lg">
                            Browse Ferries →
                        </a>
                    </div>
                </div>

                <!-- Theme Parks Section -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-all duration-300 group">
                    <div class="h-48 bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                        <span class="text-8xl">🎢</span>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Theme Parks</h3>
                        <p class="text-gray-600 mb-6">
                            Get your adrenaline pumping at our world-class theme parks! 
                            From thrilling roller coasters to family-friendly attractions.
                        </p>
                        <ul class="text-sm text-gray-600 mb-6 space-y-2">
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Thrilling rides</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Family attractions</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Live shows</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Dining & shopping</li>
                        </ul>
                        <a href="{{ route('browse.themeparks') }}" 
                           class="w-full bg-gradient-to-r from-purple-500 to-purple-600 text-white py-3 px-6 rounded-full font-semibold hover:from-purple-600 hover:to-purple-700 transition-all inline-block text-center group-hover:shadow-lg">
                            Browse Theme Parks →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Beach Events Section -->
            <div class="mt-16">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-all duration-300 group">
                    <div class="h-48 bg-gradient-to-br from-orange-400 to-pink-600 flex items-center justify-center">
                        <span class="text-8xl">🏖️</span>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Beach Events & Activities</h3>
                        <p class="text-gray-600 mb-6">
                            Join exciting beach events, water activities, and island adventures! 
                            From sunrise yoga to moonlight parties, create unforgettable memories in paradise.
                        </p>
                        <ul class="text-sm text-gray-600 mb-6 space-y-2">
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Beach yoga & fitness</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Water sports & diving</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Cultural shows & festivals</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Adventure tours</li>
                        </ul>
                        <a href="{{ route('browse.events') }}" 
                           class="w-full bg-gradient-to-r from-orange-500 to-pink-600 text-white py-3 px-6 rounded-full font-semibold hover:from-orange-600 hover:to-pink-700 transition-all inline-block text-center group-hover:shadow-lg">
                            Browse Events →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Interactive Map Preview -->
            <div class="mt-20">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="p-8 border-b border-gray-100">
                        <div class="text-center">
                            <h3 class="text-3xl font-bold text-gray-800 mb-4">🗺️ Explore FunIsland</h3>
                            <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-6">
                                Discover all our amazing locations on this interactive map. Click on markers to see hotels, ferries, and theme parks at each location.
                            </p>
                            <a href="{{ route('locations.map') }}" 
                               class="inline-flex items-center bg-gradient-to-r from-blue-500 to-teal-600 text-white px-6 py-3 rounded-full font-semibold hover:from-blue-600 hover:to-teal-700 transition-all">
                                <span class="mr-2">🗺️</span>
                                View Full Interactive Map
                            </a>
                        </div>
                    </div>
                    <div class="relative">
                        <!-- Mini Map Container -->
                        <div id="mini-map" style="height: 400px; width: 100%;"></div>
                        
                        <!-- Overlay for click-through to full map -->
                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity cursor-pointer" 
                             onclick="window.location.href='{{ route('locations.map') }}'">
                            <div class="bg-white/90 backdrop-blur-sm rounded-xl px-6 py-3 text-gray-800 font-semibold">
                                🗺️ View Full Map
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet CSS for Mini Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
          crossorigin=""/>

    <!-- Stats Section -->
    <div class="py-16 beach-gradient">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center text-white">
                <div class="transform hover:scale-105 transition-all">
                    <div class="text-4xl md:text-5xl font-bold mb-2">50+</div>
                    <div class="text-lg opacity-90">Luxury Hotels</div>
                </div>
                <div class="transform hover:scale-105 transition-all">
                    <div class="text-4xl md:text-5xl font-bold mb-2">25+</div>
                    <div class="text-lg opacity-90">Ferry Routes</div>
                </div>
                <div class="transform hover:scale-105 transition-all">
                    <div class="text-4xl md:text-5xl font-bold mb-2">15+</div>
                    <div class="text-lg opacity-90">Theme Parks</div>
                </div>
                <div class="transform hover:scale-105 transition-all">
                    <div class="text-4xl md:text-5xl font-bold mb-2">100+</div>
                    <div class="text-lg opacity-90">Beach Events</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action Section -->
    <div class="py-20 bg-gradient-to-r from-blue-600 via-purple-600 to-teal-600">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                🌟 Ready for Your Island Adventure?
            </h2>
            <p class="text-xl text-white/90 mb-8">
                Join thousands of travelers who have made FunIsland their favorite tropical destination. 
                Your perfect vacation is just a click away!
            </p>
            @guest
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
            @else
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('hotels.customer.index') }}" 
                       class="bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-4 px-8 rounded-full text-lg transition-all transform hover:scale-105 shadow-xl">
                        🏨 Book Your Stay
                    </a>
                    <a href="{{ route('bookings.my') }}" 
                       class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white font-bold py-4 px-8 rounded-full text-lg transition-all border-2 border-white/30">
                        📋 View My Bookings
                    </a>
                </div>
            @endguest
        </div>
    </div>

    <!-- Leaflet JavaScript for Mini Map -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" 
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" 
            crossorigin=""></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize mini map
        const miniMap = L.map('mini-map', {
            zoomControl: false,
            scrollWheelZoom: false,
            doubleClickZoom: false,
            dragging: false,
            attributionControl: false
        }).setView([3.94028, 73.48889], 13);

        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(miniMap);

        // Maafushi Island location data (static for welcome page)
        const sampleLocations = [
            {
                name: 'Maafushi Island',
                lat: 3.94028,
                lng: 73.48889,
                services: ['hotels', 'themeparks']
            },
            {
                name: 'Bikini Beach',
                lat: 3.94100,
                lng: 73.48900,
                services: ['hotels', 'themeparks']
            },
            {
                name: 'Water Sports Center',
                lat: 3.93950,
                lng: 73.48850,
                services: ['ferries', 'themeparks']
            },
            {
                name: 'Maafushi Harbor',
                lat: 3.93980,
                lng: 73.48870,
                services: ['ferries', 'hotels']
            },
            {
                name: 'Coral Reef Point',
                lat: 3.94150,
                lng: 73.48950,
                services: ['hotels', 'themeparks']
            },
            {
                name: 'Adventure Bay',
                lat: 3.93900,
                lng: 73.48800,
                services: ['ferries', 'themeparks']
            }
        ];

        // Create custom icons
        const createMiniIcon = (services) => {
            let color = '#3b82f6';
            if (services.length > 1) {
                color = 'linear-gradient(45deg, #f59e0b 33%, #3b82f6 33%, #3b82f6 66%, #10b981 66%)';
            } else if (services.includes('hotels')) {
                color = '#f59e0b';
            } else if (services.includes('ferries')) {
                color = '#3b82f6';
            } else if (services.includes('themeparks')) {
                color = '#10b981';
            }
            
            return L.divIcon({
                className: 'custom-mini-marker',
                iconSize: [16, 16],
                iconAnchor: [8, 8],
                html: `<div style="background: ${color}; width: 100%; height: 100%; border-radius: 50%; border: 2px solid white; box-shadow: 0 1px 3px rgba(0,0,0,0.3);"></div>`
            });
        };

        // Add markers
        sampleLocations.forEach(location => {
            const serviceIcons = {
                hotels: '🏨',
                ferries: '⛴️',
                themeparks: '🎢'
            };
            
            const serviceList = location.services.map(service => serviceIcons[service]).join(' ');
            
            L.marker([location.lat, location.lng], {
                icon: createMiniIcon(location.services)
            })
            .bindPopup(`
                <div style="text-align: center; font-size: 12px;">
                    <strong>${location.name}</strong><br>
                    <span style="font-size: 14px;">${serviceList}</span>
                </div>
            `)
            .addTo(miniMap);
        });

        // Fit bounds to show all markers
        const group = new L.featureGroup(sampleLocations.map(loc => 
            L.marker([loc.lat, loc.lng])
        ));
        miniMap.fitBounds(group.getBounds().pad(0.1));
    });
    </script>
@endsection

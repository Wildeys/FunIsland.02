@if(auth()->user()->hasRole('customer'))
    <!-- Customer Dashboard -->
    <x-tropical-layout title="Dashboard">
        <x-slot name="header">
            <div class="text-center text-white">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">🌴 Welcome to Paradise!</h1>
                <p class="text-xl md:text-2xl text-white/90">Hello {{ auth()->user()->name }}, ready for your island adventure?</p>
            </div>
        </x-slot>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12 -mt-20 relative z-10">
                <a href="{{ route('hotels.customer.index') }}" 
                   class="bg-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all transform hover:scale-105">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">🏨</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Book Hotels</h3>
                        <p class="text-gray-600">Find your perfect island retreat</p>
                    </div>
                </a>

                <a href="{{ route('ferries.customer.index') }}" 
                   class="bg-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all transform hover:scale-105">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">🚤</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Ferry Tickets</h3>
                        <p class="text-gray-600">Island hopping made easy</p>
                    </div>
                </a>

                <a href="{{ route('themeparks.customer.index') }}" 
                   class="bg-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all transform hover:scale-105">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">🎢</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Theme Parks</h3>
                        <p class="text-gray-600">Thrilling adventures await</p>
                    </div>
                </a>

                <a href="{{ route('beaches.customer.index') }}" 
                   class="bg-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all transform hover:scale-105">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">🏖️</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Beach Events</h3>
                        <p class="text-gray-600">Sun, sand, and fun activities</p>
                    </div>
                </a>
            </div>

            <!-- Interactive Map Button -->
            <div class="flex justify-center mb-12">
                <a href="{{ route('locations.map') }}" 
                   class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-all transform hover:scale-105 max-w-md">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-4xl">🗺️</span>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3">Explore Island Map</h3>
                        <p class="text-white/90 mb-4">Discover all locations, hotels, ferries, and theme parks on our interactive map</p>
                        <div class="flex items-center justify-center space-x-2 text-sm text-white/80">
                            <span>🏨 Hotels</span>
                            <span>•</span>
                            <span>⛴️ Ferries</span>
                            <span>•</span>
                            <span>🎢 Parks</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- My Bookings -->
            <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">My Recent Bookings</h2>
                    <a href="{{ route('bookings.my') }}" 
                       class="text-blue-600 hover:text-blue-700 font-medium">View All</a>
                </div>
                
                <div class="text-center py-8">
                    <div class="text-6xl mb-4">📅</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No bookings yet</h3>
                    <p class="text-gray-600 mb-6">Start planning your perfect island getaway!</p>
                    <a href="{{ route('hotels.customer.index') }}" 
                       class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 transition-all">
                        Book Now
                    </a>
                </div>
            </div>
        </div>
    </x-tropical-layout>

@elseif(auth()->user()->isAdministrator())
    <!-- Redirect to Admin Dashboard -->
    @php
        header('Location: ' . route('admin.overview'));
        exit();
    @endphp

@elseif(auth()->user()->canManageHotels())
    <!-- Redirect to Hotel Dashboard -->
    @php
        header('Location: ' . route('hotels.dashboard'));
        exit();
    @endphp

@elseif(auth()->user()->canManageFerries())
    <!-- Redirect to Ferry Dashboard -->
    @php
        header('Location: ' . route('ferries.dashboard'));
        exit();
    @endphp

@elseif(auth()->user()->canManageThemeParks())
    <!-- Redirect to Theme Park Dashboard -->
    @php
        header('Location: ' . route('themeparks.dashboard'));
        exit();
    @endphp
@elseif(auth()->user()->isHotelStaff()) 
    @php
        header('Location: ' . route('bookings.staff'));
        exit();
    @endphp
@else
    <!-- Default Dashboard -->
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {{ __("Welcome to FunIsland!") }}
                        <p class="mt-2">You're logged in as {{ auth()->user()->role->display_name ?? 'User' }}.</p>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
@endif
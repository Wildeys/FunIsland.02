@php
    // Default to 'guest' layout if not specified or user is not authenticated
    $layout = $layout ?? (auth()->check() && (auth()->user()->hasRole('theme_park_manager') || auth()->user()->hasRole('administrator')) ? 'management' : 'guest');
@endphp

@if($layout === 'guest')
    <x-guest-layout>
        <!-- Guest Header -->
        <div class="tropical-gradient text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold mb-4">Explore FunIsland</h1>
                    <p class="text-xl opacity-90">Discover amazing locations and book your perfect getaway</p>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @include('locations.map-content')
        </div>
    </x-guest-layout>
@elseif($layout === 'management')
    <x-management-layout>
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">FunIsland Interactive Map</h1>
                    <p class="text-sm text-gray-600">Explore locations and book services</p>
                </div>
                <div class="flex items-center space-x-3">
                    <button id="reset-view" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        Reset View
                    </button>
                </div>
            </div>
        </x-slot>
        @include('locations.map-content')
    </x-management-layout>
@else
    <x-app-layout>
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">FunIsland Interactive Map</h1>
                    <p class="text-sm text-gray-600">Explore locations and book services</p>
                </div>
                <div class="flex items-center space-x-3">
                    <button id="reset-view" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        Reset View
                    </button>
                </div>
            </div>
        </x-slot>
        @include('locations.map-content')
    </x-app-layout>
@endif
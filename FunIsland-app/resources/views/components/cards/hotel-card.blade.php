@props([
    'hotel',
    'showBookButton' => true,
    'showManageButton' => false
])

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <!-- Hotel Image -->
    <div class="h-48 bg-gradient-to-r from-blue-400 to-blue-600 relative">
        <div class="flex items-center justify-center h-full">
            <span class="text-6xl">🏨</span>
        </div>
        
        <!-- Rating Badge -->
        @if($hotel->rating)
        <div class="absolute top-4 right-4 bg-white rounded-full px-2 py-1 shadow-md">
            <div class="flex items-center space-x-1">
                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                <span class="text-sm font-medium text-gray-900">{{ number_format($hotel->rating, 1) }}</span>
            </div>
        </div>
        @endif
    </div>

    <!-- Hotel Info -->
    <div class="p-6">
        <div class="flex justify-between items-start mb-2">
            <h3 class="text-lg font-semibold text-gray-900">{{ $hotel->name }}</h3>
            @if($hotel->location)
            <span class="text-sm text-gray-500">📍 {{ $hotel->location->location_name }}</span>
            @endif
        </div>
        
        <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $hotel->description }}</p>
        
        <!-- Hotel Features -->
        <div class="flex items-center space-x-4 mb-4 text-sm text-gray-500">
            @if($hotel->rooms_count ?? 0 > 0)
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                </svg>
                {{ $hotel->rooms_count }} rooms
            </span>
            @endif
            
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10v11M20 10v11"></path>
                </svg>
                Resort
            </span>
        </div>

        <!-- Action Buttons -->
        <div class="flex space-x-2">
            @if($showBookButton)
            <a href="{{ route('hotels.show', $hotel) }}" 
               class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:from-blue-600 hover:to-blue-700 transition-all transform hover:scale-105 text-center">
                Book Now
            </a>
            @endif
            
            @if($showManageButton)
            <a href="{{ route('hotels.edit', $hotel) }}" 
               class="flex-1 bg-gray-100 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-200 transition-colors text-center">
                Manage
            </a>
            @endif
            
            <a href="{{ route('hotels.show', $hotel) }}" 
               class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-200 transition-colors">
                Details
            </a>
        </div>
    </div>
</div>
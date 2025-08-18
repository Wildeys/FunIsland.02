<x-management-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $hotel->name }}</h1>
                <p class="text-sm text-gray-600">{{ $hotel->location->name ?? 'Unknown Location' }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('hotels.management.edit', $hotel) }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                    Edit Hotel
                </a>
                <a href="{{ route('hotels.management.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                    Back to Hotels
                </a>
            </div>
        </div>
    </x-slot>

    <div class="p-6">
        <div class="max-w-7xl mx-auto space-y-6">
            
            <!-- Hotel Overview -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Hotel Overview</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Hotel Image -->
                        <div class="lg:col-span-1">
                            <div class="w-full h-64 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                                <span class="text-6xl">🏨</span>
                            </div>
                        </div>
                        
                        <!-- Hotel Details -->
                        <div class="lg:col-span-2 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Status -->
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $hotel->status === 'active' ? 'bg-green-100 text-green-800' : 
                                               ($hotel->status === 'maintenance' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($hotel->status) }}
                                        </span>
                                        @if($hotel->featured)
                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                Featured
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                                
                                <!-- Price -->
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Price per Night</dt>
                                    <dd class="mt-1 text-sm text-gray-900">${{ number_format($hotel->price_per_night, 2) }}</dd>
                                </div>
                                
                                <!-- Location -->
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Location</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $hotel->location->name ?? 'Not specified' }}</dd>
                                </div>
                                
                                <!-- Total Rooms -->
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Total Rooms</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $hotel->rooms->count() }} rooms</dd>
                                </div>
                            </div>
                            
                            <!-- Description -->
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Description</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $hotel->description }}</dd>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            @if($hotel->contact_info)
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Contact Information</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @if(!empty($hotel->contact_info['phone']))
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <a href="tel:{{ $hotel->contact_info['phone'] }}" class="text-indigo-600 hover:text-indigo-900">
                                        {{ $hotel->contact_info['phone'] }}
                                    </a>
                                </dd>
                            </div>
                        @endif
                        
                        @if(!empty($hotel->contact_info['email']))
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <a href="mailto:{{ $hotel->contact_info['email'] }}" class="text-indigo-600 hover:text-indigo-900">
                                        {{ $hotel->contact_info['email'] }}
                                    </a>
                                </dd>
                            </div>
                        @endif
                        
                        @if(!empty($hotel->contact_info['website']))
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Website</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <a href="{{ $hotel->contact_info['website'] }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                                        Visit Website
                                    </a>
                                </dd>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Amenities -->
            @if($hotel->amenities && count($hotel->amenities) > 0)
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Amenities</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach($hotel->amenities as $amenity)
                            <div class="flex items-center">
                                <svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-gray-900">{{ $amenity }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Rooms Management -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Hotel Rooms</h3>
                    <a href="#" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        Add Room
                    </a>
                </div>
                <div class="p-6">
                    @if($hotel->rooms->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($hotel->rooms as $room)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="text-sm font-medium text-gray-900">Room {{ $room->room_number }}</h4>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            {{ $room->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($room->status) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600">{{ $room->room_type }}</p>
                                    <p class="text-sm text-gray-600">Capacity: {{ $room->capacity }} guests</p>
                                    <p class="text-sm text-gray-900 font-medium">${{ number_format($room->price_per_night, 2) }}/night</p>
                                    <div class="mt-3 flex space-x-2">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900 text-xs">Edit</a>
                                        <a href="#" class="text-red-600 hover:text-red-900 text-xs">Delete</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No rooms configured</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by adding a room to this hotel.</p>
                            <div class="mt-6">
                                <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    Add First Room
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Rooms</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $hotel->rooms->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Available Rooms</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $hotel->rooms->where('status', 'available')->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Avg. Room Price</p>
                            <p class="text-2xl font-semibold text-gray-900">
                                ${{ $hotel->rooms->count() > 0 ? number_format($hotel->rooms->avg('price_per_night'), 2) : '0.00' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Bookings</p>
                            <p class="text-2xl font-semibold text-gray-900">0</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-management-layout>

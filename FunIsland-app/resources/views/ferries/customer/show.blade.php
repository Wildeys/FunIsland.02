<x-tropical-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-teal-50 to-green-50">
        <div class="container mx-auto px-4 py-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('ferries.customer.index') }}" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Ferry Services
                </a>
            </div>

            <!-- Ferry Header -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-blue-600 to-teal-600 p-8 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-4xl font-bold mb-2">{{ $ferry->name }}</h1>
                            <div class="flex items-center space-x-4 text-blue-100">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Based at {{ $ferry->location->location_name }}
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                                    </svg>
                                    Capacity: {{ $ferry->capacity }} passengers
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold">🚤</div>
                            <div class="mt-2">
                                @if($ferry->status === 'active')
                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        ✅ Active Service
                                    </span>
                                @else
                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                        ❌ {{ ucfirst($ferry->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ferry Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-gray-200">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $ferry->schedules->count() }}</div>
                        <div class="text-sm text-gray-600">Available Schedules</div>
                    </div>
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $ferry->schedules->where('is_available', true)->count() }}</div>
                        <div class="text-sm text-gray-600">Bookable Routes</div>
                    </div>
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-purple-600">${{ $ferry->schedules->min('price') ?? '0' }} - ${{ $ferry->schedules->max('price') ?? '0' }}</div>
                        <div class="text-sm text-gray-600">Price Range</div>
                    </div>
                </div>
            </div>

            <!-- Schedules Section -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-teal-500 to-blue-500 p-6 text-white">
                    <h2 class="text-2xl font-bold flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Available Schedules & Routes
                    </h2>
                    <p class="text-teal-100 mt-2">Choose your departure time and destination</p>
                </div>

                <div class="p-6">
                    @if($ferry->schedules->count() > 0)
                        @php
                            $groupedSchedules = $ferry->schedules->groupBy(function($schedule) {
                                return \Carbon\Carbon::parse($schedule->date)->format('Y-m-d');
                            });
                        @endphp

                        <div class="space-y-8">
                            @foreach($groupedSchedules as $date => $daySchedules)
                                <div class="border border-gray-200 rounded-xl overflow-hidden">
                                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m0 0V9a2 2 0 11-18 0 2 2 0 0118 0z"></path>
                                            </svg>
                                            {{ \Carbon\Carbon::parse($date)->format('l, F d, Y') }}
                                            <span class="ml-3 px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                                {{ $daySchedules->count() }} departures
                                            </span>
                                        </h3>
                                    </div>

                                    <div class="divide-y divide-gray-200">
                                        @foreach($daySchedules as $schedule)
                                            <div class="p-6 hover:bg-gray-50 transition-colors">
                                                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                                                    <!-- Route Info -->
                                                    <div class="flex-1">
                                                        <div class="flex items-center space-x-4 mb-3">
                                                            <div class="flex items-center text-gray-900">
                                                                <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                                                </svg>
                                                                <span class="font-medium">{{ $schedule->departureLocation->location_name }}</span>
                                                            </div>
                                                            
                                                            <div class="flex items-center text-gray-400">
                                                                <svg class="w-8 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                                                </svg>
                                                            </div>
                                                            
                                                            <div class="flex items-center text-gray-900">
                                                                <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                                                </svg>
                                                                <span class="font-medium">{{ $schedule->arrivalLocation->location_name }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="flex items-center space-x-6 text-sm text-gray-600">
                                                            <div class="flex items-center">
                                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                </svg>
                                                                <span class="font-medium">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('g:i A') }}</span>
                                                            </div>
                                                            
                                                            <div class="flex items-center">
                                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                                </svg>
                                                                <span>{{ $schedule->remaining_seats }} seats available</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Price & Action -->
                                                    <div class="flex items-center space-x-4">
                                                        <div class="text-right">
                                                            <div class="text-2xl font-bold text-green-600">${{ number_format($schedule->price, 2) }}</div>
                                                            <div class="text-sm text-gray-500">per person</div>
                                                        </div>

                                                        <div class="flex flex-col space-y-2">
                                                            @if($schedule->is_available && $schedule->remaining_seats > 0)
                                                                @auth
                                                                    <form method="POST" action="{{ route('ferries.book') }}">
                                                                        @csrf
                                                                        <input type="hidden" name="ferry_id" value="{{ $ferry->id }}">
                                                                        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                                                        <input type="hidden" name="passengers" value="1">
                                                                        <button type="submit" 
                                                                                class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors font-medium">
                                                                            Book Now
                                                                        </button>
                                                                    </form>
                                                                @else
                                                                    <a href="{{ route('login') }}" 
                                                                       class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium text-center">
                                                                        Login to Book
                                                                    </a>
                                                                @endauth
                                                            @elseif($schedule->remaining_seats <= 0)
                                                                <button disabled 
                                                                        class="bg-gray-400 text-white px-6 py-2 rounded-lg cursor-not-allowed font-medium">
                                                                    Fully Booked
                                                                </button>
                                                            @else
                                                                <button disabled 
                                                                        class="bg-red-400 text-white px-6 py-2 rounded-lg cursor-not-allowed font-medium">
                                                                    Not Available
                                                                </button>
                                                            @endif

                                                            <div class="text-center">
                                                                @if($schedule->is_available)
                                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                                        Available
                                                                    </span>
                                                                @else
                                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                                        Unavailable
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- No Schedules Available -->
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">📅</div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">No Schedules Available</h3>
                            <p class="text-gray-600 mb-6">This ferry currently has no upcoming schedules. Please check back later or contact our customer service.</p>
                            <a href="{{ route('ferries.customer.index') }}" 
                               class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Browse Other Ferries
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-8 bg-blue-50 rounded-2xl p-6">
                <div class="text-center">
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Need Help with Your Booking?</h3>
                    <p class="text-blue-700 mb-4">Our customer service team is here to assist you with any questions about ferry schedules, routes, or bookings.</p>
                    <div class="flex justify-center space-x-4">
                        <a href="tel:+960-123-4567" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            Call Us
                        </a>
                        <a href="mailto:support@funisland.com" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 7.89a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Email Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tropical-layout> 
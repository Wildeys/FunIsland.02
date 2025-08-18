<x-management-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-900">Hotel Management Dashboard</h1>
    </x-slot>

    <div class="p-6">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Hotels -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Hotels</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $totalHotels }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Bookings -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Bookings</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $totalBookings }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- This Month -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">This Month</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $thisMonthBookings }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Revenue</dt>
                                <dd class="text-lg font-medium text-gray-900">${{ number_format($totalRevenue, 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white shadow-sm rounded-lg mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('hotels.management.create') }}" 
                       class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-900">Add New Hotel</h4>
                            <p class="text-sm text-gray-500">Create a new hotel property</p>
                        </div>
                    </a>

                    <a href="{{ route('hotels.management.index') }}" 
                       class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-900">Manage Hotels</h4>
                            <p class="text-sm text-gray-500">View and edit hotel details</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.bookings') }}" 
                       class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-900">Manage Bookings</h4>
                            <p class="text-sm text-gray-500">View and edit hotel bookings</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Bookings -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Recent Bookings</h3>
                </div>
                <div class="p-6">
                    @if(count($recentBookings) > 0)
                        <div class="flow-root">
                            <ul class="-mb-8">
                                @foreach($recentBookings as $booking)
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full {{ $booking->status === 'confirmed' ? 'bg-green-500' : ($booking->status === 'pending' ? 'bg-yellow-500' : ($booking->status === 'cancelled' ? 'bg-red-500' : 'bg-blue-500')) }} flex items-center justify-center ring-8 ring-white">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">
                                                        <span class="font-medium text-gray-900">{{ $booking->booking_reference }}</span> - {{ $booking->hotel->name ?? 'Hotel' }}
                                                    </p>
                                                    <p class="text-xs text-gray-400">
                                                        {{ $booking->user->name }} • ${{ number_format($booking->total_amount, 2) }}
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium ml-2 {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                                                            {{ ucfirst($booking->status) }}
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    <time>{{ $booking->booked_at->format('M j') }}</time>
                                                    <p class="text-xs text-gray-400">{{ $booking->booked_at->format('g:i A') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="text-center py-6">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No bookings yet</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by promoting your hotels!</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Booking Trends Chart -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Booking Trends (Last 12 Months)</h3>
                </div>
                <div class="p-6">
                    @if(collect($bookingTrends)->sum('count') > 0)
                        <div class="relative">
                            <!-- Simple Bar Chart -->
                            <div class="flex items-end justify-between h-48 space-x-1">
                                @php
                                    $maxCount = collect($bookingTrends)->max('count');
                                    $maxHeight = 180; // Maximum height in pixels
                                @endphp
                                @foreach($bookingTrends as $trend)
                                    @php
                                        $height = $maxCount > 0 ? ($trend['count'] / $maxCount) * $maxHeight : 0;
                                    @endphp
                                    <div class="flex flex-col items-center flex-1">
                                        <div class="w-full bg-blue-200 rounded-t relative" 
                                             style="height: {{ max($height, 4) }}px;"
                                             title="{{ $trend['month'] }}: {{ $trend['count'] }} bookings">
                                            <div class="absolute inset-0 bg-blue-500 rounded-t hover:bg-blue-600 transition-colors"></div>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-2 text-center">
                                            {{ $trend['short_month'] }}
                                        </div>
                                        <div class="text-xs text-gray-400 text-center">
                                            {{ $trend['count'] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Legend -->
                            <div class="mt-4 flex items-center justify-center">
                                <div class="flex items-center text-sm text-gray-600">
                                    <div class="w-3 h-3 bg-blue-500 rounded mr-2"></div>
                                    <span>Monthly Bookings</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="mx-auto h-24 w-24 text-gray-400">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No booking data yet</h3>
                            <p class="mt-1 text-sm text-gray-500">Booking trends will appear here once you have bookings</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-management-layout>
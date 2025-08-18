<x-management-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Ferry Schedules Overview</h1>
            <p class="text-sm text-gray-600">Manage all ferry schedules and routes</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('ferries.dashboard') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="p-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Today's Schedules -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-blue-100 truncate">Today's Schedules</dt>
                                <dd class="text-lg font-medium text-white">{{ $stats['total_today'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-blue-700 px-5 py-3">
                    <div class="text-sm">
                        <span class="font-medium text-blue-200">
                            {{ $stats['available_today'] }} available
                        </span>
                    </div>
                </div>
            </div>

            <!-- Upcoming Schedules -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m0 0V9a2 2 0 11-18 0 2 2 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-green-100 truncate">Next 7 Days</dt>
                                <dd class="text-lg font-medium text-white">{{ $stats['total_upcoming'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-green-700 px-5 py-3">
                    <div class="text-sm">
                        <span class="font-medium text-green-200">
                            Upcoming schedules
                        </span>
                    </div>
                </div>
            </div>

            <!-- Total Seats Today -->
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-purple-100 truncate">Available Seats Today</dt>
                                <dd class="text-lg font-medium text-white">{{ $stats['total_seats_today'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-purple-700 px-5 py-3">
                    <div class="text-sm">
                        <span class="font-medium text-purple-200">
                            Across all ferries
                        </span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-orange-100 truncate">Manage Ferries</dt>
                                <dd class="text-lg font-medium text-white">Quick Access</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-orange-700 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('ferries.management.index') }}" class="font-medium text-orange-200 hover:text-white">
                            View all ferries →
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Schedules -->
        <div class="bg-white shadow rounded-lg mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Today's Schedules ({{ now()->format('M d, Y') }})</h3>
            </div>
            <div class="overflow-x-auto">
                @if($todaySchedules->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ferry</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Route</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seats</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($todaySchedules as $schedule)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $schedule->ferry->name }}</div>
                                    <div class="text-sm text-gray-500">ID: {{ $schedule->ferry->id }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $schedule->departureLocation->location_name }}</div>
                                    <div class="text-sm text-gray-500">→ {{ $schedule->arrivalLocation->location_name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">${{ number_format($schedule->price, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $schedule->remaining_seats }}</div>
                                    <div class="text-sm text-gray-500">of {{ $schedule->ferry->capacity }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($schedule->is_available)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Available
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Unavailable
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('ferries.schedules', $schedule->ferry->id) }}" 
                                       class="text-blue-600 hover:text-blue-900 mr-3">Manage</a>
                                    <a href="{{ route('ferries.management.show', $schedule->ferry->id) }}" 
                                       class="text-gray-600 hover:text-gray-900">View Ferry</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No schedules for today</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating schedules for your ferries.</p>
                        <div class="mt-6">
                            <a href="{{ route('ferries.management.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Manage Ferries
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- All Future Schedules -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Upcoming Schedules</h3>
            </div>
            <div class="p-6">
                @if($allFutureSchedules->count() > 0)
                    @foreach($allFutureSchedules as $date => $daySchedules)
                        <div class="mb-8 last:mb-0">
                            <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m0 0V9a2 2 0 11-18 0 2 2 0 0118 0z"></path>
                                </svg>
                                {{ \Carbon\Carbon::parse($date)->format('l, M d, Y') }}
                                <span class="ml-2 px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
                                    {{ $daySchedules->count() }} schedule{{ $daySchedules->count() != 1 ? 's' : '' }}
                                </span>
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($daySchedules as $schedule)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                        <div class="flex justify-between items-start mb-2">
                                            <h5 class="font-medium text-gray-900">{{ $schedule->ferry->name }}</h5>
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
                                        
                                        <div class="space-y-2 text-sm text-gray-600">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }}
                                            </div>
                                            
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ $schedule->departureLocation->location_name }} → {{ $schedule->arrivalLocation->location_name }}
                                            </div>
                                            
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                {{ $schedule->remaining_seats }} seats available
                                            </div>
                                            
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                </svg>
                                                ${{ number_format($schedule->price, 2) }}
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between">
                                            <a href="{{ route('ferries.schedules', $schedule->ferry->id) }}" 
                                               class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                                Manage Schedule
                                            </a>
                                            <a href="{{ route('ferries.management.show', $schedule->ferry->id) }}" 
                                               class="text-gray-600 hover:text-gray-900 text-sm">
                                                View Ferry
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No upcoming schedules</h3>
                        <p class="mt-1 text-sm text-gray-500">Create schedules for your ferries to start accepting bookings.</p>
                        <div class="mt-6">
                            <a href="{{ route('ferries.management.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Manage Ferries
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-management-layout> 
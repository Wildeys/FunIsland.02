<x-management-layout>
    <x-slot name="header">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Ferry Management Dashboard</h1>
                <p class="text-sm text-gray-600">Manage ferry operations and schedules</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('management.ferries.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                    Add New Ferry
                </a>
            </div>
    </x-slot>

    <div class="p-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Ferries -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-blue-100 truncate">Total Ferries</dt>
                                <dd class="text-lg font-medium text-white">{{ $stats['total_ferries'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-blue-700 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('ferries.management.index') }}" class="font-medium text-blue-200 hover:text-white">
                            View all ferries
                        </a>
                    </div>
                </div>
            </div>

            <!-- Active Routes -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-green-100 truncate">Active Routes</dt>
                                <dd class="text-lg font-medium text-white">{{ $stats['active_routes'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-green-700 px-5 py-3">
                    <div class="text-sm">
                        <span class="font-medium text-green-200">
                            Currently operating
                        </span>
                    </div>
                </div>
            </div>

            <!-- Total Schedules -->
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-purple-100 truncate">Total Schedules</dt>
                                <dd class="text-lg font-medium text-white">{{ $stats['total_schedules'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-purple-700 px-5 py-3">
                    <div class="text-sm">
                        <span class="font-medium text-purple-200">
                            Weekly schedules
                        </span>
                    </div>
                </div>
            </div>

            <!-- Total Bookings -->
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-orange-100 truncate">Total Bookings</dt>
                                <dd class="text-lg font-medium text-white">{{ $stats['total_bookings'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-orange-700 px-5 py-3">
                    <div class="text-sm">
                        <span class="font-medium text-orange-200">
                            All time bookings
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Quick Actions -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('management.ferries.create') }}" 
                           class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">Add Ferry</h4>
                                <p class="text-sm text-gray-500">Create new ferry</p>
                            </div>
                        </a>

                        <a href="{{ route('ferries.management.index') }}" 
                           class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">Manage Ferries</h4>
                                <p class="text-sm text-gray-500">View all ferries</p>
                            </div>
                        </a>

                        <a href="#" 
                           class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">Schedules</h4>
                                <p class="text-sm text-gray-500">Manage schedules</p>
                            </div>
                        </a>

                        <a href="#" 
                           class="flex items-center p-4 bg-orange-50 hover:bg-orange-100 rounded-lg transition-colors">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">Reports</h4>
                                <p class="text-sm text-gray-500">View analytics</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Recent Bookings</h3>
                </div>
                <div class="p-6">
                    @if(count($stats['recent_bookings']) > 0)
                        <div class="flow-root">
                            <ul class="-mb-8">
                                @foreach($stats['recent_bookings'] as $booking)
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">
                                                        New booking from <span class="font-medium text-gray-900">{{ $booking->user->name }}</span>
                                                    </p>
                                                    <p class="text-xs text-gray-400">{{ $booking->ferry->name }}</p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    <time>{{ $booking->created_at->diffForHumans() }}</time>
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
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No recent bookings</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by promoting your ferry services.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Ferry Status Overview -->
        <div class="mt-8">
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Ferry Fleet Overview</h3>
                </div>
                <div class="p-6">
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Ferry Fleet Management</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            You have {{ $stats['total_ferries'] }} ferries with {{ $stats['active_routes'] }} active routes.
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('ferries.management.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                                Manage Ferry Fleet
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-management-layout>

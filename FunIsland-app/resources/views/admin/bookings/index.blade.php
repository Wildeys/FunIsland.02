<x-management-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">
                @if(auth()->user()->isHotelManager() && !auth()->user()->isAdministrator())
                    Hotel Bookings Management
                @else
                    Booking Management
                @endif
            </h1>
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ $bookings->total() }} Total Bookings
                </span>
            </div>
        </div>
    </x-slot>

    <div class="p-6">
        <!-- Filters -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="p-6">
                <form method="GET" action="{{ route('admin.bookings') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                    <!-- Search -->
                    <div class="lg:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" 
                               name="search" 
                               id="search"
                               value="{{ request('search') }}"
                               placeholder="Booking reference, customer name..."
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <!-- Booking Type Filter -->
                    @if(auth()->user()->isAdministrator())
                    <div>
                        <label for="booking_type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select name="booking_type" id="booking_type" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">All Types</option>
                            <option value="hotel" {{ request('booking_type') === 'hotel' ? 'selected' : '' }}>Hotel</option>
                            <option value="ferry" {{ request('booking_type') === 'ferry' ? 'selected' : '' }}>Ferry</option>
                            <option value="event" {{ request('booking_type') === 'event' ? 'selected' : '' }}>Event</option>
                            <option value="themepark" {{ request('booking_type') === 'themepark' ? 'selected' : '' }}>Theme Park</option>
                        </select>
                    </div>
                    @endif

                    <!-- Payment Status Filter -->
                    <div>
                        <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-1">Payment</label>
                        <select name="payment_status" id="payment_status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">All Payment Status</option>
                            <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="refunded" {{ request('payment_status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>

                    <!-- Filter Actions -->
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            Filter
                        </button>
                        <a href="{{ route('admin.bookings') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            Clear
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bookings Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            @if($bookings->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                @if(auth()->user()->isAdministrator())
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                @endif
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($bookings as $booking)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                <a href="{{ route('admin.bookings.show', $booking) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    {{ $booking->booking_reference }}
                                                </a>
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $booking->guests }} guest{{ $booking->guests > 1 ? 's' : '' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $booking->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $booking->user->email }}</div>
                                        </div>
                                    </td>
                                    @if(auth()->user()->isAdministrator())
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $booking->booking_type === 'hotel' ? 'bg-purple-100 text-purple-800' : 
                                               ($booking->booking_type === 'ferry' ? 'bg-blue-100 text-blue-800' : 
                                               ($booking->booking_type === 'event' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800')) }}">
                                            {{ ucfirst($booking->booking_type) }}
                                        </span>
                                    </td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            @if($booking->hotel)
                                                {{ $booking->hotel->name }}
                                                @if($booking->room)
                                                    <div class="text-xs text-gray-500">Room: {{ $booking->room->room_number }}</div>
                                                @endif
                                            @elseif($booking->ferry)
                                                {{ $booking->ferry->name }}
                                            @elseif($booking->event)
                                                {{ $booking->event->name }}
                                            @elseif($booking->themepark)
                                                {{ $booking->themepark->name }}
                                            @else
                                                <span class="text-gray-500">N/A</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${{ number_format($booking->total_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                               ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $booking->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 
                                               ($booking->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($booking->payment_status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $booking->booked_at->format('M j, Y') }}
                                        <div class="text-xs text-gray-400">{{ $booking->booked_at->format('g:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.bookings.show', $booking) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">View</a>
                                            <a href="{{ route('admin.bookings.edit', $booking) }}" 
                                               class="text-green-600 hover:text-green-900">Edit</a>
                                            @if($booking->status !== 'cancelled')
                                                <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900"
                                                            onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                        Cancel
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-white px-4 py-3 border-t border-gray-200">
                    {{ $bookings->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No bookings found</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @if(request()->hasAny(['search', 'status', 'booking_type', 'payment_status']))
                            Try adjusting your search criteria.
                        @else
                            No bookings have been made yet.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-management-layout> 
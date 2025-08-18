<x-management-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Booking Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Booking Header -->
                    <div class="border-b border-gray-200 pb-4 mb-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                    Booking #{{ $booking->booking_reference }}
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    Created {{ $booking->created_at->format('M d, Y \a\t g:i A') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($booking->status === 'confirmed') bg-green-100 text-green-800
                                    @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                    @elseif($booking->status === 'completed') bg-blue-100 text-blue-800
                                    @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Customer Information -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Customer Information</h3>
                            <div class="space-y-2">
                                <p><span class="font-medium">Name:</span> {{ $booking->user->name }}</p>
                                <p><span class="font-medium">Email:</span> {{ $booking->user->email }}</p>
                                <p><span class="font-medium">Booking Type:</span> {{ ucfirst($booking->booking_type) }}</p>
                            </div>
                        </div>

                        <!-- Booking Information -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Booking Information</h3>
                            <div class="space-y-2">
                                <p><span class="font-medium">Guests:</span> {{ $booking->guests }}</p>
                                <p><span class="font-medium">Total Amount:</span> ${{ number_format($booking->total_amount, 2) }}</p>
                                <p><span class="font-medium">Payment Status:</span> 
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                                        @if($booking->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($booking->payment_status === 'paid') bg-green-100 text-green-800
                                        @elseif($booking->payment_status === 'refunded') bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($booking->payment_status) }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        @if($booking->booking_type === 'hotel' && $booking->hotel)
                        <!-- Hotel Details -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Hotel Details</h3>
                            <div class="space-y-2">
                                <p><span class="font-medium">Hotel:</span> {{ $booking->hotel->name }}</p>
                                @if($booking->room)
                                <p><span class="font-medium">Room:</span> {{ $booking->room->room_number }} ({{ ucfirst($booking->room->room_type) }})</p>
                                @endif
                                <p><span class="font-medium">Check-in:</span> {{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</p>
                                <p><span class="font-medium">Check-out:</span> {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</p>
                                <p><span class="font-medium">Nights:</span> {{ \Carbon\Carbon::parse($booking->check_in_date)->diffInDays(\Carbon\Carbon::parse($booking->check_out_date)) }}</p>
                            </div>
                        </div>
                        @endif

                        @if($booking->booking_type === 'ferry' && $booking->ferry)
                        <!-- Ferry Details -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Ferry Details</h3>
                            <div class="space-y-2">
                                <p><span class="font-medium">Ferry:</span> {{ $booking->ferry->name }}</p>
                                <p><span class="font-medium">Date:</span> {{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</p>
                            </div>
                        </div>
                        @endif

                        @if($booking->booking_type === 'event' && $booking->event)
                        <!-- Event Details -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Event Details</h3>
                            <div class="space-y-2">
                                <p><span class="font-medium">Event:</span> {{ $booking->event->name }}</p>
                                <p><span class="font-medium">Date:</span> {{ \Carbon\Carbon::parse($booking->event->start_time)->format('M d, Y') }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Special Requests -->
                        @if($booking->special_requests)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 md:col-span-2">
                            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Special Requests</h3>
                            <p class="text-gray-700 dark:text-gray-300">{{ $booking->special_requests }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex justify-between items-center border-t border-gray-200 pt-6">
                        <a href="{{ route('bookings.index') }}" 
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            ← Back to Bookings
                        </a>
                        
                        <div class="space-x-2">
                            @if($booking->status === 'pending')
                            <form method="POST" action="{{ route('bookings.updateStatus', $booking) }}" class="inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit" 
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Confirm Booking
                                </button>
                            </form>
                            @endif
                            
                            @if($booking->status !== 'cancelled')
                            <form method="POST" action="{{ route('bookings.cancel', $booking) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to cancel this booking?')"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Cancel Booking
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-management-layout> 
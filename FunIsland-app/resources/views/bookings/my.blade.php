<x-tropical-layout title="My Bookings">
    <x-slot name="header">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">📅 My Bookings</h1>
            <p class="text-xl md:text-2xl text-white/90">Your island adventures at a glance</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($bookings->count() > 0)
            <div class="grid gap-6">
                @foreach($bookings as $booking)
                    <div class="bg-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">
                                    @if($booking->hotel)
                                        🏨 {{ $booking->hotel->name }}
                                    @elseif($booking->ferry)
                                        🚤 {{ $booking->ferry->name }}
                                    @elseif($booking->event)
                                        🎪 {{ $booking->event->name }}
                                    @else
                                        📋 Booking #{{ $booking->id }}
                                    @endif
                                </h3>
                                <p class="text-gray-600">
                                    Booking #{{ $booking->id }} • 
                                    {{ $booking->created_at->format('M d, Y') }}
                                </p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($booking->status ?? 'pending') }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-500">Check-in / Date</p>
                                <p class="font-medium">{{ $booking->check_in_date ? $booking->check_in_date->format('M d, Y') : 'TBD' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Duration / Guests</p>
                                <p class="font-medium">{{ $booking->guests ?? 1 }} guest(s)</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Amount</p>
                                <p class="font-medium text-green-600">${{ number_format($booking->total_amount ?? 0, 2) }}</p>
                            </div>
                        </div>

                        <div class="flex space-x-3">
                            <a href="{{ route('bookings.show', $booking->id) }}" 
                               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                View Details
                            </a>
                            @if(auth()->user()->canManageTicketing())
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
                            @if($booking->status === 'pending' || $booking->status === 'confirmed')
                                <form method="POST" action="{{ route('bookings.destroy', $booking->id) }}" 
                                      onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                                        Cancel
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $bookings->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="bg-white rounded-2xl shadow-xl p-12">
                    <div class="text-6xl mb-4">📅</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">No bookings yet</h3>
                    <p class="text-gray-600 mb-8">Start planning your perfect island getaway!</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 max-w-2xl mx-auto">
                        <a href="{{ route('hotels.customer.index') }}" 
                           class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                            Book Hotels
                        </a>
                        <a href="{{ route('ferries.customer.index') }}" 
                           class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                            Ferry Tickets
                        </a>
                        <a href="{{ route('themeparks.customer.index') }}" 
                           class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition-colors">
                            Theme Parks
                        </a>
                        <a href="{{ route('beaches.customer.index') }}" 
                           class="bg-yellow-600 text-white px-6 py-3 rounded-lg hover:bg-yellow-700 transition-colors">
                            Beach Events
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-tropical-layout> 
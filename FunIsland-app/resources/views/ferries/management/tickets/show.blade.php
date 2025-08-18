<x-management-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ticket Details') }} - {{ $ticket->ticket_reference }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold">Ticket Information</h3>
                            <a href="{{ route('management.ferries.tickets.management') }}" class="text-blue-600 hover:text-blue-800">
                                ← Back to Tickets
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-4">Customer Details</h4>
                            <dl class="grid grid-cols-1 gap-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $ticket->user->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $ticket->user->email }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Booking Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $ticket->created_at->format('M d, Y H:i') }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-4">Ferry Schedule Details</h4>
                            <dl class="grid grid-cols-1 gap-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Ferry</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $ticket->ferrySchedule->ferry->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Route</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $ticket->ferrySchedule->departureLocation->location_name }} →
                                        {{ $ticket->ferrySchedule->arrivalLocation->location_name }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Date & Time</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $ticket->ferrySchedule->date->format('M d, Y') }} at 
                                        {{ $ticket->ferrySchedule->departure_time->format('H:i') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-4">Ticket Details</h4>
                            <dl class="grid grid-cols-1 gap-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Reference Number</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $ticket->ticket_reference }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Number of Guests</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $ticket->number_of_guests }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Total Price</dt>
                                    <dd class="mt-1 text-sm text-gray-900">${{ number_format($ticket->total_price, 2) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($ticket->status === 'confirmed') bg-green-100 text-green-800
                                            @elseif($ticket->status === 'cancelled') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ ucfirst($ticket->status) }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        @if($ticket->hotel_booking_id)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-4">Related Hotel Booking</h4>
                            <dl class="grid grid-cols-1 gap-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Booking Reference</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <a href="{{ route('bookings.show', $ticket->hotelBooking) }}" class="text-blue-600 hover:text-blue-800">
                                            {{ $ticket->hotelBooking->booking_reference }}
                                        </a>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Hotel</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $ticket->hotelBooking->hotel->name }}</dd>
                                </div>
                            </dl>
                        </div>
                        @endif
                    </div>

                    @if($ticket->status === 'pending')
                    <div class="mt-8 border-t pt-6">
                        <h4 class="font-medium mb-4">Update Ticket Status</h4>
                        <form action="{{ route('management.ferries.tickets.status.update', $ticket) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700">Notes (optional)</label>
                                <textarea id="notes" name="notes" rows="3" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
                            </div>

                            <div class="flex gap-4">
                                <button type="submit" name="status" value="confirmed" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Confirm Ticket
                                </button>
                                <button type="submit" name="status" value="cancelled"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Cancel Ticket
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif

                    @if($ticket->notes)
                    <div class="mt-8 border-t pt-6">
                        <h4 class="font-medium mb-4">Notes</h4>
                        <p class="text-sm text-gray-600">{{ $ticket->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-management-layout> 
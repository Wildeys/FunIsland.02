<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ferry Ticket Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold">Ticket Information</h3>
                            <a href="{{ route('ferries.tickets.my') }}" class="text-blue-600 hover:text-blue-800">
                                ← Back to My Tickets
                            </a>
                        </div>
                    </div>

                    <div class="mb-8">
                        <div class="rounded-md bg-blue-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    @if($ticket->status === 'confirmed')
                                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    @elseif($ticket->status === 'cancelled')
                                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">
                                        Ticket Status: {{ ucfirst($ticket->status) }}
                                    </h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <p>
                                            @if($ticket->status === 'confirmed')
                                                Your ticket has been confirmed. Please arrive at least 30 minutes before departure.
                                            @elseif($ticket->status === 'cancelled')
                                                This ticket has been cancelled.
                                            @else
                                                Your ticket request is pending confirmation. We'll notify you once it's confirmed.
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-4">Ferry Details</h4>
                            <dl class="grid grid-cols-1 gap-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Ferry Name</dt>
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
                                    <dt class="text-sm font-medium text-gray-500">Booking Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $ticket->created_at->format('M d, Y H:i') }}</dd>
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

                    @if($ticket->notes)
                    <div class="mt-8 border-t pt-6">
                        <h4 class="font-medium mb-4">Additional Information</h4>
                        <p class="text-sm text-gray-600">{{ $ticket->notes }}</p>
                    </div>
                    @endif

                    @if($ticket->status === 'confirmed')
                    <div class="mt-8 border-t pt-6">
                        <h4 class="font-medium mb-4">Important Information</h4>
                        <ul class="list-disc list-inside text-sm text-gray-600 space-y-2">
                            <li>Please arrive at least 30 minutes before departure time</li>
                            <li>Bring a valid ID for verification</li>
                            <li>Keep this ticket reference number handy</li>
                            <li>In case of any issues, contact our support team</li>
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
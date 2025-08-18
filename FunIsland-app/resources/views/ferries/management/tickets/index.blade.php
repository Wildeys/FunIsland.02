<x-management-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ferry Ticket Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold">Ticket Requests</h3>
                            <div class="flex gap-4">
                                <a href="{{ route('management.ferries.schedules.all') }}" class="text-blue-600 hover:text-blue-800">View All Schedules</a>
                            </div>
                        </div>
                    </div>

                    @if($tickets->isEmpty())
                        <p class="text-gray-500 text-center py-4">No ticket requests found.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Schedule</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guests</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($tickets as $ticket)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $ticket->ticket_reference }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $ticket->user->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $ticket->ferrySchedule->ferry->name }} <br>
                                                <span class="text-xs">
                                                    {{ $ticket->ferrySchedule->departureLocation->location_name }} →
                                                    {{ $ticket->ferrySchedule->arrivalLocation->location_name }} <br>
                                                    {{ $ticket->ferrySchedule->date->format('M d, Y') }} at 
                                                    {{ $ticket->ferrySchedule->departure_time->format('H:i') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $ticket->number_of_guests }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                ${{ number_format($ticket->total_price, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($ticket->status === 'confirmed') bg-green-100 text-green-800
                                                    @elseif($ticket->status === 'cancelled') bg-red-100 text-red-800
                                                    @else bg-yellow-100 text-yellow-800 @endif">
                                                    {{ ucfirst($ticket->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <a href="{{ route('management.ferries.tickets.show', $ticket) }}" 
                                                   class="text-blue-600 hover:text-blue-900">View Details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $tickets->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-management-layout> 
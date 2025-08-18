<x-management-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Booking List</h3>
                        @can('create bookings')
                            <a href="{{ route('bookings.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Create New Booking
                            </a>
                        @endcan
                    </div>

                    @if ($bookings->isEmpty())
                        <p class="text-gray-600">No bookings found.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guests</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($bookings as $booking)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $booking->booking_reference }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($booking->booking_type) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($booking->booking_type === 'hotel' && $booking->hotel)
                                                    {{ $booking->hotel->name }}
                                                @elseif ($booking->booking_type === 'ferry' && $booking->ferry)
                                                    {{ $booking->ferry->name }}
                                                @elseif ($booking->booking_type === 'themepark' && $booking->themepark)
                                                    {{ $booking->themepark->name }}
                                                @elseif ($booking->booking_type === 'event' && $booking->event)
                                                    {{ $booking->event->name }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $booking->check_in_date->format('Y-m-d') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $booking->guests }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($booking->total_amount, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                    @if($booking->status === 'confirmed')
                                                        bg-green-100 text-green-800
                                                    @elseif($booking->status === 'pending')
                                                        bg-yellow-100 text-yellow-800
                                                    @elseif($booking->status === 'cancelled')
                                                        bg-red-100 text-red-800
                                                    @elseif($booking->status === 'completed')
                                                        bg-blue-100 text-blue-800
                                                    @else
                                                        bg-gray-100 text-gray-800
                                                    @endif">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                                                <a href="{{ route('bookings.show', $booking->id) }}" class="text-blue-600 hover:text-blue-800">View</a>
                                                @can('update bookings')
                                                    <a href="{{ route('bookings.edit', $booking->id) }}" class="text-green-600 hover:text-green-800">Edit</a>
                                                @endcan
                                                @can('delete bookings')
                                                    <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800" 
                                                                onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                            Cancel
                                                        </button>
                                                    </form>
                                                @endcan
                                                @can('manage bookings')
                                                    @if ($booking->status === 'pending')
                                                        <form action="{{ route('hotel.manager.bookings.approve', $booking->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="text-green-600 hover:text-green-800">Approve</button>
                                                        </form>
                                                        <form action="{{ route('hotel.manager.bookings.reject', $booking->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="text-red-600 hover:text-red-800" 
                                                                    onclick="return confirm('Are you sure you want to reject this booking?')">
                                                                Reject
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6">
                            {{ $bookings->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-management-layout>
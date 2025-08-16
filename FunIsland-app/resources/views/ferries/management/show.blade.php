<!-- resources/views/ferries/management/show.blade.php -->
<x-management-layout title="Ferry Details">
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Ferry: {{ $ferry->name }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">View ferry details and schedules</p>

            @if(session('success'))
                <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mt-6 bg-white shadow rounded-lg p-6">
                <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-700">Ferry Name</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $ferry->name }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-700">Location</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $ferry->location->location_name }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-700">Capacity</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $ferry->capacity }} passengers</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-700">Price</h3>
                        <p class="mt-1 text-sm text-gray-900">${{ number_format($ferry->price, 2) }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-700">Route</h3>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $ferry->departure_location }} → {{ $ferry->arrival_location }}
                        </p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-700">Status</h3>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $ferry->status === 'active' ? 'bg-green-100 text-green-800' : ($ferry->status === 'inactive' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($ferry->status) }}
                        </span>
                    </div>
                    <div class="sm:col-span-2">
                        <h3 class="text-sm font-medium text-gray-700">Description</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $ferry->description ?? 'No description available' }}</p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('ferries.management.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Back to Ferries
                    </a>
                    <a href="{{ route('ferries.management.edit', $ferry->id) }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        Edit Ferry
                    </a>
                    <form action="{{ route('ferries.destroy', $ferry->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this ferry?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                            Delete Ferry
                        </button>
                    </form>
                </div>
            </div>

            <!-- Schedules -->
            <div class="mt-8 bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Schedules</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departure Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remaining Seats</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Availability</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($ferry->schedules as $schedule)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $schedule->date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $schedule->departure_time }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $schedule->remaining_seats }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $schedule->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $schedule->is_available ? 'Available' : 'Unavailable' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        No schedules found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-management-layout>
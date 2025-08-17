<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create New Booking') }}
            </h2>
            <a href="{{ route('bookings.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                ← Back to Bookings
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">🏝️ New Booking Details</h3>
                </div>
                
                <form method="POST" action="{{ route('bookings.store') }}" class="p-6 space-y-6">
                    @csrf

                    <!-- Customer Selection -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Customer Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer</label>
                                <select name="user_id" id="user_id" required 
                                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select a customer...</option>
                                    @foreach(\App\Models\User::where('role_id', \App\Models\Role::where('name', 'customer')->first()->id)->get() as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->email }})</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="booking_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Booking Type</label>
                                <select name="booking_type" id="booking_type" required onchange="toggleBookingTypeFields()"
                                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select booking type...</option>
                                    <option value="hotel">🏨 Hotel</option>
                                    <option value="ferry">🚤 Ferry</option>
                                    <option value="event">🎉 Event</option>
                                </select>
                                @error('booking_type')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Hotel Booking Fields -->
                    <div id="hotel_fields" class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6 hidden">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">🏨 Hotel Booking Details</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="hotel_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hotel</label>
                                <select name="hotel_id" id="hotel_id" 
                                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select a hotel...</option>
                                    @foreach(\App\Models\hotel::where('status', 'active')->get() as $hotel)
                                    <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="hotel_room_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Room</label>
                                <select name="hotel_room_id" id="hotel_room_id" 
                                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select a room...</option>
                                </select>
                            </div>

                            <div>
                                <label for="check_in_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Check-in Date</label>
                                <input type="date" name="check_in_date" id="check_in_date" 
                                       class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="check_out_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Check-out Date</label>
                                <input type="date" name="check_out_date" id="check_out_date" 
                                       class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Ferry Booking Fields -->
                    <div id="ferry_fields" class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-6 hidden">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">🚤 Ferry Booking Details</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="ferry_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ferry</label>
                                <select name="ferry_id" id="ferry_id" 
                                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select a ferry...</option>
                                    @foreach(\App\Models\ferry::where('status', 'active')->get() as $ferry)
                                    <option value="{{ $ferry->id }}">{{ $ferry->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="travel_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Travel Date</label>
                                <input type="date" name="travel_date" id="travel_date" 
                                       class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Event Booking Fields -->
                    <div id="event_fields" class="bg-green-50 dark:bg-green-900/20 rounded-lg p-6 hidden">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">🎉 Event Booking Details</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="event_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Event</label>
                                <select name="event_id" id="event_id" 
                                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select an event...</option>
                                    @foreach(\App\Models\Event::active()->upcoming()->get() as $event)
                                    <option value="{{ $event->id }}">{{ $event->name }} - {{ $event->start_time->format('M d, Y') }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity</label>
                                <input type="number" name="quantity" id="quantity" min="1" max="10" value="1"
                                       class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Common Fields -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Booking Details</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="guests" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Number of Guests</label>
                                <input type="number" name="guests" id="guests" min="1" max="20" value="1" required
                                       class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('guests')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="total_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Amount ($)</label>
                                <input type="number" name="total_amount" id="total_amount" step="0.01" min="0" required
                                       class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('total_amount')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                <select name="status" id="status" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="completed">Completed</option>
                                </select>
                                @error('status')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="payment_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Status</label>
                                <select name="payment_status" id="payment_status" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                    <option value="refunded">Refunded</option>
                                </select>
                                @error('payment_status')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="special_requests" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Special Requests</label>
                                <textarea name="special_requests" id="special_requests" rows="3" 
                                          class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                          placeholder="Any special requests or notes..."></textarea>
                                @error('special_requests')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('bookings.index') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-6 rounded-lg transition-colors">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-all shadow-md hover:shadow-lg">
                            Create Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleBookingTypeFields() {
            const bookingType = document.getElementById('booking_type').value;
            const hotelFields = document.getElementById('hotel_fields');
            const ferryFields = document.getElementById('ferry_fields');
            const eventFields = document.getElementById('event_fields');

            // Hide all fields first
            hotelFields.classList.add('hidden');
            ferryFields.classList.add('hidden');
            eventFields.classList.add('hidden');

            // Show relevant fields
            if (bookingType === 'hotel') {
                hotelFields.classList.remove('hidden');
            } else if (bookingType === 'ferry') {
                ferryFields.classList.remove('hidden');
            } else if (bookingType === 'event') {
                eventFields.classList.remove('hidden');
            }
        }

        // Load rooms when hotel is selected
        document.getElementById('hotel_id').addEventListener('change', function() {
            const hotelId = this.value;
            const roomSelect = document.getElementById('hotel_room_id');
            
            if (hotelId) {
                fetch(`/api/hotels/${hotelId}/rooms`)
                    .then(response => response.json())
                    .then(rooms => {
                        roomSelect.innerHTML = '<option value="">Select a room...</option>';
                        rooms.forEach(room => {
                            roomSelect.innerHTML += `<option value="${room.id}">${room.room_number} - ${room.room_type} ($${room.price_per_night}/night)</option>`;
                        });
                    })
                    .catch(error => {
                        console.error('Error loading rooms:', error);
                        roomSelect.innerHTML = '<option value="">Error loading rooms</option>';
                    });
            } else {
                roomSelect.innerHTML = '<option value="">Select a room...</option>';
            }
        });
    </script>
</x-app-layout> 
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Booking') }} #{{ $booking->booking_reference }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('bookings.show', $booking) }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    View Details
                </a>
                <a href="{{ route('bookings.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    ← Back to Bookings
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">✏️ Edit Booking Details</h3>
                </div>
                
                <form method="POST" action="{{ route('bookings.update', $booking) }}" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Booking Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Booking Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Booking Reference</label>
                                <input type="text" value="{{ $booking->booking_reference }}" disabled
                                       class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-100 dark:bg-gray-600 text-gray-500 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer</label>
                                <input type="text" value="{{ $booking->user->name }} ({{ $booking->user->email }})" disabled
                                       class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-100 dark:bg-gray-600 text-gray-500 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Booking Type</label>
                                <input type="text" value="{{ ucfirst($booking->booking_type) }}" disabled
                                       class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-100 dark:bg-gray-600 text-gray-500 shadow-sm">
                            </div>
                        </div>
                    </div>

                    @if($booking->booking_type === 'hotel')
                    <!-- Hotel Booking Details -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">🏨 Hotel Details</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hotel</label>
                                <input type="text" value="{{ $booking->hotel ? $booking->hotel->name : 'N/A' }}" disabled
                                       class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-100 dark:bg-gray-600 text-gray-500 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Room</label>
                                <input type="text" value="{{ $booking->room ? $booking->room->room_number . ' (' . $booking->room->room_type . ')' : 'N/A' }}" disabled
                                       class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-100 dark:bg-gray-600 text-gray-500 shadow-sm">
                            </div>

                            <div>
                                <label for="check_in_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Check-in Date</label>
                                <input type="date" name="check_in_date" id="check_in_date" value="{{ $booking->check_in_date ? $booking->check_in_date->format('Y-m-d') : '' }}"
                                       class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('check_in_date')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="check_out_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Check-out Date</label>
                                <input type="date" name="check_out_date" id="check_out_date" value="{{ $booking->check_out_date ? $booking->check_out_date->format('Y-m-d') : '' }}"
                                       class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('check_out_date')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($booking->booking_type === 'ferry')
                    <!-- Ferry Booking Details -->
                    <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">🚤 Ferry Details</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ferry</label>
                                <input type="text" value="{{ $booking->ferry ? $booking->ferry->name : 'N/A' }}" disabled
                                       class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-100 dark:bg-gray-600 text-gray-500 shadow-sm">
                            </div>

                            <div>
                                <label for="check_in_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Travel Date</label>
                                <input type="date" name="check_in_date" id="check_in_date" value="{{ $booking->check_in_date ? $booking->check_in_date->format('Y-m-d') : '' }}"
                                       class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($booking->booking_type === 'event')
                    <!-- Event Booking Details -->
                    <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">🎉 Event Details</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Event</label>
                                <input type="text" value="{{ $booking->event ? $booking->event->name : 'N/A' }}" disabled
                                       class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-100 dark:bg-gray-600 text-gray-500 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Event Date</label>
                                <input type="text" value="{{ $booking->event ? $booking->event->start_time->format('M d, Y g:i A') : 'N/A' }}" disabled
                                       class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-100 dark:bg-gray-600 text-gray-500 shadow-sm">
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Editable Fields -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Booking Settings</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="guests" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Number of Guests</label>
                                <input type="number" name="guests" id="guests" min="1" max="20" value="{{ $booking->guests }}" required
                                       class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('guests')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="total_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Amount ($)</label>
                                <input type="number" name="total_amount" id="total_amount" step="0.01" min="0" value="{{ $booking->total_amount }}" required
                                       class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('total_amount')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                <select name="status" id="status" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                @error('status')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="payment_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Status</label>
                                <select name="payment_status" id="payment_status" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="pending" {{ $booking->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $booking->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="refunded" {{ $booking->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                                </select>
                                @error('payment_status')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="special_requests" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Special Requests</label>
                                <textarea name="special_requests" id="special_requests" rows="3" 
                                          class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                          placeholder="Any special requests or notes...">{{ $booking->special_requests }}</textarea>
                                @error('special_requests')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Booking History -->
                    <div class="bg-amber-50 dark:bg-amber-900/20 rounded-lg p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">📊 Booking History</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Created</label>
                                <input type="text" value="{{ $booking->created_at->format('M d, Y g:i A') }}" disabled
                                       class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-100 dark:bg-gray-600 text-gray-500 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Updated</label>
                                <input type="text" value="{{ $booking->updated_at->format('M d, Y g:i A') }}" disabled
                                       class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-100 dark:bg-gray-600 text-gray-500 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Booked At</label>
                                <input type="text" value="{{ $booking->booked_at ? $booking->booked_at->format('M d, Y g:i A') : 'N/A' }}" disabled
                                       class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-100 dark:bg-gray-600 text-gray-500 shadow-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex space-x-3">
                            <a href="{{ route('bookings.show', $booking) }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-6 rounded-lg transition-colors">
                                Cancel
                            </a>
                        </div>
                        
                        <div class="flex space-x-3">
                            @if($booking->status !== 'cancelled')
                            <button type="button" onclick="confirmCancel()" 
                                    class="bg-red-500 hover:bg-red-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">
                                Cancel Booking
                            </button>
                            @endif
                            
                            <button type="submit" 
                                    class="bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-medium py-2 px-6 rounded-lg transition-all shadow-md hover:shadow-lg">
                                Update Booking
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Hidden cancel form -->
                <form id="cancelForm" method="POST" action="{{ route('bookings.cancel', $booking) }}" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmCancel() {
            if (confirm('Are you sure you want to cancel this booking? This action cannot be undone.')) {
                document.getElementById('cancelForm').submit();
            }
        }
    </script>
</x-app-layout> 
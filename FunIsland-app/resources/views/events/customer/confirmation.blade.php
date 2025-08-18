<x-tropical-layout title="Booking Confirmation">
    <x-slot name="header">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">🎉 Booking Confirmed!</h1>
            <p class="text-xl md:text-2xl text-white/90">Your event booking has been successfully confirmed</p>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-2xl shadow-xl p-8 -mt-20 relative z-10">
            <!-- Success Message -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-4xl">✅</span>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Booking Confirmed!</h2>
                <p class="text-gray-600">Thank you for booking with FunIsland. Here are your booking details:</p>
            </div>

            <!-- Booking Details -->
            <div class="border rounded-lg p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Event Info -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Event Details</h3>
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <span class="text-2xl mr-3">
                                    @if($booking->event->type == 'beach_event')
                                        🏖️
                                    @elseif($booking->event->type == 'activity')
                                        🚤
                                    @else
                                        🎵
                                    @endif
                                </span>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $booking->event->name }}</p>
                                    <p class="text-gray-600">{{ $booking->event->type_display }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center text-gray-600">
                                <span class="text-lg mr-3">📅</span>
                                <span>{{ $booking->event->start_time->format('l, F j, Y \a\t g:i A') }}</span>
                            </div>
                            
                            <div class="flex items-center text-gray-600">
                                <span class="text-lg mr-3">📍</span>
                                <span>{{ $booking->event->location }}</span>
                            </div>
                            
                            <div class="flex items-center text-gray-600">
                                <span class="text-lg mr-3">⏱️</span>
                                <span>{{ $booking->event->duration ?? 'See event schedule' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Info -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Booking Information</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Booking ID:</span>
                                <span class="font-semibold">#{{ $booking->id }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-semibold">{{ $booking->quantity }} {{ $booking->quantity == 1 ? 'person' : 'people' }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Price per person:</span>
                                <span class="font-semibold">${{ number_format($booking->event->price, 2) }}</span>
                            </div>
                            
                            <div class="flex justify-between text-lg font-bold text-green-600 pt-2 border-t">
                                <span>Total Amount:</span>
                                <span>${{ number_format($booking->total_price, 2) }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Booking Date:</span>
                                <span class="font-semibold">{{ $booking->created_at->format('M j, Y g:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if($booking->special_requirements)
                    <div class="mt-6 pt-6 border-t">
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Special Requirements</h4>
                        <p class="text-gray-600">{{ $booking->special_requirements }}</p>
                    </div>
                @endif
            </div>

            <!-- Important Information -->
            <div class="bg-blue-50 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">📋 Important Information</h3>
                <ul class="space-y-2 text-blue-800">
                    <li class="flex items-start">
                        <span class="text-blue-600 mr-2">•</span>
                        <span>Please arrive at least 15 minutes before the event start time</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-blue-600 mr-2">•</span>
                        <span>Bring a valid ID for verification</span>
                    </li>
                    @if($booking->event->requirements)
                        <li class="flex items-start">
                            <span class="text-blue-600 mr-2">•</span>
                            <span>{{ $booking->event->requirements }}</span>
                        </li>
                    @endif
                    <li class="flex items-start">
                        <span class="text-blue-600 mr-2">•</span>
                        <span>For cancellations or changes, contact us at least 24 hours in advance</span>
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('bookings.my') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors text-center">
                    View All My Bookings
                </a>
                
                <a href="{{ route('events.index') }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-3 px-6 rounded-lg transition-colors text-center">
                    Browse More Events
                </a>
                
                <a href="{{ route('dashboard') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition-colors text-center">
                    Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="mt-8 text-center">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Need Help?</h3>
                <p class="text-gray-600 mb-3">If you have any questions about your booking, please contact us:</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center text-sm">
                    <div class="flex items-center justify-center">
                        <span class="mr-2">📞</span>
                        <span>+960 123-4567</span>
                    </div>
                    <div class="flex items-center justify-center">
                        <span class="mr-2">📧</span>
                        <span>bookings@funisland.com</span>
                    </div>
                    <div class="flex items-center justify-center">
                        <span class="mr-2">💬</span>
                        <span>Live Chat Available 24/7</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tropical-layout> 
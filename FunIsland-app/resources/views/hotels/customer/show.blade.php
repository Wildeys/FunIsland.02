@extends('layouts.tropical')

@section('title', $hotel->name . ' - FunIsland')

@section('content')
    <!-- Hero Section -->
    <div class="tropical-gradient py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">
                    🏨 {{ $hotel->name }}
                </h1>
                <p class="text-xl md:text-2xl text-white/90 mb-6">
                    📍 {{ $hotel->location->name ?? 'FunIsland' }}
                </p>
                <div class="flex justify-center text-yellow-400 text-2xl">
                    @for($i = 0; $i < 5; $i++)
                        ⭐
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <!-- Hotel Details -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Hotel Image -->
                <div class="space-y-6">
                    <div class="h-64 lg:h-80 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center">
                        @if($hotel->image_url)
                            <img src="{{ $hotel->image_url }}" alt="{{ $hotel->name }}" class="w-full h-full object-cover rounded-2xl">
                        @else
                            <span class="text-8xl">🏨</span>
                        @endif
                    </div>
                </div>

                <!-- Hotel Information -->
                <div class="space-y-6">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">About This Hotel</h2>
                        <p class="text-gray-600 text-lg leading-relaxed">{{ $hotel->description }}</p>
                    </div>

                    <!-- Amenities -->
                    @if($hotel->amenities)
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">🌟 Hotel Amenities</h3>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($hotel->amenities as $amenity)
                                <div class="flex items-center text-gray-600">
                                    <span class="text-green-500 mr-2">✓</span>
                                    {{ $amenity }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Contact Info -->
                    @if($hotel->contact_info)
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">📞 Contact Information</h3>
                        <div class="space-y-2">
                            @if(isset($hotel->contact_info['phone']))
                                <div class="text-gray-600">📱 {{ $hotel->contact_info['phone'] }}</div>
                            @endif
                            @if(isset($hotel->contact_info['email']))
                                <div class="text-gray-600">📧 {{ $hotel->contact_info['email'] }}</div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Available Rooms Section -->
    <div class="py-16 bg-gradient-to-br from-blue-50 via-white to-green-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    🛏️ Available Rooms
                </h2>
                <p class="text-xl text-gray-600">
                    Choose from our selection of comfortable and luxurious accommodations
                </p>
            </div>

            @if($hotel->rooms->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($hotel->rooms as $room)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100">
                        <!-- Room Type Badge -->
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-4 text-white">
                            <h3 class="text-xl font-bold">{{ $room->room_type_display }}</h3>
                            <p class="text-blue-100">Room {{ $room->room_number }}</p>
                        </div>

                        <div class="p-6">
                            <p class="text-gray-600 mb-4">{{ $room->description }}</p>
                            
                            <!-- Room Features -->
                            <div class="mb-4">
                                <h4 class="font-semibold text-gray-800 mb-2">Room Features:</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($room->amenities as $amenity)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $amenity }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Capacity -->
                            <div class="flex items-center mb-4 text-gray-600">
                                <span class="mr-2">👥</span>
                                <span>Up to {{ $room->capacity }} guests</span>
                            </div>

                            <!-- Price -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="text-2xl font-bold text-blue-600">
                                    ${{ number_format($room->price_per_night, 0) }}
                                </div>
                                <div class="text-sm text-gray-500">per night</div>
                            </div>

                            <!-- Book Button -->
                            <button onclick="openBookingModal({{ $room->id }}, '{{ $room->room_type_display }}', {{ $room->price_per_night }})" 
                                    class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 px-4 rounded-lg font-semibold hover:from-green-600 hover:to-green-700 transition-all">
                                Book This Room
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <div class="text-6xl mb-4">😔</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">No Rooms Available</h3>
                    <p class="text-gray-600">All rooms are currently booked or under maintenance.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Booking Modal -->
    <div id="bookingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 max-h-screen overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Book Room</h3>
                <button onclick="closeBookingModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="bookingForm" method="POST" action="{{ route('hotels.book') }}">
                @csrf
                <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                <input type="hidden" name="room_id" id="selectedRoomId">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Room Type</label>
                        <input type="text" id="selectedRoomType" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Check-in Date</label>
                            <input type="date" name="check_in_date" required class="w-full px-3 py-2 border border-gray-300 rounded-md" min="{{ date('Y-m-d') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Check-out Date</label>
                            <input type="date" name="check_out_date" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Number of Guests</label>
                        <select name="guests" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            <option value="1">1 Guest</option>
                            <option value="2" selected>2 Guests</option>
                            <option value="3">3 Guests</option>
                            <option value="4">4 Guests</option>
                            <option value="5">5 Guests</option>
                            <option value="6">6 Guests</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Special Requests (Optional)</label>
                        <textarea name="special_requests" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Any special requests or requirements..."></textarea>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-gray-800">Total Amount:</span>
                            <span id="totalAmount" class="text-2xl font-bold text-blue-600">$0</span>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            <span id="pricePerNight">$0</span> per night × <span id="numberOfNights">0</span> nights
                        </div>
                    </div>
                </div>

                <div class="flex gap-4 mt-6">
                    <button type="button" onclick="closeBookingModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 bg-gradient-to-r from-green-500 to-green-600 text-white py-2 px-4 rounded-md font-semibold hover:from-green-600 hover:to-green-700">
                        Confirm Booking
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let selectedRoom = {};

        function openBookingModal(roomId, roomType, pricePerNight) {
            selectedRoom = { id: roomId, type: roomType, price: pricePerNight };
            
            document.getElementById('selectedRoomId').value = roomId;
            document.getElementById('selectedRoomType').value = roomType;
            document.getElementById('pricePerNight').textContent = '$' + pricePerNight;
            
            document.getElementById('bookingModal').classList.remove('hidden');
            document.getElementById('bookingModal').classList.add('flex');
            
            calculateTotal();
        }

        function closeBookingModal() {
            document.getElementById('bookingModal').classList.add('hidden');
            document.getElementById('bookingModal').classList.remove('flex');
        }

        function calculateTotal() {
            const checkIn = document.querySelector('input[name="check_in_date"]').value;
            const checkOut = document.querySelector('input[name="check_out_date"]').value;
            
            if (checkIn && checkOut) {
                const checkInDate = new Date(checkIn);
                const checkOutDate = new Date(checkOut);
                const timeDiff = checkOutDate - checkInDate;
                const daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
                
                if (daysDiff > 0) {
                    const total = daysDiff * selectedRoom.price;
                    document.getElementById('numberOfNights').textContent = daysDiff;
                    document.getElementById('totalAmount').textContent = '$' + total.toFixed(2);
                }
            }
        }

        // Add event listeners for date changes
        document.querySelector('input[name="check_in_date"]').addEventListener('change', function() {
            const checkOutInput = document.querySelector('input[name="check_out_date"]');
            checkOutInput.min = this.value;
            calculateTotal();
        });

        document.querySelector('input[name="check_out_date"]').addEventListener('change', calculateTotal);
    </script>
@endsection 
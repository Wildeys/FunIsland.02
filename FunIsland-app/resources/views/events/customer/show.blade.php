<x-tropical-layout :title="$event->name">
    <x-slot name="header">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">
                @if($event->type == 'beach_event')
                    🏖️
                @elseif($event->type == 'activity')
                    🚤
                @else
                    🎵
                @endif
                {{ $event->name }}
            </h1>
            <p class="text-xl md:text-2xl text-white/90">{{ $event->type_display }} at {{ $event->location }}</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 -mt-20 relative z-10">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 -mt-20 relative z-10">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 -mt-20 relative z-10">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Event Image -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                    @if($event->image_url)
                        <img src="{{ $event->image_url }}" alt="{{ $event->name }}" 
                             class="w-full h-96 object-cover">
                    @else
                        <div class="w-full h-96 bg-gradient-to-br from-blue-400 to-green-400 flex items-center justify-center">
                            <span class="text-8xl">
                                @if($event->type == 'beach_event')
                                    🏖️
                                @elseif($event->type == 'activity')
                                    🚤
                                @else
                                    🎵
                                @endif
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Event Description -->
                <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">About This Event</h2>
                    <p class="text-gray-600 leading-relaxed mb-6">{{ $event->description }}</p>
                    
                    @if($event->requirements)
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Requirements</h3>
                            <p class="text-gray-600">{{ $event->requirements }}</p>
                        </div>
                    @endif

                    @if($event->features && count($event->features) > 0)
                        <div class="border-t pt-6 mt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">What's Included</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                @foreach($event->features as $feature)
                                    <div class="flex items-center text-gray-600">
                                        <span class="text-green-500 mr-2">✓</span>
                                        {{ $feature }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Event Details -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Event Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="flex items-center mb-2">
                                <span class="text-2xl mr-3">📅</span>
                                <span class="font-semibold text-gray-900">Date & Time</span>
                            </div>
                            <p class="text-gray-600 ml-9">{{ $event->start_time->format('l, F j, Y') }}</p>
                            <p class="text-gray-600 ml-9">{{ $event->start_time->format('g:i A') }} - {{ $event->end_time->format('g:i A') }}</p>
                        </div>
                        
                        <div>
                            <div class="flex items-center mb-2">
                                <span class="text-2xl mr-3">⏱️</span>
                                <span class="font-semibold text-gray-900">Duration</span>
                            </div>
                            <p class="text-gray-600 ml-9">{{ $event->duration ?? 'See schedule' }}</p>
                        </div>

                        <div>
                            <div class="flex items-center mb-2">
                                <span class="text-2xl mr-3">👥</span>
                                <span class="font-semibold text-gray-900">Availability</span>
                            </div>
                            <p class="text-gray-600 ml-9">{{ $event->available_spots }} spots available</p>
                            <p class="text-gray-600 ml-9">{{ $event->capacity }} total capacity</p>
                        </div>

                        <div>
                            <div class="flex items-center mb-2">
                                <span class="text-2xl mr-3">📍</span>
                                <span class="font-semibold text-gray-900">Location</span>
                            </div>
                            <p class="text-gray-600 ml-9">{{ $event->location }}</p>
                        </div>

                        @if($event->difficulty_level)
                            <div>
                                <div class="flex items-center mb-2">
                                    <span class="text-2xl mr-3">⭐</span>
                                    <span class="font-semibold text-gray-900">Difficulty</span>
                                </div>
                                <p class="text-gray-600 ml-9">{{ ucfirst($event->difficulty_level) }}</p>
                            </div>
                        @endif

                        <div>
                            <div class="flex items-center mb-2">
                                <span class="text-2xl mr-3">🏷️</span>
                                <span class="font-semibold text-gray-900">Type</span>
                            </div>
                            <p class="text-gray-600 ml-9">{{ $event->type_display }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl p-8 sticky top-8">
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Book This Event</h2>
                        <div class="text-4xl font-bold text-green-600">${{ number_format($event->price, 2) }}</div>
                        <p class="text-gray-600">per person</p>
                        
                        <div class="mt-4 p-3 bg-yellow-50 rounded-lg">
                            <p class="text-sm text-yellow-800">
                                <span class="font-semibold">{{ $event->availability_status }}</span>
                                @if($event->available_spots <= 5 && $event->available_spots > 0)
                                    - Only {{ $event->available_spots }} spots left!
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($event->isAvailable() && $event->isUpcoming())
                        @auth
                            <form method="POST" action="{{ route('events.book', $event) }}" class="space-y-4">
                                @csrf

                                <div>
                                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Number of Participants</label>
                                    <select name="quantity" id="quantity" required 
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                        @for($i = 1; $i <= min(10, $event->available_spots); $i++)
                                            <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'Person' : 'People' }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div>
                                    <label for="special_requirements" class="block text-sm font-medium text-gray-700 mb-2">Special Requirements (Optional)</label>
                                    <textarea name="special_requirements" id="special_requirements" rows="3" 
                                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Any special requirements or dietary restrictions..."></textarea>
                                </div>

                                <div class="border-t pt-4 mt-4">
                                    <div class="flex justify-between text-lg font-semibold text-gray-900 mb-4">
                                        <span>Total:</span>
                                        <span id="total-amount">${{ number_format($event->price, 2) }}</span>
                                    </div>
                                    <button type="submit" 
                                            class="w-full bg-gradient-to-r from-blue-500 to-green-500 hover:from-blue-600 hover:to-green-600 text-white font-bold py-3 px-6 rounded-lg transition-all transform hover:scale-105">
                                        🎫 Book Now
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="text-center">
                                <p class="text-gray-600 mb-4">Please log in to book this event</p>
                                <a href="{{ route('login') }}" 
                                   class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors inline-block">
                                    Login to Book
                                </a>
                            </div>
                        @endauth
                    @elseif(!$event->isUpcoming())
                        <div class="text-center p-4 bg-gray-100 rounded-lg">
                            <p class="text-gray-600">This event has already passed</p>
                        </div>
                    @else
                        <div class="text-center p-4 bg-red-100 rounded-lg">
                            <p class="text-red-600 font-semibold">Event is sold out</p>
                        </div>
                    @endif

                    <!-- Back to Events -->
                    <div class="mt-6 pt-6 border-t">
                        <a href="{{ route('events.index') }}" 
                           class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-lg transition-colors text-center inline-block">
                            ← Back to All Events
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for dynamic total calculation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantitySelect = document.getElementById('quantity');
            const totalAmount = document.getElementById('total-amount');
            const pricePerPerson = {{ $event->price }};

            if (quantitySelect && totalAmount) {
                quantitySelect.addEventListener('change', function() {
                    const quantity = parseInt(this.value);
                    const total = quantity * pricePerPerson;
                    totalAmount.textContent = '$' + total.toFixed(2);
                });
            }
        });
    </script>
</x-tropical-layout> 
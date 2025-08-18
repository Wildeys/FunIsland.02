<x-tropical-layout :title="$themepark->name">
    <x-slot name="header">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">🎢 {{ $themepark->name }}</h1>
            <p class="text-xl md:text-2xl text-white/90">{{ $themepark->location->name ?? 'Theme Park' }}</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 -mt-20 relative z-10">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Park Image -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                    @if($themepark->image_url)
                        <img src="{{ $themepark->image_url }}" alt="{{ $themepark->name }}" 
                             class="w-full h-96 object-cover">
                    @else
                        <div class="w-full h-96 bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center">
                            <span class="text-8xl">🎢</span>
                        </div>
                    @endif
                </div>

                <!-- Park Description -->
                <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">About This Theme Park</h2>
                    <p class="text-gray-600 leading-relaxed mb-6">{{ $themepark->description }}</p>
                    
                    <!-- Park Features -->
                    @if($themepark->features)
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Park Features</h3>
                            <p class="text-gray-600">{{ $themepark->features }}</p>
                        </div>
                    @endif
                </div>

                <!-- Opening Hours & Details -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Park Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($themepark->opening_time && $themepark->closing_time)
                            <div>
                                <div class="flex items-center mb-2">
                                    <span class="text-2xl mr-3">🕒</span>
                                    <span class="font-semibold text-gray-900">Opening Hours</span>
                                </div>
                                <p class="text-gray-600 ml-9">{{ $themepark->opening_time }} - {{ $themepark->closing_time }}</p>
                            </div>
                        @endif
                        
                        <div>
                            <div class="flex items-center mb-2">
                                <span class="text-2xl mr-3">👥</span>
                                <span class="font-semibold text-gray-900">Capacity</span>
                            </div>
                            <p class="text-gray-600 ml-9">{{ number_format($themepark->capacity) }} visitors</p>
                        </div>

                        @if($themepark->rating)
                            <div>
                                <div class="flex items-center mb-2">
                                    <span class="text-2xl mr-3">⭐</span>
                                    <span class="font-semibold text-gray-900">Rating</span>
                                </div>
                                <p class="text-gray-600 ml-9">{{ $themepark->formatted_rating }}/5.0</p>
                            </div>
                        @endif

                        <div>
                            <div class="flex items-center mb-2">
                                <span class="text-2xl mr-3">📍</span>
                                <span class="font-semibold text-gray-900">Location</span>
                            </div>
                            <p class="text-gray-600 ml-9">{{ $themepark->location->name ?? 'Theme Park Location' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl p-8 sticky top-8">
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Book Your Tickets</h2>
                        <div class="text-4xl font-bold text-green-600">${{ number_format($themepark->admission_price, 2) }}</div>
                        <p class="text-gray-600">per person</p>
                    </div>

                    @auth
                        <form method="POST" action="{{ route('themeparks.book') }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="themepark_id" value="{{ $themepark->id }}">

                            <div>
                                <label for="tickets" class="block text-sm font-medium text-gray-700 mb-2">Number of Tickets</label>
                                <select name="tickets" id="tickets" required 
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500">
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'Ticket' : 'Tickets' }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div>
                                <label for="visit_date" class="block text-sm font-medium text-gray-700 mb-2">Visit Date</label>
                                <input type="date" name="visit_date" id="visit_date" required 
                                       min="{{ date('Y-m-d') }}"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500">
                            </div>

                            <div>
                                <label for="special_requests" class="block text-sm font-medium text-gray-700 mb-2">Special Requests (Optional)</label>
                                <textarea name="special_requests" id="special_requests" rows="3" 
                                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500"
                                          placeholder="Any special requirements or requests..."></textarea>
                            </div>

                            <div class="border-t pt-4 mt-4">
                                <div class="flex justify-between text-lg font-semibold text-gray-900 mb-4">
                                    <span>Total:</span>
                                    <span id="total-amount">${{ number_format($themepark->admission_price, 2) }}</span>
                                </div>
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-bold py-3 px-6 rounded-lg transition-all transform hover:scale-105">
                                    🎫 Book Now
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center">
                            <p class="text-gray-600 mb-4">Please log in to book tickets</p>
                            <a href="{{ route('login') }}" 
                               class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors inline-block">
                                Login to Book
                            </a>
                        </div>
                    @endauth

                    <!-- Back to Parks -->
                    <div class="mt-6 pt-6 border-t">
                        <a href="{{ route('themeparks.customer.index') }}" 
                           class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-lg transition-colors text-center inline-block">
                            ← Back to All Parks
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for dynamic total calculation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ticketsSelect = document.getElementById('tickets');
            const totalAmount = document.getElementById('total-amount');
            const pricePerTicket = {{ $themepark->admission_price }};

            if (ticketsSelect && totalAmount) {
                ticketsSelect.addEventListener('change', function() {
                    const tickets = parseInt(this.value);
                    const total = tickets * pricePerTicket;
                    totalAmount.textContent = '$' + total.toFixed(2);
                });
            }
        });
    </script>
</x-tropical-layout> 
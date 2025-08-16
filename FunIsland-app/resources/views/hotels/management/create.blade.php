<x-management-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Create New Hotel</h1>
                <p class="text-sm text-gray-600">Add a new hotel to the system</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('hotels.management.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                    Back to Hotels
                </a>
            </div>
        </div>
    </x-slot>

    <div class="p-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Hotel Information</h3>
                </div>
                
                <form method="POST" action="{{ route('hotels.store') }}" class="p-6 space-y-6">
                    @csrf

                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Hotel Name -->
                        <div class="md:col-span-2">
                            <x-input-label for="name" :value="__('Hotel Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" 
                                         :value="old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <!-- Location -->
                        <div>
                            <x-input-label for="location_id" :value="__('Location')" />
                            <select id="location_id" name="location_id" 
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Select a location</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('location_id')" />
                        </div>

                        <!-- Price per Night -->
                        <div>
                            <x-input-label for="price_per_night" :value="__('Price per Night ($)')" />
                            <x-text-input id="price_per_night" name="price_per_night" type="number" 
                                         step="0.01" min="0" max="9999.99"
                                         class="mt-1 block w-full" :value="old('price_per_night')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('price_per_night')" />
                        </div>

                        <!-- Status -->
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" 
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>

                        <!-- Featured -->
                        <div class="flex items-center">
                            <input id="featured" name="featured" type="checkbox" value="1" 
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                   {{ old('featured') ? 'checked' : '' }}>
                            <label for="featured" class="ml-2 block text-sm text-gray-900">
                                Featured Hotel
                            </label>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" rows="4" 
                                  class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                  placeholder="Describe the hotel, its facilities, and unique features..."
                                  required>{{ old('description') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <!-- Image URL -->
                    <div>
                        <x-input-label for="image_url" :value="__('Image URL')" />
                        <x-text-input id="image_url" name="image_url" type="url" class="mt-1 block w-full" 
                                     :value="old('image_url')" placeholder="https://example.com/hotel-image.jpg" />
                        <x-input-error class="mt-2" :messages="$errors->get('image_url')" />
                        <p class="mt-1 text-sm text-gray-500">Enter a URL for the hotel's main image</p>
                    </div>

                    <!-- Amenities -->
                    <div>
                        <x-input-label for="amenities" :value="__('Amenities')" />
                        <div class="mt-2 space-y-2">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                @php
                                    $commonAmenities = [
                                        'WiFi', 'Pool', 'Spa', 'Gym', 'Restaurant', 'Bar',
                                        'Room Service', 'Parking', 'Air Conditioning', 'Beach Access',
                                        'Conference Room', 'Concierge', 'Laundry', 'Airport Shuttle'
                                    ];
                                    $oldAmenities = old('amenities', []);
                                @endphp
                                @foreach($commonAmenities as $amenity)
                                    <div class="flex items-center">
                                        <input id="amenity_{{ $loop->index }}" name="amenities[]" type="checkbox" 
                                               value="{{ $amenity }}" 
                                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                               {{ in_array($amenity, $oldAmenities) ? 'checked' : '' }}>
                                        <label for="amenity_{{ $loop->index }}" class="ml-2 block text-sm text-gray-900">
                                            {{ $amenity }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('amenities')" />
                    </div>

                    <!-- Contact Information -->
                    <div>
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="contact_phone" :value="__('Phone')" />
                                <x-text-input id="contact_phone" name="contact_info[phone]" type="tel" 
                                             class="mt-1 block w-full" :value="old('contact_info.phone')" 
                                             placeholder="+1234567890" />
                                <x-input-error class="mt-2" :messages="$errors->get('contact_info.phone')" />
                            </div>

                            <div>
                                <x-input-label for="contact_email" :value="__('Email')" />
                                <x-text-input id="contact_email" name="contact_info[email]" type="email" 
                                             class="mt-1 block w-full" :value="old('contact_info.email')" 
                                             placeholder="hotel@example.com" />
                                <x-input-error class="mt-2" :messages="$errors->get('contact_info.email')" />
                            </div>

                            <div>
                                <x-input-label for="contact_website" :value="__('Website')" />
                                <x-text-input id="contact_website" name="contact_info[website]" type="url" 
                                             class="mt-1 block w-full" :value="old('contact_info.website')" 
                                             placeholder="https://hotelwebsite.com" />
                                <x-input-error class="mt-2" :messages="$errors->get('contact_info.website')" />
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('hotels.management.index') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-md font-medium transition-colors">
                            Cancel
                        </a>
                        <x-primary-button>
                            Create Hotel
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-management-layout>

<x-tropical-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Edit Theme Park: ') . $themepark->name }}
            </h2>
            <a href="{{ route('management.themeparks.show', $themepark) }}" 
               class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                ← Back to Park
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">🎢 Edit Theme Park Details</h3>
                </div>
                
                <form method="POST" action="{{ route('management.themeparks.update', $themepark) }}" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Basic Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Theme Park Name *</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $themepark->name) }}" required
                                       class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-green-500 focus:ring-green-500"
                                       placeholder="Adventure Island Theme Park">
                                @error('name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="location_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Location *</label>
                                <select name="location_id" id="location_id" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    <option value="">Select a location...</option>
                                    @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ old('location_id', $themepark->location_id) == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('location_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description *</label>
                                <textarea name="description" id="description" rows="4" required
                                          class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-green-500 focus:ring-green-500"
                                          placeholder="Describe the theme park, its attractions, and what makes it special...">{{ old('description', $themepark->description) }}</textarea>
                                @error('description')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Pricing & Capacity -->
                    <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Pricing & Capacity</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="admission_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Admission Price ($) *</label>
                                <input type="number" name="admission_price" id="admission_price" step="0.01" min="0" value="{{ old('admission_price', $themepark->admission_price) }}" required
                                       class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-green-500 focus:ring-green-500"
                                       placeholder="29.99">
                                @error('admission_price')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="capacity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Daily Capacity *</label>
                                <input type="number" name="capacity" id="capacity" min="1" value="{{ old('capacity', $themepark->capacity) }}" required
                                       class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-green-500 focus:ring-green-500"
                                       placeholder="2000">
                                @error('capacity')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rating (0-5)</label>
                                <input type="number" name="rating" id="rating" step="0.1" min="0" max="5" value="{{ old('rating', $themepark->rating) }}"
                                       class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-green-500 focus:ring-green-500"
                                       placeholder="4.5">
                                @error('rating')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Operating Hours -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Operating Hours</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="opening_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Opening Time</label>
                                <input type="time" name="opening_time" id="opening_time" value="{{ old('opening_time', $themepark->opening_time) }}"
                                       class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-green-500 focus:ring-green-500">
                                @error('opening_time')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="closing_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Closing Time</label>
                                <input type="time" name="closing_time" id="closing_time" value="{{ old('closing_time', $themepark->closing_time) }}"
                                       class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-green-500 focus:ring-green-500">
                                @error('closing_time')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Additional Details -->
                    <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Additional Details</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="image_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Main Image URL</label>
                                <input type="url" name="image_url" id="image_url" value="{{ old('image_url', $themepark->image_url) }}"
                                       class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-green-500 focus:ring-green-500"
                                       placeholder="https://example.com/themepark-image.jpg">
                                @error('image_url')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status *</label>
                                <select name="status" id="status" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    <option value="active" {{ old('status', $themepark->status) === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $themepark->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="maintenance" {{ old('status', $themepark->status) === 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                                </select>
                                @error('status')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="features" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Key Features</label>
                                <textarea name="features" id="features" rows="3"
                                          class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-green-500 focus:ring-green-500"
                                          placeholder="List the main attractions and features (e.g., Roller Coasters, Water Rides, Kids Zone, Food Courts...)">{{ old('features', $themepark->features) }}</textarea>
                                @error('features')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <div class="flex items-center">
                                    <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured', $themepark->featured) ? 'checked' : '' }}
                                           class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                                    <label for="featured" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Feature this theme park on the homepage
                                    </label>
                                </div>
                                @error('featured')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Status Change Warning -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Status Change Notice</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Changing the status to "Inactive" will hide this theme park from customers. Setting it to "Under Maintenance" will show a maintenance notice to visitors.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('management.themeparks.show', $themepark) }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-6 rounded-lg transition-colors">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-medium py-2 px-6 rounded-lg transition-all shadow-md hover:shadow-lg">
                            Update Theme Park
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-tropical-layout> 
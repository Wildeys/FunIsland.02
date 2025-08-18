<x-guest-layout>
    <!-- Header Section -->
    <div class="mb-6 text-center">
        <div class="flex items-center justify-center mb-4">
            <div class="w-16 h-16 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full flex items-center justify-center mr-4">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Join Fun<span class="text-blue-600">Island</span></h1>
                <p class="text-gray-600">Create your account and start your island adventure!</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Account Type Selection -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">I want to:</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-blue-500">
                    <input type="radio" name="account_type" value="customer" class="sr-only" checked onchange="updateRoleSelection('customer')">
                    <span class="flex flex-1">
                        <span class="flex flex-col">
                            <span class="block text-sm font-medium text-gray-900">🏖️ Book Vacations</span>
                            <span class="mt-1 flex items-center text-sm text-gray-500">Experience island paradise</span>
                        </span>
                    </span>
                    <svg class="h-5 w-5 text-blue-600 hidden" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </label>
            </div>
        </div>

        <!-- Business Role Selection (Hidden by default) -->

        <!-- Hidden role field for customers -->
        <input type="hidden" name="customer_role" value="customer">

        <!-- Personal Information -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Full Name -->
            <div>
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" 
                              class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                              type="text" 
                              name="name" 
                              :value="old('name')" 
                              required 
                              autofocus 
                              autocomplete="name"
                              placeholder="Enter your full name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email Address')" />
                <x-text-input id="email" 
                              class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                              type="email" 
                              name="email" 
                              :value="old('email')" 
                              required 
                              autocomplete="username"
                              placeholder="your@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>

        <!-- Password Fields -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" 
                              class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                              type="password"
                              name="password"
                              required 
                              autocomplete="new-password"
                              placeholder="Create a secure password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                <p class="mt-1 text-sm text-gray-500">Minimum 8 characters</p>
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" 
                              class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                              type="password"
                              name="password_confirmation" 
                              required 
                              autocomplete="new-password"
                              placeholder="Confirm your password" />
            </div>
        </div>

        <!-- Terms and Privacy -->
        <div class="flex items-start">
            <div class="flex items-center h-5">
                <input id="terms" 
                       name="terms" 
                       type="checkbox" 
                       required
                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
            </div>
            <div class="ml-3 text-sm">
                <label for="terms" class="font-medium text-gray-700">
                    I agree to the 
                    <a href="#" class="text-blue-600 hover:text-blue-500">Terms of Service</a> 
                    and 
                    <a href="#" class="text-blue-600 hover:text-blue-500">Privacy Policy</a>
                </label>
            </div>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" 
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                Create My Account
            </button>
        </div>

        <!-- Login Link -->
        <div class="text-center">
            <p class="text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
                    Sign in here
                </a>
            </p>
        </div>
    </form>

    <!-- Features Section -->
    <div class="mt-8 pt-8 border-t border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 text-center">Join thousands of happy islanders!</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
            <div>
                <div class="text-2xl mb-2">🏨</div>
                <p class="text-sm text-gray-600">Luxury hotel bookings</p>
            </div>
            <div>
                <div class="text-2xl mb-2">🚤</div>
                <p class="text-sm text-gray-600">Easy ferry transfers</p>
            </div>
            <div>
                <div class="text-2xl mb-2">🎢</div>
                <p class="text-sm text-gray-600">Theme park adventures</p>
            </div>
        </div>
    </div>

    <script>
        function updateRoleSelection(type) {
            const businessRoles = document.getElementById('business-roles');
            const roleSelect = document.getElementById('role');
            
            if (type === 'business') {
                businessRoles.classList.remove('hidden');
                roleSelect.required = true;
            } else {
                businessRoles.classList.add('hidden');
                roleSelect.required = false;
            }
            
            // Update radio button visual state
            document.querySelectorAll('input[name="account_type"]').forEach(radio => {
                const checkIcon = radio.parentElement.querySelector('svg');
                if (radio.checked) {
                    checkIcon.classList.remove('hidden');
                    radio.parentElement.classList.add('ring-2', 'ring-blue-500', 'border-blue-500');
                } else {
                    checkIcon.classList.add('hidden');
                    radio.parentElement.classList.remove('ring-2', 'ring-blue-500', 'border-blue-500');
                }
            });
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateRoleSelection('customer');
            
            // Add change listeners
            document.querySelectorAll('input[name="account_type"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    updateRoleSelection(this.value);
                });
            });
        });
    </script>
</x-guest-layout>
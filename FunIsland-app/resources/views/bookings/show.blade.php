@php
    // Dynamically choose layout based on user role
    $user = auth()->user();
    $isManagement = $user->isAdministrator() || 
                    $user->canManageHotels() || 
                    $user->canManageFerries() || 
                    $user->canManageThemeParks() || 
                    $user->canManageTicketing();
@endphp

@if($isManagement)
    <x-management-layout>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Booking Details') }} - {{ ucfirst($booking->booking_type) }}
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">
                        Managing booking #{{ $booking->booking_reference }}
                    </p>
                </div>
                @if(
                    $user->isAdministrator() || 
                    ($user->canManageHotels() && $booking->booking_type === 'hotel') ||
                    ($user->canManageFerries() && $booking->booking_type === 'ferry') ||
                    ($user->canManageThemeParks() && $booking->booking_type === 'themepark')
                )
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">Management View</span>
                    <!-- Gear Icon -->
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0..."></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                @endif
            </div>
        </x-slot>

        {{-- Main Content --}}
        @include('bookings.partials.details')

    </x-management-layout>
@else
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Booking Details') }}
            </h2>
        </x-slot>

        {{-- Main Content --}}
        @include('bookings.partials.details')

    </x-app-layout>
@endif

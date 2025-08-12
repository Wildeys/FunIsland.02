<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FunIsland') }} - {{ $title ?? 'Your Island Paradise' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .tropical-gradient {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            .ocean-gradient {
                background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
            }
            .beach-gradient {
                background: linear-gradient(135deg, #fdcb6e 0%, #e17055 100%);
            }
            .palm-shadow {
                background: linear-gradient(45deg, transparent 40%, rgba(46, 160, 67, 0.1) 60%);
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-white to-green-50">
        <!-- Navigation -->
        <nav class="bg-white/90 backdrop-blur-sm shadow-lg border-b border-blue-100 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo and Main Navigation -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <a href="{{ route('dashboard') }}" class="flex items-center">
                                <div class="w-10 h-10 ocean-gradient rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                </div>
                                <span class="text-2xl font-bold text-gray-800">Fun<span class="text-blue-600">Island</span></span>
                            </a>
                        </div>

                        <!-- Desktop Navigation -->
                        <div class="hidden md:ml-10 md:flex md:space-x-8">
                            <a href="{{ auth()->check() ? route('hotels.index') : route('browse.hotels') }}" 
                               class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('hotels.*') || request()->routeIs('browse.hotels') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }} transition-colors">
                                🏨 Hotels
                            </a>
                            <a href="{{ auth()->check() ? route('ferries.index') : route('browse.ferries') }}" 
                               class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('ferries.*') || request()->routeIs('browse.ferries') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }} transition-colors">
                                🚤 Ferries
                            </a>
                            <a href="{{ auth()->check() ? route('themeparks.index') : route('browse.themeparks') }}" 
                               class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('themeparks.*') || request()->routeIs('browse.themeparks') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }} transition-colors">
                                🎢 Theme Parks
                            </a>
                            <a href="{{ auth()->check() ? route('events.index') : route('browse.events') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('events.*') || request()->routeIs('browse.events') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }} transition-colors">
                                🏖️ Beach Events
                            </a>
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="flex items-center space-x-4">
                        @auth
                            <!-- My Bookings -->
                            <a href="{{ route('bookings.my') }}" 
                               class="flex items-center text-gray-700 hover:text-blue-600 transition-colors">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="hidden sm:inline">My Bookings</span>
                            </a>

                            <!-- User Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" 
                                        class="flex items-center text-gray-700 hover:text-blue-600 transition-colors">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mr-2">
                                        <span class="text-white text-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                    <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <div x-show="open" @click.away="open = false" 
                                     class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5">
                                    <a href="{{ route('profile.edit') }}" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Profile Settings
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Sign Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" 
                               class="text-gray-700 hover:text-blue-600 transition-colors">
                                Log in
                            </a>
                            <a href="{{ route('register') }}" 
                               class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-full hover:from-blue-600 hover:to-blue-700 transition-all transform hover:scale-105">
                                Sign up
                            </a>
                        @endauth

                        <!-- Mobile menu button -->
                        <button class="md:hidden" 
                                x-data="{ open: false }" 
                                @click="open = !open">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Navigation -->
                <div x-show="open" 
                     x-data="{ open: false }" 
                     class="md:hidden bg-white border-t border-gray-200">
                    <div class="px-2 pt-2 pb-3 space-y-1">
                        <a href="{{ auth()->check() ? route('hotels.index') : route('browse.hotels') }}" 
                           class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50">
                            🏨 Hotels
                        </a>
                        <a href="{{ auth()->check() ? route('ferries.index') : route('browse.ferries') }}" 
                           class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50">
                            🚤 Ferries
                        </a>
                        <a href="{{ auth()->check() ? route('themeparks.index') : route('browse.themeparks') }}" 
                           class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50">
                            🎢 Theme Parks
                        </a>
                        <a href="{{ auth()->check() ? route('events.index') : route('browse.events') }}" 
                           class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50">
                            🏖️ Beach Events
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Header -->
        @isset($header)
            <header class="tropical-gradient py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        {{ $header }}
                    </div>
                </div>
            </header>
        @endisset

        <!-- Main Content -->
        <main class="min-h-screen">
            @if (session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Main Content -->
            @isset($slot)
                {{ $slot }}
            @else
                @yield('content')
            @endisset
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 ocean-gradient rounded-full flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            </div>
                            <span class="text-2xl font-bold">Fun<span class="text-blue-400">Island</span></span>
                        </div>
                        <p class="text-gray-300 mb-4">
                            Your gateway to the ultimate island experience. From luxury hotels to thrilling theme parks, 
                            we make your tropical dreams come true.
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('hotels.index') }}" class="text-gray-300 hover:text-white transition-colors">Hotels</a></li>
                            <li><a href="{{ route('ferries.index') }}" class="text-gray-300 hover:text-white transition-colors">Ferries</a></li>
                            <li><a href="{{ route('themeparks.index') }}" class="text-gray-300 hover:text-white transition-colors">Theme Parks</a></li>
                            <li><a href="" class="text-gray-300 hover:text-white transition-colors">Beach Events</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Contact</h3>
                        <ul class="space-y-2 text-gray-300">
                            <li>📧 info@funisland.com</li>
                            <li>📞 +1 (555) 123-4567</li>
                            <li>📍 Paradise Island, Caribbean</li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                    <p class="text-gray-300">© {{ date('Y') }} FunIsland. All rights reserved. 🌴</p>
                </div>
            </div>
        </footer>

        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    </body>
</html>
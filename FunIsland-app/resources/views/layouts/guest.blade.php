<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FunIsland') }} - {{ $title ?? 'Island Paradise Awaits' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .tropical-gradient {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            .ocean-wave {
                background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
            }
            .palm-shadow {
                background: radial-gradient(ellipse at center, rgba(255,255,255,0.1) 0%, transparent 70%);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <!-- Background with Island Theme -->
        <div class="min-h-screen relative overflow-hidden">
            <!-- Animated Background -->
            <div class="absolute inset-0 tropical-gradient"></div>
            
            <!-- Decorative Elements -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
                <!-- Palm Trees -->
                <div class="absolute top-10 left-10 text-6xl opacity-20 transform rotate-12">🌴</div>
                <div class="absolute top-32 right-16 text-4xl opacity-15 transform -rotate-12">🌺</div>
                <div class="absolute bottom-20 left-20 text-5xl opacity-20">🏖️</div>
                <div class="absolute bottom-32 right-10 text-4xl opacity-15 transform rotate-45">⭐</div>
                
                <!-- Floating Islands -->
                <div class="absolute top-1/4 right-1/4 w-32 h-16 palm-shadow rounded-full opacity-10"></div>
                <div class="absolute bottom-1/3 left-1/4 w-24 h-12 palm-shadow rounded-full opacity-10"></div>
            </div>

            <!-- Main Content -->
            <div class="relative z-10 min-h-screen flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8">
                <!-- Logo Section -->
                <div class="mb-8 text-center">
                    <a href="/" class="inline-block">
                        <div class="flex items-center justify-center">
                            <div class="w-16 h-16 ocean-wave rounded-full flex items-center justify-center mr-4 shadow-xl">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-4xl font-bold text-white">Fun<span class="text-yellow-300">Island</span></h1>
                                <p class="text-white/80 text-sm">Your Island Paradise Awaits</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Auth Form Container -->
                <div class="w-full max-w-md sm:max-w-lg lg:max-w-xl">
                    <div class="bg-white/95 backdrop-blur-sm shadow-2xl rounded-2xl px-8 py-10 border border-white/20">
                        
                    </div>
                </div>

                <!-- Footer Links -->
                <div class="mt-8 text-center">
                    <div class="flex items-center justify-center space-x-6 text-white/80 text-sm">
                        <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                        <span>•</span>
                        <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                        <span>•</span>
                        <a href="#" class="hover:text-white transition-colors">Help</a>
                    </div>
                    <p class="mt-4 text-white/60 text-xs">
                        © {{ date('Y') }} FunIsland. Your dream vacation starts here. 🌴
                    </p>
                </div>
            </div>

            <!-- Floating Animation Elements -->
            <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden">
                <div class="absolute animate-bounce delay-1000" style="top: 20%; left: 10%; animation-duration: 3s;">
                    <span class="text-2xl opacity-30">🐚</span>
                </div>
                <div class="absolute animate-pulse delay-2000" style="top: 60%; right: 15%; animation-duration: 4s;">
                    <span class="text-xl opacity-20">🌊</span>
                </div>
                <div class="absolute animate-bounce delay-500" style="bottom: 30%; left: 70%; animation-duration: 3.5s;">
                    <span class="text-lg opacity-25">🦋</span>
                </div>
            </div>
        </div>
    </body>
</html>
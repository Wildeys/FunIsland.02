<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div>
        <h1>Welcome, {{ Auth::user()->name }}!</h1>
        <p>Your role: {{ Auth::user()->role }}</p>
    </div>
</x-app-layout>

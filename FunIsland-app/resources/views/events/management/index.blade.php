<x-management-layout title="Event Management">
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Event Management
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">Manage events, shows, and entertainment bookings</p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <a href="{{ route('management.events.create') }}" 
                       class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                        Add New Event
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($events as $event)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="h-32 bg-gradient-to-br from-red-400 to-orange-600 flex items-center justify-center">
                            <span class="text-4xl">
                                @if($event->type === 'concert') 🎵
                                @elseif($event->type === 'show') 🎭
                                @elseif($event->type === 'cultural') 🎨
                                @elseif($event->type === 'sports') ⚽
                                @else 🎪
                                @endif
                            </span>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $event->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($event->description ?? 'Exciting entertainment event', 100) }}</p>
                            
                            <div class="space-y-2 text-sm text-gray-500 mb-4">
                                <div>📍 {{ $event->venue ?? 'Paradise Theater' }}</div>
                                <div>📅 {{ $event->event_date ? $event->event_date->format('M d, Y') : 'TBD' }}</div>
                                <div>🎫 {{ $event->available_seats ?? 'Limited' }} seats</div>
                                <div>💰 
                                    @if($event->price == 0)
                                        Free Event
                                    @else
                                        ${{ number_format($event->price ?? 25, 2) }}
                                    @endif
                                </div>
                            </div>

                            <div class="flex space-x-2">
                                <a href="{{ route('management.events.show', $event->id) }}" 
                                   class="flex-1 bg-blue-600 text-white text-center py-2 px-3 rounded text-sm hover:bg-blue-700">
                                    View
                                </a>
                                <a href="{{ route('management.events.edit', $event->id) }}" 
                                   class="flex-1 bg-gray-600 text-white text-center py-2 px-3 rounded text-sm hover:bg-gray-700">
                                    Edit
                                </a>
                                <a href="{{ route('management.events.bookings', $event->id) }}" 
                                   class="flex-1 bg-green-600 text-white text-center py-2 px-3 rounded text-sm hover:bg-green-700">
                                    Bookings
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-white rounded-lg shadow">
                        <span class="text-6xl block mb-4">🎪</span>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No events found</h3>
                        <p class="text-gray-500 mb-4">Get started by adding your first event</p>
                        <a href="{{ route('management.events.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                            Add Event
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-management-layout> 
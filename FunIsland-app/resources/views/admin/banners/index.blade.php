<x-management-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Advertisement Banners</h1>
                <p class="text-sm text-gray-600">Manage homepage advertisement banners</p>
            </div>
            <a href="{{ route('admin.banners.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New Banner
            </a>
        </div>
    </x-slot>

    <div class="p-6">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($banners->count() > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200">
                    @foreach($banners as $banner)
                    <li>
                        <div class="px-4 py-4 flex items-center justify-between">
                            <div class="flex items-center min-w-0 flex-1">
                                <!-- Banner Image Thumbnail -->
                                <div class="flex-shrink-0 h-16 w-24">
                                    <img class="h-16 w-24 object-cover rounded-lg shadow-sm" 
                                         src="{{ $banner->image_url }}" 
                                         alt="{{ $banner->title }}">
                                </div>

                                <!-- Banner Info -->
                                <div class="min-w-0 flex-1 px-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900 truncate">
                                                {{ $banner->title }}
                                            </h3>
                                            @if($banner->description)
                                                <p class="text-sm text-gray-500 truncate">{{ $banner->description }}</p>
                                            @endif
                                            @if($banner->link_url)
                                                <a href="{{ $banner->link_url }}" target="_blank" 
                                                   class="text-sm text-blue-600 hover:text-blue-800">
                                                    {{ $banner->link_url }}
                                                </a>
                                            @endif
                                        </div>
                                        
                                        <!-- Status Badge -->
                                        <div class="flex flex-col items-end space-y-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $banner->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $banner->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                            
                                            @if($banner->starts_at || $banner->ends_at)
                                                <div class="text-xs text-gray-500">
                                                    @if($banner->starts_at)
                                                        <div>Starts: {{ $banner->starts_at->format('M d, Y') }}</div>
                                                    @endif
                                                    @if($banner->ends_at)
                                                        <div>Ends: {{ $banner->ends_at->format('M d, Y') }}</div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center space-x-2">
                                <!-- Toggle Active Status -->
                                <form method="POST" action="{{ route('admin.banners.toggle', $banner) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md 
                                            {{ $banner->is_active ? 'text-gray-700 bg-gray-100 hover:bg-gray-200' : 'text-green-700 bg-green-100 hover:bg-green-200' }} 
                                            transition-colors">
                                        {{ $banner->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>

                                <!-- Edit Button -->
                                <a href="{{ route('admin.banners.edit', $banner) }}" 
                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 transition-colors">
                                    Edit
                                </a>

                                <!-- Delete Button -->
                                <form method="POST" action="{{ route('admin.banners.destroy', $banner) }}" class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this banner? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 transition-colors">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No banners</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new advertisement banner.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.banners.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        New Banner
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-management-layout> 
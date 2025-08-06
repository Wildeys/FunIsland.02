<x-management-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-900">Role Assignment</h1>
    </x-slot>

    <div class="p-6">
        <!-- Role Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @foreach($roles as $role)
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 rounded-md flex items-center justify-center
                                @if($role->name === 'administrator') bg-red-500
                                @elseif($role->name === 'hotel_manager') bg-purple-500
                                @elseif($role->name === 'ferry_operator') bg-blue-500
                                @elseif($role->name === 'theme_park_manager') bg-green-500
                                @elseif($role->name === 'ticketing_staff') bg-yellow-500
                                @elseif($role->name === 'customer') bg-gray-500
                                @else bg-indigo-500
                                @endif">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($role->name === 'administrator')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    @elseif($role->name === 'hotel_manager')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    @elseif($role->name === 'customer')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    @endif
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">{{ $role->display_name }}</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $role->users_count }} users</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <span class="text-gray-500">{{ $role->description }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Bulk Role Assignment -->
        <div class="bg-white shadow rounded-lg mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Bulk Role Assignment</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Assign roles to multiple users at once. Changes are saved automatically.
                </p>
            </div>

            <form method="POST" action="{{ route('admin.roles.assign') }}" class="p-6">
                @csrf
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Current Role
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Assign New Role
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
                                                <span class="text-white font-medium text-sm">{{ substr($user->name, 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->role)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($user->role->name === 'administrator') bg-red-100 text-red-800
                                        @elseif($user->role->name === 'hotel_manager') bg-purple-100 text-purple-800
                                        @elseif($user->role->name === 'ferry_operator') bg-blue-100 text-blue-800
                                        @elseif($user->role->name === 'theme_park_manager') bg-green-100 text-green-800
                                        @elseif($user->role->name === 'customer') bg-gray-100 text-gray-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ $user->role->display_name }}
                                    </span>
                                    @else
                                    <span class="text-sm text-gray-500">No role</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select name="user_roles[{{ $user->id }}]" 
                                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                {{ $role->display_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->email_verified_at)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex items-center justify-end">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        Save Role Assignments
                    </button>
                </div>
            </form>
        </div>

        <!-- Role Permissions Reference -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Role Permissions Reference</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Overview of what each role can access in the system.
                </p>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Administrator -->
                    <div class="border border-red-200 rounded-lg p-4">
                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <h4 class="ml-3 text-lg font-medium text-gray-900">Administrator</h4>
                        </div>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Full system access and control</li>
                            <li>• User management and role assignment</li>
                            <li>• System configuration and settings</li>
                            <li>• Access to all management dashboards</li>
                            <li>• Override permissions for all operations</li>
                        </ul>
                    </div>

                    <!-- Hotel Manager -->
                    <div class="border border-purple-200 rounded-lg p-4">
                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <h4 class="ml-3 text-lg font-medium text-gray-900">Hotel Manager</h4>
                        </div>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Create and manage hotel properties</li>
                            <li>• Manage hotel rooms and amenities</li>
                            <li>• View and process hotel bookings</li>
                            <li>• Access hotel management dashboard</li>
                            <li>• Upload and manage hotel images</li>
                        </ul>
                    </div>

                    <!-- Ferry Operator -->
                    <div class="border border-blue-200 rounded-lg p-4">
                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                                </svg>
                            </div>
                            <h4 class="ml-3 text-lg font-medium text-gray-900">Ferry Operator</h4>
                        </div>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Manage ferry schedules and routes</li>
                            <li>• Set ferry pricing and capacity</li>
                            <li>• Process ferry ticket bookings</li>
                            <li>• Access ferry operations dashboard</li>
                            <li>• Monitor passenger manifests</li>
                        </ul>
                    </div>

                    <!-- Customer -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 bg-gray-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h4 class="ml-3 text-lg font-medium text-gray-900">Customer</h4>
                        </div>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Browse and book hotel accommodations</li>
                            <li>• Purchase ferry tickets and theme park passes</li>
                            <li>• Register for beach events and activities</li>
                            <li>• View personal booking history</li>
                            <li>• Manage profile and preferences</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-management-layout>
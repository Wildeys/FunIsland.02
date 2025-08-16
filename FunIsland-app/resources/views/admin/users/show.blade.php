<x-management-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.users') }}" 
                   class="text-gray-500 hover:text-gray-700 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">User Profile</h1>
                    <p class="text-sm text-gray-600">{{ $user->role->display_name ?? 'No Role' }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.users.edit', $user) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                    Edit User
                </a>
            </div>
        </div>
    </x-slot>

    <div class="p-6">
        <div class="max-w-4xl mx-auto">
            <!-- Profile Card -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-8">
                    <div class="flex items-start space-x-6">
                        <!-- Profile Image -->
                        <div class="flex-shrink-0">
                            <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center">
                                @if($user->profile_image)
                                    <img src="{{ asset('storage/' . $user->profile_image) }}" 
                                         alt="{{ $user->name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-blue-500 flex items-center justify-center">
                                        <span class="text-white text-3xl font-bold">
                                            {{ substr($user->name, 0, 1) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- User Details -->
                        <div class="flex-1">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Full Name</label>
                                    <div class="mt-1 text-lg font-semibold text-gray-900">{{ $user->name }}</div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Email Address</label>
                                    <div class="mt-1 text-lg text-gray-900">{{ $user->email }}</div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Role</label>
                                    <div class="mt-1">
                                        @if($user->role)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                {{ $user->role->display_name }}
                                            </span>
                                        @else
                                            <span class="text-gray-500">No role assigned</span>
                                        @endif
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Status</label>
                                    <div class="mt-1">
                                        @if($user->email_verified_at)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                Pending Verification
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Member Since</label>
                                    <div class="mt-1 text-gray-900">{{ $user->created_at->format('F d, Y') }}</div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Last Updated</label>
                                    <div class="mt-1 text-gray-900">{{ $user->updated_at->format('F d, Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-gray-50 px-6 py-4 flex justify-between items-center">
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.users.edit', $user) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            Edit Profile
                        </a>
                        @if($user->id !== auth()->id())
                            <button onclick="confirmDelete({{ $user->id }})" 
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Delete User
                            </button>
                        @endif
                    </div>
                    <div class="text-sm text-gray-500">
                        User ID: {{ $user->id }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg font-medium text-gray-900">Delete User</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Are you sure you want to delete this user? This action cannot be undone.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <form id="deleteForm" method="POST" action="" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md mr-2 hover:bg-red-600">
                            Delete
                        </button>
                    </form>
                    <button onclick="closeModal()" 
                            class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md hover:bg-gray-600">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(userId) {
            document.getElementById('deleteForm').action = `/admin/users/${userId}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
</x-management-layout>
<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Hotel;
use App\Models\Ferry;
use App\Models\ThemePark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:administrator');
    }

    /**
     * System overview dashboard
     */
    public function overview()
    {
        $stats = [
            'total_users' => User::count(),
            'total_customers' => User::whereHas('role', function($q) {
                $q->where('name', 'customer');
            })->count(),
            'total_managers' => User::whereHas('role', function($q) {
                $q->whereIn('name', ['hotel_manager', 'ferry_operator', 'theme_park_manager']);
            })->count(),
            'total_hotels' => Hotel::count(),
            'total_ferries' => Ferry::count(),
            'total_themeparks' => ThemePark::count(),
            'recent_users' => User::with('role')->latest()->take(5)->get(),
            'user_roles' => Role::withCount('users')->get()
        ];

        return view('admin.overview', compact('stats'));
    }

    /**
     * User management index
     */
    public function users(Request $request)
    {
        $query = User::with('role');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->filled('role')) {
            $query->whereHas('role', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        $users = $query->paginate(15);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show user details
     */
    public function showUser(User $user)
    {
        $user->load('role');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show create user form
     */
    public function createUser()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store new user
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'User created successfully!');
    }

    /**
     * Show edit user form
     */
    public function editUser(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Delete user
     */
    public function destroyUser(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')
                ->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'User deleted successfully!');
    }

    /**
     * Role assignment page
     */
    public function roleAssignment()
    {
        $roles = Role::withCount('users')->get();
        $users = User::with('role')->get();
        
        return view('admin.roles', compact('roles', 'users'));
    }

    /**
     * Bulk role assignment
     */
    public function assignRoles(Request $request)
    {
        $request->validate([
            'user_roles' => 'required|array',
            'user_roles.*' => 'exists:roles,id'
        ]);

        foreach ($request->user_roles as $userId => $roleId) {
            User::find($userId)->update(['role_id' => $roleId]);
        }

        return redirect()->route('admin.roles')
            ->with('success', 'Roles assigned successfully!');
    }

    /**
     * System settings
     */
    public function settings()
    {
        return view('admin.settings');
    }
}
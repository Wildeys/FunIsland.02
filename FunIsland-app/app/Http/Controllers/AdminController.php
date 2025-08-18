<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\hotel;
use App\Models\ferry;
use App\Models\themepark;
use App\Models\Booking;
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
     * Admin dashboard - redirects to overview
     */
    public function dashboard()
    {
        return $this->overview();
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
            'total_hotels' => hotel::count(),
            'total_ferries' => ferry::count(),
            'total_themeparks' => themepark::count(),
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
            'total_revenue' => Booking::where('payment_status', 'paid')->sum('total_amount'),
            'recent_users' => User::with('role')->latest()->take(5)->get(),
            'recent_bookings' => Booking::with(['user', 'hotel', 'ferry', 'themepark'])->latest()->take(5)->get(),
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
    public function roles()
    {
        $roles = Role::withCount('users')->get();
        $users = User::with('role')->get();
        
        return view('admin.roles', compact('roles', 'users'));
    }

    /**
     * System settings
     */
    public function settings()
    {
        return view('admin.settings');
    }

    /**
     * Booking management index - accessible to admin and hotel managers
     */
    public function bookings(Request $request)
    {
        // Check if user can manage bookings (admin or hotel manager)
        if (!auth()->user()->isAdministrator() && !auth()->user()->isHotelManager()) {
            abort(403, 'Unauthorized access to booking management.');
        }

        $query = Booking::with(['user', 'hotel', 'room', 'ferry', 'event', 'themepark']);

        // If hotel manager, only show hotel bookings
        if (auth()->user()->isHotelManager() && !auth()->user()->isAdministrator()) {
            $query->whereNotNull('hotel_id');
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('booking_reference', 'like', "%{$search}%")
                  ->orWhereHas('user', function($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%")
                           ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Booking type filter
        if ($request->filled('booking_type')) {
            $query->where('booking_type', $request->booking_type);
        }

        // Payment status filter
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('booked_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('booked_at', '<=', $request->date_to);
        }

        $bookings = $query->orderBy('booked_at', 'desc')->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show booking details
     */
    public function showBooking(Booking $booking)
    {
        // Check if user can view this booking
        if (!auth()->user()->isAdministrator() && !auth()->user()->isHotelManager()) {
            abort(403, 'Unauthorized access.');
        }

        // If hotel manager, only allow viewing hotel bookings
        if (auth()->user()->isHotelManager() && !auth()->user()->isAdministrator() && !$booking->hotel_id) {
            abort(403, 'Unauthorized access to this booking.');
        }

        $booking->load(['user', 'hotel', 'room', 'ferry', 'event', 'themepark']);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show edit booking form
     */
    public function editBooking(Booking $booking)
    {
        // Check if user can edit this booking
        if (!auth()->user()->isAdministrator() && !auth()->user()->isHotelManager()) {
            abort(403, 'Unauthorized access.');
        }

        // If hotel manager, only allow editing hotel bookings
        if (auth()->user()->isHotelManager() && !auth()->user()->isAdministrator() && !$booking->hotel_id) {
            abort(403, 'Unauthorized access to this booking.');
        }

        $booking->load(['user', 'hotel', 'room', 'ferry', 'event', 'themepark']);
        return view('admin.bookings.edit', compact('booking'));
    }

    /**
     * Update booking
     */
    public function updateBooking(Request $request, Booking $booking)
    {
        // Check if user can update this booking
        if (!auth()->user()->isAdministrator() && !auth()->user()->isHotelManager()) {
            abort(403, 'Unauthorized access.');
        }

        // If hotel manager, only allow updating hotel bookings
        if (auth()->user()->isHotelManager() && !auth()->user()->isAdministrator() && !$booking->hotel_id) {
            abort(403, 'Unauthorized access to this booking.');
        }

        $request->validate([
            'status' => ['required', 'in:pending,confirmed,cancelled,completed'],
            'payment_status' => ['required', 'in:pending,paid,refunded'],
            'special_requests' => ['nullable', 'string', 'max:1000'],
            'total_amount' => ['required', 'numeric', 'min:0'],
        ]);

        $booking->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
            'special_requests' => $request->special_requests,
            'total_amount' => $request->total_amount,
        ]);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Booking updated successfully!');
    }

    /**
     * Cancel booking
     */
    public function cancelBooking(Booking $booking)
    {
        // Check if user can cancel this booking
        if (!auth()->user()->isAdministrator() && !auth()->user()->isHotelManager()) {
            abort(403, 'Unauthorized access.');
        }

        // If hotel manager, only allow canceling hotel bookings
        if (auth()->user()->isHotelManager() && !auth()->user()->isAdministrator() && !$booking->hotel_id) {
            abort(403, 'Unauthorized access to this booking.');
        }

        $booking->update([
            'status' => 'cancelled',
            'payment_status' => $booking->payment_status === 'paid' ? 'refunded' : $booking->payment_status
        ]);

        return redirect()->route('admin.bookings')
            ->with('success', 'Booking cancelled successfully!');
    }
}
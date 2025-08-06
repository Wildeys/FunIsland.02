<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'account_type' => ['required', 'in:customer,business'],
            'role' => ['required_if:account_type,business', 'in:hotel_manager,ferry_operator,theme_park_manager,ticketing_staff'],
            'terms' => ['accepted'],
        ]);

        // Determine the role based on account type
        if ($request->account_type === 'customer') {
            $role = Role::where('name', 'customer')->first();
        } else {
            $role = Role::where('name', $request->role)->first();
        }

        if (!$role) {
            // Fallback to customer role if role not found
            $role = Role::where('name', 'customer')->first();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect based on role
        if ($user->isAdministrator()) {
            return redirect(route('admin.overview'));
        } elseif ($user->canManageHotels()) {
            return redirect(route('hotels.dashboard'));
        } elseif ($user->canManageFerries()) {
            return redirect(route('ferries.dashboard'));
        } elseif ($user->canManageThemeParks()) {
            return redirect(route('themeparks.dashboard'));
        } else {
            return redirect(route('dashboard'));
        }
    }
}

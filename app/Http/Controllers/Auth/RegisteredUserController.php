<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Notifications\UserCreated;

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
            'terms' => ['accepted'],
            'privacy' => ['accepted'],
            'age_confirmation' => ['accepted'],
        ], [
            'terms.accepted' => 'You must accept the Terms of service.',
            'privacy.accepted' => 'You must accept the Privacy policy.',
            'age_confirmation.accepted' => 'You must confirm that you are 16 or older, or that a parent or guardian consents on your behalf.',
        ]);

        $now = now();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'patient',
            'terms_accepted_at' => $now,
            'privacy_accepted_at' => $now,
            'age_confirmed_at' => $now,
        ]);

        event(new Registered($user));

        // Notify all admins about new user registration
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new UserCreated($user));
        }

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}

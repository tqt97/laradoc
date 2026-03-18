<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User; // Import User model
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        // Re-fetch the user and clear roles cache to ensure fresh data is loaded
        if ($user) {
            $freshUser = $user->fresh(); // Fetch fresh user with relationships
            if ($freshUser->hasRole('super-admin')) {
                $freshUser->forgetCachedRoles(); // Clear Spatie's role cache for the user
                Log::info("Super admin logged in, roles cache cleared: {$freshUser->email}");
            }
            // Re-authenticate with the fresh user model
            Auth::login($freshUser);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

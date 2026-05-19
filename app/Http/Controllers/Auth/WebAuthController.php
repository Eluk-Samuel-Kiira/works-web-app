<?php

namespace App\Http\Controllers\Auth;

// ============================================================
// works-web  →  app/Http/Controllers/Auth/WebAuthController.php
//
// This is a NEW controller that lives only in works-web.
// It handles the magic link click, calls works-main to verify,
// and creates a local session for the user.
// ============================================================

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Http, Log, Session};

class WebAuthController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    // GET /auth/magic/{token}
    // The user clicked the link in their email.
    // We call works-main to verify, then create a local session.
    // ─────────────────────────────────────────────────────────────────────────
    public function authenticate(Request $request, string $token)
    {
        // Check if user is already logged in
        if (session()->has('web_user')) {
            $user = session('web_user');
            
            return redirect()->route('seeker.dashboard')
                ->with('info', 'You are already logged in as ' . $user['first_name'] . '.');
        }
        
        $mainApi = rtrim(config('api.main_app.api_base'), '/');

        try {
            $response = Http::withoutVerifying()
                ->timeout(15)
                ->post($mainApi . '/auth/verify-token', ['token' => $token]);

            if (!$response->successful()) {
                $message = $response->json('message', 'This link is invalid or has expired.');
                return redirect()->route('home.welcome')
                    ->with('error', $message);
            }

            $userData = $response->json('user');

            // ── Create a local session for this user ──────────────────────
            Session::regenerate();

            Session::put('web_user', [
                'id'           => $userData['id'],
                'uuid'         => $userData['uuid'],
                'email'        => $userData['email'],
                'first_name'   => $userData['first_name'],
                'last_name'    => $userData['last_name'],
                'full_name'    => $userData['full_name'],
                'phone'        => $userData['phone'],
                'role'         => $userData['role'],
                'role_id'      => $userData['role_id'],
                'country_code' => $userData['country_code'],
            ]);

            Session::put('web_user_logged_in_at', now()->toISOString());

            Log::info('Web session created via magic link', [
                'user_id' => $userData['id'],
                'email'   => $userData['email'],
            ]);

            // ── Always redirect to job seeker dashboard ────────────────────
            return redirect()->route('seeker.dashboard')
                ->with('success', 'Welcome back, ' . $userData['first_name'] . '!');

        } catch (\Exception $e) {
            Log::error('Web magic link authentication error: ' . $e->getMessage());

            return redirect()->route('home.welcome')
                ->with('error', 'Something went wrong. Please request a new magic link.');
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // POST /auth/logout
    // ─────────────────────────────────────────────────────────────────────────
    public function logout(Request $request)
    {
        Session::forget('web_user');
        Session::forget('web_user_logged_in_at');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home.welcome')->with('info', 'You have been logged out.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Helper: get the current web user from session (use in controllers/views)
    //
    //   $user = WebAuthController::currentUser();
    //   if (!$user) return redirect()->route('home.welcome');
    // ─────────────────────────────────────────────────────────────────────────
    public static function currentUser(): ?array
    {
        return Session::get('web_user');
    }

    // Usage in web for auth user 
    /*
    In any controller:
        $user = session('web_user');
        abort_unless($user, 401);
    
    In any Blade view:
        @if(session('web_user'))
            Hello, {{ session('web_user.first_name') }}!
            Role: {{ session('web_user.role') }}
        @endif
    
    Logout button:
        <form method="POST" action="{{ route('web.logout') }}">
            @csrf
            <button type="submit">Log out</button>
        </form>
    */

}
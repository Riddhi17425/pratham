<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    private const MAX_ATTEMPTS = 5;   // wrong attempts allowed
    private const LOCK_SECONDS = 60;  // lock time after too many attempts

    public function login_page()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $throttleKey = Str::lower($credentials['email']).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ]);
        }

        $attempt = Auth::attempt(
            $credentials + ['status' => true, fn ($q) => $q->whereIn('role', [1, 2])],
            $request->boolean('remember')
        );

        if ($attempt) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))->with('toast_success', 'You have been signed in successfully.');
        }

        RateLimiter::hit($throttleKey, self::LOCK_SECONDS);

        return back()->withErrors(['email' => 'The email or password is incorrect, or your account is inactive.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('toast_info', 'You have been signed out successfully.');
    }
}

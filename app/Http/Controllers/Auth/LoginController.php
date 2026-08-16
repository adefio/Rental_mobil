<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use ThrottlesLogins;

    /**
     * Where to redirect users after login.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            $this->username() => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $request->only($this->username(), 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $this->clearLoginAttempts($request);
            $request->session()->regenerate();

            return redirect()->intended($this->redirectTo());
        }

        $this->incrementLoginAttempts($request);

        return back()
            ->withErrors([$this->username() => 'Email atau password salah. Silakan coba lagi.'])
            ->withInput($request->only($this->username()));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function redirectTo()
    {
        return auth()->user() && auth()->user()->isAdmin() ? '/home' : '/';
    }

    protected function username(): string
    {
        return 'email';
    }
}

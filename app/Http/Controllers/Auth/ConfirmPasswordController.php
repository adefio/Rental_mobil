<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ConfirmPasswordController extends Controller
{
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showConfirmForm()
    {
        return view('auth.passwords.confirm');
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        $user = $request->user();

        $valid = $user
            && Auth::guard()->validate(['email' => $user->email, 'password' => $request->password]);

        if (! $valid) {
            throw ValidationException::withMessages([
                'password' => 'Password yang Anda masukkan salah.',
            ]);
        }

        $request->session()->passwordConfirmed();

        return redirect()->intended($this->redirectTo);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('verify');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view('auth.verify');
    }

    public function verify(Request $request, $id, $hash)
    {
        $user = User::find($id);

        if ($user && hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            if (! $user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
            }
        }

        return redirect($this->redirectPath())
            ->with('status', 'Email Anda telah dikonfirmasi. Silakan masuk.');
    }

    public function resend(Request $request)
    {
        return redirect($this->redirectPath())
            ->with('status', 'Konfirmasi email ditangani oleh Supabase. Periksa email Anda.');
    }

    protected function redirectPath()
    {
        return '/';
    }
}

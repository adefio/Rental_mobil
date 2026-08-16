<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\SupabaseAuthException;
use App\Http\Controllers\Controller;
use App\Services\SupabaseAuthService;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function __construct(protected SupabaseAuthService $supabase)
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        try {
            $this->supabase->recover($request->input('email'));
        } catch (SupabaseAuthException $e) {
            return back()->withErrors(['email' => $e->getMessage()]);
        }

        return back()->with('status', 'Tautan reset password telah dikirim ke email Anda.');
    }
}

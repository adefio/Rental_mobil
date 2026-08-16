<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\SupabaseAuthException;
use App\Http\Controllers\Controller;
use App\Services\SupabaseAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    public function __construct(protected SupabaseAuthService $supabase)
    {
        $this->middleware('guest');
    }

    /**
     * Rute lama (`/password/reset/{token}`) dipertahankan agar rute
     * `Auth::routes()` tidak berubah, tetapi alur reset sesungguhnya
     * diarahkan ke halaman `/password/reset/complete`.
     */
    public function showResetForm(Request $request, $token = null)
    {
        if ($request->has('token')) {
            return redirect()->route('password.reset.complete', ['token' => $request->query('token')]);
        }

        return redirect()->route('password.request');
    }

    /**
     * Rute lama untuk POST `/password/reset`.
     */
    public function reset(Request $request)
    {
        return redirect()->route('password.request');
    }

    public function showCompleteForm(Request $request)
    {
        $token = $request->query('token');

        if (! $token) {
            return redirect()->route('password.request');
        }

        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function complete(Request $request)
    {
        $data = $request->validate([
            'token' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            $session = $this->supabase->verifyRecovery($data['token']);
            $this->supabase->updatePassword($session['access_token'], $data['password']);
        } catch (SupabaseAuthException $e) {
            return back()->withErrors(['token' => 'Tautan tidak valid atau sudah kedaluwarsa. Silakan minta tautan baru.']);
        }

        Auth::guard('supabase')->logout();

        return redirect()->route('login')
            ->with('status', 'Password berhasil diubah. Silakan masuk dengan password baru Anda.');
    }
}

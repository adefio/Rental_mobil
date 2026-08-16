<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\SupabaseAuthException;
use App\Http\Controllers\Controller;
use App\Services\SupabaseAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __construct(protected SupabaseAuthService $supabase)
    {
        $this->middleware('guest');
        $this->middleware('throttle:10,1')->only('register');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $this->validator($request->all())->validate();

        try {
            $session = $this->supabase->signUp($data['email'], $data['password'], [
                'nama' => $data['name'],
            ]);
        } catch (SupabaseAuthException $e) {
            return back()
                ->withErrors(['email' => $e->getMessage()])
                ->withInput($request->only('name', 'email'));
        }

        if (! empty($session['access_token']) && ! empty($session['user']['id'])) {
            $user = Auth::guard('supabase')->loginFromSupabase($session);

            if ($user) {
                $request->session()->regenerate();

                return redirect($this->redirectTo());
            }
        }

        return redirect()->route('login')
            ->with('status', 'Pendaftaran berhasil! Silakan cek email Anda untuk konfirmasi, lalu masuk.');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function redirectTo()
    {
        return '/';
    }
}

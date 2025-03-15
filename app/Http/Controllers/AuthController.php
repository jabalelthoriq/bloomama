<?php

namespace App\Http\Controllers;
use App\Models\Midwive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller{

    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:midwives',
            'phone_number' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create a new user record
        $midwive = Midwive::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
        ]);

        // Redirect with success message
        return redirect()->route('login')
            ->with('success', 'Registration successful! You can now log in.');
    }
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        try {
            // Validasi input
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            // Coba autentikasi khusus untuk midwife
            if (Auth::guard('midwife')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('dashboard')
            ->with('success', 'Registration successful! You can now log in.');
            }

            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput($request->except('password'));

        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Terjadi kesalahan sistem. Silakan coba lagi.',
            ])->withInput($request->except('password'));
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function acara()
    {
        return view('acara');
    }

    public function chat()
    {
        return view('chat');
    }

    public function user()
    {
        return view('user');
    }

    public function setting()
    {
        return view('setting');
    }

    public function security()
    {
        return view('security');
    }



}


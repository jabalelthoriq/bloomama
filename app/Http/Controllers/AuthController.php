<?php

namespace App\Http\Controllers;

use App\Models\Midwive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;



class AuthController extends Controller
{
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

        // Pastikan midwife_id ada sebelum menyimpan ke session
        if ($midwive && $midwive->midwife_id) {
            \Log::info('User registered with ID: ' . $midwive->midwife_id);

            // Store user data in session for later use
            $userData = [
                'midwife_id' => $midwive->midwife_id,
                'name' => $midwive->name,
                'email' => $midwive->email,
                'phone_number' => $midwive->phone_number,
            ];

            // Store in session
            Session::put('user_data', $userData);
        } else {
            \Log::error('Failed to get midwife_id after registration');
        }

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
            // Validate input
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            // Set remember me option
            $remember = $request->has('remember') ? true : false;

            // Try to authenticate specifically for midwife
            if (Auth::guard('midwife')->attempt($credentials, $remember)) {
                // Regenerate session for security
                $request->session()->regenerate();

                // Get the authenticated midwife's data
                $midwife = Auth::guard('midwife')->user();

                // Log untuk debugging
                \Log::info('User logged in with ID: ' . ($midwife->midwife_id ?? 'null'));

                // Store user data in session for later use
                $userData = [
                    'midwife_id' => $midwife->midwife_id,
                    'name' => $midwife->name,
                    'email' => $midwife->email,
                    'phone_number' => $midwife->phone_number,
                    'profile_picture' => $midwife->profile_picture ?? null,
                    'role' => $midwife->role,
                ];

                // Store in session
                Session::put('user_data', $userData);

                // Check role and redirect accordingly
                if ($midwife->role === 'admin') {
                    return redirect('menu1')
                        ->with('success', 'Login successful!');
                } else {
                    return redirect()->route('dashboard')
                        ->with('success', 'Login successful!');
                }
            }

            // Authentication failed
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput($request->except('password'));

        } catch (\Exception $e) {
            \Log::error('Login error: ' . $e->getMessage());
            return back()->withErrors([
                'email' => 'Terjadi kesalahan sistem. Silakan coba lagi: ' . $e->getMessage(),
            ])->withInput($request->except('password'));
        }
    }



    public function logout(Request $request)
    {
        try {
            // Log information about the logout for debugging
            Log::info('User logout initiated: ' . (Auth::guard('midwife')->id() ?? 'no-auth-id'));

            // Remove all session data related to the user
            Session::forget('user_data');
            Session::forget('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');

            // Logout from authentication
            Auth::guard('midwife')->logout();

            // Clear all session data
            $request->session()->flush();

            // Invalidate session and regenerate token
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Clear cookie if exists
            if ($request->hasCookie('remember_web_59ba36addc2b2f9401580f014c7f58ea4e30989d')) {
                Cookie::queue(Cookie::forget('remember_web_59ba36addc2b2f9401580f014c7f58ea4e30989d'));
            }

            // Return a proper response based on request type
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => true, 'message' => 'You have been logged out successfully.']);
            }

            // Regular form submission redirect
            return redirect()->route('login')
                ->with('success', 'You have been logged out successfully.');
        } catch (\Exception $e) {
            Log::error('Logout error: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Logout failed: ' . $e->getMessage()], 500);
            }

            return redirect()->back()->with('error', 'Logout failed: ' . $e->getMessage());
        }
    }




}

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
                ];

                // Store in session
                Session::put('user_data', $userData);

                // Redirect to intended URL or dashboard
                return redirect()->intended(route('dashboard'))
                    ->with('success', 'Login successful!');
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

    // public function logout(Request $request)
    // {
    //     Auth::guard('midwife')->logout();
    //     $request->session()->forget('user_data');
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return redirect()->route('login')
    //         ->with('success', 'You have been logged out successfully.');
    // }

    public function chat()
    {
        return view('chat');
    }

    public function setting()
    {
        // Get user data from session
        $userData = Session::get('user_data');

        // Pass user data to the view
        return view('setting', ['userData' => $userData]);
    }

    public function security()
    {
        return view('security');
    }

    public function updateProfile(Request $request)
    {
        // Log data session untuk debugging
        \Log::info('User data in session:', Session::get('user_data') ?? ['No data']);

        // Validate the form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Get the user data from session
            $userData = Session::get('user_data');

            if (!$userData) {
                return back()->withErrors([
                    'error' => 'User data not found in session. Please login again.',
                ])->withInput();
            }

            // Get the user from the database using email if midwife_id is null
            $midwife = null;
            if (isset($userData['midwife_id']) && $userData['midwife_id'] !== null) {
                $midwife = Midwive::find($userData['midwife_id']);
            } elseif (isset($userData['email'])) {
                $midwife = Midwive::where('email', $userData['email'])->first();
            }

            if (!$midwife) {
                return back()->withErrors([
                    'error' => 'User not found in database. Please login again.',
                ])->withInput();
            }

            // Update the user record
            $midwife->name = $request->name;
            $midwife->email = $request->email;
            $midwife->phone_number = $request->phone;

            // Handle profile picture upload if provided
            if ($request->hasFile('profile_picture')) {
                // Delete old profile picture if exists
                if ($midwife->profile_picture && file_exists(public_path('storage/' . $midwife->profile_picture))) {
                    unlink(public_path('storage/' . $midwife->profile_picture));
                }

                // Generate a unique filename
                $filename = 'profile_pictures/' . time() . '_' . $request->file('profile_picture')->getClientOriginalName();

                // Store the new profile picture
                $request->file('profile_picture')->storeAs('public', $filename);

                // Update the profile picture field with the path
                $midwife->profile_picture = $filename;
            }

            $midwife->save();

            // Update session data with the correct midwife_id
            $userData = [
                'midwife_id' => $midwife->midwife_id,
                'name' => $midwife->name,
                'email' => $midwife->email,
                'phone_number' => $midwife->phone_number,
                'profile_picture' => $midwife->profile_picture,
            ];

            Session::put('user_data', $userData);

            // Log updated session data
            \Log::info('Updated user data in session:', $userData);

            return back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Profile update error: ' . $e->getMessage());
            return back()->withErrors([
                'error' => 'Failed to update profile: ' . $e->getMessage(),
            ])->withInput();
        }
    }


    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'new_password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Kata sandi saat ini tidak cocok.',
            ])->withInput();
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Kata sandi berhasil diperbarui.');
    }

    /**
     * Send a password reset link to the user's email
     */
    public function sendResetLinkEmail(Request $request) {
        // Validasi email yang dimasukkan
        $request->validate([
            'email' => ['required', 'email', 'exists:midwives,email'],
        ]);

        // Konfigurasi broker untuk model midwives
        $broker = 'midwives';

        // Mengirimkan link reset password
        $status = Password::broker($broker)->sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            Log::info('Password reset link sent to: ' . $request->email);
            return back()->with(['status' => __($status)]);
        } else {
            return back()->withErrors(['email' => __($status)]);
        }
    }
}

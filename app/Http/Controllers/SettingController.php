<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Midwive;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->checkAdminAccess();
    }

    /**
     * Check if the authenticated user is a midwife with admin role
     */
    private function checkAdminAccess()
    {
        // Check if user is authenticated as midwife
        if (!Auth::guard('midwife')->check()) {
            abort(403, 'Unauthorized access');
        }

        // Check if midwife has admin role
        $midwife = Auth::guard('midwife')->user();

        // Check if role field exists, is not null, and is set to 'admin'
        if (!isset($midwife->role) || $midwife->role === null || empty($midwife->role) || $midwife->role !== 'midwife') {
            abort(403, 'midwife access required');
        }
    }

    /**
     * Display a listing of the resource.
     */
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
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

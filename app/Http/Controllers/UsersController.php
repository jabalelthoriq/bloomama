<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Midwive;
use App\Models\UserPregnant;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
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
     * Show the users page with users data.
     *
     * @return \Illuminate\Contracts\View\View
     */

     public function showUsersAndMidwives()
     {
         $midwives = Midwive::paginate(10, ['*'], 'midwife_page');
         $users = User::paginate(10, ['*'], 'user_page');

         $userPregnancies = UserPregnant::with(['user' => function($query) {
                 $query->select('user_id', 'name'); // Only select needed columns
             }])
             ->orderBy('created_at', 'desc')
             ->paginate(10, ['*'], 'pregnancy_page');

         return view('user', compact('users', 'midwives', 'userPregnancies'));
     }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'phone_number' => 'required|string|max:20',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        }

        $user->update($validated);

        // Update: Changed 'user' to 'midwife.user' to match route name in routes file
        return redirect()->route('midwife.user')
            ->with('success', 'Data bidan berhasil diperbarui.');
    }

    /**
     * Remove the specified user from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        // Update: Changed 'user' to 'midwife.user' to match route name in routes file
        return redirect()->route('midwife.user')
            ->with('success', 'Bidan berhasil dihapus.');
    }





}

<?php

namespace App\Http\Controllers;

use App\Models\Midwive;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class MidwiveController extends Controller
{
/**
 * Store a newly created midwife in database.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\RedirectResponse
 */
public function store(Request $request): RedirectResponse
{
    // Validate the request data
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:midwives,email',
        'phone_number' => 'required|string|max:20',
        'password' => 'required|string|min:8',
    ]);

    // Hash the password
    $validated['password'] = bcrypt($request->password);

    // Create new midwife record
    Midwive::create($validated);

    // Redirect back with success message
    return redirect()->route('user')
        ->with('success', 'Bidan berhasil ditambahkan.');
}


}

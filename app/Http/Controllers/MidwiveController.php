<?php

namespace App\Http\Controllers;

use App\Models\Midwive;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class MidwiveController extends Controller
{

    /**
     * Show the form for editing the specified midwive.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $midwive = Midwive::findOrFail($id);
        return view('midwives.edit', compact('midwive'));
    }

    /**
     * Update the specified midwive in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $midwive = Midwive::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:midwives,email,'.$id,
            'phone_number' => 'required|string|max:20',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        }

        $midwive->update($validated);

        return redirect()->route('user')
            ->with('success', 'Data bidan berhasil diperbarui.');
    }

    /**
     * Remove the specified midwive from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $midwive = Midwive::findOrFail($id);
        $midwive->delete();

        return redirect()->route('user')
            ->with('success', 'Bidan berhasil dihapus.');
    }
}

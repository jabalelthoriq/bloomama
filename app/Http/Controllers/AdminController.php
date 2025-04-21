<?php

namespace App\Http\Controllers;
use App\Models\Midwive;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    public function menu1()
    {
        return view('admin/menu1');
    }
    public function showUsersAndMidwives()
    {
        $midwives = Midwive::paginate(10, ['*'], 'midwife_page');
        return view('admin/menu2', compact( 'midwives'));
    }
    public function menu3()
    {
        return view('admin/menu3');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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

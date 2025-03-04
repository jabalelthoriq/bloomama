<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller{
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


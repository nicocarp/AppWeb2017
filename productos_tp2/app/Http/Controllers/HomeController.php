<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// usado para ver usuario actualmente logueado
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        //return view('home', ['usuario' => $user]);
        return view('home');
    }
}

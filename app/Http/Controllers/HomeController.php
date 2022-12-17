<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\MainFunction;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    use MainFunction;
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->endDay();
        return view('milk_supply');
    }
}

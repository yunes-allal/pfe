<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->type == 'candidat'){
            return view('candidat.index');
        }else{
            if(Auth::user()->type == 'sdp'){
                return view('SDP.index');
            }else{
                if(Auth::user()->type == 'commission'){
                    return view('commission.conformite.index');
                }
            }
        }
    }
}

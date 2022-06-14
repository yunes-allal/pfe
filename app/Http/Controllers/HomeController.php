<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Session;

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
        $this->middleware('update.status');
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
                return view('SDP.home');
            }else{
                if(Auth::user()->type == 'commission'){
                    if(Session::where('status','inscription')->count() || Session::where('status','conformity')->count()){
                      return view('commission.conformite.index');
                    }else{
                        if(Session::where('status','interview')->count()){
                            return view('commission.entretien.index');
                        }else{
                            if(Session::where('status','sc_works_validation')->count()){
                                return view('commission.scientifique.index');
                            }
                        }
                    }
                }else{
                    if(Auth::user()->type == 'admin'){
                        return view('admin.home');
                    }
                }
            }
        }
    }
}

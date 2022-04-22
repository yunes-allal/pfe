<?php

namespace App\Http\Controllers;

use App\Models\Besoin;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    public function index(){
        if(DB::table('sessions')->where('on_going','=','true')->count()!=0){
            return view('SDP.besoins.besoins')->with('besoins',Besoin::all());
        }else{
            return view('SDP.besoins.session');
        }
    }

    public function store(Request $request){
        $session = Session::create([
            'name'=> $request->name,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'global_number'=>$request->global_number,
            'onlyDoctorat'=>$request->onlyDoctorat,
            'decision'=>$request->decision,
            'decision_date'=>$request->decision_date,
            'agreement'=>$request->agreement,
            'agreement_date'=>$request->agreement_date
        ]);
        return back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Besoin;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SessionController extends Controller
{
    public function index(){
        if(DB::table('sessions')->where('status','!=','off')->count()!=0){
            if(DB::table('sessions')->where('status','=','declaring')->count()>0){
                return view('SDP.besoins.besoins')->with('besoins',Besoin::all());
            }else{
                return redirect()->route('home')->with('info', 'La session est en cours');
            }
        }else{
            return view('SDP.besoins.session');
        }
    }

    public function store(Request $request){
        Session::create([
            'name'=> $request->name,
            'start_date'=>$request->start_date,
            'end_date'=>Carbon::createFromDate($request->start_date)->addDays($request->duration),
            'global_number'=>$request->global_number,
            'onlyDoctorat'=>$request->onlyDoctorat,
            'decision'=>$request->decision,
            'decision_date'=>$request->decision_date,
            'agreement'=>$request->agreement,
            'agreement_date'=>$request->agreement_date
        ]);
        return back()->with('success', 'La session a été créée avec succès');
    }

    public function updateStatus(Request $data)
    {
        DB::table('sessions')->where('status','!=','off')->update(['status' => $data->status]);
        return redirect()->route('home');
    }
}

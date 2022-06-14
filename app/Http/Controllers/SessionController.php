<?php

namespace App\Http\Controllers;

use App\Models\Besoin;
use App\Models\Session;
use App\Models\Commission;
use App\Models\Criteres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SessionController extends Controller
{
    public function index(){
        if(DB::table('sessions')->where('status','!=','off')->count()!=0){
            if(DB::table('sessions')->where('status','=','declaring')->count()>0){
                if(!Commission::count()){
                    return view('SDP.besoins.besoins')->with('besoins',Besoin::all());
                }else{
                    return view('SDP.besoins.criteres')->with('criteres',Criteres::all());
                }
            }else{
                return redirect()->route('home')->with('info', 'La session est en cours');
            }
        }else{
            return view('SDP.besoins.session');
        }
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'start_date' => 'required|date',
            'global_number' => 'required|integer',
            'onlyDoctorat' => 'required',
            'duration' => 'required|integer',
            'decision_file'=> 'nullable|max:2048'
        ]);
        if($request->hasFile('decision_file')){
            //Get file name with extension
            $fileNameWithExt = $request->file('decision_file')->getClientOriginalName();
            //Get just file name
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get just extension
            $extension = $request->file('decision_file')->getClientOriginalExtension();
            // filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // upload image
            $path = $request->file('decision_file')->storeAs('public/session/decisions', $fileNameToStore);
        }else{
            $fileNameToStore = NULL;
        }

        $session = new Session();
        $session->name = $request->name;
        $session->start_date = $request->start_date;
        $session->end_date = Carbon::createFromDate($request->start_date)->addDays($request->duration);
        $session->global_number = $request->global_number;
        $session->onlyDoctorat = $request->onlyDoctorat;
        $session->decision = $request->decision;
        $session->decision_date = $request->decision_date;
        $session->agreement = $request->agreement;
        $session->agreement_date = $request->agreement_date;
        $session->decision_file = $fileNameToStore;
        $session->save();

        return back()->with('success', 'La session a été créée avec succès');
    }

    public function updateStatus(Request $data)
    {
        //DB::table('sessions')->where('status','!=','off')->update(['status' => $data->status]);
        return redirect()->route('home');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Globalcriterias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GlobalcriteriasController extends Controller
{
    public function index()
    {
        //
    }


    public function create()
    {
        $global_positions = DB::table('sessions')->select('global_number')
                                    ->where('on_going','=','true')->get();
        $declared_positions = DB::table('besoins')->sum('positions_number');

        if($declared_positions != $global_positions[0]->global_number){
            return redirect()->route('besoins.index')->with('fail','le nombre globale != le nombre declare');
        }else{
            $default_creterias = DB::table('globalcriterias')->select('name','pts')
                                    ->where('session_id','=', NULL)->get();
            //dd($default_creterias);
            return view('SDP.besoins.creterias')->with('default_criterias', $default_creterias);
        }
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Globalcriterias $globalcriterias)
    {
        //
    }

    public function edit(Globalcriterias $globalcriterias)
    {
        return view('SDP.besoins.creterias')->with('criterias',Globalcriterias::all());
    }

    public function update(Request $request, Globalcriterias $globalcriterias)
    {
        $globalcriterias->update($request->all());
        return redirect()->back();
    }


    public function destroy(Globalcriterias $globalcriterias)
    {
        //
    }
}

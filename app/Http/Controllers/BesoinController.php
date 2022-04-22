<?php

namespace App\Http\Controllers;

use App\Models\Besoin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BesoinController extends Controller
{
    public function index()
    {
        //TODO: send values using GROUP BY
        // $besoins = DB::table('besoins')
        //         ->groupBy('faculty_id')
        //         ->get();

        return view('SDP.besoins.besoins')->with('besoins',Besoin::all());
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        Besoin::create([
            'faculty_id'=> $request->faculty_id,
            'department_id'=> $request->department_id,
            'sector_id'=> $request->sector_id,
            'speciality_id'=> $request->speciality_id,
            'subspeciality_id'=> $request->subspeciality_id,
            'positions_number'=> $request->positions_number
        ]);
        return redirect()->back();
    }


    public function show(Besoin $besoin)
    {
        return view('SDP.besoins.besoins', compact('besoin'));
    }


    public function edit(Besoin $faculty)
    {
        //
    }


    public function update(Request $request, Besoin $faculty)
    {
        //
    }


    public function destroy(Besoin $besoin)
    {
        //Besoin::find($besoin)->delete();
        //dd($besoin);
        $besoin->delete();
        return redirect()->back();
    }
}

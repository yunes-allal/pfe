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
        //
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
        $besoin->delete();
        return redirect()->back()->with('info', 'Besoin supprimée');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Criteres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CriteresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('SDP.besoins.criteres')->with('criteres', Criteres::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Criteres  $criteres
     * @return \Illuminate\Http\Response
     */
    public function show(Criteres $criteres)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Criteres  $criteres
     * @return \Illuminate\Http\Response
     */
    public function edit(Criteres $criteres)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Criteres  $criteres
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::table('criteres')->where('id', '=', $request->id)
                            ->update(['pts' => $request->pts]);
        return back()->with('success', 'Critère modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Criteres  $criteres
     * @return \Illuminate\Http\Response
     */
    public function destroy(Criteres $criteres)
    {
        //
    }
}

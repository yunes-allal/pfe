<?php

namespace App\Http\Controllers;

use App\Models\FormationsComp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormationsCompController extends Controller
{
    public function store(Request $data)
    {
        $data->validate([
            'fc_speciality' => 'required',
            'fc_institution' => 'required',
            'fc_number' => 'required',
            'fc_inscription_date' => 'required|date',
        ]);
        FormationsComp::create([
            'user_id' => Auth::id(),
            'fc_speciality' => $data->fc_speciality,
            'fc_institution' => $data->fc_institution,
            'fc_number' => $data->fc_number,
            'fc_inscription_date' => $data->fc_inscription_date,
            'created_at' =>now(),
            'updated_at' => now()
        ]);
        DB::table('dossiers')->where('id', $data->dossier_id)->update(['current_tab' => '2']);
        return back()->with('success', 'Nouvelle formation complémentaire ajoutée avec succès');
    }

    public function delete(Request $request)
    {
        DB::table('formations_comps')->where('id',$request->id)->delete();
        DB::table('dossiers')->where('id', $request->dossier_id)->update(['current_tab' => '2']);
        return redirect()->back()->with('info', 'Formation supprimée');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\FormationsComp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormationsCompController extends Controller
{
    public function store(Request $data)
    {
        FormationsComp::create([
            'user_id' => $data->user_id,
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
}

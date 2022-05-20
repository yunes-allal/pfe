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
            'dossier_id' => $data->dossier_id,
            'fc_diploma' => $data->fc_diploma,
            'fc_field' => $data->fc_field,
            'fc_major' => $data->fc_major,
            'fc_origin' => $data->fc_origin,
            'fc_diploma_ref' => $data->fc_diploma_ref,
            'fc_diploma_date' => $data->fc_diploma_date,
            'fc_start_date' => $data->fc_start_date,
            'fc_end_date' => $data->fc_end_date,
            'fc_phd_register_date' => $data->fc_phd_register_date,
        ]);
        DB::table('dossiers')->where('id', $data->dossier_id)->update(['current_tab' => '3']);
        return back()->with('success', 'Nouvelle formation complémentaire ajoutée avec succès');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ExperiencePro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExperienceProController extends Controller
{

    public function store(Request $data)
    {
        ExperiencePro::create([
            'user_id' => $data->user_id,
            'ep_institution' => $data->ep_institution,
            'ep_workplace' => $data->ep_workplace,
            'ep_start_date' => $data->ep_start_date,
            'ep_end_date' => $data->ep_end_date,
            'ep_work_certificate_ref' => $data->ep_work_certificate_ref,
            'ep_work_certificate_date' => $data->ep_work_certificate_date,
            'ep_mark' => $data->ep_mark
        ]);
        DB::table('dossiers')->where('id', $data->dossier_id)->update(['current_tab' => '4']);
        return back()->with('success', 'Nouvelle expérience ajoutée avec succès');
    }
}

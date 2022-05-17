<?php

namespace App\Http\Controllers;

use App\Models\ExperiencePro;
use Illuminate\Http\Request;

class ExperienceProController extends Controller
{

    public function store(Request $data)
    {
        ExperiencePro::create([
            'dossier_id' => $data->dossier_id,
            'ep_institution' => $data->ep_institution,
            'ep_workplace' => $data->ep_workplace,
            'ep_start_date' => $data->ep_start_date,
            'ep_end_date' => $data->ep_end_date,
            'ep_work_certificate_ref' => $data->ep_work_certificate_ref,
            'ep_work_certificate_date' => $data->ep_work_certificate_date,
            'ep_mark' => $data->ep_mark
        ]);
        return back()->with('success', 'Nouveau experience ajoutee avec succees');
    }
}

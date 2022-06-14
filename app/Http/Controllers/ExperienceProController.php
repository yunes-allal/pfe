<?php

namespace App\Http\Controllers;

use App\Models\ExperiencePro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExperienceProController extends Controller
{

    public function store(Request $data)
    {
        DB::table('dossiers')->where('id', $data->dossier_id)->update(['current_tab' => '4']);
        $data->validate([
            'ep_institution' => 'required',
            'ep_workplace' => 'required',
            'ep_periode' => 'required|integer',
            'ep_work_certificate_ref' => 'required',
            'ep_work_certificate_date' => 'required|date',
        ]);
        ExperiencePro::create([
            'user_id' => $data->user_id,
            'ep_institution' => $data->ep_institution,
            'ep_workplace' => $data->ep_workplace,
            'ep_periode' => $data->ep_periode,
            'ep_work_certificate_ref' => $data->ep_work_certificate_ref,
            'ep_work_certificate_date' => $data->ep_work_certificate_date,
            'ep_mark' => $data->ep_mark
        ]);
        return back()->with('success', 'Nouvelle expérience ajoutée avec succès');
    }

    public function delete(Request $request)
    {
        DB::table('experience_pros')->where('id',$request->id)->delete();
        DB::table('dossiers')->where('id', $request->dossier_id)->update(['current_tab' => '4']);
        return redirect()->back()->with('info', 'Expérience supprimée');
    }
}

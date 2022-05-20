<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConferenceController extends Controller
{
    //

    public function store(Request $data)
    {
        Conference::create([
            'dossier_id' => $data->dossier_id,
            'is_international' => $data->is_international,
            'conference_name' => $data->conference_name,
            'conference_place' => $data->conference_place,
            'conference_date' => $data->conference_date,
            'conference_title' => $data->conference_title,
            'conference_authors' => $data->conference_authors,
            'conference_link' => $data->conference_link
        ]);
        DB::table('dossiers')->where('id', $data->dossier_id)->update(['current_tab' => '4']);
        return back()->with('success', 'Nouvel conférence ajouté avec succès');
    }
}

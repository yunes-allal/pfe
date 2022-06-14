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
        DB::table('dossiers')->where('id', $data->dossier_id)->update(['current_tab' => '3']);

        $data->validate([
            'is_international'=>'required',
            'conference_name'=>'required',
            'conference_place'=>'required',
            'conference_date'=>'required|date',
            'communication_title'=>'required',
            'conference_authors'=>'required',
            'conference_link'=>'nullable|url',
            'certificate' =>'required|mimes:pdf,png,jpg,jpeg|max:2048'
        ]);

            //Get file name with extension
            $fileNameWithExt = $data->file('certificate')->getClientOriginalName();
            //Get just file name
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get just extension
            $extension = $data->file('certificate')->getClientOriginalExtension();
            // filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // upload file
            $path = $data->file('certificate')->storeAs('public/candidats/certificates', $fileNameToStore);

            $conference = new Conference();
            $conference->user_id = $data->user_id;
            $conference->is_international = $data->is_international;
            $conference->conference_name = $data->conference_name;
            $conference->conference_place = $data->conference_place;
            $conference->conference_date = $data->conference_date;
            $conference->communication_title = $data->communication_title;
            $conference->conference_authors = $data->conference_authors;
            $conference->conference_link = $data->conference_link;
            $conference->certificate = $fileNameToStore;
            $conference->save();

        return back()->with('success', 'Nouvel conférence ajouté avec succès');
    }

    public function delete(Request $request)
    {
        DB::table('conferences')->where('id',$request->id)->delete();
        DB::table('dossiers')->where('id', $request->dossier_id)->update(['current_tab' => '3']);
        return redirect()->back()->with('info', 'Conférence supprimée');
    }
}

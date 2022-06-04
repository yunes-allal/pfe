<?php

namespace App\Http\Controllers;

use App\Models\Dossier;
use App\Models\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DossierController extends Controller
{
    public function index()
    {
        if(!Dossier::where('user_id', Auth::id())->exists()){
            return redirect()->route('home');
        }
        return view('candidat.dossier')->with('dossier', DB::table('dossiers')->where('user_id', Auth::id())->get());
    }

    public function create()
    {
        if(!Dossier::where('user_id', Auth::id())->exists()){
            $session = DB::table('sessions')->select('id')->where('status','!=', 'off')->get();
            Dossier::create([
                'session_id' => $session[0]->id,
                'current_tab' => 1,
                'user_id'=> Auth::id(),
                'status'=> 'not_validated',
                'isMan' => 0,
                'nationality' => 'Algerienne',
                'isMarried' => 0
            ]);
            return view('candidat.dossier')->with('success', 'Merci pour votre participation à notre programme');
        }
        return view('candidat.dossier');
    }

    public function update(Request $request)
    {
        DB::table('dossiers')->where('id',$request->id)
                            ->update([
                                'besoin_id' => $request->besoin_id,
                                'current_tab' => $request->current_tab,
                                'name'=>$request->name,
                                'family_name' => $request->family_name,
                                'name_ar'=>$request->name_ar,
                                'family_name_ar' => $request->family_name_ar,
                                'father_name' => $request->father_name,
                                'mother_family_name' => $request->mother_family_name,
                                'mother_name' => $request->mother_name,
                                'birth_date' => $request->birth_date,
                                'birthplace' => $request->birthplace,
                                'isMan' => $request->isMan,
                                'nationality' => $request->nationality,
                                'id_card' => $request->id_card,
                                'isMarried' => $request->isMarried,
                                'children_number' => $request->children_number,
                                'disability_type' => $request->disability_type,
                                'commune' => $request->commune,
                                'wilaya' => $request->wilaya,
                                'adresse' => $request->adresse,
                                'tel' => $request->tel,
                                'national_service' =>$request->national_service,
                                'doc_num' => $request->doc_num,
                                'doc_issued_date' => $request->doc_issued_date,
                                'diploma_name' => $request->diploma_name,
                                'diploma_mark' => $request->diploma_mark,
                                'diploma_sector' => $request->diploma_sector,
                                'diploma_speciality' => $request->diploma_speciality,
                                'diploma_date' => $request->diploma_date,
                                'diploma_number' => $request->diploma_number,
                                'diploma_start_date' => $request->diploma_start_date,
                                'diploma_end_date' => $request->diploma_end_date,
                                'diploma_institution' => $request->diploma_institution,
                                'sp_workplace' => $request->sp_workplace,
                                'sp_first_nomination_date' => $request->sp_first_nomination_date,
                                'sp_nomination_date' => $request->sp_nomination_date,
                                'sp_category' => $request->sp_category,
                                'sp_echelon' => $request->sp_echelon,
                                'sp_agreement_ref' => $request->sp_agreement_ref,
                                'sp_agreement_date' => $request->sp_agreement_date,
                                'sp_authority' => $request->sp_authority,
                                'sp_adresse' => $request->sp_adresse,
                                'sp_tel' => $request->sp_tel,
                                'sp_fax' => $request->sp_fax,
                                'sp_email' => $request->sp_email,
                            ]);
        return back()->with('info', 'Mis à jour avec succés');
    }
}

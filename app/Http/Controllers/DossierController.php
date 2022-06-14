<?php

namespace App\Http\Controllers;

use App\Models\Dossier;
use App\Models\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        if($request->user_picture && Dossier::where('user_id',Auth::id())->where('user_picture',NULL)){
            $fileNameToStore = NULL;
            $request->validate([
            'user_picture' => 'image|nullable|max:2048|dimensions:min_width=132,min_height=170,max_width=133,max_height=171'
            ]);
            if($request->hasFile('user_picture')){
                //Get file name with extension
                $fileNameWithExt = $request->file('user_picture')->getClientOriginalName();
                //Get just file name
                $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                //Get just extension
                $extension = $request->file('user_picture')->getClientOriginalExtension();
                // filename to store
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                // upload image
                $path = $request->file('user_picture')->storeAs('public/users_pictures', $fileNameToStore);
            }
            // store image to db
            DB::table('dossiers')->where('id',$request->id)->update(['user_picture' => $fileNameToStore]);
        }

        if($request->id_card_pic && Dossier::where('user_id',Auth::id())->where('id_card_pic',NULL)){
            $fileNameToStore = NULL;
            $request->validate([
            'id_card_pic' => 'image|nullable|max:2048'
            ]);
            if($request->hasFile('id_card_pic')){
                //Get file name with extension
                $fileNameWithExt = $request->file('id_card_pic')->getClientOriginalName();
                //Get just file name
                $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                //Get just extension
                $extension = $request->file('id_card_pic')->getClientOriginalExtension();
                // filename to store
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                // upload image
                $path = $request->file('id_card_pic')->storeAs('public/id_cards', $fileNameToStore);
            }
            // store image to db
            DB::table('dossiers')->where('id',$request->id)->update(['id_card_pic' => $fileNameToStore]);
        }


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
                                'updated_at' => now()
                            ]);
        return back()->with('info', 'Mis à jour avec succés');
    }

    public function validateFolder(Request $request)
    {
        DB::table('dossiers')->where('id',$request->id)->update([
            'besoin_id' => $request->choix,
            'name' => $request->name,
            'family_name' => $request->family_name,
            'name_ar' => $request->name_ar,
            'family_name_ar' => $request->family_name_ar,
            'birth_date' => $request->birth_date,
            'birthplace' => $request->birthplace,
            'id_card' => $request->id_card,
            'id_card_pic' => $request->id_card_picture,
            'nationality' => $request->nationality,
            'adresse' => $request->adresse,
            'tel' => $request->tel,
            'diploma_name' => $request->diplome,
            'diploma_mark' => $request->mention,
            'diploma_sector' => $request->filiere,
            'diploma_speciality' => $request->specialite,
            'updated_at' => now()
        ]);
        $request->validate([
            'choix' => 'required',
            'name' => 'required',
            'family_name' => 'required',
            'name_ar' => 'required',
            'family_name_ar' => 'required',
            'birth_date' => 'required',
            'birthplace' => 'required',
            'id_card' => 'required',
            'id_card_picture' =>'required',
            'nationality' => 'required',
            'adresse' => 'required',
            'tel' => 'required',
            'diplome' => 'required',
            'mention' => 'required',
            'filiere' => 'required',
            'specialite' => 'required'
        ]);

        DB::table('dossiers')->where('id',$request->id)->update(['is_validated'=>1, 'current_tab'=>1]);
        return redirect()->route('home')->with('success', 'votre dossier a été soumis avec succès');
    }
}

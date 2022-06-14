<?php

namespace App\Http\Controllers;

use App\Models\Criteres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    public function storeEntretien(Request $request)
    {
        DB::table('notes')->where('dossier_id', $request->dossier_id)
                            ->update([
                                'entretien_1' => $request->critere1,
                                'entretien_2' => $request->critere2,
                                'entretien_3' => $request->critere3,
                                'entretien_4' => $request->critere4,
                                'updated_at' => now()
                            ]);
        return redirect()->back();
    }
    public function storeTrav(Request $request)
    {
        $criteres = Criteres::where('type','traveaux_scientifique')->select('pts')->get();
        DB::table('notes')->where('dossier_id', $request->dossier_id)
                            ->update([
                                'ts_1' => $request->critere1*$criteres[0]->pts,
                                'ts_2' => $request->critere2*$criteres[1]->pts,
                                'ts_3' => $request->critere3*$criteres[2]->pts,
                                'ts_4' => $request->critere4*$criteres[3]->pts,
                                'updated_at' => now()
                            ]);
        return redirect()->back();
    }

    public function storeEP(Request $request)
    {
        DB::table('notes')->where('dossier_id', $request->id)
                            ->update([
                                'ep_mark' => $request->ep_mark,
                                'updated_at' => now()
                            ]);
        $old_note = DB::table('dossiers')->where('id', $request->id)->first();
        $notes = DB::table('notes')->where('dossier_id', $request->id)->first();
        $note = floatval($notes->entretien_1)+floatval($notes->entretien_2)+floatval($notes->entretien_3)+floatval($notes->entretien_4);
        if((floatval($notes->ts_1)+floatval($notes->ts_2)+floatval($notes->ts_3)+floatval($notes->ts_4)+floatval($request->ep_mark))>2){
            $note = $note+2;
        }else{
            $note = $note+ floatval($notes->ts_1)+floatval($notes->ts_2)+floatval($notes->ts_3)+floatval($notes->ts_4)+floatval($request->ep_mark);
        }

        $note = $note + floatval($old_note->mark);
        DB::table('dossiers')->where('id', $request->id)
                            ->update([
                                'mark' => $note
                            ]);
        return redirect()->back();
    }
}

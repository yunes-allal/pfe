<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    public function store(Request $request)
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
}

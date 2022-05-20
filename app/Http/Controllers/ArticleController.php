<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    //
    public function store(Request $data)
    {
        Article::create([
            'dossier_id' => $data->dossier_id,
            'is_international' => $data->is_international,
            'article_title' => $data->article_title,
            'article' => $data->article,
            'article_date' => $data->article_date,
            'article_place' => $data->article_place,
            'article_link' => $data->article_link
        ]);
        DB::table('dossiers')->where('id', $data->dossier_id)->update(['current_tab' => '4']);
        return back()->with('success', 'Nouvel revue ajouté avec succès');
    }
}

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
            'is_international'=> $data->is_international,
            'article_title'=> $data->article_title,
            'article'=> $data->article,
            'article_date'=> $data->article_date,
            'article_category'=> $data->article_category,
            'article_link'=> $data->article_link,
            'user_id' => $data->user_id,
        ]);
        DB::table('dossiers')->where('id', $data->dossier_id)->update(['current_tab' => '4']);
        return back()->with('success', 'Nouvel revue ajouté avec succès');
    }
}

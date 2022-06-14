<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function store(Request $data)
    {
        DB::table('dossiers')->where('id', $data->dossier_id)->update(['current_tab' => '3']);

        $data->validate([
            'user_id' => 'required',
            'is_international' => 'required',
            'article_title' => 'required',
            'article' => 'required',
            'article_date' => 'required',
            'article_file' => 'mimes:pdf|nullable'
        ]);


        if($data->hasFile('article_file')){
            //Get file name with extension
            $fileNameWithExt = $data->file('article_file')->getClientOriginalName();
            //Get just file name
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get just extension
            $extension = $data->file('article_file')->getClientOriginalExtension();
            // filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // upload image
            $path = $data->file('article_file')->storeAs('public/candidats/articles', $fileNameToStore);
        }else{
            $fileNameToStore = NULL;
        }
        $article = new Article();
        $article->is_international = $data->is_international;
        $article->article_title = $data->article_title;
        $article->article = $data->article;
        $article->article_date = $data->article_date;
        $article->article_category = $data->article_category;
        $article->article_link = $data->article_link;
        $article->user_id = $data->user_id;
        $article->article_file = $fileNameToStore;
        $article->save();

        return back()->with('success', 'Nouvel revue ajouté avec succès');
    }

    public function delete(Request $request)
    {
        DB::table('articles')->where('id',$request->id)->delete();
        DB::table('dossiers')->where('id', $request->dossier_id)->update(['current_tab' => '3']);
        return redirect()->back()->with('info', 'Article supprimée');
    }
}

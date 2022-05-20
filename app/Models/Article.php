<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
     protected $fillable = [
        'dossier_id',
        'is_international',
        'article_title',
        'article',
        'article_date',
        'article_place',
        'article_link'
     ];

     /**
      * Get the dossier that owns the Article
      *
      * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
      */
     public function dossier()
     {
         return $this->belongsTo(Dossier::class, 'foreign_key', 'other_key');
     }
}

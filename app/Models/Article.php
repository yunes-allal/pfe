<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
     protected $fillable = [
        'user_id',
        'is_international',
        'article_title',
        'article',
        'article_date',
        'article_category',
        'article_link'
     ];

     /**
      * Get the user that owns the Article
      *
      * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
      */
     public function user()
     {
         return $this->belongsTo(User::class);
     }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_international',
        'conference_name',
        'conference_place',
        'conference_date',
        'communication_title',
        'conference_authors',
        'conference_link'
    ];

    /**
     * Get the user that owns the Conference
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

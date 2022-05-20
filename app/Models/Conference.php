<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    use HasFactory;

    protected $fillable = [
        'dossier_id',
        'is_international',
        'conference_name',
        'conference_place',
        'conference_date',
        'conference_title',
        'conference_authors',
        'conference_link'
    ];

    /**
     * Get the dossier that owns the Conference
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }
}

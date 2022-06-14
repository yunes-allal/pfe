<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'dossier_id',
        'entretien_1',
        'entretien_2',
        'entretien_3',
        'entretien_4',
        'ts_1',
        'ts_2',
        'ts_3',
        'ts_4',
        'ep_mark'
    ];

    /**
     * Get the dossier that owns the Note
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }
}

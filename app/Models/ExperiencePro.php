<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperiencePro extends Model
{
    use HasFactory;

    protected $fillable = [
        'dossier_id',
        'ep_institution',
        'ep_workplace',
        'ep_start_date',
        'ep_end_date',
        'ep_work_certificate_ref',
        'ep_work_certificate_date',
        'ep_mark'
    ];

    /**
     * Get the dossier that owns the ExperiencePro
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }
}

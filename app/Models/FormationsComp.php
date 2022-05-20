<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormationsComp extends Model
{
    use HasFactory;

    protected $fillable = [
        'dossier_id', 'fc_diploma', 'fc_field', 'fc_major', 'fc_origin', 'fc_diploma_ref', 'fc_diploma_date', 'fc_start_date', 'fc_end_date', 'fc_phd_register_date',
    ];

    /**
     * Get the dossier that owns the FormationsComp
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }
}

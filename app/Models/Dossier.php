<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the Dossier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
    'user_id', 'status', 'besoin_id' , 'name', 'family_name', 'name_ar', 'family_name_ar', 'father_name', 'mother_family_name', 'mother_name',
    'birth_date', 'birthplace', 'isMan', 'nationality', 'id_card', 'isMarried', 'children_number',
    'disability_type', 'commune', 'wilaya', 'adresse', 'tel', 'national_service', 'doc_num', 'doc_issued_date',
    'diploma_name', 'diploma_mark', 'diploma_sector', 'diploma_speciality', 'diploma_date', 'diploma_number', 'diploma_start_date', 'diploma_end_date', 'diploma_institution', 'sp_workplace', 'sp_first_nomination_date', 'sp_nomination_date','sp_category', 'sp_echelon', 'sp_agreement_ref', 'sp_agreement_date', 'sp_authority', 'sp_adresse', 'sp_tel', 'sp_fax', 'sp_email',
    ];

    /**
     * Get all of the experiences_pros for the Dossier
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function experiences_pros()
    {
        return $this->hasMany(ExperiencePro::class);
    }
}
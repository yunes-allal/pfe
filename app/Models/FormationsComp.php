<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormationsComp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fc_speciality',
        'fc_institution',
        'fc_number',
        'fc_inscription_date',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the user that owns the FormationsComp
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

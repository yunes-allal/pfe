<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'start_date', 'end_date', 'global_number', 'onlyDoctorat', 'decision', 'decision_date', 'agreement', 'agreement_date',
    ];

    protected $dates = [
        'start_date', 'end_date', 'created_at'
    ];
    /**
     * Get all of the besoins for the Session
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function besoins()
    {
        return $this->hasMany(Besoin::class);
    }
}

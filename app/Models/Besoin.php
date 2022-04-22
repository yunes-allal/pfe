<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Besoin extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'session_id', 'faculty_id', 'department_id', 'sector_id', 'speciality_id', 'subspeciality_id', 'positions_number'
    ];

    /**
     * Get the session that owns the Besoin
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}

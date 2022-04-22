<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Globalcriterias extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'pts', 'session_id'
    ];

    /**
     * Get the session that owns the Globalcriterias
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}

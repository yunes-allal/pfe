<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'email',
        'password',
        'start_date',
        'end_date',
        'sent_to',
        'conformity_members',
        'interview_members',
        'sc_work_members',
    ];
}

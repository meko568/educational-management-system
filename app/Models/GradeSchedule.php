<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeSchedule extends Model
{
    protected $fillable = [
        'grade',
        'days',
    ];

    protected $casts = [
        'days' => 'array',
    ];
}

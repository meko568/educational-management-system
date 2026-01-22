<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class StudentParent extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'parents';

    protected $primaryKey = 'code';

    protected $fillable = [
        'phone_number',
        'password',
        'plain_password',
        'sons',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'code' => 'integer',
        'password' => 'hashed',
        'sons' => 'array',
    ];
}

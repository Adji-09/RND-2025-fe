<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'username',
        'email',
        'password',
        'foto',
        'role_id',
        'status',
        'remember_token',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}

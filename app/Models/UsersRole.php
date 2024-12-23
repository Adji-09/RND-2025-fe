<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersRole extends Model
{
    use HasFactory;

    protected $table = 'users_role';

    protected $primaryKey = 'id';

    protected $fillable = [
        'role',
        'status'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}

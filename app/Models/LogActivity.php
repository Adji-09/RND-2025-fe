<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;

    protected $table = 't_log_activity';

    protected $primaryKey = 'id_log';

    protected $fillable = [
        'id_user',
        'activity',
        'browser',
        'platform',
        'ip_address'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}

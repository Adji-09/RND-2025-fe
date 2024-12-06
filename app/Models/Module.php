<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $table = 'tm_module';

    protected $primaryKey = 'module_id';

    protected $fillable = [
        'module_name',
        'module_icon',
        'module_url',
        'module_parent',
        'module_position',
        'module_status',
        'module_nav',
        'is_superadmin'
    ];

    public function menu()
    {
        return $this->hasMany(Module::class, 'module_parent', 'module_id')->orderBy('module_position', 'ASC');
    }
}

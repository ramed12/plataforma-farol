<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class permission_user extends Model
{
    use HasFactory;

    protected $table = 'permission_user';
    protected $fillable = [
        'grupo_id',
        'permission_id',
    ];

    public function group(){
        return $this->hasOne(UserGroup::class, 'id', 'grupo_id');
    }

    public function permissao(){
        return $this->belongsToMany(Permission::class, 'id', 'permission_id');
    }

}

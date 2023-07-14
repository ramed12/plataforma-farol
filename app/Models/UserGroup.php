<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    use HasFactory;
    protected $table = 'grupo_users';
    protected $fillable = [
        'name',
        'permissoes',
        'users',
        'userCreate',
        'status'
    ];

    public function User(){
        return $this->hasOne(User::class, 'id', 'userCreate');
    }
}

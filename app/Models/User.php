<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UserGroup;
use Illuminate\Foundation\Auth\User as Authenticatable;
use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasJsonRelationships, Notifiable;

    protected $table = 'users';
    protected $casts = [
        'users' => 'json',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'cpf',
        'token',
        'status',
        'instituicao',
        'cargo',
        'newRegister'
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function group(){
        return $this->hasManyJson(UserGroup::class, 'users', 'id');
    }

    public function instituicao(){
        return $this->hasOne(Instituicao::class, 'user', 'id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Indicador extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'indicador';

    protected $fillable = ['name', 'status', 'user_create', 'idUser_update', 'tema_filho'];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_create');
    }

    public function userEdit(){
        return $this->hasOne(User::class, 'id', 'idUser_update');
    }

    public function paineis(){
        return $this->hasOne(Panel::class, 'id', 'tema_filho');
    }

    public function indicadores(){
        return $this->hasMany(Indicador_theme::class, 'tema_filho', 'id');
    }
}

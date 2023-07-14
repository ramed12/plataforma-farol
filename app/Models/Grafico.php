<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grafico extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'grafico';

    protected $fillable = ['ano', 'total', 'homens', 'mulheres', 'grupo_idades', 'estado', 'idIndicador', 'status', 'id_usuario', 'enum'];

    public function indicador(){
        return $this->hasOne(Indicador::class, 'id', 'idIndicador');
    }

    public function idUserSent(){
        return $this->hasOne(Indicador::class, 'id', 'id_usuario');
    }

    public function enum(){
        return $this->hasMany(Pendente_indicador::class, 'enum', 'enum');
    }
}

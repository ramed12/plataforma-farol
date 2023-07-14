<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pendente_indicador extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pendente_indicador';

    protected $fillable = ['id_indicador','enum', 'status', 'colunas'];


    public function indicador(){
        return $this->hasOne(Indicador::class, 'id', 'id_indicador');
    }

    public function enums(){
        return $this->hasMany(Info_indicadores::class, 'enum', 'enum');
    }
}

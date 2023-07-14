<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Graficos_indicativos extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'graficos_indicativos';

    protected $fillable = ['id_indicador','x','y', 'notas', 'tipo', 'name', 'piramede', 'type_grafico'];

    public function indicativos(){
        return $this->hasOne(Info_indicadores::class, 'id_indicador', 'id_indicador');
    }
}

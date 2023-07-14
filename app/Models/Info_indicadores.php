<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Info_indicadores extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'info_indicadores';

    // protected $fillable = ['id_indicador', 'notas'];
    protected $guarded = [];

    public function indicador(){
        return $this->hasOne(Indicador_theme::class, 'id', 'id_indicador');
    }

    // public function pendenteIndicador(){
    //     return $this->hasMan(Pendente_indicador::class, 'enum', 'enum');
    // }
}

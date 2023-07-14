<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Indicador_theme extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'indicador_theme';

    protected $fillable = ['name', 'tema_filho', 'status'];

    public function tema(){
        return $this->hasOne(Indicador::class, 'id', 'tema_filho');
    }

    public function pendente(){
        return $this->hasMany(Pendente_indicador::class, 'id_indicador', 'id');
    }
}

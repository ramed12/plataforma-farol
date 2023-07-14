<?php

namespace App\Repositories;

use App\Models\Indicador_theme;
use App\Repositories\Contracts\IndicadorThemeInterface;


Class IndicadorThemeRepository extends BaseRepository implements IndicadorThemeInterface{
    public function __construct(Indicador_theme $indicadorTheme){
        parent::__construct($indicadorTheme);
    }
}

<?php

namespace App\Repositories;

use App\Models\Indicador;
use App\Repositories\Contracts\UserContracts;


Class IndicadorRepository extends BaseRepository{

    public function __construct(Indicador $IndicadorRepository){
        parent::__construct($IndicadorRepository);
    }

}

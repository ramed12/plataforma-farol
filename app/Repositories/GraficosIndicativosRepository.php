<?php

namespace App\Repositories;

use App\Models\Graficos_indicativos;
use App\Repositories\Contracts\UserContracts;


Class GraficosIndicativosRepository extends BaseRepository{

    public function __construct(Graficos_indicativos $graficos_indicativos){
        parent::__construct($graficos_indicativos);
    }

}

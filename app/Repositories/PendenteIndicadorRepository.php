<?php

namespace App\Repositories;

use App\Models\Pendente_indicador;


Class PendenteIndicadorRepository extends BaseRepository{

    public function __construct(Pendente_indicador $PendenteIndicadorRepository){
        parent::__construct($PendenteIndicadorRepository);
    }
}

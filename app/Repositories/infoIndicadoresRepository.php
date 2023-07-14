<?php

namespace App\Repositories;

use App\Models\Info_indicadores;


Class infoIndicadoresRepository extends BaseRepository{


    public function __construct(Info_indicadores $infoIndicadores){
        parent::__construct($infoIndicadores);
    }

}

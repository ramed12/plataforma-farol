<?php

namespace App\Repositories;

use App\Models\Grafico;

Class GraficoRepository extends BaseRepository{

    public function __construct(Grafico $GraficoRepository){
        parent::__construct($GraficoRepository);
    }

}

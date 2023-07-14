<?php

namespace App\Repositories;

use App\Models\Instituicao;
use App\Repositories\Contracts\UserContracts;


Class InstituicaoRepository extends BaseRepository implements UserContracts{

    public function __construct(Instituicao $instituicao){
        parent::__construct($instituicao);
    }

}

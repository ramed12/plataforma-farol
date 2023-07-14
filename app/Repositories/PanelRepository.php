<?php

namespace App\Repositories;

use App\Models\Panel;
use App\Repositories\Contracts\PanelRepositoryInterface;
use App\Repositories\Contracts\UserContracts;


Class PanelRepository extends BaseRepository implements PanelRepositoryInterface{


    public function __construct(Panel $panelRepository){
        parent::__construct($panelRepository);
    }

}

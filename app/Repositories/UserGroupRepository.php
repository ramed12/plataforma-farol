<?php

namespace App\Repositories;

use App\Models\UserGroup;


Class UserGroupRepository extends BaseRepository{


    public function __construct(UserGroup $UserGroupRepository){
        parent::__construct($UserGroupRepository);
    }

}

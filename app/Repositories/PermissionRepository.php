<?php

namespace App\Repositories;

use App\Models\Permission;


Class PermissionRepository extends BaseRepository{

    public function __construct(Permission $PermissionRepository){
        parent::__construct($PermissionRepository);
    }
}

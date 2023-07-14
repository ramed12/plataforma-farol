<?php

namespace App\Repositories;

use App\Models\permission_user;


Class PermissionGroupRepository extends BaseRepository{


    protected $PermissionGroupRepository;
    public function __construct(permission_user $PermissionGroupRepository){
        parent::__construct($PermissionGroupRepository);
    }

    // public function findPermission($value){
    //     return $this->PermissionGroupRepository->where('permission_id', $value)->get();
    // }


}

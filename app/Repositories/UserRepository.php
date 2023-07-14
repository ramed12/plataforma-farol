<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserContracts;


Class UserRepository extends BaseRepository implements UserContracts{


    public function __construct(User $userRepository){
        parent::__construct($userRepository);
    }

}

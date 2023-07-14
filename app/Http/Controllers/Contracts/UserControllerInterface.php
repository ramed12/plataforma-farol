<?php

namespace App\Http\Controllers\Contracts;

use Illuminate\Http\Request;


interface UserControllerInterface{

    public function tokenRecovery($token);

    public function validateCpf(Request $request);

    public function validateEmail(Request $request);

}

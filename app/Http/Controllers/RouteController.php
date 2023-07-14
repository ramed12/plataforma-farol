<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Routes;

class RouteController extends Controller
{

    use Routes;
    public function index(){
        $this->insertRoute();
    }
}

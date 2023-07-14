<?php

namespace App\Http\Controllers;

use Route;
use App\Models\UserGroup;
use App\Models\Permission;
use App\Models\permission_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\PermissionRepository;
use App\Http\Controllers\GroupUserController;
use App\Repositories\PermissionGroupRepository;

class BaseWebController extends Controller
{
    public function __construct($user, $request){

        $grupos = \DB::table('grupo_users')
            ->whereJsonContains('users', ["{$user->id}"])
        ->get();

        foreach($grupos as $grupo){
            if(!in_array($user->id, json_decode($grupo->users, true))){
                session()->flash('alert', ['code' => "danger", "text" => "Você não está em nenhum grupo. Solicite permissão ao administrador"]);
                Redirect::to('auth')->send();
            }

            $permission = permission_user::where('grupo_id', $grupo->id)->get();

            $array = [];
            $array_permisao = [];
            foreach($permission as $permissao){
                array_push($array, $permissao->grupo_id);
                array_push($array_permisao, $permissao->permission_id);
            }

            if(!in_array($grupo->id, $array)){
                session()->flash('alert', ['code' => "danger", "text" => "O grupo <b>{$grupo->name}</b> não tem permissão para acessar nenhuma rota"]);
                Redirect::to('auth')->send();
            }

            $gaoTech = [];
            foreach($array_permisao as $row){
                $findPermission = Permission::find($row);
                if(empty($findPermission)){
                    continue;
                }
                array_push($gaoTech, $findPermission->name);
            }

                if (isset($request->route()->getAction()['groupname'])) {
                    if (!in_array($request->route()->getAction()['as'], $gaoTech)) {
                        abort(403);
                    }
                }

        }
     }
}

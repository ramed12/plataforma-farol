<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Permission;
use App\Models\permission_user;
use App\Models\UserGroup;
use Illuminate\Support\Facades\Route;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            "name" => "José Alves",
            "email" => "jose.alves@gaotech.com.br",
            "password" => "josealves"
        ];

        User::create($user);

        $routes = Route::getRoutes();

        foreach ($routes as $route) {
            //Checa as rotas
            if (isset($route->getAction()['nickname']) && isset($route->getAction()['groupname'])) {
                $permission = Permission::where('name', $route->getName())->get();

                if ($permission->isEmpty()) {
                    $permission = Permission::updateOrCreate(array(
                        'nickname'  => $route->getAction()['nickname'],
                        'name'      => $route->getName(),
                        'groupname' => (isset($route->getAction()['groupname'])) ? $route->getAction()['groupname'] : null,
                    ));

                    permission_user::create([
                        "grupo_id" => 1,
                        "permission_id" => $permission->id
                    ]);
                }
            }
        }

        UserGroup::create([
            'name' => 'Administrador',
            'userCreate' => 1,
            'users' => json_encode(array("1")),
            'status' => 2
        ]);
    }
}

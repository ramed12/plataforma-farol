<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TheSeer\Tokenizer\Exception;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserGroupRepository;
use App\Http\Requests\GroupUserStoreRequest;
use App\Models\permission_user;
use App\Repositories\PermissionRepository;
use App\Repositories\PermissionGroupRepository;

class GroupUserController extends BaseWebController
{

    protected $groupUser;
    protected $user;
    protected $permission;
    protected $permissionGroup;
    public function __construct(Request $request, PermissionGroupRepository $permissionGroup, UserGroupRepository $groupUser, UserRepository $user, PermissionRepository $permission)
    {
        $this->groupUser       = $groupUser;
        $this->user            = $user;
        $this->permission      = $permission;
        $this->permissionGroup = $permissionGroup;

        $this->middleware(function ($request, $next) {
            $this->id = Auth::guard('web')->user();
            parent::__construct($this->id, $request);
            return $next($request);
        });
    }

    public function index(Request $request){

        $paginate     = ($request->input('per_page')) ? $request->input('per_page') : 10;
        $orderByField = ($request->input('order_by_field')) ? $request->input('order_by_field') : 'id';
        $orderByOrder = ($request->input('order_by_order')) ? $request->input('order_by_order') : 'DESC';

        return view('dashboard.group.index', [
            "groupUser" => $this->groupUser->list($request, $orderByField, $orderByOrder, $paginate)
        ]);
    }

    public function show(){
        return view('dashboard.group.show', [
            "users" => $this->user->all(),
            'permissions' => $this->permission->all()->sortBy('groupname'),
            'rolesCreate' => null,
        ]);
    }

    public function edit($id){
        $user = $this->groupUser->find($id)->users;

        // dd($this->groupUser->find($id));
        $ab = json_decode($user);

        $findPermisson =  permission_user::where('grupo_id', $this->groupUser->find($id)->id)->get();

        $array = [];
        foreach($findPermisson as $perm){
            array_push($array, $perm->permission_id);
        }


        return view('dashboard.group.edit', [
            "users" => $this->user->all()->pluck('name', 'id'),
            "user"  => $ab,
            'group' => $this->groupUser->find($id),
            'permissions'   => $this->permission->all()->sortBy('groupname'),
            'role'  =>  $array
        ]);
    }

    public function store(GroupUserStoreRequest $request){
        try{
            $request->merge([
                "userCreate" => Auth::user()->id,
                "users"      => json_encode($request->input('users')),
                'status'     => 2
            ]);

            $group = $this->groupUser->create($request->except('_token'));

                foreach($request->input('permissions') as $permission){
                    $request->merge([
                        "grupo_id"      => $group->id,
                        "permission_id" => $permission
                    ]);

                    $this->permissionGroup->create($request->except('_token'));
                }
            $request->session()->flash('alert', ['code' => 'success', 'text' => 'Grupo cadastro com sucesso']);
        }catch(Exception $e){
            $request->session()->flash('alert', ['code' => 'danger', 'text' => $e->getMessage()]);
        }

        return redirect()->route('dash.grupouser');
    }

    public function update(Request $request, $role_id){

        try {

            $request->merge([
                "userCreate" => Auth::user()->id,
                "users"      => json_encode($request->input('users')),
                "status"     => 2,
                "grupo_id"   => $role_id
            ]);

             $this->groupUser->update($request->input(), $role_id);


            permission_user::where('grupo_id', $role_id)->forceDelete();

            foreach($request->input('permissions') as $permis){
                $request->merge([
                    "permission_id" => $permis,
                ]);

                $this->permissionGroup->create($request->input());
            }

            $request->session()->flash('alert', array('code'=> 'success', 'text'  => "Grupo atualizado com sucesso!"));
            return redirect(route("dash.groupuser.edit", $role_id));

        } catch (Exception $e) {
            $request->session()->flash('alert', array('code'=> 'danger', 'text'  => $e->getMessage()));
            return redirect(route("sgi-role"));
        }

    }
}

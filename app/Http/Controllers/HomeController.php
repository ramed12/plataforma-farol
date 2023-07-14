<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\InstituicaoRepository;
use App\Http\Requests\UpdateUserRegisterRequest;
use App\Http\Controllers\Contracts\HomeControllerInterface;

class HomeController extends Controller implements HomeControllerInterface
{

    protected $user;
    protected $instituicao;

    public function __construct(UserRepository $user, InstituicaoRepository $instituicao)
    {
        $this->user = $user;
        $this->instituicao = $instituicao;
    }

    public function index(){
        return view('auth.index');
    }

    public function recovery(){
        return view('auth.recoveryPassword');
    }

    public function newRegister($token){
        if(empty($token)){
            session()->flash('alert', ['code' => 'danger',  'text' => 'Nenhum token informado']);
            return redirect()->route('auth');
        }
        $auth = $this->user->where('newRegister', $token);

        if(empty($auth)){
            session()->flash('alert', ['code' => 'danger',  'text' => 'O token informado não está mais disponível para uso']);
            return redirect()->route('auth');
        }

        return view('auth.newUser', [
            'user' => $auth,
            'instituicao' => $this->instituicao->all()
        ]);
    }

    public function user(UpdateUserRegisterRequest $request, $id){
        try {

            $request->merge([
                "newRegister" => null,
                "status"      => 2,
            ]);
            $this->user->update($request->all(), $id);
            $request->session()->flash('alert', ["code" => "success", "text" => "Conta validada com sucesso!"]);
        }catch(Exception $e){
            $request->session()->flash('alert', ["code" => "danger", "text" => $e->getMessage()]);
        }
        return redirect(route('auth'));
    }
}

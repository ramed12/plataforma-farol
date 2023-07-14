<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\InstituicaoRepository;

class InstituicaoController extends BaseWebController
{
    protected $instituicao;
    public function __construct(InstituicaoRepository $instituicao, UserRepository $user, Request $request)
    {
        $this->middleware(function ($request, $next) {
            $this->id = Auth::guard('web')->user();
            parent::__construct($this->id, $request);
            return $next($request);
        });

        $this->instituicao = $instituicao;
    }

    public function index(Request $request){
        $paginate     = ($request->input('per_page')) ? $request->input('per_page') : 10;
        $orderByField = ($request->input('order_by_field')) ? $request->input('order_by_field') : 'id';
        $orderByOrder = ($request->input('order_by_order')) ? $request->input('order_by_order') : 'DESC';
        
        return view('dashboard.instituicao.index', [
            "instituicao" => $this->instituicao->list($request, $orderByField, $orderByOrder, $paginate)
        ]);
    }

    public function show($id){
        return view('dashboard.instituicao.show', [
            "instituicao" => $this->instituicao->find($id)
        ]);
    }

    public function create(){
        return view('dashboard.instituicao.show');
    }

    public function store(Request $request){

        try {

            $request->merge([
                "user" => Auth::user()->id
            ]);

            $this->instituicao->create($request->all());
            $request->session()->flash('alert', ["code" => "success", "text" => "Instituição criada com sucesso"]);
        }catch(Exception $e){
            $request->session()->flash('alert', ["code" => "danger", "text" => $e->getMessage()]);
        }
        return redirect(route('dash.instituicao'));
    }

    public function destroy(Request $request, $id){
        try {

            $this->instituicao->destroy($id);
            $request->session()->flash('alert', ["code" => "success", "text" => "Instituição removida com sucesso"]);
        }catch(Exception $e){
            $request->session()->flash('alert', ["code" => "danger", "text" => $e->getMessage()]);
        }
        return redirect(route('dash.instituicao'));
    }

    public function update(Request $request, $id){
        try {

            $request->merge([
                "user" => Auth::user()->id
            ]);

            $this->instituicao->update($request->all(), $id);
            $request->session()->flash('alert', ["code" => "success", "text" => "Instituição atualizada com sucesso"]);
        }catch(Exception $e){
            $request->session()->flash('alert', ["code" => "danger", "text" => $e->getMessage()]);
        }
        return redirect(route('dash.instituicao'));
    }

}

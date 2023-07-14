<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\PanelRequest;
use App\Http\Requests\PainelUpdateRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\PanelRepository;

class PanelController extends BaseWebController
{
    protected $painelRepository;
    public function __construct(UserRepository $user, Request $request, PanelRepository $panelRepository)
    {
        $this->middleware(function ($request, $next) {
            $this->id = Auth::guard('web')->user();
            parent::__construct($this->id, $request);
            return $next($request);
        });

        $this->painelRepository = $panelRepository;
    }
    public function index(Request $request){
        $paginate     = ($request->input('per_page')) ? $request->input('per_page') : 10;
        $orderByField = ($request->input('order_by_field')) ? $request->input('order_by_field') : 'id';
        $orderByOrder = ($request->input('order_by_order')) ? $request->input('order_by_order') : 'DESC';
        
        return view('dashboard.panel.index', [
            "painel" => $this->painelRepository->list($request, $orderByField, $orderByOrder, $paginate)
        ]);
    }

    public function create(){
        return view('dashboard.panel.show');
    }

    public function store(PanelRequest $request){
        try {
            $this->painelRepository->create($request->all());
            $request->session()->flash('alert', ['code' => "success", "text" => "Painel cadastrado com sucesso"]);
        }catch(Exception $e){
            $request->session()->flash('alert', ['code' => "danger", "text" => $e->getMessage()]);
        }

        return redirect(route('dash.painel'));
    }

    public function show($id){

        if(empty($id)){
            abort(404);
        }

        return view('dashboard.panel.show', [
            "painel" => $this->painelRepository->find($id)
        ]);
    }

    public function update(PainelUpdateRequest $request, $id){
        try {
            $this->painelRepository->update($request->all(), $id);
            $request->session()->flash('alert', ['code' => "success", "text" => "Painel atualizado com sucesso"]);
        }catch(Exception $e){
            $request->session()->flash('alert', ['code' => "danger", "text" => $e->getMessage()]);
        }
        return redirect(route('dash.painel'));
    }

    public function destroy(Request $request, $id){
        try {
            $this->painelRepository->destroy($id);
            $request->session()->flash('alert', ['code' => "success", "text" => "Painel removido com sucesso"]);
        }catch(Exception $e){
            $request->session()->flash('alert', ['code' => "danger", "text" => $e->getMessage()]);
        }
        return redirect(route('dash.painel'));
    }

}

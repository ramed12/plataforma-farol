<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\IndicadorRequest;
use App\Repositories\IndicadorRepository;
use App\Http\Controllers\BaseWebController;
Use App\Repositories\GraficoRepository;
use App\Repositories\PendenteIndicadorRepository;
use App\Repositories\PanelRepository;
use App\Http\Requests\TemaUpdateRequest;
class IndicadorController extends BaseWebController
{
    protected $indicadorRepository;
    protected $grafico;
    protected $pendenteIndicadorRepository;
    protected $painelRepository;
    public function __construct(PanelRepository $painelRepository, PendenteIndicadorRepository $pendenteIndicadorRepository, GraficoRepository $grafico, Request $request, IndicadorRepository $indicadorRepository)
    {
        $this->middleware(function ($request, $next) {
            $this->id = Auth::guard('web')->user();
            parent::__construct($this->id, $request);
            return $next($request);
        });

        $this->indicadorRepository         = $indicadorRepository;
        $this->grafico                     = $grafico;
        $this->pendenteIndicadorRepository = $pendenteIndicadorRepository;
        $this->painelRepository            = $painelRepository;
    }

    public function index(Request $request){
        $paginate     = ($request->input('per_page')) ? $request->input('per_page') : 10;
        $orderByField = ($request->input('order_by_field')) ? $request->input('order_by_field') : 'id';
        $orderByOrder = ($request->input('order_by_order')) ? $request->input('order_by_order') : 'DESC';

        return view("dashboard.indicador.index", [
            "indicador" => $this->indicadorRepository->list($request, $orderByField, $orderByOrder, $paginate)
        ]);
    }

    public function new(){
        return view('dashboard.indicador.show', [
            "painel"    => $this->painelRepository->all()->pluck('name', 'id'),
        ]);
    }

    public function show($id){
        return view('dashboard.indicador.show',[
            "indicador" => $this->indicadorRepository->find($id),
            "painel"    => $this->painelRepository->all()->pluck('name', 'id'),
            "tema_filho" => $this->indicadorRepository->find($id)->tema_filho
        ]);
    }

    public function store(IndicadorRequest $request){
        try {
            $request->merge([
                "user_create"   => Auth::user()->id,
                "idUser_update" => Auth::user()->id,
                "status"        => 2
            ]);

            $this->indicadorRepository->create($request->input());
            $request->session()->flash('alert', ['code' => "success", "text" => "Indicador cadastrado com sucesso"]);
        }catch(Exception $e){
            $request->session()->flash('alert', ['code' => "danger", "text" => $e->getMessage()]);
        }

        return redirect()->route('dash.indicador');
    }


    public function update(TemaUpdateRequest $request, $id){
        try {
            $request->merge([
                "idUser_update" => Auth::user()->id,
                "status"        => 2
            ]);

            $this->indicadorRepository->update($request->input(), $id);
            $request->session()->flash('alert', ['code' => "success", "text" => "Indicador cadastrado com sucesso"]);
        }catch(Exception $e){
            $request->session()->flash('alert', ['code' => "danger", "text" => $e->getMessage()]);
        }
        return redirect()->route('dash.indicador');
    }

    public function insert(Request $request){

        $pendentes = $this->pendenteIndicadorRepository->whereS('status', 1);
        $indicador = $this->indicadorRepository->all();

        return view("dashboard.indicador.insert", [
            "indicador" => (!$indicador->isEmpty()) ? $indicador : null,
            "pendentes" => $pendentes
        ]);
    }

}

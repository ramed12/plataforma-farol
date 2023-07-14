<?php

namespace App\Http\Controllers;

use Exception;
use App\Exports\Export;
use App\Models\Grafico;
use Illuminate\Http\Request;
use App\Exports\GraficoExport;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CheckBoxRequest;
use App\Repositories\GraficoRepository;
use App\Repositories\PendenteIndicadorRepository;

class RemovePendenteGraficController extends BaseWebController
{

    protected $pendenteIndicadorRepository;
    protected $graficoRepository;
    public function __construct(Request $request, PendenteIndicadorRepository $pendenteIndicadorRepository, GraficoRepository $graficoRepository)
    {
        $this->middleware(function ($request, $next) {
            $this->id = Auth::guard('web')->user();
            parent::__construct($this->id, $request);
            return $next($request);
        });

        $this->pendenteIndicadorRepository = $pendenteIndicadorRepository;
        $this->graficoRepository = $graficoRepository;
    }

    public function find(Request $request, $id){

        $paginate     = ($request->input('per_page')) ? $request->input('per_page') : 500;
        $orderByField = ($request->input('order_by_field')) ? $request->input('order_by_field') : 'id';
        $orderByOrder = ($request->input('order_by_order')) ? $request->input('order_by_order') : 'DESC';

        $pendente = $this->pendenteIndicadorRepository->find($id);
        $buscaEstado = Grafico::select('estado','ano')->where('enum', $pendente->enum)->groupBy('estado')->get();

        if(empty($request->input('ano')) &&
           empty($request->input('homem_mulher')) &&
           empty($request->input('grupo_idades')) && empty($request->input('estado'))){
            $buscaResult = Grafico::where('enum', $pendente->enum)->paginate(10);
        } else {
            $buscaResult = $this->graficoRepository->list($request, $orderByField, $orderByOrder, $paginate)
            ->where('enum', $pendente->enum);
        }

        return view('dashboard.indicador.grafico.index',[
                "grafico"   => $pendente,
                "estado"    => $buscaEstado,
                "resultado" => $buscaResult
    ]);

    }

    public function export(Request $request, $id) {
        $paginate     = null;
        $orderByField = ($request->input('order_by_field')) ? $request->input('order_by_field') : 'id';
        $orderByOrder = ($request->input('order_by_order')) ? $request->input('order_by_order') : 'DESC';
        $grafic = $this->graficoRepository->list($request, $orderByField, $orderByOrder, $paginate)
            ->where('enum', $id);

        // dd($grafic);

        return (new Export(new GraficoExport($grafic)))->download();
    }


    public function destroy(Request $request, $id){
        try {

            $pendente = $this->pendenteIndicadorRepository->destroy($id);
            $grafico = Grafico::where('enum', $pendente->enum)->delete();
            $request->session()->flash('alert', ['code' => 'success', 'text' => 'Gráfico e registros removidos com sucesso']);

        }catch(Exception $e){
            $request->session()->flash('alert', ['code' => 'danger', 'text' => $e->getMessage()]);
        }

        return redirect(route('dash.indicador.grafico'));


    }

    public function removeGrafic(Request $request, $id, $idFaixa){
        try {

            $this->graficoRepository->destroy($id);
            $request->session()->flash('alert', ['code' => 'success', 'text' => 'Registro removido com sucesso']);

        }catch(Exception $e){
            $request->session()->flash('alert', ['code' => 'danger', 'text' => $e->getMessage()]);
        }
        return redirect(route('dash.grafico.show', $idFaixa));
    }

    public function removeIndicador(Request $request, $id){
        try {

            $pendente = $this->pendenteIndicadorRepository->destroy($id);
            $grafico = Grafico::where('enum', $pendente->enum)->delete();

            $request->session()->flash('alert', ['code' => 'success', 'text' => 'Gráfico Indicador removido com sucesso']);

        }catch(Exception $e){
            $request->session()->flash('alert', ['code' => 'danger', 'text' => $e->getMessage()]);
        }
        return redirect(route('dash.indicador.grafico'));
    }


    public function aprovedGrafic(Request $request, $id){
        try {

            $indicador = $this->pendenteIndicadorRepository->find($id);
            $indicador->status = 2;
            $indicador->save();
            Grafico::where('enum', $indicador->enum)->update(["status" => 2]);
            $request->session()->flash('alert', ['code' => 'success', 'text' => 'Gráfico aprovado com sucesso']);

        }catch(Exception $e){
            $request->session()->flash('alert', ['code' => 'danger', 'text' => $e->getMessage()]);
        }
        return redirect(route('dash.grafico.show', $id));
    }

    public function checkBox(CheckBoxRequest $request){
        try {
            foreach ($request->input('id') as $row) {
                $this->graficoRepository->destroy($row);
            }
            $request->session()->flash('alert', ['code' => "success", "text" => "Registros removidos com sucesso"]);
        }catch(Exception $e){
            $request->session()->flash('alert', ['code' => "danger", "text" => $e->getMessage()]);
        }
        return redirect(route('dash.grafico.show', $request->input('faixa')));
    }

}

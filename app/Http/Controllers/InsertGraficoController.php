<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Grafico;
use Illuminate\Http\Request;
use App\Imports\FaixaEtariaImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\PendenteIndicadorRepository;

class InsertGraficoController extends BaseWebController
{

    protected $faixaEtariaImport;
    protected $grafico;
    protected $pendenteIndicador;
    public function __construct(PendenteIndicadorRepository $pendenteIndicador, Grafico $grafico, FaixaEtariaImport $faixaEtariaImport)
    {
        $this->middleware(function ($request, $next) {
            $this->id = Auth::guard('web')->user();
            parent::__construct($this->id, $request);
            return $next($request);
        });

        $this->faixaEtariaImport = $faixaEtariaImport;
        $this->grafico           = $grafico;
        $this->pendenteIndicador = $pendenteIndicador;
    }

    public function store(Request $request){

        // Faixa Etaria
            try {
                $enum = str_replace('.', '', microtime(true));

                $request->merge([
                    "id_indicador" => $request->input('idIndicador'),
                    "enum"         => $enum,
                    "status"       => 1,
                ]);

                $this->pendenteIndicador->create($request->input());

                Excel::import(new $this->faixaEtariaImport($request), $request->file('file'));
                $request->session()->flash('alert', array('code'=> 'success', 'text'  => "Dados enviados com sucesso. Pendente de avaliação pelo responsável"));
                return redirect(route("dash.indicador.grafico"));

            } catch (Exception $e) {
                $request->session()->flash('alert', array('code'=> 'danger', 'text'  => $e->getMessage()));
                return redirect(route("dashboard"));
            }
    }
}

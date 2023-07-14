<?php

namespace App\Http\Controllers;

use Exception;
use App\Exports\Export;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Exports\GraficoExport;
use App\Models\Indicador_theme;
use App\Models\Info_indicadores;
use App\Imports\FaixaEtariaImport;
use Illuminate\Support\Facades\DB;
use App\Models\Graficos_indicativos;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;
use App\Repositories\IndicadorRepository;
use App\Http\Requests\GraficoInserRequest;
use App\Http\Requests\IndicadorThemeRequest;
use App\Repositories\IndicadorThemeRepository;
use App\Repositories\infoIndicadoresRepository;
use App\Repositories\PendenteIndicadorRepository;
use App\Http\Requests\IndicadorThemeRequestUpdate;
use App\Http\Requests\IndicadorThemeLayout1Request;
use App\Repositories\GraficosIndicativosRepository;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;

class IndicadorThemeController extends BaseWebController
{

    protected $themeIndicador;
    protected $indicadorRepository;
    protected $pendenteIndicador;
    protected $infoIndicadores;
    protected $graficos_indicativos;

    protected $grafico;
    protected $info;
    public function __construct(
        infoIndicadoresRepository $info,
        GraficosIndicativosRepository $graficos_indicativos,
        Info_indicadores $infoIndicadores,
        PendenteIndicadorRepository $pendenteIndicador,
        FaixaEtariaImport $grafico,
        IndicadorRepository $indicadorRepository,
        IndicadorThemeRepository $themeIndicador
    ) {
        $this->middleware(function ($request, $next) {
            $this->id = Auth::guard('web')->user();
            parent::__construct($this->id, $request);
            return $next($request);
        });
        $this->themeIndicador       = $themeIndicador;
        $this->indicadorRepository  = $indicadorRepository;
        $this->grafico              = $grafico;
        $this->pendenteIndicador    = $pendenteIndicador;
        $this->infoIndicadores      = $infoIndicadores;
        $this->graficos_indicativos = $graficos_indicativos;
        $this->info                 = $info;
    }

    public function index(Request $request)
    {
        $paginate     = ($request->input('per_page')) ? $request->input('per_page') : 10;
        $orderByField = ($request->input('order_by_field')) ? $request->input('order_by_field') : 'id';
        $orderByOrder = ($request->input('order_by_order')) ? $request->input('order_by_order') : 'DESC';

        return view('dashboard.indicadorTheme.index', [
            "indicador" => $this->themeIndicador->list($request, $orderByField, $orderByOrder, $paginate)
        ]);
    }

    public function create()
    {
        return view('dashboard.indicadorTheme.show', [
            "temas" => $this->indicadorRepository->all()->pluck('name', 'id')
        ]);
    }

    public function notas(Request $request, $id)
    {
        try {

            $findInfo = Indicador_theme::where('id', $id)->first();

            Info_indicadores::where([
                ['id_indicador', "=", $findInfo->id],
                ['ano', "=", $request->input('ano')]
            ])->update(["notas" => $request->input("notas")]);

            $request->session()->flash('alert', ['code' => "success", "text" => "Notas de {$request->input('ano')} adiciona com sucesso"]);
        } catch (Exception $e) {
            $request->session()->flash('alert', ['code' => "danger", "text" => $e->getMessage()]);
        }

        return redirect(route('dash.indicadorTheme.info', $id));
    }

    public function removeGraficoTema(Request $request)
    {
        try {
            foreach ($request->id as $row) {
                $this->info->destroy($row);
            }
            if ($request->deleteAll == true) {
                $this->pendenteIndicador->destroy($request->faixa);
                $request->session()->flash('alert', ['code' => "success", "text" => "Registros removidos com sucesso"]);

                return response()->json(['url' => route('dash.indicadorTheme.info', $request->indicator_id)]);
            }

            $request->session()->flash('alert', ['code' => "success", "text" => "Registros removidos com sucesso"]);
        } catch (Exception $e) {
            $request->session()->flash('alert', ['code' => "danger", "text" => $e->getMessage()]);
        }

        return response()->json(['url' => route('dash.indicadorTheme.info.pendente', $request->faixa)]);
    }

    public function export(Request $request, $id)
    {
        $paginate     = null;
        $orderByField = ($request->input('order_by_field')) ? $request->input('order_by_field') : 'id';
        $orderByOrder = ($request->input('order_by_order')) ? $request->input('order_by_order') : 'DESC';
        $grafic = $this->info->list($request, $orderByField, $orderByOrder, $paginate)
            ->where('enum', $id);

        // dd($grafic);

        return (new Export(new GraficoExport($grafic)))->download();
    }


    public function aprovedGrafic(Request $request, $id)
    {
        try {
            $indicador = $this->pendenteIndicador->find($id);
            $indicador->status = 2;
            $indicador->save();
            Info_indicadores::where('enum', $indicador->enum)->update(["status" => 2]);
            $request->session()->flash('alert', ['code' => 'success', 'text' => 'Gráfico aprovado com sucesso']);
        } catch (Exception $e) {
            $request->session()->flash('alert', ['code' => 'danger', 'text' => $e->getMessage()]);
        }
        return redirect(route('dash.indicadorTheme.info.pendente', $id));
    }


    public function store(IndicadorThemeRequest $request)
    {
        try {
            $this->themeIndicador->create($request->all());
            $request->session()->flash('alert', ['code' => "success", "text" => "Indicador adicionado com sucesso"]);
        } catch (Exception $e) {
            $request->session()->flash('alert', ['code' => "danger", "text" => $e->getMessage()]);
        }
        return redirect(route('dash.indicadorTheme'));
    }

    public function show($id)
    {
        if (empty($id)) {
            abort(404);
        }

        $indicador = $this->themeIndicador->find($id);

        return view('dashboard.indicadorTheme.show', [
            "indicador"     => $indicador,
            "temas" =>      $this->indicadorRepository->all()->pluck('name', 'id'),
            "tema_filho"    => $indicador->tema_filho
        ]);
    }

    public function info($id)
    {
        if (empty($id)) {
            abort(404);
        }
        $indicador = $this->themeIndicador->find($id);

        $info = Info_indicadores::where('id_indicador', $id)->get()->toArray();

        $nomes = [];
        $dados = [];

        foreach ($info as $k => $v) {
            foreach ($v as $name => $value) {
                if (!is_null($value) && !in_array($name, $nomes) && !in_array($name, ['id', 'enum', 'status', 'id_indicador', 'notas', 'created_at', 'updated_at', 'deleted_at'])) {
                    $nomes[] = $name;
                    $dados[$name] = $value;
                }
            }
        }

        // grafico tipo 1
        $grafico = Graficos_indicativos::where([
            ['id_indicador', $id],
            ['tipo', "=", 1]
        ])->get()->last();

        if (!is_null($grafico)) {
            $array = [];
            if ($grafico->x != "null") {
                foreach (json_decode($grafico->x, true) as $row) {
                    array_push($array, $row);
                }
            }

            $array_y = [];
            if ($grafico->y != "null") {
                foreach (json_decode($grafico->y, true) as $row) {
                    array_push($array_y, $row);
                }
            }
        }

        //grafico tipo 2
        $grafico_tipo_dois = Graficos_indicativos::where([
            ['id_indicador', $id],
            ['tipo', "=", 2]
        ])->get()->last();


        if (!is_null($grafico_tipo_dois)) {
            $array_dois = [];
            if ($grafico_tipo_dois->x != "null") {
                foreach (json_decode($grafico_tipo_dois->x, true) as $row) {
                    array_push($array_dois, $row);
                }
            }

            $array_y_dois = [];
            if ($grafico_tipo_dois->y != "null") {
                foreach (json_decode($grafico_tipo_dois->y, true) as $row) {
                    array_push($array_y_dois, $row);
                }
            }
        }

        //grafico tipo 3
        $grafico_tipo_tres = Graficos_indicativos::where([
            ['id_indicador', $id],
            ['tipo', "=", 3]
        ])->get()->last();


        if (!is_null($grafico_tipo_tres)) {
            $array_tres = [];
            if ($grafico_tipo_tres->x != "null") {
                foreach (json_decode($grafico_tipo_tres->x, true) as $row) {
                    array_push($array_tres, $row);
                }
            }

            $array_y_tres = [];
            if ($grafico_tipo_tres->y != "null") {
                foreach (json_decode($grafico_tipo_tres->y, true) as $row) {
                    array_push($array_y_tres, $row);
                }
            }
        }


        $grafico_tipo_quatro = Graficos_indicativos::where([
            ['id_indicador', $id],
            ['tipo', "=", 4]
        ])->get()->last();


        if (!is_null($grafico_tipo_quatro)) {
            $array_quatro = [];
            if ($grafico_tipo_quatro->x != "null") {
                foreach (json_decode($grafico_tipo_quatro->x, true) as $row) {
                    array_push($array_quatro, $row);
                }
            }
        }

        return view('dashboard.indicadorTheme.info', [
            "indicador"     => $indicador,
            "grafico"       => $grafico,
            "grafico_tipo_dois" => $grafico_tipo_dois,
            "grafico_tipo_tres" => $grafico_tipo_tres,
            "grafico_tipo_quatro" => $grafico_tipo_quatro,
            "colunas"       => !empty($nomes) ? $nomes : [],
            "inseridos"     => isset($array) ? $array : [],
            "inseridos_y"    => isset($array_y) ? $array_y : [],
            "inseridos_dois" => isset($array_dois) ? $array_dois : [],
            "inseridos_y_dois" => isset($array_y_dois) ? $array_y_dois : [],
            "inseridos_tres"   => isset($array_tres) ? $array_tres : [],
            "inseridos_y_tres" => isset($array_y_tres) ? $array_y_tres : [],
            "array_quatro"     => isset($array_quatro) ? $array_quatro : [],


        ]);
    }


    public function acao(Request $request, $id)
    {

        $grafico = Graficos_indicativos::findOrFail($id);
        if ($request->input('type') == 1) {
            $request->session()->flash('alert', array('code' => 'success', 'text'  => "Gráfico inativado com sucesso"));
            $grafico->status = 1; // Inativa gráfico
            $grafico->save();

            Info_indicadores::where([
                ["id_indicador", "=", $request->input('id_indicador')]
            ])->update(["status" => "1"]);
        } else {
            $request->session()->flash('alert', array('code' => 'success', 'text'  => "Gráfigo ativado com sucesso"));
            $grafico->status = 2; // Ativa o gráfico
            $grafico->save();

            Info_indicadores::where([
                ["id_indicador", "=", $request->input('id_indicador')]
            ])->update(["status" => "2"]);
        }

        return redirect(route('dash.indicadorTheme.info', $request->input('id_indicador')));
    }

    public function layout1(Request $request, $id)
    {
        if (empty($id)) {
            abort(404);
        }

        try {
            $enum = str_replace('.', '', microtime(true));

            $request->merge([
                "id_indicador" => $id,
                "notas"        => "oi",
                "status"       => 1,
                "enum"         => $enum
            ]);
            $pendenteIndicador = [
                "id_indicador" => $id,
                "notas"        => "oi",
                "status"       => 1,
                "enum"         => $enum
            ];

            if (!empty($request->input('fields'))) {
                foreach ($request->input('fields') as $reck) {
                    $colunas = Schema::getColumnListing("info_indicadores");
                    if (!in_array($reck, $colunas)) {
                        $reck = strtolower($reck);
                        DB::statement("ALTER TABLE `info_indicadores` ADD `{$reck}` VARCHAR(255) NULL AFTER `enum`; ");
                    }
                    $request->merge([
                        $reck        => $reck,
                    ]);
                }
            }

            $install = new Process(['pip', 'install', '-r', 'storage/requirements.txt']);
            $install->run();

            if (!$install->isSuccessful()) {
                /* throw new ProcessFailedException($install); */
                $request->session()->flash('alert', array('code' => 'danger', 'text'  => 'Erro ao instalar as dependencias!'));
                return redirect(route('dash.indicadorTheme.info', $id));
            }
            if ($request->file('file')->extension() == 'txt' || $request->file('file')->extension() == 'csv') {
                $request->file('file')->storeAs('public', 'import.csv');
                $process = new Process(['python', 'storage/import.py', '-i', $id, '-e', $enum, '-s', 1, '-n', 'oi', '-a', 'storage/import.csv']);
            } else {

                $request->file('file')->storeAs('public', 'import.xlsx');
                $process = new Process(['python', 'storage/import.py', '-i', $id, '-e', $enum, '-s', 1, '-n', 'oi', '-a', 'storage/import.xlsx']);
            }

            $process->setTimeout(360000000);
            $process->run();
            if (!$process->isSuccessful()) {
                /*  throw new ProcessFailedException($process); */
                $request->session()->flash('alert', array('code' => 'danger', 'text'  => 'O arquivo processado é inválido, verifique e repita o processo novamente!'));
                return redirect(route('dash.indicadorTheme.info', $id));
            }

            $this->pendenteIndicador->create($request->all());
            $request->session()->flash('alert', array('code' => 'success', 'text'  => "Dados enviados com sucesso. Pendente de avaliação pelo responsável"));
        } catch (Exception $e) {
            $request->session()->flash('alert', array('code' => 'danger', 'text'  => $e->getMessage()));
        }
        return redirect(route('dash.indicadorTheme.info', $id));
    }

    public function grafico(Request $request)
    {
        $request->merge([
            "x" => json_encode($request->input('x')),
            "y" => json_encode($request->input('y'))
        ]);

        if ($request->input("tipo") == 4) {
            $request->merge([
                "y" => json_encode([]),
            ]);
        }

        try {
            $this->graficos_indicativos->create($request->all());
            $request->session()->flash('alert', array('code' => 'success', 'text'  => "Gráfico inserido com sucesso"));
        } catch (Exception $e) {
            $request->session()->flash('alert', array('code' => 'danger', 'text'  => $e->getMessage()));
        }
        return redirect(route('dash.indicadorTheme.info', $request->input('id_indicador')));
    }

    public function updateGrafico(Request $request, $id)
    {

        if (empty($request->input("x"))) {
            $grafico = Graficos_indicativos::findOrFail($id);
            $grafico->forceDelete();
            $request->session()->flash('alert', array('code' => 'success', 'text'  => "Gráfico atualizado com sucesso"));
            return redirect(route('dash.indicadorTheme.info', $request->input('id_indicador')));
        }

        $request->merge([
            "x" => json_encode($request->input('x'))
        ]);

        try {
            Graficos_indicativos::where([
                ["id_indicador", "=", $request->input('id_indicador')],
                ["tipo", "=", $request->input('tipo')],
                ["id", "=", $id]

            ])->update($request->except('_method', '_token'));
            //$this->graficos_indicativos->where('id_indicador', $request->input('id_indicador'))->update($request->all());
            $request->session()->flash('alert', array('code' => 'success', 'text'  => "Gráfico atualizado com sucesso"));
        } catch (Exception $e) {
            $request->session()->flash('alert', array('code' => 'danger', 'text'  => $e->getMessage()));
        }

        return redirect(route('dash.indicadorTheme.info', $request->input('id_indicador')));
    }


    public function update(IndicadorThemeRequestUpdate $request, $id)
    {

        try {
            $this->themeIndicador->update($request->all(), $id);
            $request->session()->flash('alert', ['code' => "success", "text" => "Indicador atualizado com sucesso"]);
        } catch (Exception $e) {
            $request->session()->flash('alert', ['code' => "danger", "text" => $e->getMessage()]);
        }
        return redirect(route('dash.indicadorTheme'));
    }

    public function destroy($id)
    {
        if (empty($id)) {
            abort(404);
        }
        try {
            $this->themeIndicador->destroy($id);
            session()->flash('alert', ['code' => "success", "text" => "Indicador removido com sucesso"]);
        } catch (Exception $e) {
            session()->flash('alert', ['code' => "danger", "text" => $e->getMessage()]);
        }
        return redirect(route('dash.indicadorTheme'));
    }


    public function removeIndicador(Request $request, $id)
    {
        try {
            $pendente = $this->pendenteIndicador->destroy($id);
            Info_indicadores::where('enum', $pendente->enum)->delete();
            $request->session()->flash('alert', ['code' => 'success', 'text' => 'Gráfico e Indicador removido com sucesso']);
        } catch (Exception $e) {
            $request->session()->flash('alert', ['code' => 'danger', 'text' => $e->getMessage()]);
        }
        return redirect(route('dash.indicadorTheme', $request->input('indicator_id')));
    }

    public function showPendente(Request $request, $id)
    {
        if (empty($id)) {
            abort(404);
        }

        $paginate     = ($request->input('per_page')) ? $request->input('per_page') : 500;
        $orderByField = ($request->input('order_by_field')) ? $request->input('order_by_field') : 'id';
        $orderByOrder = ($request->input('order_by_order')) ? $request->input('order_by_order') : 'DESC';

        $pendente = $this->pendenteIndicador->find($id);

        //dd($pendente);
        $buscaResult = Info_indicadores::where('enum', $pendente->enum)->paginate(25);

        $names = [];
        $buscaResult2 = Info_indicadores::where('enum', $pendente->enum)->first();
        if (!empty($buscaResult2)) {
            foreach ($buscaResult2->toArray() as $name => $value) {
                if (in_array($name, ['created_at', 'updated_at', 'deleted_at', 'id_indicador', 'enum', 'notas', 'status'])) {
                    continue;
                }
                $names[] = $name;
            }
        }

        return view('dashboard.indicadorTheme.pendente', [
            "grafico"   => !empty($pendente) ? $pendente : [],
            "resultado" => !empty($buscaResult) ? $buscaResult : [],
            "names"     => !empty($names) ? $names : []
        ]);
    }
}

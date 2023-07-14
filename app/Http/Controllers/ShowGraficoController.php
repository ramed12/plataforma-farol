<?php

namespace App\Http\Controllers;

use App\Models\Grafico;
use App\Models\Info_indicadores;
use Illuminate\Http\Request;
use App\Repositories\GraficosIndicativosRepository;
use App\Repositories\infoIndicadoresRepository;
use App\Models\Graficos_indicativos;

class ShowGraficoController extends Controller
{
    protected $grafico_indicativo;
    protected $info;

    public function __construct(GraficosIndicativosRepository $grafico, infoIndicadoresRepository $info)
    {
        $this->grafico_indicativo = $grafico;
        $this->info = $info;
    }


    public function gerar(Request $request)
    {

        $valores = [];
        $titulos = [];
        $dataset = [];

        switch ($request->input('type_grafico')) {
            case 1:
                $graf = "bar";
                break;
            case 2:
                $graf = "line";
                break;
            case 3:
                $graf = "pie";
                break;
            case 4:
                $graf = "radar";
                break;
            case 5:
                $graf = "polarArea";
                break;
            default;
                $graf = "bar";
        }

        //dd($request->all());
        if ($request->input('estado') == 'PE') {

            $consulta = Info_indicadores::where([
                ["id_indicador", "=", $request->input('id_indicativo')],
                ["ano", "=", $request->input('ano')],
                ["estado", "=", $request->input('estado')],
                ["cidade", "!=", null]
            ])->get()->toArray();
        } else {
            $consulta = Info_indicadores::where([
                ["id_indicador", "=", $request->input('id_indicativo')],
                ["ano", "=", $request->input('ano')],
                ["estado", "=", $request->input('estado')]
            ])->get()->toArray();
        }
        if (empty($consulta)) {

            $request->session()->flash('alert', ['code' => 'danger', 'text' => 'Não existe dados para gerar o gráfico']);
            return \Redirect::back();
        }
        foreach ($consulta as $row => $value) {
            foreach ($value as $k => $v) {
                if (in_array($k, $request->input('x'))) {
                    if (empty($valores[$k])) {
                        $valores[$k] = [];
                    }
                    $valores[$k][] = $v;
                }
            }
        }

        foreach ($valores as $k => $v) {
            $dataset[] = [
                "label" => ucfirst(str_replace('_', ' ', $k)),
                // 'backgroundColor' => "rgba(194,31,241, .5)",
                // 'borderColor' => "rgba(194,31,241, 0.7)",
                // "pointBorderColor" => "rgba(194,31,241, 0.7)",
                // "pointBackgroundColor" => "rgba(194,31,241, 0.7)",
                // "pointHoverBackgroundColor" => "#fff",
                // "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => array_values($v)
            ];
        }

        if ($request->input('estado') == 'PE') {

            $consulta = Info_indicadores::where([
                ["id_indicador", "=", $request->input('id_indicativo')],
                ["ano", "=", $request->input('ano')],
                ["estado", "=", $request->input('estado')],
                ["cidade", "!=", null]
            ])->get()->toArray();
        } else {
            $consulta = Info_indicadores::where([
                ["id_indicador", "=", $request->input('id_indicativo')],
                ["ano", "=", $request->input('ano')],
                ["estado", "=", $request->input('estado')]
            ])->get()->toArray();
        }

        foreach ($consulta as $row => $value) {
            foreach ($value as $k => $v) {
                if ($request->input('titulo') == $k) {
                    $titulos[] = $v;
                }
            }
        }

        $chartjs_meio = app()->chartjs
            ->name('grafico_meio')
            ->type($graf)
            ->size(['width' => 650, 'height' => 290])
            ->labels($titulos)
            ->datasets($dataset)
            ->options([]);

        // var_dump($titulos);
        // var_dump(array_keys($valores));
        // var_dump(array_values($valores));
        // exit;

        return view('tabelas.gerar', [
            "grafico_meio" => (!empty($consulta) ? (!empty($chartjs_meio) ? $chartjs_meio->render() : []) : []),
        ]);
    }


    public function table(Request $request)
    {

        $grafico = Graficos_indicativos::where([
            ["id_indicador", "=", $request->input('id_indicativo')],
            ["tipo", "=", 4]
        ])->first();

        $values = [];
        $names = [];
        $dataset = [];


        $consulta = Info_indicadores::where([
            ["id_indicador", "=", $request->input('id_indicativo')],
            ["ano", "=", $request->input('ano')],
            ["status", "=", 2],
            ["estado", "=", $request->input('estado')],
            ["cidade", "=", $request->input('estado') == 'PE' ? $request->input('cidade') : null]
        ])->get()->toArray();


        if (!empty($grafico)) {
            $zz = json_decode($grafico->x, true);
            foreach ($consulta as $value) {
                foreach ($value as $k => $v) {
                    if (in_array($k, $zz)) {
                        if (!is_null($v)) {
                            $values[$k][] = $v;
                            if (!in_array($k, $names)) {
                                $names[] = $k;
                            }
                        }
                    }
                }
            }
        }

        return view('tabelas.faixaEtariatable', [
            "table" => $values
        ]);
    }


    public function index(Request $request)
    {
        if ($request->input('tipo') == 1) {
            $grafico = Graficos_indicativos::where([
                ["id_indicador", "=", $request->input('id_indicativo')],
                ["tipo", "=", 1]
            ])->first();

            $values = [];
            $names = [];
            $dataset = [];

            $values2 = [];
            $names2 = [];
            $dataset2 = [];

            if ($request->input('estado') == 'PE') {

                if (!empty($request->input('cidade'))) {
                    $consulta = Info_indicadores::where([
                        ["id_indicador", "=", $request->input('id_indicativo')],
                        ["ano", "=", $request->input('ano')],
                        ["estado", "=", $request->input('estado')],
                        ["status", "=", 2],
                        ["cidade", "=", $request->input('cidade')]
                    ])->get()->toArray();
                } else {
                    $consulta = Info_indicadores::where([
                        ["id_indicador", "=", $request->input('id_indicativo')],
                        ["ano", "=", $request->input('ano')],
                        ["estado", "=", $request->input('estado')],
                        ["status", "=", 2],
                        ["cidade", "!=", null]
                    ])->get()->toArray();
                }
            } else {
                if (!empty($request->input('estado'))) {
                    $consulta = Info_indicadores::where([
                        ["id_indicador", "=", $request->input('id_indicativo')],
                        ["ano", "=", $request->input('ano')],
                        ["estado", "=", $request->input('estado')],
                        ["status", "=", 2]
                    ])->get()->toArray();
                } else {

                    $consulta = Info_indicadores::where([
                        ["id_indicador", "=", $request->input('id_indicativo')],
                        ["ano", "=", $request->input('ano')],
                        ["status", "=", 2]
                    ])->get()->toArray();
                }
            }

            $notas = Info_indicadores::where([
                ["id_indicador", "=", $request->input('id_indicativo')],
                ["ano", "=", $request->input('ano')],
                ["status", "=", 2]
            ])->whereNotNull('notas')->groupBy('notas')->get()->last();

            if (!empty($notas)) {
                $notas->toArray();
            }

            if (!empty($grafico)) {
                $zz = json_decode($grafico->x, true);
                $bb = json_decode($grafico->y, true);
                $nome_primeiro = $grafico->name;
                $tipo_grafico = $grafico->piramede;
                $formato = $grafico->type_grafico;
                switch ($formato) {
                    case 1:
                        $graf = "bar";
                        break;
                    case 2:
                        $graf = "line";
                        break;
                    case 3:
                        $graf = "pie";
                        break;
                    case 4:
                        $graf = "radar";
                        break;
                    case 5:
                        $graf = "polarArea";
                        break;
                    default;
                        $graf = "bar";
                }
            }


            if (!empty($bb) || !empty($zz)) {

                foreach ($consulta as $value) {
                    foreach ($value as $k => $v) {
                        if (in_array($k, $zz)) {
                            if (!is_null($v)) {
                                $values[$k][] = $v;
                                if (!in_array($k, $names)) {
                                    $names[] = $k;
                                }
                            }
                        }
                    }
                }

                foreach ($consulta as $value) {
                    foreach ($value as $k => $v) {
                        if (in_array($k, $bb)) {
                            if (!is_null($v)) {
                                if (!in_array($v, $values2)) {
                                    $values2[] = $v;
                                }
                                if (!in_array($k, $names2)) {
                                    $names2[] = $k;
                                }
                            }
                        }
                    }
                }
            }

            if (!empty($tipo_grafico)) {
                $i = false;
                $biggest = 0;
                foreach ($values as $k => $v) {
                    $value = array_reverse($v);
                    foreach ($value as $x) {
                        if ($x > $biggest) {
                            $biggest = $x;
                        }
                    }
                    $dataset[] = [
                        "label" => ucfirst(str_replace('_', ' ', $k)),
                        // 'backgroundColor' => "rgba(194,31,241, .5)",
                        // 'borderColor' => "rgba(194,31,241, 0.7)",
                        // "pointBorderColor" => "rgba(194,31,241, 0.7)",
                        // "pointBackgroundColor" => "rgba(194,31,241, 0.7)",
                        // "pointHoverBackgroundColor" => "#fff",
                        // "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        'data' => (!$i ? $value : array_map(fn ($x) => '-' . $x, $value))
                    ];
                    $i = !$i;
                }

                #var_dump($dataset);
                #exit;

                $padding = 30;

                //$biggest

                if (!empty($grafico)) {
                    $chartjs_meio = app()->chartjs
                        ->name('grafico_meio')
                        ->type('bar')
                        ->size(['width' => 950, 'height' => 700])
                        ->labels(array_reverse($values2))
                        ->datasets($dataset)
                        ->optionsRaw('{
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: (ttItem) => (Math.abs(ttItem.parsed.x))
                                }
                            }
                        },
                        indexAxis: "y",
                        scales: {
                            y: {
                                stacked: true,
                                grid: {
                                    display: false
                                }
                            },
                            x: {
                                min: -' . 1000 . ',
                                max: ' . 1000 . ',
                                ticks: {
                                    callback: (val) => (Math.abs(val))
                                }
                            }
                        }
                    }');
                    /*->options([
                        "indexAxis" => "y",
                        "scales" => [
                            "x" => [
                                "stacked" => true
                            ],

                            "y" => [
                                "stacked" => true
                            ],
                        ],
                        "plugins" => [
                            "tooltip" => [
                                "yAlign" => "bottom",
                                "titleAlign" => "center"
                            ]
                        ]
                    ]);*/
                } else {
                    $chartjs_meio = [];
                }
            } else {

                foreach ($values as $k => $v) {
                    $dataset[] = [
                        "label" => ucfirst(str_replace('_', ' ', $k)),
                        // 'backgroundColor' => "rgba(194,31,241, .5)",
                        // 'borderColor' => "rgba(194,31,241, 0.7)",
                        // "pointBorderColor" => "rgba(194,31,241, 0.7)",
                        // "pointBackgroundColor" => "rgba(194,31,241, 0.7)",
                        // "pointHoverBackgroundColor" => "#fff",
                        // "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        'data' => array_values($v)
                    ];
                }


                if (!empty($grafico)) {
                    $chartjs_meio = app()->chartjs
                        ->name('grafico_meio')
                        ->type($graf)
                        ->size(['width' => 950, 'height' => 700])
                        ->labels($values2)
                        ->datasets($dataset)
                        ->options([]);
                } else {
                    $chartjs_meio = [];
                }
            }


            // grafico 2


            $grafico = Graficos_indicativos::where([
                ["id_indicador", "=", $request->input('id_indicativo')],
                ["tipo", "=", 2]
            ])->first();

            $values = [];
            $names = [];
            $dataset = [];

            $values2 = [];
            $names2 = [];
            $dataset2 = [];


            if ($request->input('estado') == 'PE') {
                if (!empty($request->input('cidade'))) {
                    $consulta = Info_indicadores::where([
                        ["id_indicador", "=", $request->input('id_indicativo')],
                        ["ano", "=", $request->input('ano')],
                        ["estado", "=", $request->input('estado')],
                        ["status", "=", 2],
                        ["cidade", "=", $request->input('cidade')]
                    ])->get()->toArray();
                } else {
                    $consulta = Info_indicadores::where([
                        ["id_indicador", "=", $request->input('id_indicativo')],
                        ["ano", "=", $request->input('ano')],
                        ["estado", "=", $request->input('estado')],
                        ["status", "=", 2],
                        ["cidade", "!=", null]
                    ])->get()->toArray();
                }
            } else {
                if (!empty($request->input('estado'))) {
                    $consulta = Info_indicadores::where([
                        ["id_indicador", "=", $request->input('id_indicativo')],
                        ["ano", "=", $request->input('ano')],
                        ["estado", "=", $request->input('estado')],
                        ["status", "=", 2]
                    ])->get()->toArray();
                } else {

                    $consulta = Info_indicadores::where([
                        ["id_indicador", "=", $request->input('id_indicativo')],
                        ["ano", "=", $request->input('ano')],
                        ["status", "=", 2]
                    ])->get()->toArray();
                }
            }

            if (!empty($grafico)) {
                $zz = json_decode($grafico->x, true);
                $bb = json_decode($grafico->y, true);
                $nome_segundo = $grafico->name;
                $formato = $grafico->type_grafico;
                switch ($formato) {
                    case 1:
                        $graf = "bar";
                        break;
                    case 2:
                        $graf = "line";
                        break;
                    case 3:
                        $graf = "pie";
                        break;
                    case 4:
                        $graf = "radar";
                        break;
                    case 5:
                        $graf = "polarArea";
                        break;
                    default;
                        $graf = "bar";
                }
            }

            if (!empty($bb) || !empty($zz)) {
                foreach ($consulta as $value) {
                    foreach ($value as $k => $v) {
                        if (in_array($k, $zz)) {
                            if (!is_null($v)) {
                                $values[$k][] = $v;
                                if (!in_array($k, $names)) {
                                    $names[] = $k;
                                }
                            }
                        }
                    }
                }

                foreach ($consulta as $value) {
                    foreach ($value as $k => $v) {
                        if (in_array($k, $bb)) {
                            if (!is_null($v)) {
                                if (!in_array($v, $values2)) {
                                    $values2[] = $v;
                                }
                                if (!in_array($k, $names2)) {
                                    $names2[] = $k;
                                }
                            }
                        }
                    }
                }
            }

            foreach ($values as $k => $v) {
                $dataset[] = [
                    "label" => ucfirst(str_replace('_', ' ', $k)),
                    // 'backgroundColor' => "rgba(194,31,241, .5)",
                    // 'borderColor' => "rgba(194,31,241, 0.7)",
                    // "pointBorderColor" => "rgba(194,31,241, 0.7)",
                    // "pointBackgroundColor" => "rgba(194,31,241, 0.7)",
                    // "pointHoverBackgroundColor" => "#fff",
                    // "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => array_values($v)
                ];
            }

            if (!empty($grafico)) {
                $chartjs_esquerda = app()->chartjs
                    ->name('grafico_esquerda')
                    ->type($graf)
                    ->size(['width' => 650, 'height' => 290])
                    ->labels($values2)
                    ->datasets($dataset)
                    ->options([]);
            } else {
                $chartjs_esquerda = '';
            }


            //GRAFICO 3

            $grafico = Graficos_indicativos::where([
                ["id_indicador", "=", $request->input('id_indicativo')],
                ["tipo", "=", 3]
            ])->first();

            $values = [];
            $names = [];
            $dataset = [];

            $values2 = [];
            $names2 = [];
            $dataset2 = [];


            if ($request->input('estado') == 'PE') {
                if (!empty($request->input('cidade'))) {
                    $consulta = Info_indicadores::where([
                        ["id_indicador", "=", $request->input('id_indicativo')],
                        ["ano", "=", $request->input('ano')],
                        ["estado", "=", $request->input('estado')],
                        ["status", "=", 2],
                        ["cidade", "=", $request->input('cidade')]
                    ])->get()->toArray();
                } else {
                    $consulta = Info_indicadores::where([
                        ["id_indicador", "=", $request->input('id_indicativo')],
                        ["ano", "=", $request->input('ano')],
                        ["estado", "=", $request->input('estado')],
                        ["status", "=", 2],
                        ["cidade", "!=", null]
                    ])->get()->toArray();
                }
            } else {
                if (!empty($request->input('estado'))) {
                    $consulta = Info_indicadores::where([
                        ["id_indicador", "=", $request->input('id_indicativo')],
                        ["ano", "=", $request->input('ano')],
                        ["estado", "=", $request->input('estado')],
                        ["status", "=", 2]
                    ])->get()->toArray();
                } else {

                    $consulta = Info_indicadores::where([
                        ["id_indicador", "=", $request->input('id_indicativo')],
                        ["ano", "=", $request->input('ano')],
                        ["status", "=", 2]
                    ])->get()->toArray();
                }
            }

            if (!empty($grafico)) {
                $zz = json_decode($grafico->x, true);
                $bb = json_decode($grafico->y, true);
                $nome_terceiro = $grafico->name;
                $formato = $grafico->type_grafico;

                switch ($formato) {
                    case 1:
                        $graf = "bar";
                        break;
                    case 2:
                        $graf = "line";
                        break;
                    case 3:
                        $graf = "pie";
                        break;
                    case 4:
                        $graf = "radar";
                        break;
                    case 5:
                        $graf = "polarArea";
                        break;
                    default;
                        $graf = "bar";
                }
            }

            if (!empty($bb) || !empty($zz)) {

                foreach ($consulta as $value) {
                    foreach ($value as $k => $v) {
                        if (in_array($k, $zz)) {
                            if (!is_null($v)) {
                                $values[$k][] = $v;
                                if (!in_array($k, $names)) {
                                    $names[] = $k;
                                }
                            }
                        }
                    }
                }

                foreach ($consulta as $value) {
                    foreach ($value as $k => $v) {
                        if (in_array($k, $bb)) {
                            if (!is_null($v)) {
                                if (!in_array($v, $values2)) {
                                    $values2[] = $v;
                                }
                                if (!in_array($k, $names2)) {
                                    $names2[] = $k;
                                }
                            }
                        }
                    }
                }
            }
            foreach ($values as $k => $v) {
                $dataset[] = [
                    "label" => ucfirst(str_replace('_', ' ', $k)),
                    // 'backgroundColor' => "rgba(194,31,241, .5)",
                    // 'borderColor' => "rgba(194,31,241, 0.7)",
                    // "pointBorderColor" => "rgba(194,31,241, 0.7)",
                    // "pointBackgroundColor" => "rgba(194,31,241, 0.7)",
                    // "pointHoverBackgroundColor" => "#fff",
                    // "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => array_values($v)
                ];
            }


            if (!empty($grafico)) {
                $chartjs_esquerda_abaixo = app()->chartjs
                    ->name('grafico_esquerda_abaixo')
                    ->type($graf)
                    ->size(['width' => 650, 'height' => 290])
                    ->labels($values2)
                    ->datasets($dataset)
                    ->options([]);
            } else {
                $chartjs_esquerda_abaixo = '';
            }
        }

        return view('tabelas.faixaEtaria', [
            "grafico_meio" => (!empty($consulta) ? (!empty($chartjs_meio) ? $chartjs_meio->render() : []) : []),
            "grafico_esquerda" => (!empty($consulta) ? (!empty($chartjs_esquerda) ? $chartjs_esquerda->render() : []) : []),
            "chartjs_esquerda_abaixo" => (!empty($consulta) ? (!empty($chartjs_esquerda_abaixo) ? $chartjs_esquerda_abaixo->render() : []) : []),
            "notas" => $notas,
            "nome_primeiro" => isset($nome_primeiro) ? $nome_primeiro : [],
            "nome_segundo" => isset($nome_segundo) ? $nome_segundo : [],
            "nome_terceiro" => isset($nome_terceiro) ? $nome_terceiro : [],
        ]);
    }
}

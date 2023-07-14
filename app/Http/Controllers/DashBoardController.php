<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\UserVisit;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\IndicadorRepository;
use App\Http\Controllers\BaseWebController;

class DashBoardController extends BaseWebController
{

    protected $user;
    protected $indicador;
    public function __construct(IndicadorRepository $indicador, UserRepository $user, Request $request)
    {
        $this->middleware(function ($request, $next) {
            $this->id = Auth::guard('web')->user();
            parent::__construct($this->id, $request);
            return $next($request);
        });

        $this->indicador = $indicador;
        $this->user = $user;
    }

    public function index()
    {
        // dd($this->indicador->whereNotNull('deleted_at'));

        $data = Carbon::today()->toDateString();
        $dataOntem = date('Y-m-d', strtotime('-1 days'));

        $chartjs = app()->chartjs
            ->name('lineChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['Visitas de Hoje', 'Visitas de Ontem'])
            ->datasets([
                [
                    "label" => "Visitas de Hoje",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [UserVisit::where('created_at', 'like', "%{$data}%")->count(), UserVisit::where('created_at', 'like', "%{$dataOntem}%")->count()],
                ]
            ])
            ->options([]);

        /*  if ($this->indicador->where('status', 2) != 0) {
            $ativo = $this->indicador->where('status', 2)->count();
        } else {
            $ativo = 0;
        } */

        $ativo = 0;

        return view('dashboard.index', [
            "indicador"         => $this->indicador->all()->count(),
            "indicadorAtivo"    => $ativo,
            "indicadorInativo"  => $this->indicador->where('status', 1),
            "indicadorRemovido" => $this->indicador->whereNotNull('deleted_at'),
            'grafico'           => $chartjs,
        ]);
    }

    public function changePassword()
    {
        return view('dashboard.senha', []);
    }

    public function newUser()
    {
        return view('dashboard.user');
    }

    public function listUser(Request $request)
    {
        $paginate     = ($request->input('per_page')) ? $request->input('per_page') : 10;
        $orderByField = ($request->input('order_by_field')) ? $request->input('order_by_field') : 'id';
        $orderByOrder = ($request->input('order_by_order')) ? $request->input('order_by_order') : 'DESC';
        return view('dashboard.list-user', [
            "user" => $this->user->list($request, $orderByField, $orderByOrder, $paginate)
        ]);
    }

    public function destroy($id)
    {
        try {
            $this->user->destroy($id);
            session()->flash('alert', ["code" => "success", "text" => "Usuário removido com sucesso"]);
        } catch (Exception $e) {
            session()->flash('alert', ["code" => "success", "text" => $e->getMessage()]);
        }
        return redirect(route('dash.user.list'));
    }
}

<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Grafico;
use App\Mail\SendNewUser;
use App\Models\UserVisit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\RecoveryPassword;
use App\Http\Requests\UserRequest;
use App\Mail\sendRecoveryPassword;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Repositories\GraficoRepository;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UserRecoveryRequest;
use App\Http\Controllers\Contracts\UserControllerInterface;
use App\Repositories\PanelRepository;
use App\Repositories\IndicadorRepository;
use App\Repositories\IndicadorThemeRepository;

class UserController extends Controller implements UserControllerInterface
{
    protected $user;
    protected $faixaEtaria;
    protected $panelRepository;
    protected $indicadorRepository;
    protected $indicadorTema;

    public function __construct(
        IndicadorThemeRepository $indicadorTema,
        IndicadorRepository $indicadorRepository,
        PanelRepository $panelRepository,
        GraficoRepository $faixaEtaria,
        UserRepository $user
    ) {
        $this->user = $user;
        $this->faixaEtaria = $faixaEtaria;
        $this->panelRepository = $panelRepository;
        $this->indicadorRepository = $indicadorRepository;
        $this->indicadorTema = $indicadorTema;
    }

    public function index(Request $request)
    {
        return view('usuario.index', [
            "panel" => $this->panelRepository->all(),
        ]);
    }

    public function painel($id)
    {
        if (empty($id)) {
            abort(404);
        }
        //        dd($id, $this->indicadorRepository->whereS('tema_filho', $id), $this->panelRepository->all());
        return view('usuario.temas', [
            "temas" => $this->indicadorRepository->whereS('tema_filho', $id),
            "panel" => $this->panelRepository->all(),
            "id" => $id
        ]);
    }

    public function indicativos($id_painel, $id_indicativo, Request $request)
    {

        if (empty($id_painel) || empty($id_indicativo)) {
            abort(404);
        }

        /*  $url = "https://servicodados.ibge.gov.br/api/v1/localidades/estados";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        $response = json_decode(json_encode($response));

        $url = "https://servicodados.ibge.gov.br/api/v1/localidades/estados/PE/municipios";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_cidades = curl_exec($ch);
        curl_close($ch);
        $response_cidades = json_decode($response_cidades, true);
        $response_cidades = json_decode(json_encode($response_cidades));

        if (empty($response)) {
            $request->session()->flash(
                'alert',
                ["code" => "danger", "text" => "Não foi possível carregar os dados, tente novamente mais tarde"]
            );
            return redirect()->route('painel_home', ['id' => $id_painel]);
        } */

        $db_estado = \DB::table('info_indicadores');
        $db_estado = $db_estado->select('estado')->where('estado', '!=', null)->where('id_indicador', $id_indicativo)->where('status', 2)->distinct()->get(['estado']);

        $state = $request->all();

        foreach ($db_estado as $estado) {
            if ($estado == $state) {
                $state = $estado;
            } else {
                $request->session()->flash(
                    'alert',
                    ["code" => "danger", "text" => "Estado não encontrado, tente novamente"]
                );
            }
        }

        $db_cidade = \DB::table('info_indicadores');
        $db_cidade = $db_cidade->select('cidade')->distinct()->where('cidade', '!=', '')->where('cidade', '!=', null)->where('id_indicador', $id_indicativo)->where('status', 2)->get(['cidade']);

        $city = $request->input('cidade');

        foreach ($db_cidade as $cidade) {
            if ($cidade->cidade != null) {
                $city = $cidade->cidade;
            } else {
                $request->session()->flash(
                    'alert',
                    ["code" => "danger", "text" => "Cidade não encontrada, tente novamente"]
                );
            }
        }

        return view('usuario.indicativos', [
            "panel" => $this->panelRepository->all(),
            "id" => $id_painel,
            /*  "response" => $response,
            "response_cidades" => $response_cidades, */
            "state" => $state,
            "estado_db" => $db_estado,
            "city" => $city,
            "cidade_db" => $db_cidade,
            "indicativo" => $this->indicadorTema->find($id_indicativo)
        ]);
    }

    public function about()
    {
        return view('usuario.about');
    }


    public function auth(UserRequest $request)
    {
        $auth = $this->user->where('email', $request->input('email'));

        if ($auth != null) {
            if ($auth->status == 1) {
                $request->session()->flash('alert', [
                    "code" => "danger",
                    "text" => "Seu cadastro ainda está pendente de conclusão, acesse seu e-mail e preencha as informações"
                ]);
                return redirect()->route('auth');
            }
        }
        if (Auth::guard('web')->attempt($request->except('_token'))) {
            $request->session()->flash('alert', ["code" => "success", "text" => "Login realizado com sucesso..."]);
            return redirect()->route('dashboard');
        }
        $request->session()->flash(
            'alert',
            ["code" => "danger", "text" => "Login ou senha incorretos, tente novamente"]
        );
        return redirect()->route('auth');
    }

    public function recovery(UserRecoveryRequest $request)
    {
        $auth = $this->user->where('email', $request->input('email'));
        if (empty($auth)) {
            $request->session()->flash(
                'alert',
                ["code" => "warning", "text" => "E-mail não encontrado, por favor, tente novamente"]
            );
            return redirect()->route('auth.recovery');
        }

        try {
            $token = Str::random(125);
            // Insere o token para recuperação de senha
            $auth->token = $token;
            $auth->save();
            // Encerra a inserção do token para recuperação de senha

            Mail::send(new RecoveryPassword($auth));
            $request->session()->flash(
                'alert',
                ["code" => "success", "text" => "Enviamos um link no e-mail cadastrado."]
            );
        } catch (Exception $e) {
            $request->session()->flash('alert', ["code" => "danger", "text" => $e->getMessage()]);
        }
        return redirect()->route('auth.recovery');
    }

    public function tokenRecovery($token)
    {
        if (empty($token)) {
            session()->flash(
                'alert',
                ['code' => 'danger', 'text' => 'É necessário um TOKEN para autorizar a alteração de senha']
            );
            return redirect()->route('auth');
        }

        $auth = $this->user->where('token', $token);

        if (empty($auth)) {
            session()->flash(
                'alert',
                ['code' => 'danger', 'text' => 'O Token informado já foi utilizado e não está mais válido.']
            );
            return redirect()->route('auth');
        }

        $password = Str::random(5);
        try {
            Mail::send(new sendRecoveryPassword($auth, $password));
            $auth->password = $password;
            $auth->token = null;
            $auth->save();
            session()->flash(
                'alert',
                ['code' => 'success', 'text' => 'Senha atualizada com sucesso. Enviamos uma nova senha em seu e-mail']
            );
        } catch (Exception $e) {
            session()->flash('aler', ['code' => 'danger', 'text' => $e->getMessage()]);
        }

        return redirect()->route('auth');
    }

    public function newUserSend(CreateUserRequest $request)
    {

        try {
            $request->merge([
                "status" => 1,
                "password" => Str::random(7)
            ]);

            $user = $this->user->create($request->except('_token'));

            if ($user) {
                session()->flash('alert', ['code' => 'success', 'text' => 'Usuário cadastrado com sucesso.']);
                //Gera token para o usuário validar o cadastro e salva no banco de dados
                $random = Str::random(180) . $user->id;
                $user->newRegister = $random;
                $user->save();

                //Envia e-mail ao usuário
                Mail::send(new SendNewUser($user));
            }
        } catch (Exception $e) {
            session()->flash('alert', ['code' => 'danger', 'text' => $e->getMessage()]);
        }

        return redirect()->route('dash.user.list');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flash('alert', ["code" => "success", "text" => "Deslogado com sucesso"]);
        return redirect()->route('auth');
    }

    // Validação ajax

    public function validateCpf(Request $request)
    {
        if (preg_match('/(\d)\1{10}/', $request->input('cpf'))) {
            return response()->json(["status" => "danger", "message" => "Formato do CPF está incorreto"]);
        }
        $cpf = $request->input('cpf');

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return response()->json(["status" => "danger", "message" => "CPF digitado não é válido"]);
            }
        }
        $auth = $this->user->where('cpf', $request->input('cpf'));
        if (!empty($auth)) {
            return response()->json(["status" => "danger", "message" => "CPF já cadastrado, por favor, utilize outro"]);
        }
        return response()->json(["status" => "success", "message" => "CPF disponível para uso"]);
    }

    public function validateEmail(Request $request)
    {
        $auth = $this->user->where('email', $request->input('email'));
        if (!empty($auth)) {
            return response()->json([
                "status" => "danger",
                "message" => "E-mail já cadastrado, por favor, utilize outro"
            ]);
        }
        return response()->json(["status" => "success", "message" => "E-mail disponível para uso"]);
    }

    public function indicativos2($id_indicativo, $id_painel, Request $request)
    {
        if (empty($id_painel) || empty($id_indicativo)) {
            abort(404);
        }

        if ($request->input('estado') === 'PE') {

            $url = "https://servicodados.ibge.gov.br/api/v1/localidades/estados/PE/municipios";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response_cidades = curl_exec($ch);
            curl_close($ch);
            $response_cidades = json_decode($response_cidades, true);
            $response_cidades = json_decode(json_encode($response_cidades));

            $db_estado = [];
            $db_cidade = \DB::table('info_indicadores');
            $db_cidade = $db_cidade->select(\DB::RAW('cidade, count(cidade) as total_por_cidade'))->where('cidade', '!=', null)->where('id_indicador', $id_indicativo)->where('status', 2)->distinct()->groupBy('cidade')->get(['cidade']);
            /*  dd($db_estado, $db_cidade); */
            $response = [];
        } else {

            $response_cidades = [];
            $url = "https://servicodados.ibge.gov.br/api/v1/localidades/estados";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response, true);
            $response = json_decode(json_encode($response));

            $db_estado = \DB::table('info_indicadores');
            $db_estado = $db_estado->select(\DB::RAW('estado, count(estado) as total_por_estado'))->where('estado', '!=', null)->where('id_indicador', $id_indicativo)->where('status', 2)->distinct()->groupBy('estado')->get(['estado']);
            $db_cidade = [];
        }

        return view('indicador.index', [
            "id" => $id_painel,
            "id_indicativo" => $id_indicativo,
            "response" => $response,
            "response_cidades" => $response_cidades,
            "estado_db" => $db_estado,
            "cidade_db" => $db_cidade,
            "ano" => '2021',
            "indicativo" => $this->indicadorTema->find($id_indicativo)
        ]);
    }
}

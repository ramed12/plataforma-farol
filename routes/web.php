<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\GroupUserController;
use App\Http\Controllers\IndicadorController;
use App\Repositories\Contracts\UserContracts;
use App\Http\Controllers\InstituicaoController;
use App\Http\Controllers\ShowGraficoController;
use App\Http\Controllers\InsertGraficoController;
use App\Http\Controllers\IndicadorThemeController;
use App\Http\Controllers\RemovePendenteGraficController;
Route::get('/logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class,'index']);

Route::get('/', [UserController::class, 'index'])->name('home');
Route::get('painel/{id}', [UserController::class, 'painel'])->name('painel_home');
//maps
Route::get('painel/{id_painel}/{id}/indicativo', [UserController::class, 'indicativos'])->name('indicativos_home');

Route::get('/auth', [HomeController::class, 'index'])->name('auth');
Route::post('/auth', [UserController::class, 'auth'])->name('auth.post');
Route::get('/senha', [HomeController::class, 'recovery'])->name('auth.recovery');
Route::post('/senha', [UserController::class, 'recovery'])->name('auth.recovery.post');
Route::post('/token/{token}', [UserController::class, 'tokenRecovery'])->name('auth.recovery.token');

Route::get('dash/rotas', [RouteController::class, 'index'])->name('routeController');

Route::get('/register/{token}', [HomeController::class, 'newRegister'])->name('auth.register');

Route::post('/register/{id}', [HomeController::class, 'user'])->name('user.update');

Route::get('grafico/show', [ShowGraficoController::class, 'index'])->name('grafico.show');

Route::get('grafico/gerar', [ShowGraficoController::class, 'gerar'])->name('grafico.gerar');


Route::get('grafico/show/table/', [ShowGraficoController::class, 'table'])->name('grafico.table');
Route::get('/sobre', [UserController::class, 'about'])->name('about');

Route::group(['middleware' => 'auth:web'], function() {
    Route::get('/dash', ['as' => 'dashboard',  'nickname' => 'Usuário Logar no sistema',     'groupname' => 'DashBoard',    'resource' => 'web',    'uses' => 'DashBoardController@index']);
    Route::get('/logout', [UserController::class, 'logout'])->name('auth.logout');
    Route::get('dash/senha', ['as' => 'dash.senha',  'nickname' => 'Usuário alterar senha',     'groupname' => 'DashBoard',    'resource' => 'web',    'uses' => 'DashBoardController@changePassword']);
    Route::get('dash/usuario', ['as' => 'dash.user',  'nickname' => 'Cadastrar usuários',     'groupname' => 'DashBoard',    'resource' => 'web',    'uses' => 'DashBoardController@newUser']);
    Route::get('dash/lista/usuario', ['as' => 'dash.user.list',  'nickname' => 'visualizar usuários cadastrados',     'groupname' => 'DashBoard',    'resource' => 'web',    'uses' => 'DashBoardController@listUser']);
    Route::post('dash/usuario/user', [userController::class, 'newUserSend'])->name('dash.user.post');

    Route::get('dash/usuario/remove/{id}', ['as' => 'dash.user.remove',  'nickname' => 'Excluir usuário cadastrado',     'groupname' => 'DashBoard',    'resource' => 'web',    'uses' => 'DashBoardController@destroy']);

    Route::get('dash/grupo-usuarios', ['as' => 'dash.grupouser',  'nickname' => 'Visualizar Grupos de usuários',     'groupname' => 'DashBoard',    'resource' => 'web',    'uses' => 'GroupUserController@index']);
    Route::get('dash/grupo-usuarios/novo', ['as' => 'dash.show',  'nickname' => 'Cadastrar Grupo de usuários',     'groupname' => 'DashBoard',    'resource' => 'web',    'uses' => 'GroupUserController@show']);
    Route::post('dash/grupo-usuarios/novo', [GroupUserController::class, 'store'])->name('dash.groupuser.store');
    Route::get('dash/grupo-usuarios/{id}', ['as' => 'dash.groupuser.edit',  'nickname' => 'Editar Grupo de usuários',     'groupname' => 'DashBoard',    'resource' => 'web',    'uses' => 'GroupUserController@edit']);
    Route::post('dash/grupo-usuarios/{id}', [GroupUserController::class, 'update'])->name('dash.atualiza');
    //Validate e-mail e cpf ajax

    Route::post('/validateEmail', [UserController::class, 'validateEmail'])->name('validateEmail');
    Route::post('/validateCpf', [UserController::class, 'validateCpf'])->name('validateCpf');

    // Instituições

    Route::get('dash/instituicoes', ['as' => 'dash.instituicao',  'nickname' => 'Visualizar instituicões cadastradas',     'groupname' => 'DashBoard',    'resource' => 'web',    'uses' => 'InstituicaoController@index']);
    Route::get('dash/instituicoes/{id}', ['as' => 'dash.instituicao.show',  'nickname' => 'Atualizar instituicões',     'groupname' => 'DashBoard',    'resource' => 'web',    'uses' => 'InstituicaoController@show']);
    Route::get('dash/instituicoes/remove/{id}', ['as' => 'dash.instituicao.destroy',  'nickname' => 'Remover instituicões',     'groupname' => 'DashBoard',    'resource' => 'web',    'uses' => 'InstituicaoController@destroy']);
    Route::get('dash/instituicoes-novo', ['as' => 'dash.instituicao.create',  'nickname' => 'Cadastrar instituicões',     'groupname' => 'DashBoard',    'resource' => 'web',    'uses' => 'InstituicaoController@create']);

    Route::put('dash/instituicoes/{id}', [InstituicaoController::class, 'update'])->name('dash.instituicao.update');
    Route::post('dash/instituicoes',     [InstituicaoController::class, 'store'])->name('dash.instituicao.post');


    /*Indicador */

    Route::get('dash/indicador',      ['as' => "dash.indicador", 'nickname' => "Visualizar Temas", 'groupname' => "Temas", 'resource' => 'web',    'uses' => 'IndicadorController@index']);
    Route::get('dash/indicador/novo', ['as' => "dash.indicador.novo", 'nickname' => "Cadastrar Temas", 'groupname' => "Temas", 'resource' => 'web',    'uses' => 'IndicadorController@new']);
    Route::post('dash/indicador/novo/send', [IndicadorController::class, 'store'])->name('dash.indicador.post');
    Route::get('dash/indicador/{id}', ['as' => "dash.indicador.show", 'nickname' => "Visualizar um Tema", 'groupname' => "Temas", 'resource' => 'web',    'uses' => 'IndicadorController@show']);
    Route::put('dash/indicador/{id}', [IndicadorController::class, 'update'])->name('dash.indicador.update');


    //Paineis
    Route::get('dash/painel', ['as' => "dash.painel", 'nickname' => "Visualizar Painéis", 'groupname' => "Painéis", 'resource' => 'web',    'uses' => 'PanelController@index']);
    Route::get('dash/painel/novo', ['as' => "dash.painel.create", 'nickname' => "Criar Painéis", 'groupname' => "Painéis", 'resource' => 'web',    'uses' => 'PanelController@create']);
    Route::get('dash/painel/{id}', ['as' => "dash.painel.show", 'nickname' => "Atualizar Painéis", 'groupname' => "Painéis", 'resource' => 'web',    'uses' => 'PanelController@show']);
    Route::get('dash/painel/remove/{id}', ['as' => "dash.painel.destroy", 'nickname' => "Remover Painéis", 'groupname' => "Painéis", 'resource' => 'web',    'uses' => 'PanelController@destroy']);
    Route::post('dash/painel/novo', [PanelController::class, 'store'])->name('dash.panel.store');
    Route::put('dash/painel/{id}', [PanelController::class, 'update'])->name('dash.panel.update');


    //Indicador Thema
    Route::get('dash/indicadortema', ['as' => "dash.indicadorTheme", 'nickname' => "Visualizar Indicadores", 'groupname' => "Indicadores", 'resource' => 'web',    'uses' => 'IndicadorThemeController@index']);
    Route::get('dash/indicadortema/novo', ['as' => "dash.indicadorTheme.create", 'nickname' => "Criar Indicadores", 'groupname' => "Indicadores", 'resource' => 'web', 'uses' => 'IndicadorThemeController@create']);
    Route::get('dash/indicadortema/{id}', ['as' => "dash.indicadorTheme.show", 'nickname' => "Atualizar Indicadores", 'groupname' => "Indicadores", 'resource' => 'web', 'uses' => 'IndicadorThemeController@show']);
    Route::get('dash/indicadortema/remove/{id}', ['as' => "dash.indicadorTheme.destroy", 'nickname' => "Remover Indicadores", 'groupname' => "Indicadores", 'resource' => 'web', 'uses' => 'IndicadorThemeController@destroy']);
    Route::post('dash/indicadortema/novo', [IndicadorThemeController::class, 'store'])->name('dash.indicadorTheme.store');
    Route::put('dash/indicadortema/{id}', [IndicadorThemeController::class, 'update'])->name('dash.indicadorTheme.update');


    //Info Indicadores
    Route::get('dash/indicadortema/info/{id}', ['as' => "dash.indicadorTheme.info", 'nickname' => "Visualizar Informações dos Gráficos", 'groupname' => "Gráficos", 'resource' => 'web',    'uses' => 'IndicadorThemeController@info']);
    Route::get('dash/indicadortema/info/destroy/{pendente}', ['as' => "dash.indicadorTheme.info.destroy.pendente", 'nickname' => "Remover Gráficos pendentes de aprovação", 'groupname' => "Gráficos", 'resource' => 'web',    'uses' => 'IndicadorThemeController@removeIndicador']);
    Route::get('dash/indicadortema/info/pendente/{id}', ['as' => "dash.indicadorTheme.info.pendente", 'nickname' => "Visualizar Gráfico pendente", 'groupname' => "Gráficos", 'resource' => 'web',    'uses' => 'IndicadorThemeController@showPendente']);
    Route::get('dash/indicadortema/info/aproved/{id}',  ['as' => "dash.grafico.aproved", 'nickname' => "Aprovar Gráficos pendente", 'groupname' => "Gráficos", 'resource' => 'web',    'uses' => 'IndicadorThemeController@aprovedGrafic']);
    Route::get('export/{id}', [IndicadorThemeController::class, 'export'])->name('grafic.export');
    Route::get('dash/indicadortema/info/acao/{id}',  ['as' => "dash.grafico.acao", 'nickname' => "Inativar e ativar Gráfico", 'groupname' => "Gráficos", 'resource' => 'web',    'uses' => 'IndicadorThemeController@acao']);



    //Layout 1
    Route::post('dash/indicadortema/info/destroy/grafico/', ['as' => "dash.indicadorTheme.info.grafico.destroy", 'nickname' => "Remover valores dentro do Gráfico", 'groupname' => "Gráficos", 'resource' => 'web',    'uses' => 'IndicadorThemeController@removeGraficoTema']);
    Route::post('dash/indicadortema/info/{id}/send/layout1', [IndicadorThemeController::class, 'layout1'])->name('dash.indicadorTheme.layout1');
    Route::post('dash/indicadortema/info/send/grafico',      [IndicadorThemeController::class, 'grafico'])->name('dash.indicadorTheme.grafico');
    Route::put('dash/indicadortema/info/send/grafico/update/{id}',[IndicadorThemeController::class, 'updateGrafico'])->name('dash.indicadorTheme.update');
    Route::post('dash/indicadortema/info/send/notas/{id}',         [IndicadorThemeController::class, 'notas'])->name('dash.indicadorTheme.notas');


    // /* Gráfico */
    // Route::get('dash/grafico/inserir', ['as' => "dash.indicador.grafico", 'nickname' => "Inserir Gráfico", 'groupname' => "Gráfico", 'resource' => 'web',    'uses' => 'IndicadorController@insert']);
    // Route::post('dash/grafico/inserir', [InsertGraficoController::class, 'store'])->name('dash.indicador.grafico.save');

    // /* Remover Gráfico */
    // Route::get('dash/remove/grafico/{id}', ['as' => "dash.indicador.grafico.remove", 'nickname' => "Remover Gráfico Pendente", 'groupname' => "Gráfico", 'resource' => 'web',    'uses' => 'RemovePendenteGraficController@destroy']);

    /* Visualizar Gráfico */
    // Route::get('dash/grafico/{id}', ['as' => "dash.grafico.show", 'nickname' => "Visualizar Gráfico Pendente", 'groupname' => "Gráfico", 'resource' => 'web',    'uses' => 'RemovePendenteGraficController@find']);
    // Route::get('dash/grafico/remove/{id}/{idFaixa}', ['as' => "dash.grafico.remove", 'nickname' => "Remover Valores do Gráfico", 'groupname' => "Gráfico", 'resource' => 'web',    'uses' => 'RemovePendenteGraficController@removeGrafic']);
    // Route::get('dash/grafico/aproved/{id}', ['as' => "dash.grafico.aproved", 'nickname' => "aprovar Gráfico", 'groupname' => "Gráfico", 'resource' => 'web',    'uses' => 'RemovePendenteGraficController@aprovedGrafic']);
    // Route::get('dash/grafico/remove/{id}', ['as' => "dash.grafico.remove.indicador", 'nickname' => "Remover o gráfico do indicador", 'groupname' => "Gráfico", 'resource' => 'web',    'uses' => 'RemovePendenteGraficController@removeIndicador']);
    // Route::post('dash/grafico/remove/checkbox', [RemovePendenteGraficController::class, 'checkBox'])->name('dash.indicador.checkbox');

});

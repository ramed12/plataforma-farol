@include('dashboard.include.header')
<div class="page has-sidebar-left height-full">
<div class="container-fluid relative animatedParent animateOnce">
    <div class="animated fadeInUpShort">
        <div class="row my-3">
            <div class="col-md-12">

                <div class="card no-b  no-r" style="padding:40px;">
                    <h3 class="box-title">Temas cadastrados <i class=" icon-analytics-1"></i> </h3>
                    <div class="container-fluid mt-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Pesquisar temas</h6>
                            </div>
                            <div class="container-fluid">
                                {!! Form::model(Request::input(), [
                                    'route' => ['dash.indicador', http_build_query(Request::input())],
                                    'method' => 'get',
                                ]) !!}
                                <div class="row">
                                    <div class="col-6">
                                        <div class="col-12">{!! Form::label('name', 'Nome', ['class' => 'col-form-label font-weight-bold']) !!}</div>
                                        <div class="col-12">{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nome']) !!}</div>
                                        @if (!empty($errors->first('name')))
                                            <label class="invalid-feedback d-block">{!! $errors->first('name') !!}</label>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <div class="col-12">{!! Form::label('status', 'Status', ['class' => 'col-form-label font-weight-bold']) !!}</div>
                                        <div class="col-12">{!! Form::select('size', ['L' => 'Ativo', 'S' => 'Inativo'], null, [
                                            'class' => 'form-control',
                                            'placeholder' => 'Status',
                                        ]) !!}</div>
                                        @if (!empty($errors->first('status')))
                                            <label class="invalid-feedback d-block">{!! $errors->first('status') !!}</label>
                                        @endif
                                    </div>
                                    <div class="col-12 text-right py-4 px-4">
                                        <a href="{!! route('dash.indicador.novo') !!}" class="btn btn-success"><i
                                                class="fas fa-plus"></i> Novo</a>
                                        <button type="submit" class="btn btn-primary btn-color"><i
                                                class="fas fa-search"></i> Pesquisar</button>
                                        <a href="{!! route('dash.indicador') !!}" class="btn cur-p btn-warning btn-color"><i
                                                class="fas fa-eraser"></i> Limpar Pesquisa</a>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <hr>
                    <BR><BR>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead style="background:#03a9f4; color:#fff; font-weight:bolder;">
                                <tr>
                                    <th scope="col">Painel</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Usuário criador</th>
                                    <th scope="col">Ultima atualização por</th>
                                    <th scope="col">Editar</th>
                                    <th scope="col">Remover</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!$indicador->isEmpty())
                                    @foreach ($indicador as $row)
                                        <tr>
                                            <td>{!! empty($row->paineis->name) ? 'Não existe painel' : $row->paineis->name !!}</td>
                                            <td>{!! $row->name !!}</td>
                                            <td>{!! Status($row->status) !!}</td>
                                            <td>{!! $row->user->name !!} - as {!! date('H:i:s d/m/Y', strtotime($row->created_at)) !!}</td>
                                            <td>{!! $row->userEdit->name !!} - as {!! date('H:i:s d/m/Y', strtotime($row->updated_at)) !!}</td>
                                            <td><a href="{!! route('dash.indicador.show', $row->id) !!}">
                                                    <center><i style="color:#2979ff!important;"
                                                            class="icon-document-edit2"></i></center>
                                                </a></td>
                                            <td>
                                                <center><i style="color:red;" class="icon-close"></i></center>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>Nenhum registro encontrado</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    {{ $indicador->links() }}
                </div>
                <div class="row" style="margin:20px;">
                    <a class="pull-right" href="{!! route('dash.indicador.novo') !!}"><button
                            class="btn btn-primary btn-lg btn-block" style="width:250px;"> <i
                                class="icon-analytics-3"></i> Cadastrar novo tema</button></a>
                </div>
                @include('alert')
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- Right Sidebar -->
<script src="{!! asset('assets/js/app.js') !!}"></script>
</body>

</html>

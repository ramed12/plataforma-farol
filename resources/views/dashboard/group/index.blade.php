@include("dashboard.include.header")
<div class="page has-sidebar-left height-full">
<div class="container-fluid relative animatedParent animateOnce">
    <div class="animated fadeInUpShort">
        <div class="row my-3">
            <div class="col-md-12">

                    <div class="card no-b  no-r" style="padding:40px;">
                        <h3 class="box-title">Grupos cadastrados  <i class="icon icon-users"></i>      </h3>
                        <div class="container-fluid mt-4">
                          <div class="card shadow mb-4">
                              <div class="card-header py-3">
                                  <h6 class="m-0 font-weight-bold text-primary">Pesquisar grupos</h6>
                              </div>
                              <div class="container-fluid">
                                  {!! Form::model(Request::input(), [
                                      'route' => ['dash.grupouser', http_build_query(Request::input())],
                                      'method' => 'get',
                                  ]) !!}
                                  <div class="row">
                                      <div class="col-12">
                                          <div class="col-12">{!! Form::label('name', 'Nome do Grupo', ['class' => 'col-form-label font-weight-bold']) !!}</div>
                                          <div class="col-12">{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nome']) !!}</div>
                                          @if (!empty($errors->first('name')))
                                              <label class="invalid-feedback d-block">{!! $errors->first('name') !!}</label>
                                          @endif
                                      </div>
                                      <div class="col-12 text-right py-4 px-4">
                                          <a href="{!! route('dash.show') !!}" class="btn btn-success"><i
                                                  class="fas fa-plus"></i> Novo</a>
                                          <button type="submit" class="btn btn-primary btn-color"><i
                                                  class="fas fa-search"></i> Pesquisar</button>
                                          <a href="{!! route('dash.grupouser') !!}" class="btn cur-p btn-warning btn-color"><i
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
                                    <th scope="col">Nome do Grupo</th>
                                    <th scope="col">Usuário Responsável</th>
                                    <th scope="col">Data de criação</th>
                                    <th scope="col">Situação</th>
                                    <th scope="col">Editar</th>
                                    <th scope="col">Remover</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $groupUser as $row)
                                    <tr>
                                        <td>{!! $row->name !!}</td>
                                        <td>{!! $row->user->name !!}</td>
                                        <td>{!! date('d/m/Y', strtotime($row->created_at)) !!}</td>
                                        <td>{!! Status($row->status) !!}</td>
                                        <td><center><a href="{!! route('dash.groupuser.edit', $row->id) !!}"><i style="color:#2979ff!important;" class="icon-document-edit2"></i></a></center></td>
                                        <td><center><i style="color:red;" class="icon-close"></i></center></td>
                                      </tr>
                                    @endforeach
                                </tbody>
                              </table>
                        </div>
                          {{ $groupUser->links() }}
                    </div>
                    <div class="row" style="margin:20px;">
                        <a class="pull-right" href="{!! route('dash.show') !!}"><button class="btn btn-primary btn-lg btn-block" style="width:250px;"> <i class="icon icon-user-plus"></i> Cadastrar novo Grupo </button></a>
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

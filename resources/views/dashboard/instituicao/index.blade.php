@include("dashboard.include.header")
<div class="page has-sidebar-left height-full">
<div class="container-fluid relative animatedParent animateOnce">
    <div class="animated fadeInUpShort">
        <div class="row my-3">
            <div class="col-md-12">

                    <div class="card no-b  no-r" style="padding:40px;">
                        <h3 class="box-title">Instituições Cadastradas  <i class="icon icon-flag5"></i>      </h3>
                        <div class="container-fluid mt-4">
                          <div class="card shadow mb-4">
                              <div class="card-header py-3">
                                  <h6 class="m-0 font-weight-bold text-primary">Pesquisar instituições</h6>
                              </div>
                              <div class="container-fluid">
                                  {!! Form::model(Request::input(), ['route' => ['dash.instituicao', http_build_query(Request::input())], 'method' => 'get'])!!}
                                  <div class="row">
                                      <div class="col-12">
                                          <div class="col-12">{!! Form::label('name', 'Nome', ['class' => 'col-form-label font-weight-bold']) !!}</div>
                                          <div class="col-12">{!! Form::text('name',null, ['class' => 'form-control','placeholder' => 'Nome']) !!}</div>
                                          @if (!empty($errors->first('name')))
                                              <label class="invalid-feedback d-block">{!!$errors->first('name')!!}</label>
                                          @endif
                                      </div>
                                      <div class="col-12 text-right py-4 px-4">
                                          <a href="{!! route('dash.instituicao.create') !!}" class="btn btn-success"><i class="fas fa-plus"></i> Novo</a>
                                          <button type="submit" class="btn btn-primary btn-color"><i class="fas fa-search"></i> Pesquisar</button>
                                          <a href="{!! route('dash.instituicao') !!}" class="btn cur-p btn-warning btn-color"><i class="fas fa-eraser"></i> Limpar Pesquisa</a>
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
                                <th scope="col">Nome</th>
                                <th scope="col">Editar</th>
                                <th scope="col">Remover</th>
                              </tr>
                            </thead>
                            <tbody>
                              @if(!$instituicao->isEmpty())
                                @foreach ( $instituicao as $row)
                                <tr>
                                    <td>{!! $row->name !!}</td>
                                    <td><a href="{!! route('dash.instituicao.show', $row->id) !!}"><center><i style="color:#2979ff!important;" class="icon-document-edit2"></i></center></a></td>
                                    <td><a href="{!! route('dash.instituicao.destroy', $row->id) !!}"><center><i style="color:red;" class="icon-close"></i></center></a></td>
                                  </tr>
                                @endforeach
                              @else
                              <tr>
                                <td><div class="alert alert-warning">Nenhuma instituição cadastrada</div></td>
                              </tr>
                              @endif
                            </tbody>
                          </table>
                        </div>
                          <div class="flex">
                            {{ $instituicao->links() }}
                          </div>
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

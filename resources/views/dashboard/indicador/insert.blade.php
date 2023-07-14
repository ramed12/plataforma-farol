@include("dashboard.include.header")
<div class="page has-sidebar-left height-full">
<div class="container-fluid relative animatedParent animateOnce">
    <div class="animated fadeInUpShort">
        <div class="row my-3">
            <div class="col-md-12">
                {!!Form::open(['method' => 'post', 'autocomplete' => false, 'route' => ['dash.indicador.grafico.save', http_build_query(Request::input())], 'class' => ($errors->any()) ? 'was-validated': '' ,'novalidate', 'files' => true])!!}
                        {{-- {!!Form::open(['method' => 'post', 'autocomplete' => false, 'route' => ['dash.indicador.grafico.save', http_build_query(Request::input())], 'class' => ($errors->any()) ? 'was-validated': '' ,'novalidate'])!!} --}}
                    <div class="card no-b  no-r">
                        <div class="card-body">
                            <h5 class="card-title">Inserir Gráfico Excel <i class="icon-analytics-1"></i></h5>
                            <hr>
                            <style>
                                .form-control { padding:20px !important; }
                                .form-group { margin-top:20px !important; }
                                .s-28 { font-size:27px !important; position: relative; top:5px; }
                            </style>
                            <div class="form-row mt-1">
                                <div class="form-group col-12 m-0">
                                    <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Escolha o Tema</label>
                                    <select class="select2" name="idIndicador">
                                        @foreach ($indicador as $row)
                                        <option value="{!! $row->id !!}">{!! $row->name !!}</option>
                                        @endforeach
                                    </select>
                                    @error('name')
                                    <p class="text-danger">{!! $message !!}</p>
                                   @enderror
                                </div>
                                <div class="form-group col-12 m-0">
                                    {!!Form::file('file', ['class' => 'form-control', 'required', 'accept' => ".xlsx,.xls,.csv"])!!}
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary btn-lg"><i class="icon-save mr-2"></i>Salvar</button>
                        </div>
                    </div>
                </form>
                @include('alert')
            </div>
        </div>

        <div class="row my-3">
            <div class="col-md-9  offset-md-2">

                    <div class="card no-b  no-r" style="padding:40px;">
                        <h3 class="box-title">Dados pendentes de aprovação</h3>
                        <hr>
                        <BR><BR>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead style="background:#03a9f4; color:#fff; font-weight:bolder;">
                                  <tr>
                                    <th scope="col">Nome do Tema</th>
                                    <th scope="col">Usuário Responsável pelo Envio</th>
                                    <th scope="col">Data de Envio</th>
                                    <th scope="col">Situação</th>
                                    <th scope="col">Visualizar</th>
                                    <th scope="col">Remover</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @if(!$pendentes->isEmpty())
                                        @foreach ($pendentes as $row)
                                        <tr>
                                            <td>{!! $row->indicador->name !!}</td>
                                            <td>{!! $row->indicador->user->name !!}</td>
                                            <td>{!! date('d/m/Y H:i:s', strtotime($row->created_at)) !!}</td>
                                            <td>{!! Status($row->status) !!} </td>
                                            <td><center><a href="{{ route('dash.grafico.show', $row->id) }}"><i style="color:#2979ff!important;" class="icon-eye"></i></a></center></td>
                                            <td><center><a href="{!! route('dash.indicador.grafico.remove', $row->id) !!}"><i style="color:red;" class="icon-close"></i></a></center></td>
                                        </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td>Nenhum registro pendente</td>
                                      </tr>
                                    @endif
                                </tbody>
                              </table>
                        </div>
                    </div>
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

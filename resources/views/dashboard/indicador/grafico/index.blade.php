@include("dashboard.include.header")
<div class="page has-sidebar-left height-full">
<div class="container-fluid relative animatedParent animateOnce">
    <div class="animated fadeInUpShort">
        <div class="row my-3">
            <div class="col-md-12">
                    <div class="card no-b  no-r">
                        <div class="card-body">
                            <h5 class="card-title">Gráfico do tema <b>{{$grafico->indicador->name}}</b> <i class="icon-analytics-1"></i></h5>
                            <hr>
                            {{-- <style>
                                .form-control { padding:20px !important; }
                                .form-group { margin-top:20px !important; }
                                .s-28 { font-size:27px !important; position: relative; top:5px; }
                            </style> --}}

                                {!! Form::model(Request::input(), ['method' => 'get', 'autocomplete' => 'off', 'route' => ['dash.grafico.show', $grafico->id, http_build_query(Request::input())], 'class' => $errors->any() ? 'was-validated' : '', 'novalidate']) !!}
                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                        <label for="inputEmail4" class="col-form-label">Ano</label>
                                        <select class="form-control" name="ano">
                                            <option></option>
                                            @foreach ($estado as $row )
                                                <option>{{$row->ano}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputPassword4" class="col-form-label">Tipo</label>
                                        <select class="form-control" name="home_mulher">
                                            <option></option>
                                            <option>Homem</option>
                                            <option>Mulher</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputPassword4" class="col-form-label">Grupo de Idade</label>
                                        <select class="form-control" name="grupo_idades">
                                            @foreach (GrupoIdade() as $row )
                                                <option>{{$row}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputPassword4" class="col-form-label">Estado</label>
                                        <select class="form-control" name="estado">
                                            <option></option>
                                            @foreach ($estado as $row )
                                                <option>{{$row->estado}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                    <button class="btn btn-primary" style="position: relative; top:35px;">Buscar </button>
                                    </div>
                                </div>
                            </form>
                            <div class="form-row mt-1">
                                <div class="form-group col-12 m-0">
                                    <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Informações do gráfico </label>
                                    <div class="box-body">
                                        <form action="{{ route('dash.indicador.checkbox') }}" method="POST">
                                        <table class="table table-bordered table-hover">
                                            <tbody>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Ano</th>
                                                <th>Total</th>
                                                <th>Homens</th>
                                                <th>Mulheres</th>
                                                <th>Grupo de Idades</th>
                                                <th>Estado</th>
                                                <th>Ação</th>
                                            </tr>

                                        <input type="hidden" value="{!! $grafico->id !!}" name="faixa">
                                        @csrf
                                            @foreach ( $resultado as  $row)
                                            <tr>
                                                <td><input value="{{$row->id}}" type="checkbox" class="form-control" name="id[]"></td>
                                                <td>{{$row->ano}}</td>
                                                <td>{{$row->total}}</td>
                                                <td>{{$row->homens}}</td>
                                                <td>{{$row->mulheres}}</td>
                                                <td>{{$row->grupo_idades}}</td>
                                                <td>{{$row->estado}}</td>
                                                @if($row->status == 1)
                                                    <td><a style="color:red" href="{{route('dash.grafico.remove', ["id" => $row->id, "idFaixa" => $grafico->id])}}">Remover </a></td>
                                                @else
                                                    <td style="color:green">Aprovado</td>
                                                @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                        </table>
                                        <button type="submit" class="btn btn-danger btn-lg"><i class="icon-remove mr-2"></i>Remover Linhas Selecionadas</button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            @if($resultado instanceof \Illuminate\Pagination\LengthAwarePaginator )
                        <center>{!! $resultado->links('pagination::bootstrap-4') !!}</center>
                        @endif
                        </div>
                        <hr>
                        <div class="card-body">
                            @if($row->status == 1)
                            <a href="{{route('dash.grafico.aproved', $grafico->id)}}" class="btn btn-primary btn-lg"><i class="icon-save mr-2"></i>Aprovar Relatório</a>
                            @endif
                             <a href="{{route('dash.grafico.remove.indicador', $grafico->id)}}" class="btn btn-danger btn-lg"><i class="icon-save mr-2"></i>Reprovar Gráfico</a>

                             <a href="{{route('grafic.export', $grafico->enum, http_build_query(Request::input()))}}" class="btn btn-success btn-lg"><i class="icon-file-excel-o mr-2"></i>Exportar Excel</a>

                        </div>
                    </div>
                </form>
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

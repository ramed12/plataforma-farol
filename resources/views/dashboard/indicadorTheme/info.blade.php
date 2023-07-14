@include("dashboard.include.header")
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
  $(document).ready(function() {
	var max_fields      = 10000; //maximum input boxes allowed
	var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
	var add_button      = $(".add_field_button"); //Add button ID

	var x = 1; //initlal text box count
	$(add_button).click(function(e){ //on add input button click
		e.preventDefault();
		if(x < max_fields){ //max input box allowed
			x++; //text box increment
			$(wrapper).append('<div class="form-group col-6 m-0"> <input type="text" name="fields[]" placeholder="Nome do novo campo" class="form-control r-0 light s-12"> <a href="#" class="text-danger remove_field"><i class="fas fa-minus"></i> Remover</a></div>'); //add input box
		}
	});

	$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); x--;
	})

});
</script>
<div class="page has-sidebar-left height-full">
<div class="container-fluid relative animatedParent animateOnce">
    <div class="animated fadeInUpShort">
        <div class="row my-3">
            <div class="col-md-12">
                    <div class="card no-b  no-r">
                        <div class="card-body">
                            <h5 class="card-title">Cadastrar Informações do indicativo
                                <b>{!! $indicador->name !!}</b></h5>
                            <hr>
                            <style>
                                /* .form-control { padding:20px !important; } */
                                .form-group { margin-top:20px !important; }
                                .s-28 { font-size:27px !important; position: relative; top:5px; }
                                .layout { height: 100px; background:#fff; border-radius: 10px; box-shadow:1px 2px 13px rgba(0,0,0,.2); margin-top:20px; }
                                .t1 { height: auto; }
                            </style>
                            <div class="col-12 m-0">
                                <div class="row">
                                    @include('alert')
                                    <div class="col-12 layout t1">
                                        {!!Form::open(['method' => 'post', 'id' => 'upload-info' , 'autocomplete' => false, 'route' => ['dash.indicadorTheme.layout1', $indicador->id, http_build_query(Request::input())], 'class' => ($errors->any()) ? 'was-validated': '' ,'novalidate', 'files' => true])!!}
                                        <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Adicione Campos para enviar o excel ao sistema </label>

                                        <div class="row input_fields_wrap">
                                                @error('fields')
                                                    <span class="text-danger" style="margin-left:40px;">{!! $message !!}</span>
                                                @enderror
                                                @error('unidade_territorial')
                                                    <span class="text-danger" style="margin-left:40px;">{!! $message !!}</span>
                                                @enderror
                                                @error('ano')
                                                    <span class="text-danger" style="margin-left:40px;">{!! $message !!}</span>
                                                @enderror
                                            </div>
                                            <div class="custom-file" style="margin-top:40px;">
                                                <label class="custom-file-label" for="validatedCustomFile">Escolher arquivo</label>
                                                <input type="file" name="file" id="validatedCustomFile" class="custom-file-input" required accept=".xlsx,.xls,.csv">
                                               {{--  {!!Form::file('file', ['class' => 'custom-file-input', 'required', 'id' => 'validatedCustomFile', 'accept' => ".xlsx,.xls,.csv"])!!}  --}}                                           </div>
                                            <div class="card-body">
                                                <button type="submit" class="btn btn-submit-form btn-form btn-primary btn-lg"><i class="icon-save mr-2"></i>Salvar</button>
                                                <button class="btn btn-primary btn-add-camp-form btn-lg add_field_button"><i class="icon icon-exposure_plus_1"></i> Campo</button>
                                            </div>
                                            <div class="col-12">
                                                    <div class="box-body">
                                                        @if(!$indicador->pendente->isEmpty())
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <tbody>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Nome do indicador</th>
                                                                    <th>Status</th>
                                                                    <th>Ação</th>
                                                                    <th>Remover</th>
                                                                </tr>
                                                                    @foreach ( $indicador->pendente as $row )
                                                                        <tr>
                                                                            <td>{!! $row->id !!}</td>
                                                                            <td>{!! $indicador->name !!}</td>
                                                                            <td>{!! status($row->status) !!}</td>
                                                                            <td><a href="{!! route('dash.indicadorTheme.info.pendente',$row->id) !!}"><center><i style="color:#2979ff!important;" class="icon-document-edit2"></i></center></a></td>
                                                                            <td><a href="{!! route('dash.indicadorTheme.info.destroy.pendente', $row->id) !!}"><center><i style="color:red;" class="icon-close"></i></center></a></td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        @else
                                                            <div class="alert alert-warning"> Nenhum gráfico pendente para aprovação </div>
                                                        @endif
                                                    </div>
                                            </div>
                                        </form>
                                        </div>

                                        <style>

                                            #v-pills-tab { width:100%; background:#2979ff!important; margin-top:20px; padding:10px; border-radius:10px; }
                                            #v-pills-tab li a { color:#fff; }
                                            #v-piils-tab li .active { background: #fff !important;}


                                        </style>

                                        <div class="col-12">
                                            <div class="row">
                                                <ul class="nav responsive-tab nav-material nav-material-white" id="v-pills-tab">
                                                    <li>
                                                        <a class="nav-link active" id="v-pills-1-tab" data-toggle="pill" href="#principal">
                                                            <i class="icon icon-bar-chart2"></i>Gráfico Principal</a>
                                                    </li>
                                                    <li>
                                                        <a class="nav-link" id="v-pills-2-tab" data-toggle="pill" href="#auxiliar1"><i class="icon  icon-analytics-2 mb-3"></i>Gráfico Auxiliar 1                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="nav-link" id="v-pills-3-tab" data-toggle="pill" href="#auxiliar2"><i class="icon  icon-analytics-2"></i>Gráfico Auxiliar 2</a>
                                                    </li>
                                                    <li>
                                                        <a class="nav-link" id="v-pills-3-tab" data-toggle="pill" href="#analitico"><i class="icon  icon-list3"></i>Analítico</a>
                                                    </li>
                                                    <li>
                                                        <a class="nav-link" id="v-pills-3-tab" data-toggle="pill" href="#notas"><i class="icon  icon-note"></i>Notas</a>
                                                    </li>
                                                </ul>

                                            </div>
                                        </div>

                                    <div class="container-fluid relative animatedParent animateOnce">
                                        <div class="tab-content pb-3" id="v-pills-tabContent">
                                            <div class="tab-pane animated fadeInUpShort show active" id="principal">
                                                <div class="col-12 layout t1">
                                                    @if(empty($inseridos))
                                                    {!!Form::open(['method' => 'post', 'autocomplete' => false, 'route' => ['dash.indicadorTheme.grafico', http_build_query(Request::input())], 'class' => ($errors->any()) ? 'was-validated': '' ,'novalidate', 'files' => true])!!}

                                                    <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Escolha os campos para aparecer no gráfico <span class="text-danger">GRAFICO PRINCIPAL</span> </label>
                                                    <div class="row">
                                                        <div class="form-group col-6 m-0">
                                                            <input type="hidden" value="{!! $indicador->id !!}" name="id_indicador">
                                                            <input type="hidden" value="1" name="tipo">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Escolha o eixo X </label>
                                                            @if(!empty($colunas))
                                                                <select class="select2" name="x[]" multiple="multiple" required>
                                                                    @foreach($colunas as $row)
                                                                        <option value="{!! $row !!}"> {!! $row !!} </option>
                                                                    @endforeach
                                                                </select>
                                                            @else
                                                            <div class="alert alert-warning">Nenhum campo encontrado </div>
                                                            @endif
                                                        </div>


                                                        <div class="form-group col-6 m-0">
                                                            <input type="hidden" value="{!! $indicador->id !!}" name="id_indicador">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Escolha o título do eixo X  </label>
                                                            @if(!empty($colunas))
                                                                <select class="select2" name="y[]" multiple="multiple">
                                                                    <option></option>
                                                                    @foreach($colunas as $row)
                                                                        <option value="{!! $row !!}"> {!! $row !!} </option>
                                                                    @endforeach
                                                                </select>
                                                            @else
                                                            <div class="alert alert-warning">Nenhum campo encontrado </div>
                                                            @endif
                                                        </div>

                                                        <div class="form-group col-6 m-0">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Título do gráfico</label>
                                                            <input type="text" placeholder="Titulo do Gráfico" class="form-control" name="name" required>
                                                        </div>

                                                        <div class="form-group col-6 m-0">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Gráfico é pirâmede etária?</label>
                                                            <select class="select2" name="piramede">
                                                                <option></option>
                                                                <option value="1">Sim</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-12 m-0">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Tipo de Gráfico</label>
                                                            <select class="select2" name="type_grafico">
                                                                {!! Graficos() !!}
                                                            </select>
                                                        </div>
                                                    </div>

                                                    @else
                                                    {!!Form::open(['method' => 'put', 'autocomplete' => false, 'route' => ['dash.indicadorTheme.update', $grafico->id, http_build_query(Request::input())], 'class' => ($errors->any()) ? 'was-validated': '' ,'novalidate'])!!}
                                                    <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Escolha os campos para aparecer no gráfico  <span class="text-danger">GRAFICO PRINCIPAL</span> </label>
                                                    <div class="row">
                                                        <div class="form-group col-6 m-0">
                                                            <input type="hidden" value="{!! $indicador->id !!}" name="id_indicador">
                                                            <input type="hidden" value="1" name="tipo">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Escolha o eixo X </label>
                                                            @if(!empty($colunas))
                                                                <select class="select2" name="x[]" multiple="multiple">
                                                                    @foreach($colunas as $row)
                                                                    <option value="{!! $row !!}" {!! (in_array($row, $inseridos) ? "selected" : '')  !!}> {!! $row !!}
                                                                    @endforeach
                                                                </select>
                                                            @else
                                                                <div class="alert alert-warning">Nenhum campo encontrado </div>
                                                            @endif
                                                        </div>

                                                        <div class="form-group col-6 m-0">
                                                            <input type="hidden" value="{!! $indicador->id !!}" name="id_indicador">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Escolha o título do eixo X </label>
                                                            @if(!empty($colunas))
                                                                <select class="select2" name="y[]">
                                                                    <option></option>
                                                                    @foreach($colunas as $row)
                                                                    <option value="{!! $row !!}" {!! (in_array($row, $inseridos_y) ? "selected" : '')  !!}> {!! $row !!}
                                                                    @endforeach
                                                                </select>
                                                            @else
                                                                <div class="alert alert-warning">Nenhum campo encontrado </div>
                                                            @endif
                                                        </div>

                                                        <div class="form-group col-6 m-0">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Título do gráfico</label>
                                                            <input type="text" value="{!! $grafico->name !!}" class="form-control" name="name" required>
                                                        </div>

                                                        <div class="form-group col-6 m-0">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Gráfico é pirâmede etária?</label>
                                                            <select class="select2" name="piramede">
                                                                <option></option>
                                                                <option value="1" {!! !empty($grafico->piramede) ? 'selected' :'' !!}>Sim</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-12 m-0">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Tipo de Gráfico</label>
                                                            <select class="select2" name="type_grafico">
                                                                {!! Graficos($grafico->type_grafico) !!}
                                                            </select>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="card-body">
                                                        <button type="submit" class="btn btn-form btn-primary btn-lg"><i class="icon-save mr-2"></i>Salvar</button>
                                                        {{-- @if(!empty($grafico))
                                                            @if($grafico->status == 2)
                                                                <a href="{!! route('dash.grafico.acao', $grafico->id) !!}?type=1&id_indicador={!! $indicador->id !!}" class="btn btn-status btn-warning btn-lg" style="color:black !important"><i class="icon-save mr-2"></i>Inativar Gráfico</a>
                                                            @else
                                                                <a href="{!! route('dash.grafico.acao', $grafico->id) !!}?type=2&id_indicador={!! $indicador->id !!}" class="btn btn-status btn-success btn-lg" style="color:black !important"><i class="icon-save mr-2"></i>Ativar Gráfico</a>
                                                            @endif
                                                        @endif --}}
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="tab-pane animated fadeInUpShort" id="auxiliar1">
                                                <div class="col-12 layout t1">
                                                    @if(empty($inseridos_dois))
                                                    {!!Form::open(['method' => 'post', 'autocomplete' => false, 'route' => ['dash.indicadorTheme.grafico', http_build_query(Request::input())], 'class' => ($errors->any()) ? 'was-validated': '' ,'novalidate', 'files' => true])!!}

                                                    <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Escolha os campos para aparecer no gráfico <span class="text-danger">GRAFICO AUXILIAR 1</span> </label>
                                                    <div class="row">
                                                        <div class="form-group col-6 m-0">
                                                            <input type="hidden" value="{!! $indicador->id !!}" name="id_indicador">
                                                            <input type="hidden" value="2" name="tipo">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Escolha o eixo X </label>
                                                            @if(!empty($colunas))
                                                                <select class="select2" name="x[]" multiple="multiple">
                                                                    @foreach($colunas as $row)
                                                                        <option value="{!! $row !!}"> {!! $row !!} </option>
                                                                    @endforeach
                                                                </select>
                                                            @else
                                                            <div class="alert alert-warning">Nenhum campo encontrado </div>
                                                            @endif
                                                        </div>

                                                        <div class="form-group col-6 m-0">
                                                            <input type="hidden" value="{!! $indicador->id !!}" name="id_indicador">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Escolha o título do eixo X  </label>
                                                            @if(!empty($colunas))
                                                                <select class="select2" name="y[]" multiple="multiple">
                                                                    <option></option>
                                                                    @foreach($colunas as $row)
                                                                        <option value="{!! $row !!}"> {!! $row !!} </option>
                                                                    @endforeach
                                                                </select>
                                                            @else
                                                            <div class="alert alert-warning">Nenhum campo encontrado </div>
                                                            @endif
                                                        </div>

                                                        <div class="form-group col-6 m-0">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Título do gráfico</label>
                                                            <input type="text" value="" class="form-control" name="name" required>
                                                        </div>

                                                        <div class="form-group col-6 m-0">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Gráfico é pirâmede etária?</label>
                                                            <select class="select2" name="piramede">
                                                                <option></option>
                                                                <option value="1">Sim</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-12 m-0">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Tipo de Gráfico</label>
                                                            <select class="select2" name="type_grafico">
                                                                {!! Graficos() !!}
                                                            </select>
                                                        </div>
                                                    </div>

                                                    @else
                                                    {!!Form::open(['method' => 'put', 'autocomplete' => false, 'route' => ['dash.indicadorTheme.update', $grafico_tipo_dois->id, http_build_query(Request::input())], 'class' => ($errors->any()) ? 'was-validated': '' ,'novalidate'])!!}
                                                    <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Escolha os campos para aparecer no gráfico  <span class="text-danger">GRAFICO AUXILIAR 1</span> </label>
                                                    <div class="row">
                                                        <div class="form-group col-6 m-0">
                                                            <input type="hidden" value="{!! $indicador->id !!}" name="id_indicador">
                                                            <input type="hidden" value="2" name="tipo">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Escolha o eixo X </label>
                                                            @if(!empty($colunas))
                                                                <select class="select2" name="x[]" multiple="multiple">
                                                                    @foreach($colunas as $row)
                                                                    <option value="{!! $row !!}" {!! (in_array($row, $inseridos_dois) ? "selected" : '')  !!}> {!! $row !!}

                                                                    @endforeach
                                                                </select>
                                                            @else
                                                                <div class="alert alert-warning">Nenhum campo encontrado </div>
                                                            @endif
                                                        </div>

                                                        <div class="form-group col-6 m-0">
                                                            <input type="hidden" value="{!! $indicador->id !!}" name="id_indicador">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Escolha o título do eixo X </label>
                                                            @if(!empty($colunas))
                                                                <select class="select2" name="y[]">
                                                                    <option></option>
                                                                    @foreach($colunas as $row)
                                                                        <option value="{!! $row !!}" {!! (in_array($row, $inseridos_y_dois) ? "selected" : '')  !!}> {!! $row !!}
                                                                    @endforeach
                                                                </select>
                                                            @else
                                                                <div class="alert alert-warning">Nenhum campo encontrado </div>
                                                            @endif
                                                        </div>
                                                        <div class="form-group col-6 m-0">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Título do gráfico</label>
                                                            <input type="text" value="{!! $grafico_tipo_dois->name !!}" class="form-control" name="name" required>
                                                        </div>

                                                        <div class="form-group col-6 m-0">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Gráfico é pirâmede etária?</label>
                                                            <select class="select2" name="piramede">
                                                                <option></option>
                                                                <option value="1" {!! !empty($grafico_tipo_dois->piramede) ? 'selected' :'' !!}>Sim</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-12 m-0">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Tipo de Gráfico</label>
                                                            <select class="select2" name="type_grafico">
                                                                {!! Graficos($grafico_tipo_dois->type_grafico) !!}
                                                            </select>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="card-body">
                                                        <button type="submit" class="btn btn-form btn-primary btn-lg"><i class="icon-save mr-2"></i>Salvar</button>

                                                       {{-- @if(!empty($grafico_tipo_dois))
                                                            @if($grafico_tipo_dois->status == 2)
                                                                <a href="{!! route('dash.grafico.acao', $grafico_tipo_dois->id) !!}?type=1&id_indicador={!! $indicador->id !!}" class="btn btn-status btn-warning btn-lg" style="color:black !important"><i class="icon-save mr-2"></i>Inativar Gráfico</a>
                                                            @else
                                                                <a href="{!! route('dash.grafico.acao', $grafico_tipo_dois->id) !!}?type=2&id_indicador={!! $indicador->id !!}" class="btn btn-status btn-success btn-lg" style="color:black !important"><i class="icon-save mr-2"></i>Ativar Gráfico</a>
                                                            @endif
                                                        @endif --}}
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <div class="tab-pane animated fadeInUpShort" id="auxiliar2">

                                                <div class="col-12 layout t1">
                                                    @if(empty($inseridos_tres))
                                                    {!!Form::open(['method' => 'post', 'autocomplete' => false, 'route' => ['dash.indicadorTheme.grafico', http_build_query(Request::input())], 'class' => ($errors->any()) ? 'was-validated': '' ,'novalidate', 'files' => true])!!}
                                                    <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Escolha os campos para aparecer no gráfico <span class="text-danger">GRAFICO AUXILIAR 2</span> </label>
                                                    <div class="row">
                                                        <div class="form-group col-6 m-0">
                                                            <input type="hidden" value="{!! $indicador->id !!}" name="id_indicador">
                                                            <input type="hidden" value="3" name="tipo">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Escolha o eixo X </label>
                                                            @if(!empty($colunas))
                                                                <select class="select2" name="x[]" multiple="multiple">
                                                                    @foreach($colunas as $row)
                                                                        <option value="{!! $row !!}"> {!! $row !!} </option>
                                                                    @endforeach
                                                                </select>
                                                            @else
                                                            <div class="alert alert-warning">Nenhum campo encontrado </div>
                                                            @endif
                                                        </div>

                                                        <div class="form-group col-6 m-0">
                                                            <input type="hidden" value="{!! $indicador->id !!}" name="id_indicador">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Escolha o título do eixo X  </label>
                                                            @if(!empty($colunas))
                                                                <select class="select2" name="y[]" multiple="multiple">
                                                                    <option></option>
                                                                    @foreach($colunas as $row)
                                                                        <option value="{!! $row !!}"> {!! $row !!} </option>
                                                                    @endforeach
                                                                </select>
                                                            @else
                                                            <div class="alert alert-warning">Nenhum campo encontrado </div>
                                                            @endif
                                                        </div>

                                                        <div class="form-group col-6 m-0">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Título do gráfico</label>
                                                            <input type="text" value="" class="form-control" name="name" required>
                                                        </div>

                                                        <div class="form-group col-6 m-0">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Gráfico é pirâmede etária?</label>
                                                            <select class="select2" name="piramede">
                                                                <option></option>
                                                                <option value="1">Sim</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-12 m-0">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Tipo de Gráfico</label>
                                                            <select class="select2" name="type_grafico">
                                                                {!! Graficos() !!}
                                                            </select>
                                                        </div>
                                                    </div>

                                                    @else
                                                    {!!Form::open(['method' => 'put', 'autocomplete' => false, 'route' => ['dash.indicadorTheme.update',$grafico_tipo_tres->id, http_build_query(Request::input())], 'class' => ($errors->any()) ? 'was-validated': '' ,'novalidate'])!!}
                                                    <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Escolha os campos para aparecer no gráfico  <span class="text-danger">GRAFICO AUXILIAR 2</span> </label>
                                                    <div class="row">
                                                        <div class="form-group col-6 m-0">
                                                            <input type="hidden" value="{!! $indicador->id !!}" name="id_indicador">
                                                            <input type="hidden" value="3" name="tipo">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Escolha o eixo X </label>
                                                            @if(!empty($colunas))
                                                                <select class="select2" name="x[]" multiple="multiple">
                                                                    @foreach($colunas as $row)
                                                                    <option value="{!! $row !!}" {!! (in_array($row, $inseridos_tres) ? "selected" : '')  !!}> {!! $row !!}
                                                                    @endforeach
                                                                </select>
                                                            @else
                                                                <div class="alert alert-warning">Nenhum campo encontrado </div>
                                                            @endif
                                                        </div>

                                                        <div class="form-group col-6 m-0">
                                                            <input type="hidden" value="{!! $indicador->id !!}" name="id_indicador">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Escolha o título do eixo X </label>
                                                            @if(!empty($colunas))
                                                                <select class="select2" name="y[]">
                                                                    <option></option>
                                                                    @foreach($colunas as $row)
                                                                     <option value="{!! $row !!}" {!! (in_array($row, $inseridos_y_tres) ? "selected" : '')  !!}> {!! $row !!}
                                                                    @endforeach
                                                                </select>
                                                            @else
                                                                <div class="alert alert-warning">Nenhum campo encontrado </div>
                                                            @endif
                                                        </div>

                                                        <div class="form-group col-6 m-0">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Título do gráfico</label>
                                                            <input type="text" value="{!! $grafico_tipo_tres->name !!}" class="form-control" name="name" required>
                                                        </div>
                                                        <div class="form-group col-6 m-0">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Gráfico é pirâmede etária?</label>
                                                            <select class="select2" name="piramede">
                                                                <option></option>
                                                                <option value="1" {!! !empty($grafico_tipo_tres->piramede) ? 'selected' :'' !!}>Sim</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-12 m-0">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Tipo de Gráfico</label>
                                                            <select class="select2" name="type_grafico">
                                                                {!! Graficos($grafico_tipo_tres->type_grafico) !!}
                                                            </select>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="card-body">
                                                        <button type="submit" class="btn btn-form btn-primary btn-lg"><i class="icon-save mr-2"></i>Salvar</button>
{{--
                                                        @if(!empty($grafico_tipo_tres))
                                                            @if($grafico_tipo_tres->status == 2)
                                                                <a href="{!! route('dash.grafico.acao', $grafico_tipo_tres->id) !!}?type=1&id_indicador={!! $indicador->id !!}" class="btn btn-status btn-warning btn-lg" style="color:black !important"><i class="icon-save mr-2"></i>Inativar Gráfico</a>
                                                            @else
                                                                <a href="{!! route('dash.grafico.acao', $grafico_tipo_tres->id) !!}?type=2&id_indicador={!! $indicador->id !!}" class="btn btn-status btn-success btn-lg" style="color:black !important"><i class="icon-save mr-2"></i>Ativar Gráfico</a>
                                                            @endif
                                                        @endif --}}
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <div class="tab-pane animated fadeInUpShort" id="analitico">

                                                <div class="col-12 layout t1">
                                                    @if(empty($array_quatro))
                                                    {!!Form::open(['method' => 'post', 'autocomplete' => false, 'route' => ['dash.indicadorTheme.grafico', http_build_query(Request::input())], 'class' => ($errors->any()) ? 'was-validated': '' ,'novalidate', 'files' => true])!!}
                                                    <input type="hidden" value="grafico 4" class="form-control" name="name" required>
                                                    <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Escolha os campos para aparecer no analítico <span class="text-danger">ANALÍTICO</span> </label>
                                                    <div class="row">
                                                        <div class="form-group col-12 m-0">
                                                            <input type="hidden" value="{!! $indicador->id !!}" name="id_indicador">
                                                            <input type="hidden" value="4" name="tipo">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Selecione as colunas </label>
                                                            @if(!empty($colunas))
                                                                <select class="select2" name="x[]" multiple="multiple">
                                                                    @foreach($colunas as $row)
                                                                        <option value="{!! $row !!}"> {!! $row !!} </option>
                                                                    @endforeach
                                                                </select>
                                                            @else
                                                            <div class="alert alert-warning">Nenhum campo encontrado </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    @else
                                                    {!!Form::open(['method' => 'put', 'autocomplete' => false, 'route' => ['dash.indicadorTheme.update', $grafico_tipo_quatro->id, http_build_query(Request::input())], 'class' => ($errors->any()) ? 'was-validated': '' ,'novalidate'])!!}
                                                    <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Escolha os campos para aparecer  <span class="text-danger">ANALÍTICO</span> </label>
                                                    <div class="row">

                                                        <div class="form-group col-12 m-0">
                                                            <input type="hidden" value="{!! $indicador->id !!}" name="id_indicador">
                                                            <input type="hidden" value="4" name="tipo">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Selecione as colunas</label>

                                                            <input type="hidden" value="teste" class="form-control" name="name" required>
                                                            @if(!empty($colunas))
                                                                <select class="select2" name="x[]" multiple="multiple">
                                                                    @foreach($colunas as $row)
                                                                    <option value="{!! $row !!}" {!! (in_array($row, $array_quatro) ? "selected" : '')  !!}> {!! $row !!}
                                                                    @endforeach
                                                                </select>
                                                            @else
                                                                <div class="alert alert-warning">Nenhum campo encontrado </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="card-body">
                                                        <button type="submit" class="btn btn-save-new btn-form btn-primary btn-lg"><i class="icon-save mr-2"></i>Salvar</button>
                                                   </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <div class="tab-pane animated fadeInUpShort" id="notas">

                                                <div class="col-12 layout t1">
                                                    {!!Form::open(['method' => 'post', 'autocomplete' => false, 'route' => ['dash.indicadorTheme.notas', $indicador->id, http_build_query(Request::input())], 'class' => ($errors->any()) ? 'was-validated': '' ,'novalidate', 'files' => true])!!}
                                                    <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Notas do Sistema</label>
                                                    <div class="row">
                                                        <div class="form-group col-12 m-0">
                                                            <textarea name="notas" placeholder="Digite aqui as notas"></textarea>
                                                        </div>
                                                        <div class="form-group col-12 m-0">
                                                            <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Selecione o ano da nota</label>
                                                            <select class="select2" name="ano">
                                                                @foreach ( Anos() as $row )
                                                                    <option value="{!! $row !!}">{!! $row !!}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <button type="submit" class="btn btn-save-nota btn-primary btn-lg"><i class="icon-save mr-2"></i>Envir notas</button>
                                                        </div>
                                                    </form>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
</div>
</div>
</div>
</div>
<!-- Right Sidebar -->
<script src="{!! asset('assets/js/app.js') !!}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.3.10/sweetalert2.min.js"></script>
<script src="{!! asset('assets/js/validacao.js') !!}"></script>
<script>
document.querySelector('.custom-file-input').addEventListener('change',function(e){
  var fileName = document.getElementById("validatedCustomFile").files[0].name;
    $('.custom-file-label').html(fileName)
})
$(".btn-submit-form").click(function (e) {
    e.preventDefault();

    //disable the submit button
    $(".btn-submit-form").attr("disabled", true);
    $(".btn-add-camp-form").attr("disabled", true);
    $(".btn-save-new").attr("disabled", true);
    $(".btn-save-nota").attr("disabled", true);
    $('.btn-submit-form').html('<i class="fa-solid fa-spinner fa-spin-pulse"></i> Enviado')
    return true;
});
</script>
<script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
  </script>
</body>
</html>

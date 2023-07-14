¨@include("dashboard.include.header")
<div class="page has-sidebar-left height-full">
<div class="container-fluid relative animatedParent animateOnce">
    <div class="animated fadeInUpShort">
        <style>

            #v-pills-tab { width:100%; background:#2979ff!important; margin-top:20px; padding:10px; border-radius:10px; }
            #v-pills-tab li a { color:#fff; }
            #v-piils-tab li .active { background: #fff !important;}


        </style>

        <div class="row my-3">
            <div class="col-md-12">

                @include('alert')
                    <div class="card no-b  no-r">
                        <div class="card-body">
                            <div class="col-12">
                                <div class="row">
                                    @if(!$resultado->isEmpty())
                                    <ul class="nav responsive-tab nav-material nav-material-white" id="v-pills-tab">
                                        <li><a class="nav-link active" id="v-pills-2-tab" data-toggle="pill" href="#principal"><i class="icon  icon-note mb-3"></i>Análitico</a></li>
                                        <li>
                                            <a class="nav-link" id="v-pills-1-tab" data-toggle="pill" href="#grafico">
                                                <i class="icon icon-bar-chart2"></i>Gráfico</a>
                                        </li>
                                    </ul>
                                    @else
                                        <div class='alert alert-warning'> Ao incluir o arquivo em excel, é necessário informar os campos que o sistema deve incluir. Refaça o procedimento  e exclua esse atual </div>
                                    @endif

                                </div>
                            </div>
                            <div class="container-fluid relative animatedParent animateOnce">
                            <div class="tab-content pb-3" id="v-pills-tabContent">
                            <div class="tab-pane animated fadeInUpShort show {!! (!$resultado->isEmpty()) ? 'active' : ''  !!}" id="principal">
                            <div class="form-row mt-1">
                                <div class="form-group col-12 m-0">
                                    <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Informações do gráfico analitico </label>
                                    <div class="box-body">
                                        <form action="{!! route('dash.indicadorTheme.info.grafico.destroy') !!}" id="form-pendente" method="POST">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <tbody>
                                                <tr>
                                                    <th style="width: 110px">
                                                        <input type="checkbox" id="flowcheckall" value="" onclick="javascript:checkAll(this)" /><span> Todos</span>
                                                    </th>
                                                    @foreach ($names as $name)
                                                    <th class="c-{{$name}}">{{ ucfirst(str_replace('_', ' ', $name)) }}</th>
                                                    @endforeach
                                                </tr>
                                            <input type="hidden" value="{!! $grafico->id !!}" id="faixa" name="faixa">
                                            @csrf
                                                @foreach ( $resultado as $key => $row)
                                                @if (!empty($row->id_indicador))
                                                        <td><input value="{{$row->id}}" type="checkbox" id="checkbox-pendente-{{$key}}" class="form-control checkbox-pendente" name="id[]"></td>
                                                        <td class="d-none"><input type="hidden" name="indicator_id" id="indicator_id" value="{!! $row->id_indicador!!}"></td>
                                                        <td class="d-none"><input type="hidden" name="number_indicators" id="number_indicators" value="{!! count($resultado) !!}"></td>
                                                        @foreach ($names as $name)
                                                            @php
                                                                $value = $row->{$name};
                                                            @endphp
                                                            <td class="counter c-{{$name}}" data-name="c-{{$name}}">{{$value}}</td>
                                                        @endforeach
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                            </table>
                                        </div>
                                        <div class="flex">
                                            {{ $resultado->links() }}
                                          </div>
                                        <div class="d-none p-3" id="delete-all">
                                            <button type="button" class="btn btn-danger btn-delete-all">Excluir</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="tab-pane animated fadeInUpShort show" id="grafico" style="margin-top:30px;">
                                <div class="col-12 layout t1">
                                <form action="{!! route('grafico.gerar') !!}" method="GET" target="_blank">
                                    <input type="hidden" name="temp" value="temporario">
                                    <input type="hidden" name="id_indicativo" value="{!! !empty($row) ? $row->id_indicador : null !!}">
                                <div class="row">
                                    <div class="form-group col-6 m-0">
                                        <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Escolha o eixo X </label>
                                            <select class="select2" name="x[]" multiple>
                                                @foreach ($names as $name)
                                                <option class="c-{{$name}}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                    <div class="form-group col-6 m-0">
                                        <label for="nome" class="col-form-label s-12">
                                            <i class="icon-information s-28 mr-2"></i>Escolha o titulo do eixo X</label>
                                            <select class="select2" name="titulo">
                                                @foreach ($names as $name)
                                                <option class="c-{{$name}}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                    </div>

                                    <div class="form-group col-6 m-0">
                                        <label for="nome" class="col-form-label s-12">
                                            <i class="icon-information s-28 mr-2"></i>Ano</label>
                                            <select class="select2" name="ano">
                                                @foreach (Anos() as $row)
                                                    <option>{!! $row !!}</option>
                                                @endforeach
                                            </select>
                                    </div>

                                    <div class="form-group col-6 m-0">
                                        <label for="nome" class="col-form-label s-12">
                                            <i class="icon-information s-28 mr-2"></i>Estado</label>
                                            <select class="select2" name="estado">
                                                {!! UnidadeTerritorial() !!}
                                            </select>
                                    </div>

                                    <div class="form-group col-12 m-0">
                                        <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Tipo de Gráfico</label>
                                        <select class="select2" name="type_grafico">
                                            {!! Graficos() !!}
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-primary" style="margin: 20px;">Gerar Gráfico </button>
                                </form>
                                </div>
                            </div>
                            </div>
                            </div>
                        </div>

                         <div class="card-body">
                             <a href="{{route('dash.grafico.aproved', $grafico->id)}}" class="btn btn-status btn-primary btn-lg"><i class="icon-save mr-2"></i>Aprovar Dados</a>

                             {{-- <a href="{{route('grafic.export', $grafico->enum, http_build_query(Request::input()))}}" class="btn btn-success btn-lg"><i class="icon-file-excel-o mr-2"></i>Exportar Excel</a> --}}
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
let count = []

document.querySelectorAll('.counter').forEach(function(element) {
    let name = element.dataset.name
    let value = element.innerHTML
    if (count[name] === undefined) {
        count[name] = 0
    }
    if (value != '') {
        ++count[name]
    }
});

Object.keys(count).forEach(key => {
    if(`.${key}` != '.c-estado' && `.${key}` != '.c-cidade' && `.${key}` != '.c-ano'){
        if (count[key] == 0) {
            document.querySelectorAll(`.${key}`).forEach((el) => {
                if ('OPTION' === el.tagName) {
                    console.log($(el).remove());
                } else {
                    el.style.display = "none";
                }
            });
        }
    }
});
</script>

<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
{{--
<select id="appbundle_items_accountdebet" name="appbundle_items[accountdebet]" class="js-example-basic-single"><option value="1">001 - Środki trwałe x</option><option value="2">001-001 - Środek trwały 1 </option><option value="3">001-002 - Środek trwały 2 </option><option value="4">002 - Kasa</option><option value="7">04-33 - test</option><option value="10">05 - dff</option></select>
 --}}
<script>
    $(document).ready(function() {
    $(".select2").select2();
});
</script>
<script type="text/javascript">
$('.checkbox-pendente').change(function(){
  let allInputChecked = $('.checkbox-pendente:checkbox:checked')
  if(this.checked){
    $('#delete-all').removeClass("d-none").addClass("d-block")
  }else if(allInputChecked.length < 1){
    $('#delete-all').removeClass("d-block").addClass("d-none")
  }
})
$('.btn-delete-all').on('click', function(e){
        const formPendente = document.getElementById('form-pendente')
        const formData = new FormData(formPendente)
        let everythingIsChecked = false
        let allInputChecked = []
        let faixa = $('#faixa').val()
        let indicator_id = $('#indicator_id').val()

        $('.checkbox-pendente:checkbox:checked').each(function(){
            allInputChecked.push(this.value)
        })

        if(allInputChecked.length == $('#number_indicators').val()){
            everythingIsChecked = true
        }

        var url = formPendente.action;
        new Swal({
                title: "Apagar dados planilha",
                text: "Deseja realmente excluir todos esses itens?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Sim'
              }).then(function(result) {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Processando...',
                        html: 'Aguarde um instante, estamos processando a sua requisição!',
                        timer: 2500
                    });
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        dataType : "json",
                        contentType: "application/json; charset=utf-8",
                        type: 'POST',
                        url: url,
                        data: JSON.stringify({id: allInputChecked, deleteAll: everythingIsChecked, faixa: faixa, indicator_id:indicator_id}),
                        statusCode: {
                        200: function(data) {
                            window.location.href = data.url
                        },
                        400: function() {
                            alert( "page not found" );
                        }
                        }
                    })
                }
            });
    });
    </script>

</body>
</html>

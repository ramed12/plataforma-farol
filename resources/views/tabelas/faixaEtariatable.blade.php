<link rel="stylesheet" type="text/css" href="{!! asset('style.css') !!}" media="all" />
<style>
    .artigo {height:70px; max-width:250px; border-radius:42px; margin-top:-20px; margin-left:10px}
    .artigo h1 { position: relative; font-size:13px !important; top:20px;  text-align: center;  font-weight: bolder; }
    .artigo { box-shadow: 1px 1px 7px rgba(0,0,0.1); }
    .temas { background:#fff; border-radius:20px; padding:10px; box-shadow: 1px 4px 15px rgba(0,0,0,.4); }
    .temas  li {list-style-type: circle; width:280px; text-align: left; font-weight: bolder; position: relative; left:30px; margin-top:20px;}
    .temas  li a { font-weight: 600; line-height: 5px; }
    .temas .titulo { padding:10px; border-radius:10px;}
    .temas .titulo h3 { font-weight: bolder;}
    .temas { margin-left:20px; left:-40px;}
    .graficos { margin-top:40px; padding:10px }
    .graficos label { float:left;}
    .graficos .reck { box-shadow:1px 9px 15px rgba(0,0,0,.2); margin-top:10px; padding:10px; border-radius: 10px; }
    .tipo_example {margin-top:40px;}
    .indicador h2 {float:left; font-size:17px;}
    .indicador { margin-top:50px;}
    .indicador label { float:left; margin-left:40px; }
    </style>
<div class="col-12 graficos">
    <div class="row">
        <div class="col-md-12 reck">
            @if(!empty($table))
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                @foreach ( $table as $name => $value )
                                    <th scope="col">{!! $name !!}</th>
                                @endforeach
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ( $table as $name => $value )
                                @foreach ($value as $k => $v)
                                    <tr>
                                    @foreach ( $table as $namex => $value )
                                        <td>{{ $table[$namex][$k] }}</td>
                                    @endforeach
                                    </tr>
                                @endforeach
                                @php
                                    break;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
              @else
              <div class="alert alert-warning">Nenhum gráfico gerado</div>
              @endif
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



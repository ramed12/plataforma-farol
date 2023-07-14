        @include("usuario.include.header")
        <style>
        .artigo {height:150px; border-radius:42px; margin-top:10px;}
        .artigo h1 { position: relative; font-size:17px !important; top:60px;  text-align: center;  font-weight: bolder; }
        .artigo { box-shadow: 1px 1px 7px rgba(0,0,0.1); }
        .temas { background:#fff; border-radius:20px; padding:10px; box-shadow: 1px 4px 15px rgba(0,0,0,.4); }
        .temas  li {list-style-type: circle; width:280px; text-align: left; font-weight: bolder; position: relative; left:30px; margin-top:20px;}
        .temas  li a { font-weight: 600; line-height: 5px; }
        .temas .titulo { padding:10px; border-radius:10px;}
        .temas .titulo h3 { font-weight: bolder;}
        .temas { margin-left:20px; left:-40px;}
        @media (max-width: 768px) {  .temas { margin-left:0px; left:0px; margin-top: 10px;}  }
        </style>
        <div class="about-us module" style="margin-top:70px;">
            <div class="section-title">
                <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3 col-12">
                    @foreach($panel as $row)
                           <div class="col-12 artigo" style="background: {!! $row->cor !!}; {!! ($id != $row->id) ? 'filter: grayscale(100%) !important;' : '' !!}">
                                <a href="{!! route('painel_home', $row->id) !!}"><center><h1 style="color:#000; width: 100%; word-wrap: break-word;">{!! $row->name !!}</h1></center></a>
                           </div>
                     @endforeach
                    </div>
                        <div class="col-md-9 col-12 mt-5 px-md-5 px-0 ml-md-0 ml-4">
                            <div class="row">
                                @if(!$temas->isEmpty())
                                    @foreach($temas as $row)
                                        <ul class="temas col-md-4 col-12">
                                            <div class="titulo"> <h3>{!! $row->name !!}</h3></div>
                                            <hr>
                                            <div class="conteudo col-12">
                                                @if(!empty($row->indicadores))
                                                    @foreach ( $row->indicadores as $reck)
                                                        <li class="px-0 px-md-3" style="width: 100%; word-wrap: break-word;"><a href="{{ route('indicativos_home', ["id_painel" => $id, "id" => $reck->id]) }}">{!! $reck->name !!}</a></li>
                                                    @endforeach
                                                @else
                                                <span class="alert alert-warning">Nenhum indicador Cadastrado</span>
                                                @endif
                                            </div>
                                            <br>
                                        </ul>
                                    @endforeach
                                @else
                                <span class="alert alert-warning" style="border-radius:10px;">Nenhum tema cadastrado</span>
                                @endif
                            </div>
                        </div>
                </div>
            </div>
            </div>
        </div>
         @include("usuario.include.footer")


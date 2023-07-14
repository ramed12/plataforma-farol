        @include("usuario.include.header")
        <style>

        .artigo {height:200px; border-radius:62px; margin-left:10px; margin-top:20px;}
        .artigo h1 { position: relative; font-size:20px !important; top:60px;  text-align: center;  font-weight: bolder; width:250px }
        .artigo { box-shadow: 1px 1px 7px rgba(0,0,0.1); }
        .artigo i { color:#fff; font-size:46px; position: relative; top:30px;}
        </style>

        <div class="about-us module" style="margin-top:80px;">
            <style> .container {width: 50%} </style>
            <div class="section-title">
                <div class="container">
                    <div class="row">
                        @foreach($panel as $row)
                           <div class="col-md-5 artigo" style="background: {!! $row->cor !!}">
                            <a href="{!! route('painel_home', $row->id) !!}"><center><h1 style="color:#000; width: 100%; word-wrap: break-word;">{!! $row->name !!}</h1></center></a>
                            </div>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>



         @include("usuario.include.footer")
         {{-- <script>

            $("#grafico-value").on('change', function(e){
                grafico = $("#grafico-tipo").val();
                grafico_ano = $("#grafico-ano").val();
                tipo_grafico = $("#grafico-grafico").val();
                $("#url").attr('src', 'grafico/show?ano='+grafico_ano+'&tipo=' + grafico + '&grafico=' + tipo_grafico);
             });
            </script> --}}


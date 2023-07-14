        @include("usuario.include.header")

         <div class="about-us module" style="margin-top:80px;">

            <div class="section-title">
            <div class="row">
            <div class="col-md-3 s">
                <style>
                    .section-title { max-width:90% }
                    .s {position: relative; top:190px}
                    </style>

                <form action="" method="" id="grafico-value">
                    <select name="" class="form-control" id="grafico-tipo">
                        <option value="1"> Faixa etária </option>
                    </select>
                    <select style="margin-top:20px;" id="grafico-ano" name="" class="form-control">
                        @foreach ($ano as $row )
                            <option value="{{$row}}"> {{$row}} </option>
                        @endforeach
                    </select> <BR>
                    <label> Modelo do Gráfico </label>
                    <select name="" class="form-control" id="grafico-grafico">
                        <option value="1"> Colunas </option>
                        <option value="2"> Linha </option>
                        {{-- <option value="3"> Pizza </option> --}}
                        <option value="4"> Radar </option>
                        <option value="5"> Por área</option>
                    </select>
                </form>


            </div>

            <div class="col-md-9">
                <div class="row" id="resultado_ajax" style="height:800px; min-width:100%">
                    <iframe id="url" src="grafico/show?ano=2021&tipo=1&grafico=1" frameborder="0" style="overflow:hidden;height:100%;width:100%" height="800" width="100%"></iframe>
                   </div>
            </div>
            </div>


            </div>
            {{-- <div class="container">

            </div> --}}
         </div>



         @include("usuario.include.footer")
         <script>

            $("#grafico-value").on('change', function(e){
                grafico = $("#grafico-tipo").val();
                grafico_ano = $("#grafico-ano").val();
                tipo_grafico = $("#grafico-grafico").val();
                $("#url").attr('src', 'grafico/show?ano='+grafico_ano+'&tipo=' + grafico + '&grafico=' + tipo_grafico);
             });
            </script>


@include("dashboard.include.header")
<div class="page has-sidebar-left height-full">
<div class="container-fluid relative animatedParent animateOnce">
    <div class="animated fadeInUpShort">
        <div class="row my-3">
            <div class="col-md-9  offset-md-2">

                @if (isset($indicador))
                        {!!Form::model($indicador, ['method' => 'put', 'autocomplete' => false, 'route' => ['dash.indicadorTheme.update', $indicador->id, http_build_query(Request::input())], 'class' => ($errors->any()) ? 'was-validated': '' ,'novalidate'])!!}
                     @else
                        {!!Form::open(['method' => 'post', 'autocomplete' => false, 'route' => ['dash.indicadorTheme.store', http_build_query(Request::input())], 'class' => ($errors->any()) ? 'was-validated': '' ,'novalidate'])!!}
                @endif
                    <div class="card no-b  no-r">
                        <div class="card-body">
                            <h5 class="card-title"> {!! isset($indicador) ? 'Atualizar Indicador' : 'Cadastrar Indicador' !!} <i class="icon-trending_up"></i></h5>
                            <hr>
                            <style>
                                .form-control { padding:20px !important; }
                                .form-group { margin-top:20px !important; }
                                .s-28 { font-size:27px !important; position: relative; top:5px; }
                            </style>
                            <div class="form-row mt-1">
                                <div class="form-group col-12 m-0">
                                    <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Nome do indicador </label>
                                    {!!Form::text('name', null, ['class' => 'form-control r-0 light s-12'])!!}
                                    @error('name')
                                    <p class="text-danger">{!! $message !!}</p>
                                   @enderror
                                </div>
                            </div>
                            <div class="form-row mt-1">
                            <div class="form-group col-12 m-0">
                                <label for="nome" class="col-form-label s-12"><i class="icon-information s-28 mr-2"></i>Selecione o Tema </label>
                                {!!Form::select('tema_filho', $temas, isset($tema_filho) ? $tema_filho : null, ['class' => 'select2'])!!}
                                @error('tema_filho')
                                    <p class="text-danger">{!! $message !!}</p>
                                @enderror
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
</div>
</div>
</div>
</div>
<!-- Right Sidebar -->
<script src="{!! asset('assets/js/app.js') !!}"></script>
</body>
</html>

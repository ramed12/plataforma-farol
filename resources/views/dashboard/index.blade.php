@include("dashboard.include.header")
<div class="page has-sidebar-left height-full">
    <div class="container-fluid relative animatedParent animateOnce">
        <div class="tab-content pb-3" id="v-pills-tabContent">
            <!--Today Tab Start-->
            <div class="tab-pane animated fadeInUpShort show active" id="v-pills-1">
                @include('alert')
                <div class="row my-3">
                    <div class="col-md-3">
                        <div class="counter-box white r-5 p-3">
                            <div class="p-4">
                                <div class="float-right">
                                    <span class="icon icon-folder-bookmark text-light-blue s-48"></span>
                                </div>
                                <div class="counter-title">Temas Cadastrados</div>
                                <h5 class="sc-counter mt-3">{{ $indicador}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="counter-box white r-5 p-3">
                            <div class="p-4">
                                <div class="float-right">
                                    <span class="icon icon-folder-checked text-light-blue s-48"></span>
                                </div>
                                <div class="counter-title ">Temas Ativos</div>
                                <h5 class="sc-counter mt-3">{{($indicadorAtivo != 0 ) ? $indicadorAtivo : 0 }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="counter-box white r-5 p-3">
                            <div class="p-4">
                                <div class="float-right">
                                    <span class="icon icon-folder-error text-light-blue s-48"></span>
                                </div>
                                <div class="counter-title">Temas Inativos</div>
                                <h5 class="sc-counter mt-3">{{($indicadorInativo != 0 ) ? $indicadorInativo->count() : 0 }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="counter-box white r-5 p-3">
                            <div class="p-4">
                                <div class="float-right">
                                    <span class="icon icon-folder-remove text-light-blue s-48"></span>
                                </div>
                                <div class="counter-title">Temas Removidos</div>
                                <h5 class="sc-counter mt-3">{{((!$indicadorRemovido->isEmpty())) ? $indicadorRemovido : 0}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="white p-5 r-5">
                            <div class="card-title">
                                <h5> Acessos ao Portal Farol</h5>
                            </div>
                            <div class="row my-3">
                                <div style="width:100%;">
                                    {!! $grafico->render() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="assets/js/app.js"></script>
</body>
</html>

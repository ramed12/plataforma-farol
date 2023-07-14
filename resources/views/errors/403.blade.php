@include("dashboard.include.header")
<div class="page has-sidebar-left height-full">
    <div class="container-fluid relative animatedParent animateOnce">
        <div class="tab-content pb-3" id="v-pills-tabContent">
            <!--Today Tab Start-->
            <div class="tab-pane animated fadeInUpShort show active" id="v-pills-1">
                <div class="height-full light">
                    <div id="primary" class="content-area"
                         data-bg-possition="center"
                         data-bg-repeat="false"
                         style="background: url('assets/img/icon/icon-circles.png');">
                        <div class="container">
                            <div class="col-xl-12 mx-lg-auto p-t-b-80">
                                <header class="text-center mb-5">
                                    <h1 class="">oops!</h1>
                                    <p class="section-subtitle alert alert-danger" style="font-size:18px">Você não tem permissão para fazer essa ação. Preocure o Administrador do sistema</p>

                                </header>
                                <div class="pt-5 p-t-100 text-center">
                                    <p class="s-256 text-danger">403</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #primary -->
                </div>
                <!-- Right Sidebar -->
            </div>
        </div>
    </div>
</div>
</div>
<script src="{!! asset('assets/js/app.js') !!}"></script>
</body>
</html>

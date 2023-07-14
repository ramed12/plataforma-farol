@include("dashboard.include.header")
<div class="page has-sidebar-left height-full">
<div class="container-fluid relative animatedParent animateOnce">
    <div class="animated fadeInUpShort">
        <div class="row my-3">
            <div class="col-md-12">
                <form action="#">
                    <div class="card no-b  no-r">
                        <div class="card-body">
                            <h5 class="card-title">Alteração de senha</h5>


                            <div class="form-row mt-1">
                                <div class="form-group col-4 m-0">
                                    <label for="email" class="col-form-label s-12"><i class="icon-key3 mr-2"></i>Senha atual </label>
                                    <input id="email" placeholder="******" class="form-control r-0 light s-12 " type="text">
                                </div>

                                <div class="form-group col-4 m-0">
                                    <label for="phone" class="col-form-label s-12"><i class="icon-key4 mr-2"></i>Nova senha</label>
                                    <input id="phone" placeholder="******" class="form-control r-0 light s-12 " type="text">
                                </div>
                                <div class="form-group col-4 m-0">
                                    <label for="mobile" class="col-form-label s-12"><i class="icon-key4 mr-2"></i>Repetir nova senha</label>
                                    <input id="mobile" placeholder="*******" class="form-control r-0 light s-12 " type="text">
                                </div>

                            </div>

                        </div>
                        <hr>

                        <div class="card-body">
                            <button type="submit" class="btn btn-primary btn-lg"><i class="icon-save mr-2"></i>Alterar senha</button>
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
</body>
</html>

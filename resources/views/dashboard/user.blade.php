@include("dashboard.include.header")
<div class="page has-sidebar-left height-full">
<div class="container-fluid relative animatedParent animateOnce">
    <div class="animated fadeInUpShort">
        <div class="row my-3">
            <div id="conteudo" class="col-md-12">
                <form action="{!! route('dash.user.post') !!}" method="POST">
                    <div class="card no-b  no-r">
                        <div class="card-body">
                            <h5 class="card-title">Cadastrar novo usuário <i class="icon icon-user-plus"></i></h5>
                            <hr>

                            <style>

                                .form-control { padding:20px !important; }
                                .form-group { margin-top:20px !important; }
                                .s-28 { font-size:27px !important; position: relative; top:5px; }
                            </style>
                           @csrf
                            <div class="form-row mt-1">
                                <div class="form-group col-12 m-0">
                                    <label for="nome" class="col-form-label s-12"><i class="icon-credit-card-2 s-28 mr-2"></i>Nome do usuário </label>
                                    <input id="nome" name="name" placeholder="Digite aqui" value="{!! old('name') !!}" class="@error('name') border-danger @enderror form-control r-0 light s-12 " type="text">
                                    @error('name')
                                    <p class="text-danger">{!! $message !!}</p>
                                   @enderror
                                </div>
                                <div class="form-group col-12 m-0">
                                    <label for="cpf" class="col-form-label s-12"><i class="icon-credit-card-1 s-28 mr-2"></i>CPF do Usuário </label>
                                    <input id="cpf"  maxlength="11" name="cpf" placeholder="Digite aqui" value="{!! old('cpf') !!}" class="@error('cpf') border-danger @enderror form-control r-0 light s-12 " type="text">
                                    @error('cpf')
                                    <p class="text-danger">{!! $message !!}</p>
                                   @enderror
                                   <div style="position:relative; top:5px;" id="resultCpf"></div>
                                </div>
                                <div class="form-group col-12 m-0">
                                    <label for="email" class="col-form-label s-12"><i class="icon-mail-envelope-closed3 s-28 mr-2"></i>E-mail do usuário</label>
                                    <input id="email" name="email" placeholder="Ex: email@gmail.com" {!! old('email') !!} class="@error('email') border-danger @enderror form-control r-0 light s-12 " type="text">
                                    @error('email')
                                    <p class="text-danger">{!! $message !!}</p>
                                   @enderror
                                   <div style="position:relative; top:5px;" id="resultMail"></div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary btn-lg"><i class="icon-save mr-2"></i>Cadastrar Usuário</button>
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
<script>

$('#email').on("keyup", function() {
    var user = this.value;
    if(user.length > 5){
    $.ajax({
        url: "{!! route('validateEmail') !!}",
        type: "POST",
        data: {
            email: user,
            "_token": "{!! csrf_token() !!}"
        },
        dataType: "json",
        success: function(s){
            resultMail.innerHTML = `<span class='text-${s.status}'>${s.message}</span>`
            console.log(s)
        },
        error: function(e){
            console.log(e);
        }
    });
}
});


$('#cpf').on("keyup", function() {
    var user = this.value;
    if(user.length > 10){
    $.ajax({
        url: "{!! route('validateCpf') !!}",
        type: "POST",
        data: {
            cpf: user,
            "_token": "{!! csrf_token() !!}"
        },
        dataType: "json",
        success: function(s){
            resultCpf.innerHTML = `<span class='text-${s.status}'>${s.message}</span>`
            console.log(s)
        },
        error: function(e){
            console.log(e);
        }
    });
}
});



</script>
</body>
</html>

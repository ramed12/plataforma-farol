
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="José Alves - Desenvolvedor GAO TECH">
    <meta name="csrf-token" content="{!! csrf_token() !!}"/>
    <title>Usuário - {!! $user->name !!}</title>
    <link rel="stylesheet" href="{!! asset('assets/css/app.css') !!}">
    <style>
        .loader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #F5F8FA;
            z-index: 9998;
            text-align: center;
        }

        .plane-container {
            position: absolute;
            top: 50%;
            left: 50%;
        }
    </style>
</head>
<body>
<div id="app">
<div class="page parallel">
    <div class="d-flex row">
        <div class="col-md-7 white">
            <div class="p-1 mt-4">
            <center><img style="max-width: 150px !important" src="{!! asset('assets/fundo-auth.png') !!}" alt=""></center>
            </div>
            <div class="p-5">
                <h3>Olá <b>{!! $user->name !!}</b></h3>
                <p>Para seu cadastro que foi feito no dia <b>{!! date('d/m/Y', strtotime($user->created_at)) !!}</b> seja efetivado, é necessário que
                você preencha as informações abaixo.<BR>
                Campos marcados com <span style="color:red"> * </span> são obrigatórios
                </p>
                <style>

                    .form-control { padding:10px !important; }
                    .form-group { margin-top:10px !important; }
                    .s-28 { font-size:27px !important; position: relative; top:5px; }
                </style>
                <form action="{!! route('user.update', $user->id) !!}" method="POST">
                    @csrf

                    <hr>

                    <div class="form-row mt-1">
                        <div class="form-group col-4 m-0">
                            <label for="nome" class="col-form-label s-12"><i class="icon-credit-card-2 s-28 mr-2"></i>Seu Nome </label>
                            <input id="nome" name="name" placeholder="Digite aqui" value="{!! $user->name !!}" class=" form-control r-0 light s-12 " type="text" readonly>
                        @error('name')
                            <span class="text-danger">{!! $message !!}</span>
                        @enderror

                        </div>

                        <div class="form-group col-4 m-0">
                            <label for="email" class="col-form-label s-12"><i class="icon-mail-envelope-closed3 s-28 mr-2"></i>Seu e-mail </label>
                            <input id="email" name="email" placeholder="Digite aqui" value="{!! $user->email !!}" class=" form-control r-0 light s-12 " type="text" readonly>
                            @error('email')
                            <span class="text-danger">{!! $message !!}</span>
                        @enderror
                        </div>

                        <div class="form-group col-4 m-0">
                                <label for="cpf" class="col-form-label s-12"><i class="icon-credit-card-1 s-28 mr-2"></i>Seu CPF</label>
                                <input id="cpf" name="cpf" placeholder="Digite aqui" value="{!! $user->cpf !!}" class=" form-control r-0 light s-12 " type="text" readonly>
                                @error('cpf')
                                <span class="text-danger">{!! $message !!}</span>
                            @enderror
                            </div>

                        <div class="form-group col-3 m-0">
                            <label for="phone" class="col-form-label s-12"><i class="icon-telephone s-28 mr-2"></i>Seu Telefone <span style="color:red">*</span></label>
                            <input id="phone" name="phone" placeholder="Digite aqui" value="{!! old('phone') !!}" class=" form-control r-0 light s-12 " type="text">
                            @error('phone')
                            <span class="text-danger">{!! $message !!}</span>
                        @enderror
                        </div>

                        <div class="form-group col-3 m-0">
                            <label for="instituicao" class="col-form-label s-12"><i class="icon-user-secret s-28 mr-2"></i>Sua Instituição <span style="color:red">*</span></label>
                            <select name="instituicao" class="form-control r-0 light s-12">
                                @foreach ($instituicao as $row)
                                    <option value="{!! $row->id !!}">{!! $row->name !!}</option>
                                @endforeach
                            </select>
                            @error('instituicao')
                            <span class="text-danger">{!! $message !!}</span>
                        @enderror
                        </div>

                        <div class="form-group col-4 m-0">
                            <label for="cargo" class="col-form-label s-12"><i class="icon-account_balance_wallet s-28 mr-2"></i>Seu cargo <span style="color:red">*</span></label>
                            <input id="cargo" name="cargo" placeholder="Digite aqui" value="{!! old('cargo') !!}" class=" form-control r-0 light s-12 " type="text">
                            @error('cargo')
                            <span class="text-danger">{!! $message !!}</span>
                        @enderror
                        </div>

                        <div class="form-group col-4 m-0">
                            <label for="senha" class="col-form-label s-12"><i class="icon-key3 s-28 mr-2"></i>Sua senha <span style="color:red">*</span></label>
                            <input id="senha" name="password" placeholder="Digite aqui"  class=" form-control r-0 light s-12 " type="password">
                            @error('password')
                            <span class="text-danger">{!! $message !!}</span>
                        @enderror
                        </div>

                        <div class="form-group col-4 m-0">
                            <label for="resenha" class="col-form-label s-12"><i class="icon-key3 s-28 mr-2"></i>Repetir senha <span style="color:red">*</span></label>
                            <input id="resenha" name="password_confirmation" placeholder="Digite aqui" class=" form-control r-0 light s-12 " type="password">
                            @error('password_confirmation')
                            <span class="text-danger">{!! $message !!}</span>
                        @enderror
                        </div>





                    </div>


                    <input style="margin:40px; width:200px;" type="submit" class="btn btn-primary btn-lg btn-block" value="Efetivar cadastro">
                </form>
                @include('alert')


                <p style="margin-top:10px;">Por motivos de segurança, salvamos seu IP: {!! Request::ip() !!} <br>
                    Versão do programa {!! env('SYSTEM_VERSION') !!} <BR>

                    Plataforma desenvolvida por <a target="_BLANK" href="https://gaotech.com.br"><img style="max-width:100px" src="{!! asset('assets/logo-gao.png') !!}"></a>

                    </p>
            </div>
        </div>
        <div class="col-md-5  height-full accent-3 align-self-center text-center" data-bg-repeat="false"
             data-bg-possition="center"
             style="background: url('{!! asset('assets/fundo-painel.png') !!}') #FFEFE4; background-size:800px 800px">
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
     $("#semOlhoSenha").hide()
      $("#olhoSenha").click(function(){
    $('#alterandoSenha').get(0).type = 'text';
    $("#olhoSenha").hide()
    $("#semOlhoSenha").show()
  })

  $("#semOlhoSenha").click(function(){
      $("#alterandoSenha").get(0).type = "password"
      $("#semOlhoSenha").hide()
      $("#olhoSenha").show()
 })

  </script>

</body>

</html>


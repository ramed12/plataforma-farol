
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="José Alves - Desenvolvedor GAO TECH">
    <meta name="csrf-token" content="{!! csrf_token() !!}"/>
    <title>Projeto Farol da Inovação - Login</title>
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
        <div class="col-md-3 white">
            <div class="p-1 mt-4">
            <center><img style="max-width: 150px !important" src="{!! asset('assets/fundo-auth.png') !!}" alt=""></center>
            </div>
            <div class="p-5">
                <h3>Bem vindo de volta</h3>
                <p>Para acessar o painel digite seu login e senha</p>
                <form action="{!! route('auth.post') !!}" method="POST">
                    @csrf
                    <div class="form-group has-icon"><i class="icon-envelope-o"></i>
                        <input type="text" name="email" class="form-control form-control-lg @error('email') border-danger @enderror"
                        placeholder="Seu e-mail">
                               @error('email')
                                <p class="text-danger">{!! $message !!}</p>
                               @enderror
                    </div>
                    <div class="form-group has-icon"><i class="icon-user-secret"></i>
                        <style>
                            .iconInput { position:absolute; right:51px !important; border:none !important; top:0; background:#000;  }
                        </style>
                        <div id="olhoSenha" class="iconInput"><i class="icon-eye"></i></div>
                        <div id="semOlhoSenha" class="iconInput"><i class="icon-eye-slash"></i></div>
                        <input id="alterandoSenha" type="password" name="password" class="form-control form-control-lg @error('password') border-danger @enderror"
                               placeholder="*********">
                               @error('password')
                               <p class="text-danger">{!! $message !!}</p>
                              @enderror
                    </div>
                    <input type="submit" class="btn btn-primary btn-lg btn-block" value="Acessar">
                </form>
                @include('alert')
                <a href="{!! route('auth.recovery') !!}"><button style="margin-top:5px; font-size:14px !important" class="btn btn-secundary btn-lg btn-block">Esqueceu sua senha? </button></a>

                <p style="margin-top:10px;">Por motivos de segurança, salvamos seu IP: {!! Request::ip() !!} <br>
                    Versão do programa {!! env('SYSTEM_VERSION') !!} <BR>

                    Plataforma desenvolvida por <a target="_BLANK" href="https://gaotech.com.br"><img style="max-width:100px" src="{!! asset('assets/logo-gao.png') !!}"></a>

                    </p>
            </div>
        </div>
        <div class="col-md-9  height-full accent-3 align-self-center text-center" data-bg-repeat="false"
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


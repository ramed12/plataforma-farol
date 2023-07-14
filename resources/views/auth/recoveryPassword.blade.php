
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="José Alves - Desenvolvedor GAO TECH">
    <meta name="csrf-token" content="{!! csrf_token() !!}"/>
    <title>Projeto Farol da Inovação - Recuperação de senah</title>
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
                <h3><a href="{!! route('auth') !!}" style="color:#86939e"> <i class="icon icon-arrow_back text-lime s-18"></i> Voltar </a></h3>
                <hr>
                <h3>Recuperação de senha</h3>
                <span> Digite seu e-mail para recuperar sua senha </span>
                <form action="{!! route('auth.recovery.post') !!}" style="margin-top:20px;" method="POST">
                    @csrf
                    <div class="form-group has-icon"><i class="icon-envelope-o"></i>
                        <input type="text" name="email" class="form-control form-control-lg @error('email') border-danger @enderror"
                        placeholder="Seu e-mail">
                               @error('email')
                                <p class="text-danger">{!! $message !!}</p>
                               @enderror
                    </div>
                    <input type="submit" class="btn btn-primary btn-lg btn-block" value="Recuperar Senha">
                </form>
                @include('alert')
                <p style="margin-top:10px;">Por motivos de segurança, salvamos seu IP: {!! Request::ip() !!} <br>
                    Versão do programa {!! env('SYSTEM_VERSION') !!} <BR>

                        Plataforma desenvolvida por <a target="_BLANK" href="https://gaotech.com.br"><img style="max-width:100px" src="{!! asset('assets/logo-gao.png') !!}"></a>
            </div>
        </div>
        <div class="col-md-9  height-full accent-3 align-self-center text-center" data-bg-repeat="false"
             data-bg-possition="center"
             style="background: url('{!! asset('assets/fundo-painel.png') !!}') #FFEFE4; background-size:800px 800px">
        </div>
    </div>
</div>

</body>

</html>


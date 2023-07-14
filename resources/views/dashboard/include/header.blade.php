<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="José Alves - GAO TECH">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" href="assets/img/basic/favicon.ico" type="image/x-icon">
    <title>DashBoard - Farol</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.tiny.cloud/1/p74lc9vtc30rv1bc4xj0ku9uc98fr6u90saf4dh1xd00g1pp/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.11.0/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        </script>
    <!-- CSS -->
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
        .swal2-container { background:rgba(0,0,0,.8) !important;}
    </style>
    <script>(function(w,d,u){w.readyQ=[];w.bindReadyQ=[];function p(x,y){if(x=="ready"){w.bindReadyQ.push(y);}else{w.readyQ.push(x);}};var a={ready:p,bind:p};w.$=w.jQuery=function(f){if(f===d||f===u){return a}else{p(f)}}})(window,document)</script>
    <script src="{!! asset('assets/js/checkAll.js') !!}"></script>
</head>
<body class="light sidebar-collapse">
    <div id="loader" class="loader">
        <div class="plane-container">
            <div class="preloader-wrapper small active">
                <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                </div><div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
                </div>

                <div class="spinner-layer spinner-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                </div><div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
                </div>

                <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                </div><div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
                </div>

                <div class="spinner-layer spinner-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                </div><div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
                </div>
            </div>
        </div>
    </div>
<div id="app">
<aside class="main-sidebar fixed offcanvas shadow" data-toggle='offcanvas'>
    <section class="sidebar">
        <div class="center mt-3 mb-7">
            <center><img style="max-width: 180px !important" src="{!! asset('logo.jpg') !!}" alt=""></center>
        </div>
        <div  class="mt-3 mb-3 ml-3 relative">
            <div class="user-panel p-3 light mb-2">
                <div>
                    <div class="float-left info">
                        <h6 class="font-weight-light mt-2 mb-1">Bem Vindo {!! Auth::user()->name !!}</h6>
                    </div>
                </div>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li class="header"><strong>MENU DE NAVEGAÇÃO</strong></li>
            <li class="treeview"><a href="{!! route('dashboard') !!}">
                <i class="icon icon-sailing-boat-water purple-text s-18"></i> <span>Início</span> </a>

            </li>
            <li class="header light mt-3"><strong>COMPONENTES</strong></li>
            <li class="treeview ">
                <a href="#">
                    <i class="icon icon-dashboard2 text-lime s-18"></i> <span>Painéis</span><i
                    class="icon icon-angle-left s-18 pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('dash.painel')  }}"><i class="icon icon-circle-o"></i>Cadastrados</a>
                    </li>
                    <li><a href="{!! route('dash.painel.create') !!}"><i class="icon icon-add"></i>Cadastrar</a>
                    </li>
                </ul>
            </li>
            <li class="treeview ">
                <a href="#">
                    <i class="icon icon-package text-lime s-18"></i> <span>Temas</span><i
                    class="icon icon-angle-left s-18 pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('dash.indicador')  }}"><i class="icon icon-circle-o"></i>Cadastrados</a>
                    </li>
                    <li><a href="{!! route('dash.indicador.novo') !!}"><i class="icon icon-add"></i>Cadastrar</a>
                    </li>
                </ul>
            </li>

            <li class="treeview ">
                <a href="#">
                    <i class="icon  icon-call_missed_outgoing text-lime s-18"></i> <span>Indicador</span><i
                    class="icon icon-angle-left s-18 pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('dash.indicadorTheme')  }}"><i class="icon icon-circle-o"></i>Cadastrados</a>
                    </li>
                    <li><a href="{!! route('dash.indicadorTheme.create') !!}"><i class="icon icon-add"></i>Cadastrar</a>
                    </li>
                    {{-- <li><a href="{!! route('dash.indicador.grafico') !!}"><i class="icon icon-analytics-1"></i>Gráficos</a>
                    </li> --}}
                </ul>
            </li>

            <li class="header light mt-3"><strong>DASHBOARD</strong></li>
            <li class="treeview ">
                <a href="#">
                    <i class="icon icon-user-o text-lime s-18"></i> <span>Usuários</span><i
                    class="icon icon-angle-left s-18 pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li><a href="{!! route('dash.user.list') !!}"><i class="icon icon-circle-o"></i>Cadastrados</a>
                    </li>
                    <li><a href="{!! route('dash.user') !!}"><i class="icon icon-add"></i>Cadastrar</a>
                    </li>
                </ul>
            </li>

            <li class="treeview ">
                <a href="{!! route('dash.senha') !!}">
                    <i class="icon icon-key3 text-lime s-18"></i> <span>Alterar Senha</span>
                </a>
            </li>

            <li class="treeview ">
                <a href="#">
                    <i class="icon icon-group_add text-lime s-18"></i> <span>Grupos de Usuários</span><i
                    class="icon icon-angle-left s-18 pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{!! route('dash.grupouser') !!}"><i class="icon icon-circle-o"></i>Cadastrados</a>
                    </li>
                    <li><a href="{!! route('dash.show') !!}"><i class="icon icon-add"></i>Cadastrar</a>
                    </li>
                </ul>
            </li>


            <li class="treeview ">
                <a href="#">
                    <i class="icon icon-flag5 text-lime s-18"></i> <span>Instituições</span><i
                    class="icon icon-angle-left s-18 pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{!! route('dash.instituicao') !!}"><i class="icon icon-circle-o"></i>Cadastrados</a>
                    </li>
                    <li><a href="{!! route('dash.instituicao.create') !!}"><i class="icon icon-add"></i>Cadastrar</a>
                    </li>
                </ul>
            </li>

            <li class="treeview ">
                <a href="{!! route('auth.logout') !!}">
                    <i class="icon icon-sign-out text-lime s-18"></i> <span>Sair</span>
                </a>
            </li>
        </ul>

       <center> <p style="margin-top:30px;">
                Plataforma desenvolvida por <a target="_BLANK" href="https://gaotech.com.br"><img style="max-width:100px" src="{!! asset('assets/logo-gao.png') !!}"></a></p></center>
    </section>
</aside>
<!--Sidebar End-->
<div class="has-sidebar-left">
    <div class="pos-f-t">
    <div class="collapse" id="navbarToggleExternalContent">
        <div class="bg-dark pt-2 pb-2 pl-4 pr-2">
            <div class="search-bar">
                <input style="width:100% !important;" class="transparent s-24 text-white b-0 font-weight-lighter w-128 height-50" type="text"
                       placeholder="Digite aqui para pesquisar.....">
            </div>
            <a href="#" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-expanded="false"
               aria-label="Toggle navigation" class="paper-nav-toggle paper-nav-white active "><i></i></a>
        </div>
    </div>

</div>
    <div class="sticky">
        <div class="navbar navbar-expand navbar-dark d-flex justify-content-between bd-navbar blue accent-3">
            <div class="relative">
                <a href="#" data-toggle="push-menu" class="paper-nav-toggle pp-nav-toggle">
                    <i></i>
                </a>
            </div>
<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">

        <li>
            <a class="nav-link " data-toggle="collapse" data-target="#navbarToggleExternalContent"
               aria-controls="navbarToggleExternalContent"
               aria-expanded="false" aria-label="Toggle navigation">
                <i class=" icon-search3 "></i>
            </a>
        </li>
        <!-- User Account-->

    </ul>
</div>
        </div>
        <header class="blue accent-3 relative nav-sticky">
            <div class="container-fluid text-white">
                <div class="row p-t-b-10 ">
                    <div class="col">
                        <h4>
                            <i class="icon  icon-arrow_back"></i>
                            <a href="{{ redirect()->getUrlGenerator()->previous() }}"> Voltar</a>
                        </h4>
                    </div>
                </div>
            </div>
        </header>
    </div>
</div>

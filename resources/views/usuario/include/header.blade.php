<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Projeto Farol - Início</title>
      <meta name="author" content="José Alves  - GAO TECH">
      <meta name="keywords" content="">
      <meta name="description" content="">
      <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" type="text/css" href="{!! asset('style.css') !!}" media="all" />
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <style>
        .formulario-busca input { border-radius:10px 0 0 10px; color: rgba(255,255,255,.7)}
        .formulario-busca input { float:left; width:600px;; border:none; outline: none; }
        .formulario-busca input { background:#1c345a; padding:10px; box-shadow: 1px 3px 10px rgba(0,0,0,.1)  }
        .formulario-busca input:focus { box-shadow: inset 1px 1px 10px rgba(255,255,255,.1); border:none; }
        .formulario-busca ::placeholder { color:#fff }
        .formulario-busca button { background:#fff; color:#000; cursor:pointer; border:1px solid rgba(0,0,0,.2); padding:9px;   }
        ng
.lds-dual-ring {
  display: inline-block;
  width: 64px;
  height: 64px;
}
.lds-dual-ring:after {
  content: " ";
  display: block;
  width: 46px;
  height: 46px;
  margin: 1px;
  border-radius: 50%;
  border: 5px solid #cef;
  border-color: #cef transparent #cef transparent;
  animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.navigation { background:none !important; box-shadow:1px 2px 3px rgba(0,0,0,.4); border:none !important }
.navigation ul li a { color:#7a7a7a !important; font-size:13px !important; position: relative; left:100px;}
.section-title { max-width:95% }
        </style>
</head>
   <body>
      <div class="main-container">
         {{-- <div class="top-bar">
            <div class="container">
               <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-6">
                     <div class="left-side">
                        <ul class="menu">
                           <li><i class="fas fa-map-marker-alt"></i>Praça da República, Bairro de Santo Antônio, Recife - PE, CEP 50.010-928</li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-sm-12 col-md-12 col-lg-5 text-right">
                    <div class="right-side">
                    <ul class="menu">
                        <style>
                            .font  a { font-size:11px !important }
                            </style>
                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                    <li class="font"><a href="#">ACESSIBILIDADE</a></li>
                    <li class="font"><a href="#">ALTO CONTRASTE</a></li>
                    <li class="font"><a href="#">MAPA DO SITE</a></li>
                    </ul>
                    </div>
                    </div>
               </div>
            </div>
         </div> --}}
         {{-- <div class="header">
            <div class="container">
               <div class="row">
                  <div class=" col-sm-12 col-lg-4 col-md-4">
                     <div class="logo">
                        <a href="/">
                        <img style="max-width: 150px;" src="{!! asset('logo.png') !!}" class="img-responsive" alt="Logo Projeto Farol">
                        </a>
                     </div>
                  </div>
                  <div style="margin-top:40px;" class="col-sm-12 col-lg-8 col-md-8">
                     <div class="info-container">
                        <div class="icon-box">
                           <div class="info-side">
                              <p>
                                <form class="formulario-busca" action="" method="POST">
                                    <input type="search" name="searchUser" placeholder="O que está procurando?">
                                    <button> Buscar </button>
                                </form>
                              </p>
                           </div>
                        </div>
                     </div>
                     <div class="clearfix"></div>
                  </div>
               </div>
            </div>
         </div> --}}
         <div class="navigation">
            <div class="container">
               <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                     <nav class="navbar navbar-expand-lg navbar-light bg-white">
                        <a class="navbar-brand" href="{{url('/')}}"><img style="max-width: 100px;" src="{!! asset('logo.png') !!}" class="img-responsive" alt="Logo Projeto Farol"></a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                          <span class="navbar-toggler-icon"></span>
                        </button>
                      
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                          <ul class="navbar-nav mr-auto"> 
                            <li class="nav-item"> 
                              <a class="nav-link" href="{{ route('home') }}">Página Inicial</a> 
                            </li> 
                            <li class="nav-item"> 
                              <a class="nav-link" href="#">Sobre Nós</a> 
                            </li>  
                            <li class="nav-item"> 
                              <a class="nav-link" href="#">Fale Conosco</a>
                            </li> 
                          </ul> 
                        </div>
                      </nav>
                  </div>
               </div>
            </div>
         </div>


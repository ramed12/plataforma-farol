<title> Gráfico geral </title>

<link rel="stylesheet" type="text/css" href="{!! asset('style.css') !!}" media="all" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .artigo {height:70px; max-width:250px; border-radius:42px; margin-top:-20px; margin-left:10px}
    .artigo h1 { position: relative; font-size:13px !important; top:20px;  text-align: center;  font-weight: bolder; }
    .artigo { box-shadow: 1px 1px 7px rgba(0,0,0.1); }
    .temas { background:#fff; border-radius:20px; padding:10px; box-shadow: 1px 4px 15px rgba(0,0,0,.4); }
    .temas  li {list-style-type: circle; width:280px; text-align: left; font-weight: bolder; position: relative; left:30px; margin-top:20px;}
    .temas  li a { font-weight: 600; line-height: 5px; }
    .temas .titulo { padding:10px; border-radius:10px;}
    .temas .titulo h3 { font-weight: bolder;}
    .temas { margin-left:20px; left:-40px;}
    .graficos { margin-top:40px; padding:10px }
    .graficos label { float:left;}
    .graficos .reck { box-shadow:1px 9px 15px rgba(0,0,0,.2); margin-top:10px; padding:10px; border-radius: 10px; }
    .tipo_example {margin-top:40px;}
    .indicador h2 {float:left; font-size:17px;}
    .indicador { margin-top:50px;}
    .indicador label { float:left; margin-left:40px; }
    #grafico_esquerda_abaixo { width:400px !important; height:400px !important; }
    .titulo { background:#f5f5f5; padding:7px; border-bottom:2px solid #dddddd; color:black }
    .row > div.conteudo {border:2px solid #abcdef; }
    .principal {max-width: 1000px; margin-right: 20px;}
    .titulo a { background:#9ad0f5; float:right; padding:4px; margin-top:-4px; border-radius: 10px;}
    .titulo a:hover { color:#000; box-shadow: 0px 1px 7px rgba(0,0,0.1)}
    </style>
<div class="col-12 graficos">
    <div class="row">
        @if(!empty($grafico_meio))
            <div id="testprint" class="conteudo principal col-md-12 reck">
               <div class="titulo">Gráfico Gerado<a href="" class="grafico_meio"><i class="fas fa-chevron-down"></i> Baixar gráfico</a></div>
                {!! $grafico_meio !!}
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jspdf@1.5.3/dist/jspdf.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>

<script>

$('.grafico_meio').on('click', function() {
    var canvas = document.querySelector("#grafico_meio");
    var canvas_img = canvas.toDataURL("image/png",1.0); //JPEG will not match background color
    var pdf = new jsPDF('landscape','in', 'letter'); //orientation, units, page size
    pdf.addImage(canvas_img, 'png', .5, 1.75, 10, 5); //image, type, padding left, padding top, width, height
    pdf.autoPrint(); //print window automatically opened with pdf
    var blob = pdf.output("bloburl");
    window.open(blob);
});

$('.grafico_esquerda').on('click', function() {
    var canvas = document.querySelector("#grafico_esquerda");
    var canvas_img = canvas.toDataURL("image/png",1.0); //JPEG will not match background color
    var pdf = new jsPDF('landscape','in', 'letter'); //orientation, units, page size
    pdf.addImage(canvas_img, 'png', .5, 1.75, 10, 5); //image, type, padding left, padding top, width, height
    pdf.autoPrint(); //print window automatically opened with pdf
    var blob = pdf.output("bloburl");
    window.open(blob);
});

$('.chartjs_esquerda_abaixo').on('click', function() {
    var canvas = document.querySelector("#grafico_esquerda_abaixo");
    var canvas_img = canvas.toDataURL("image/png",1.0); //JPEG will not match background color
    var pdf = new jsPDF('landscape','in', 'letter'); //orientation, units, page size
    pdf.addImage(canvas_img, 'png', .5, 1.75, 10, 5); //image, type, padding left, padding top, width, height
    pdf.autoPrint(); //print window automatically opened with pdf
    var blob = pdf.output("bloburl");
    window.open(blob);
});

</script>

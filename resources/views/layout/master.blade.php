<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<style>
  
</style>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Trámites a Distancia - Documentos QR</title>
        
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/poncho.css') }}" rel="stylesheet">
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
        <link rel="shortcut icon" href="{{ asset('/images/favicon.ico') }}">
        <link href="{{ asset('css/estilo.css') }}" rel="stylesheet">
        <link href="{{ asset('css/back-to-top.css') }}" rel="stylesheet">

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </head>

<body>

<header>
  <a name=top-section></a>
  <nav class="navbar navbar-top navbar-default" role="navigation">
    <div class="container">
      <div>
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="badge notificas">.</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
					<div class="navbar-brand">
						<img alt="Logotipo de Trámites a Distancia" src="https://tramitesadistancia.gob.ar/tramitesadistancia/images/tramitesadistancia_logo.svg">
            <h1 class="sr-only">Trámites a Distancia <small>Presidencia de la Nación</small></h1>
          </div>
        </div>
        <div class="collapse navbar-collapse" id="main-navbar-collapse">
         <ul class="nav navbar-nav navbar-right">
            <li><a href="https://tramitesadistancia.gob.ar/tramitesadistancia/inicio-publico">INICIO</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</header>
<div class="container-fluid d-flex flex-column">
<section class="col-md-10 col-md-offset-2" id="titulo">
        
        <h3 data-toggle="tooltip">Consultar documento oficial</h3>
        <p>Obtené información de un documento oficial por su número o código QR</p>
    </section>

    @yield('content')
    
</div>

    

<footer class="main-footer">

  <div class="container  all-footer">
   <div class="row">
   <div class="col-xs-12 col-sm-4  institu">
        <img class="image-responsive para-mobile" id= "footer-logo-mobi" alt="Logotipo de Trámites a Distancia, Presidencia de la Nación" src="https://tramitesadistancia.gob.ar/tramitesadistancia/images/logo_argentina_unida.svg">
        <img class="image-responsive para-desktop" id= "footer-logo-desk" alt="Logotipo de Trámites a Distancia, Presidencia de la Nación" src="https://tramitesadistancia.gob.ar/tramitesadistancia/images/logo_argentina_unida.svg">
    </div>

    <div class=" col-sm-4 footer1">
    <li><a class="subfooter" href="https://tramitesadistancia.gob.ar/terminos-condiciones.html">Términos y condiciones</a></li>
      <li><a class="subfooter" href="https://tramitesadistancia.gob.ar/ayuda.html#6">Contacto</a></li>
      <li><a class="subfooter" href="https://tramitesadistancia.gob.ar/descarga.html">Descarga</a></li>
    </div>

    <div class=" col-sm-4 footer2">
      <li><a class="subfooter" href="https://tramitesadistancia.gob.ar/ayuda.html">Ayuda</a></li>
      <li><a class="subfooter" href="https://tramitesadistancia.gob.ar/ayuda.html#3">Manual de usuario</a></li>
      <li><a class="subfooter" href="https://tramitesadistancia.gob.ar/ayuda.html#5">Preguntas frecuentes</a></li>
    </div>
    </div>
  </div>

  <a id="go-to-top" class= "top" href="#top-section"></a>

</footer>


    @yield('js')
</body>
</html>

@extends('layout.master')
@section('content')

<div class="container-fluid d-flex flex-column">

   <section class="col-md-8 col-md-offset-2" id="titulo">
        
        <h3 data-toggle="tooltip">Consultar documento oficial</h3>
        <p>Obtené información de un documento oficial por su número o código QR</p>
    </section>


    <section class="col-md-8 col-md-offset-2 text-center">
        <p>
          <span style="font-size: 60px;" class="glyphicon glyphicon-remove text-danger"></span>
        </p>
        <h6>No se puede continuar</h6>
        <h6>Consulta no autorizada</h6>
    </section>



      <section class="col-md-8 col-md-offset-2 text-center" id="botones">
        <a href="/">
            <button type="button" role="link" class="btn btn-sm btn-secondary">
            <span class="glyphicon glyphicon-refresh"></span>
            Consultar otro</button>
        </a>
      </section>
  
</div>

@stop
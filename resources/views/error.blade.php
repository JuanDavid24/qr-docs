@extends('layout.master')
@section('content')
    <section class="col-md-8 col-md-offset-2 text-center">
        <p>
          <span style="font-size: 60px;" class="glyphicon glyphicon-remove text-danger"></span>
        </p>
        <h6>No se puede realizar la consulta en este momento. Por favor, intente nuevamente más tarde</h6>
    </section>



      <section class="col-md-8 col-md-offset-2 text-center" id="botones">
         <a href="#">
        <button type="button" role="button" class="btn btn-sm btn-secondary" onclick="javascript:window.history.back();return false;">
            <span class="glyphicon glyphicon-backward"></span>
            Volver</button>
          </a>
          
        <a href="/">
            <button type="button" role="link" class="btn btn-sm btn-secondary">
            <span class="glyphicon glyphicon-refresh"></span>
            Consultar otro</button>
        </a>
      </section>
  
@stop
@extends('layout.master')
@section('content')

<div class="container-fluid d-flex flex-column">

    <section class="col-md-12 center" id="buscador">
        
        <h6>{!! $response["numeroDocumento"] !!} <span class="glyphicon glyphicon-remove text-danger"></span></h6>
        <center>
        <p>
            <span class="text-danger">No se encuentra el documento</span>
            </p>
        <a href="/">
            <button role="button" class="btn btn-sm btn-primary">
            <span class="glyphicon glyphicon-refresh"></span>
            Consultar otro </button>
        </a>              
        </center>
    </section>

</div>

@stop
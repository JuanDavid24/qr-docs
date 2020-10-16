@extends('layout.master')
@section('content')


@if(!$gedo['existe'])
    <section class="col-md-8 col-md-offset-2 text-center">
        <p>
          <span style="font-size: 60px;" class="glyphicon glyphicon-remove text-danger"></span>
        </p>
        <h6>{{ $gedo['nroDocumento'] }}</h6>
        <h6>No se ha encontrado un documento oficial con el número ingresado</h6>
    </section>


@else
  @if($gedo['reservado'])
  <section class="col-md-8 col-md-offset-2 center text-center">
        <p>
          <span style="font-size: 60px;" class="glyphicon glyphicon-ok text-success"></span>
        </p>
        <h6>{{ $gedo['nroDocumento'] }}</h6>
        <h6>El documento oficial consultado fue emitido por el sistema de Gestión Documental Electrónica y es de carácter reservado</h6>
    </section>
  @else
    <section class="col-md-8 col-md-offset-2 center text-center">
        <p>
          <span style="font-size: 60px;" class="glyphicon glyphicon-ok text-success"></span>
        </p>
        <h6>{{ $gedo['nroDocumento'] }}</h6>
        <h6>El documento oficial consultado fue emitido por el sistema de Gestión Documental Electrónica</h6>
    </section>

    <section class="col-md-8 col-md-offset-2 p-0" id="metadata" style="padding: 0">
        
        <div class="card ">
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <div class="list-group-item-fixed">
                <strong class="list-group-left">Número GDE:</strong>
                <span class="list-group-right">{{ $detalle['content']['numeroGde'] ?? '' }}</span>
              </div>
            </li>
            @if($detalle['content']['numeroEspecial'])
            <li class="list-group-item">
              <div class="list-group-item-fixed">
                <strong class="list-group-left">Número Especial:</strong>
                <span class="list-group-right">{{ $detalle['content']['numeroEspecial'] ?? '' }}</span>
              </div>
            </li>
            @endif

            <li class="list-group-item">
              <div class="list-group-item-fixed">
                <strong class="list-group-left">Tipo de Documento:</strong>
                <span class="list-group-right">{{ $detalle['content']['tipoDocumento'] ?? '' }}</span>
              </div>
            </li>

        <li class="list-group-item">
              <div class="list-group-item-fixed">
                <strong class="list-group-left">Fecha de creación:</strong>
                <span class="list-group-right">{{ \Carbon\Carbon::createFromTimestamp($detalle['content']['fechaCreacion'])->format('d/m/Y h:i:s')  ?? '' }}</span>
              </div>
            </li>

        <li class="list-group-item">
              <div class="list-group-item-fixed">
                <strong class="list-group-left">Firmantes:</strong>
                <span class="list-group-right">{{ implode(', ',$detalle['content']['listaFirmantes'] ?? []) }}</span>
              </div>
            </li>

        

          </ul>
        </div>
      </section>
  @endif
@endif


          
@if( $gedo['qr'] && !$gedo['qrPublico'])
<form action="{{ route('verPdf') }}" method="POST">
            @csrf
            <input type="hidden" name="nroDocumento" value="{{ $detalle['content']['numeroGde'] ?? '' }}">
    <div class="col-md-8 col-md-offset-2">
  <div class="form-group row">
      <p><strong >Este documento requiere un código verificador para ser visualizado</strong></p>
      <p><span class="text-muted">Puede encontrarlo junto al código QR en el documento</span>
    </div>
  </div>
  <div class="col-md-8 col-md-offset-2">
  <div class="form-group row">
    <div class="col-sm-9">
    <label for="inputPassword" class="col-sm-3 col-form-label">Ingresar el código:</label>
      <input type="text" class="form-control " id="codigoVerificador" minlength="7" maxlength="7" name="codigoVerificador" placeholder="Abc4567" required="">
    </div>
  </div>
</div>
</form>
@endif
      <section class="col-md-8 col-md-offset-2 text-center" id="botones">


        <a href="#">
        <button type="button" role="button" class="btn btn-md btn-secondary" onclick="javascript:window.history.back();return false;">
            <span class="glyphicon glyphicon-backward"></span>
            Volver</button>
          </a>

        <a href="/">
            <button type="button" role="link" class="btn btn-md btn-secondary">
            <span class="glyphicon glyphicon-refresh"></span>
            Consultar otros</button>
        </a>
@if( $gedo['qr'])
<form action="{{ route('verPdf') }}" method="POST">
            @csrf
            <input type="hidden" name="nroDocumento" value="{{ $detalle['content']['numeroGde'] ?? '' }}">
            <button type="submit" role="button" class="btn btn-md btn-primary" >
            <span class="glyphicon glyphicon-eye-open"></span>
            Visualizar documento</button>

            </form>
@endif             
    </section>
         


@stop
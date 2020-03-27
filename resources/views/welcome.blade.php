@extends('layout.master')
@section('content')
<style type="text/css">
#qr {
    width: 300px;
    height: 225px;
    border: 1px solid silver
}


</style>
<div class="container-fluid text-center">
                    <h1>Comprobar documento</h1>

                        <div class="form-group row block-center">

                            <div class="col-12 ">
                                
                            <div id="qr" class="m-1" style="display: inline-block;">
                                <span class="text-center text-muted">Click para escanear</span>
                            </div>
                            <select class="form-control center" id="cameraSelection"></select>

                            <div class="m-2">
                                <button id="scanButton" class="btn btn-primary btn-sm">Escanear QR</button>&nbsp;
                                <button id="stopButton" class="btn btn-secondary btn-sm" disabled="">Detener</button>

                                <p><span id="feedback"></span></p>
                                <br>
                                    
                                <form action="#" id="qr_form">
                                <input type="text" class="form-control center" name="qr_url" id="qr_url">
                                </form>
                                <div>
                                    
                                <button role="button" id="goButton" class="btn m-1 btn-primary btn-sm" disabled="">Acceder</button>
                                </div>
                            </div>

                            </div>
                      </div>

                    
    </div>

@stop


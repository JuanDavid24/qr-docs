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
                    <h1>Escanear Código QR</h1>

                        <div class="form-group row block-center">

                            <div class="col-4 "></div>
                            <div class="col-4 ">
                                
                            <div id="qr" class="m-1" style="display: inline-block;">
                                <span class="text-center text-muted">Click para escanear</span>
                            </div>
                            <select class="form-control center" id="cameraSelection"></select>

                            <div class="m-2">
                                <button id="scanButton" class="btn btn-success btn-sm">Escanear QR</button>&nbsp;
                                <button id="stopButton" class="btn btn-warning btn-sm" disabled="">Detener</button>

                                <span id="feedback" style="margin: 10px; display: inline-block"></span>
                            </div>

                            </div>
                            <div class="col-4 "></div>
                      </div>

                    <!-- <h3>O ingresar la URL</h3>
                   <div class="row block-center">
                   </div>

                    <form action="#" >

                        <div class="form-group row block-center">

                            <div class="col-4 "></div>
                            <div class="col-4 ">
                                <input type="url" class="form-control center" id="qr_url" placeholder="Url del documento">
                            </div>
                            <div class="col-4 "></div>
                      </div>


                    </form>-->
    </div>

@stop


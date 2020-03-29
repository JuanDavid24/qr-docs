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
    <h3>Comprobar documento</h3>

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
@section('js')
    <script src="{{ asset('js/jsqrcode-combined.js') }}"></script>
    <script src="{{ asset('js/html5-qrcode.js') }}"></script>


<script type="text/javascript">

    $(document).ready(function() {
      $('#goButton').click(function(e) {
        window.location.href = $('#qr_url').val();
    });

    var onQRCodeFoundCallback = function (qrCodeMessage) {
        // usar url
        $("#qr").html5_qrcode_stop();
        $("#qr_url").val(qrCodeMessage);
        $("#feedback").html("Datos encontrados");
        $("#goButton").prop("disabled", false);
        if(qrCodeMessage.includes('{{ $_SERVER['HTTP_HOST'] }}')) {
            window.location.href = qrCodeMessage;
        }

    }
    var onQRCodeNotFoundCallback = function (error) {
        //$("#feedback").html('Qr Inválido! Error: ' + error);
    }
    var onVideoErrorCallback = function (videoError) {
        $("#feedback").html('Error en video : ' + videoError);
    }
    var onCamerasEnumerated = function (cameras) {
        // Cameras found.
        $("#logging").html("Cámaras: " +cameras.length);
        if (cameras.length == 0) {
            $("#feedback").html("Error: No hay cámaras habilitadas");
            return;
        }
        for (i = 0; i < cameras.length; i++) {
            var camera = cameras[i];
            var value = camera.id;
            var name = camera.label == null ? value : camera.label;
            $("#cameraSelection").append("<option value='" + value+ "'>" + name + "</option>");
        }
        $("#cameraSelection").prop("disabled", false);
        $("#cameraSelection").on("change", function () {
        });
        $("#scanButton").prop("disabled", false);

        $("#scanButton,#qr").on('click', function() {
            var cameraId = $("#cameraSelection").val();
            $("#goButton").prop("disabled", true);
            $("#feedback").html("Leyendo...");
            $("#cameraSelection").prop("disabled", true);
            $("#scanButton").prop("disabled", true);
            $("#stopButton").prop("disabled", false);
            $("#status").html('scanning');
            $('#qr').html5_qrcode(
                cameraId,
                onQRCodeFoundCallback,
                onQRCodeNotFoundCallback,
                onVideoErrorCallback,
                { fps : 5 }
            );
        });
        $("#stopButton").on('click', function() {
            $("#qr").html5_qrcode_stop();
            $("#cameraSelection").prop("disabled", false);
            $("#scanButton").prop("disabled", false);
            $("#stopButton").prop("disabled", true);
            $("#feedback").html("");
        });
    }
    var onCameraEnumerationFailed = function (errorMessage) {
        $("#feedback").html("Error: no hay cámaras: " +errorMessage);
    }
    $(document).html5_qrcode_getSupportedCameras(
        onCamerasEnumerated, onCameraEnumerationFailed);
});
</script>
@stop


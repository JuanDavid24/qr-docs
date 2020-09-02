@extends('layout.master')
@section('content')

<div class="container-fluid">
    <h3>Consultar documento oficial</h3>
    <p>Obtené información de un documento oficial escaneando su código QR</p>
    <p><strong>Escáner de código QR</strong></p>

    <div class="form-group block-center">   
        <div class="col-12 ">    
            <div id="qr-block">
                <div id="qr" class="m-1">
                    <span class="text-center text-muted">Click para escanear</span>
                </div><br>
                
                <button id="scanButton" class="btn btn-primary btn-sm">Escanear código QR</button>                     
                <span class="buttonGroup" id="buttonGroupScanning">
                    <button id="stopButton" class="btn btn-secondary btn-sm">Detener</button>
                    <button id="switchButton" class="btn btn-secondary btn-sm">Cambiar cámara</button>
                </span> 
                <!--resultado qr/!-->      
                <p><span id="feedback"></span></p> 
            </div>

            <div class="m-2">                
            <div>      
                <form action="#" id="qr_form">
                    <input type="text" class="form-control center disabled" name="qr_url" id="qr_url">
                </form>    
                <button role="button" id="goButton" class="btn m-1 btn-primary btn-sm" disabled="">Acceder</button>  
            </div>
        </div>
        </div>
      </div>

      <div class="form-group block-center" id="verification_block">
          <p><strong>Ingresar código de verificación</strong></p>
          <span>Para descargar el documento, ingresar el código de verificación de 7 dígitos que se encuentra debajo del código QR</span>
          <input type="textarea" class="form-control center" name="verif_code" id="verif_code">
          <span id= verif_feedback></span>          
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
        
    }
    var onQRCodeNotFoundCallback = function (error) {
        //$("#feedback").html('Qr Inválido! Error: ' + error);
    }
    var onVideoErrorCallback = function (videoError) {
        $("#feedback").html('Error en video : ' + videoError);
    }

    //iterar array de camaras
    var currentCameraIndex;
    var loopCameraIndex = function (cameras, currentCameraIndex) {    
        if (currentCameraIndex == cameras.length-1){  //llego al final del array
            currentCameraIndex = 0;          
        } else{
            currentCameraIndex = currentCameraIndex + 1; 
        }   
        return(currentCameraIndex);
    }

    var onCamerasEnumerated = function (cameras, currentCameraIndex) {
        // Cameras found.
        $("#logging").html("Cámaras: " +cameras.length);
        if (cameras.length == 0) {
            $("#feedback").html("Error: No hay cámaras habilitadas");
            return;
        }
        $("#scanButton").prop("disabled", false);      
        $("#scanButton,#qr").on('click', function() {
            var cameraId = cameras[0].id;
            currentCameraIndex = 0;
            $("#feedback").html("Leyendo...");
            $("#scanButton").hide();
            $("#stopButton").show();
            $("#switchButton").show();
            $("#buttonGroupScanning").show();
            $("#status").html('scanning');
            set_camera(cameraId, onQRCodeFoundCallback, onQRCodeNotFoundCallback, onVideoErrorCallback);
            /*$('#qr').html5_qrcode(
                cameraId,
                onQRCodeFoundCallback,
                onQRCodeNotFoundCallback,
                onVideoErrorCallback,
                { fps : 5 }
            );*/
        });
        $("#stopButton").on('click', function() {
            $("#qr").html5_qrcode_stop();
            $("#scanButton").show();
            $("#stopButton").hide();
            $("#switchButton").hide();
            $("#feedback").html("");
            $('#cameraIndex').append(currentCameraIndex);           
        });
        $('#switchButton').on('click', function() {
            currentCameraIndex = loopCameraIndex(cameras, currentCameraIndex);
            cameraId = cameras [currentCameraIndex].id;
            $('#cameraIndex').append(currentCameraIndex);            
            set_camera(cameraId, onQRCodeFoundCallback, onQRCodeNotFoundCallback, onVideoErrorCallback);
        });
    }
    var set_camera = function (cameraId, onQRCodeFoundCallback, onQRCodeNotFoundCallback, onVideoErrorCallback){
        $('#qr').html5_qrcode(
                cameraId,
                onQRCodeFoundCallback,
                onQRCodeNotFoundCallback,
                onVideoErrorCallback,
                { fps : 5 }
                );
    }
    var onCameraEnumerationFailed = function (errorMessage) {
        $("#feedback").html("Error: no hay cámaras: " +errorMessage);
    }
    $(document).html5_qrcode_getSupportedCameras(
        onCamerasEnumerated, onCameraEnumerationFailed);
});
</script>
@stop


@extends('layout.master')
@section('content')


<section class="col-md-8 col-md-offset-2 text-center" style="margin-top: 0px; padding-top: 0px">
    <span class="text-muted">Ingrese el número de documento</span>
</section>
<section class="col-md-8 col-md-offset-2" id="buscador2" style="margin-top: 0px; padding-top: 0px;">

    <form id="frm_gedo" class="buscamos ng-pristine ng-valid ng-touched" action="{{ route('consulta') }}" method="POST">
        @csrf
<div class="row form-wrapper form-group input-group input-group-lg input-group-shadow form-item form-item-keys form-type-textfield">    
            
            <div class="col-sm-3 m-0" style="margin:0px;padding:0px">
                <label for="actuacion">Actuación</label>
                <select tabindex="1" class="form-control  tt-select form-control-md"  id="actuacion" name="actuacion" required="">
                        <option value="">Actuación</option>
                      @foreach (['AA','AB','AC','ACR','ACTA','ACTO','AD','ANLE','AP','AT','CA','CC','CD','CE','CF','CG','CM','CONV','COPD','CP','CR','CS','DCTO','DECA','DECR','DI','DIRE','DOCF','DOCP','EXDI','IF','IFMU','INLE','LAUD','MAPA','ME','NO','OD','OF','OFJU','OG'] as $actuacion)
                        <option value="{{ $actuacion }}" {{ ($docParam['actuacion'] == $actuacion ? 'SELECTED' : '')}}>{{ $actuacion }}</option>
                        @endforeach

                </select>
            </div>
            <div class="col-sm-2 m-0" style="margin:0px;padding:0px">
                <label for="anio">Año</label>
                <select tabindex="2" class=" form-control  tt-select form-control-md" id="anio"  name="anio" placeholder="2020" required="">
                        <option value="{{ date("Y") }}">{{ date("Y") }}</option>
                    @foreach (range(date("Y")-1,2011) as $anio)
                        <option value="{{ $anio }}" {{ ($docParam['anio'] == $anio ? 'SELECTED' : '')}}>{{ $anio }}</option>
                    @endforeach
                </select>
            </div>
        <div class="col-sm-3" style="margin:0px;padding:0px">
                <label for="numero">Número</label>

                <input tabindex="3" type="number" class="input-md form-control tt-input" id="numero" name="numero" min="1" max="999999999" maxlength="9" step="1" placeholder="123456789" spellcheck="false"  value="{{ $docParam['numero'] ?? '' }}" required="" size="10" autocomplete="true" />
</div>
            <div class="col-sm-2" style="margin:0px;padding:0px">
            <label for="ecosistema">Ecosistema</label>            
                <select tabindex="4" class=" form-control  tt-select form-control-md" id="ecosistema" name="ecosistema" placeholder="APN" required="">
                        <option value="APN">APN</option>
                    @foreach( ['INSSJP','ANSES'] as $ecosistema)
                        <option value="{{ $ecosistema }}" {{ ($docParam['ecosistema']==$ecosistema) ? 'SELECTED' : '' }}>{{ $ecosistema }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-sm-2" style="margin:0px;padding:0px">
                <label for="reparticion">Repartición</label> 
                <input tabindex="5" type="text" class="input-md form-control tt-input" style=" text-transform: uppercase;" id="reparticion" name="reparticion" placeholder="DN#JGM" spellcheck="false" value="{{ $docParam['reparticion'] ?? '' }}" required="" size="200" />
            </div>

           

</div>

<div class="clearfix">&nbsp;</div>
        <div class="text-center">
            <p><span class="text-small" id="feedback">&nbsp;</span></p>
            <button tabindex="7" class="btn btn-md btn-secondary" id="pegar-tab" type="button"><span class="glyphicon glyphicon-paste"></span> Pegar</button>
            <button tabindex="8" class="btn btn-md btn-secondary" id="bt_scanner" type="button"><span class="glyphicon glyphicon-qrcode"></span> Escanear QR</button>
            <button tabindex="9" class="btn btn-md btn-secondary" id="completar-tab" type="button"><span class="glyphicon glyphicon-trash"></span> Limpiar</button>
            <button tabindex="6" class="btn btn-primary btn-md form-submit" id="edit-submit" name="buscar" type="submit"><span class="glyphicon glyphicon-search"></span> Buscar</button>
        </div>
        
        </form>
</section>

<section  class="col-md-8 col-md-offset-2 d-flex">
    <div id="scanner" class="col-md-6">
        <div id="qr" class="" style="background-color: #EEEEEE;">
        </div>
        
        <button id="scanButton" class="btn btn-primary btn-sm hide">Escanear código QR</button>
        
        <span class="buttonGroup" id="buttonGroupScanning">
            <button id="stopButton" class="btn btn-secondary btn-sm">Detener</button>
            <button id="switchButton" class="btn btn-secondary btn-sm">Cambiar cámara</button>
        </span>
    </div>

    <div class="col-md-6">
      <div>
          <h6><strong>¿Dónde encuentro el Número del Documento?</strong></h6>
          <p><span class="text-muted">Podrás encontrar el <strong>Número</strong> a la derecha del encabezado</span></p>
        <img src="{{ asset('images/nro-ubicacion.jpg') }}" alt="Ubicación del número de documento">
      </div>

      

    </div>


    <div class="col-md-6">
      <div>
        <p>&nbsp;</p>
          <h6><strong>¿Dónde encuentro el código QR?</strong></h6>
          <span class="text-muted">Podrás encontrar el <strong>código QR</strong> en la esquina inferior derecha del documento</span>
        <img src="{{ asset('images/qr-ubicacion.jpg') }}" alt="Ubicación del QR en el documento">
      </div>

      
    </div>

</section>

@stop
@section('js')
    <script src="{{ asset('js/jsqrcode-combined.js') }}"></script>
    <script src="{{ asset('js/html5-qrcode.js') }}"></script>


<script type="text/javascript">

    $(document).ready(function() {


$('#completar-tab').click(function() {
    setFeedback('&nbsp;');
    buscadorClear();
});

function buscadorClear() {
    $("#actuacion option").filter(function() { return $(this).val() == ""; }).attr('selected', true);
    $("#anio option").filter(function() { return $(this).text() == ''; }).attr('selected', true);
    $("#numero").val('');
    $("#ecosistema option").filter(function() { return $(this).text() == ''; }).attr('selected', true);
    $("#reparticion").val('');
}

function setFeedback(txt) {
    $("#feedback").html(txt);
}

    
$('#pegar-tab').click(function() {
    setFeedback('');
    buscadorClear();
    var pasteDoc = navigator.clipboard.readText().then(function(data) {
        if(!data) {
            setFeedback('No hay un Número de Documento válido en su portapapeles');
            return false;
        }
        partes = data.split('-');
        if(partes.length!=5) {
            setFeedback('No hay un Número de Documento válido en su portapapeles');
            return false;
        }

        // actuacion
        $("#actuacion option").filter(function() { return true; }).attr('selected', false);
        setActuacion = $("#actuacion option").filter(function() {
          return $(this).text() == partes[0];
        }).attr('selected', true);
        console.log("Seleccionado: ", setActuacion.length);
        if(setActuacion.length !=1) {
            setFeedback('Número de Documento inválido: actuación incorrecta');
            return false;
        }

        // anio
        $("#anio option").filter(function() { return true; }).attr('selected', false);
        setAnio = $("#anio option").filter(function() {
          return $(this).text() == partes[1];
        }).attr('selected', true);
        if(setAnio.length !=1) {
            setFeedback('Número de Documento inválido: año incorrecto');
            return false;
        }
        // numero
        numero = parseInt(partes[2]);
        if( !numero || numero > 999999999) {
            setFeedback('Documento inválido: número incorrecto');
            return false;
        }
        $("#numero").val(numero);

        // ecosistema
        $("#ecosistema option").filter(function() { return true; }).attr('selected', false);
        setEco = $("#ecosistema option").filter(function() {
          return $(this).text() == partes[3];
        }).attr('selected', true);
        if(setEco.length !=1) {
            setFeedback('Número de Documento inválido: sólo se admiten ecosistemas APN, INSSJP y ANSES');
            return false;
        }
        // reparticion
        setRep = $("#reparticion").val(partes[4]);

        setFeedback('&nbsp;');

        
        });

});
    function scannerOn() {
        setFeedback('');
        buscadorClear();
        $("#scanner").show();
        $("#scanButton").click();
    }

    $('#frm_gedo').submit(function(event) {
        actuacion = $('#actuacion').val();
        anio = $('#anio').val();
        numero = $('#numero').val();
        ecosistema = $('#ecosistema').val();
        reparticion = $('#reparticion').val();
        documento = actuacion + '-' + anio + '-' + numero + '-' + ecosistema + '-' + reparticion;
    });

        $('#bt_scanner').click(function(e) {
            //console.log('Activo QR Scanner');
            scannerOn();
        });

    

    var onQRCodeFoundCallback = function (qrCodeMessage) {
        // usar url
        $("#qr").html5_qrcode_stop();
        const url = new URL(qrCodeMessage);
        // 1. extraemos nombre doc
        // @todo: evaluar bas64 con caracter /
        var parametros = url.pathname.split("/");
        visibilidad = parametros[parametros.length-1];
        documento = parametros[parametros.length-2];

        $("#feedback").html("Nombre de documento encontrado");
        if(atob(documento)) {
            $("#feedback").html("Formato correcto");
            window.location.href = url.pathname;
        } else {
            $("#feedback").html("QR incorrecto o no corresponde a un Documento Oficial");
            return false;
        }
        window.location.href = url.pathname;
    }
    var onQRCodeNotFoundCallback = function (error) {
        //$("#feedback").html($("#feedback").html() + '.');
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
            $("#feedback").html("Su dispositivo no tiene cámaras para leer códigos QR");
            $('#btn-scanner').attr('disabled',true);
            $('#scanner').hide();
            return;
        }
        $("#scanButton").prop("disabled", false);      
        $("#scanButton,#qr").on('click', function() {
            var cameraId = cameras[0].id;
            currentCameraIndex = 0;
            $("#feedback").html('Buscando QR...');
            $("#scanButton").hide();
            $("#stopButton").show();
            $("#switchButton").show();
            $("#buttonGroupScanning").show();
            $("#status").html('scanning');
            set_camera(cameraId, onQRCodeFoundCallback, onQRCodeNotFoundCallback, onVideoErrorCallback);
        });
        $("#stopButton").on('click', function() {
            $("#qr").html5_qrcode_stop();
            $("#scanButton").show();
            $("#stopButton").hide();
            $("#switchButton").hide();
            $("#feedback").html("&nbsp;");
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


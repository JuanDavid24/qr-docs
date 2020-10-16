@extends('layout.master')
@section('content')


@if( $response['status'] == 401)
    <section class="col-md-8 col-md-offset-2 center text-center">
       <section class="col-md-8 col-md-offset-2" id="titulo">
        
        <h3 data-toggle="tooltip">Consultar documento oficial</h3>
        <p>Obtené información de un documento oficial por su número o código QR</p>
    </section>


        <p>
          <span style="font-size: 60px;" class="glyphicon glyphicon-remove text-danger"></span>
        </p>
        <h6>El código de verificación indicado es incorrecto</h6>

            <button role="button" class="btn btn-md btn-primary" onclick="window.history.back()">
            <span class="glyphicon glyphicon-backward"></span>
            Volver
          </button>
          
          <a href="/">
            <button role="button" class="btn btn-md btn-primary">
            <span class="glyphicon glyphicon-refresh"></span>
            Consultar otro documento</button>
        </a>
        
    </section>

@else
  
    <section class="col-md-12 text-center" id="buscador">
        
        <h6>{!! $response["numeroDocumento"] !!} <span class="glyphicon glyphicon-ok text-success"></span></h6>
        <center>
            

        <a href="/">
            <button role="button" class="btn btn-md btn-primary">
            <span class="glyphicon glyphicon-refresh"></span>
            Consultar otro documento</button>
        </a> 

        <a href="#" id="descargar">
            <button role="button" class="btn btn-md btn-primary" onclick="downloadPDF()">
            <span class="glyphicon glyphicon-download"></span>
            Descargar</button>
        </a>
        </center>
    </section>


<center>
<div id="pdfCanvas" ></div>
</center>


<script src="{{ asset('/js/pdfjs/build/pdf.js') }}"></script>


<script id="script">

  /**
 * Creates an anchor element `<a></a>` with
 * the base64 pdf source and a filename with the
 * HTML5 `download` attribute then clicks on it.
 * @param  {string} pdf 
 * @return {void}     
 */



  var pdfData = atob('{!! $response["content"] !!}');
  pdfjsLib.GlobalWorkerOptions.workerSrc = '{{ asset("/js/pdfjs/build/pdf.worker.js") }}';
  var loadingTask = pdfjsLib.getDocument({ data: pdfData, });

  var currPage = 1; //Pages are 1-based not 0-based
  var numPages = 0;
  var thePDF = null;


  loadingTask.promise.then(function(pdf) {

        thePDF = pdf;
        numPages = pdf.numPages;
        pdf.getPage(1).then( handlePages );

    function handlePages(page) {
      var scale = 1.2;
      var viewport = page.getViewport({ scale: scale, });
      var canvas = document.createElement( "canvas" );
      canvas.style.display = "block";

      var context = canvas.getContext('2d');
      canvas.height = viewport.height;
      canvas.width = viewport.width;
      var renderContext = {
        canvasContext: context,
        viewport: viewport,
      };
      page.render(renderContext);
      // document.body.appendChild( canvas )
      document.getElementById('pdfCanvas').appendChild( canvas )

    currPage++;
    if ( thePDF !== null && currPage <= numPages ) {
        thePDF.getPage( currPage ).then( handlePages );
      }
    }
  });


  function downloadPDF() {
    const linkSource = 'data:application/pdf;base64,'+btoa(pdfData);
    const downloadLink = document.createElement("a");
    const fileName = "{!! $response["numeroDocumento"] !!}.pdf";

    downloadLink.href = linkSource;
    downloadLink.download = fileName;
    downloadLink.click();
}


</script>  
</center>
@endif



@stop
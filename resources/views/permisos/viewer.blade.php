@extends('layout.master')
@section('content')

<div class="container-fluid d-flex flex-column">

@if($response["code"] == 500)

<section class="col-md-12 center" id="buscador">
        
        <h6><span class="glyphicon glyphicon-ok text-success"></span></h6>
        <center>
            
        <a href="/">
            <button role="button" class="btn btn-sm btn-primary">
            <span class="glyphicon glyphicon-refresh"></span>
            Consultar otro documento</button>
        </a>              
        </center>
    </section>

@endif
    <section class="col-md-12 center" id="buscador">
        
        <h6>{!! $response["numeroDocumento"] !!} <span class="glyphicon glyphicon-ok text-success"></span></h6>
        <center>
            
        <a href="/">
            <button role="button" class="btn btn-sm btn-primary">
            <span class="glyphicon glyphicon-refresh"></span>
            Consultar otro documento</button>
        </a>              
        </center>
    </section>

</div>

<center>
<div id="pdfCanvas" ></div>
</center>


<script src="{{ asset('/js/pdfjs/build/pdf.js') }}"></script>

<script id="script">
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
</script>  
</center>



@stop
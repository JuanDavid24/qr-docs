@extends('layout.master')
@section('content')

<style type="text/css">
  canvas {
  background-color: white; 
  width: 100%;
  height: auto;
}

</style>
            <div class="text-center m-1">
          <a href="/"><button class="btn btn-primary">Volver</button></a>
              </div>
            <center>
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
      var scale = 1.5;
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
      document.body.appendChild( canvas )

    currPage++;
    if ( thePDF !== null && currPage <= numPages ) {
        thePDF.getPage( currPage ).then( handlePages );
      }
    }
  });
</script>  
</center>


@stop

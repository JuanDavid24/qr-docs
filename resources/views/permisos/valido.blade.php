@extends('layout.master')
@section('content')

<div class="flex-center position-ref full-height">


            <div class="text-center m-1">
          <a href="/">
                    <button class="btn btn-primary">Volver</button>
                </a>
              </div>
            <embed src="data:application/pdf;base64,{!! $response['content'] !!}" width="100%" height="800px" type="application/pdf">
              

        </div>

@stop

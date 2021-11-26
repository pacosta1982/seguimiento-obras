@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.visit.actions.sync'))

@section('body')

<div class="card">
    <div class="card-header text-center">
         PROYECTO - {{ $project->SEOBProy }}
    </div>

    <div class="card-body">

       <div class="container">

  <h2 class="fw-light text-center text-lg-start mb-0">Imagenes de la Visita</h2>

  <hr class="mt-2 mb-5">

  <div class="row text-center text-lg-start">

    @foreach ($imagenes->take(10) as $item)

        <a href="{{ url('download/'.basename($item['imagen'],'.jpg').PHP_EOL) }}"><img class="img-fluid img-thumbnail" src="{{ $item['imagen'] }}" alt=""></a>

    @endforeach

  </div>

</div>

    </div>
  </div>





@endsection

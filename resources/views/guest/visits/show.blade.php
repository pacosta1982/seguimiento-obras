@extends('brackets/admin-ui::admin.layout.usersys')

@section('title', trans('admin.guest.projects'))

@section('body')

<div class="card">
    <div class="card-header text-center">
         DATOS DEL LA VISITA
         <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url()->previous() }}" role="button"><i class="fa fa-undo"></i>&nbsp; {{ trans('admin.guest.actions.back') }}</a>

    </div>

    <div class="card-body">
        <div class="row">
            <div class="form-group col-sm-4">
                <p class="card-text"><strong>PROYECTO:</strong>  {{ $project->SEOBProy }}  </p>
            </div>
            <div class="form-group col-sm-4">
                <p class="card-text"><strong>DEPARTAMENTO:</strong> {{ $project->departamento->DptoNom }}  </p>
            </div>
            <div class="form-group col-sm-4">
                <p class="card-text"><strong>DISTRITO:</strong> {{ $project->distrito->CiuNom }}</p>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-4">
                <p class="card-text"><strong>VISITA N°:</strong> {{ $visit->visit_number }}  </p>
            </div>
            <div class="form-group col-sm-4">
                <p class="card-text"><strong>FECHA:</strong> {{ $visit->visit_date }}  </p>
            </div>
            <div class="form-group col-sm-4">
                <p class="card-text"><strong>AVANCE:</strong> {{ $visit->advance }} %</p>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-12">
                <slide :datos="{{ json_encode($datos) }}" />
            </div>
        </div>
    </div>
</div>

<!--<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="form-group col-sm-12">
                <slide :datos="{{ json_encode($datos) }}" />
            </div>
        </div>
    </div>
</div>-->



@endsection

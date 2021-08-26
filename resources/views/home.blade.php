@extends('brackets/admin-ui::admin.layout.usersys')

@section('title', trans('admin.guest.home'))

@section('body')

<div class="card   text-center">
    <div class="card-header">
        <h2>Bienvenido  </h2>
        <h6>Seleccione una de las siguientes opciones para continuar</h6>
    </div>
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-6 col-sm-4 col-md-2 col-xl mb-3 mb-xl-0">
                <a href="/projects" type="button" class="btn btn-square btn-primary btn-lg btn-block">{{ trans('admin.guest.projects') }}</a>
            </div>
            <div class="col-6 col-sm-4 col-md-2 col-xl mb-3 mb-xl-0">
                <a href="/files" type="button" class="btn btn-square btn-warning btn-lg btn-block">{{ trans('admin.guest.files') }}</a>
            </div>

            <div class="col-6 col-sm-4 col-md-2 col-xl mb-3 mb-xl-0">
                <a href="/applicants" type="button" class="btn btn-square btn-success btn-lg btn-block">{{ trans('admin.guest.applicants') }}</a>
            </div>

            <div class="col-6 col-sm-4 col-md-2 col-xl mb-3 mb-xl-0">
                <a href="/beneficiaries" type="button" class="btn btn-square btn-danger btn-lg btn-block">{{ trans('admin.guest.beneficiaries') }}</a>
            </div>
        </div>

    </div>


    </div>



@endsection

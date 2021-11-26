@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.visit.actions.sync'))

@section('body')

<div class="card">
    <div class="card-header text-center">
         DATOS DEL PROYECTO
    </div>

    <div class="card-body">
        <div class="row">
            <div class="form-group col-sm-4">
                <p class="card-text"><strong>PROYECTO:</strong>  {{ $project->SEOBProy }}</p>
            </div>
            <div class="form-group col-sm-4">
                <p class="card-text"><strong>SAT:</strong> {{ $project->SEOBEmpr }}</p>
            </div>
            <div class="form-group col-sm-4">
                <p class="card-text"><strong>AVANCE:</strong> {{ $project->advance ? $project->advance->advance : '0' }} %</p>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-4">
                <p class="card-text"><strong>DEPARTAMENTO:</strong> {{ $project->departamento->DptoNom }}</p>
            </div>
            <div class="form-group col-sm-4">
                <p class="card-text"><strong>CIUDAD:</strong> {{ $project->distrito->CiuNom }}</p>
            </div>
            <div class="form-group col-sm-4">
                <p class="card-text"><strong>SUPERVISOR:</strong> {{ $project->SEOBSuper }}</p>
            </div>
        </div>
    </div>
  </div>


<div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.guest.actions.syncstp') }}
                    </div>
                    <div class="card-body" v-cloak>
                        <!--<div class="card-block">-->
                            <table class="table table-sm table-hover table-borderless">
                                <thead>
                                    <tr>
                                    <th class="text-center"># Relevamiento</th>
                                    <th class="text-center">{{ trans('admin.visit.columns.visit_number') }}</th>
                                    <th class="text-center">{{ trans('admin.visit.columns.advance') }}</th>
                                    <th class="text-center">{{ trans('admin.visit.columns.visit_date') }}</th>
                                    <th class="text-center">{{ trans('admin.visit.columns.latitude') }}</th>
                                    <th class="text-center">{{ trans('admin.visit.columns.longitude') }}</th>
                                    <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key=>$item)
                                    <tr>
                                    <td class="text-center">{{$key}}</td>
                                    <td class="text-center">{{$item['2720']}}</td>
                                    <td class="text-center">{{$item['2719']}} % </td>
                                    <td class="text-center">{{$item['2718']}}</td>
                                    <td class="text-center">{{$item['latitud']}}</td>
                                    <td class="text-center">{{$item['longitud']}}</td>
                                    <td>
                                        <div class="row no-gutters">
                                            <div class="col-auto">
                                                <a class="btn btn-sm btn-spinner btn-info"  href="{{ url('admin/visits/'.$project->SEOBId.'/'.$key.'/syncstore')}}" role="button"><i class="fa fa-refresh"></i></a>
                                            </div>
                                        </div>
                                    </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                                </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.guest.actions.syncmuvh') }}
                    </div>
                    <div class="card-body" v-cloak>
                        <!--<div class="card-block">-->
                            <table class="table table-sm table-hover table-borderless">
                                <thead>
                                    <tr>

                                    <th>{{ trans('admin.visit.columns.id') }}</th>
                                    <th>{{ trans('admin.visit.columns.visit_number') }}</th>
                                    <th>{{ trans('admin.visit.columns.advance') }}</th>
                                    <th>{{ trans('admin.visit.columns.visit_date') }}</th>
                                    <th>{{ trans('admin.visit.columns.latitude') }}</th>
                                    <th>{{ trans('admin.visit.columns.longitude') }}</th>
                                    <th>{{ trans('admin.visit.columns.visitid') }}</th>
                                    <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visitas as $key=>$item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->visit_number }}</td>
                                        <td>{{ $item->advance }}</td>
                                        <td>{{ $item->visit_date }}</td>
                                        <td>{{ $item->latitude }}</td>
                                        <td>{{ $item->longitude }}</td>
                                        <td>{{ $item->visit_id }}</td>
                                    <td>
                                        <div class="row no-gutters">
                                            <div class="col-auto">
                                                <a class="btn btn-sm btn-spinner btn-info"  href="{{ url('admin/visits/'.$project->SEOBId.'/'.$item->visit_id.'/syncimage')}}"  role="button"><i class="fa fa-camera"></i></a>
                                            </div>
                                        </div>
                                    </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                                </table>
                    </div>
                </div>
            </div>
        </div>


@endsection

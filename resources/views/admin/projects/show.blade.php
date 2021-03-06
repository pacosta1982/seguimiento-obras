@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.visit.actions.index'))

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
    <!--<div class="row">
            <div class="form-group col-sm-4">
                <p class="card-text">Nacionalidad: </p>
            </div>

            <div class="form-group col-sm-4">
                <p class="card-text">Nacimiento: </p>
            </div>

            <div class="form-group col-sm-4">
                <p class="card-text">Documento: </p>
            </div>
    </div>
    <div class="row">
            <div class="form-group col-sm-4">
                <p class="card-text">Telefono: </p>
            </div>

            <div class="form-group col-sm-4">
                <p class="card-text">Email: </p>
            </div>
    </div>-->
    </div>
  </div>

  <div class="card">
    <div class="card-header text-center">
         LINEA TEMPORAL
    </div>

    <div class="card-body">
        <grafico :label="{{ json_encode($visitas) }}" :values="{{ json_encode($avances) }}"  />
    </div>
  </div>

  <div class="card">
    <div class="card-header text-center">
         UBICACION DEL PROYECTO
    </div>

    <div class="card-body">
    <googlemap :latitude="{{ $latlong["lat"] }}" :longitude="{{ $latlong["lon"] }}" />
    </div>
  </div>

<visit-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/projects/'.$project->SEOBId.'/show') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.visit.actions.index') }}
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/projects/visit/'.$project->SEOBId.'/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.visit.actions.create') }}</a>
                        <a class="btn btn-success  mx-1 btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/visits/'.$project->SEOBId.'/sync') }}" role="button"><i class="fa fa-refresh"></i>&nbsp; {{ trans('admin.visit.actions.sync') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">

                            <table class="table table-hover table-listing">
                                <thead>
                                    <tr>
                                        <th class="bulk-checkbox">
                                            <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled"  name="enabled_fake_element" @click="onBulkItemsClickedAllWithPagination()">
                                            <label class="form-check-label" for="enabled">
                                                #
                                            </label>
                                        </th>

                                        <th is='sortable' :column="'id'">{{ trans('admin.visit.columns.id') }}</th>
                                        <!--<th is='sortable' :column="'project_id'">{{ trans('admin.visit.columns.project_id') }}</th>-->
                                        <th is='sortable' :column="'visit_number'">{{ trans('admin.visit.columns.visit_number') }}</th>
                                        <th is='sortable' :column="'advance'">{{ trans('admin.visit.columns.advance') }}</th>
                                        <th is='sortable' :column="'visit_date'">{{ trans('admin.visit.columns.visit_date') }}</th>

                                        <th></th>
                                    </tr>
                                    <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                        <td class="bg-bulk-info d-table-cell text-center" colspan="7">
                                            <span class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}.  <a href="#" class="text-primary" @click="onBulkItemsClickedAll('/admin/visits')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a
                                                        href="#" class="text-primary" @click="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a>  </span>

                                            <span class="pull-right pr-2">
                                                <button class="btn btn-sm btn-danger pr-3 pl-3" @click="bulkDelete('/admin/visits/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
                                            </span>

                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                        <td class="bulk-checkbox">
                                            <input class="form-check-input" :id="'enabled' + item.id" type="checkbox" v-model="bulkItems[item.id]" v-validate="''" :data-vv-name="'enabled' + item.id"  :name="'enabled' + item.id + '_fake_element'" @click="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                            <label class="form-check-label" :for="'enabled' + item.id">
                                            </label>
                                        </td>

                                        <td>@{{ item.id }}</td>
                                        <!--<td>@{{ item.project_id }}</td>-->
                                        <td>@{{ item.visit_number }}</td>
                                        <td>@{{ item.advance }}</td>
                                        <td>@{{ item.visit_date | datetime }}</td>

                                        <td>
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-spinner btn-info" :href="item.resource_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                </div>
                                                <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                    <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row" v-if="pagination.state.total > 0">
                                <div class="col-sm">
                                    <span class="pagination-caption">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto">
                                    <pagination></pagination>
                                </div>
                            </div>

                            <div class="no-items-found" v-if="!collection.length > 0">
                                <!--<i class="icon-magnifier"></i>-->
                                <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                                <!--<p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                                <a class="btn btn-primary btn-spinner" href="{{ url('admin/visits/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.visit.actions.create') }}</a>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </visit-listing>

@endsection

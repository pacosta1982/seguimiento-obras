@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.visit.actions.index'))

@section('body')

    <project-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/projects') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.projects.actions.index') }}
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-7 col-xl-5 form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="{{ trans('brackets/admin-ui::admin.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary" @click="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('brackets/admin-ui::admin.btn.search') }}</button>
                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </form>

                            <table class="table table-hover table-listing">
                                <thead>
                                    <tr>
                                        <th is='sortable' :column="'SEOBId'">{{ trans('admin.projects.columns.SEOBId') }}</th>
                                        <th is='sortable' :column="'project_id'">{{ trans('admin.projects.columns.SEOBProy') }}</th>
                                        <th is='sortable' :column="'project_id'">{{ trans('admin.projects.columns.state') }}</th>
                                        <th is='sortable' :column="'project_id'">{{ trans('admin.projects.columns.city') }}</th>
                                        <th is='sortable' :column="'visit_number'">{{ trans('admin.projects.columns.SEOBEmpr') }}</th>
                                        <th is='sortable' :column="'advance'">{{ trans('admin.projects.columns.SEOBAvanc') }}</th>
                                        <th></th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                        <td>@{{ item.SEOBId }}</td>
                                        <td>@{{ item.SEOBProy }}</td>
                                        <td>@{{ item.departamento ? item.departamento.DptoNom : '' }}</td>
                                        <td>@{{ item.distrito ? item.distrito.CiuNom : '' }}</td>
                                        <td>@{{ item.SEOBEmpr }}</td>
                                        <td>@{{ item.advance ? item.advance.advance : '0' }} %</td>
                                        <td>
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-spinner btn-info" :href="item.resource_url + '/show'" title="{{ trans('brackets/admin-ui::admin.btn.show') }}" role="button"><i class="fa fa-search"></i></a>
                                                </div>

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
    </project-listing>

@endsection

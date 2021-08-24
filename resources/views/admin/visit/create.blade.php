@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.visit.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">

        <visit-form
            :action="'{{ url('admin/visits') }}'"
            :project="{{ $project->SEOBId }}"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>

                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.visit.actions.create') }}
                </div>

                <div class="card-body">
                    @include('admin.visit.components.form-elements')
                    @include('brackets/admin-ui::admin.includes.media-uploader', [
                            'mediaCollection' => app(App\Models\Visit::class)->getMediaCollection('gallery'),
                            //'media' => $call->getThumbs200ForCollection('gallery'),
                            'label' => 'Documentos Adjuntos'
                        ])
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                </div>

            </form>

        </visit-form>

        </div>

        </div>


@endsection

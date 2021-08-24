@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.visit.actions.edit', ['name' => $visit->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <visit-form
                :action="'{{ $visit->resource_url }}'"
                :data="{{ $visit->toJson() }}"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.visit.actions.edit', ['name' => $visit->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.visit.components.form-elements')
                        @include('brackets/admin-ui::admin.includes.media-uploader', [
                            'mediaCollection' => app(App\Models\Visit::class)->getMediaCollection('gallery'),
                            'media' => $visit->getThumbs200ForCollection('gallery'),
                            'label' => 'Fotografias'
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

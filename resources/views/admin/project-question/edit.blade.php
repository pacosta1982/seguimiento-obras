@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.project-question.actions.edit', ['name' => $projectQuestion->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <project-question-form
                :action="'{{ $projectQuestion->resource_url }}'"
                :data="{{ $projectQuestion->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.project-question.actions.edit', ['name' => $projectQuestion->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.project-question.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </project-question-form>

        </div>
    
</div>

@endsection
<div class="form-group row align-items-center" :class="{'has-danger': errors.has('questionnaire_id'), 'has-success': fields.questionnaire_id && fields.questionnaire_id.valid }">
    <label for="questionnaire_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.project-question.columns.questionnaire_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.questionnaire_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('questionnaire_id'), 'form-control-success': fields.questionnaire_id && fields.questionnaire_id.valid}" id="questionnaire_id" name="questionnaire_id" placeholder="{{ trans('admin.project-question.columns.questionnaire_id') }}">
        <div v-if="errors.has('questionnaire_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('questionnaire_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('project_id'), 'has-success': fields.project_id && fields.project_id.valid }">
    <label for="project_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.project-question.columns.project_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.project_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('project_id'), 'form-control-success': fields.project_id && fields.project_id.valid}" id="project_id" name="project_id" placeholder="{{ trans('admin.project-question.columns.project_id') }}">
        <div v-if="errors.has('project_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('project_id') }}</div>
    </div>
</div>



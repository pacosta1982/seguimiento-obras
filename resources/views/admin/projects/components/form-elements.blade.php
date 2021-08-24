<div class="form-group row align-items-center" :class="{'has-danger': errors.has('project_id'), 'has-success': fields.project_id && fields.project_id.valid }">
    <label for="project_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.visit.columns.project_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.project_id" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('project_id'), 'form-control-success': fields.project_id && fields.project_id.valid}" id="project_id" name="project_id" placeholder="{{ trans('admin.visit.columns.project_id') }}">
        <div v-if="errors.has('project_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('project_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('visit_number'), 'has-success': fields.visit_number && fields.visit_number.valid }">
    <label for="visit_number" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.visit.columns.visit_number') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.visit_number" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('visit_number'), 'form-control-success': fields.visit_number && fields.visit_number.valid}" id="visit_number" name="visit_number" placeholder="{{ trans('admin.visit.columns.visit_number') }}">
        <div v-if="errors.has('visit_number')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('visit_number') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('advance'), 'has-success': fields.advance && fields.advance.valid }">
    <label for="advance" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.visit.columns.advance') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.advance" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('advance'), 'form-control-success': fields.advance && fields.advance.valid}" id="advance" name="advance" placeholder="{{ trans('admin.visit.columns.advance') }}">
        <div v-if="errors.has('advance')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('advance') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('visit_date'), 'has-success': fields.visit_date && fields.visit_date.valid }">
    <label for="visit_date" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.visit.columns.visit_date') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.visit_date" :config="datetimePickerConfig" v-validate="'required|date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('visit_date'), 'form-control-success': fields.visit_date && fields.visit_date.valid}" id="visit_date" name="visit_date" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_date_and_time') }}"></datetime>
        </div>
        <div v-if="errors.has('visit_date')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('visit_date') }}</div>
    </div>
</div>



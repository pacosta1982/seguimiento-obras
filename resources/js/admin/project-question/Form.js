import AppForm from '../app-components/Form/AppForm';

Vue.component('project-question-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                questionnaire_id:  '' ,
                project_id:  '' ,
                
            }
        }
    }

});
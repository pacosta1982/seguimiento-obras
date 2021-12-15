import AppForm from '../app-components/Form/AppForm';

Vue.component('question-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                questionnaire_id:  '' ,
                name:  '' ,
                description:  '' ,
                
            }
        }
    }

});
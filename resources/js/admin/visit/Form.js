import AppForm from '../app-components/Form/AppForm';

Vue.component('visit-form', {
    mixins: [AppForm],
    props: ['project'],
    data: function() {
        return {
            form: {
                project_id:  this.project ,
                visit_number:  '' ,
                advance: '',
                latitude: '',
                longitude: '',
                visit_date:  '' ,

            },
            mediaCollections: ['gallery']
        }
    }

});

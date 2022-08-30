import AppListing from '../app-components/Listing/AppListing';
import { gmapApi } from "vue2-google-maps";

Vue.component('project-listing', {
    mixins: [AppListing],
    data: function data() {
        return {
            orderBy: {
                column: 'SEOBProy',
                direction: 'asc'
            },
        }
    },
    computed: {
        google: gmapApi
    }
});

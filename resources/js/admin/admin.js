import './bootstrap';

import 'vue-multiselect/dist/vue-multiselect.min.css';
import flatPickr from 'vue-flatpickr-component';
import VueQuillEditor from 'vue-quill-editor';
import Notifications from 'vue-notification';
import Multiselect from 'vue-multiselect';
import VeeValidate from 'vee-validate';
import 'flatpickr/dist/flatpickr.css';
import VueCookie from 'vue-cookie';
import { Admin } from 'craftable';
import VModal from 'vue-js-modal'
import Vue from 'vue';
import * as VueGoogleMaps from 'vue2-google-maps'
import VueSplide from '@splidejs/vue-splide';

import './app-components/bootstrap';
import './index';

import 'craftable/dist/ui';
Vue.use( VueSplide );
Vue.component('multiselect', Multiselect);
Vue.use(VeeValidate, {strict: true});
Vue.component('datetime', flatPickr);
Vue.component('googlemap', require('../components/AddGoogleMap.vue').default);
Vue.component('grafico', require('../components/grafico.vue').default);
Vue.component('slide', require('../components/slide.vue').default);
Vue.component('expediente', require('../components/expedientes.vue').default);
//Vue.component('chartmap', require('../components/ChartMap.vue').default);
Vue.use(VModal, { dialog: true, dynamic: true, injectModalsContainer: true });
Vue.use(VueQuillEditor);
Vue.use(Notifications);
Vue.use(VueCookie);

Vue.use(VueGoogleMaps, {
    load: {
      key: 'AIzaSyDuvnZUZmZ1ws40ZVXYw3DF2YmnEn5MCvg',
      libraries: 'places', // This is required if you use the Autocomplete plugin
      // OR: libraries: 'places,drawing'
      // OR: libraries: 'places,drawing,visualization'
      // (as you require)

      //// If you want to set the version, you can do so:
      // v: '3.26',
    },
})

new Vue({
    mixins: [Admin],
});

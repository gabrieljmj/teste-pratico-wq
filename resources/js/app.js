import Vue from 'vue';

import { getRoutes } from './utils';

import googleMapsConfig from './config/google-maps';

import PropertyForm from './components/property-form.vue';
import PropertiesList from './components/properties-list.vue';
import PropertiesSearch from './components/properties-search.vue';
import PropertiesInlineList from './components/properties-inline-list.vue';
import Property from './components/property.vue';

import * as VueGoogleMaps from 'vue2-google-maps';
import VueTheMask from 'vue-the-mask';

Vue.component('property-form', PropertyForm);
Vue.component('properties-list', PropertiesList);
Vue.component('properties-search', PropertiesSearch);
Vue.component('properties-inline-list', PropertiesInlineList);
Vue.component('property', Property);

Vue.use(VueGoogleMaps, googleMapsConfig);
Vue.use(VueTheMask);

new Vue({
    el: '#app',
    data: {
        routes: getRoutes()
    },
});

import './bootstrap'

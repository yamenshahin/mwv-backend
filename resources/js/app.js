/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// Vue Routes
import VueRouter from 'vue-router'

Vue.use(VueRouter)

//vForm
import { 
    Form,
    HasError,
    AlertError,
    AlertErrors, 
    AlertSuccess
} from 'vform'

window.Form = Form
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component(AlertErrors.name, AlertErrors)
Vue.component(AlertSuccess.name, AlertSuccess)

import objectToFormData from 'object-to-formdata'
window.objectToFormData = objectToFormData

// Define routes
let routes = [
    // Admin Power
    { path: '/admin/dashboard', name: 'dashboard', component: require('./components/Dashboard.vue').default },

    { path: '/admin/global-settings', name: 'global-settings', component: require('./components/GlobalSettings.vue').default },

    { path: '/admin/statistics-charts', name: 'statistics-charts', component: require('./components/StatisticsCharts.vue').default },

    //Jobs
    { path: '/admin/jobs/', name: 'jobs', component: require('./components/Jobs.vue').default },

    //Quotes
    { path: '/admin/quotes/', name: 'quotes', component: require('./components/Quotes.vue').default },
    //ToBe
    /* { path: '/admin/feedback-jobs', name: 'feedback-jobs', component: require('./components/FeedbackJobs.vue').default }, */
    
    // Maps
    { path: '/admin/drivers-places', name: 'drivers-places', component: require('./components/DriversPlaces.vue').default },
    { path: '/admin/areas-we-cover', name: 'areas-we-cover', component: require('./components/AreasWeCover.vue').default },
    
    { path: '/admin/calendar', name: 'calendar', component: require('./components/Calendar.vue').default },

    // Users
    { path: '/admin/customers', name: 'customers', component: require('./components/Customers.vue').default },
    { path: '/admin/drivers', name: 'drivers', component: require('./components/Drivers.vue').default },

    { path: '/admin/admins', name: 'admins', component: require('./components/Admins.vue').default },

    { path: '/admin/my-profile', name: 'my-profile', component: require('./components/MyProfile.vue').default },

    //Dev
    { path: '/admin/metas', name: 'metas', component: require('./components/Metas.vue').default },
    { path: '/admin/tests', name: 'tests', component: require('./components/Tests.vue').default },

    //Pages
    { path: '/admin/home-page', name: 'home-page', component: require('./components/HomePage.vue').default },
    { path: '/admin/faq-page', name: 'faq-page', component: require('./components/FAQPage.vue').default },
    { path: '/admin/privacy-page', name: 'privacy-page', component: require('./components/PrivacyPage.vue').default },
    { path: '/admin/terms-page', name: 'terms-page', component: require('./components/TermsPage.vue').default },
    { path: '/admin/drivers-terms-page', name: 'drivers-terms-page', component: require('./components/DriversTermsPage.vue').default },

    //Dynamic Pages
    { path: '/admin/dynamic-page', name: 'dynamic-page', component: require('./components/DynamicPage.vue').default },
]

// Create the router instance and pass the `routes` option
const router = new VueRouter({
    mode: 'history',
    routes, // short for `routes: routes`
    linkActiveClass: 'active'
})

// Passport components
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

//https://github.com/gilbitron/laravel-vue-pagination
Vue.component('pagination', require('laravel-vue-pagination'));

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});

require('./filters');
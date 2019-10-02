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

// Define routes
let routes = [
    { path: '/admin/dashboard', name: 'dashboard', component: require('./components/Dashboard.vue').default },

    { path: '/admin/statistics-charts', name: 'statistics-charts', component: require('./components/StatisticsCharts.vue').default },

    { path: '/admin/jobs', name: 'jobs', component: require('./components/Jobs.vue').default },
    
    // Maps
    { path: '/admin/drivers-places', name: 'drivers-places', component: require('./components/DriversPlaces.vue').default },
    { path: '/admin/areas-we-cover', name: 'areas-we-cover', component: require('./components/AreasWeCover.vue').default },
    
    { path: '/admin/calendar', name: 'calendar', component: require('./components/Calendar.vue').default },

    // Users
    { path: '/admin/customers', name: 'customers', component: require('./components/Customers.vue').default },
    { path: '/admin/drivers', name: 'drivers', component: require('./components/Drivers.vue').default },

    { path: '/admin/admins', name: 'admins', component: require('./components/Admins.vue').default },

    { path: '/admin/my-profile', name: 'my-profile', component: require('./components/MyProfile.vue').default },
]

// Create the router instance and pass the `routes` option
const router = new VueRouter({
    mode: 'history',
    routes, // short for `routes: routes`
    linkActiveClass: 'active'
})

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

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('reservas-component', require('./components/ReservasComponent.vue').default);
Vue.component('categoriaservicios-component', require('./components/CategoriaServicioComponent.vue').default);
Vue.component('categoriaproductos-component', require('./components/CategoriaProductoComponent.vue').default);
Vue.component('operadores-component', require('./components/OperadoresComponent.vue').default);
Vue.component('productos-component', require('./components/ProductosComponent.vue').default);
Vue.component('servicios-component', require('./components/ServiciosComponent.vue').default);
Vue.component('trabajos-component', require('./components/TrabajosComponent.vue').default);
Vue.component('ventas-component', require('./components/VentasComponent.vue').default);
Vue.component('reportes-component', require('./components/ReportesComponent.vue').default);
Vue.component('ticket-component', require('./components/TicketComponent.vue').default);
Vue.component('total-component', require('./components/TotalDiarioComponent.vue').default);
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

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 import reservas from './components/ReservasComponent';
 import categoriaservicios from './components/CategoriaServicioComponent';
 import categoriaproductos from './components/CategoriaProductoComponent';
 import operadores from './components/OperadoresComponent';
 import productos from './components/ProductosComponent';
 import servicios from './components/ServiciosComponent';
 import trabajos from './components/TrabajosComponent';
 import ventas from './components/VentasComponent';
 import reportes from './components/ReportesComponent';
 import ticket from './components/TicketComponent';
 import total from './components/TotalDiarioComponent';
 import Vuelidate from 'vuelidate'
 Vue.use(Vuelidate)

 import Vue from 'vue';
import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);

const app = new Vue({
    el: '#app',
    component: {
        reservas,
        categoriaservicios,
        categoriaproductos,
        operadores,
        productos,
        servicios,
        trabajos,
        ventas,
        reportes,
        ticket,
        total
    }
});

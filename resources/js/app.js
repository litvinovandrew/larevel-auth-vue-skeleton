require('./bootstrap');

window.Vue = require('vue');


import ExampleComponent from './components/ExampleComponent'

const app = new Vue({
    el: '#app',
    components: {ExampleComponent}
});

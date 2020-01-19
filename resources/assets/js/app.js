import Echo from "laravel-echo"
import Notifica from './notifica';
import select from './directives/select2';
import money from './directives/money';
import formValidator from './directives/formValidator'
import {registerMasks} from './masks';
import {configurarAjax} from './ajax';
import {registerBinds} from './binds';
import {registerPlugins} from "./plugins";
import axios from 'axios';
import * as defaultConfig from './defaultconfigs';
import * as constants from './constants';
import _ from 'underscore';

import Geral from './components/geral';

// Só depois do documento estar carregado
$(document).ready(() => {
    configurarAjax();
    registerMasks();
    registerBinds();
    registerPlugins();
});

// Disponibiliza globalmente algumas classes e constantes
window.constants = constants;
window.Notifica = new Notifica();
window.Config = defaultConfig;
window._ = _

window.axios = require('axios');

window.axios.defaults.headers.common = {
    "Access-Control-Allow-Origin": "*",
    "Access-Control-Allow-Headers": "Authorization",
    "Access-Control-Allow-Methods": "GET, POST, OPTIONS, PUT, PATCH, DELETE",
    "Content-Type": "application/json;charset=UTF-8"
};

Vue.config.devtools = true;

// Inicia o socket
if (typeof io !== 'undefined') {
    window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: window.location.hostname + ':6001'
    });
}

// Configura vue
Vue.http.headers.common['X-CSRF-TOKEN'] = constants.CSRF_TOKEN;



// Inicia o eventhub utilizado no vue
const eventHub = new Vue();
Vue.mixin({
    data: function () {
        return {
            eventHub: eventHub
        }
    }
});

// Inicializa algumas poucas diretivas
Vue.directive('select', select);
Vue.directive('money', money);
Vue.directive('form-validate', formValidator);
Vue.component('wysiwyg', require('./components/wysiwyg'));
Vue.component('dropzone', require('./components/dropzone'));


Vue.use(require('vue-scrollto'));
Vue.use(money, {precision: 4});

const App = Vue.extend(Vue.component('app'));
new App().$mount('#app');

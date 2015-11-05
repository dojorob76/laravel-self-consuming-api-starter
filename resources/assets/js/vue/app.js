var Vue = require('vue');
Vue.use(require('vue-resource'));

<<<<<<< HEAD
var rootApiPath = 'SET-YOUR-ROOT-API-PATH-HERE'; //ex. 'http://api.app-name.com'
var appDomain = 'SET-YOUR-APP-DOMAIN-HERE'; //ex. '.app-name.com'

var jsCookie = require('js-cookie');
jsCookie.defaults = {domain: appDomain};

Vue.http.headers.common['Authorization'] = 'Bearer ' + jsCookie.get('jwt');
=======
global.auth = require('./custom/auth');
>>>>>>> d777b7f4a0795542a2f44a6d65c5eb838af4c5f7

new Vue({
    el: '#app',

    data: {
<<<<<<< HEAD
        rootApiPath: rootApiPath,
        csrf: $('meta[name="csrf-token"]').attr('content'),
        currentView: 'login-view'
    },

    components: {
        'login-view': require('./views/authorization/login'),
        'register-view': require('./views/authorization/register')
    },

    methods: {
        updateJwt: function(jwtoken){
            if(jwtoken != null && jwtoken != 'undefined'){
                jsCookie.set('jwt', jwtoken);
            }
            else{
                jsCookie.remove('jwt', jwtoken);
            }
        }
    }
=======
        currentView: 'welcome-view'
    },

    components: {
        'welcome-view': require('./views/welcome'),
        'login-view': require('./views/authentication/login'),
        'register-view': require('./views/authentication/register')
    },

    methods: {
        route: function(view){
            this.currentView = view;
        }
    }

>>>>>>> d777b7f4a0795542a2f44a6d65c5eb838af4c5f7
});
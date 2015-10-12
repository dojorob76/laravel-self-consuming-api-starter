var Vue = require('vue');
Vue.use(require('vue-resource'));

var rootApiPath = 'SET-YOUR-ROOT-API-PATH-HERE'; //ex. 'http://api.app-name.com'
var appDomain = 'SET-YOUR-APP-DOMAIN-HERE'; //ex. '.app-name.com'

var jsCookie = require('js-cookie');
jsCookie.defaults = {domain: appDomain};

Vue.http.headers.common['Authorization'] = 'Bearer ' + jsCookie.get('jwt');

new Vue({
    el: '#app',

    data: {
        rootApiPath: rootApiPath,
        currentView: 'login-view'
    },

    components: {
        'login-view': require('./views/authorization/login')
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
});
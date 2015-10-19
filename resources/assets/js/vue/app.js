var Vue = require('vue');
Vue.use(require('vue-resource'));

var rootApiPath = 'YOUR-ROOT-API-PATH'; //ex. 'http://api.app-name.com'
var appDomain = 'YOUR-APP-DOMAIN'; //ex. '.app-name.com'

var jsCookie = require('js-cookie');
jsCookie.defaults = {domain: appDomain};

Vue.http.headers.common['Authorization'] = 'Bearer ' + jsCookie.get('jwt');

new Vue({
    el: '#app',

    data: {
        rootApiPath: rootApiPath,
        csrf: $('meta[name="csrf-token"]').attr('content')
    },

    components: {},

    methods: {
        updateJwt: function(jwtoken){
            if(jwtoken != null && jwtoken != 'undefined'){
                jsCookie.set('jwt', jwtoken); // Set a potentially valid JWT in the cookies
            }
            else{
                // Remove an invalid JWT from the cookies
                jsCookie.remove('jwt', jwtoken);
            }
        }
    }
});
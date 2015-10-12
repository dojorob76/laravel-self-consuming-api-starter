var Vue = require('vue');
Vue.use(require('vue-resource'));

var jsCookie = require('js-cookie');
//jsCookie.defaults = {domain: 'CONFIGURE-DEFAULT-DOMAIN-HERE'}; //ex. '.domain-name.com'
jsCookie.defaults = {domain: '.mmh.app'};

Vue.http.headers.common['Authorization'] = 'Bearer ' + jsCookie.get('jwt');

new Vue({
    el: '#app',

    data: {
        //rootApiPath: 'CONFIGURE ROOT API PATH HERE', //ex. 'http://api.domain-name.com'
        rootApiPath: 'http://api.mmh.app',
        jwtManager: require('./custom/jwt-manager.js'),
        currentView: 'login-view'
    },

    components: {
        'login-view': require('./views/authorization/login')
    }
});
var Vue = require('vue');
Vue.use(require('vue-resource'));

global.auth = require('./custom/auth');

new Vue({
    el: '#app',

    data: {
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

});
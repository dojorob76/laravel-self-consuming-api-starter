var Vue = require('vue');
Vue.use(require('vue-resource'));

new Vue({
    el: '#app',

    data: {
        //rootApiPath: 'http://api.app.tld',
        rootApiPath: 'http://api.mmh.app',
        currentView: 'login-view'
    },

    components: {
        'login-view': require('./views/authorization/login')
    }
});
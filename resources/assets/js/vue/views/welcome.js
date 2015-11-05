module.exports = {

    template: require('./welcome.template.html'),

    data: function(){
        return{
            authMsg: 'Click the buttons to test the JWT using the Authorization header and/or Query string on different domains.',
            token: auth.jwtCookie,
            authorized: auth.authorized,
            apiDomain: appGlobals.rootApiPath,
            nonApiDomain: "http://" + appGlobals.appDomain.substr(1)
        };
    },

    ready: function(){
        this.refreshAuth();
    },

    methods: {
        queryTest: function(option){
            if(option === "test-one"){
                // Test the JWT using a Query string on the NON-API domain
                window.location = this.nonApiDomain + "/test-auth-one?token=" + this.token
            }
            if(option === "test-two"){
                // Test the JWT using the Query String on the API domain
                this.$http.get( this.apiDomain + "/test-auth-two?token=" + this.token)
                .success(function(data){
                    this.authMsg = data.msg;
                })
                .error(function(data){
                    this.authMsg = data;
                    auth.logOut();
                    this.$root.currentView = 'login-view';
                })
            }
        },
        headerTest: function(option) {
            if(option === "test-three"){
                // Test the JWT using the Authorization header on the NON-API domain
                var path = this.nonApiDomain + '/test-auth-three';
            }
            if(option === "test-four"){
                // Test the JWT using the Authorization header on the API domain
                var path = this.apiDomain + '/test-auth-four';
            }
            this.$http.get(path, function (data) {},
                // Add the JWT Authorization header to the request
                {headers: {'Authorization': 'Bearer ' + this.token}
                }).success(function (data, status, jqXHR) {
                    auth.getAuthHeader(jqXHR);
                    this.authMsg = data.msg;
                    this.refreshAuth();
                }).error(function (data) {
                    this.authMsg = data;
                    auth.logOut();
                    this.$root.currentView = 'login-view';
                })
        },
        refreshAuth: function(){
            auth.getAuthStatus();
            this.authorized = auth.authorized;
            this.token = auth.jwtCookie;
        }

    }

};
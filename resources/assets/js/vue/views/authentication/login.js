module.exports = {

    template: require('./login.template.html'),

    data: function(){
        return{
            credentials: {
                email: '',
                password: '',
                token_key: appGlobals.csrf
            },
            singleError: ''
        };
    },

    methods: {
        validate: function(e){
            e.preventDefault();

            this.singleError = '';
            formErrors.clear();

            this.$http.post( appGlobals.rootApiPath + '/form-login', this.credentials)
                .success(function(data){
                    if(data.error){
                        // A non-FormRequest error was returned, so let's clear the form and display the error above it
                        this.resetForm();
                        this.singleError = '<div class="alert alert-danger" role="alert"><strong>Whoops!</strong> ' + data.message + ' Please try again.</div>';
                    }
                    else{
                        auth.updateJwt(data.jwtoken);
                        //Reload in order to access the Laravel Auth object and display the welcome view
                        location.reload(); //Reload in order to gain access to the Laravel Auth helper
                    }
                })
                .error(function(data){
                    if(data.errors){
                        formErrors.set(data.errors, 'login-');
                    }
                })
        },
        resetForm: function(){
            formErrors.clear();
            this.credentials.email = '';
            this.credentials.password = '';
        }
    }
};
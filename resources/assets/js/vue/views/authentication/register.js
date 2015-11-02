module.exports = {

    template: require('./register.template.html'),

    data: function(){
        return{
            registration: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                token_key: appGlobals.csrf
            },
            singleError: ''
        };
    },

    methods: {
        register: function(e){
            e.preventDefault();

            this.singleError = '';
            formErrors.clear();

            this.$http.post( appGlobals.rootApiPath + '/form-register', this.registration)
                .success(function(data){
                    if(data.error){
                        // A non-FormRequest error was returned, so let's clear the form and display the error above it
                        this.resetForm();
                        this.singleError = '<div class="alert alert-danger" role="alert"><strong>Whoops!</strong> ' + data.message + ' Please try again.</div>';
                    }
                    else{
                        auth.updateJwt(data.jwtoken);
                        //Reload in order to access the Laravel Auth object and display the welcome view
                        location.reload();
                    }
                })
                .error(function(data){
                    if(data.errors){
                        formErrors.set(data.errors, 'register-');
                    }
                })
        },
        resetForm: function(){
            formErrors.clear();
            this.credentials.name = '';
            this.credentials.email = '';
            this.credentials.password = '';
            this.credentials.password_confirmation = '';
        }
    }
};
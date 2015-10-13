module.exports = {

    inherit: true,

    template: require('./register.template.html'),

    data: function(){
        return{
            registration: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                token_key: this.csrf
            }
        };
    },

    methods: {
        register: function(e){
            e.preventDefault();

            this.$http.post( this.rootApiPath + '/register', this.registration)
                .success(function(data){
                    console.log(data);
                    this.updateJwt(data.jwtoken);
                })
                .error(function(data){
                    console.log(data)
                })
        }
    }

};
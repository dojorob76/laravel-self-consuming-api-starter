module.exports = {

    inherit: true,

    template: require('./login.template.html'),

    data: function(){
        return{
            credentials: {
                email: '',
                password: ''
            }
        };
    },

    methods: {
        validate: function(e){
            e.preventDefault();

            this.$http.post( this.rootApiPath + '/login', this.credentials)
                .success(function(data){
                    console.log(data);
                })
                .error(function(data){
                    console.log(data)
                })
        }
    }

};
var jsCookie = require('js-cookie');
//jsCookie.defaults = {domain: 'CONFIGURE-DEFAULT-DOMAIN-HERE'}; //ex. '.domain-name.com'
jsCookie.defaults = {domain: '.mmh.app'};

module.exports = {
    updateJwt: function(jwtoken){
        if(jwtoken != null && jwtoken != 'undefined'){
            jsCookie.set('jwt', jwtoken);
        }
        else{
            jsCookie.remove('jwt', jwtoken);
        }
    }
};
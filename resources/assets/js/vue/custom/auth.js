module.exports = {
    jwtCookie: null,
    authorized: false,

    getAuthStatus: function(){
        var jwtCookie = jwToken.getFromCookie();

        this.jwtCookie = jwtCookie;
        this.authorized = jwtCookie != null;
    },
    updateJwt: function(jwt){
        if(jwt != null && jwt != 'undefined'){
            jwToken.addCookie(jwt);
            this.jwtCookie = jwt;
            this.authorized = true;
        }
        else{
            this.logOut();
        }
    },
    getAuthHeader: function(jqXHR){
        var jwtHeader = jwToken.getFromHeader(jqXHR);
        // Update the Auth status and cookie
        this.updateJwt(jwtHeader);
    },
    logOut: function(){
        jwToken.removeCookie();
        this.jwtCookie = null;
        this.authorized = false;
    }
};
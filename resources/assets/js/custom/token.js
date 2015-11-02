var jwToken = {
    getFromCookie: function(){
        // If there is a JWT cookie, return it, otherwise return null
        return (docCookies.hasItem('jwt') ? docCookies.getItem('jwt') : null);
    },
    getFromHeader: function(jqXHR){
        // Get the value of Authorization from the Response header
        var fullToken = jqXHR.getResponseHeader('Authorization');

        // Remove 'Bearer ' to set jwtoken to the JWT value only
        return fullToken.substr(fullToken.indexOf(' ')+1);
    },
    addCookie: function(jwt){
        docCookies.setItem('jwt', jwt, 7200, '/', appGlobals.appDomain);
    },
    removeCookie: function(){
        docCookies.setItem('jwt', null, -2628000, '/', appGlobals.appDomain);
    },
    setHeader: function(){
        return (docCookies.hasItem('jwt') ? 'Bearer ' + docCookies.getItem('jwt') : null);
    }
};
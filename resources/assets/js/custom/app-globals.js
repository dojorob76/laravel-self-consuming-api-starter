var appGlobals = {
    csrf: $('meta[name="csrf-token"]').attr('content'),
    // Set the root API Path and Domain for a specific app instance below
    rootApiPath : 'YOUR-API-PATH-HERE', //ex. 'http://api.app-name.com'
    appDomain: 'YOUR-APP(SESSION)-DOMAIN-HERE' //ex. '.app-name.com'
};
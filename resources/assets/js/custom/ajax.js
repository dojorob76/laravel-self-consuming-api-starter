var formAjax = {
    /**
     * Validate a form via AJAX. Success and Error callback functions should be defined below, then added to the
     * appropriate param array (successCallback/errorCallback) when the validate function is invoked.
     *
     * @param prefix - string (The specific form's error message prefix)
     * @param submit - boolean true/false (Whether the form should be submitted normally on success) [defaults to false]
     * @param successCallback - array of functions (functions to execute on success) [optional]
     * @param errorCallback - array of functions (functions to execute on error) [optional]
     */
    validate: function (prefix, submit, successCallback, errorCallback) {
        $('.ajax-submit').on('click', function (e) {

            var form = $(this).closest('form');

            formErrors.clearAll();

            var ajaxRequest = $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: form.serialize()
            });

            ajaxRequest.done(function (data, textStatus, jqXHR) {
                // Display error response if/when non-FormRequest generated errors are returned
                if (data.error) {
                    formErrors.setSingle(data);
                }
                else {
                    // If success callbacks were provided, execute each of them
                    if (successCallback != null) {
                        $.each(successCallback, function (index, value) {
                            value(data, textStatus, jqXHR);
                        });
                    }
                    // If the submit parameter is set to true, (re)submit the form normally
                    if (submit) {
                        form.submit();
                    }
                }
            });

            ajaxRequest.fail(function (data, textStatus, jqXHR) {
                // Get the list of errors returned from a Form Request
                var errors = $.parseJSON(data.responseText);
                // Display the errors on the form fields they belong to
                formErrors.set(errors, prefix);
                if (errorCallback != null) {
                    // If error callbacks were provided, execute each of them
                    $.each(errorCallback, function (index, value) {
                        value(data, textStatus, jqXHR);
                    });
                }
            });

            e.preventDefault();
        });
    },
    /**
     *  ----------------SUCCESS/ERROR CALLBACKS--------------------
     *  These functions are provided as parameters to the validate function, then run through the $.each loop of .done
     *  and/or .fail - the data, textStatus, and jqXHR responses will be passed as params to each of them.
     *
     * @param data
     * @param textStatus
     * @param jqXHR
     */
    setAuthorized: function (data, textStatus, jqXHR) {
        // On successful Login and/or Registration, set the JWT Cookie and redirect to welcome page
        if (data.jwtoken) {
            jwToken.addCookie(data.jwtoken);
            location.replace('/laravel', function () {
                // Break out of the $.each loop so redirect actually occurs
                return false;
            });
        }
    },
    removeAuthorized: function (data, textStatus, jqXHR) {
        // On Authorization failure, log the user out
        location.replace('/logout', function () {
            // Break out of the $.each loop so redirect actually occurs
            return false;
        });
    },
    setCookieFromHeader: function(data, textStatus, jqXHR){
        var jwtHeader = jwToken.getFromHeader(jqXHR);
        jwToken.addCookie(jwtHeader);
    }

};
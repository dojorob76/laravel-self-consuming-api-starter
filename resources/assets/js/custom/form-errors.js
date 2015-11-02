var formErrors = {
    set: function(errors, prefix){
        // If validation error messages are returned, display them under their input fields
        $.each(errors, function(index, value){
            var msgtxt = '';
            $.each(value, function(key, msg){
                msgtxt += '<li>' + msg + '</li>';
            });
            $('#' + prefix + index).addClass('has-error has-feedback');
            $('.' + prefix + index + '-error-msg ul').html(msgtxt);
        });
    },
    setSingle: function(data){
        // If a single error message (not part of Form Request) is returned, display it in alert box at top of form
        $('.single-error').removeClass('hidden');
        $('.error-msg').text(data.message + ' Please try again.');
    },
    clear: function(){
        // If form validation error messages are present, remove them before (re)submitting a form
        $('.form-group').each(function(){
            if($(this).hasClass('has-error has-feedback')){
               $(this).removeClass('has-error has-feedback') ;
            }
        });
    },
    clearSingle: function(){
        // If a form has a single error at the top of the page, clear and hide it
        $('.error-msg').text('');
        $('.single-error').addClass('hidden');
    },
    clearAll: function(){
        this.clear();
        this.clearSingle();
    }
};
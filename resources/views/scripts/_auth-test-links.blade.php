<script>
    $('.ajax-link').on('click', function(e){

        var response = $('.test-message');

        if($(this).hasClass('refresh')){
            var refresh = true;
        }

        $.ajax({
            url: $(this).attr('href')
        })
            .done(function(data, textStatus, jqXHR){
                response.text(data.msg);
                if(refresh){
                    formAjax.setCookieFromHeader(data, textStatus, jqXHR);
                    location.reload(); // Reload page to update the header and cookie token variables
                }
            })
            .fail(function(data, textStatus, jqXHR){
                response.text(data.responseText + '. You are being logged out.');
                location.replace('/logout');
            });

        e.preventDefault();
    });
</script>
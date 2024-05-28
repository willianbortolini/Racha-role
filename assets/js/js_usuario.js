(function getCaptcha()
{   
        grecaptcha.ready(function () {
            grecaptcha.execute('6LeqisoZAAAAAM3vBJYQjtZ9P8gyBdFeE0mbsorb', {action: 'submit'}).then(function (token) {
                $("#g-recaptcha-response").val(token);
                // Add your logic to submit to your backend server here.
            });
        });
    
}
());
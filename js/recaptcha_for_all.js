jQuery(document).ready(function ($) {
    console.log('loaded!');
    // console.log(window.location.hostname);
    jQuery("#recaptcha_for_all").click(function (e) {
        jQuery('#recaptcha_for_all').fadeOut(250).fadeIn(250); 
        jQuery('#recaptcha_for_all').attr("disabled", true);
        e.preventDefault();
        e.stopImmediatePropagation();
        // console.log("Handler for .click() called.");
        grecaptcha.ready(function () {
           // console.log('17');
            var $sitekey = jQuery("#sitekey").val();
            grecaptcha.execute($sitekey, { action: 'recaptcha_for_all_main' }).then(function (token) {
               // console.log('23');
                // console.log('Token: ' + token);
                $('#recaptcha_for_all').prepend('<input type="hidden" name="token" value="' + token + '">');
                $('#recaptcha_for_all').prepend('<input type="hidden" name="action" value="recaptcha_for_all">');
                $("#recaptcha_for_all").submit();
            });
        });
    });
});
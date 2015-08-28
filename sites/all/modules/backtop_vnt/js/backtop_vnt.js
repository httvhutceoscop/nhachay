(function ($){
    Drupal.behaviors.sm_backtop = {
        attach: function(context){
            var offset = 220;
            var duration = 500;

            $('html,body').append('<a href="javascript:;" class="lb-back-to-top">BackTop</a>');

            $(window).scroll(function() {
                if ($(this).scrollTop() > offset) {
                    $('.lb-back-to-top').fadeIn(duration);
                } else {
                    $('.lb-back-to-top').fadeOut(duration);
                }
            });

            $('.lb-back-to-top').click(function(event) {
                event.preventDefault();
                $('html, body').animate({scrollTop: 0}, duration);
                return false;
            })
        }
    }
})(jQuery);

/*
jQuery(document).ready(function() {
    var offset = 220;
    var duration = 500;

    jQuery('body').prepend('<a href="javascript:;" class="lb-back-to-top">BackTop</a>');

    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > offset) {
            jQuery('.lb-back-to-top').fadeIn(duration);
        } else {
            jQuery('.lb-back-to-top').fadeOut(duration);
        }
    });
    
    jQuery('.lb-back-to-top').click(function(event) {
        event.preventDefault();
        jQuery('html, body').animate({scrollTop: 0}, duration);
        return false;
    })
});*/

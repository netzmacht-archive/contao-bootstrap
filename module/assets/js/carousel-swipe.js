// credits to Justin Lazanowski http://lazcreative.com/blog/adding-swipe-support-to-bootstrap-carousel-3-0/
$(document).ready(function() {

    $(".carousel").swipe( {
        swipeLeft:function(event, direction, distance, duration, fingerCount) {
            $(this).carousel('next');
        },
        swipeRight: function() {
            $(this).carousel('prev');
        },
        //Default is 75px, set to 0 for demo so any distance triggers swipe
        threshold: 75
    });
});
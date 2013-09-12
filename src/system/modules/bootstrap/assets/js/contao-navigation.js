
$(document).ready(function() {

    $('.dropdown > [data-toggle="collapse"]').click(function(e) {
        console.log('sfd');
        e.preventDefault()
        e.stopPropagation();

        $(this).parent('.dropdown').toggleClass('open');
    });
});
jQuery(document).ready(function ($) {
    //Youtube Link
    
    $('.youtube-link').each(function() {
         /* iterate through array or object */
         var youTubeHref = $(this).attr('href');
         console.log(youTubeHref);

        $(this).siblings('a').each(function(index) {
            $(this).attr("href", youTubeHref).addClass('lightbox' +index);
        });
    });

    /* Magnific pop-up */

    $('.lightbox0').magnificPopup({
        disableOn: 768,
        type: 'iframe',
        // other options
        gallery: {
            // options for gallery
            enabled: true
        },
    });

    $('.lightbox1').magnificPopup({
        type: 'iframe',
        // other options
        gallery: {
            // options for gallery
            enabled: true
        },
    });
});


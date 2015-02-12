jQuery(document).ready(function ($) {
    // allow jQuery's "containts" selector to not have to match cases
    $.expr[":"].contains = $.expr.createPseudo(function(arg) {
        return function( elem ) {
            return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
        };
    });


/* jQuery UI Tabs */

    $("#tabs").tabs();
    $(function() {
        $("#tabs").tabs({
            activate: function(event, ui) {
                var scrollTop = $(window).scrollTop();
                window.location.hash = ui.newPanel.attr('id');
                $(window).scrollTop(scrollTop);
                // Keep search persistance
                $( "#custom-search" ).trigger('keyup');
            }
        });
    });
 
    // Get the title and selector for active tab
    var tabTitle; 
    function getTabTitle() {
        var active = $( "#tabs" ).tabs( "option", "active" );
            switch (active) {
                case 0:
                    tabTitle = "#speakers article";
                    //var dataBookmarkVal = "#speakers article";
                    break;
                case 1:
                    tabTitle = "#topics .cat-item";
                    break;
                case 2:
                    tabTitle = "#presentations li";
                    break;
            }
        
    }

    // Get the current tab when clicked and maintain search persistance
    $('.ui-tabs-nav').on('click', 'li', function(event) {
        $('.az-checkbox [type="checkbox"]').prop('checked', false);
        getTabTitle();
        createAz(tabTitle);
        numberResults(tabTitle);
        $('#not-found').remove();
        //keep search persistance
        $( "#custom-search" ).trigger('keyup');
    });

    // Count Bar - Speakers page
    function numberResults(currentSelector) {
        var displayed = $(currentSelector).filter(":visible").length;
        $('#count-bar #results').text(displayed);
    }

    // Collapse tabs on home page */
    $( "#tabs-collapse" ).tabs({
        show: { effect: "blind", duration: 800 },
        hide: { effect: "blind", duration: 800 },
        collapsible: true,
        active: false
    });

    $( "#tabs-collapse-2" ).tabs({
        show: { effect: "blind", duration: 800 },
        hide: { effect: "blind", duration: 800 },
        collapsible: true,
        active: false
    });



/* A-Z Filter */

    var catLetters = [];
    
    // Add data-bookmark="" to .cat-item li
    $('.cat-item a').each(function( index ) {
        var topic = $( this ).text();
        var firstLetter = topic.charAt(0);
        $(this).attr("data-bookmark", firstLetter).parent().attr("data-bookmark", firstLetter);
    });

    // Add data-bookmark="" to .pres-item
    $('.pres-item a').each(function( index ) {
        var presentation = $( this ).text();
        var firstLetter = presentation.charAt(0);
        $(this).attr("data-bookmark", firstLetter).parent().attr("data-bookmark", firstLetter);
        
    });

    // Create the A-Z Filter Checkboxes
    function createAz(dataBookmark) {
        sortedAz = [];
        $('.az-filter span').remove();
        $(dataBookmark).each(function(index, el) {
            $(el).removeClass('az-filter').show();
            firstLetterLastName = $(el).attr( "data-bookmark" );
            if ($.inArray(firstLetterLastName, sortedAz) < 0) {
                sortedAz.push(firstLetterLastName);
            }
            sortedAz = sortedAz.sort();
        });
        $.each(sortedAz, function(index, val) {
        /* iterate through array or object */
            $('.two_third .az-filter').append('<span class="az-checkbox" data-bookmark="' + val + '"><input type="checkbox" name="' + val + '" id="' + val + '"><label for="' + val + '">' + val + '</label></span>');
        });
    }
    
    $('.az-placeholder').remove();
    $('.az-checkbox [type="checkbox"]').prop('checked', false); // set checked prop to false on load
    $('.two_third').on('change', '.az-checkbox [type="checkbox"]', function( event ) {
        $('.az-filter').removeClass('even odd');
        //Act on the event */
        letter = $(this).siblings('label').text();
        if ($(this).prop('checked')) {
            $('[data-bookmark='+letter+']').addClass("az-filter");
            $(this).siblings('label').addClass('checked');
        } else {
            $('[data-bookmark='+letter+']').removeClass("az-filter");
            $(this).siblings('label').removeClass('checked');
        }
    
        if ($('input:checkbox:checked').length > 0) {
            $('article, .cat-item, .pres-item').each(function() {
                $('article, .cat-item, .pres-item').not('.az-filter').hide();
                $('.az-filter').show();
                $('#count-bar #clear').show(); // show 'clear filter/show all' button
            });
        } else {
            $('article, .cat-item, .pres-item').each(function() {
                $('article, .cat-item, .pres-item').show();
            });
            $('#count-bar #clear').hide(); // hide 'clear filter/show all' button
        }
        getTabTitle();
        numberResults(tabTitle);
        addClassEvenOdd();
    });

function addClassEvenOdd() {
    $('#speakers .az-filter').filter(':even').addClass('even');
    $('#speakers .az-filter').filter(':odd').addClass('odd');
}

/* End AZ Filter */


/* jQuery Search Filter */

    $( "#custom-search" ).keyup(function() {
        $('#speaker-search .fa-times, #count-bar #clear').show();
        if( !$('#custom-search').val() && $('input:checkbox:checked').length == 0 ) {
            $('#speaker-search .fa-times, #count-bar #clear').hide();
            console.log('hide');
        }
        var singleValues = $(this).val();
        $('article').removeClass('found').show();
        if($("article").hasClass("az-filter")){
            $(".az-filter .entry-wrapper:contains('" + singleValues + "')" ).parents('article').addClass("found"); 
        } else {
            $(".entry-wrapper:contains('" + singleValues + "')" ).parents('article').addClass("found");
        }
        
        $('.cat-item, .pres-item').removeClass('found').show();
        if($(".cat-item, .pres-item").hasClass("az-filter")){
            $(".az-filter:contains('" + singleValues + "')" ).addClass("found");
        } else {
            $(".cat-item:contains('" + singleValues + "')" ).addClass("found");
            $(".pres-item:contains('" + singleValues + "')" ).addClass("found");
        }

        $('article').not(".found").hide();
        $('.cat-item').not(".found").hide();
        $('.pres-item').not(".found").hide();
        //$("#ptag").html( "<b>Single:</b> " + singleValues);
        getTabTitle();
        numberResults(tabTitle);
    });
    $('#speaker-search .fa-times, #count-bar #clear').click(function(event) {
        $( '.az-checkbox [type="checkbox"]' ).prop('checked', false).trigger('change');// set checked prop to false and remove checked a-z filter
        $( '#custom-search' ).val('').trigger('keyup'); // clear contents of search input when button is clicked and trigger keyup event to hide button again
    });


/* Front Page Search Filter */

var $input = $( '#home-search' );

$(document).click( function(evt) {
   var $tgt = $(evt.target);
   if( !$tgt.is( '.search-dropdown-container') && !$tgt.is($input) ) {
         $input.blur();
         $('.search-dropdown-container').hide();
    }
})

    // $( "#home-search" ).blur(function() {
    //     $('.search-dropdown-container').hide();
    // });
    function searchSpeakers() {
        var singleValues = $('#home-search').val();
        $('.search-dropdown-container li').removeClass('found').show();
        if( $('#home-search').val() ) {
            $('.search-dropdown-container').show();
            $(".search-dropdown-container li:contains('" + singleValues + "')" ).addClass("found");
            $('.search-dropdown-container li').not(".found").hide();
            if(!$(".search-dropdown-container li").hasClass("found")){
                $(".search-dropdown-container").hide();
            }
        } else {
            $('.search-dropdown-container').hide();
        }
    }
    $( "#home-search" ).keyup(searchSpeakers).focus(searchSpeakers); // clear search field when losing focus


/* Move Tag Cloud */

    $( ".tag-cloud p" ).replaceWith( $( "#tag-cloud" ));



/* Initialize functions */

    function init() {
        getTabTitle();
        createAz(tabTitle);
        numberResults(tabTitle);
    }
    init();
});


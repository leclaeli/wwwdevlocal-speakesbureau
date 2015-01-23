jQuery(document).ready(function ($) {
    // allow jQuery's "containts" selector to not have to match cases
    $.expr[":"].contains = $.expr.createPseudo(function(arg) {
        return function( elem ) {
            return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
        };
    });

    /* jQuery Ui Tabs */
    $("#tabs").tabs();
    $(function() {
        $("#tabs").tabs({
            activate: function(event, ui) {
                var scrollTop = $(window).scrollTop();
                window.location.hash = ui.newPanel.attr('id');
                $(window).scrollTop(scrollTop);
            }
        });
    });
 
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

    /* Get the current tab when clicked */
    $('.ui-tabs-nav').on('click', 'li', function(event) {
        $('.az-checkbox [type="checkbox"]').prop('checked', false);

        getTabTitle();
        createAz(tabTitle);
        numberResults(tabTitle);
        $('#not-found').remove();
    });

    /* Count Bar - Speakers page */
    function numberResults(currentSelector) {
        var displayed = $(currentSelector).filter(":visible").length;
        $('#count-bar').text('Number of Results: '+displayed);
    }



/* A-Z Filter */

    var catLetters = [];
    
    // Add data-bookmark="" to .cat-item li
    $('.cat-item').each(function( index ) {
        var topic = $( this ).text();
        var firstLetter = topic.charAt(0);
        $(this).attr("data-bookmark", firstLetter);
        // catLetters[index] = firstLetter;
        // if ($.inArray(firstLetter, aZ) < 0) {
        //     aZ.push(firstLetter);
        // }
        // sortedAz = aZ.sort();
    });

      // Add data-bookmark="" to .pres-item
    $('.pres-item a').each(function( index ) {
        var presentation = $( this ).text();
        var firstLetter = presentation.charAt(0);
        $(this).attr("data-bookmark", firstLetter);
        $(this).parent().attr("data-bookmark", firstLetter);
    });

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
    $('.az-checkbox [type="checkbox"]').prop('checked', false);
    $('.two_third').on('change', '.az-checkbox [type="checkbox"]', function(event) {
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
            // if($("article").hasClass("az-filter")){
            //     // remove not found message
            //     $('#speaker-container > #not-found').remove();
            // } else {
            //     $('#speaker-container').prepend("<p id='not-found'>Sorry, we didn't find any speakers that fit your search criteria.</p>")
            // }
            // if($(".cat-item").hasClass("az-filter")){
            //     // remove not found message
            //     $('#topics > #not-found').remove();
            // } else {
            //     $('#topics').prepend("<p id='not-found'>Sorry, we didn't find any Topics that fit your search criteria.</p>")
            // }
            // if($(".pres-item").hasClass("az-filter")){
            //     // remove not found message
            //     $('#presentations > #not-found').remove();
            // } else {
            //     $('#presentations').prepend("<p id='not-found'>Sorry, we didn't find any Topics that fit your search criteria.</p>")
            // }
            $('article, .cat-item, .pres-item').each(function() {
                $('article, .cat-item, .pres-item').not('.az-filter').hide();
                $('.az-filter').show();
            });
        } else {
            $('#not-found').remove();
            $('article, .cat-item, .pres-item').each(function() {
                $('article, .cat-item, pres-item').show();
            });
        }
        getTabTitle();
        numberResults(tabTitle);
    });

/* End AZ Filter */



    /* jQuery Search Filter */

    $( "#custom-search" ).keyup(function() {
        var singleValues = $(this).val();
        $('article').removeClass('found').show();
        if($("article").hasClass("az-filter")){
            $(".az-filter .entry-wrapper:contains('" + singleValues + "')" ).parents('article').addClass("found"); 
        } else {
            $(".entry-wrapper:contains('" + singleValues + "')" ).parents('article').addClass("found");
        }
        $('.cat-item').removeClass('found').show();
        if($(".cat-item").hasClass("az-filter")){
            console.log('has class az filter');
            $(".az-filter:contains('" + singleValues + "')" ).addClass("found");
        } else {
            $(".cat-item:contains('" + singleValues + "')" ).addClass("found");
        }
        $('article').not(".found").hide();
        $('.cat-item').not(".found").hide();
        //$("#ptag").html( "<b>Single:</b> " + singleValues);
        getTabTitle();
        numberResults(tabTitle);
    });



    // Collapse
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

    // Link to jQuery Tabs

    // if($("#tabs") && document.location.hash) {
    //     console.log('hash');
    //     //$.scrollTo("#tabs");
    // }

    /* Front Page Search Filter */
    $( "#home-search" ).blur(function() {
        $('.search-dropdown-container').hide();
    });
    function searchSpeakers() {
        var singleValues = $('#home-search').val();
        $('.search-dropdown-container li').removeClass('found').show();
        if( $('#home-search').val() ) {
            console.log(singleValues);
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

    function init() {
        getTabTitle();
        createAz(tabTitle);
        numberResults(tabTitle);
    }
    init();
});


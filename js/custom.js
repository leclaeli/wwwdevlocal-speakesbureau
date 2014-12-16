jQuery(document).ready(function ($) {
    // allow jQuery's "containts" selector to not have to match cases
    $.expr[":"].contains = $.expr.createPseudo(function(arg) {
        return function( elem ) {
            return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
        };
    });


    /* A-Z Filter */

    $('.az-checkbox [type="checkbox"]').prop('checked', false);
    
    $('.az-checkbox [type="checkbox"]').change(function(){

        //Act on the event */
        letter = $(this).siblings('label').text();

        if ($(this).prop('checked')) {
            $('[data-bookmark='+letter+']').addClass("az-filter");
            $(this).siblings('label').addClass('checked');
            console.log(letter);
        } else {
            $('[data-bookmark='+letter+']').removeClass("az-filter");
            $(this).siblings('label').removeClass('checked');
            console.log(letter);
        }
    
        //iterate through array or object
        if ($('input:checkbox:checked').length > 0) {
            $('article').each(function() {
                $('article').not('.az-filter').hide();
                $('.az-filter').show();
                console.log('checked');
            });
        } else {
            $('article').each(function() {
                $('article').show();
                console.log('not checked');
            });
        } 
    });

    /* jQuery Search Filter */

    $( "#custom-search" ).keyup(function() {
        var singleValues = $(this).val();
        $('article').removeClass('found').show();
        if($("article").hasClass("az-filter")){
            $(".az-filter .entry-wrapper:contains('" + singleValues + "')" ).parents('article').addClass("found");
        } else {
            $(".entry-wrapper:contains('" + singleValues + "')" ).parents('article').addClass("found");
        }
        
        $('article').not(".found").hide();
        //$("#ptag").html( "<b>Single:</b> " + singleValues);
    });

//var listItem = $( "#post-35" );
//alert( "Index: " + listItem.index( "article" ) );
    
    // $("#primary").selectable({ 
    //     filter: "article",
    //      stop: function() {
    //         var result = $( "#select-result" ).empty();
    //         $( ".ui-selected").each(function() {
    //         var index = $( "#primary article" ).index( this );
    //         result.append( " #" + ( index + 1 ) );
    //         });
    //         } 
    // });

//  $(".entry-title").append('<span class="ui-icon ui-icon-circle-plus"></span>');

    
    // $("#primary").selectable( { 
    //     filter: '.ui-icon-circle-plus',
    //     selected: function() {
    //         $('#select-result').append('<p>Added</p>');
    //         $('.ui-selected').removeClass('ui-icon-circle-plus ui-selectee')
    //         .addClass('ui-icon-circle-minus');
    //     },
    //     cancel: '.ui-selected'
    // });


    // $( ".ui-icon" ).click(function() {
    // // `this` is the DOM element that was clicked
    // var index = $( ".ui-icon" ).index( this );
    // $( "#select-result" ).append( "<p>That was div index #" + index + "</p>");
    // });

    var title = $("article:nth-child(5)").text();
   
    $( ".ui-icon" ).toggle(function() {
        $(this).removeClass('ui-icon-circle-plus').addClass('ui-icon-circle-minus');
        // `this` is the DOM element that was clicked
        var index = $( ".ui-icon" ).index( this );
        $( "#select-result" ).append( "<p class='" + index + "'>" + index + "</p>");

        }, function() {
        $(this).removeClass('ui-icon-circle-minus').addClass('ui-icon-circle-plus');
        var index = $( ".ui-icon" ).index( this );
    $('.'+index).remove();
    });

    /* jQuery Ui Tabs */

    $(function() {
        $( "#tabs" ).tabs();
    });

    /* Front Page Search Filter */
    $( "#home-search" ).blur(function() {
        $('.search-dropdown-container').hide();
    });
    $( "#home-search" ).keyup(function() {
        var singleValues = $(this).val();
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
    });

    /* Move Tag Cloud */
    $( ".tag-cloud p" ).replaceWith( $( "#tag-cloud" ) );
});


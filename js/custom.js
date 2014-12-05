jQuery(document).ready(function ($) {
    // allow jQuery's "containts" selector to not have to match cases
    $.expr[":"].contains = $.expr.createPseudo(function(arg) {
        return function( elem ) {
            return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
        };
    });

    // jquery filter
    $( "#custom-search" ).keyup(function() {
        $('article').removeClass('found').show();
        var singleValues = $(this).val();
        $("#ptag").html( "<b>Single:</b> " + singleValues);
        $(".entry-wrapper:contains('" + singleValues + "')" )
        .parents('article').addClass("found");
        $('article').not(".found").hide();
    });

    /* A-Z Filter */

    $('[type="checkbox"]').prop('checked', false);
    
    $('[type="checkbox"]').change(function(){

        /* Act on the event */

        letter = $(this).siblings('label').text();

        if ($(this).prop('checked')) {
            $('[data-bookmark='+letter+']').addClass("az-filter");
            console.log(letter);
        } else {
            $('[data-bookmark='+letter+']').removeClass("az-filter");
            console.log(letter);
        }
    
        /* iterate through array or object */
    
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

    $( "#home-search" ).keyup(function() {
        if( $('#home-search').val() ) {
            $('.search-dropdown-container').show();
        } else {
            $('.search-dropdown-container').hide();
        }
        $('.search-dropdown-container li').removeClass('found').show();
        var singleValues = $(this).val();
        $(".search-dropdown-container li:contains('" + singleValues + "')" ).addClass("found");
        $('.search-dropdown-container li').not(".found").hide();
    });

});


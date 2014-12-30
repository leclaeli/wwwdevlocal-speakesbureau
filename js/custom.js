jQuery(document).ready(function ($) {
    // allow jQuery's "containts" selector to not have to match cases
    $.expr[":"].contains = $.expr.createPseudo(function(arg) {
        return function( elem ) {
            return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
        };
    });


    /* A-Z Filter */
var catLetters = [];
var aZ = [];
sortedAz = [];
    // Add data-bookmark="" to .cat-item li
    $('.cat-item, .az-checkbox').each(function( index ) {
        var topic = $( this ).text();
        var firstLetter = topic.charAt(0);
        //console.log(topic + " " + firstLetter);
        $(this).attr("data-bookmark", firstLetter);
        catLetters[index] = firstLetter;
        //console.log(catLetters);
        if (catLetters[index] != catLetters[index-1]) {

        }
        if ($.inArray(firstLetter, aZ) < 0) {
            aZ.push(firstLetter);
        }
        sortedAz = aZ.sort();
    });

    $.each(sortedAz, function(index, val) {
         /* iterate through array or object 
         <span class='az-checkbox'><input type='checkbox' name='$first_char_lc' id='$first_char_lc'><label for='$first_char_lc'>$first_char_ln[$i]</label></span>";*/
         $('.az-filter').append('<span class="az-checkbox" data-bookmark="' + val + '"><input type="checkbox" name="' + val + '" id="' + val + '"><label for="' + val + '">' + val + '</label></span>');
    });
    $('.az-placeholder').remove();

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
            $('article, .cat-item').each(function() {
                $('article, .cat-item').not('.az-filter').hide();
                $('.az-filter').show();
                console.log('checked');
            });
        } else {
            $('article, .cat-item').each(function() {
                $('article, .cat-item').show();
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

    /* jQuery Ui Tabs */

    $(function() {
        $( "#tabs" ).tabs();
    });

    // Collapse
    $( "#tabs-collapse" ).tabs({
        show: { effect: "blind", duration: 800 },
        hide: { effect: "blind", duration: 800 },
        collapsible: true,
        active: false
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


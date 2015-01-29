jQuery(document).ready(function($) {
  var GreetingAll = jQuery("#GreetingAll").val();
  jQuery("#PleasePushMe").click(function(){ 
  //var formData = 'action=MyAjaxFunction' + $(this).serialize();
    jQuery.ajax(myAjax.ajaxurl,{
      type: "post",
      data: {
        action: 'MyAjaxFunction',
        GreetingAll: GreetingAll,
      },
      success: function(data, textStatus, XMLHttpRequest){
        jQuery("#test-div1").html('');
        jQuery("#test-div1").append(data);
      },
      error: function(MLHttpRequest, textStatus, errorThrown){
        alert(errorThrown);
      }
    });
  });
  $('#clickToLoad').on('click', function(e){
    //e.preventDefault();
    var link = $('#PaginationExample a').attr('href');
    var page = link.charAt(link.length-2);
    console.log(link + page);
    //jQuery('#tabs').html('Loading...');
    //jQuery('#speakers').load(link+' #speakers');
    var placeHolder = $('#speaker-container-' +page).load(link+' #speaker-container article');
    $('#PaginationExample li').load(link+' #PaginationExample a')
    $('#speaker-container-' +page).append(placeHolder);
    // jQuery.ajax(myAjax.ajaxurl,{
    //   type: "post",
    //   data: {
    //     link: link,
    //   },
    //   success: function(data, textStatus, XMLHttpRequest){
    //     jQuery("#test-div1").html('');
    //     jQuery("#test-div1").append(data);
    //   },
    //   error: function(MLHttpRequest, textStatus, errorThrown){
    //     alert(errorThrown);
    //   }
    // });
  });
  
    // disable presentation selection before speaker is selected
    $(".populate-posts select").prop("disabled", true);
    $("#gform_fields_6").on('change', '#input_6_3', function(){ 
      var spkPostId = $("#input_6_3").val();
      console.log(spkPostId);
      jQuery.ajax(myAjax.ajaxurl,{
        type: "post",
        data: {
          action: 'MyAjaxFunction',
          spkPostId: spkPostId,
        },
        success: function(data, textStatus, XMLHttpRequest){
          //jQuery("#test-div1").html('');
      
            $(".populate-posts select").empty();
            $('.chosen-drop .chosen-results').empty();
            var options = $.parseJSON(data);
            console.log(options);
                    for(i=0;i<options.length;i++){
                      $(".populate-posts select").append('<option value="'+options[i].value+'">'+options[i].text+'</option>');
                      $('.chosen-results').append('<li class="active-result result-selected" style="" data-option-array-index="i">' +options[i].text+ '</li>');
                    }
            $(".populate-posts select").prop("disabled", false);
            $('.populate-posts select').trigger('chosen:updated');
            //$("#input_6_2_chosen").prop("disabled", false);
            // $("#input_6_2_chosen").removeClass('chosen-disabled');
        },
        error: function(MLHttpRequest, textStatus, errorThrown){
          alert(errorThrown);
        }
      });
    });

});
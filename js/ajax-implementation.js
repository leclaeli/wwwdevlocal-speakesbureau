jQuery(document).ready(function($) {
  
    // disable presentation selection before speaker is selected
    $(".populate-posts select").prop("disabled", true);
    $("#gform_fields_3").on('change', '#input_3_1', function(){ 
      var spkPostId = $("#input_3_1").val();
      console.log(spkPostId);
      jQuery.ajax(myAjax.ajaxurl,{
        type: "post",
        data: {
          action: 'MyAjaxFunction',
          spkPostId: spkPostId,
        },
        success: function(data, textStatus, XMLHttpRequest){

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
        },
        error: function(MLHttpRequest, textStatus, errorThrown){
          alert(errorThrown);
        }
      });
    });


    $("#gform_fields_4").on('change', '#input_4_16', function(){ 
      var eventIDstr = $("#input_4_16").val();
      var eventID = eventIDstr.substring( eventIDstr.indexOf('-') + 1 );
      jQuery.ajax(myAjax.ajaxurl,{
        type: "post",
        data: {
          action: 'newAjaxFunction',
          eventID: eventID,
        },
        success: function(data, textStatus, XMLHttpRequest){

            var newResults = $.parseJSON(data);
            console.log(newResults);
            $('#input_4_1').val( newResults );
        },
        error: function(MLHttpRequest, textStatus, errorThrown){
          alert(errorThrown);
        }
      });
    });

});
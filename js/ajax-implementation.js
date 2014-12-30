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
  jQuery('#PaginationExample a').live('click', function(e){
    e.preventDefault();
    var link = jQuery(this).attr('href');
    var page = link.charAt(link.length-2);
    console.log(page);
    //jQuery('#tabs').html('Loading...');
    //jQuery('#speakers').load(link+' #speakers');
    var placeHolder = jQuery('#speaker-container-2').load(link+' #speaker-container');
    $('#PaginationExample a').load(link+' #PaginationExample a')
    jQuery('#speaker-container-2').append(placeHolder);
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
});
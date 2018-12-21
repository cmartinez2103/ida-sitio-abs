$(document).ready(function(){

  $('body').on('click','#btn-form-message',function(){
    var formData = $('#admision-message').serializeArray();
        formData.push({name:'action',value: 'form-ajax-nonce'});
        formData.push({name:'security',value:$('#form-ajax-nonce').val()});
        formData.push({name:'message',value:tmce_getContent('tiny')});


        $('#btn-form-message').addClass('button--loading');

    $.post(data.base_url + 'message', $.param(formData),function(json){

      json = JSON.parse(json);

      if(json.code == 422){
        for(input in json.data){
          $('[name='+input+']').addClass('invalid-input').parents('.form-control').attr('data-error-message',json.data[input]).addClass('form-control--invalid');
          $('[name='+input+']').siblings('.form-control__text').hide();
          removeClass($('[name='+input+']'));
        }
      }

      if(json.code == 200){
        $('#msj_message').html('<div class="message message--ghost-success" data-module="message"> <div class="message__body"> <p>'+json.msg+'</p> </div> <button class="message__close-button" data-role="close"></button> </div> ');
        $('#admision-message')[0].reset();
      }

      if(json.code == 500){
        $('#msj_message').html('<div class="message message--ghost-danger" data-module="message"> <div class="message__body"> <p>'+json.msg+'</p> </div> <button class="message__close-button" data-role="close"></button> </div>');
      }

      setTimeout(function () {
        $('#msj_message .message').remove();
      }, 4000);

      $('#btn-form-message').removeClass('button--loading');
    });
    return false;
  });


  function removeClass(input){
    setTimeout(function () {
      input.siblings('.form-control__text').show(); //added
      input.removeClass('invalid-input').parents('.form-control').removeClass('form-control--invalid');
    }, 4000);
  }

  function tmce_getContent(editor_id, textarea_id) {
  if ( typeof editor_id == 'undefined' ) editor_id = wpActiveEditor;
  if ( typeof textarea_id == 'undefined' ) textarea_id = editor_id;

  if ( jQuery('#wp-'+editor_id+'-wrap').hasClass('tmce-active') && tinyMCE.get(editor_id) ) {
    return tinyMCE.get(editor_id).getContent();
  }else{
    return jQuery('#'+textarea_id).val();
  }
}
});

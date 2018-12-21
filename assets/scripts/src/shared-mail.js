$(document).ready(function(){
    $('body').on('click','#form-shared-email .button',function(){
      var button = $(this);
      var formData = $('body').find('#form-shared-email').serializeArray();
          formData.push({name:'url',value: $('#btn-active-modal-emails').data('url')});
          formData.push({name:'title',value: $('#btn-active-modal-emails').data('title')});

      button.addClass('button--loading');

      $.post(data.base_url + 'shared-emails-post', $.param(formData),function(json){
         json = JSON.parse(json);
         var input = [];
         console.log(json);
        if(json.code == 422){
          for(input in json.data){
            $('#form-shared-email [name='+input+']').addClass('invalid-input').parents('.form-control').attr('data-error-message',json.data[input]).addClass('form-control--invalid');
            $('#form-shared-email [name='+input+']').siblings('.form-control__text').hide();
            removeClass($('#form-shared-email [name='+input+']'));
          }
        }

        if(json.code == 200){
          $('#section-form-shared-email').hide();
          $('#section-shared-email-exito').addClass('exito');
          $('#section-shared-email-exito').show();
        }

        button.removeClass('button--loading');
      });

      return false;
    });

    function removeClass(input){
      setTimeout(function () {
        input.siblings('.form-control__text').show(); //added
        input.removeClass('invalid-input').parents('.form-control').removeClass('form-control--invalid');
      }, 4000);
    }
});

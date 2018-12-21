$(document).ready(function(){

  $('body').on('click','#btn-form-contact',function(){
    var formData = $('#admision-contacto').serializeArray();
        formData.push({name:'action',value: 'form-ajax-nonce'});
        formData.push({name:'security',value:$('#form-ajax-nonce').val()});

        $('#btn-form-contact').addClass('button--loading');
        console.log(formData);
    $.post(data.base_url + 'contact', $.param(formData),function(json){

      json = JSON.parse(json);
      var input = [];

      if(json.code == 422){
        for(input in json.data){
          $('[name='+input+']').addClass('invalid-input').parents('.form-control').attr('data-error-message',json.data[input]).addClass('form-control--invalid');
          $('[name='+input+']').siblings('.form-control__text').hide();
          removeClass($('[name='+input+']'));
        }
      }

      if(json.code == 200){
         $('#admision-contacto').hide();
         $('.form-response').show();
         $('.form-response').addClass('exito');
         $('.form-response__title').append('¡Tu mensaje ha sido enviado con éxito!');
         $('.form-response__excerpt').append(json.msg);
      }

      if(json.code == 500){
         $('#admision-contacto').hide();
         $('.form-response').show();
         $('.form-response').addClass('error');
         $('.form-response__title').append('¡Lo sentimos, tu mensaje no ha podido ser enviado!');
         $('.form-response__excerpt').append(json.msg);
      }

      $('#btn-form-contact').removeClass('button--loading');
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

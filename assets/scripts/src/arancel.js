$(document).ready(function(){

  $('.ad-event').on('click',function(){
    var tabActive = $('.form-pasos--button.active').data('target');
    var tabNext = $(this).data('target');
    var button = $(this);
    button.addClass('button--loading');

    if(tabActive == 'postulacion-alumno')
    validate_admision_alumno(button,tabNext);

    if(tabActive == 'postulacion-apoderado')
    validate_admision_apoderado(button,tabNext);

    return false;
  });

  function validate_admision_alumno(button,tabNext){
    var tab = $('.form-pasos--target[data-tabname=postulacion-alumno]');
    var formData = $('#postulacion-alumno').serializeArray();
    formData.push({name:'form',value: 'alumno'});
    console.log(formData);
    $.ajax({ url: data.base_url + 'postulacion', method: "POST", data:$.param(formData)})
    .done(function(json) {
      json = JSON.parse(json);
      var input = [];
      if(json.code == 422){
         console.log(json);
        for(input in json.data){
          $('[name='+input+']').addClass('invalid-input').parents('.form-control').attr('data-error-message',json.data[input]).addClass('form-control--invalid');
          $('[name='+input+']').siblings('.form-control__text').hide();
          removeClass($('[name='+input+']'));
        }
      }
      if(json.code == 200){
        tab.data('validate',true);
        nextTab(tabNext);
      }

      button.removeClass('button--loading');
    });
  }

  function validate_admision_apoderado(button,tabNext){
    var tab = $('.form-pasos--target[data-tabname=postulacion-apoderado]');
    var formData = $('#postulacion-alumno').serializeArray();
    formData = formData.concat($('#postulacion-apoderado').serializeArray());
    formData.push({name:'form',value: 'all'});
   console.log(formData);
    $.ajax({ url: data.base_url + 'postulacion', method: "POST", data:$.param(formData)})
    .done(function(json) {
      json = JSON.parse(json);
      var input = [];
      if(json.code == 422){
        for(input in json.data){
            $('#postulacion-apoderado [name='+input+']').addClass('invalid-input').parents('.form-control').attr('data-error-message',json.data[input]).addClass('form-control--invalid');
            $('#postulacion-apoderado [name='+input+']').siblings('.form-control__text').hide();
            removeClass($('#postulacion-apoderado [name='+input+']'));
        }
      }
      if(json.code == 200){
         $('#postulacion-apoderado').hide();
         $('.form-response').show();
         $('.form-response').addClass('exito');
         $('.form-response__title').append('¡Tu mensaje ha sido enviado con éxito!');
         $('.form-response__excerpt').append(json.msg);
      }

      if(json.code == 500){
         $('#postulacion-apoderado').hide();
         $('.form-response').show();
         $('.form-response').addClass('error');
         $('.form-response__title').append('¡Lo sentimos, tu mensaje no ha podido ser enviado!');
         $('.form-response__excerpt').append(json.msg);
      }

      button.removeClass('button--loading');
    });
  }

  function nextTab(tabNext){
    $('.form-pasos--target.active').removeClass('active');
    $('.form-pasos--button.active').removeClass('active');

    $('.form-pasos--target[data-tabname='+tabNext+']').addClass('active');
    $('.form-pasos--button[data-target='+tabNext+']').addClass('active');
  }

  $('select[name=curso]').on('change',function(){
      var curso = $(this).val();
  });

  function removeClass(input){
    setTimeout(function () {
      input.siblings('.form-control__text').show(); //added
      input.removeClass('invalid-input').parents('.form-control').removeClass('form-control--invalid');
    }, 4000);
  }
});

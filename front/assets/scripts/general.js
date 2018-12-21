$(document).ready(function () {

   var posicionActual = 0;

   $(window).scroll(function(){
      scroll = $(this).scrollTop()>100;
      if (scroll) {
         $('.share').show('slow');
      }else if(scroll < posicionActual) {
         $('.share').hide('slow');
         console.log('retrocediendo');
      }else {
         $('.share').hide('slow');
      }

   });
});

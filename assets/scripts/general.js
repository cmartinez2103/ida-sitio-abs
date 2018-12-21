$(document).ready(function () {
   //
   // var posicionActual = 0;
   //
   // $(window).scroll(function(){
   //    scroll = $(this).scrollTop()>100;
   //    if (scroll) {
   //       $('.share').show('slow');
   //    }else if(scroll < posicionActual) {
   //       $('.share').hide('slow');
   //       console.log('retrocediendo');
   //    }else {
   //       $('.share').hide('slow');
   //    }
   //
   // });

   $('[data-module="collapse-body"]').hide();
   $('[data-action="collapse-deploy"]').click(function () {
      $(this).siblings('[data-module="collapse-body"]').slideToggle();
      $(this).toggleClass('active');
   });
});

$(document).ready(function (e) {
   function t(t) {
       e(t).bind("click", function (t) {
           t.preventDefault();
           e(this).parent().fadeOut()
       })
   }
   e(".dropdown-toggle").click(function () {
       var t = e(this).parents(".button-dropdown").children(".dropdown-menu").is(":hidden");
       e(".button-dropdown .dropdown-menu").hide();
       e(".button-dropdown .dropdown-toggle").removeClass("active");
       if (t) {
           e(this).parents(".button-dropdown").children(".dropdown-menu").toggle().parents(".button-dropdown").children(".dropdown-toggle").addClass("active")
       }
   });
   e(document).bind("click", function (t) {
       var n = e(t.target);
       if (!n.parents().hasClass("button-dropdown")) e(".button-dropdown .dropdown-menu").hide();
   });
   e(document).bind("click", function (t) {
       var n = e(t.target);
       if (!n.parents().hasClass("button-dropdown")) e(".button-dropdown .dropdown-toggle").removeClass("active");
   })
});

$(document).ready(function () {
   $('.button-test').on('click', function(){

      //CAMBIAR $(this) por $button y $('#'+ $(this).attr('data-target')) por $target
      var $button = $(this),
         $target = $('[data-tab-name="' + $(this).attr('data-target') + '"]'); //attr('data-target') por data.('target')
         console.log($('#'+ $(this).attr('data-target')));

      $("[data-nivel='"+$(this).attr('data-nivel')+"']").removeClass('active');
      $('#'+ $(this).attr('data-target')).siblings().removeClass('active');

      if ($('#'+ $(this).attr('data-target')).hasClass('active')) {
         $(this).removeClass('active')
      }else {
         $(this).addClass('active')
      }

      $('#'+ $(this).attr('data-target')).toggleClass('active');

   })
});

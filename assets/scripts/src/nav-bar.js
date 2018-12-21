(function (window, document, $) {
   "use strict";

   var NavBar = function (element) {
      this.$navBar = $(element);
      this.$navBarBody = this.$navBar.find('[data-role="nav-body"]');
      this.$navBarDeployer = this.$navBar.find('[data-role="nav-deployer"]');
      this.$navBarDeployer.on('click.NavBar', this.toggleNavBar.bind(this));
      var offset = this.$navBar.data('offtop');
      var stopper = $(this.$navBar.data('stopper')).height();
      var status;

      if (stopper === undefined || stopper == false) {
         status = false;
      } else {
         status = true;
      }

      $(window).scroll(function () {
         var scroll = this.pageYOffset || document.documentElement.scrollTop;
         var scrollHeight = $(document).height();
         var scrollPosition = $(window).height() + $(window).scrollTop();
         // var scrollzero = (scrollHeight - scrollPosition) / scrollHeight;
         var scrollstop = scrollHeight - stopper;
         var stop = (scrollstop - scrollPosition) / scrollHeight;
         var returner;

         status == false ? returner = true : returner = stop > 0;

         if (scroll >= offset && returner == true) {
            $('body').addClass('scrolled');
            $('body').removeClass('no-scrolled');
         } else {
            $('body').addClass('no-scrolled');
            $('body').removeClass('scrolled');
         }
      });

		this.touchSubmenus();

      //WATCH
      this.$searchBarBody = $('body').find('[data-role="search-body"]');
      this.$searchBarDeployer = $('body').find('[data-role="search-deployer"]');
      this.$searchBarDeployer.on('click.NavBar', this.toggleExtra.bind(this));

      return this;
   };

   NavBar.prototype = {
      toggleNavBar: function (event) {
         event.preventDefault();
         this.$navBarDeployer.toggleClass('deployed');
         this.$navBarBody.toggleClass('deployed');
         //WATCH
			$('body').toggleClass('deployed--nav').removeClass('scrolled');
			this.$searchBarDeployer.removeClass('deployed');
			this.$searchBarBody.removeClass('deployed');
			$('body').removeClass('deployed--search');
      },

      toggleExtra: function (event) {
         event.preventDefault();
         this.$searchBarDeployer.toggleClass('deployed');
			this.$searchBarBody.toggleClass('deployed');
			$('body').toggleClass('deployed--search').removeClass('scrolled');

			this.$navBarDeployer.removeClass('deployed');
			this.$navBarBody.removeClass('deployed');
			$('body').removeClass('deployed--nav');
      },

      touchSubmenus: function () {
         // if (!Modernizr.touchevents) {
         //    return;
         // }
         var $touchSubmenus = $('body').find('[data-role="touch-submenu"]');

         $touchSubmenus.on('click', '[data-role="touch-submenu-deployer"]', function (e) {
            event.preventDefault();
				// console.log('clicked');
            var $current = $(e.currentTarget),
                $currentParent = $current.parents('[data-role="touch-submenu"]');
            $current.toggleClass('deployed');
            $currentParent.toggleClass('deployed');
         });
      }
   };

   $.fn.navBar = function () {
      if (this.data('navBar')) {
         return this.data('navBar');
      }
      return this.each(function (i, el) {
         $(el).data('navBar', (new NavBar(el)));
      });
   };

   // self initialization
   $(document).ready(function () {
      $('[data-module="nav-bar"]').navBar();
   });

}(window, document, jQuery));

jQuery(function(){jQuery(".dropdown-menu > li > a").on("click",function(e){var n=jQuery(this).parent(),o=jQuery(this).parent().parent();jQuery.parent.toggleClass("open"),o.find(".open").not(n).toggleClass("open"),e.stopPropagation()}),jQuery("li.dropdown > a").not("li.dropdown li.dropdown > a").on("click",function(){jQuery(this).find(".dropdown").find(".sub-menu:visible").hide()}),jQuery("#blect-mmenu").mmenu({wrappers:["bootstrap4"],offCanvas:{position:"right",zposition:"front"}});var e=jQuery("#blect-mmenu").data("mmenu");jQuery(".hamburger").click(function(){e.open()}),jQuery(".navbar-blect-collapse").on("show.bs.collapse",function(){jQuery("#hamburger").addClass("is-active")}),jQuery(".navbar-blect-collapse").on("hide.bs.collapse",function(){jQuery("#hamburger").removeClass("is-active")})});
//# sourceMappingURL=./application-min.js.map
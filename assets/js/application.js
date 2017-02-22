$(function() {
	//////////////////////////////////
	// Bootstrap 3rd level dropdown //
	//////////////////////////////////
	$(".dropdown-menu > li > a").on("click",function(e){
		var current		=	$(this).next();
		var $parent 		=	$(this).parent()
		var $grandparent =	$(this).parent().parent();

		$parent.toggleClass('open');

		$grandparent.find('.open').not($parent).toggleClass('open')
		e.stopPropagation();
	});
	$("li.dropdown > a").not('li.dropdown li.dropdown > a').on("click",function(){
		var root=$(this).find('.dropdown');
		root.find('.sub-menu:visible').hide();
	});
	///////////
	// MMenu //
	///////////
	// jQuery( '#blect-mmenu' ).mmenu({
	// 	offCanvas: {
 //           	position  : "right",
 //           	zposition : "front"
 //        }
	// });


	/////////////////////
	// Related Module //
	/////////////////////
	// var $related = jQuery('#related.floating');
	// var $relatedCloseBtn = jQuery('#related .close');
	// var $content = jQuery('#content');
	// var $contentOffset = $content.offset();
	// //console.log($contentOffset.top);
	// if( window.innerWidth < 992 ){
	// 	setRelatedToStatic();
	// }

	// $relatedCloseBtn.on( 'click', closeRelated );
	// function setRelatedToStatic(){
	// 	$related.removeClass( 'floating' ).addClass( 'static' );
	// }
	// function setRelatedToFloating(){
	// 	$related.addClass( 'floating' ).removeClass( 'static' );
	// }
	// function openRelated(){
	// 	if( ! $related.hasClass('floating')) return;
	// 	//console.log('open now');
	// 	$related.removeClass('away');
	// }
	// function hideRelated(){
	// 	if( ! $related.hasClass('floating')) return;
	// 	//console.log('hide now');
	// 	$related.addClass('away');
	// }
	// function closeRelated(){
	// 	if( ! $related.hasClass('floating')) return;
	// 	//console.log('close now');
	// 	$related.fadeOut( 400, function(){
	// 		$related.addClass('away static noMoreFloating').removeClass('floating').slideDown();
	// 	});
	// }




	//////////////////
	// EventListen //
	//////////////////
	//window.addEventListener('scroll', windowScrolling, false);
	// function windowScrolling( e ){
	// 	if( $related.hasClass('floating')){
	// 		if( window.pageYOffset > $contentOffset.top ){
	// 			//console.log('bingo');
	// 			openRelated();
	// 		}else{
	// 			hideRelated();
	// 		}
	// 	}
	// }
	// $(window).resize( function(){
	// 	if( window.innerWidth < 992 ){
	// 		setRelatedToStatic();
	// 	}else{
	// 		if( ! $related.hasClass( 'noMoreFloating' ) ){
	// 			setRelatedToFloating();
	// 		}
	// 	}
	// });

	////////////////////////////
	// #masthead parallaxing //
	////////////////////////////
	// var $masthead = jQuery( '#masthead' );
	// var $masthead_height = $masthead.outerHeight();


	// window.addEventListener('scroll', parallaxing, false);

	// function parallaxing( e ){
	// 	if ( window.pageYOffset <= $masthead_height ){
	// 		console.log ( (  50 - window.pageYOffset / $masthead_height * 100 ) ) );
	// 		$masthead.css( 'background-position', 'center ' + ( 50 - window.pageYOffset / $masthead_height * 100 ) + '%' );
	// 	}
	// }

});

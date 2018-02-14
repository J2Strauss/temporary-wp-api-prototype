$(document).ready(function(){

	// Remove loading class
	$('body').removeClass('loading');

	// Syntax highlighter on load
	prism();

	// Scroll to links that don't have URL
	scrollToLinks();

	// Add admin-link to Wordpress link to prevent Barba
 	$('a').each( function() {
       
        if ( this.href.indexOf('/wp-admin/') !== -1 || 
             this.href.indexOf('/wp-login.php') !== -1 ) {
            $(this).addClass( 'admin-link' );
        }
    });

	Barba.Pjax.originalPreventCheck = Barba.Pjax.preventCheck;

	Barba.Pjax.preventCheck = function(evt, element) {
		if (!Barba.Pjax.originalPreventCheck(evt, element)) {
			return false;
		}

		// No need to check for element.href -
		// originalPreventCheck does this for us! (and more!)
		if (/.pdf/.test(element.href.toLowerCase())) {
			return false;
		}

		if (element.classList.contains('caret')){
			return false;
		}

		if (element.classList.contains('admin-link')){
			return false;
		}

		// if ($('li').hasClass('expandable-menu')){
		// 	return false;
		// }

		return true;
	};
	Barba.Pjax.Dom.wrapperId = 'content';
	Barba.Pjax.Dom.containerClass = 'content-container';
	Barba.Pjax.start();


	Barba.Dispatcher.on('linkClicked', function() {
  		$('body').removeClass('page-loaded').addClass('page-loading');
	});
	Barba.Dispatcher.on('newPageReady', function(currentStatus, oldStatus, container) {

		setTimeout(function(){
  			$('body').removeClass('page-loading').addClass('page-loaded');
		}, 500);

		// Syntax highlighter on after page load
		prism();

		// Accordion component
		accordion();

	});
});




});
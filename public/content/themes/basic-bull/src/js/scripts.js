$(document).ready(function(){

	// Remove loading class
	$('body').removeClass('loading');


	// Syntax highlighter on load
	prism();

	// Scroll to links that don't have URL
	scrollToLinks();

	// Accordions
	accordions();

	// Add admin-link to Wordpress link to prevent Barba
 	$('a').each( function() {
       
        if ( this.href.indexOf('/wp-admin/') !== -1 || 
             this.href.indexOf('/wp-login.php') !== -1 ) {
            $(this).addClass( 'admin-link' );
        }
    });
	
	var tag = document.createElement('script');
	tag.src = "https://www.youtube.com/iframe_api";
	var firstScriptTag = document.getElementsByTagName('script')[0];
	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

   
	

	// Barba.Pjax.originalPreventCheck = Barba.Pjax.preventCheck;

	// Barba.Pjax.preventCheck = function(evt, element) {
	// 	if (!Barba.Pjax.originalPreventCheck(evt, element)) {
	// 		return false;
	// 	}

	// 	// No need to check for element.href -
	// 	// originalPreventCheck does this for us! (and more!)
	// 	if (/.pdf/.test(element.href.toLowerCase())) {
	// 		return false;
	// 	}

	// 	if (element.classList.contains('caret')){
	// 		return false;
	// 	}

	// 	if (element.classList.contains('admin-link')){
	// 		return false;
	// 	}

	// 	// if ($('li').hasClass('expandable-menu')){
	// 	// 	return false;
	// 	// }

	// 	return true;
	// };
	// Barba.Pjax.Dom.wrapperId = 'content';
	// Barba.Pjax.Dom.containerClass = 'content-container';
	// Barba.Pjax.start();


	// Barba.Dispatcher.on('linkClicked', function() {
 //  		$('body').removeClass('page-loaded').addClass('page-loading');
	// });
	// Barba.Dispatcher.on('newPageReady', function(currentStatus, oldStatus, container) {

	// 	setTimeout(function(){
 //  			$('body').removeClass('page-loading').addClass('page-loaded');
	// 	}, 500);

	// 	// Syntax highlighter on after page load
	// 	prism();

	// 	// Accordion component
	// 	accordion();

	// });
	
});

function onYouTubeIframeAPIReady() {
    
    var players = document.querySelectorAll('.embed-background .background-video');
    
    for (var i = 0; i < players.length; i++) {
        new YT.Player(players[i], {
        	videoId: players[i].dataset.id,
            playerVars: {
            	'autoplay': 1,
				'controls': 0,
				'modestbranding': 1,
				'loop': 1,
				'showinfo': 0,
				'cc_load_policy': 0,
				'iv_load_policy': 3,
				'autohide': 0,
				'rel': 0,
				'playsinline': 1,
				'enablejsapi': 1,
				'playlist': players[i].dataset.id,
            },
			events: {
				'onReady' : onPlayerReady
			}
        });

        function onPlayerReady(e) {
		    e.target.mute();
		   $(e.target.getIframe()).css({
		  //   	"min-width": "100%",
				// "position": "absolute",
				// "padding-bottom" : "56%",
				// "top": "50%",
				// "left": "50%",
				// "transform": "translate(-50%, -50%)",
		    })
		    $('.background-component').addClass('playing-video');
		   
		}

    }

     

}

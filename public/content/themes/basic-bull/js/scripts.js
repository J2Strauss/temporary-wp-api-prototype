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

		
	var clndr = {};

	$( function() {

	  // PARDON ME while I do a little magic to keep these events relevant for the rest of time...
	  var currentMonth = moment().format('YYYY-MM');
	  var nextMonth    = moment().add('month', 1).format('YYYY-MM');

	 $.ajax({
		url: 'http://wordpress.localhost/wp-json/wp/v2/events?filter[meta_key]=event_start_date&filter[orderby]=meta_value_num&order=asc',
		dataType: 'json',
		success: function(result) {
		 	
		 	var eventObject= "[";
		 	var number = "";
		 	$.each(result, function (i, value) {
		 		number+= i;
		 		eventObject+= '{',
		 		eventObject+= 'date: "' + value.acf.event_start_date +'",',
                eventObject+= 'title: "' + value.title.rendered +'",',
                eventObject+='startDate: "' + value.acf.event_start_date +'",',
                eventObject+='endDate: "' + value.acf.event_end_date +'",',
                eventObject+='startTime: "' + value.acf.event_start_time +'",',
                eventObject+= 'endTime: "' + value.acf.event_end_time+'"'
                for(var i=0; i < result.length; i++) {
					if(i === length-1) {  //The last one
						eventObject+= '}'
					} else {
						eventObject+= '},'
					} 
				}
            });
            console.log(number);
            eventObject+= ']';
            
            console.log(eventObject);
            console.log(result);

	    //       var events = [
			  //   { date: currentMonth + '-' + '10', title: 'Persian Kitten Auction', location: 'Center for Beautiful Cats' },
			  //   { date: currentMonth + '-' + '19', title: 'Cat Frisbee', location: 'Jefferson Park' },
			  //   { date: currentMonth + '-' + '23', title: 'Kitten Demonstration', location: 'Center for Beautiful Cats' },
			  //   { date: nextMonth + '-' + '07',    title: 'Small Cat Photo Session', location: 'Center for Cat Photography' }
			  // ];

			// var events = $.parseJSON(result); //parse JSON

			// var output="<ul>";
			// for (var i in events) {
			// 	output+="<li>" + events[i].id + "</li>";
			// }
			// output+="</ul>";


			// console.log(output);
			 clndr = $('#calendar').clndr({
			    template: $('#calendar-template').html(),
			    events: result,
			    forceSixRows: true
			  });
		}
	});

	

	  // $('#clndr-4').clndr({
	  //   template: $('#clndr-4-template').html(),
	  //   events: events,
	  //   lengthOfTime: {
	  //     days: 7,
	  //     interval: 7
	  //   }
	  // });
	});

	
	

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

//# sourceMappingURL=maps/scripts.js.map

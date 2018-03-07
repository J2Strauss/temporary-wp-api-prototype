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
			 	
			 	var number = "";
			 	var eventObject= "";
			 	eventObject+= "[";
			 	$.each(result, function (i, value) {
			 		number = result.length;
			 		eventObject+= '{',
			 		eventObject+= '"date": "' + value.acf.event_start_date +'", ',
	                eventObject+= '"title": "' + value.title.rendered +'", ',
	                eventObject+= '"startDate": "' + value.acf.event_start_date +'", ',
	                eventObject+= '"endDate": "' + value.acf.event_end_date +'", ',
	                eventObject+= '"startTime": "' + value.acf.event_start_time +'", ',
	                eventObject+= '"endTime": "' + value.acf.event_end_time +'", ',
	                eventObject+= '"location": "' + value.acf.event_location+'"'
					if(i == number-1) {  //The last one
						eventObject+= '}'
					} else {
						eventObject+= '},'
					} 
	            });
	            eventObject+=']';
	            var eventData = $.parseJSON(eventObject);
	            console.log(eventData);
				clndr = $('#calendar').clndr({
					template: $('#calendar-template').html(),
					events: eventData,
					forceSixRows: true,
					clickEvents: {
					    click: function(target) {
							// make a <ul>
							var markup = '<ul>';
							// loop through the events, making a <div> for each with relevation info
							for(var i = 0; i < target.events.length; i++) {
								markup += '<div class="event">' + target.events[i].title + 'at ' + target.events[i].location + '</div>';
							}
							// close the </ul>
							markup += '</ul>';
							// put your new markup in the events container!
							$('.day-event-listing').empty();
							$(event.target).next('.day-event-listing').html( markup );
						}
				  	}
				});
			}
		});
	 
	});
	
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

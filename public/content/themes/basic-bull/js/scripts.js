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

	

	// Fire clndr.js if element exists
    if ( $('#calendar').length ) {

    	var clndr = {};
		var currentMonth = moment().format('YYYY-MM');
		var nextMonth    = moment().add('month', 1).format('YYYY-MM');
		var $eventsContainer = $('#events-container');

    	calenderFunction();

    	$('.event-filter').on('click', function(e){

    		e.preventDefault();

    		$eventsContainer.addClass('loading-events');

    		if ( !$(this).hasClass('reset-events') ) {

    			$filterCategory = '&filter['+$(this).data('type')+']';
		   		$categorySlug = '='+$(this).data('category-slug');

    		} else {

    			$filterCategory = "";
				$categorySlug = "";

    		};
    		
    		$.ajax({
				url: 'http://wordpress.localhost/wp-json/wp/v2/events?filter[meta_key]=event_start_date&filter[orderby]=meta_value_num&order=asc'+$filterCategory+$categorySlug,
				dataType: 'json',
				success: function(result) {
				 	
					// Events object
				 	var number = "";
				 	var eventObject= "";
				 	eventObject+= "[";
				 	
				 	$.each(result, function (i, value) {
				 		
				 		// Total number of events to determine last one
				 		number = result.length;

				 		// If post does not have image
				 		if (value.acf.event_image == false) {
				 			eventImageThumbnail = "";
				 			eventImageLarge = "";
				 		} else {
				 			if (value.acf.event_image.mime_type == "image/gif") {
				 				eventImageThumbnail = value.acf.event_image.url;
				 				eventImageLarge = value.acf.event_image.url;
				 			} else {
				 				eventImageThumbnail = value.acf.event_image["sizes"]["thumbnail_horizontal"];
				 				eventImageLarge = value.acf.event_image["sizes"]["large_horizontal"];	
				 			}
				 		}

				 		eventObject+= '{',
				 		eventObject+= '"date": "' + value.acf.event_start_date +'", ',
				        eventObject+= '"title": "' + value.title.rendered +'", ',
				        eventObject+= '"excerpt": "' + value.acf.event_excerpt +'", ',
				        eventObject+= '"imageUrl": "' + value.acf.event_image.url +'", ',
				        eventObject+= '"imageThumbnail": "' + eventImageThumbnail +'", ',
				        eventObject+= '"imageLarge": "' + eventImageLarge +'", ',
				        eventObject+= '"imageAlt": "' + value.acf.event_image.alt +'", ',
				        eventObject+= '"startDate": "' + value.acf.event_start_date +'", ',
				        eventObject+= '"endDate": "' + value.acf.event_end_date +'", ',
				        eventObject+= '"startTime": "' + value.acf.event_start_time +'", ',
				        eventObject+= '"endTime": "' + value.acf.event_end_time +'", ',
				        eventObject+= '"location": "' + value.acf.event_location +'", ',
				        eventObject+= '"streetAddress": "' + value.acf.event_street_address +'", ',
				        eventObject+= '"city": "' + value.acf.event_city +'", ',
				        eventObject+= '"state": "' + value.acf.event_state +'", ',
				        eventObject+= '"zipCode": "' + value.acf.event_zip_code +'", ',
				        eventObject+= '"categoryName": "' + value.acf.event_category.name +'", ',
				        eventObject+= '"categorySlug": "' + value.acf.event_category.slug +'", ',
				        eventObject+= '"link": "' + value.link+'"'
						if(i == number-1) {  //The last one
							eventObject+= '}'
						} else {
							eventObject+= '},'
						} 
				    });

				    eventObject+=']';

				    var eventData = $.parseJSON(eventObject);

				    clndr.setEvents(eventData);

				    setTimeout(function(){
  						
  						$eventsContainer.removeClass('loading-events');

					}, 1000);

				}
			});

    	});

		

		

	 	function calenderFunction(options) {

	 		$eventsContainer.addClass('loading-events');

	 		// Default filter parameters settings for the url
	 		var $filterCategory = "",
	 			$categorySlug = "",
				filter = $.extend({
		    		filterCategory : '',
		    		categorySlug : ''
		    	}, options );

		    if ( filter.filterCategory != undefined && filter.categorySlug != undefined) {

		    	$filterCategory = '&filter['+filter.filterCategory+']';
		    	$categorySlug = '='+filter.categorySlug;

		    } 

		 	$.ajax({
				url: 'http://wordpress.localhost/wp-json/wp/v2/events?filter[meta_key]=event_start_date&filter[orderby]=meta_value_num&order=asc'+$filterCategory+$categorySlug,
				dataType: 'json',
				success: function(result) {

					// Events object
				 	var number = "";
				 	var eventObject= "";
				 	eventObject+= "[";
				 	
				 	$.each(result, function (i, value) {
				 		
				 		// Total number of events to determine last one
				 		number = result.length;

				 		// If post does not have image
				 		if (value.acf.event_image == false) {
				 			eventImageThumbnail = "";
				 			eventImageLarge = "";
				 		} else {
				 			if (value.acf.event_image.mime_type == "image/gif") {
				 				eventImageThumbnail = value.acf.event_image.url;
				 				eventImageLarge = value.acf.event_image.url;
				 			} else {
				 				eventImageThumbnail = value.acf.event_image["sizes"]["thumbnail_horizontal"];
				 				eventImageLarge = value.acf.event_image["sizes"]["large_horizontal"];	
				 			}
				 		}

				 		eventObject+= '{',
				 		eventObject+= '"date": "' + value.acf.event_start_date +'", ',
		                eventObject+= '"title": "' + value.title.rendered +'", ',
		                eventObject+= '"excerpt": "' + value.acf.event_excerpt +'", ',
		                eventObject+= '"imageUrl": "' + value.acf.event_image.url +'", ',
		                eventObject+= '"imageThumbnail": "' + eventImageThumbnail +'", ',
		                eventObject+= '"imageLarge": "' + eventImageLarge +'", ',
		                eventObject+= '"imageAlt": "' + value.acf.event_image.alt +'", ',
		                eventObject+= '"startDate": "' + value.acf.event_start_date +'", ',
		                eventObject+= '"endDate": "' + value.acf.event_end_date +'", ',
		                eventObject+= '"startTime": "' + value.acf.event_start_time +'", ',
		                eventObject+= '"endTime": "' + value.acf.event_end_time +'", ',
		                eventObject+= '"location": "' + value.acf.event_location +'", ',
		                eventObject+= '"streetAddress": "' + value.acf.event_street_address +'", ',
		                eventObject+= '"city": "' + value.acf.event_city +'", ',
		                eventObject+= '"state": "' + value.acf.event_state +'", ',
		                eventObject+= '"zipCode": "' + value.acf.event_zip_code +'", ',
		                eventObject+= '"categoryName": "' + value.acf.event_category.name +'", ',
		                eventObject+= '"categorySlug": "' + value.acf.event_category.slug +'", ',
		                eventObject+= '"link": "' + value.link+'"'
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
						forceSixRows: false,
						clickEvents: {
						    click: function(target) {
								// make a <ul>
								var markup = '<ul>';
								// loop through the events, making a <div> for each with relevation info
								for(var i = 0; i < target.events.length; i++) {
									markup += '<div class="event">' + target.events[i].title + ' at ' + target.events[i].location + '</div>';
								}
								// close the </ul>
								markup += '</ul>';
								// put your new markup in the events container!
								$('.day-event-listing').empty();
								$(event.target).next('.day-event-listing').html( markup );
							}
					  	},
					  	doneRendering: function() {
						    
						    var day=1, 
						    	week=1, 
						    	thisCLNDR = $(this)[0]["element"];

						    // Make the background rows alternate colour
						    thisCLNDR.find(".day").each(function() {
						        if (day == 8) { day = 1; week++; }
						        if (week % 2 === 0) { $(this).addClass("alternate-bg"); }
						        day++;
						    });

						    // Display a notice if there are no events for a month
						    var thisMonthEvents = thisCLNDR.find(".event-listing").length;
						    
						    if (thisMonthEvents == 0) {
						        thisCLNDR.find(".event-listings-container").append(
						            "<div style='text-align:center;' class='event-item'>No events found</div>"
						        );
						    }

							// Group events depending on data-date value
							var $eventListings = $('.event-listing');
							    dates = {};
							    
							$eventListings.each(function(){
							   dates[$(this).data('date')] = '';
							});

							for (date in dates) {
								var $month = moment(date).format('MMM');
								var $dayName = moment(date).format('ddd');
								var $dayNumber = moment(date).format('D');
							  	$eventListings.filter('[data-date='+ date +']').wrapAll('<div class="event-listing-group"></div>').first().before('<div class="event-group-date" data-day="' + $dayName + '"  data-month="' + $month + '">' + $dayNumber + '</div>');
							}

							// Events text filter
							var $eventsFilterItem = $('.event-listing');

							$('#events-filter').keyup(debounce(function() {

								var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
									reg = RegExp(val, 'i'),
									text;

								$eventsFilterItem.show().filter(function() {
									text = $(this).text().replace(/\s+/g, ' ');
									return !reg.test(text);
								}).hide();

								// Hide group if there aren't any events in this day
								$('.event-listing-group').each( function() {
									$(this).show();
									if($(this).children('.event-listing:visible').length < 1 ){
										$(this).hide();
									} 

								});

							}, 300));

							function debounce(func, wait, immediate) {
								var timeout;
								return function() {
									var context = this,
									args = arguments;
									var later = function() {
										timeout = null;
										if (!immediate) func.apply(context, args);
									};
									var callNow = immediate && !timeout;
									clearTimeout(timeout);
									timeout = setTimeout(later, wait);
									if (callNow) func.apply(context, args);
								};
							};

						}

					});
					
					setTimeout(function(){
  						
  						$eventsContainer.removeClass('loading-events');

					}, 1000);

				}

			});

		}			
	
	}
	
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

function accordions() {

    // Accordion
    $accordion = $('.accordion-component')
    $accordionPanel = $('.accordion-panel');
    $panelButton = $('.panel-heading button');
    $panelContent = $('.accordion-panel .panel-content');

    // Sets the states of the panels
    $accordionPanel.each(function() {
        
        $this = $(this);
        
        $this.addClass('inactive-panel');

        if ( $this.hasClass('inactive-panel') ) {

            $currentPanelContent = $this.find('.panel-content');

            TweenMax.to($currentPanelContent, 0, {
                height: 0
            });

            $panelButton.attr({'aria-expanded': 'false'});
            $panelContent.attr({'aria-hidden': 'true'});

        }

    });

    $panelButton.on('click', function(e){
        
        e.preventDefault();

        $this = $(this);

        // Current panel of button clicked
        $currentPanel = $this.closest('.accordion-panel');
        // Closest content of the current button clicked
        $currentPanelContent = $currentPanel.find('.panel-content');
        // Header height compensation for the scrollto funciton
        $headerHeight = $('.site-header').outerHeight();
        
        function setHeight(){
              TweenMax.from($currentPanelContent, 0.3, { height: 0 });
        }

        if ( $currentPanel.hasClass('inactive-panel') ) {

            // Toggle accessibility for the button
            $panelButton.attr({'aria-expanded': 'false'});
            $this.attr({'aria-expanded': 'true'});

            // Toggle accessibility for the content
            $panelContent.attr({'aria-hidden': 'true'});
            $currentPanelContent.attr({'aria-hidden': 'false'});
            
            // Closes "all" panels
            $accordionPanel.removeClass('active-panel').addClass('inactive-panel');
            TweenMax.to($panelContent, 0.3, { height: 0 });

            // Opens this panel
		    $currentPanel.removeClass("inactive-panel").addClass("active-panel");
		    TweenMax.set($currentPanelContent, { 
                height: "auto", 
                onComplete: setHeight() 
            });

            // Goes to the clicked panel
            setTimeout(function(){
                
                $('html, body').animate({
                    scrollTop:$this.offset().top-$headerHeight
                }, 300);

            }, 300);

        } else {

            // Toggle accessibility for the button
            $this.attr({'aria-expanded': 'false'});
            
            // Toggle accessibility for the content
            $currentPanelContent.attr({'aria-hidden': 'true'});
            
            // Closes this panels
            TweenMax.to($currentPanelContent, 0.2, { height: 0 });
            $currentPanel.addClass("inactive-panel").removeClass("active-panel");

        }


    });

}
function youtube(){

	var player;
	
	player = new YT.Player('video', {
        events: {
        	'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        }
    });

    function onPlayerReady(event) {
		event.target.playVideo();
		event.target.seekTo(0,true);
		// bind events
		var playButton = document.getElementById("play-button");
		playButton.addEventListener("click", function() {

			player.playVideo();

		});

		$iframe = player.getIframe();
		console.log($iframe);
	}

	// The API calls this function when the player's state changes.
	function onPlayerStateChange(event) {

		if (event.data == YT.PlayerState.UNSTARTED) {
			
			// setTimeout(stopVideo, 6000);

		} else if (event.data == YT.PlayerState.PLAYING) {

			// $iframe = player.getIframe();

			$('.slide').addClass('active-media');

			console.log('playing');

		} else if (event.data == YT.PlayerState.PAUSED ){

			paused = true;

			setTimeout(function(){

				if (paused == true) {
				
				$('.slide').removeClass('active-media');

					console.log(paused);

				}

			}, 100);

			// $('.slide').removeClass('active-media');
			console.log('paused');

		} else if (event.data == YT.PlayerState.ENDED) {

			console.log('ended');
			
			// player.destroy();

			$('.slide').removeClass('active-media');

			player.pauseVideo().seekTo(0,true);

		} else if (event.data == YT.PlayerState.BUFFERING ){

			paused = false;

			console.log('buffering');

			console.log(paused);

		} else if (event.data == YT.PlayerState.CUED) {

			console.log('video cued');

		}

	}
};

function vimeo(){
	
	$iframe = $('.slick-current iframe');
	$playButton = $('.play-button');

    var player = new Vimeo.Player($iframe);

	$playButton.on('click', function(e) {
		player.play();
	});

	player.on('pause', function(data) {
    	$('.slide').removeClass('active-media');
	});	

}

$(document).ready(function(){

	// Multimedia carousels
	$('.multimedia-carousel').each(function(){
		
		$this = $(this);


		$('.carousel-slides',$this).slick({
			arrows: false,
			dots: false,
			lazyLoad: 'ondemand',
			asNavFor: $('.carousel-thumbs',$this)
		});

		// Thumbnails
		$('.carousel-thumbs',$this).slick({
			slidesToShow: 3,
			slidesToScroll: 1,
			asNavFor: $('.carousel-slides',$this),
			dots: false,
			arrows: false,
			centerMode: true,
			focusOnSelect: true
		});

		// Lazy loaded
		$('.carousel-slides',$this).on('lazyLoaded', function(event, slick, currentSlide, nextSlide){
			currentSlide.closest('.slide-poster').addClass('loaded');
		});

		// On before slide change
		$('.carousel-slides',$this).on('beforeChange', function(event, slick, currentSlide, nextSlide){
			$('.slick-current').removeClass('active-media');

		});

		// On after slide change
		$('.carousel-slides',$this).on('afterChange', function(event, slick, currentSlide, nextSlide){
			$('.slide-object').empty();
			$('.slide').removeClass('active-media');

		});

	});

	$(document).keyup(function(e){
		if(e.keyCode==27){
			e.preventDefault();
			$slideObject.empty();
			$('.slide').removeClass('active-media');
		}
	});

	// Video triggers

	var player;

	$playButton = $('.play-button');
	
	$iframe = $('.slick-current iframe');

	$playButton.on('click', function(e) {

		e.preventDefault();

		$(this).closest('.slide').addClass('active-media');

		$iframe = $('.slick-current iframe');
		$slideType = $(this).closest('.slide').attr('data-type');
		$slideObject = $(this).closest('.slide').find('.slide-object');
		$videoId = $(this).closest('.slide').find('.video').attr('data-id');
		$embedUrl = $(this).closest('.slide').find('.iframe').attr('data-embed');

		if ( $slideType == 'youtube' ) {

			// Inject YouTube API script
			if ( !$('script[src="https://www.youtube.com/iframe_api"]').length ) {
			
				var tag = document.createElement('script');
				tag.src = "https://www.youtube.com/iframe_api";
				var firstScriptTag = document.getElementsByTagName('script')[0];
				firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

			}

			if ( !$iframe.length ) {

				$slideObject.html('<iframe id="video" src="//www.youtube.com/embed/'+$videoId+'?&enablejsapi=1" frameborder="0" allowfullscreen allow-same-origin allow-scripts></iframe>');

				setTimeout(function(){
					
					youtube();

				}, 1000);

			}

		} else if ( $slideType == 'vimeo' ){

			// Inject Vimeo API script
			if ( !$('script[src="https://player.vimeo.com/api/player.js"]').length ) {
			
				var tag = document.createElement('script');
				tag.src = "https://player.vimeo.com/api/player.js";
				var firstScriptTag = document.getElementsByTagName('script')[0];
				firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

			}

			if ( !$iframe.length ) {

				$slideObject.html('<iframe src="//player.vimeo.com/video/'+$videoId+'?autoplay=1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');

				setTimeout(function(){
					
					vimeo();

				}, 1000);

			}

		} else if ( $slideType == 'matterport' ){

			if ( !$iframe.length ) {

				$slideObject.html('<iframe src="'+$embedUrl+'" frameborder="0" allowfullscreen></iframe>');

				$('.slide .close-button').on('click', function(e){
					e.preventDefault();
					$slideObject.empty();
					$('.slide').removeClass('active-media');
				});

			}
		}
	});


});
$(document).ready(function(){

	// Headroom
	$(".site-header").headroom({
	    // vertical offset in px before element is first unpinned
	    offset : 100,
	    // scroll tolerance in px before state changes
	    tolerance : 0,
	    // or you can specify tolerance individually for up/down scroll
	    tolerance : {
	        up : 5,
	        down : 10
	    },
	    // css classes to apply
	    classes : {
	        // when element is initialised
	        initial : "header",
	        // when scrolling up
	        pinned : "header-pinned",
	        // when scrolling down
	        unpinned : "header-unpinned",
	        // when above offset
	        top : "header-top",
	        // when below offset
	        notTop : "header-not-top",
	        // when at bottom of scoll area
	        bottom : "header-bottom",
	        // when not at bottom of scroll area
	        notBottom : "header-not-bottom"
	    },
	});

});
$(document).ready(function(){

	$menuGroup = $('.main-menu .menu');

	// Multi level push menu
	$(".main-menu .caret").on('click', function(e) {
		
		e.preventDefault();

		$this = $(this);

		// Breadcrumb wrapper
		$breadcrumbWrapper = $('.breadcrumb-wrapper');
		$breadcrumb = $('.breadcrumb');
		$breadcrumbText = $this.prev('.link-text');
		$breadcrumbText = $breadcrumbText.text();
		$breadcrumbItem = $('<a href="#" class="breadcrumb">'+$breadcrumbText+'</a>' );
		if( !$breadcrumbWrapper.length ) {

			$('<div class="breadcrumb-wrapper"></div>').insertBefore('.main-menu').append($breadcrumbItem);
			$breadcrumbHeight = $breadcrumbItem.height();

		} else {

			$breadcrumbWrapper.append($breadcrumbItem);
			$breadcrumbHeight = $breadcrumbItem.height();
		}

		console.log($breadcrumbHeight);
		$('.main-menu').css({top: $breadcrumbHeight});

		// Make "all" menus not active
		$menuGroup.removeClass('active-menu-group');

		// Make current menu clicked "inactive" by pushing it the back of the line
		$this.closest('.menu').addClass('inactive-menu-group');

		// Bring the next menu up to the front of the line and active
		$this.parent().next('.menu').addClass('active-menu-group');
		
	});
	
	// Breadcrumb triggers
	$(document).on( 'click', '.breadcrumb', function(e) {
		
		e.preventDefault();

		$this = $(this);
		
		$index = $this.index('.breadcrumb');
		$breadcrumbHeight = $this.outerHeight;
		$breadcrumbWrapper = $('.breadcrumb-wrapper');

		// Make "all" menus not active
		$menuGroup.removeClass('active-menu-group');
		$('.site-navigation').find('.menu').slice($index).removeClass('inactive-menu-group');
		$('.site-navigation').find('.menu').eq($index).removeClass('inactive-menu-group').addClass('active-menu-group');

		if( $this.is(':first-child') ) {

			$breadcrumbWrapper.fadeOut().remove();
			$('.main-menu').css({top: 0});

		} else {

			$this.fadeOut().remove();		

		}
		
	});

});
$(document).ready(function(){

        // Accordion
        $scrollableTable = $('.scrollable-table');

        // Sets the states of the panels
        $scrollableTable.each(function() {

            $table = $(this);
            
            $table.scroll(function() {
                
                $currentTable = $(this);
                $distanceX = $table.scrollLeft();
                $distanceY = $table.scrollTop();
                
                if( !$currentTable.hasClass('scroll-y') ) {

                    $rowLabel = $table.find('tr th:first-child');
                    $columnLabel = $table.find('thead tr');
                    
                    if($distanceX > 0 ){

                        $currentTable.addClass('scroll-x');
                        $rowLabel.each(function(){
                            $(this).css({transform: 'translateX(' + $distanceX +'px)'});
                        });
                        
                    } else {

                        $currentTable.removeClass('scroll-x');

                    }

                }

                if( !$currentTable.hasClass('scroll-x') ) {

                    $rowLabel = $table.find('tbody tr th:first-child');
                    $columnLabel = $table.find('thead tr');

                    if($distanceY > 0 ){

                        $currentTable.addClass('scroll-y');
                        $columnLabel.each(function(){
                            $(this).css({transform: 'translateY(' + $distanceY +'px)'});
                        });
                       

                    } else {
                       
                        $currentTable.removeClass('scroll-y');

                    } 

                 }

            });

        });

});
$(document).ready(function(){

	// Remove loading class
	$('.tabs-component').each(function(){

		var $component = $(this);
		var $tabList = $component.find('.tab-list');
		var $tabPanel = $component.find('.tab-panel');
		var $tab = $component.find('.tab-list button')
		var $panelLabel = $component.find('.panel-label');

		if ($(window).width() > 768) {

			$tab.first().attr({"aria-selected": "true"}).addClass('active-tab');
			$tabPanel.first().attr({"aria-hidden": "true"}).addClass('active-content');

		}


		$tab.on('click', function(e){

			e.preventDefault();

			$this = $(this);

			$tabIndex = $this.index();
			$tabTarget = $tabPanel.eq($tabIndex);

			$tab.attr({"aria-selected": "false"}).removeClass('active-tab');
			$this.attr({"aria-selected": "true"}).addClass('active-tab');

			$tabPanel.attr({"aria-hidden": "false"}).removeClass('active-content');
			$tabTarget.attr({"aria-hidden": "true"}).addClass('active-content');

		});

		$panelLabel.on('click', function(e){

			e.preventDefault();

			$this = $(this);
			$labelTarget = $this.closest($tabPanel);

			if( $labelTarget.hasClass('active-content') ) {

				$labelTarget.attr({"aria-hidden": "false"}).removeClass('active-content');

			} else {

				$tabPanel.attr({"aria-hidden": "false"}).removeClass('active-content');
				$labelTarget.attr({"aria-hidden": "true"}).addClass('active-content');

				// Goes to the clicked item
	            setTimeout(function(){

	            	$headerHeight = $('.site-header').outerHeight();
	                
	                $('html, body').animate({
	                    scrollTop:$this.offset().top-$headerHeight
	                }, 300);

	            }, 300);

			}

		});

	});


});
//# sourceMappingURL=maps/partials.js.map

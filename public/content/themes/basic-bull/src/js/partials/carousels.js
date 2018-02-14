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
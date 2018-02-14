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
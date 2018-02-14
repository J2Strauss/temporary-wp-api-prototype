$(document).ready(function(){

	// WP admin bar toggles
	$wpNavBar = $('#wpadminbar');
	$wpNavBar.addClass('hide');

	$('#admin-trigger').on('click', function(e){
		
		e.preventDefault();
		$(this).toggleClass('down');
		$wpNavBar.toggleClass('hide show');

	});

});
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
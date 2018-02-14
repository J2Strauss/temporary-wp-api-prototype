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
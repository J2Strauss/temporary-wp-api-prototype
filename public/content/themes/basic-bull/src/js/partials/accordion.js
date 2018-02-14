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
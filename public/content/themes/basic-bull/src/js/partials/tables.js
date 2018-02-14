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
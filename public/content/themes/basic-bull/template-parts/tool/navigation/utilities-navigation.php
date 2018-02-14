<?php

	$menu_name = 'utilities';

	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) :

	    wp_nav_menu( 
	    	array(
		        'menu'              => 'utilities',
		        'theme_location'    => 'utilities',
				'items_wrap'        => '<ul id="utility-menu" class="menu main-menu" role="menu" >%3$s</ul>',
				// 'container_class'   => 'navigation-container',
				'container'=> false, 
		        'depth'             => 4,
		        'walker'            => new Custom_Menu_Walker()
		    )
	   	);

	endif;
?>
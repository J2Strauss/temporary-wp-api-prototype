<?php

   	$menu_name = 'primary';

	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ]) ) :

		$home = '49';
	    $mainMenu = wp_nav_menu( 
	    	array(
		        'menu'              => $menu_name,
		        'theme_location'    => $menu_name,
				'items_wrap'        => '<ul id="primary-menu" class="menu main-menu" role="menu" >%3$s</ul>',
				// 'container_class'   => 'navigation-container',
				'container'=> false, 
		        'depth'             => 20,
		        'walker'            => new Custom_Menu_Walker(),
		        'fallback_cb'    => false,
    			'echo'           => false,
		    )
	    );

	    if ( $mainMenu ) {
		    
		    echo $mainMenu;

		} else {
		    
		    $args = array(
		    	'exclude'      => '141, 157, 49, 165',
			    'title_li'     => '',
			    'sort_column'  => 'menu_order, post_title',
			    'post_type'    => 'page',
			    'post_status'  => 'publish'
			); 


			echo '<div class="default-navigation"><ul>';

				wp_list_pages($args);

			echo '</ul></div>';

		}

	endif;

?>
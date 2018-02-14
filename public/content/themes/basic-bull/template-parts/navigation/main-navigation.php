<?php
    wp_nav_menu( array(
        'menu'              => 'primary',
        'theme_location'    => 'primary',
		'items_wrap'        => '<ul id="primary-menu" class="menu main-menu" role="menu" >%3$s</ul>',
		'container_class'   => 'navigation-container',
        'depth'             => 4,
        'walker'            => new Custom_Menu_Walker())
    );
?>
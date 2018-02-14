<?php 

/*--------------------------------------------------------------
Navigation setup
--------------------------------------------------------------*/

if ( ! function_exists( 'basic_bull_navigation' ) ) {

	function basic_bull_navigation() {
  		
 		// Register navigations
		// ==================================

		register_nav_menus( array(
			'primary' 		=> __( 'Primary Navigation' ),
			'secondary' 	=> __( 'Secondary Navigation' ),
			'sidebar' 		=> __( 'Sidebar Navigation'),
			'footer' 		=> __( 'Footer Navigation'),
		));


	}

	add_action( 'after_setup_theme', 'basic_bull_navigation' );

}

?>
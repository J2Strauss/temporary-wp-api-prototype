<?php 

/*--------------------------------------------------------------
Enqueue "mandatory" scripts and styles.
--------------------------------------------------------------*/

if ( ! function_exists( 'basic_bull_scripts_and_styles' ) ) {

	function basic_bull_scripts_and_styles() {

		// Include theme styles

		wp_enqueue_style( 'style', get_template_directory_uri() . '/css/style.css' );
		
		// Remove jQuery that Wordpress installs and add the desired version of jQuery on the "frontend"

		if ( !is_admin() ) {

			wp_deregister_script('jquery');
			
			wp_enqueue_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js", array(), false, true);

		}

		// Google maps

		// wp_enqueue_script('googlemaps', 'https://maps.googleapis.com/maps/api/js?key=API-KEY', array( 'jquery' ), null, true);

		// Include TweenMax library

		wp_enqueue_script('tweenmax', get_template_directory_uri() . '/js/lib/tween-max.min.js', array( 'jquery' ), false, true);

		// Include compiled plugins

		wp_enqueue_script('plugin', get_template_directory_uri() . '/js/plugins.js', array( 'jquery' ), false, true);

		// Include compiled partials

		wp_enqueue_script('partials', get_template_directory_uri() . '/js/partials.js', array( 'jquery' ), false, true);

		// Include general scripts

		wp_enqueue_script('scripts', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ), false, true);

		// Default commenting scripts

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	add_action("wp_enqueue_scripts", "basic_bull_scripts_and_styles", 11);

}

?>
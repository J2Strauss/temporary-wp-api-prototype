<?php 

/*--------------------------------------------------------------
General theme setup
--------------------------------------------------------------*/

if ( ! function_exists( 'basic_bull_general_setup' ) ) {

	function basic_bull_general_setup() {

		// Remove excess from the head
		// ==================================

		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wp_generator');
		remove_action('wp_head', 'feed_links', 2);
		remove_action('wp_head', 'index_rel_link');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'feed_links_extra', 3);
		remove_action('wp_head', 'start_post_rel_link', 10, 0);
		remove_action('wp_head', 'parent_post_rel_link', 10, 0);
		remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

		// Add support to the head
		// ==================================

		add_theme_support( 'title-tag' );

	}

	add_action( 'after_setup_theme', 'basic_bull_general_setup' );

}

?>
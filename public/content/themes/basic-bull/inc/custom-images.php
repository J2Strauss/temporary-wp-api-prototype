<?php 

/*--------------------------------------------------------------
Custom images
--------------------------------------------------------------*/

if ( ! function_exists( 'basic_bull_images' ) ) {

	function basic_bull_images() {

		// Add thumbnail support
		// ==================================

		add_theme_support( 'post-thumbnails' ); 

		// Removes default images to save server space
		// ==================================

		function remove_default_image_sizes( $sizes) {
		/* Default WordPress */
		unset( $sizes[ 'thumbnail' ]);       // Remove Thumbnail (150 x 150 hard cropped)
		unset( $sizes[ 'medium' ]);          // Remove Medium resolution (300 x 300 max height 300px)
		unset( $sizes[ 'medium_large' ]);    // Remove Medium Large (added in WP 4.4) resolution (768 x 0 infinite height)
		unset( $sizes[ 'large' ]);           // Remove Large resolution (1024 x 1024 max height 1024px)
		 
		return $sizes;
		}
		add_filter('intermediate_image_sizes_advanced', 'remove_default_image_sizes');

		// Create custom sizes
		// ==================================

		add_image_size( 'thumbnail-horizontal', 380, 270, true ); // 380 pixels wide by 270 pixels tall, soft proportional crop mode
		add_image_size( 'thumbnail-vertical', 545, 99999 ); // 545 pixels wide by unlimited pixels tall, soft proportional crop mode
		add_image_size( 'medium-horizontal', 530, 390, true ); // 530 pixels wide by 390 pixels tall, hard proportional crop mode
		add_image_size( 'medium-square', 650, 650, true ); // 650 pixels wide by 650 pixels tall, hard proportional crop mode
		add_image_size( 'large-horizontal', 960, 535, true ); // 960 pixels wide by 420 pixels tall, hard proportional crop mode
		add_image_size( 'wide-strip', 1280, 320, true ); // 1280 pixels wide by 320 pixels tall, hard proportional crop mode


		// Add custom image sizes in the add media window
		// ==================================

		function custom_size_options( $sizes ) {
		return array_merge( $sizes, array(
			'thumbnail-horizontal' => __('Horizontal Thumbnail'),
			'thumbnail-vertical' => __('Vertical Thumbnail (Proportioal Height)'),
			'medium-horizontal' => __('Horizontal Medium'),
			'medium-square' => __('Square Medium'),
			'large-horizontal' => __('Horizontal Large'),
		) );
		}

		add_filter( 'image_size_names_choose', 'custom_size_options' );

		// Remove Width and Height Attributes From Inserted Images
		// ==================================

		add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
		add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );

		function remove_width_attribute( $html ) {
		$html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
		return $html;
		}

		// SVG Support for Wordpress
		// ==================================

		function cc_mime_types($mimes) {

		$mimes['svg'] = 'image/svg+xml';
		return $mimes;

		}

		add_filter('upload_mimes', 'cc_mime_types');	


	}

	add_action( 'after_setup_theme', 'basic_bull_images' );

}

?>
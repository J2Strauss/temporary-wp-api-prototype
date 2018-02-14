<?php 

/*--------------------------------------------------------------
Custom shorttcodes
--------------------------------------------------------------*/

if ( ! function_exists( 'basic_bull_custom_shortcodes' ) ) {

	function mdarts_shortcodes() {

		// Shortcode to create pomotion blocks
 
		function promo_shortcode (  ) {
			
			$content = '';

			if( get_field('promotion_title') || get_field('promotion_copy') ) :

				$content .= '<div class="module module-promotion">';

				if ( get_field('promotion_icon') ):

					$content .= sprintf('<i class="icon promotion-icon"><img src="%s" alt=""></i>', get_field('promotion_icon'));

				endif;

				if ( get_field('promotion_title') ):

					$content .= sprintf('<h2>%s</h2>', get_field('promotion_title'));

				endif;

				if ( get_field('promotion_copy') ):

					$content .= sprintf('<p>%s</p>', get_field('promotion_copy'));

				endif;

				if ( get_field('promotion_target') && get_field('promotion_link_external') ):

					$content .= sprintf('<a href="%s" target="_blank"><i class="icon icon-ui arrow-right"><svg><use xlink:href="'.get_template_directory_uri().'/img/spritemap.svg#icon-ui-arrow-right"></use><svg></i></a>' ,get_field('promotion_link_external'));

				elseif( get_field('promotion_link') ):

					$content .= sprintf('<a href="%s"><i class="icon icon-ui arrow-right"><svg><use xlink:href="'.get_template_directory_uri().'/img/spritemap.svg#icon-ui-arrow-right"></use><svg></i></a>' ,get_field('promotion_link'));

				endif;

				$content .= '</div>';

			endif;

			return $content;
		} 

		add_shortcode( 'promotion-block', 'promo_shortcode' );



	}

	add_action( 'after_setup_theme', 'mdarts_shortcodes' );

}

?>
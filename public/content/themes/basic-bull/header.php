<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package basic-bull
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />

<?php wp_head(); ?>

</head>

<body <?php body_class('fixed-header-left multi-level-push'); ?>>
	
	<?php 

	// Adds a button to toggle the "WP Admin Bar" 
	// ===============================================

	?>

	<?php if ( is_user_logged_in() ) : ?>

		<a href="#" id="admin-trigger"></a>

	<?php endif; ?>

	<div id="page" class="site">
		
		<a class="skip-link srt-only" href="#content">Skip to Main Content</a>

		<div id="masthead" class="section section-header site-header" role="banner">

			<div class="site-header-container">
						
				<div class="site-branding">

					<a href="<?php echo get_bloginfo('url'); ?>" class="logo">

						<?php get_template_part( 'template-parts/components/logos/company', 'logo' ); ?>

					</a>

				</div><!-- .site-branding -->

				<div class="site-search" role="search">

					<?php get_template_part( 'template-parts/forms/site', 'search' ); ?>

				</div><!-- .site-search -->

				<div class="site-navigation" role="navigation">
					
					<?php get_template_part( 'template-parts/navigation/main', 'navigation' ); ?>

				</div><!-- .site-navigation -->

				<div class="site-social-links" role="complementary">
					
					<?php get_template_part( 'template-parts/social-media/social', 'links' ); ?>

				</div><!-- .site-social-links -->

			</div><!-- .site-header-container -->

		</div><!-- #masthead -->

		<div id="content" class="site-content">

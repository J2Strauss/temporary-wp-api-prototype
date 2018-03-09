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

		<div id="content" class="site-content">

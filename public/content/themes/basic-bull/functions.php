<?php
/**
 * basic-bull functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package basic-bull
 */

// Cron job
// ==================================

require_once( __DIR__ . '/inc/custom-cron.php');

// Styles and scripts
// ==================================

require_once( __DIR__ . '/inc/enqueue.php');

// Custom admin abilities
// ==================================

require_once( __DIR__ . '/inc/custom-admin.php');

// General setup
// ==================================

require_once( __DIR__ . '/inc/general-setup.php');

// Custom post types
// ==================================

require_once( __DIR__ . '/inc/custom-post-types.php');

// Custom taxonomies
// ==================================

require_once( __DIR__ . '/inc/custom-taxonomies.php');

// Custom post formats
// ==================================

require_once( __DIR__ . '/inc/custom-format-types.php');

// Custom images
// ==================================

require_once( __DIR__ . '/inc/custom-images.php');

// Custom shortcodes
// ==================================

require_once( __DIR__ . '/inc/custom-shortcodes.php');

// Navigation(s)
// ==================================

require_once( __DIR__ . '/inc/navigation.php');

require_once( __DIR__ . '/inc/custom-navigation-walker.php');

// Custom tinymce formats
// ==================================

require_once( __DIR__ . '/inc/custom-tinymce.php');

// ACF functionality
// ==================================

require_once( __DIR__ . '/inc/acf-functions.php');



?>
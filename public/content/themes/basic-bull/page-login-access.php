<?php 

/**
 * Template Name: Login Page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package cohere-foundation
 */

get_header(); ?>

	<div id="primary" class="content-area">
		
		<main id="main" class="site-main" role="main">

			<?php get_template_part( 'template-parts/tool/admin/login' ); ?>

		</main><!-- #main -->

	</div><!-- #primary -->

<?php get_footer(); ?>

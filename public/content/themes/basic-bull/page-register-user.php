<?php 

/**
 * Template Name: Register User Page
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

			<?php  

			    $current_user = wp_get_current_user();

			    if ( !empty( $current_user ) ) {

			        if(current_user_can('create_users')) {

			            get_template_part( 'template-parts/tool/admin/registration' );
			        
			        } else {

			        	echo "<h1>Sorry, but you cannot create users, please contact your system admin to do so.</h1>";
			        }

			    }

			?>

		</main><!-- #main -->

	</div><!-- #primary -->

<?php get_footer(); ?>

<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package basic-bull
 */

get_header(); ?>

	<div id="primary" class="content-area">
		
		<div id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php the_title(); ?>

			<div class="section">
				
				<div class="content-component">
					
					<h1>This is a section heading and has stuff</h1>
					<p>The stuff I was talking about in the heading above are the words you are currently reading...Baboozled again.</p>

				</div>
				
				<?php get_template_part( 'template-parts/components/media/video', 'backgrounds' );  ?>

			</div>
		
		<?php endwhile;  ?>

		</div><!-- #main -->

	</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>

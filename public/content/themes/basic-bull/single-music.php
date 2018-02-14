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
			
			<h1><?php the_title(); ?></h1>

			<?php if ( get_field( 'description_long_form' ) ) : ?>
				
				<h6><strong>Description (Long Form):</strong></h6>

				<?php the_field( 'description_long_form' ); ?>

			<?php endif; ?>

			<?php if ( get_field( 'description_short_form' ) ) : ?>

				<h6><strong>Description (Short Form):</strong></h6>
				
				<p><?php the_field( 'description_short_form' ); ?></p>
				
			<?php endif; ?>

			<?php if( have_rows('age_range') ): ?>

				<?php while( have_rows('age_range') ): the_row(); ?>
					
					<?php 

						$ageRangeStart = get_sub_field('age_range_start');
						$ageRangeEnd = get_sub_field('age_range_end');

						if ( $ageRangeStart ) {

							echo '<h6><strong>Age(s):</strong></h6><p>'.$ageRangeStart;

						}

						if ( $ageRangeEnd ) {

							echo ' - '.$ageRangeEnd;

						}

						echo '</p>';

					 ?>

				<?php endwhile; ?>

			<?php endif; ?>

			<?php if( have_rows('tuitions') ): ?>

				<h6><strong>Tuition:</strong></h6>

				<?php while( have_rows('tuitions') ): the_row(); ?>
				
				

					<?php 

						$tuitionValue = get_sub_field('tuition_value');
						$tuitionCriteria = get_sub_field('tuition_criteria');
						$tuitionValue = number_format($tuitionValue);

					?>
					

					<p>$<?php echo $tuitionValue; ?>.00 <?php echo $tuitionCriteria; ?></p>

				<?php endwhile; ?>

			<?php endif; ?>
				
			<h6><strong>Is financial aid available?</strong></h6>

			<?php if ( get_field( 'financial_aid' ) ) : ?>

				<p>Financial aid is available.</p>

			<?php else : ?>

				<p>Financial aid is not available.</p>

			<?php endif; ?>

		<?php endwhile; ?>

		</div><!-- #main -->

	</div><!-- #primary -->

<?php get_footer(); ?>

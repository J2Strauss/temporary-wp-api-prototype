<?php if (get_sub_field('carousel_slide')): ?>

	<div class="component carousel-component multimedia-carousel">

		<div class="component-content">

			<div class="container">

				<?php if (get_sub_field('carousel_description')): ?>

					<div class="row">

						<div class="col-sm-12 col-md-10 col-md-offset-1">

							<div class="component-description">
								
								<?php the_sub_field('carousel_description'); ?>

							</div>

						</div>

					</div>

				<?php endif; ?>

				<?php if( have_rows('carousel_slide') ): ?>

					<div class="row">

						<div class="col-sm-12 col-lg-10 col-lg-offset-1">

							<div class="carousel-slides">

								<?php  while ( have_rows('carousel_slide') ) : the_row(); ?>

									<?php $mediaType = get_sub_field('slide_type'); ?>

									<div class="slide multimedia-slide <?php echo $mediaType; ?>-slide" data-type="<?php echo $mediaType; ?>">

										<div class="slide-content">									

											<?php get_template_part( 'template-parts/carousel/multimedia', 'slide' ); ?>

										</div>

									</div>

								<?php endwhile; ?>

							</div>

							<div class="carousel-thumbs">

								<?php  while ( have_rows('carousel_slide') ) : the_row(); ?>

									<div class="slide-thumbnail">

										<?php get_template_part( 'template-parts/carousel/multimedia', 'thumbnail' ); ?>

									</div>

								<?php endwhile; ?>

							</div>

						</div>

					</div>

				<?php endif; ?>

			</div>

		</div>

	</div>

<?php endif; ?>
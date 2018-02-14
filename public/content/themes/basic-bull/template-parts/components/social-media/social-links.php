<?php if( have_rows('social_media_links', 'options') ): ?>
	
	<div class="social-link-container">

		<?php while ( have_rows('social_media_links', 'options') ) : the_row();  ?>
	
			<?php if( get_row_layout() == 'facebook' ): ?>

				<?php if ( get_sub_field('social_url') ): ?>
					
					<a href="<?php the_sub_field('social_url'); ?>" target="_blank" class="social-link">

						<i class="icon icon-social facebook-icon">

							<svg>
								<use xlink:href="<?php echo get_template_directory_uri(); ?>/img/spritemap.svg#icon-social-facebook"></use>
							<svg>

						</i>

					</a>

				<?php endif; ?>
			
			<?php elseif( get_row_layout() == 'twitter' ):  ?>

				<?php if ( get_sub_field('social_url') ): ?>
					
					<a href="<?php the_sub_field('social_url'); ?>" target="_blank" class="social-link">

						<i class="icon icon-social twitter-icon">

							<svg>
								<use xlink:href="<?php echo get_template_directory_uri(); ?>/img/spritemap.svg#icon-social-twitter"></use>
							<svg>

						</i>

					</a>

				<?php endif; ?>

			<?php elseif( get_row_layout() == 'linkedin' ):  ?>

				<?php if ( get_sub_field('social_url') ): ?>
					
					<a href="<?php the_sub_field('social_url'); ?>" target="_blank" class="social-link">

						<i class="icon icon-social linkedin-icon">

							<svg>
								<use xlink:href="<?php echo get_template_directory_uri(); ?>/img/spritemap.svg#icon-social-linkedin"></use>
							<svg>

						</i>

					</a>

				<?php endif; ?>

			<?php elseif( get_row_layout() == 'instagram' ):  ?>

				<?php if ( get_sub_field('social_url') ): ?>
					
					<a href="<?php the_sub_field('social_url'); ?>" target="_blank" class="social-link">

						<i class="icon icon-social instagram-icon">

							<svg>
								<use xlink:href="<?php echo get_template_directory_uri(); ?>/img/spritemap.svg#icon-social-instagram"></use>
							<svg>

						</i>

					</a>

				<?php endif; ?>

			<?php elseif( get_row_layout() == 'google_plus' ):  ?>

				<?php if ( get_sub_field('social_url') ): ?>
					
					<a href="<?php the_sub_field('social_url'); ?>" target="_blank" class="social-link">

						<i class="icon icon-social google-plus-icon">

							<svg>
								<use xlink:href="<?php echo get_template_directory_uri(); ?>/img/spritemap.svg#icon-social-google-plus"></use>
							<svg>

						</i>

					</a>

				<?php endif; ?>	

			<?php elseif( get_row_layout() == 'pinterest' ):  ?>

				<?php if ( get_sub_field('social_url') ): ?>
					
					<a href="<?php the_sub_field('social_url'); ?>" target="_blank" class="social-link">

						<i class="icon icon-social pinterest-icon">

							<svg>
								<use xlink:href="<?php echo get_template_directory_uri(); ?>/img/spritemap.svg#icon-social-pinterest"></use>
							<svg>

						</i>

					</a>

				<?php endif; ?>			

			<?php elseif( get_row_layout() == 'snapchat' ):  ?>

				<a href="<?php the_sub_field('social_url'); ?>" target="_blank" class="social-link">

					<i class="icon icon-social snapchat-icon">

						<svg>
							<use xlink:href="<?php echo get_template_directory_uri(); ?>/img/spritemap.svg#icon-social-snapchat"></use>
						<svg>

					</i>
					
				</a>

			<?php elseif( get_row_layout() == 'tumblr' ):  ?>

				<a href="<?php the_sub_field('social_url'); ?>" target="_blank" class="social-link">

					<i class="icon icon-social tumblr-icon">

						<svg>
							<use xlink:href="<?php echo get_template_directory_uri(); ?>/img/spritemap.svg#icon-social-tumblr"></use>
						<svg>

					</i>
					
				</a>

			<?php elseif( get_row_layout() == 'youtube' ):  ?>

				<a href="<?php the_sub_field('social_url'); ?>" target="_blank" class="social-link">

					<i class="icon icon-social youtube-icon">

						<svg>
							<use xlink:href="<?php echo get_template_directory_uri(); ?>/img/spritemap.svg#icon-social-youtube"></use>
						<svg>

					</i>
					
				</a>

			<?php elseif( get_row_layout() == 'vimeo' ):  ?>

				<a href="<?php the_sub_field('social_url'); ?>" target="_blank" class="social-link">

					<i class="icon icon-social vimeo-icon">

						<svg>
							<use xlink:href="<?php echo get_template_directory_uri(); ?>/img/spritemap.svg#icon-social-vimeo"></use>
						<svg>

					</i>
					
				</a>
			
			<?php endif; ?>

		<?php endwhile; ?>

	</div>

<?php endif; ?>
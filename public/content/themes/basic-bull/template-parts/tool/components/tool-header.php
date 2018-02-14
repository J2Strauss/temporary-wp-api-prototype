<div id="masthead" class="site-header" role="banner">

	<div class="site-header-container">
		
		<div class="site-branding">
			
			<a href="/" class="logo">
				
				<?php get_template_part( 'template-parts/tool/components/logo', 'cohere' ); ?>

			</a>

			<a href="#" class="menu-button">
						
				<span class="bars"></span>

			</a>

		</div><!-- .site-branding -->

		<?php if ( is_user_logged_in() ) : ?>

			<div class="site-navigation main-navigation" role="navigation">

				<div class="navigation-container">
					
					<?php get_template_part( 'template-parts/tool/navigation/main', 'navigation' ); ?>

				</div>

			</div><!-- #site-navigation -->

		<?php endif; ?>

		<?php if ( is_user_logged_in() ) : ?>
			
			<div class="site-navigation site-utilities inactive-utilities" role="complementary">
			
				<?php wp_loginout( home_url() ); ?> 

				<a href="<?php echo get_edit_user_link(); ?>">Profile</a>

				<?php  

					$current_user = wp_get_current_user();
	 
	    			if ( !empty( $current_user ) ) {

	    				if(current_user_can('create_users')) {

	    					echo '<a href="'.wp_registration_url().'">Register User</a>';
						
						}

					}

				?>

				<a href="#" class="settings-button">
				
					<i class="icon icon-ui settings-icon">

                        <svg><use xlink:href="<?php echo get_template_directory_uri(); ?>/img/spritemap.svg#icon-ui-settings"></use><svg>

                    </i>

				</a>

			</div>

		<?php endif; ?>
	
	</div>

</div><!-- #masthead -->

<?php if ( is_user_logged_in() ) : ?>

	<div class="site-search header-search" role="search">

		<?php get_template_part( 'template-parts/forms/site', 'search' ); ?>

	</div><!-- .site-search -->

<?php endif; ?>
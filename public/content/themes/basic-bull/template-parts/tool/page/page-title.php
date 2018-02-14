<div class="block block-header">

	<?php

		global $post;

		if ( is_page() && $post->post_parent ) : 

	 ?>
		<?php get_template_part( 'template-parts/tool/navigation/parent', 'link' );  ?>

	<?php else : ?>

		<?php $homeTitle = get_the_title( get_option('page_on_front') ); ?>

		<?php if ( is_front_page() ) :  ?>
			
			<span class="button button-label inactive-button"><?php echo $homeTitle; ?></span>

		<?php else : ?>

			<a href="<?php echo home_url(); ?>" class="button button-label"><?php echo $homeTitle; ?></a>

		<?php endif; ?>
		
	<?php endif; ?>

	<?php if (!get_field('title_option')): ?>

		<h1><?php the_title(); ?></h1>
		
	<?php endif; ?>

</div>
<?php 

if ( !empty( get_the_content() ) ) :

?>

	<div class="block block-content">

		<?php get_template_part( 'template-parts/page/content', 'page' ); ?>

	</div>

<?php endif; ?>
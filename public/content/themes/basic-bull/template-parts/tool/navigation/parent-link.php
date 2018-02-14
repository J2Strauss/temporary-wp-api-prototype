<?php 

	global $post;

	if ( $post->post_parent ) : 

?>
	
	<a href="<?php echo get_permalink( $post->post_parent ); ?>" class="button button-label">

		<?php echo get_the_title( $post->post_parent ); ?>
		
	</a>

<?php endif; ?>
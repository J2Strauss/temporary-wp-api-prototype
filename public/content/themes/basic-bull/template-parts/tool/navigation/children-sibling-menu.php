<?php 

	if( is_page() && $post->post_parent > 0 ) : 

		$args = array(
			'title_li'		=> '',
			'depth' 		=> 1,
			'echo'			=> false,
			'sort_column'  	=> 'menu_order, post_title',
			'child_of' 		=> $post->post_parent,
			'post_type'    	=> 'page',
			'post_status'  	=> 'publish',
			'exclude' 		=> $post->ID
		); 

		$childrenSiblings = wp_list_pages($args);

?>

	<?php if ( !empty($childrenSiblings) ): ?>
		
		<div class="related-links sibling-links">

			<h6>Sibling Pages:</h6>

			<ul>

				<?php echo $childrenSiblings; ?>

			</ul>

		</div>

	<?php endif; ?>

<?php endif; ?>
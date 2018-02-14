<?php 

	if( is_page() && !$post->post_parent ) : 

		$exclude = array();
		$exclude[] ='141, 157, 49, 165';
		$currentPage = $post->ID;
		$args = array(
			'title_li'		=> '',
			'depth' 		=> 1,
			'echo'			=> false,
			'sort_column'  	=> 'menu_order, post_title',
			'post_type'    	=> 'page',
			'post_status'  	=> 'publish',
			'exclude'      	=> '141, 157, 49, 165,'.$currentPage.'', 
		); 

		$topLevelSiblings = wp_list_pages($args);
				

?>

	<?php if ( !empty($topLevelSiblings) ): ?>

		<div class="related-links">

			<h6>Related Links:</h6>

			<ul>

				<?php echo $topLevelSiblings; ?>

			</ul>

		</div>

	<?php endif; ?>

<?php endif; ?>
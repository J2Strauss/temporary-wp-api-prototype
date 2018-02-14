<?php 
	
	$args = array(
		'parent' 		=> $post->ID,
		'post_type' 	=> 'page',
		'post_status' 	=> 'publish'
	); 

	$children = get_pages($args);  
	
?>

<?php if (!empty($children)): ?>

	<div class="related-links children-links">

		<h6>Children Pages:</h6>

		<ul> 

			<?php foreach( $children as $child ) : ?>
			
				<li>
				    
				    <a href="<?php echo  get_permalink($child->ID); ?>">
				    	<?php echo $child->post_title; ?>

				    </a>

				</li>

			<?php endforeach; ?>
			
		</ul>

	</div>

<?php endif; ?>
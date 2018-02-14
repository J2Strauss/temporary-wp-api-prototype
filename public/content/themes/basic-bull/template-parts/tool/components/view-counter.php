<?php 

	// Count page views and update the field

	$count = (int) get_field('field_5a0cb1934903f');

	$count++;

	update_field('field_5a0cb1934903f', $count);

?>
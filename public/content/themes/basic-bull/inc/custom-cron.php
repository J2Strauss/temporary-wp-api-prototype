<?php 

/*--------------------------------------------------------------
Cron job
--------------------------------------------------------------*/

// delete_post_revisions will be call when the Cron is executed
add_action( 'delete_post_revisions', 'delete_all_post_revisions' );

// This function will run once the 'delete_post_revisions' is called
function delete_all_post_revisions() {

	$args = array(
		'post_type' => 'post',
		'posts_per_page' => -1,
		// We don't need anything else other than the Post IDs
		'fields' => 'ids',
		'cache_results' => false,
		'no_found_rows' => true
	);

	$posts = new WP_Query( $args );

	// Cycle through each Post ID
	foreach( (array)$posts->posts as $post_id ) {

		// Check for possible revisions
		$revisions = wp_get_post_revisions( $post_id, array( 'fields' => 'ids' ) );

		// If we got some revisions back from wp_get_post_revisions
		if( is_array( $revisions ) && count( $revisions ) >= 1 ) {
		  
			foreach( $revisions as $revision_id ) {

				// Do a final check on the Revisions
				if( wp_is_post_revision( $revision_id ) ) {
					// Delete the actual post revision
					wp_delete_post_revision( $revision_id);
				}
			}
		}
	}
}

// Add function to register event to WordPress init
add_action( 'init', 'register_daily_revision_delete_event');

// Function which will register the event
function register_daily_revision_delete_event() {
	// Make sure this event hasn't been scheduled
	if( !wp_next_scheduled( 'delete_post_revisions' ) ) {
		// Schedule the event
		wp_schedule_event( time(), 'daily', 'delete_post_revisions' );
	}
}


?>
<?php 

/*--------------------------------------------------------------
Custom admin abilities
--------------------------------------------------------------*/

if ( ! function_exists( 'basic_bull_custom_admin' ) ) {

	function basic_bull_custom_admin() {

		// Make the admin logo on login link go the the site url instead of wordpress.org

		function my_login_logo_url() {

			return get_bloginfo( 'url' );

		}

		add_filter( 'login_headerurl', 'my_login_logo_url' );

		// Custom title text for the admin logo on login

		function my_login_logo_url_title() {

			return get_bloginfo( 'name' );

		}

		add_filter( 'login_headertitle', 'my_login_logo_url_title' );

		// Adds compiled stylesheet from src/css/admin/~

		function custom_login() {
			
			echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/css/admin-style.css" />';

		}

		add_action('login_head', 'custom_login');

		// Removes admin margin-top for the hidden admin bar

		add_action('get_header', 'my_filter_head');

		function my_filter_head() {
			
			remove_action('wp_head', '_admin_bar_bump_cb');

		}

	}

	add_action( 'after_setup_theme', 'basic_bull_custom_admin' );


	// Adds compiled admin scripts and styles for the "frontend" when user is logged in

	if ( is_user_logged_in() ) {
		
		function basic_bull_custom_backend_styles() {

			wp_enqueue_style( 'admin_style', get_template_directory_uri() . '/css/admin-style.css' );
		}

		add_action("admin_enqueue_scripts", "basic_bull_custom_backend_styles", 11);

		function basic_bull_custom_admin_scripts_and_styles() {

			wp_enqueue_style( 'admin_style', get_template_directory_uri() . '/css/admin-style.css' );
			
			wp_enqueue_script('admin_scripts', get_template_directory_uri() . '/js/admin-scripts.js', array( 'jquery' ), false, true);
		}

		add_action("wp_enqueue_scripts", "basic_bull_custom_admin_scripts_and_styles", 11);

	}

	// Adds custom columns for page views with ACF
	// ==================================

	function page_views_column($columns) {
		$columns = array(
			'cb'	 		=> '<input type="checkbox" />',
			// 'thumbnail'		=>	'Thumbnail',
			'title' 		=> 'Title',
			'page_views' 	=> 'Page Views',
			'date'			=>	'Date',
		);
		return $columns;
	}

	// Sets the value to the custom columns for page views with ACF
	// ==================================

	function my_custom_columns($column) {
	
		if($column == 'page_views') {

			if(get_field('page_views')) {
				
				$value = get_field('page_views');
				echo $value;

			} else {

				echo '0';

			}
		}
	}

	//add_action('manage_pages_custom_column','my_custom_columns', 10, 2 );
	//add_filter( 'manage_pages_columns', 'page_views_column' );

	// Makes the custom columns for page views with ACF sortable
	// ==================================

	function my_column_register_sortable( $columns ) {
		$columns['page_views'] = 'page_views';
		return $columns;
	}

	add_filter("manage_edit-page_sortable_columns", "my_column_register_sortable" );

	add_action( 'pre_get_posts', 'page_view_orderby' );
	function page_view_orderby( $query ) {
	    if( ! is_admin() )
	        return;
	 
	    $orderby = $query->get( 'orderby');
	 
	    if( 'page_views' == $orderby ) {
	        $query->set('meta_key','page_views');
	        $query->set('orderby','meta_value_num');
	    }
	}

	// Makes the custom columns for page views with ACF accessable for the quick edit and bulk edit screen 
	// ==================================

	add_action( 'bulk_edit_custom_box', 'add_to_bulk_quick_edit_custom_box', 10, 2 );
	
	add_action( 'quick_edit_custom_box', 'add_to_bulk_quick_edit_custom_box', 10, 2 );
	function add_to_bulk_quick_edit_custom_box( $column_name, $post_type ) {
	   switch ( $post_type ) {
	      case 'page':

	         switch( $column_name ) {
	            case 'page_views':
	               ?><fieldset class="inline-edit-col-right">
	                  <div class="inline-edit-group">
	                     <label>
	                        <span class="title">Page Views</span>
	                        <input type="text" name="page_views" value="" />
	                     </label>
	                  </div>
	               </fieldset><?php
	               break;
	         }
	         break;

	   }
	}

	// Includes the scripts needed to adjust and save the data on the edit screen
	// ==================================

	add_action( 'admin_print_scripts-edit.php', 'custom_enqueue_edit_scripts' );
	
	function custom_enqueue_edit_scripts() {
	   wp_enqueue_script( 'custom-admin-edit', get_bloginfo( 'stylesheet_directory' ) . '/js/lib/quick-edit.js', array( 'jquery', 'inline-edit-post' ), '', true );
	}

	// Saves the custom columns data for page views with ACF via the quick edits screen
	// ==================================

	add_action( 'save_post','custom_save_post', 10, 2 );
	
	function custom_save_post( $post_id, $post ) {

	   // don't save for autosave
	   if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
	      return $post_id;

	   // dont save for revisions
	   if ( isset( $post->post_type ) && $post->post_type == 'revision' )
	      return $post_id;

	   switch( $post->post_type ) {

	      case 'page':

	         // release date
		 // Because this action is run in several places, checking for the array key keeps WordPress from editing
	         // data that wasn't in the form, i.e. if you had this post meta on your "Quick Edit" but didn't have it
	         // on the "Edit Post" screen.
		 if ( array_key_exists( 'page_views', $_POST ) )
		    update_post_meta( $post_id, 'page_views', $_POST[ 'page_views' ] );

		 break;

	   }

	}

	// Saves the custom columns data for page views with ACF via the bulk edits screen
	// ==================================

	add_action( 'wp_ajax_manage_wp_posts_using_bulk_quick_save_bulk_edit', 'manage_wp_posts_using_bulk_quick_save_bulk_edit' );
	function manage_wp_posts_using_bulk_quick_save_bulk_edit() {
		// we need the post IDs
		$post_ids = ( isset( $_POST[ 'post_ids' ] ) && !empty( $_POST[ 'post_ids' ] ) ) ? $_POST[ 'post_ids' ] : NULL;
			
		// if we have post IDs
		if ( ! empty( $post_ids ) && is_array( $post_ids ) ) {

			// get the custom fields
			$custom_fields = array( 'page_views');
			
			foreach( $custom_fields as $field ) {
				
				// if it has a value, doesn't update if empty on bulk
				if ( isset( $_POST[ $field ] ) && !empty( $_POST[ $field ] ) ) {
				
					// update for each post ID
					foreach( $post_ids as $post_id ) {
						update_post_meta( $post_id, $field, $_POST[ $field ] );
					}
					
				}
				
			}
			
		}

	}



}

?>
<?php 

/*--------------------------------------------------------------
Custom post types
Based off of: https://code.tutsplus.com/articles/custom-post-type-helper-class--wp-25104
--------------------------------------------------------------*/

	class Custom_Post_Type {

	    public $post_type_name;
	    public $post_type_options;
	    public $post_type_labels;

		
		// Remove underscore or dash and add space
		public static function beautify( $string ) {

	    	return ucwords( str_replace( ['-', '_'], ' ', $string ) );

		}

	 	// Remove space and add underscore
		public static function uglify( $string ) {

	    	return strtolower( str_replace( ' ', '_', $string ) );

		}

		// Pluralize
		public static function pluralize( $string ) {
	    
	    	$last = $string[strlen( $string ) - 1];
	     
		    if( $last == 'y' ) {
			        $cut = substr( $string, 0, -1 );
			        //convert y to ies
			        $plural = $cut . 'ies';

		    } else {

		        // just attach an s
		        $plural = $string . 's';

		    }
		     
		    return ucwords( str_replace( ['-', '_'], ' ', $plural ) );
		}
	     
	    // Class constructor w/ options and labels that can be passed need be
	    public function __construct( $name, $options = [], $labels = [] ) {
	    	
	    	// Default options
	    	$default_post_options = [
				'public' => true,
				'supports' => ['title', 'editor', 'thumbnail', 'revisions']
			];

			// Required labels
			$required_post_labels = [
				'singular_name' => self::beautify( $name ),
				'plural_name' => self::pluralize( $name )
			];

			// Sets post type name
	    	$this->post_type_name = strtolower( str_replace( ' ', '_', $name ) );

			// Adds defaults options to any addiontional arguments passed
			$this->post_type_options = $options + $default_post_options;

			// Adds required labels to any addiitional labels passed
			$this->post_type_labels = $labels + $required_post_labels;

			// Sets the lables array and adds all of the labels on the arguments array
			$this->post_type_options['labels'] = $this->post_type_labels + $this->default_post_labels();
			
		    // Add action to register the post type, if the post type does not already exist
		    if( ! post_type_exists( $this->post_type_name ) ) {
		        add_action( 'init', array( $this, 'register_post_type' ) );
		    }
	     
	    }

	    // Sets default post type labels
	    public function default_post_labels() {
			
			return [
				'name' => $this->post_type_labels['plural_name'],
				'singular_name' => $this->post_type_labels['singular_name'],
				'add_new' => 'Add New ' . $this->post_type_labels['singular_name'],
				'add_new_item' => 'Add New ' . $this->post_type_labels['singular_name'],
				'edit_item' => 'Edit ' . $this->post_type_labels['singular_name'],
				'new_item' => 'New ' . $this->post_type_labels['singular_name'],
				'view' => 'View ' . $this->post_type_labels['singular_name'] . ' Page',
				'view_item' => 'View ' . $this->post_type_labels['singular_name'],
				'all_items' => 'All ' . $this->post_type_labels['plural_name'],
				'search_items' => 'Search ' . $this->post_type_labels['plural_name'],
				'not_found' => 'No matching ' . strtolower($this->post_type_labels['plural_name']) . ' found',
				'not_found_in_trash' => 'No ' . strtolower($this->post_type_labels['plural_name']) . ' found in Trash',
				'parent_item_colon' => 'Parent ' . $this->post_type_labels['singular_name']
			];
		}
	     
	   	// Registers the post type
		public function register_post_type() {
		     
		    register_post_type( $this->post_type_name, $this->post_type_options );

		}

		public function add_taxonomy( $name, $args = array(), $labels = array() ) {
		    
		    if( ! empty( $name ) ) {
		        
		        // We need to know the post type name, so the new taxonomy can be attached to it.
		        $post_type_name = $this->post_type_name;
		 
		        // Taxonomy properties
		        $taxonmy_name      = strtolower( str_replace( ' ', '_', $name ) );
		        $taxonomy_labels    = $labels;
		        $taxonomy_args      = $args;
		 
		        /* More code coming */
		        if( ! taxonomy_exists( $taxonmy_name ) ) {
    				
    				//Capitilize the words and make it plural
					$name = self::beautify( $name );
					$plural = self::pluralize( $name );
					 
					// Default labels, overwrite them with the given labels.
					$labels = array_merge(
					 
					    // Default
					    array(
					        'name'                  => _x( $plural, 'taxonomy general name' ),
					        'singular_name'         => _x( $name, 'taxonomy singular name' ),
					        'search_items'          => __( 'Search ' . $plural ),
					        'all_items'             => __( 'All ' . $plural ),
					        'parent_item'           => __( 'Parent ' . $name ),
					        'parent_item_colon'     => __( 'Parent ' . $name . ':' ),
					        'edit_item'             => __( 'Edit ' . $name ),
					        'update_item'           => __( 'Update ' . $name ),
					        'add_new_item'          => __( 'Add New ' . $name ),
					        'new_item_name'         => __( 'New ' . $name . ' Name' ),
					        'menu_name'             => __( $plural ),
					    ),
					 
					    // Given labels
					    $taxonomy_labels
					 
					);
					 
					// Default arguments, overwritten with the given arguments
					$args = array_merge(
					 
					    // Default
					    array(
					        'label'                 => $plural,
					        'labels'                => $labels,
					        'public'                => true,
					        'hierarchical'          => true,
					        'show_ui'               => true,
					        'show_in_nav_menus'     => true,
					        'show_admin_column'     => true,
					        'show_tagcloud'         => false,
					        '_builtin'              => false,
							'show_in_rest'          => true,
							'rest_base'             => $taxonmy_name,
							'rest_controller_class' => 'WP_REST_Terms_Controller',
					    ),
					 
					    // Given
					    $taxonomy_args
					 
					);
					 
					// Add the taxonomy to the post type
					add_action( 'init', function() use( $taxonmy_name, $post_type_name, $args ) {
					        
						register_taxonomy( $taxonmy_name, $post_type_name, $args );

					});

				} else {
    				
    				add_action( 'init', function() use( $taxonmy_name, $post_type_name ) {

        				register_taxonomy_for_object_type( $taxonmy_name, $post_type_name );

    				});

				}
		    }

		}


	}

	$events = new Custom_Post_Type( 'event' ,
		[
			'menu_icon' => 'dashicons-calendar',
			'has_archive' => true,
			'publicly_queryable' => true,
			'hierarchical' => true,
			'show_in_rest'       => true,
			'rest_base'          => 'events',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		], 
		[
			// 'name' => 'Events', 
			// 'singular_name' => 'Custom Single Name',
			// 'all_items' => 'All Events', 
			// 'add_new' => 'Add Event', 
			// 'add_new_item' => 'Add Event',
			// 'edit_item' => 'Edit Custom Name', 
			// 'view' => 'View Custom Name', 
			// 'view_item' => 'View Custom Name'
		]
	);

	$music = new Custom_Post_Type( 'music' ,
		[
			'menu_icon' => 'dashicons-format-audio',
			'has_archive' => true,
			'publicly_queryable' => true,
			'hierarchical' => true,
			'show_in_rest'       => true,
			'rest_base'          => 'music',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		], 
		[
		'name' => 'Music', 
			// 'singular_name' => 'Custom Single Name',
		'all_items' => 'All Music Courses', 
		'add_new' => 'Add New Course', 
		'add_new_item' => 'Add New Music Course',
			// 'edit_item' => 'Edit Custom Name', 
			// 'view' => 'View Custom Name', 
			// 'view_item' => 'View Custom Name'
		]
	);

	$dance = new Custom_Post_Type( 'dance' ,
		[
			'menu_icon' => 'dashicons-groups',
			'has_archive' => true,
			'publicly_queryable' => true,
			'hierarchical' => true,
			'show_in_rest'       => true,
			'rest_base'          => 'dance',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		], 
		[
		'name' => 'Dance', 
			// 'singular_name' => 'Custom Single Name',
		'all_items' => 'All Dance Courses', 
		'add_new' => 'Add New Course', 
		'add_new_item' => 'Add New Dance Course',
			// 'edit_item' => 'Edit Custom Name', 
			// 'view' => 'View Custom Name', 
			// 'view_item' => 'View Custom Name'
		]
	);

	$artsTherapy = new Custom_Post_Type( 'arts_therapy' ,
		[
			'menu_icon' => 'dashicons-heart',
			'has_archive' => true,
			'publicly_queryable' => true,
			'hierarchical' => true,
			'show_in_rest'       => true,
			'rest_base'          => 'creative-arts-therapy',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		], 
		[
		'name' => 'Therapy', 
			// 'singular_name' => 'Custom Single Name',
		'all_items' => 'All Therapy Courses', 
		'add_new' => 'Add New Course', 
		'add_new_item' => 'Add New Creative Arts Therapy Item',
			// 'edit_item' => 'Edit Custom Name', 
			// 'view' => 'View Custom Name', 
			// 'view_item' => 'View Custom Name'
		]
	);

	$preschool = new Custom_Post_Type( 'preschool' ,
		[
			'menu_icon' => 'dashicons-lightbulb',
			'has_archive' => true,
			'publicly_queryable' => true,
			'hierarchical' => true,
			'show_in_rest'       => true,
			'rest_base'          => 'preschool',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		], 
		[
		'name' => 'Preschool', 
			// 'singular_name' => 'Custom Single Name',
		'all_items' => 'All Preschool Programs', 
		'add_new' => 'Add New Program', 
		'add_new_item' => 'Add New Preschool Program',
			// 'edit_item' => 'Edit Custom Name', 
			// 'view' => 'View Custom Name', 
			// 'view_item' => 'View Custom Name'
		]
	);

	$afterSchool = new Custom_Post_Type( 'after_school' ,
		[
			'menu_icon' => 'dashicons-clock',
			'has_archive' => true,
			'publicly_queryable' => true,
			'hierarchical' => true,
			'show_in_rest'       => true,
			'rest_base'          => 'after-school',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		], 
		[
		'name' => 'After School', 
			// 'singular_name' => 'Custom Single Name',
		'all_items' => 'All After School Programs', 
		'add_new' => 'Add New Program', 
		'add_new_item' => 'Add New After School Program',
			// 'edit_item' => 'Edit Custom Name', 
			// 'view' => 'View Custom Name', 
			// 'view_item' => 'View Custom Name'
		]
	);

	$music->add_taxonomy( 'music_program', array(
			'labels' => array(
				'name' => 'Programs',
				'add_new_item' => "Add New Program"
				// 'singular_name' => 'Custom Single Name',
				// 'all_items' => 'All Therapy Items', 
				// 'add_new' => 'Add New Item', 
				// 'add_new_item' => 'Add New Creative Arts Therapy Item',
				// 'edit_item' => 'Edit Custom Name', 
				// 'view' => 'View Custom Name', 
				// 'view_item' => 'View Custom Name'
				)
			)
		);

	$music->add_taxonomy( 'instrument' );

	$dance->add_taxonomy( 'dance_program', array(
			'labels' => array(
				'name' => 'Programs', 
				// 'singular_name' => 'Custom Single Name',
				// 'all_items' => 'All Therapy Items', 
				// 'add_new' => 'Add New Item', 
				// 'add_new_item' => 'Add New Creative Arts Therapy Item',
				// 'edit_item' => 'Edit Custom Name', 
				// 'view' => 'View Custom Name', 
				// 'view_item' => 'View Custom Name'
				)
			)
	);

	// // Makes columns sortable

	// add_filter("manage_edit-class_sortable_columns", 'class_sort');
	
	// function class_sort($columns) {
	// 	$custom = array(
	// 		'taxonomy-music_group' => 'taxonomy-music_group',
	// 	);
	// 	return wp_parse_args($custom, $columns);
	// }


	// // Filter by taxonomy

	// add_action('restrict_manage_posts', 'music_group_filter_post_type_by_taxonomy');
	
	// // Filter by taxonomy results

	// function music_group_filter_post_type_by_taxonomy() {
	// 	global $typenow;
	// 	$post_type = 'class'; // change to your post type
	// 	$taxonomy  = 'music_group'; // change to your taxonomy
	// 	if ($typenow == $post_type) {
	// 		$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
	// 		$info_taxonomy = get_taxonomy($taxonomy);
	// 		wp_dropdown_categories(array(
	// 			'show_option_all' => __("All {$info_taxonomy->label}"),
	// 			'taxonomy'        => $taxonomy,
	// 			'name'            => $taxonomy,
	// 			'orderby'         => 'name',
	// 			'selected'        => $selected,
	// 			'show_count'      => false,
	// 			'hide_empty'      => true,
	// 		));
	// 	};
	// }

	// // Creates filter by taxonomy dropdown

	// add_filter('parse_query', 'music_group_convert_id_to_term_in_query');

	// function music_group_convert_id_to_term_in_query($query) {
	// 	global $pagenow;
	// 	$post_type = 'class'; // change to your post type
	// 	$taxonomy  = 'music_group'; // change to your taxonomy
	// 	$q_vars    = &$query->query_vars;
	// 	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
	// 		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
	// 		$q_vars[$taxonomy] = $term->slug;
	// 	}
	// }

?>
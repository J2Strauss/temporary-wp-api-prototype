<?php 

/*--------------------------------------------------------------
Custom format types using taxonomies
--------------------------------------------------------------*/

if ( ! function_exists( 'basic_bull_custom_formats' ) ) {

	// Post formats
	// ==================================

	function basic_bull_custom_formats() {

		// Hook into the init action and call custom_post_formats_taxonomies when it fires
		add_action( 'init', 'custom_post_formats_taxonomies', 0 );

		// Create a new taxonomy we're calling 'format'
		function custom_post_formats_taxonomies() {
			
			// Add new taxonomy, make it hierarchical (like categories)
			$labels = array(
				'name'              => _x( 'Formats', 'taxonomy general name', 'textdomain' ),
				'singular_name'     => _x( 'Format', 'taxonomy singular name', 'textdomain' ),
				'search_items'      => __( 'Search Formats', 'textdomain' ),
				'all_items'         => __( 'All Formats', 'textdomain' ),
				'parent_item'       => __( 'Parent Format', 'textdomain' ),
				'parent_item_colon' => __( 'Parent Format:', 'textdomain' ),
				'edit_item'         => __( 'Edit Format', 'textdomain' ),
				'update_item'       => __( 'Update Format', 'textdomain' ),
				'add_new_item'      => __( 'Add New Format', 'textdomain' ),
				'new_item_name'     => __( 'New Format Name', 'textdomain' ),
				'menu_name'         => __( 'Format', 'textdomain' ),
			);

			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'format' ),
				'capabilities' => array(
					'manage_terms' => '',
					'edit_terms' => '',
					'delete_terms' => '',
					'assign_terms' => 'edit_posts'
				),
				'public' => true,
				'show_in_nav_menus' => true,
				'show_tagcloud' => false,
			);
			
			// Register the new 'format' taxonomy
			register_taxonomy( 'format', array( 'custom_post' ), $args ); 

		}

		// Programmatically create a few format terms
		// Later we'll define this as our default, so all posts have to have at least one format on save
		function example_insert_default_format() { 
			wp_insert_term(
				'Default',
				'format',
				array(
				  'description'	=> '',
				  'slug' 		=> 'default'
				)
			);
		}
		add_action( 'init', 'example_insert_default_format' );

		// Repeat the following 11 lines for each format you want
		function example_insert_map_format() {
			wp_insert_term(
				'Map', // change this to
				'format',
				array(
					'description'	=> 'Adds a large map to the top of your post.',
					'slug' 		=> 'map'
				)
			);
		}
		add_action( 'init', 'example_insert_map_format' );

		// Make sure there's a default Format type and that it's chosen if they didn't choose one on save
		function select_default_format_term( $post_id, $post ) {
			if ( 'publish' === $post->post_status ) {
			    $defaults = array(
			        'format' => 'default' // change 'default' to whatever term slug you created above that you want to be the default
			        );
			    $taxonomies = get_object_taxonomies( $post->post_type );
			    foreach ( (array) $taxonomies as $taxonomy ) {
			        $terms = wp_get_post_terms( $post_id, $taxonomy );
			        if ( empty( $terms ) && array_key_exists( $taxonomy, $defaults ) ) {
			            wp_set_object_terms( $post_id, $defaults[$taxonomy], $taxonomy );
			        }
			    }
			}
		}
		add_action( 'save_post', 'select_default_format_term', 100, 2 );

		// Replace checkboxes for the format taxonomy with radio buttons and a custom meta box
		function radio_conversion( $args ) {
			
			if ( ! empty( $args['taxonomy'] ) && $args['taxonomy'] === 'format' ) {
			    
			    if ( empty( $args['walker'] ) || is_a( $args['walker'], 'Walker' ) ) { // Don't override 3rd party walkers.
			        
			        if ( ! class_exists( 'category_radio_checklist' ) ) {
			            
			            class category_radio_checklist extends Walker_Category_Checklist {
			                
			                function walk( $elements, $max_depth, $args = array() ) {
			                    $output = parent::walk( $elements, $max_depth, $args );
			                    $output = str_replace(
			                        array( 'type="checkbox"', "type='checkbox'" ),
			                        array( 'type="radio"', "type='radio'" ),
			                        $output
			                    );
			                    return $output;
			                }

			            }

			        }

			        $args['walker'] = new category_radio_checklist;

			    }
			}
			
			return $args;

		}

		add_filter( 'wp_terms_checklist_args', 'radio_conversion' );

	}

	add_action( 'after_setup_theme', 'basic_bull_custom_formats' );

} 

?>
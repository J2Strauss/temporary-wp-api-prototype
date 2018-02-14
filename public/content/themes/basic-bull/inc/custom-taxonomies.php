<?php 

	class Custom_Taxonomy {

	    public $taxonomy_name;
	    public $taxonomy_options;
	    public $taxonomy_labels;

		
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
	    	$default_taxonomy_options = [
				'labels'                     => $labels,
				'hierarchical'               => true,
				'public'                     => true,
				'show_ui'                    => true,
				'show_admin_column'          => true,
				'show_in_nav_menus'          => true,
				'show_in_rest'          => true,
				'rest_base'             => $name,
				'rest_controller_class' => 'WP_REST_Terms_Controller',
			];

			// Required labels
			$required_taxonomy_labels = [
				'singular_name' => self::beautify( $name ),
				'plural_name' => self::pluralize( $name )
			];

			// Sets post type name
	    	$this->taxonomy_name = strtolower( str_replace( ' ', '_', $name ) );

			// Adds defaults options to any addiontional arguments passed
			$this->taxonomy_options = $options + $default_taxonomy_options;

			// Adds required labels to any addiitional labels passed
			$this->taxonomy_labels = $labels + $required_taxonomy_labels;

			// Sets the lables array and adds all of the labels on the arguments array
			$this->taxonomy_options['labels'] = $this->taxonomy_labels + $this->default_taxonomy_labels();
			
		    // Add action to register the post type, if the post type does not already exist
		    if( ! taxonomy_exists( $this->taxonomy_name ) ) {
		        add_action( 'init', array( $this, 'register_taxonomy' ) );
		    }
	     
	    }

	    // Sets default post type labels
	    public function default_taxonomy_labels() {
			
			return [
				'name' => $this->taxonomy_labels['plural_name'],
				'singular_name' => $this->taxonomy_labels['singular_name'],
				'add_new' => 'Add New ' . $this->taxonomy_labels['singular_name'],
				'add_new_item' => 'Add New ' . $this->taxonomy_labels['singular_name'],
				'edit_item' => 'Edit ' . $this->taxonomy_labels['singular_name'],
				'new_item' => 'New ' . $this->taxonomy_labels['singular_name'],
				'view' => 'View ' . $this->taxonomy_labels['singular_name'] . ' Page',
				'view_item' => 'View ' . $this->taxonomy_labels['singular_name'],
				'all_items' => 'All ' . $this->taxonomy_labels['plural_name'],
				'search_items' => 'Search ' . $this->taxonomy_labels['plural_name'],
				'not_found' => 'No matching ' . strtolower($this->taxonomy_labels['plural_name']) . ' found',
				'not_found_in_trash' => 'No ' . strtolower($this->taxonomy_labels['plural_name']) . ' found in Trash',
				'parent_item_colon' => 'Parent ' . $this->taxonomy_labels['singular_name']
			];
		}
	     
	   	// Registers the post type
		public function register_taxonomy() {

		    register_taxonomy( $this->taxonomy_name, array( 'music', 'dance', 'arts_therapy', 'preschool', 'after_school'), $this->taxonomy_options );

		}

	}

	$locations = new Custom_Taxonomy( 'location', [], [] );

	$skillLevel = new Custom_Taxonomy( 'skill_level', [], [] );

	$ageRange = new Custom_Taxonomy( 'age_range', [], [] );

?>
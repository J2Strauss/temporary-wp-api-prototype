<?php
/**
 * WP Custom Navwalker
 *
 * @package WP Custom Navwalker
 */
/**
 * Plugin URI:  https://github.com/wp-bootstrap/wp-bootstrap-navwalker
 * Description: A custom WordPress nav walker class to implement the custom markup
 * Author: Edward McIntyre - @twittem, WP Bootstrap
 */
/* Check if Class Exists. */
if ( ! class_exists( 'Custom_Menu_Walker' ) ) {
    /**
     * Custom_Menu_Walker class.
     *
     * @extends Walker_Nav_Menu
     */
    class Custom_Menu_Walker extends Walker_Nav_Menu {
        /**
         * Start Level.
         *
         * @see Walker::start_lvl()
         *
         * @access public
         * @param mixed $output Passed by reference. Used to append additional content.
         * @param int   $depth (default: 0) Depth of page. Used for padding.
         * @param array $args (default: array()) Arguments.
         * @return void
         */
        public function start_lvl( &$output, $depth = 0, $args = array() ) {
            $indent = str_repeat( "\t", $depth );
            $output .= "\n$indent<ul role=\"menu\" class=\"menu sub-menu\" >\n";
        }
        /**
         * Start El.
         *
         * @see Walker::start_el()
         * @since 3.0.0
         *
         * @access public
         * @param mixed $output Passed by reference. Used to append additional content.
         * @param mixed $item Menu item data object.
         * @param int   $depth (default: 0) Depth of menu item. Used for padding.
         * @param array $args (default: array()) Arguments.
         * @param int   $id (default: 0) Menu item ID.
         * @return void
         */
        public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
            
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

            /**
             * Dividers, Headers or Disabled
             * =============================
             * Determine whether the item is a Divider, Header, Disabled or regular
             * menu item. To prevent errors we use the strcasecmp() function to so a
             * comparison that is not case sensitive. The strcasecmp() function returns
             * a 0 if the strings are equal.
             */

            // Empty li by adding divider to an items "Title Attribute" in the Appearance > Menus dashboard
            if ( 0 === strcasecmp( $item->attr_title, 'divider' ) && 1 === $depth ) {

                $output .= $indent . '<li role="presentation" class="divider">';

            // Empty li by adding divider to an items "Navigation Label" in the Appearance > Menus dashboard
            } elseif ( 0 === strcasecmp( $item->title, 'divider' ) && 1 === $depth ) {

                $output .= $indent . '<li role="presentation" class="divider">';

            // Plain li (without a link) by adding dropdown-header to an items "Title Attribute" in the Appearance > Menus dashboard
            } elseif ( 0 === strcasecmp( $item->attr_title, 'dropdown-header' ) && 1 === $depth ) {

                $output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );

            // Hashtag anchor link by adding disabled to the "Title Attribue" in the Appearance > Menus dashboard
            } elseif ( 0 === strcasecmp( $item->attr_title, 'disabled' ) ) {

                $output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';

            } else {

                // Gets the initial slug based on the title
                $slug = $item->title;
                // Lower case everything the title
                $slug = strtolower($slug);
                // Removes all characters beyond letters and numbers
                $slug = preg_replace("/[^a-z0-9_\s-]/", "", $slug);
                // Clean up multiple dashes or whitespace
                $slug = preg_replace("/[\s-]+/", " ", $slug);
                //Convert whitespace and/or underscore to dash
                $slug = preg_replace("/[\s_]/", "-", $slug);

                // Creates the empty value variable
                $value = '';
                $class_names = $value;

                $classes = empty( $item->classes ) ? array() : (array) $item->classes;

                // Removes default Wordpress classes for both menu, page and current states
                $classes = preg_replace('/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', '', $classes);
                $classes = preg_replace('/^((menu|page)[-_\w+]+)+/', '', $classes);

                // Adds .menu-item and slug to the classes array
                $classes[] = 'menu-item '.$slug;

                // A filter hook that adds classes to the nav menu items
                $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

                // Adds .expandable-menu class to the $class_names array for the "parent" li if it has children
                if ( $args->has_children ) {
                    $class_names .= ' expandable-menu';
                }

                // Adds .current-page class to the $class_names array for the "current" page
                if ( in_array( 'current-menu-item', $item->classes, true ) ) {
                    $class_names .= ' current-page';
                }

                // Adds .current-page-ancestor class to the $class_names array for the "ancestor" page of the current page
                if ( in_array( 'current-page-ancestor', $item->classes, true ) ) {
                    $class_names .= ' current-page-ancestor';
                }

                // Applies the classes to the class selector
                $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

                 // A filter hook that applies the id to the "menu-item" id selector
                $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );

                // Applies the id to the id selector
                $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

                // Output for the li element with classes, id's and values applied
                $output .= $indent . '<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"' . $id . $value . $class_names . '>';

                // Creates the empty array to store potential data to the links
                $atts = array();

                // Link title attribute
                if ( empty( $item->attr_title ) ) {
                    $atts['title']  = ! empty( $item->title )   ? strip_tags( $item->title ) : '';
                } else {
                    $atts['title'] = "$item->attr_title";
                }

                // Link target attribute
                $atts['target'] = ! empty( $item->target ) ? $item->target : '';

                // Link rel attribute
                $atts['rel']    = ! empty( $item->xfn )    ? $item->xfn    : '';

                // If item has_children establish specific attributes and values
                if ( $args->has_children && 0 === $depth ) {

                    // If you don't want to add a link uncomments below and comment the one afterwards
                    // $atts['href']        = '#';
                    $atts['href']           = ! empty( $item->url ) ? $item->url : '';
                    $atts['class']          = 'expandable-link';
                    $atts['aria-haspopup']  = 'true';

                } else {

                    $atts['href'] = ! empty( $item->url ) ? $item->url : '';
                }

                // A filter hook that applies the attributes to the "menu-item" link
                $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

                // Creates the empty attribute variable
                $attributes = '';

                // Loops through and returns the values
                foreach ( $atts as $attr => $value ) {
                    
                    if ( ! empty( $value ) ) {
                        
                        $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                        $attributes .= ' ' . $attr . '="' . $value . '"';

                    }

                }

                // The begining of the the link markup.
                $item_output = $args->before;
                
                /*
                * Glyphicons/Font-Awesome
                * ===========
                * Since the the menu item is NOT a Divider or Header we check the see
                * if there is a value in the attr_title property. If the attr_title
                * property is NOT null we apply it as the class name for the glyphicon.
                */

                if ( ! empty( $item->attr_title ) ) {
                    $pos = strpos( esc_attr( $item->attr_title ), 'glyphicon' );
                    
                    if ( false !== $pos ) {
                        
                        $item_output .= '<a' . $attributes . '><span class="glyphicon ' . esc_attr( $item->attr_title ) . '" aria-hidden="true"></span>&nbsp;';

                    } else {

                        $item_output .= '<a' . $attributes . '><i class="fa ' . esc_attr( $item->attr_title ) . '" aria-hidden="true"></i>&nbsp;';

                    }

                } else {

                    $item_output .= '<a' . $attributes . '>';

                }

                // Link text
                $linkText = '<span class="link-text">'.$item->title.'</span>';

                // Puts the link together
                $item_output .= $args->link_before . apply_filters( 'the_title', $linkText, $item->ID ) . $args->link_after;

                // Adds a "icon" after the link text if theres are children
                $item_output .= ( $args->has_children ) ? ' <span class="caret"></span></a>' : '</a>';

                // Anything that would go ext after the link markup
                $item_output .= $args->after;

                // The hook that outputs the link
                $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

            }

        }

        /**
        * Traverse elements to create list from elements.
        *
        * Display one element if the element doesn't have any children otherwise,
        * display the element and its children. Will only traverse up to the max
        * depth and no ignore elements under that depth.
        *
        * This method shouldn't be called directly, use the walk() method instead.
        *
        * @see Walker::start_el()
        * @since 2.5.0
        *
        * @access public
        * @param mixed $element Data object.
        * @param mixed $children_elements List of elements to continue traversing.
        * @param mixed $max_depth Max depth to traverse.
        * @param mixed $depth Depth of current element.
        * @param mixed $args Arguments.
        * @param mixed $output Passed by reference. Used to append additional content.
        * @return null Null on failure with no changes to parameters.
        */

        public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
            
            if ( ! $element ) {
                
                return; 

            }

            $id_field = $this->db_fields['id'];

            // Display this element.
            if ( is_object( $args[0] ) ) {

                $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] ); 

            }
            
            parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );

        }

        /**
        * Menu Fallback
        * =============
        * If this function is assigned to the wp_nav_menu's fallback_cb variable
        * and a menu has not been assigned to the theme location in the WordPress
        * menu manager the function with display nothing to a non-logged in user,
        * and will add a link to the WordPress menu manager if logged in as an admin.
        *
        * @param array $args passed from the wp_nav_menu function.
        */

        public static function fallback( $args ) {
            
            if ( current_user_can( 'edit_theme_options' ) ) {

                /* Get Arguments. */
                $container = $args['container'];
                $container_id = $args['container_id'];
                $container_class = $args['container_class'];
                $menu_class = $args['menu_class'];
                $menu_id = $args['menu_id'];

                if ( $container ) {
                    
                    echo '<' . esc_attr( $container );
                    
                    if ( $container_id ) {
                        
                        echo ' id="' . esc_attr( $container_id ) . '"';
                    }

                    if ( $container_class ) {
                        
                        echo ' class="' . sanitize_html_class( $container_class ) . '"'; 

                    }

                    echo '>';
                }

                echo '<ul';

                    if ( $menu_id ) {
                        
                        echo ' id="' . esc_attr( $menu_id ) . '"'; 

                    }

                    if ( $menu_class ) {
                        
                        echo ' class="' . esc_attr( $menu_class ) . '"';

                    }
                    
                echo '>';
                    
                    echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" title="">' . esc_attr( 'Add a menu', '' ) . '</a></li>';
                    
                echo '</ul>';
                
                if ( $container ) {
                    
                    echo '</' . esc_attr( $container ) . '>'; 

                }
            }

        }

    }

}

?>
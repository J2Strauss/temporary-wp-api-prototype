<?php
/**
 * Plugin Name:       Custom Login by Bull Interactive
 * Description:       A plugin that replaces the WordPress login flow with a custom page.
 * Version:           1.0.0
 * Author:            By Bull Interactive - Referred to Jarkko Laine
 * License:           GPL-2.0+
 * Text Domain:       personalize-login
 */

/**
 * Plugin activation hook.
 *
 * Creates all WordPress pages needed by the plugin.
 */


// function restrict_post_deletion($post_ID){
// 	$role = get_role('administrator');
// 	$role->remove_cap('delete_pages');

//         echo "You are not authorized to delete this page.";
//         exit;
// }
// add_action('wp_trash_post', 'restrict_post_deletion', 10, 1);
// add_action('before_delete_post', 'restrict_post_deletion', 10, 1);

// =============================================================================
// Redirects to the login page if not logged in and not already on the page
// =============================================================================

add_action( 'template_redirect', function() {

    if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {

    	$login_url = site_url( '/login-access' );
    	$register_url = home_url( '/register-user' );

    	if( !is_page('login-access') ) {

	        if ( !is_user_logged_in() ) {

				wp_redirect( $login_url );
        		exit();

	        }

	    }	

	}

});

// =============================================================================
// Redirects to the custom account settings page if not a "admin"
// =============================================================================

add_action ('wp_loaded', 'profile_redirect');

function profile_redirect() {

	$account_url = home_url( '/account-settings' );
	
	global $pagenow;
		
	if(!current_user_can('create_users')) {

		if ($pagenow == 'profile.php') {
		    wp_redirect( $account_url);
	    	exit();
		}

	}
}


// =============================================================================
// Redirects to the custom registration form if it links to the WP backend
// =============================================================================

add_action( 'login_form_register', 'redirect_to_custom_register' );

function redirect_to_custom_register($user ) {

    $redirect_url = home_url();

    if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
        
   		$current_user = wp_get_current_user();
 
		if ( !empty( $current_user ) ) {

			if(current_user_can('create_users')) {
				
				$redirect_url = home_url( '/register-user' );

			} else {

				$redirect_url = home_url();

			}
			
        }

        wp_redirect( $redirect_url);
        exit;

    }
}

// =============================================================================
// Redirects to the dashboard if an admin or editor
// =============================================================================

function admin_login_redirect( $url, $request, $user ){
    
    $redirect_url = home_url();
        
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {

		//check for admins
		if ( in_array( 'administrator', $user->roles ) || in_array( 'editor', $user->roles ) ) {
			
			$redirect_url = admin_url();

		} else {

			$redirect_url = home_url();

		}
	} 

	wp_redirect( $redirect_url);
	exit();

}

add_filter('login_redirect', 'admin_login_redirect', 10, 3 );

// =============================================================================
// Redirects to the login page when logged out
// =============================================================================

add_action('wp_logout', function() {
	
	$login_url = site_url( '/login-access' );

	wp_redirect($login_url);
	exit();
	
});

// =============================================================================
// User registration
// =============================================================================

function register_user( $email, $username, $first_name, $last_name, $role ) {
    
    $errors = new WP_Error();
 
    // Email address is used as both username and email. It is also the only
    // parameter we need to validate
    if ( ! is_email( $email ) ) {
        $errors->add( 'email', get_error_message( 'email' ) );
        return $errors;
    }
 
    if ( username_exists( $username ) ) {
        $errors->add( 'username_exists', get_error_message( 'username_exists') );
        return $errors;
    }

    if ( username_exists( $email ) || email_exists( $email ) ) {
        $errors->add( 'email_exists', get_error_message( 'email_exists') );
        return $errors;
    }

 	if ( $username != "" ) {

     	$username = $username;

     } else {

     	$username = $email;
     }

     if ( !empty( $role ) ) {

     	$role = $role;

     } else {

     	$role = 'subscriber';

     }
 
    // Generate the password so that the subscriber will have to check email...
    $password = wp_generate_password( 12, false );
 
    $user_data = array(
        'user_login'    => $username,
        'user_email'    => $email,
        'user_pass'     => $password,
        'first_name'    => $first_name,
        'last_name'     => $last_name,
        'nickname'      => $first_name,
        'role'			=> $role
    );
 
    $user_id = wp_insert_user( $user_data );

    wp_new_user_notification( $user_id, null, 'both' );
 
    return $user_id;
}

add_action( 'login_form_register', 'do_register_user' ) ;

function do_register_user() {

    if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
        $redirect_url = home_url( '/register-user' );
 
        if ( ! get_option( 'users_can_register' ) ) {
            // Registration closed, display error
            $redirect_url = add_query_arg( 'register-errors', 'closed', $redirect_url );
        } else {

            $email = $_POST['email'];
            $role = $_POST['role'];
            $username = sanitize_text_field( $_POST['username'] );
            $first_name = sanitize_text_field( $_POST['first_name'] );
            $last_name = sanitize_text_field( $_POST['last_name'] );
 
            $result = register_user( $email, $username, $first_name, $last_name, $role);
 
            if ( is_wp_error( $result ) ) {
                // Parse errors into a string and append as parameter to redirect
                $errors = join( ',', $result->get_error_codes() );
                $redirect_url = add_query_arg( 'register-errors', $errors, $redirect_url );
            } else {
                // Success, redirect to login page.
                $redirect_url = home_url( 'login-access' );
                $redirect_url = add_query_arg( 'registered', $email, $redirect_url );
            }
        }
 
        wp_redirect( $redirect_url );
        exit;
    }
}

// =============================================================================
// Registration authentication error cases
// =============================================================================

// Retrieve possible errors from request parameters
$attributes['errors'] = array();
if ( isset( $_REQUEST['register-errors'] ) ) {
    $error_codes = explode( ',', $_REQUEST['register-errors'] );
 
    foreach ( $error_codes as $error_code ) {
        $attributes['errors'] []= get_error_message( $error_code );
    }
}

// =============================================================================
// Login uthentication check
// =============================================================================

add_filter( 'authenticate', 'maybe_redirect_at_authenticate', 101, 3 );

function maybe_redirect_at_authenticate( $user, $username, $password ) {
   
    // Check if the earlier authenticate filter (most likely, the default WordPress authentication) functions have found errors
    if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
        
        if ( is_wp_error( $user ) ) {
            
            $error_codes = join( ',', $user->get_error_codes() );
 
            $login_url = home_url( 'login-access' );
            $login_url = add_query_arg( 'login', $error_codes, $login_url );
 
            wp_redirect( $login_url );
            exit;
        }
        
    }
 
    return $user;
}

// =============================================================================
// Authentication error cases
// =============================================================================

function get_error_message( $error_code ) {
    switch ( $error_code ) {
        case 'empty_username':
            return __( 'You do have an email address, right?', 'personalize-login' );
 
        case 'empty_password':
            return __( 'You need to enter a password to login.', 'personalize-login' );
 
        case 'invalid_username':
            
            return __(
                "We don't have any users with that email address. Maybe you used a different one when signing up?",
                'personalize-login'
            );
 
        case 'incorrect_password':
            
            $err = __(
                "The password you entered wasn't quite right. <a href='%s'>Did you forget your password</a>?",
                'personalize-login'
            );
            return sprintf( $err, wp_lostpassword_url() );

       // Registration errors
		case 'email':
		    return __( 'The email address you entered is not valid.', 'personalize-login' );
		 
		case 'email_exists':
		    return __( 'An account exists with this email address.', 'personalize-login' );

		case 'username_exists':
		    return __( 'An account exists with this username.', 'personalize-login' );
		 
		case 'closed':
		    return __( 'Registering new users is currently not allowed.', 'personalize-login' );
 
        default:
            break;
    }
     
    return __( 'An unknown error occurred. Please try again later.', 'personalize-login' );
}




// =============================================================================
// Create the necessary pages for the plugin to work
// =============================================================================

function plugin_activated() {
	// Information needed for creating the plugin's pages
	$page_definitions = array(
		'login-access' => array(
			'title' => __( 'Sign In', 'personalize-login' ),
			'content' => '[custom-login-form]'
		),
		'account-settings' => array(
			'title' => __( 'Account Details', 'personalize-login' ),
			'content' => '[account-info]'
		),
		'register-user' => array(
			'title' => __( 'Register User', 'personalize-login' ),
			'content' => '[account-info]'
		),
	);

	foreach ( $page_definitions as $slug => $page ) {
		// Check that the page doesn't exist already
		$query = new WP_Query( 'pagename=' . $slug );

		if ( ! $query->have_posts() ) {
			// Add the page using the data from the array above
			wp_insert_post(
				array(
					'post_content'   => $page['content'],
					'post_name'      => $slug,
					'post_title'     => $page['title'],
					'post_status'    => 'publish',
					'post_type'      => 'page',
					'ping_status'    => 'closed',
					'comment_status' => 'closed',
				)
			);
			 
		} elseif( 'trash' == strtolower( $query->post_status ) ) {

			$query->post_status = 'publish';

			wp_update_post( $query );

		} // end if/else

	}



}


// =============================================================================
// Create the custom pages at plugin activation
// =============================================================================


add_action( 'after_setup_theme', 'plugin_activated' );

// =============================================================================
// Hide the trash button from the edit screens
// =============================================================================

add_filter( 'page_row_actions', 'remove_row_actions_page');

function remove_row_actions_page( $actions ) {
 	
 	$login = get_page_by_title('Sign In')->ID;
    $register = get_page_by_title('Register User')->ID;
    $account = get_page_by_title('Account Details')->ID;

	if( get_the_ID() == $login ) {
		
		unset( $actions['trash'] );
		
	} elseif( get_the_ID() == $register ) {
		
		unset( $actions['trash'] );

	} elseif( get_the_ID() == $account ) {
		
		unset( $actions['trash'] );

	} else {

		$actions;

	}
 
   return $actions;

}

// =============================================================================
// Disable delete entirely from the pages created by title/id
// =============================================================================

function restrict_post_deletion($post_ID){
    $login = get_page_by_title('Sign In')->ID;
    
    $register = get_page_by_title('Register User')->ID;
    
    $account = get_page_by_title('Account Details')->ID;
    
    if( get_the_ID() == $login || get_the_ID() == $register || get_the_ID() == $account ){
       
        echo '<style>html { background: #f1f1f1; } #error-page { background: #fff; color: #444; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif; margin: 50px auto 2em; padding: 1em 2em; max-width: 700px; -webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.13); box-shadow: 0 1px 3px rgba(0,0,0,0.13); } #error-page p { font-size: 14px; line-height: 1.5; margin: 25px 0 20px; }</style>';
        echo '<div id="error-page"><p>You are not authorized to delete this page. Please contact your websites administrator for more information or delete the Custom Login Pluggin.</p></div>';
        exit;

    }
}


add_action('wp_trash_post', 'restrict_post_deletion', 10, 1);
// add_action('before_delete_post', 'restrict_post_deletion', 10, 1);


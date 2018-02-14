<?php 

/**
 * Template Name: Account Details Page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package cohere-foundation
 */


global $current_user, $wp_roles;
$error = array();    

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {

    // Update user password.

    if ( !empty($_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) {
        
		if ( $_POST['pass1'] == $_POST['pass2'] ) {

			wp_update_user( array( 'ID' => $current_user->ID, 'user_pass' => esc_attr( $_POST['pass1'] ) ) );

		} else {
		
			$error[] = __('The passwords you entered do not match.  Your password was not updated.', 'profile');

		}

    }

	// Update user information.
    
    if ( !empty( $_POST['url'] ) ) {

        wp_update_user( array( 'ID' => $current_user->ID, 'user_url' => esc_url( $_POST['url'] ) ) );

    }

    if ( !empty( $_POST['email'] ) ) {

        if ( !is_email(esc_attr( $_POST['email'] )) ) {
            
            $error[] = __('The Email you entered is not valid.  please try again.', 'profile');

        } elseif(email_exists(esc_attr( $_POST['email'] )) != $current_user->ID ) {
            
            $error[] = __('This email is already used by another user.  try a different one.', 'profile');

        } else{

            wp_update_user( array ('ID' => $current_user->ID, 'user_email' => esc_attr( $_POST['email'] )));

        }

    }

	if ( !empty( $_POST['first-name'] ) ) {

		update_user_meta( $current_user->ID, 'first_name', esc_attr( $_POST['first-name'] ) );

	}
	
	if ( !empty( $_POST['last-name'] ) ) {
	
		update_user_meta($current_user->ID, 'last_name', esc_attr( $_POST['last-name'] ) );

	}

	if ( !empty( $_POST['description'] ) ) {
	
		update_user_meta( $current_user->ID, 'description', esc_attr( $_POST['description'] ) );

	}

	/* Redirect so the page will show updated info.*/

	if ( count($error) == 0 ) {
		
		//action hook for plugins and extra fields saving
		do_action('edit_user_profile_update', $current_user->ID);
		wp_redirect( get_permalink().'?update=success');
		exit;

	}
}

get_header(); ?>

	<div id="primary" class="content-area">
		
		<div id="main" class="site-main" role="main">

			<div class="container custom-update-user-form">
			    
			    <div class="row">
			        
			        <div class="col-sm-4 col-sm-offset-4">
			        
			            <div class="login-logo"></div>
			            
			        </div>
			    </div>

			    <div class="row">
			        
			        <div class="col-sm-6 col-sm-offset-3">

						<?php if ( is_user_logged_in() ) : ?>

							<?php $current_user = wp_get_current_user(); ?>

							<h4>Update Information for: <?php echo $current_user->user_login ?></h4>

							<?php // If information updated ?>

				         	<?php if ( isset( $_GET['update'] ) && $_GET['update'] == 'success' ) : ?> 

				            	<div class="form-response success updated">

				            		<p>Your profile has been updated.</p>

				            	</div> 

				           	<?php endif; ?>
							
							<?php // if ( isset( $_GET['update'] ) && $_GET['update'] == 'error' ) {
								
								if(count($error) > 0 ) {

									echo '<p class="status">Im sorry your profile was not updated.</p>'; 

									echo '<p class="error">' . implode("<br />", $error) . '</p>'; 

								//}

							} ?>

			            	<form id="update-user" method="post" action="<?php the_permalink(); ?>">
			                
			                    <div class="input-group">
			                        
			                        <label for="first-name"><?php _e('First Name', 'profile'); ?></label>
			                        <input class="text-input" name="first-name" type="text" id="first-name" value="<?php the_author_meta( 'first_name', $current_user->ID ); ?>" />

			                    </div><!-- .form-username -->

			                    <div class="input-group">
			                        
			                        <label for="last-name"><?php _e('Last Name', 'profile'); ?></label>
			                        <input class="text-input" name="last-name" type="text" id="last-name" value="<?php the_author_meta( 'last_name', $current_user->ID ); ?>" />

			                    </div><!-- .form-username -->
			                    
			                	<div class="input-group">

				                    <label for="display_name"><?php _e('Display name publicly as') ?></label>
					
									<select name="display_name" id="display_name"><br/>
										
										<?php
											$public_display = array();
											$public_display['display_nickname']  = $current_user->nickname;
											$public_display['display_username']  = $current_user->user_login;

											if ( !empty($current_user->first_name) )
												$public_display['display_firstname'] = $current_user->first_name;

											if ( !empty($current_user->last_name) )
												$public_display['display_lastname'] = $current_user->last_name;

											if ( !empty($current_user->first_name) && !empty($current_user->last_name) ) {
												$public_display['display_firstlast'] = $current_user->first_name . ' ' . $current_user->last_name;
												$public_display['display_lastfirst'] = $current_user->last_name . ' ' . $current_user->first_name;
											}

											if ( ! in_array( $current_user->display_name, $public_display ) ) // Only add this if it isn't duplicated elsewhere
												$public_display = array( 'display_displayname' => $current_user->display_name ) + $public_display;

											$public_display = array_map( 'trim', $public_display );
											$public_display = array_unique( $public_display );

											foreach ( $public_display as $id => $item ) :
										?>
											
											<option <?php selected( $current_user->display_name, $item ); ?>><?php echo $item; ?></option>
										<?php endforeach; ?>
									</select>

								</div><!-- .form-display_name -->

			                    <div class="input-group">

			                        <label for="email"><?php _e('E-mail *', 'profile'); ?></label>
			                        <input class="text-input" name="email" type="text" id="email" value="<?php the_author_meta( 'user_email', $current_user->ID ); ?>" />
			                    
			                    </div><!-- .form-email -->

			                    <div class="input-group">

			                        <label for="url"><?php _e('Website', 'profile'); ?></label>
			                        <input class="text-input" name="url" type="text" id="url" value="<?php the_author_meta( 'user_url', $current_user->ID ); ?>" />
			                    
			                    </div><!-- .form-url -->

			                    <div class="input-group">

			                        <label for="pass1"><?php _e('Password *', 'profile'); ?> </label>
			                        <input class="text-input" name="pass1" type="password" id="pass1" />
			                    
			                    </div><!-- .form-password -->

			                    <div class="input-group">

			                        <label for="pass2"><?php _e('Repeat Password *', 'profile'); ?></label>
			                        <input class="text-input" name="pass2" type="password" id="pass2" />
			                    
			                    </div><!-- .form-password -->

			                    <div class="input-group">

			                        <label for="description"><?php _e('Biographical Information', 'profile') ?></label>
			                        <textarea name="description" id="description" rows="3" cols="50"><?php the_author_meta( 'description', $current_user->ID ); ?></textarea>
			                    
			                    </div><!-- .form-textarea -->

			                    <div class="input-group">
			                        
			                        <input name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php _e('Update', 'profile'); ?>" />
			                        
			                        <?php wp_nonce_field( 'update-user_'. $current_user->ID ) ?>
			                        
			                        <input name="action" type="hidden" id="action" value="update-user" />

			                    </div><!-- .form-submit -->

			            	</form><!-- #update-user -->

			            <?php else : ?>

				            <div class="notice">
								
								<p>
				                        
				                	<?php _e('You must be logged in to edit your profile.', 'profile'); ?>
				                
				                </p>

				            </div>

			            <?php endif; ?>

			        </div>

				</div>

			</div>

		</div><!-- #main -->

	</div><!-- #primary -->

<?php get_footer(); ?>

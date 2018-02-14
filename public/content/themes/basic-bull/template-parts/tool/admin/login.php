<?php
	$loginForm = array(
		'echo'          	=> true,
		// 'redirect' => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
		'redirect'			=> home_url(),
		'form_id'			=> 'login-form',
		'label_username' 	=> __( 'Username' ),
		'label_password' 	=> __( 'Password' ),
		'label_remember' 	=> __( 'Remember Me' ),
		'label_log_in'   	=> __( 'Log In' ),
		'id_username'    	=> 'user_login',
		'id_password'    	=> 'user_pass',
		'id_remember'    	=> 'rememberme',
		'id_submit'      	=> 'wp-submit',
		'remember'       	=> true,
		'value_username' 	=> '',
		'value_remember' 	=> true
	);


?>
<div class="container custom-login-form">

	<div class="row">

		<div class="col-sm-4 col-sm-offset-4">

			<div class="login-logo"></div>
			
		</div>

	</div>
	
	<div class="row">

		 <div class="col-sm-6 col-sm-offset-3">

			<?php if ( ! is_user_logged_in() ) : ?>

				<h3>Please log in</h3>

				<?php // Display errors if they exist ?>

				<?php 

					$errors = array();
					
					if ( isset( $_REQUEST['login'] ) ) {
					
						$error_codes = explode( ',', $_REQUEST['login'] );

						foreach ( $error_codes as $code ) {
							
							$errors []= get_error_message( $code );
						
						}
					}
					
					$attributes['errors'] = $errors; ?>
					
					<?php if ( count( $attributes['errors'] ) > 0 ) : ?>
						
						<?php foreach ( $attributes['errors'] as $error ) : ?>
							
							<p class="login-error">
								
								<?php echo $error; ?>

							</p>
					
					<?php endforeach; ?>

				<?php endif; ?>

				<?php // Display login forms ?>

				<?php wp_login_form( $loginForm );  ?>

				<a class="forgot-password" href="<?php echo wp_lostpassword_url(); ?>">
			        
			        <?php _e( 'Forgot your password?', 'personalize-login' ); ?>

			    </a>

			<?php else : ?>

				<h3>You're Logged In</h3>
				
				<?php wp_loginout( home_url() ); ?> 

				<?php  

					$current_user = wp_get_current_user();
	 
	    			if ( !empty( $current_user ) ) {

	    				if(current_user_can('create_users')) {

	    					echo '| <a href="'.wp_registration_url().'">Register User</a>';
						
						}

					}

				?>

			<?php endif; ?>


		</div>
	</div>
</div>

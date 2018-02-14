<div class="container custom-registration-form">
    
    <div class="row">
        
        <div class="col-sm-4 col-sm-offset-4">
        
            <div class="login-logo"></div>
            
        </div>
    </div>

    <div class="row">
        
        <div class="col-sm-6 col-sm-offset-3">

            <h3>Register User</h3>

            <?php // Retrieve possible errors from request parameters ?>

            <?php 

                $attributes['errors'] = array();

                if ( isset( $_REQUEST['register-errors'] ) ) {
                    $error_codes = explode( ',', $_REQUEST['register-errors'] );
                 
                    foreach ( $error_codes as $error_code ) {
                        $attributes['errors'] []= get_error_message( $error_code );
                    }
                }

             ?>

            <?php if ( count( $attributes['errors'] ) > 0 ) : ?>
            
                <?php foreach ( $attributes['errors'] as $error ) : ?>
                
                     <div class="form-response error">

                        <p><?php echo $error; ?></p>

                    </div>
            
                <?php endforeach; ?>

            <?php endif; ?>

            <?php // Check if the user just registered ?>

            
            <?php 

                $attributes['registered'] = isset( $_REQUEST['registered'] );

                if ( $attributes['registered'] ) : 

            ?>
                
                <div class="form-response success">
                    
                    <p>
                        
                        <?php printf(__( 'You have successfully registered to <strong>%s</strong>. We have emailed your password to the email address you entered.', 'personalize-login' ), get_bloginfo( 'name' )); ?>

                    </p>
                
                </div>

            <?php endif; ?>


            <form id="register-form" action="<?php echo wp_registration_url(); ?>" method="post">
                
                <div class="input-group">
                    
                    <label for="email"><?php _e( 'Email', 'personalize-login' ); ?> <strong>*</strong></label>
                    <input type="text" name="email" id="email">

                </div>

                <div class="input-group">
                    
                    <label for="username"><?php _e( 'Username', 'personalize-login' ); ?></label>
                    <input type="text" name="username" id="username">

                </div>
         
                <div class="input-group">

                    <label for="first_name"><?php _e( 'First name', 'personalize-login' ); ?></label>
                    <input type="text" name="first_name" id="first-name">

                </div>
         
                <div class="input-group">

                    <label for="last_name"><?php _e( 'Last name', 'personalize-login' ); ?></label>
                    <input type="text" name="last_name" id="last-name">

                </div>

                <?php 

                    if ( ! function_exists( 'get_editable_roles' ) ) {
                        require_once ABSPATH . 'wp-admin/includes/user.php';
                    }

                    $roles = get_editable_roles(); 

                ?>

                <?php if ( $roles != "" ) : ?>

                     <div class="input-group">

                        <label for="role"><?php _e( 'Role', 'personalize-login' ); ?></label>

                        <select name="role" id="role">

                            <option value selected>- Change User Role -</option>

                            <?php foreach ($roles as $role_name => $role_info): ?>

                                <?php if ($role_name != "administrator"): ?>
                                    
                                    <option value="<?php echo $role_name ?>"><?php echo $role_name ?></option>
                                    
                                <?php endif ?>
                           
                            <?php endforeach; ?>

                        </select>

                    </div>

                <?php endif; ?>
         
                <div class="form-note">
                    
                    <p>
                    
                        <?php _e( 'Note: Your password will be generated automatically and sent to your email address.', 'personalize-login' ); ?>

                    </p>

                </div>
         
                <div class="input-group">

                    <input type="submit" name="submit" class="button white-button" value="<?php _e( 'Register', 'personalize-login' ); ?>"/>

                 </div>

            </form>

        </div>

    </div>

</div>
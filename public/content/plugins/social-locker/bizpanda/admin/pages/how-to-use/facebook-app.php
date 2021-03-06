<div class="onp-help-section">
    <h1><?php _e('Creating Facebook App', 'bizpanda'); ?></h1>
    
    <p>
        <?php _e('A Facebook App is required for the following buttons:', 'bizpanda'); ?>
        <ul>
            <?php if ( BizPanda::hasPlugin('sociallocker') ) { ?>
            <li><?php _e('Facebook Share of the Social Locker.', 'bizpanda') ?></li>
            <?php } ?>
            <li><?php _e('Facebook Sign-In of the Sign-In Locker.', 'bizpanda') ?></li>
            <?php if ( BizPanda::hasPlugin('optinpanda') ) { ?>
            <li><?php _e('Facebook Subscribe of the Email Locker.', 'bizpanda') ?></li>      
            <?php } ?>
        </ul>
    </p>
    <p><?php _e('If you want to use these buttons, you need to register a Facebook App for your website. Otherwise you can use the default Facebook App Id (117100935120196).', 'bizpanda') ?></p>
    <p><?php _e('In other words, <strong>you don\'t need to create an own app</strong> if you\'re not going to use these Facebook buttons.') ?></p>

</div>

<div class="onp-help-section">
    <p><?php printf( __('1. Open the website <a href="%s" target="_blank">developers.facebook.com</a> and click "Add a New App" (you have to be logged in):', 'bizpanda'), 'https://developers.facebook.com/' ) ?></p>
    <p class='onp-img'>
        <img src="http://cconp.s3.amazonaws.com/bizpanda/facebook-app/v2/1.png">
    </p>
</div>

<div class="onp-help-section">
    <p><?php _e('2. Type your app name (it will be visible for users), email address (for notifications from Facebook) and click "Create App ID":', 'bizpanda') ?></p>
    <p class="onp-img">
        <img src="http://cconp.s3.amazonaws.com/bizpanda/facebook-app/v2/2.png">
    </p>
</div>

<div class="onp-help-section">
    <p><?php _e('3. Pass the security check if needed by typing the code displaying on the picture and clicking on "Submit":', 'bizpanda') ?></p>
    <p class="onp-img">
        <img src="http://cconp.s3.amazonaws.com/bizpanda/facebook-app/v2/3.png">
    </p>
</div>

<div class="onp-help-section">
    <p><?php _e('4. Click "Settings" in the menu at the left:', 'bizpanda') ?></p>
    <p class="onp-img">
        <img src="http://cconp.s3.amazonaws.com/bizpanda/facebook-app/v2/4.png">
    </p>
</div>

<div class="onp-help-section">
    <p><?php _e('5. Twice enter your site domain name: without "www" and with "www", check your email address, set the category and click "+ Add Platform":', 'bizpanda') ?></p>
    <p class="onp-img">
        <img src="http://cconp.s3.amazonaws.com/bizpanda/facebook-app/v2/5.png">
    </p>
</div>

<div class="onp-help-section">
    <p><?php _e('6. Click "Website":', 'bizpanda') ?></p>
    <p class="onp-img">
        <img src="http://cconp.s3.amazonaws.com/bizpanda/facebook-app/v2/6.png">
    </p>
</div>

<div class="onp-help-section">
    <p><?php _e('7. Specify an URL of your website and save the changes:', 'bizpanda') ?></p>
    <p class="onp-img">
        <img src="http://cconp.s3.amazonaws.com/bizpanda/facebook-app/v2/7.png">
    </p>
</div>

<div class="onp-help-section">
    <p><?php _e('8. Move to the section "App Review":', 'bizpanda') ?></p>
    <p class="onp-img">
        <img src="http://cconp.s3.amazonaws.com/bizpanda/facebook-app/v2/8.png">
    </p>
</div>

<div class="onp-help-section">
    <p><?php _e('9. Make your app available to the general public:', 'bizpanda') ?></p>
    <p class="onp-img">
        <img src="http://cconp.s3.amazonaws.com/bizpanda/facebook-app/v2/9.png">
    </p>
</div>

<div class="onp-help-section">
    <p><?php _e('10. Copy your app id:', 'bizpanda') ?></p>
    <p class="onp-img">
        <img src="http://cconp.s3.amazonaws.com/bizpanda/facebook-app/v2/10.png">
    </p>
</div>

<div class="onp-help-section">
    <p><?php printf( __('11. Paste your Facebook App Id on the page Global Settings > <a href="%s">Social Options</a>.', 'bizpanda' ), opanda_get_settings_url('social') ) ?></p>
</div>
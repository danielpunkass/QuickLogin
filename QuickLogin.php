<?php /*

**************************************************************************

Plugin Name:  QuickLogin
Plugin URI:   https://github.com/danielpunkass/QuickLogin
Version:      1.0.2
Description:  Adds a keyboard shortcut to your blog for easily logging in.
Author:       Daniel Jalkut, Red Sweater Software
Author URI:   http://www.red-sweater.com/blog/

**************************************************************************/

// If you want to use another keystroke besides ESC, set it here
$triggerKeyCode = apply_filters( 'quicklogin_keycode', 27);

function insertQuickLoginTrigger() {

    // When the user "logs in" we send them to the appropriate login page URL, redirecting to current URL
    $loginPageURL = wp_login_url( ( is_ssl() ? "https://" : "http://" ) . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] );
    global $triggerKeyCode

    ?>

    <script type="text/javascript">
    //QuickLogin by Red Sweater Software

    document['onkeyup'] = function(event){
        var e = event || window.event;

        var triggerKeyCode = <?php echo $triggerKeyCode; ?>;
        var loginPageURL = "<?php echo $loginPageURL; ?>";

        if ( e.keyCode == triggerKeyCode ) {
            document.location.href=loginPageURL;
        }
    }
    </script>

    <?php

}

function insertQuickAdminTrigger() {

    // If the user is already logged in, send them to the dashboard.
    $adminPageURL = admin_url();
    global $triggerKeyCode

    ?>

    <script type="text/javascript">
    //QuickLogin by Red Sweater Software

    document['onkeyup'] = function(event){
        var e = event || window.event;

        var triggerKeyCode = <?php echo $triggerKeyCode; ?>;
        var adminPageURL = "<?php echo $adminPageURL; ?>";

        if ( e.keyCode == triggerKeyCode ) {
            document.location.href=adminPageURL;
        }
    }
    </script>

    <?php

}

// We may not implicitly get the is_user_logged_in() function from pluggable.php, 
// so define it ourselves if needed.
if ( !function_exists('is_user_logged_in') ) :
function is_user_logged_in() {
	$user = wp_get_current_user();

	if ( empty( $user->ID ) )
		return false;

	return true;
}
endif;

function insertTriggerCode() {
	if( is_user_logged_in() ) {
		add_action('wp_head', 'insertQuickAdminTrigger');
	}
	else {
		add_action('wp_head', 'insertQuickLoginTrigger');
	}
}

add_action('init', 'insertTriggerCode');

?>

<?php /*

**************************************************************************

Plugin Name:  QuickLogin
Plugin URI:   https://github.com/danielpunkass/QuickLogin
Version:      1.0
Description:  Adds a keyboard shortcut to your blog for easily logging in.
Author:       Daniel Jalkut, Red Sweater Software
Author URI:   http://www.red-sweater.com/blog/

**************************************************************************/

function enqueueQuickLoginScripts() {

	if( is_user_logged_in() ) {
		return;
	}
	
	// We depend upon jQuery that is bundled with WordPress, for easy keystroke detection
	wp_enqueue_script("jquery"); 
}
add_action('init', 'enqueueQuickLoginScripts');

function insertQuickLoginTrigger() {

	if( is_user_logged_in() ) {
		return;
	}
	
	// If you want to use another keystroke besides ESC, set it here
	$triggerKeyCode = 27;

	// When the user "logs in" we send them to the appropriate login page URL, redirecting to current URL
	$loginPageURL = wp_login_url(get_permalink());
	
	echo <<<TRIGGEREND
	<script type="text/javascript">
	//QuickLogin by Red Sweater Software

	var triggerKeyCode = $triggerKeyCode;

	jQuery(document).keyup(function(e) {
		if (e.keyCode == triggerKeyCode) {
			promptForWordPressLogin();
		}
	});

	function promptForWordPressLogin() {
		document.location.href="$loginPageURL";
	}

	</script>
TRIGGEREND;
}
add_action('wp_head', 'insertQuickLoginTrigger');

?>
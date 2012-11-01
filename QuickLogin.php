<?php /*

**************************************************************************

Plugin Name:  QuickLogin
Plugin URI:   https://github.com/danielpunkass/QuickLogin
Version:      1.0.1
Description:  Adds a keyboard shortcut to your blog for easily logging in.
Author:       Daniel Jalkut, Red Sweater Software
Author URI:   http://www.red-sweater.com/blog/

**************************************************************************/

// If you want to use another keystroke besides ESC, set it here
$triggerKeyCode = 27;

// We depend upon get-current-user type functions, which are not defined by default
// until AFTER the plugin is given a chance to override.
require_once(ABSPATH . WPINC . '/pluggable.php');

function insertQuickLoginTrigger() {

	// When the user "logs in" we send them to the appropriate login page URL, redirecting to current URL
	$loginPageURL = wp_login_url(get_permalink());
	global $triggerKeyCode;
	
	echo <<<TRIGGEREND
	<script type="text/javascript">
	<!-- QuickLogin by Red Sweater Software

	var triggerKeyCode = $triggerKeyCode;

	jQuery(document).keyup(function(e) {
		if (e.keyCode == triggerKeyCode) {
			promptForWordPressLogin();
		}
	});

	function promptForWordPressLogin() {
		document.location.href="$loginPageURL";
	}

	-->
	</script>
TRIGGEREND;
}

$isLoggedIn = is_user_logged_in();

if ($isLoggedIn == False) {
	function load_scripts() {
		// We depend upon jQuery that is bundled with WordPress, for easy keystroke detection
		wp_enqueue_script("jquery"); 
	}
	add_action('wp_enqueue_scripts', 'load_scripts');
	add_action('wp_head', 'insertQuickLoginTrigger');
}

?>

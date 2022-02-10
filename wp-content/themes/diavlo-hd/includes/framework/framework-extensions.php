<?php 
/* file: framework-extensions.php
 * purpose: contains all support functions for the i3d-framework system
 *          that can be included either directly in the theme package, or 
 *          within an external plugin
 */
 
function i3d_framework_extension_exists() { return true; }

require_once("custom-post-types/faqs.php");
require_once("custom-post-types/portfolio-items.php");
require_once("custom-post-types/team-members.php");
require_once("custom-post-types/testimonials.php");

require_once("special-components/calls-to-action.php");
require_once("special-components/contact-forms.php");
require_once("special-components/content-panel-groups.php");
require_once("special-components/focal-boxes.php");
require_once("special-components/enqueue.php");


/** SHORT CODES **/
add_shortcode('theme_root', 'i3d_theme_root');
add_shortcode('i3d_get_theme_pre_footer', 'i3d_get_theme_pre_footer'); 	// contained within the theme's functions.php
add_shortcode('i3d_example_styles', 'i3d_example_styles');				// contained within the theme's functions.php
add_shortcode('i3d_included_features', 'i3d_included_features'); 		// contained within the theme's functions.php
add_shortcode('i3d_copyright_message', 'i3d_copyright_message'); 		
add_shortcode('i3d_powered_by_message', 'i3d_powered_by_message'); 		


function i3d_theme_root($atts) {
  return get_stylesheet_directory_uri();
}

function i3d_load_recaptcha_lib() {
	require_once("google-recaptcha/recaptchalib.php");  
}

function i3d_copyright_message() {
	global $copyright_message;
	global $copyright_wrapper;
	//echo '<h6 data-wow-delay="2s" class="wow fadeIn">'.$copyright_message.'</h6>';	
	echo str_replace("[copyright_message]", $copyright_message, $copyright_wrapper);	

}

function i3d_powered_by_message() {
	global $powered_by_message;
	global $powered_by_wrapper;
	echo str_replace("[powered_by_message]", $powered_by_message, $powered_by_wrapper);	
}


require_once("google-recaptcha/recaptchalib.php");
?>
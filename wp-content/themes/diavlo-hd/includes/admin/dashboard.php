<?php
function luckymarble_dashboard_instructions() {
	global $templateName;
	$helpLocation = strtolower(str_replace(" ", "_", $templateName))."-wp2";
	echo "For help with this theme, please proceed to the <a target='_blank' href='http://www.luckymarble.com/members/product/helpsys/wordpress/all/".$helpLocation."/'>Instruction Center</a>.";
}

function i3d_add_dashboard_widgets() {
	global $templateName;
	global $wp_meta_boxes;

	wp_add_dashboard_widget('i3d_theme_manager_widget', ''.get_option("current_theme").' WordPress Theme Help Topics', array("I3D_Framework", "render_dashboardManager"));
	
	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
	$side_dashboard = $wp_meta_boxes['dashboard']['side']['core'];
	$widget_backup = array('i3d_theme_manager_widget' => $normal_dashboard['i3d_theme_manager_widget']);
	unset($normal_dashboard['i3d_theme_manager_widget']);
	$sorted_dashboard = array_merge($widget_backup, $side_dashboard);
	$wp_meta_boxes['dashboard']['side']['core'] = $sorted_dashboard;
	$wp_meta_boxes['dashboard']['normal']['core'] = $normal_dashboard;



}

//add_action('wp_dashboard_setup', 'i3d_add_dashboard_widgets' );
?>
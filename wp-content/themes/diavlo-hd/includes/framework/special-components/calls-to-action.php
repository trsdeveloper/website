<?php
add_shortcode('i3d_cta', 	'i3d_cta');


function i3d_cta($atts) {
	global $page;
		
	extract($atts);	
	global $i3dBootstrapVersion;
	
	$ctas = get_option("i3d_calls_to_action");
	$cta = $ctas["$id"];
	ob_start();
	the_widget( 'I3D_Widget_CallToAction', array("is_short_tag" => true, "id" => $id));


	return ob_get_clean();
}




?>
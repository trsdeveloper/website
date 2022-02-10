<?php
add_shortcode('i3d_fb', 	'i3d_fb');


function i3d_fb($atts) {
	global $page;
		
	extract($atts);	
	global $i3dBootstrapVersion;
	
	$fbs = get_option("i3d_focal_boxes");
	$fb = $fbs["$id"];
	ob_start();
	the_widget( 'I3D_Widget_FocalBox', array("is_short_tag" => true, "id" => $id));


	return ob_get_clean();
}
?>
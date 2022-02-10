<?php
require("includes/user_view/template-header.php");

//I3D_Framework::template_header();
//print "yes";
if (I3D_Framework::use_global_layout()) {
	$post_cat = get_queried_object();
	//print $post_cat->post_type;
	if ($post_cat->post_type == "i3d-faq") {
	  $page_id = get_option("page_for_faqs");	
	} else if ($post_cat->post_type == "i3d-team-member") {
		//print "team member";
	  $page_id = get_option("page_for_team-members");	
	} 
	

	I3D_Framework::render_page_in_layout($page_id);
	return;
} else {


	if ($pageTemplate == "default" || $pageTemplate == "") {
		require("template-minimized.php");
	} else {
		require("template-{$pageTemplate}.php");
	}
}
?>
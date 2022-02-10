<?php
// call on the template header
require("includes/user_view/template-header.php");

// for those themes using the new global layout editor
if (I3D_Framework::use_global_layout()) {
	$post_cat = get_queried_object();
	
	if ($post_cat->post_type == "i3d-faq") {
	  $page_id = get_option("page_for_faqs");	
	  
	} else if ($post_cat->post_type == "i3d-team-member") {
	  $page_id = get_option("page_for_team-members");	
	} else if ($post_cat->post_type == "i3d-portfolio-item") {
	  $page_id = get_option("page_for_portfolio_items");	
	}
	

	I3D_Framework::render_page_in_layout($page_id);
	
	//return;
	
// for legacy themes
} else {
	if ($pageTemplate == "default" || $pageTemplate == "") {
		require("template-minimized.php");
	} else {
		require("template-{$pageTemplate}.php");
	}
}

global $i3d_using_external_header_call, $i3d_footer_output;
if (@$i3d_using_external_header_call) {
  echo $i3d_footer_output;
}

?>
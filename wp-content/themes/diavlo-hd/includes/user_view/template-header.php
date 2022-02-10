<?php
global $myPageID, $pageTemplate, $pageColumns, $supportedSidebars, $page_id, $onBlog, $postCat, $wp_query, $post_type, $author;

$pageTemplate = "";
$pageColumns  = "";

I3D_Framework::assert_extensions();
if ($page_id == 0) {
	$page_object = get_queried_object();

	$page_id     = get_queried_object_id();
	$pageMeta = get_post_meta($page_id);
	if (@$pageMeta['_wp_page_template'][0] != "") {
		$pageTemplate = str_replace("template-", "", str_replace(".php", "", $pageMeta['_wp_page_template'][0]));
	}
	
	$postCat = get_queried_object();
	
   
	if ((
		@$postCat->post_type != "page" && 
		(@$postCat->post_type == "post" || 
		 @$postCat->post_type == "i3d-faq" ||
		 @$postCat->post_type == "i3d-team-member" ||
		 @$postCat->post_type == "i3d-portfolio-item" ||
		 @$postCat->post_type == "i3d-testimonial" ||
		 @$postCat->taxonomy == "category" || @$postCat->post_type == "i3d-portfolio-item" || @$postCat->taxonomy == "i3d-faq-category" || @$postCat->taxonomy == "i3d-team-member-department"))) {
	     $onBlog = true;
		 if (get_post_type() == 'i3d-team-member') {
			 $page_id = get_option("page_for_team_members");
		 
		 } else if (get_post_type() == 'i3d-faq') {
			 $page_id = get_option("page_for_faqs");
	
		 } else if (get_post_type() == 'i3d-portfolio-item') {
			 $page_id = get_option("page_for_portfolio_items");
		  
		 } else {
			$onBlog = true;
			 $page_id = get_option("page_for_posts");
		 }
	} else if (@$postCat->taxonomy == "post_tag") {
	  $onBlog = true;
	  		 $page_id = get_option("page_for_posts");

	} else if ($author != "") {
	   $onBlog = true;
	   $page_id = get_option("page_for_posts");
/*
	} else if ($postCat->post_type == 'tribe_events') {
		   $page_id = get_option("page_for_events");
		   if ($page_id == "") {
		   		$page_id = get_option("page_for_posts");
		   }
	 */
	} else if ($post_type == "tribe_events") {
		//print "yup";
		$pageTemplate = "events-calendar";
		   $page_id = get_option("page_for_events");
		   if ($page_id == "") {
		   		$page_id = get_option("page_for_posts");
		   }
		
	} else if ($pageTemplate == "blog") {
		//query_posts(array());
	} else if (is_search()) {
	  $page_for_search_results = get_option("page_for_search_results");
	  if ($page_for_search_results) {
		  $page_id = $page_for_search_results;
	  }
	  
	}
	
}

// if the page specified is the one indicated as the blog, be sure to force it to have a page_id of zero (so that it actually displays the blog and not the "page")
if ($page_id == get_option('page_for_posts') && $page_id == get_option("page_on_front") && !$onBlog) {
	$page_id = 0;
  // re query the posts
 
  query_posts(array());
}

if (is_front_page() && !$onBlog) {
	 $page_id = get_option("page_on_front");
} else if (get_option('page_for_posts') == get_option("page_on_front") && $page_id == 0) {
  $page_id = get_option('page_for_posts');
 // print "yes";
  $onBlog = true;
} else if ($onBlog) {
//	print "mmhmm";
  $page_id = get_option('page_for_posts');

} else if (is_404() && I3D_Framework::use_global_layout()) {
  //	print "yes";
	
} else if ($page_id == 0) {
if ($postCat->rewrite["slug"] == "directories") {
   // for RPeck, Directory Plugin
 } else {
 	//print "x".$postCat->taxonomy."<br>";

 	$page_id = get_option('page_for_posts');
 	$onBlog = true;
	// disabled as it makes every page the home page
}

} else {
	//print "no";
}


$myPageID = $page_id;
@include('setting_values.php');

	//if (I3D_Framework::use_global_layout()) {
//	  	 $pageTemplate = "";
//	} else {
if ($pageTemplate == "" || I3D_Framework::use_global_layout()) {
		$pageTemplate = "default";
}

function i3d_external_header_call() {}

global $i3d_using_external_header_call;

if ($i3d_using_external_header_call) {
  global $i3d_header_output;
  echo ($i3d_header_output);
} else {
  get_header();
}


$myPageID = $page_id;
if (is_front_page()) {
//	print "front page";
//	  var_dump( $post);
}
//print "pageTemplate: $pageTemplate ]]";
if ( ! isset( $content_width ) ) $content_width = 1170;


?>
<?php
global $templateName;
global $layoutOptions;
global $settingOptions;
global $onBlog;

$settingOptions = get_option('i3d_general_settings');
//var_dump($settingOptions);
$layoutOptions  = get_option('i3d_layout_regions');

$pageMeta = get_post_meta($page_id);
if ($pageMeta['_wp_page_template'][0] != ""  && !I3D_Framework::use_global_layout()) {
  $pageTemplate = str_replace("template-", "", str_replace(".php", "", $pageMeta['_wp_page_template'][0]));
}

//print $original_page_id."-".$page_id;
if ($pageTemplate == "blog" && !$onBlog) {
	//query_posts('showposts=10'); // disabled April 23rd
	
  //$args = $wp_query->query_vars;
  //$wp_query->set("name", "");
  //$wp_query->set("pagename", "");
//  $wp_query->query_vars['name'] = "";
 // $args = $wp_query->query_vars;
  
  //print "<pre>";
 // var_dump($args);
 // print "</pre>";
  
  //$wp_query->init();
  //$wp_query->query($args);
  //$wp_query = new WP_Query($args);
  //print "<pre>";
 // var_dump($wp_query->query_vars);
 // print "</pre>";
 // $wp_query->parse_query_vars();
 // $wp_query->get_posts();

 // print "<pre>";
 // var_dump($wp_query->query_vars);
 // print "</pre>";

//$args['name'] = "";
 // $wp_query = new WP_Query($args);
  //print "need to assert that we are looking for posts and not the page data";	
}
//exit;

// disabled June 5, 2017
/*
foreach ($settingOptions as $key => $value) {
	global $$key;
	$$key = $value;
}
*/
global $copyright_message;
global $powered_by_message;
global $code_custom_css;
global $code_end_of_body;
global $code_end_of_head;
$copyright_message = $settingOptions['copyright_message'];
$powered_by_message = $settingOptions['powered_by_message'];
$code_custom_css = $settingOptions['code_custom_css'];
$code_end_of_head = $settingOptions['code_end_of_head'];
$code_end_of_body = $settingOptinos['code_end_of_body'];

//print "pageTemplate : $pageTemplate";
//print "trying to include config";
include_once("config.php");
?>
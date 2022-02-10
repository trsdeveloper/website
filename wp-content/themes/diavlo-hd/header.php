<?php
global $page_layout, $settingOptions, $typography, $code_custom_css, $code_end_of_head, $pageTemplate, $pageColumns, $defaultTemplate, $myPageID, $defaultColumns, $lmCssMap, $layout_max_content_width, $i3dBodyAttributes;
global $i3d_using_external_header_call;
global $i3d_header_output;
if (!function_exists("i3d_external_header_call")) {
  $i3d_using_external_header_call = true;
    ob_start();

}
// global array used throughout the theme
$settingOptions = wp_parse_args( (array) $settingOptions, array( 'tablet_responsive' => '','mobile_responsive' => '', 'layout_max_content_width' => '') );

// used as basic seo
$pageKeywords     = get_post_meta($myPageID, 'i3d_page_meta_keywords', true);
$pageDescription  = get_post_meta($myPageID, 'i3d_page_meta_description', true);

if ($pageTemplate == null) {
	// check to see if a page has been assigned to display blog posts
	$blogPageId = get_option('page_for_posts');
	$myPageID   = $blogPageId;

	$pageKeywords     = get_post_meta($blogPageId, 'i3d_page_meta_keywords', true);
	$pageDescription  = get_post_meta($blogPageId, 'i3d_page_meta_description', true);

	// if still not found, set default values
	if($pageTemplate == null) {
		$pageTemplate = $defaultTemplate;
		$pageColumns  = $defaultColumns;
	}
} 

ob_start(); // this is so that form submissinos may happen
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
<meta charset="utf-8" />

<?php 
// this feature now disabled as WordPress SEO is now recommended seo provider
// I3D_Framework::page_metadata($pageKeywords, $pageDescription); 
?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php

wp_head(); ?>
<?php if (I3D_Framework::$embedded_style_css) { ?>
<link rel="stylesheet" id="aquila-theme-style-css" type="text/css" href="<?php echo get_stylesheet_directory_uri()."/style.css"; ?>" media="all" />
<?php } ?>
<?php if (array_key_exists("mobile_responsive", $settingOptions) && $settingOptions['mobile_responsive'] == "1") { ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php }  ?>

<?php if ($pageTemplate != "intro" && $page_layout != "intro") { ?>
<script>var $ = jQuery.noConflict();</script>
<?php } ?>
<!-- ie compatibility -->
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<![endif]-->

<!--[if lt IE 9]>
<script src="Site/javascript/bootstrap/html5shiv.js"></script>
<![endif]-->
<?php $typography->googleFontLinks(); ?>
<style type='text/css'>
<?php if ($settingOptions['layout_max_content_width'] != "") { ?> 
.container { width: 100%; max-width: <?php echo trim(str_replace("%", "", str_replace("px", "", $settingOptions['layout_max_content_width']))); ?>px; }
.main-wrapper { max-width: <?php echo trim(str_replace("%", "", str_replace("px", "", $settingOptions['layout_max_content_width']))); ?>px; margin-left: auto; margin-right: auto; }
<?php } ?>
<?php if (I3D_Framework::$headerBGSupport) { 
  $fileName = "";
  if (wp_attachment_is_image(get_post_meta($myPageID, 'header_bg_image', true))) { 
                                                $metaData = get_post_meta(get_post_meta($myPageID, 'header_bg_image', true), '_wp_attachment_metadata', true);
                                                $fileName = I3D_Framework::get_image_upload_path($metaData['file']);			
  
  } else if (wp_attachment_is_image($settingOptions['header_bg_filename'])) {
                                                $metaData = get_post_meta($settingOptions['header_bg_filename'], '_wp_attachment_metadata', true);
                                                $fileName = I3D_Framework::get_image_upload_path($metaData['file']);			
                                                
  }  
  if ($fileName != "") {
  ?> <?php echo I3D_Framework::$headerBGClassName; ?> { background-image: url(<?php echo $fileName; ?>);  <?php echo I3D_Framework::$headerBGStyles; ?>} 
  <?php } ?>
<?php } ?>



/* Custom CSS Settings */
<?php echo $code_custom_css; ?>

/* Custom Typograpy Settings */
<?php echo $typography->getStyles(); ?>

/* Active Background Styles */
<?php I3D_Framework::render_active_background_styles(); ?>
</style>
<?php echo $code_end_of_head; ?>
<?php if ($pageTemplate == "intro" || $page_layout == "intro") { ?>
<style> .edgeLoad-EDGE-202142810 	{ visibility:hidden; } </style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<?php } ?>
<?php if (@$settingOptions['custom_fav_icon'] != "") { ?>
<link rel="shortcut icon" href="<?php echo array_shift(wp_get_attachment_image_src( $settingOptions['custom_fav_icon'], 'full' )); ?>" type="image/x-icon" />
<?php } ?>
<?php if(@$settingOptions['custom_icon_iphone'] != "") { ?>
<!-- For iPhone -->
<link rel="apple-touch-icon-precomposed" href="<?php echo array_shift(wp_get_attachment_image_src( $settingOptions['custom_icon_iphone'], 'full' )); ?>">
<?php } ?>
<?php if(@$settingOptions['custom_icon_iphone_retina'] != "") { ?>
<!-- For iPhone 4 Retina display -->
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo array_shift(wp_get_attachment_image_src( $settingOptions['custom_icon_iphone_retina'], 'full' )); ?>">
<?php } ?>
<?php if(@$settingOptions['custom_icon_ipad'] != "") { ?>
<!-- For iPad -->
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo array_shift(wp_get_attachment_image_src( $settingOptions['custom_icon_ipad'], 'full' )); ?>">
<?php } ?>
<?php if(@$settingOptions['custom_icon_ipad_retina'] != "") { ?>
<!-- For iPad Retina display -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo array_shift(wp_get_attachment_image_src( $settingOptions['custom_icon_ipad_retina'], 'full' )); ?>">
<?php } ?>

</head>
<?php 
// condition the body class
if (!isset($class)) { $class = ""; }
if (I3D_Framework::use_global_layout()) {
  $class .= " i3d-layout-editor i3d-layout-{$page_layout}";
}

if (!isset($i3dBodyAttributes)) { $i3dBodyAttributes = ""; } 
?>
<body <?php body_class( $class ); ?> <?php echo $i3dBodyAttributes; ?>>
<?php @include("theme-header.php"); 
if (@$i3d_using_external_header_call) {
  $i3d_header_output = ob_get_clean();
  ob_start();
}
?>
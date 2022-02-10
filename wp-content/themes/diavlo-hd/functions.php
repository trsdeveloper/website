<?php
$templateName = ucwords(get_option("current_theme"));

/***********************/
/**** INCLUDE FILES ****/
/***********************/
require_once(TEMPLATEPATH."/includes/framework/framework-class.php");
require_once(TEMPLATEPATH.'/includes/framework/includes.php');
require_once(TEMPLATEPATH.'/includes/admin/includes.php');
require_once(TEMPLATEPATH.'/includes/user_view/includes.php');
require_once(TEMPLATEPATH.'/includes/user_view/short_tags.php');
require_once(TEMPLATEPATH.'/includes/framework/functions.php');

if (!is_admin()) {
  add_action("wp_enqueue_scripts", "i3d_enqueue_scripts", 11) ;
}

function i3d_enqueue_scripts() {
	global $page_id, $settingOptions, $pageTemplate;
    $themeRoot = get_stylesheet_directory_uri();


	global $page_layout;
	global $page_content_type;
	$page_layout = "";
	$page_content_type = "";
	if (I3D_Framework::use_global_layout()) {
	  $page_layout 	= get_post_meta($page_id, "selected_layout", true);	
	  $page_content_type 	= get_post_meta($page_id, "selected_page_type", true);	
	  
	  if ($page_layout == "") {
		$pageMeta = get_post_meta($page_id);
		if (@$pageMeta['_wp_page_template'][0] != "") {
		  $page_layout = str_replace("template-", "", str_replace(".php", "", $pageMeta['_wp_page_template'][0]));
		}
		  
	  } else if ($page_layout == "primary") {
		$page_layout = "home";  
	  }
	  
	 // print "page_layout = $page_layout";
		if ($page_layout == "" || $page_content_type == "") {
		//	print "yeah";
			$pageMeta = get_post_meta($page_id);
			if (@$pageMeta['_wp_page_template'][0] != "") {
			  $pageTemplate = str_replace("template-", "", str_replace(".php", "", $pageMeta['_wp_page_template'][0]));
			} else {
				$pageTemplate = "";
			}
			if ($pageTemplate == "blog") {
				$page_content_type = "blog";
			} else if ($pageTemplate == "sitemap") {
				$page_content_type = "sitemap";
			} else if ($pageTemplate == "faqs") {
				$page_content_type = "faqs";
			} else if ($pageTemplate == "under-construction") {
				$page_content_type = "default";
			} else if ($pageTemplate == "minimized") {
				$page_content_type = "default";
			} else if ($pageTemplate == "home") {
				$page_content_type = "default";
			} else if ($pageTemplate == "advanced") {
				$page_content_type = "default";
			} else if ($pageTemplate == "contact") {
				$page_content_type = "contact";	
			} else if ($pageTemplate == "events-calendar") {
				$page_content_type = "default";
			} else if ($pageTemplate == "team-members") {
				$page_content_type = "team-members";
			} else if ($pageTemplate == "photo-slideshow") {
				$page_content_type = "photo-slideshow";
			} else {
				$page_content_type = "default";
			}
		}
	
		
		
		if ($page_layout == "") {
		  $page_layout = I3D_Framework::get_default_layout_id($page_id);	
		}	  
	}



    wp_register_script('i3d-modernizr-js',       "{$themeRoot}/Library/sliders/parallax-slider/js/modernizr.custom.28468.js", array('jquery'), '1.0' );
    wp_register_script('i3d-modernizr-79639-js', "{$themeRoot}/Library/sliders/fullscreen-slider/js/modernizr.custom.79639.js", array('jquery'), '1.0' );

	// header scripts
	wp_enqueue_script('jquery');
	//wp_enqueue_script('jquery-ui');

	// footer scripts
	wp_enqueue_script( 'aquila-bootstrap-js',    "{$themeRoot}/includes/admin/control-panel/bootstrap/3.2.0/js/bootstrap.min.js", array('jquery'), '1.0', true);
	wp_enqueue_script( 'aquila-theme-js',        "{$themeRoot}/Site/javascript/special_functions.js", array('jquery'), '1.0', true );
	wp_enqueue_script( 'aquila-framework-js',    "{$themeRoot}/Site/javascript/aquila.js", array('jquery', 'aquila-bootstrap-js'), '1.0', true );

	//wp_enqueue_script( 'aquila-wow-js',    "{$themeRoot}/Site/javascript/wow.min.js", array(), '1.0', true );
	wp_enqueue_script( 'aquila-waypoints-js',    "{$themeRoot}/Site/javascript/waypoints.js", array(), '1.0', true );
	wp_enqueue_script( 'aquila-animations-js',    "{$themeRoot}/Site/javascript/animations.js", array(), '1.0', true );
	wp_enqueue_script( 'aquila-headhesive',    "{$themeRoot}/Site/javascript/headhesive.js", array(), '1.0', true );
	//wp_enqueue_script( 'aquila-skrollr-js',    "{$themeRoot}/Site/javascript/skrollr.min.js", array(), '1.0', true );


	//if ($pageTemplate == "contact" && !I3D_Framework::use_global_layout()) {
		  wp_enqueue_script( 'aquila-google-maps',  "https://maps.google.com/maps/api/js?key=AIzaSyBrB_tWpTV_xOg6khHXLwIRio8Et48u-r8&v=3.exp&amp;sensor=false&amp;language=en&libraries=common,util,geocoder,map,overlay,onion,marker,infowindow,controls", array('jquery'), '1.0' );
		  wp_enqueue_script( 'aquila-gomap', 		"{$themeRoot}/Site/javascript/gomap/jquery.gomap-1.3.2.min.js", array('jquery', 'aquila-google-maps'), '1.0' );
	//}

	if ($pageTemplate == "blog" || $page_layout == "blog" || $page_content_type == "blog") {
		wp_enqueue_script( 'masonry');
		wp_enqueue_script( 'masonry-init', "{$themeRoot}/Site/javascript/masonry-init.js", array('masonry'), null );
	}

	if ($pageTemplate == "photo-slideshow"  || $page_layout == "photo-slideshow" || $page_content_type == "photo-slideshow") {
		wp_enqueue_script( 'aquila-jquery-easing',  		  "{$themeRoot}/Library/sliders/supersized-slideshow/js/jquery.easing.min.js", array('jquery'), '1.0' );
		wp_enqueue_script( 'aquila-jquery-photo-slideshow-1', "{$themeRoot}/Library/sliders/supersized-slideshow/js/supersized.3.2.7.min.js", array('jquery'), '1.0' );
		wp_enqueue_script( 'aquila-jquery-photo-slideshow-2', "{$themeRoot}/Library/sliders/supersized-slideshow/theme/supersized.shutter.min.js", array('jquery'), '1.0' );
		wp_enqueue_style( 'aquila-photo-slideshow-css-1',     "{$themeRoot}/Library/sliders/supersized-slideshow/css/supersized.css");
		wp_enqueue_style( 'aquila-photo-slideshow-css-2',     "{$themeRoot}/Library/sliders/supersized-slideshow/theme/supersized.shutter.css");
	}

	// gallery styles file
	//wp_enqueue_style( 'aquila-gallery-styles',                  "{$themeRoot}/Site/styles/gallery-styles.css"); 
	//wp_enqueue_style( 'aquila-gallery-prettyphoto-styles',      "{$themeRoot}/Site/styles/prettyPhoto.css");
	//wp_enqueue_script( 'aquila-jquery-prettyphoto', 			"{$themeRoot}/Site/javascript/jquery.prettyPhoto.js", array('jquery'), '1.0', false );

	// bootstrap standard file
	wp_enqueue_style( 'aquila-bootstrap',						"{$themeRoot}/Site/styles/bootstrap/bootstrap.css"); 
	
	// theme component styles
	wp_enqueue_style( 'aquila-bootstrap-theme-components1', "{$themeRoot}/Site/styles/backgrounds.css");
	wp_enqueue_style( 'aquila-bootstrap-theme-components2', "{$themeRoot}/Site/styles/menubar.css");
	wp_enqueue_style( 'aquila-bootstrap-theme-components3', "{$themeRoot}/Library/components/feature-boxes/css/feature-boxes.css");
	
	// default google fonts
	//wp_enqueue_style( 'aquila-google-font-1', "//fonts.googleapis.com/css?family=Patrick+Hand");
	//wp_enqueue_style( 'aquila-google-font-1', "//fonts.googleapis.com/css?family=Mouse+Memoirs");
	//wp_enqueue_style( 'aquila-google-font-1', "//fonts.googleapis.com/css?family=Open+Sans:400,300,600");


	// theme standard theme css file
	//$themeStyle = I3D_Framework::getThemeStyle();
	//$themeStyleColor = I3D_Framework::getThemeStyleColor();

	//wp_enqueue_style( 'aquila-theme-secondary-styles',			"{$themeRoot}/Site/theme/{$themeStyle}/css/theme.css");
	//wp_enqueue_style( 'aquila-theme-secondary-styles2',			"{$themeRoot}/Site/theme/{$themeStyle}/css/styles.css");
	//wp_enqueue_style( 'aquila-theme-secondary-color',			"{$themeRoot}/Site/theme/{$themeStyle}/colors/{$themeStyleColor}/color.css");
	//wp_enqueue_style( 'aquila-theme-accordion-panels',			"{$themeRoot}/Library/components/accordion-panels/css/accordion-panels.css");

	// theme standard css file
	wp_enqueue_style( 'aquila-theme-main-styles',               "{$themeRoot}/Site/styles/styles.css");
	wp_enqueue_style( 'aquila-theme-main-animations1',			"{$themeRoot}/Site/styles/bootstrap/animate.css");
	wp_enqueue_style( 'aquila-theme-main-animations2',			"{$themeRoot}/Site/styles/animations.css");
	

	// font-awesome standard file
	wp_enqueue_style( 'aquila-fontawesome',						"{$themeRoot}/includes/admin/control-panel/font-awesome-4.1.0/css/font-awesome.css");

	// bootstrap overrided styles
	wp_enqueue_style( 'aquila-bootstrap-override',				"{$themeRoot}/Site/styles/bootstrap/lm-bootstrap.css");



    // contact panel
		wp_enqueue_style( 'aquila-contact-panel',               "{$themeRoot}/Library/components/contact-panel/css/contact-panel.css");

    // call to action styles
	wp_enqueue_style( 'aquila-call-to-action',               "{$themeRoot}/Library/components/call-to-action/css/call-to-action.css");

	if ($pageTemplate == "home") {
//		wp_enqueue_style( 'aquila-primary-layout', 		   	"{$themeRoot}/Site/styles/primary.css");	
	} else {
	//	wp_enqueue_style( 'aquila-primary-layout', 			"{$themeRoot}/Site/styles/minimized.css");
	}
	
	
    // page styles
	/*
	$settingOptions = wp_parse_args( (array) $settingOptions, array( 'page_edge_style' => '','page_inner_style' => '', 'page_outer_style' => '') );
    $pageStyle = get_post_meta($page_id, 'page_styles', true);
	if (!is_array($pageStyle)) {
		$pageStyle = array();
		$useGlobal = true;
		$pageStyle['edge'] = '';
		$pageStyle['inner'] = '';
		$pageStyle['outer'] = '';
	}
	if ($pageStyle['edge'] == "default" || $useGlobal) {
		
		$globalEdgeStyle = $settingOptions["page_edge_style"];
		if ($globalEdgeStyle == "") {
			$globalEdgeStyle = array_shift(array_keys(I3D_Framework::$optionalPageStyledEdges));
		}
		$pageStyle['edge'] = $globalEdgeStyle;
	} 
	if ($pageStyle['edge'] != "" && $pageStyle['edge'] != "-") {
   		  wp_enqueue_style( 'aquila_theme_page_styled_edge', 			get_template_directory_uri().$pageStyle['edge']);
	}		

	if ($pageStyle['inner'] == "default" || $useGlobal) {
		$globalInnerStyle =  $settingOptions["page_inner_style"];
		if ($globalInnerStyle == "") {
			$globalInnerStyle = array_shift(array_keys(I3D_Framework::$optionalPageInnerBackground));
		}
		$pageStyle['inner'] = $globalInnerStyle;
	} 
	if ($pageStyle['inner'] != "" && $pageStyle['inner'] != "-") {
   		  wp_enqueue_style( 'aquila_theme_page_styled_inner', 			get_template_directory_uri().$pageStyle['inner']);
	}		

	if ($pageStyle['outer'] == "default" || $useGlobal) {
		$globalOuterStyle =  $settingOptions["page_outer_style"];
		if ($globalOuterStyle == "") {
			
			$globalOuterStyle = array_shift(array_keys(I3D_Framework::$optionalPageOuterBackground));
		}
		$pageStyle['outer'] = $globalOuterStyle;
	} 
	if ($pageStyle['outer'] != "" && $pageStyle['outer'] != "-") {
   		  wp_enqueue_style( 'aquila_theme_page_styled_outer', 			get_template_directory_uri().$pageStyle['outer']);
	}		
	*/
	
	wp_enqueue_style( 'aquila-isotope',               "{$themeRoot}/Library/components/isotope-portfolio/css/isotope.css");
	wp_enqueue_style( 'aquila-isotope-pretty-photo',               "{$themeRoot}/Library/components/isotope-portfolio/css/prettyPhoto.css");
	
	wp_enqueue_script( 'aquila-isotope1', "{$themeRoot}/Library/components/isotope-portfolio/js/jquery.waitforimages.js", array('jquery'), '1.0', true);
	wp_enqueue_script( 'aquila-isotope2', "{$themeRoot}/Library/components/isotope-portfolio/js/jquery.isotope.min.js", array('jquery'), '1.0', true);
	wp_enqueue_script( 'aquila-isotope3', "{$themeRoot}/Library/components/isotope-portfolio/js/jquery.prettyPhoto.js", array('jquery'), '1.0', true);
	//wp_enqueue_script( 'aquila-isotope4', "{$themeRoot}/Library/components/isotope-portfolio/js/prettyPhoto-theme.js", array('jquery'), '1.0', true);
	wp_enqueue_script( 'aquila-isotope5', "{$themeRoot}/Library/components/isotope-portfolio/js/jquery.ui.totop.js", array('jquery'), '1.0', true);

	
}
?>
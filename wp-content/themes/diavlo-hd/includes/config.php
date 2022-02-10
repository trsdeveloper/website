<?php
/**********************************************************************************
 * wp-content/themes/[theme]/includes/config.php
 * Purpose: the main configurable (theme to theme) elements can be configured here
 * Last Updated: July 30, 2013
 **********************************************************************************/
global $_GET;
global $pageTemplate;
global $testMode;
$testMode = false;

include_once ("theme/config-typography.php");
include_once ("theme/config-sliders.php");
include_once ("theme/config-templates.php");

I3D_Framework::$conditionOffset = 0;
I3D_Framework::$conditionPeriod = 3;
//I3D_Framework::$configurationName = "Education/Pre-School";

$i3dBodyAttributes		 = 'data-spy="scroll" data-target=".bs-docs-sidebar"';
$i3dTextLogoLines        = 2;

$i3dBootstrapVersion   = 3;
$i3dFontAwesomeVersion = 4;

I3D_Framework::$bootstrapVersion	   = 3;
I3D_Framework::$fontAwesomeVersion	   = 4;
I3D_Framework::$socialMediaIconVersion = 5;
I3D_Framework::$navbarVersion		   = 4;
I3D_Framework::$quickLinksVersion	   = 2;
I3D_Framework::$textLinksVersion	   = 2;
I3D_Framework::$logoVersion		   	   = 4;
I3D_Framework::$searchBoxVersion	   = 4;
I3D_Framework::$infoBoxVersion		   = 2;
I3D_Framework::$parallaxSliderVersion  = 2;
I3D_Framework::$layoutVersion          = 2; // when initializing, this is used to determine how the footer is set up
I3D_Framework::$numTopMenuItems        = 5; // when initializing, this is used to determine how many items in the header of the page
I3D_Framework::$defaultVectorIcon      = ''; // when initializing, this is used to set the logo icon

I3D_Framework::$contactPanelVersion    = 2;

I3D_Framework::$initForm['standard-contact-panel'] = true;
I3D_Framework::$initForm['standard-contact-box']   = false;
I3D_Framework::$initForm['standard-contact-page']  = true;
//I3D_Framework::$initForm['preschool-child-absence']  		  = true;
//I3D_Framework::$initForm['preschool-employment-application']  = true;
//I3D_Framework::$initForm['preschool-enrollment-application']  = true;

I3D_Framework::$callToActionVersion    = 2;
I3D_Framework::$fullScreenSliderVersion = 3;
I3D_Framework::$quotatorVersion         = 2;
I3D_Framework::$infoBoxSliderVersion    = 1;
I3D_Framework::$initMenusWithIcons      = false;
I3D_Framework::$initSubVerticalMenu      = true;

I3D_Framework::$fullscreenCarouselVersion = 2;
I3D_Framework::$jumbotronCarouselVersion  = 3;
I3D_Framework::$parallaxSliderVersion  	  = 3;

I3D_Framework::$eventsCalendarSupport  		= true;
I3D_Framework::$supportType 				= "i3d";
I3D_Framework::$useTimThumb 				= true;
I3D_Framework::$globalSearchVersion			= 2;
I3D_Framework::$isotopePortfolioVersion		= 1;

I3D_Framework::$layoutEditorAvailable	 	= 1;
I3D_Framework::$recommendedLogoDimensions 		= "340x80";
I3D_Framework::$recommendedRetinaLogoDimensions = "680x160";

I3D_Framework::$default_contact_panel_width[2] = "6|6";
I3D_Framework::$default_contact_panel_width[3] = "4|4|4";
I3D_Framework::$default_contact_panel_width[4] = "3|3|3|3";




I3D_Framework::$animationClasses = array("animated-fade-in-down" => __("Fade In Down", get_template()),
										 "animated-fade-in-down-big" => __("Fade In Down Big", get_template()),
										 "animated-fade-in-left" => __("Fade In Left", get_template()),
										 "animated-fade-in-left-big" => __("Fade In Left Big", get_template()),
										 "animated-fade-in-right" => __("Fade In Right", get_template()),
										 "animated-fade-in-right-big" => __("Fade In Right Big", get_template()),
										 "animated-fade-in-up" => __("Fade In Up", get_template()),
										 "animated-fade-in-up-big" => __("Fade In Up Big", get_template()));

I3D_Framework::$paragraphClasses = array("lead" 	=> __("Lead", get_template()),
									  "p-tagline" 	=> __("Tagline", get_template())
										);

I3D_Framework::$htmlBoxWidgetLayouts = array("section-list" => __("Section List", get_template()));
I3D_Framework::$callToActionStyles = array("" => "Default", "highlight" => "Highlight");													



I3D_Framework::$optionalStyledBackgrounds = array("" => "Default",
												  "padding-top-10 padding-bottom-10" => "Default (With 10px Padding)",
												  "padding-top-20 padding-bottom-20" => "Default (With 20px Padding)",
												  "padding-top-40 padding-bottom-40" => "Default (With 40px Padding)",
												  "section1" => "Geometric Background", 
												  "section1 animated" => "Geometric Background (Animated)", 
												  "parallax1" => "Photo Background", 
												  "parallax1,section-inner" => "Photo Background Dark", 
												  "parallax1 animated" => "Photo Background (Animated)", 
												  "parallax1 animated,section-inner" => "Photo Background Dark (Animated)",
												  "section2" => "Light Background with Inner Shadow"
												  );

I3D_Framework::$boxStyles = array("" => "Default",
								"content-light"		=> "Content Light (No Accents)",
								"content-light faded"	=> "Content Light Faded (No Accents)",
								"content-dark"		=> "Dark Light (No Accents)",
								"content-dark faded"	=> "Dark Light Faded (No Accents)"
								
								);

I3D_Framework::$formDescriptionWrapperTag = "div";



I3D_Framework::add_layout_preset(array("logo" => 
									  array(
										"columns" => array(
											array('wrappers' => array(), 
												  'widgets' => array(array('class_name' => 'I3D_Widget_Logo', 
																		   'id' 		=> 'logo',
																		   'defaults'   => array("graphic_logo" => "disabled", "website_name" => "default", "tagline_setting" => "default")))
												  
												  )																										  
									  	), // end of columns
										'layout' => '12', 
										"container" => array(array("tag" => "div", "class" => "sticky-menubar"),
															 array("tag" => "div", "class" => "container")),
										"name" => "Logo",
										"section" => array("header", "main-menu"),
										"description" => "Typically used as the top row in this theme when you don't want a top menu."
									  )
									  ));

I3D_Framework::add_layout_preset(array("logo-menu" => 
									  array(
										"columns" => array(
											array('wrappers' => array(), 
												  'widgets' => array(array('class_name' => 'I3D_Widget_Logo', 
																		   'id' 		=> 'logo',
																		   'defaults'   => array("graphic_logo" => "disabled", "website_name" => "default", "tagline_setting" => "default")))
												  
												  ),
											array('wrappers' => array(),
												  'widgets' => array(array('class_name' => 'I3D_Widget_Menu',
																		   'id' 		=> 'menu',
																		   'defaults' => array('theme_location' => 'i3d-dropdown-menu-1', 'justification' => 'right')) )
												  ) 																										  
									  	), // end of columns
										'layout' => '6|6', 
										"container" => array(),
										"name" => "Logo | Menu",
										"section" => array("header", "main-menu"),
										"description" => "Typically used as the top row in this theme."
									  )
									  ));






I3D_Framework::add_layout_preset(array("minimized-header" => 
									  array(
										"columns" => array(
											array('wrappers' => array(), 
												  'widgets' => array(array('class_name' => 'I3D_Widget_SEOTags', 
																		   'id' 		=> 'seo',
																		   'defaults'   => array('justification' => 'center')))
												  
												  ),
																																				  
									  	), // end of columns
										'layout' => '12', 
										"container" => array(array("tag" => "div", "class" => "showcase animated"),
															 array("tag" => "div", "class" => "section-inner"),
															 array("tag" => "div", "class" => "wrapper"),
															 array("tag" => "div", "class" => "container")),
										"name" => "Minimized Header",
										"section" => array("main"),
										"description" => "Single column containing the page title with stylized background image"

									  )
									  ));

I3D_Framework::add_layout_preset(array("contact-panel" => 
									  array(
										"columns" => array(
											array('wrappers' => array(), 
												  'widgets' => array(array('class_name' => 'I3D_Widget_ContactPanel', 
																		   'id' 		=> 'contactpanel',
																		   'defaults'   => array('sidebar' => 'i3d-widget-area-header-top')))
												  
												  ),
																																				  
									  	), // end of columns
										'layout' => '12', 
										
										"container" => array(),
										"name" => "Contact Panel",
										"section" => array("contact-panel"),
										"description" => "A special region that is styled to provide a drop in contact panel."

									  )
									  ));

I3D_Framework::add_layout_preset(array("content" => 
									  array(
										"columns" => array(
											array('wrappers' => array(), 
												  'widgets' => array(array('class_name' => 'I3D_Widget_ContentRegion', 
																		   'id' 		=> 'content',
																		   'defaults'   => array()))
												  
												  ),
																																				  
									  	), // end of columns
										'layout' => '12', 
										
										"container" => array(array("tag" => "div", "class" => "content-wrapper"),
															 array("tag" => "div", "class" => "container"),
															 array("tag" => "div", "class" => "row")),
										"name" => "Content Region",
										"section" => array("main"),
										"description" => "Single column content region row."

									  )
									  ));

I3D_Framework::add_layout_preset(array("content-sidebar" => 
									  array(
										"columns" => array(
											array('wrappers' => array(), 
												  'widgets' => array(array('class_name' => 'I3D_Widget_ContentRegion', 
																		   'id' 		=> 'content-left',
																		   'defaults'   => array()))
												  
												  ),
											array('wrappers' => array(),
												  'widgets' => array(array('class_name' => 'I3D_Widget_SidebarRegion',
																		   'id' 		=> 'sidebar-right',
																		   'defaults' => array('sidebar' => 'i3d-widget-area-header-main')) )
												  ) 																										  
									  	), // end of columns
										'layout' => '9|3', 
										"container" => array(array("tag" => "div", "class" => "content-wrapper"),
															 array("tag" => "div", "class" => "container"),
															 array("tag" => "div", "class" => "row")),
										"name" => "Content | Sidebar",
										"section" => array("main"),
										
										"description" => "Two column row with a left content region and a right sidebar."

									  )
									  ));

I3D_Framework::add_layout_preset(array("sidebar-content" => 
									  array(
										"columns" => array(
											array('wrappers' => array(),
												  'default-width' => 3,
												  'hard-width' => false,
												  'widgets' => array(array('class_name' => 'I3D_Widget_SidebarRegion',
																		   'id' 		=> 'sidebar-left',
																		   'defaults' => array('sidebar' => 'i3d-widget-area-custom-3')) )
												  ),														   
											array('wrappers' => array(), 
												  'default-width' => 9, 
												  'hard-width' => false,
												  'widgets' => array(array('class_name' => 'I3D_Widget_ContentRegion', 
																		   'id' 		=> 'content-right',
																		   'defaults'   => array()))
												  
												  ),
																										  
									  	), // end of columns
										'layout' => '3|9', 
										"container" => array(array("tag" => "div", "class" => "content-wrapper"),
															 array("tag" => "div", "class" => "container"),
															 array("tag" => "div", "class" => "row")),
										"name" => "Sidebar | Content",
										"section" => array("main"),
										"description" => "Two column row with a left sidebar and a content region right."

									  )
									  ));

I3D_Framework::add_layout_preset(array("sidebar-content-sidebar" => 
									  array(
										"columns" => array(
											array('wrappers' => array(),
												  'hard-width' => false,
												  'widgets' => array(array('class_name' => 'I3D_Widget_SidebarRegion',
																		   'id' 		=> 'sidebar-left',
																		   'defaults' => array('sidebar' => 'i3d-widget-area-custom-3')) )
												  ),														   
											array('wrappers' => array(array("tag" => "div", "class" => "")), 
												  'hard-width' => false,
												  'widgets' => array(array('class_name' => 'I3D_Widget_ContentRegion', 
																		   'id' 		=> 'content-center',
																		   'defaults'   => array()))
												  
												  ),
											array('wrappers' => array(),
												  'hard-width' => false,
												  'widgets' => array(array('class_name' => 'I3D_Widget_SidebarRegion',
																		   'id' 		=> 'sidebar-right',
																		   'defaults' => array('sidebar' => 'i3d-widget-area-header-main')) )
												  ),														   
																										  
									  	), // end of columns
										'layout' => '3|6|3', 
										"container" => array(array("tag" => "div", "class" => "content-wrapper"),
															 array("tag" => "div", "class" => "container"),
															 array("tag" => "div", "class" => "row")),
										"name" => "Sidebar | Content | Sidebar",
										"section" => array("main"),

										"description" => "Three column row with a left and right sidebar and a center content region."

									  )
									  ));
I3D_Framework::add_layout_preset(array("primary-slider" => 
									  array(
										"columns" => array(
											array('wrappers' => array(),
												  'widgets' => array(array('class_name' => 'I3D_Widget_SliderRegion',
																		   'id' 		=> 'slider',
																		   'defaults' => array()) )
												  ) 																										  
									  	), // end of columns
										'layout' => '12', 
										"container" => array(),
										"name" => "Primary Slider",
										"section" => array("primary-slider"),
										
										"description" => "Featured Primary Layout Slider"

									  )
									  ));

I3D_Framework::add_layout_preset(array("secondary-slider" => 
									  array(
										"columns" => array(
											array('wrappers' => array(),
												  'widgets' => array(array('class_name' => 'I3D_Widget_SliderRegion',
																		   'id' 		=> 'slider',
																		    'defaults' => array('slider' => 'default-amazing-slider')) )
												  ) 																										  
									  	), // end of columns
										'layout' => '12', 
										"container" => array(),
										"name" => "Secondary Slider",
										"section" => array("secondary-slider"),
										
										"description" => "Secondary Layout Slider"

									  )
									  ));

I3D_Framework::add_layout_preset(array("photo-slideshow" => 
									  array(
										"columns" => array(
											array('wrappers' => array(),
												  'widgets' => array(array('class_name' => 'I3D_Widget_PhotoSlideshow',
																		   'id' 		=> 'slideshow',
																		   'defaults' => array()) )
												  ) 																										  
									  	), // end of columns
										'layout' => '12', 
										"container" => array(),
										"name" => "Fullscreen Photo Slideshow",
										"section" => array("photo-slideshow"),
										
										"description" => "Fullscreen Photo Slideshow"

									  )
									  ));

I3D_Framework::add_layout_preset(array("map-banner" => 
									  array(
										"columns" => array(
											array('wrappers' => array(),
												  'widgets' => array(array('class_name' => 'I3D_Widget_MapBanner',
																		   'id' 		=> 'mapbanner',
																		   'defaults' => array()) )
												  ) 																										  
									  	), // end of columns
										'layout' => '12', 
										"container" => array(array("tag" => "div", "class" => "clear-both section-bordered contact-map-container")),
										"name" => "Map Banner",
										"section" => array("main"),		
										"description" => "Map Banner"

									  )
									  ));

I3D_Framework::add_layout_preset(array("content-map-banner" => 
									  array(
										"columns" => array(
											array('wrappers' => array(array("tag" => "div", "class" => "")), 
												  'hard-width' => false,
												  'widgets' => array(array('class_name' => 'I3D_Widget_ContentRegion', 
																		   'id' 		=> 'content-center',
																		   'defaults'   => array()))
												  
												  ),
														   
											array('wrappers' =>  array(array("tag" => "div", "class" => "clear-both section-bordered contact-map-container")),
												  'widgets' => array(array('class_name' => 'I3D_Widget_MapBanner',
																		   'id' 		=> 'mapbanner',
																		   'defaults' => array()) )
												  ) 																										  
									  	), // end of columns
										'layout' => '6|6', 
										"container" => array(array("tag" => "section", "class" => "container")),


										"name" => "Content | Map Banner",
										"section" => array("main"),		
										"description" => "Content Section with Map on the right"

									  )
									  ));

I3D_Framework::add_layout_preset(array("map-banner-content" => 
									  array(
										"columns" => array(
											array('wrappers' =>  array(array("tag" => "div", "class" => "clear-both section-bordered contact-map-container")),
												  'widgets' => array(array('class_name' => 'I3D_Widget_MapBanner',
																		   'id' 		=> 'mapbanner',
																		   'defaults' => array()) )
												  ),																										  
											array('wrappers' => array(array("tag" => "div", "class" => "")), 
												  'hard-width' => false,
												  'widgets' => array(array('class_name' => 'I3D_Widget_ContentRegion', 
																		   'id' 		=> 'content-center',
																		   'defaults'   => array()))
												  
												  )
														   
									  	), // end of columns
										'layout' => '6|6', 
										"container" => array(array("tag" => "section", "class" => "container")),


										"name" => "Map Banner | Content",
										"section" => array("main"),		
										"description" => "Content Section with map on the left"

									  )
									  ));


I3D_Framework::add_layout_preset(array("footer-sidebar" => 
									  array(
										"columns" => array(
											array('wrappers' => array(),
												  'widgets' => array(array('class_name' => 'I3D_Widget_SidebarRegion',
																		   'defaults' => array()) )
												  ) 																										  
									  	), // end of columns
										'layout' => '12', 
										"container" => array(array("tag" => "div", "class" => "class1 class2 class3"),
															 array("tag" => "div", "class" => "anotherclass1 anotherclass2")),
										"name" => "Footer Sidebar",
										"section" => array("footer"),
										
										"description" => "Two column row with a left content region and a right sidebar."

									  )
									  ));

I3D_Framework::add_default_layout("default", 
								  "Minimized", 
								  true,
								  array(
										"contact-panel" 	=> array("rows" => array("contact-panel"  => array("visibility" => array(), "status" => "enabled", "title" => "Contact Panel", "type" => "preset", "presets" => "contact-panel", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "12"))),
										"utility-bar" 	=> array("rows" => array("utility-bar"  => array("visibility" => array(), "status" => "enabled", "title" => "Utility Bar", "type" => "sidebar", "sidebar" => "i3d-widget-area-utility", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "6|6"))),
										"main-menu" 	=> array("rows" => array("main-menu"  => array("visibility" => array(), "status" => "enabled", "title" => "Main Menu", "type" => "preset", "presets" => "logo-menu", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "6|6"))), 
										
										"main" 			=> array("rows" => 
																 array("minimized-header" => array("visibility" => array(), "status" => "enabled", "title" => "Minimized Header", "type" => "preset", "presets" => "minimized-header", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "12"),
																	   "breadcrumb" => array("visibility" => array(), "status" => "enabled", "title" => "Breadcrumb", "type" => "widget", "widget" => "I3D_Widget_Breadcrumb", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12"),
																	   "content" => array("visibility" => array(), "status" => "enabled", "title" => "Main Content", "type" => "preset", "presets" => "content", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12"),
																	   "bottom-padding" => array("visibility" => array(), "status" => "enabled", "title" => "Padding", "type" => "divider", "presets" => "", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12", "styles" => "gap-spacer-lg")),
																 ), 
										"footer" 		=> array("rows" => array("footer"  => array("visibility" => array(), "status" => "enabled", "title" => "Footer", "type" => "sidebar", "sidebar" => "i3d-widget-area-footer", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "4|4|2|2")))));

I3D_Framework::add_default_layout("default-2r", 
								  "Minimized 2R", 
								  false,
								  array(
										"contact-panel" 	=> array("rows" => array("contact-panel"  => array("visibility" => array(), "status" => "enabled", "title" => "Contact Panel", "type" => "preset", "presets" => "contact-panel", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "12"))),
										"utility-bar" 	=> array("rows" => array("utility-bar"  => array("visibility" => array(), "status" => "enabled", "title" => "Utility Bar", "type" => "sidebar", "sidebar" => "i3d-widget-area-utility", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "6|6"))),
										"main-menu" 	=> array("rows" => array("main-menu"  => array("visibility" => array(), "status" => "enabled", "title" => "Main Menu", "type" => "preset", "presets" => "logo-menu", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "6|6"))), 

										"main" 			=> array("rows" => 
																 array("minimized-header" => array("visibility" => array(), "status" => "enabled", "title" => "Minimized Header", "type" => "preset", "presets" => "minimized-header", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "12"),
																	   "breadcrumb" => array("visibility" => array(), "status" => "enabled", "title" => "Breadcrumb", "type" => "widget", "widget" => "I3D_Widget_Breadcrumb", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12"),
																	   "content" => array("visibility" => array(), "status" => "enabled", "title" => "Main Content", "type" => "preset", "presets" => "content-sidebar", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "9|3"),
																	   "bottom-padding" => array("visibility" => array(), "status" => "enabled", "title" => "Padding", "type" => "divider", "presets" => "", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12", "styles" => "gap-spacer-lg")),
																 
																 ), 
										"footer" 		=> array("rows" => array("footer"  => array("visibility" => array(), "status" => "enabled", "title" => "Footer", "type" => "sidebar", "sidebar" => "i3d-widget-area-footer", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "4|4|2|2")))));

I3D_Framework::add_default_layout("default-2l", 
								  "Minimized 2L", 
								  false,
								  array(
										"contact-panel" 	=> array("rows" => array("contact-panel"  => array("visibility" => array(), "status" => "enabled", "title" => "Contact Panel", "type" => "preset", "presets" => "contact-panel", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "12"))),
										"utility-bar" 	=> array("rows" => array("utility-bar"  => array("visibility" => array(), "status" => "enabled", "title" => "Utility Bar", "type" => "sidebar", "sidebar" => "i3d-widget-area-utility", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "6|6"))),
										"main-menu" 	=> array("rows" => array("main-menu"  => array("visibility" => array(), "status" => "enabled", "title" => "Main Menu", "type" => "preset", "presets" => "logo-menu", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "6|6"))), 
										
										"main" 			=> array("rows" => 
																 array("minimized-header" => array("visibility" => array(), "status" => "enabled", "title" => "Minimized Header", "type" => "preset", "presets" => "minimized-header", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "12"),
																	   "breadcrumb" => array("visibility" => array(), "status" => "enabled", "title" => "Breadcrumb", "type" => "widget", "widget" => "I3D_Widget_Breadcrumb", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12"),
																	   "content" => array("visibility" => array(), "status" => "enabled", "title" => "Main Content", "type" => "preset", "presets" => "sidebar-content", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "3|9"),
																	   "bottom-padding" => array("visibility" => array(), "status" => "enabled", "title" => "Padding", "type" => "divider", "presets" => "", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12", "styles" => "gap-spacer-lg")),
																 
																 ), 
										"footer" 		=> array("rows" => array("footer"  => array("visibility" => array(), "status" => "enabled", "title" => "Footer", "type" => "sidebar", "sidebar" => "i3d-widget-area-footer", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "4|4|2|2")))));


I3D_Framework::add_default_layout("primary", 
								  "Primary", 
								  false,
								  array(
										"contact-panel" 	=> array("rows" => array("contact-panel"  => array("visibility" => array(), "status" => "enabled", "title" => "Contact Panel", "type" => "preset", "presets" => "contact-panel", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "12"))),
										"header" 		=> array("rows" => array("primary-slider"  => array("visibility" => array(), "status" => "enabled", "title" => "Primary Slider", "type" => "preset", "presets" => "primary-slider", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => ""))),
										"utility-bar" 	=> array("rows" => array("utility-bar"  => array("visibility" => array(), "status" => "enabled", "title" => "Utility Bar", "type" => "sidebar", "sidebar" => "i3d-widget-area-utility", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "6|6"))),
										"main-menu" 	=> array("rows" => array("main-menu"  => array("visibility" => array(), "status" => "enabled", "title" => "Main Menu", "type" => "preset", "presets" => "logo-menu", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "6|6"))), 
										"feature-boxes" => array("rows" => array("feature-boxes"  => array("visibility" => array(), "status" => "enabled", "title" => "Feature Boxes", "type" => "sidebar", "sidebar" => "i3d-widget-area-header-lower", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "3|3|3|3"))), 
										"main" 			=> array("rows" => array(
																	   		/* "top-padding-1" => array("visibility" => array(), "status" => "enabled", "title" => "Padding", "type" => "divider", "presets" => "", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12", "styles" => "gap-spacer-xs"),*/
																			 
																			 "home-top-1" => array("visibility" => array(), "status" => "enabled", "title" => "Top Message", "type" => "sidebar", "sidebar" => "i3d-widget-area-main-top", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12", "styles" => "section1 animated"),
																			 "home-top-2" => array("visibility" => array(), "status" => "enabled", "title" => "Section Lists", "type" => "sidebar", "sidebar" => "i3d-widget-area-custom-1", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "6|6", "styles" => "section1 animated"), 
																			 "home-top-3" => array("visibility" => array(), "status" => "enabled", "title" => "Call To Action", "type" => "sidebar", "sidebar" => "i3d-widget-area-advertising", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12", "styles" => "parallax1 animated,section-inner"), 
																	   		/* "top-padding-2" => array("visibility" => array(), "status" => "enabled", "title" => "Padding", "type" => "divider", "presets" => "", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12", "styles" => "gap-spacer-lg"),*/
																			
																			 /* "home-top-3" => array("visibility" => array(), "status" => "enabled", "title" => "Info Box Slider", "type" => "sidebar", "sidebar" => "i3d-widget-area-home-3", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12", "styles" => "section1 parallax6 border-mb light wrapper-tint wrapper-tint1"), */
																			 "content" => array("visibility" => array(), "status" => "enabled", "title" => "Main Content", "type" => "preset", "presets" => "content", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12", "styles" => "section1 animated"),
																		/*	 "home-bottom-2" => array("visibility" => array(), "status" => "enabled", "title" => "Focal Box", "type" => "widget", "widget" => "I3D_Widget_FocalBox", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12", "configuration" => array("i3d_fb" => array("default_focal_box_id" => "fb_default_1")) ),
																			 "home-bottom-4" => array("visibility" => array(), "status" => "enabled", "title" => "Quotator", "type" => "sidebar", "sidebar" => "i3d-widget-area-home-4", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12", "styles" => "section3 parallax4 border-mb light wrapper-tint wrapper-tint1"), */
																			 "home-bottom-1" => array("visibility" => array(), "status" => "enabled", "title" => "About The Team", "type" => "sidebar", "sidebar" => "i3d-widget-area-custom-2", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12", "styles" => "section1 animated"),
																			 "home-bottom-2" => array("visibility" => array(), "status" => "enabled", "title" => "Contact Form", "type" => "widget", "widget" => "I3D_Widget_ContactForm", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12", "styles" => "section_ab_1",  "configuration" => array("i3d_contact_form" => array("form_id" => "cf_default_cp", "box_style" => "content-light"))),
																			 "home-bottom-3" => array("visibility" => array(), "status" => "enabled", "title" => "Quotator", "type" => "sidebar", "sidebar" => "i3d-widget-area-lower", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12", "styles" => "section2 animated"),
																													  )), 
										"footer" 	=> array("rows" => array("footer"  => array("visibility" => array(), "status" => "enabled", "title" => "Footer", "type" => "sidebar", "sidebar" => "i3d-widget-area-footer", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "4|4|2|2")))));

I3D_Framework::add_default_layout("secondary", 
								  "Secondary", 
								  false,
								  array(
										"contact-panel" 	=> array("rows" => array("contact-panel"  => array("visibility" => array(), "status" => "enabled", "title" => "Contact Panel", "type" => "preset", "presets" => "contact-panel", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "12"))),
										"utility-bar" 	=> array("rows" => array("utility-bar"  => array("visibility" => array(), "status" => "enabled", "title" => "Utility Bar", "type" => "sidebar", "sidebar" => "i3d-widget-area-utility", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "6|6"))),
										"main-menu" 	=> array("rows" => array("main-menu"  => array("visibility" => array(), "status" => "enabled", "title" => "Main Menu", "type" => "preset", "presets" => "logo-menu", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "6|6"))), 
										"secondary-slider" => array("rows" => array("secondary-slider"  => array("visibility" => array(), "status" => "enabled", "title" => "Secondary Slider", "type" => "preset", "presets" => "secondary-slider", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => ""))),  
										"main" 		=> array("rows" => array(
																	   		"top-padding-1" => array("visibility" => array(), "status" => "enabled", "title" => "Padding", "type" => "divider", "presets" => "", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12", "styles" => "gap-spacer-xs"),
																			 "content" => array("visibility" => array(), "status" => "enabled", "title" => "Main Content", "type" => "preset", "presets" => "content", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12"),
																													  )), 
										"footer" 	=> array("rows" => array("footer"  => array("visibility" => array(), "status" => "enabled", "title" => "Footer", "type" => "sidebar", "sidebar" => "i3d-widget-area-footer", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "4|4|2|2")))));


I3D_Framework::add_default_layout("secondary2", 
								  "Secondary2", 
								  false,
								  array(
										"contact-panel" 	=> array("rows" => array("contact-panel"  => array("visibility" => array(), "status" => "enabled", "title" => "Contact Panel", "type" => "preset", "presets" => "contact-panel", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "12"))),
										"utility-bar" 	=> array("rows" => array("utility-bar"  => array("visibility" => array(), "status" => "enabled", "title" => "Utility Bar", "type" => "sidebar", "sidebar" => "i3d-widget-area-utility", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "6|6"))),
										"main-menu" 	=> array("rows" => array("main-menu"  => array("visibility" => array(), "status" => "enabled", "title" => "Main Menu", "type" => "preset", "presets" => "logo-menu", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "6|6"))), 
										"secondary-slider" => array("rows" => array("secondary-slider"  => array("visibility" => array(), "status" => "enabled", "title" => "Secondary Slider", "type" => "preset", "presets" => "secondary-slider", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => ""))),  
										"feature-boxes-secondary" => array("rows" => array("feature-boxes-secondary"  => array("visibility" => array(), "status" => "enabled", "title" => "Feature Boxes", "type" => "sidebar", "sidebar" => "i3d-widget-area-header-lower", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "3|3|3|3"))), 
										"main" 		=> array("rows" => array(
																	   		"top-padding-1" => array("visibility" => array(), "status" => "enabled", "title" => "Padding", "type" => "divider", "presets" => "", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12", "styles" => "gap-spacer-xs"),
																			 "content" => array("visibility" => array(), "status" => "enabled", "title" => "Main Content", "type" => "preset", "presets" => "content", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12"),
																													  )), 
										"footer" 	=> array("rows" => array("footer"  => array("visibility" => array(), "status" => "enabled", "title" => "Footer", "type" => "sidebar", "sidebar" => "i3d-widget-area-footer", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "4|4|2|2")))));


I3D_Framework::add_default_layout("photo-slideshow", 
								  "Photo Slideshow", 
								  false,
								  array(
										"utility-bar" 	=> array("rows" => array("utility-bar"  => array("visibility" => array(), "status" => "enabled", "title" => "Utility Bar", "type" => "sidebar", "sidebar" => "i3d-widget-area-utility", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "6|6"))),
										"main-menu" 	=> array("rows" => array("main-menu"  => array("visibility" => array(), "status" => "enabled", "title" => "Main Menu", "type" => "preset", "presets" => "logo-menu", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "6|6"))), 
/*										
										"photo-slideshow-header" 	=> array("rows" => array("header"  => array("visibility" => array(), "status" => "enabled", "title" => "Top", "type" => "preset", "presets" => "logo-menu", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "4|8"))), 
	*/									
										
										"photo-slideshow" => array("rows" => array("photo-slideshow"  => array("visibility" => array(), "status" => "enabled", "title" => "Photo Slideshow", "type" => "preset", "presets" => "photo-slideshow", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => ""))),  
										));

I3D_Framework::add_default_layout("contact", 
								  "Contact", 
								  false,
								  array(
										"contact-panel" 	=> array("rows" => array("contact-panel"  => array("visibility" => array(), "status" => "enabled", "title" => "Contact Panel", "type" => "preset", "presets" => "contact-panel", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "12"))),
										"utility-bar" 	=> array("rows" => array("utility-bar"  => array("visibility" => array(), "status" => "enabled", "title" => "Utility Bar", "type" => "sidebar", "sidebar" => "i3d-widget-area-utility", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "6|6"))),
										"main-menu" 	=> array("rows" => array("main-menu"  => array("visibility" => array(), "status" => "enabled", "title" => "Main Menu", "type" => "preset", "presets" => "logo-menu", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "6|6"))), 
										
										"main" 			=> array("rows" => 
																 array("minimized-header" => array("visibility" => array(), "status" => "enabled", "title" => "Minimized Header", "type" => "preset", "presets" => "minimized-header", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "12"),
																	   "map-banner" => array("visibility" => array(), "status" => "enabled", "title" => "Map Banner", "type" => "preset", "presets" => "map-banner", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "12"),						   
																	   "content" => array("visibility" => array(), "status" => "enabled", "title" => "Main Content", "type" => "preset", "presets" => "content", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12")),
																 ), 
										"footer" 		=> array("rows" => array("footer"  => array("status" => "enabled", "title" => "Footer", "type" => "sidebar", "sidebar" => "i3d-widget-area-footer", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "4|4|2|2")))));

I3D_Framework::add_default_layout("contact-2r", 
								  "Contact 2R", 
								  false,
								  array(
										"contact-panel" 	=> array("rows" => array("contact-panel"  => array("visibility" => array(), "status" => "enabled", "title" => "Contact Panel", "type" => "preset", "presets" => "contact-panel", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "12"))),
										"utility-bar" 	=> array("rows" => array("utility-bar"  => array("visibility" => array(), "status" => "enabled", "title" => "Utility Bar", "type" => "sidebar", "sidebar" => "i3d-widget-area-utility", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "6|6"))),
										"main-menu" 	=> array("rows" => array("main-menu"  => array("visibility" => array(), "status" => "enabled", "title" => "Main Menu", "type" => "preset", "presets" => "logo-menu", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "6|6"))), 
										
										"main" 			=> array("rows" => 
																 array("minimized-header" => array("visibility" => array(), "status" => "enabled", "title" => "Minimized Header", "type" => "preset", "presets" => "minimized-header", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "12"),
																	   					   
																	   "content" => array("visibility" => array(), "status" => "enabled", "title" => "Main Content", "type" => "preset", "presets" => "content-map-banner", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "9|3")),
																 ), 
										"footer" 		=> array("rows" => array("footer"  => array("status" => "enabled", "title" => "Footer", "type" => "sidebar", "sidebar" => "i3d-widget-area-footer", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "4|4|2|2")))));

I3D_Framework::add_default_layout("contact-2l", 
								  "Contact 2L", 
								  false,
								  array(
										"contact-panel" 	=> array("rows" => array("contact-panel"  => array("visibility" => array(), "status" => "enabled", "title" => "Contact Panel", "type" => "preset", "presets" => "contact-panel", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "12"))),
										"utility-bar" 	=> array("rows" => array("utility-bar"  => array("visibility" => array(), "status" => "enabled", "title" => "Utility Bar", "type" => "sidebar", "sidebar" => "i3d-widget-area-utility", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "6|6"))),
										"main-menu" 	=> array("rows" => array("main-menu"  => array("visibility" => array(), "status" => "enabled", "title" => "Main Menu", "type" => "preset", "presets" => "logo-menu", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "6|6"))), 
										
										"main" 			=> array("rows" => 
																 array("minimized-header" => array("visibility" => array(), "status" => "enabled", "title" => "Minimized Header", "type" => "preset", "presets" => "minimized-header", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "12"),
																	   						   
																	   "content" => array("visibility" => array(), "status" => "enabled", "title" => "Main Content", "type" => "preset", "presets" => "map-banner-content", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "3|9")),
																 ), 
										"footer" 		=> array("rows" => array("footer"  => array("status" => "enabled", "title" => "Footer", "type" => "sidebar", "sidebar" => "i3d-widget-area-footer", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "4|4|2|2")))));

I3D_Framework::add_default_layout("under-construction", 
								  "Under Construction", 
								  true,
								  array(
										"contact-panel" 	=> array("rows" => array("contact-panel"  => array("visibility" => array(), "status" => "enabled", "title" => "Contact Panel", "type" => "preset", "presets" => "contact-panel", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "12"))),
										
										
										"header" 	=> array("rows" => array("header"  => array("visibility" => array(), "status" => "enabled", "title" => "Top", "type" => "preset", "presets" => "logo", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "12"))), 

										"main" 			=> array("rows" => 
																 array("minimized-header" => array("visibility" => array(), "status" => "enabled", "title" => "Minimized Header", "type" => "preset", "presets" => "minimized-header", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "12"),
																	   "content" => array("visibility" => array(), "status" => "enabled", "title" => "Main Content", "type" => "preset", "presets" => "content", "columns" => 0, "orderable" => true, "stylable" => true, "layout" => "12")),
																 ), 
										"footer" 		=> array("rows" => array("footer"  => array("visibility" => array(), "status" => "enabled", "title" => "Footer", "type" => "sidebar", "sidebar" => "i3d-widget-area-footer", "columns" => 0, "orderable" => false, "stylable" => false, "layout" => "4|4|2|2")))));



I3D_Framework::set_layout_section_wrapper_code("contact-panel", '', "", array());

I3D_Framework::set_layout_section_wrapper_code("primary-slider", '<div class="fullscreen-slider-wrapper">', '</div>', array());

I3D_Framework::set_layout_section_wrapper_code("secondary-slider", 	 "<div class='showcase-animated'><!-- slider section begin -->", '<!-- slider section end --></div><div>', array(array("tag" => "div", "class" => "section-inner"), array("tag" => "div", "class" => "wrapper"), array("tag" => "div", "class" => "container"), array("tag" => "div", "class" => "row inner")), array());

I3D_Framework::set_layout_section_wrapper_code("photo-slideshow", "", '', array());
I3D_Framework::set_layout_section_wrapper_code("utility-bar", '<div class="top">', "</div>", array(array("tag" => "div", "class" => "container"), array("tag" => "div", "class" => "row inner")));

I3D_Framework::set_layout_section_wrapper_code("main-menu", '<div class="sticky-menubar">', "</div>", array(array("tag" => "div", "class" => "container"), array("tag" => "div", "class" => "row inner")));
I3D_Framework::set_layout_section_wrapper_code("feature-boxes", '<div class="feature-boxes">', "</div>", array(array("tag" => "div", "class" => "container"), array("tag" => "div", "class" => "row inner")));
I3D_Framework::set_layout_section_wrapper_code("feature-boxes-secondary", '<div class="feature-boxes feature-boxes-secondary">', "</div>", array(array("tag" => "div", "class" => "container"), array("tag" => "div", "class" => "row inner")));
I3D_Framework::set_layout_section_wrapper_code("header", '<div class="header original fullscreen-maybe"><div class="fullscreen-slider-wrapper">', "</div>", array());
I3D_Framework::set_layout_section_wrapper_code("photo-slideshow-header", '<header class="header">', '</header>', array(array("tag" => "div", "class" => "container"), array("tag" => "div", "class" => "row inner")));
I3D_Framework::set_layout_section_wrapper_code("main", 	 "</div><div class='section-divider'></div><a id='showHere'></a><!-- main start -->", '<!-- main end -->', array(), array(array("tag" => "div", "class" => "content-wrapper"), array("tag" => "div", "class" => "container"), array("tag" => "div", "class" => "row inner")));
I3D_Framework::set_layout_section_wrapper_code("footer", "<!-- footer start --><div class='footer'><div class='section-inner'><div class='wrapper'><div class='container'><div class='row inner'><footer><div class='footer-top'>".__("Get in Touch!", get_template())."</div>", '</footer></div></div></div></div></div><!-- footer end -->', array());



$lmImageDefaults = array();
$lmImageDefaults['thumbnail']     = array('width' => 75, 'height' => 75);
$lmImageDefaults['small']         = array('width' => 380, 'height' => 200);
$lmImageDefaults['medium']        = array('width' => 600, 'height' => 298);
$lmImageDefaults['large']         = array('width' => 600, 'height' => 298);

$lmImageDefaults['posts-small']        = array('width' => 50, 'height' => 50);
$lmImageDefaults['posts-medium']       = array('width' => 75, 'height' => 75);
$lmImageDefaults['posts-large']        = array('width' => 200, 'height' => 100);
$lmImageDefaults['news-small']         = array('width' => 50, 'height' => 50);
$lmImageDefaults['news-medium']        = array('width' => 75, 'height' => 75);
$lmImageDefaults['news-large']         = array('width' => 420, 'height' => 200);


$lmImageDefaults['news-featured-1']     = array('width' => 924, 'height' => 200);/* 1 column */
$lmImageDefaults['news-featured-2']     = array('width' => 686, 'height' => 200);/* 2 column */
$lmImageDefaults['news-featured-3']     = array('width' => 456, 'height' => 200);/* 3 column */
$lmImageDefaults['news-featured-4']     = array('width' => 686, 'height' => 200); /* Magazine */
$lmImageDefaults['news-featured-5']     = array('width' => 686, 'height' => 200); /* Magazine */
$lmImageDefaults['news-featured-6']     = array('width' => 686, 'height' => 200);/* Magazine */
$lmImageDefaults['news-featured-7']     = array('width' => 686, 'height' => 200);/* Magazine */
$lmImageDefaults['news-featured-8']     = array('width' => 686, 'height' => 200);/* Magazine */
$lmImageDefaults['news-featured-9']     = array('width' => 686, 'height' => 200);/* Magazine */
$lmImageDefaults['news-featured-10']    = array('width' => 686, 'height' => 200);/* Magazine */
$lmImageDefaults['news-featured-11']    = array('width' => 686, 'height' => 200);/* Magazine */
$lmImageDefaults['news-featured-12']    = array('width' => 686, 'height' => 200);/* Magazine */

$lmImageDefaults['featured-page-feature-box'] = array('width' => 200, 'height' => 200);
$lmImageDefaults['featured-page-thumbnail'] = array('width' => 240, 'height' => 180);
$lmImageDefaults['featured-page-animated-image-box'] = array('width' => 465, 'height' => 348);
$lmImageDefaults['placeholder'] 		= array('width' => 240, 'height' => 180);
$lmImageDefaults['placeholder-thumbnail'] 		= array('width' => 240, 'height' => 180);
$lmImageDefaults['placeholder-feature-box'] 		= array('width' => 200, 'height' => 200);
$lmImageDefaults['placeholder-animated-image-box'] 		= array('width' => 480, 'height' => 360);


$i3dSupportedMenus['primary-horizontal']   = true;
$i3dSupportedMenus['primary-vertical']     = true;
$i3dSupportedMenus['sub-vertical']     = true;
$i3dSupportedMenus['primary-contact']      = true;
$i3dSupportedMenus['secondary-horizontal'] = true;
$i3dSupportedMenus['secondary-vertical']   = true;



$allSidebars =  array("default", "template-events-calendar", "template-sitemap", "template-advanced", "template-contact", "template-faqs", "template-photo-slideshow", "template-sitemap", "template-home", "template-blog", "template-minimized", "template-under-construction", "template-team-members");


$i3dSupportedSidebars = array('i3d-widget-area-top'          => array('name' => 'Top Menu', 
																	  'show_page_sidebar_configuration' => "template-advanced",
																	  'configurable' => array('advanced')),
							  'i3d-widget-area-header-top'   => array('name' => 'Contact Panel', 
																	  'show_page_sidebar_configuration' => "template-advanced",
																	  'configurable' => $allSidebars),																	  
							  'i3d-widget-area-header-main'  => array('name' => 'Logo', 
																	  'show_page_sidebar_configuration' => "template-advanced",
																	  'configurable' => array('advanced')),
							  'i3d-widget-area-header-lower' => array('name' => 'Info Boxes', 
																	  'show_page_sidebar_configuration' => "template-advanced",
																	  'configurable' => $allSidebars),
							  'i3d-widget-area-utility'      => array('name' => 'Utility', 
																	  'show_page_sidebar_configuration' => "default template-advanced template-sitemap template-contact-form template-blog template-faqs template-team-members template-blog-magazine",
																	  'configurable' => array('advanced')),																  
							  'i3d-widget-area-showcase'     => array('name' => 'Showcase', 
																	  'show_page_sidebar_configuration' => "default template-sitemap template-blog tempalte-blog-magazine",
																	  'configurable' => array('advanced')),																  
							  'i3d-widget-area-seo'          => array('name' => 'SEO', 
																	  'show_page_sidebar_configuration' => "default template-sitemap  template-business template-contact-form  template-blog template-faqs template-team-members",
																	  'configurable' => $allSidebars),																  
							  'i3d-widget-area-breadcrumb'   => array('name' => 'Breadcrumb', 
																	  'show_page_sidebar_configuration' => "default template-contact-form  template-blog template-faqs template-team-members template-blog-magazine",
																	  'configurable' => $allSidebars),							  
							  'i3d-widget-area-main-top'     => array('name' => 'Main Top', 
																	  'show_page_sidebar_configuration' => "default template-contact-form template-blog-traditional template-faqs template-team-members template-blog-magazine",
																	  'configurable' => $allSidebars),

							  'i3d-widget-area-main'     => array('name' => 'Main', 
																	  'show_page_sidebar_configuration' => "default template-contact-form tempalte-blog-magazine",
																	  'configurable' => $allSidebars),

							  'i3d-widget-area-main-bottom'  => array('name' => 'Main Bottom', 
																	  'show_page_sidebar_configuration' => "default template-contact-form template-blog template-faqs template-team-members template-blog-magazine",
																	  'configurable' => $allSidebars),
							  'i3d-widget-area-lower'        => array('name' => 'Lower', 
																	  'show_page_sidebar_configuration' => "default template-business template-contact-form template-blog template-faqs template-team-members template-blog-magazine",
																	  'configurable' => $allSidebars),
							  'i3d-widget-area-bottom'       => array('name' => 'Bottom', 
																	  'show_page_sidebar_configuration' => "default template-business template-contact-form template-blog template-faqs template-team-members template-blog-magazine",
																	  'configurable' => $allSidebars),
							  'i3d-widget-area-advertising'  => array('name' => 'Advertising', 
																	  'show_page_sidebar_configuration' => "default template-business template-contact-form template-blog template-faqs template-team-members template-blog-magazine",
																	  'configurable' => $allSidebars),
							  'i3d-widget-area-footer'       => array('name' => 'Footer', 
																	  'show_page_sidebar_configuration' => "default",
																	  'configurable' => $allSidebars),
							  'i3d-widget-area-copyright'    => array('name' => 'Copyright',
																	  'show_page_sidebar_configuration' => "default",
																	  'configurable' => $allSidebars));


	I3D_Framework::$globalPageDividers = array("" => "None",
											   "gap-spacer-xs" => "Gap Spacer XS",
											   "gap-spacer-sm" => "Gap Spacer SM",
											   "gap-spacer-md" => "Gap Spacer MD",
											   "gap-spacer-lg" => "Gap Spacer LG",
											   "gap-spacer-xl" => "Gap Spacer XL",
											   "divider1" => "Light Diagonal Lines", 
											   "divider2" => "Dark Vertical Lines");


include("framework/config-options.php");

// portfolio/nivo-slider defaults
$lmPortfolioConfig = array();
$lmPortfolioConfig['default-image-prefix']          		  = "holder"; // also used by the blog images
$lmPortfolioConfig['default-image-prefix-nivo']    			  = "portfolio-very-large-";
$lmPortfolioConfig['default-image-prefix-nivo-secondary']     = "portfolio-small-";



/*************** featured page BOX ****************/
//$lmWidgetWrapConfig['feature-page-box']['format']  = '<h3><a class="title-link" href="[titlehref]">[title]</a></h3><div class="centerpic"><a href="[imghref]">[img]</a></div><p>[description]</p>';
$lmWidgetWrapConfig['info-box']['feature-box']['title']        = "Feature Box";
$lmWidgetWrapConfig['info-box']['feature-box']['widget_html']  = '<div class="fb-inner-wrapper"><div class="fb-feature-box"><div class="fb-image img-circle">[img]</div>
                                                                  <div class="fb-content"><div class="fb-content-inner"><p>[description]</p>[btn]</div></div>
																  <[title_tag]>[title]</[title_tag]></div></div>';
$lmWidgetWrapConfig['info-box']['feature-box']['button_html']  = '<a href="[linkhref]" class="fb-button" roll="button">[button link text]</a>';
$lmWidgetWrapConfig['info-box']['feature-box']['img_classes']  = "";
$lmWidgetWrapConfig['info-box']['feature-box']['options']      = array('image', 'title_tag');


$lmWidgetWrapConfig['info-box']['thumbnail']['title']        = "Thumbnail";
$lmWidgetWrapConfig['info-box']['thumbnail']['widget_html']  = '<div class="info-box-carousel-bg"><a href="[imghref]" class="thumbnail">[img]</a><[title_tag]>[title]</[title_tag]>[hr]<p>[description]</p>[btn]</div>';
$lmWidgetWrapConfig['info-box']['thumbnail']['button_html']  = '<a href="[linkhref]" class="btn btn-default btn-sm pull-right">[button link text]</a>';
$lmWidgetWrapConfig['info-box']['thumbnail']['img_classes']  = "img-responsive";
$lmWidgetWrapConfig['info-box']['thumbnail']['options']      = array('image', 'title_text_linkable', 'title_tag', 'hr', 'image_mask');

/*
$lmWidgetWrapConfig['info-box']['hover-icon']['title']        = "Hover Icon";
$lmWidgetWrapConfig['info-box']['hover-icon']['widget_html']  = '<div class="vector-icon-info-box">
<div class="hi-icon-wrap hi-icon-effect-1 hi-icon-effect-1a"><a class="hi-icon [hover_icon]" href="[titlehref]">[title]</a></div>
<[title_tag] class="small-caps text-center">[title]</[title_tag]>[hr]<p class="text-center"><small>[description]</small></p>[btn]</div>';
$lmWidgetWrapConfig['info-box']['hover-icon']['button_html']  = '<p class="text-center"><a href="[linkhref]" class="btn btn-primary">[button link text]</a></p>';
$lmWidgetWrapConfig['info-box']['hover-icon']['options']      = array('hover_icon', 'title_tag');



$lmWidgetWrapConfig['info-box']['wrapbox']['title']        = "WrapBox";
$lmWidgetWrapConfig['info-box']['wrapbox']['widget_html']  = '<div class="snippet13"><h3 class="h3-lead">[title]</h3><h3 class="h3-bold">[title2]</h3><p>[description]</p>[btn]</div>';
$lmWidgetWrapConfig['info-box']['wrapbox']['button_html']  = '<button class="btn btn-small" type="button" onclick="document.location.href=\'[linkhref]\'">[button link text]</button>';
$lmWidgetWrapConfig['info-box']['wrapbox']['options']      = array('title_text_2');

 
$lmWidgetWrapConfig['info-box']['animated-image-box']['title']        = "Animated Image Box";
$lmWidgetWrapConfig['info-box']['animated-image-box']['widget_html']  = '<section class="content-section content-init"><!--split--><article class="content-side content-side-[content_position]"><[title_tag]>[title]</[title_tag]>[hr]<p>[description]</p>[btn]</article><!--split--><figure class="content-side content-side-[image_position]">[img]</figure><!--split--></section>';
$lmWidgetWrapConfig['info-box']['animated-image-box']['button_html']  = '<p class="center"><a href="[linkhref]" class="btn btn-primary">[button link text]</a></p>';
$lmWidgetWrapConfig['info-box']['animated-image-box']['img_classes']  = "img-thumbnail img-responsive";
$lmWidgetWrapConfig['info-box']['animated-image-box']['options']      = array('image', 'title_text_linkable', 'title_tag', 'image_position');
*/

// WPWFW 2 rev 1, custom component sidebars
// note, these can only implemented on ACTIVATION (activate=true) or UPGRADE (upgrade=true)
$lmUsesCustomComponentRegions = true;
$customComponentSidebars = array();
$customComponentSidebars['luckymarble-custom-component-1-widget-area'] = "Custom Component Region 1";
$customComponentSidebars['luckymarble-custom-component-2-widget-area'] = "Custom Component Region 2";
$customComponentSidebars['luckymarble-custom-component-3-widget-area'] = "Custom Component Region 3";

$filesToInclude[] = "user_view/custom_components";

$lmUsesConfigurableDropDowns = true;
$lmUpdaterAvailable          = true;
$topMenuTag 				 = "ul";
?>
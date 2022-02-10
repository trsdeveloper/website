<?php
function i3d_update_administrative_menu() {
	global $menu, $submenu, $_registered_pages, $templateName, $advancedMenu, $_wp_last_utility_menu;
	global $settingOptions;
	global $lmIncludedComponents;
	global $lmFrameworkVersion;
	global $lmUsesConfigurableDropDowns;
	global $lmUpdaterAvailable;
	//print $templateName;

	if (!isset($settingOptions)) {
	  $settingOptions = get_option('i3d_general_settings');
	}

		$templateName2 = str_replace(' ', '_', ucwords($templateName));
	//print $templateName2;
			
		add_theme_page('Manage Sidebars', 'Manage Sidebars', 'edit_theme_options', 'i3d-edit-sidebar', 'i3d_admin_sidebar');
		add_theme_page('Add New Sidebar', 'Add Sidebar', 'edit_theme_options', 'i3d-add-sidebar', 'i3d_admin_add_sidebar');
		 
		unset($menu[99]);

		//add separator
		//$menu[] = array( '', 'read', 'separator5', '', 'wp-menu-separator' ); 
		add_menu_page('Theme Framework', $templateName, 'edit_theme_options', 'i3d-settings', 'i3d_admin_settings', get_template_directory_uri() .'/includes/admin/images/aquila-sm.png');
		add_submenu_page("i3d-settings", 'Manage Framework Settings', '<i class="fa fa-fw fa-map-o"></i> Theme Framework', 'edit_theme_options', "i3d-settings");
		add_submenu_page("i3d-settings", 'Manage Framework Settings', '<i class="fa fa-fw fa-dashboard"></i> Control Panel', 'edit_themes', "admin.php?page=i3d-settings&tab=tabs-configure");
		add_submenu_page("i3d-settings", 'Manage Framework Settings', '<i class="fa fa-fw fa-graduation-cap"></i> Tutorials', 'edit_theme_options', "admin.php?page=i3d-settings&tab=tabs-tutorials");
		add_submenu_page("i3d-settings", 'Manage Framework Settings', '<i class="fa fa-fw fa-support"></i> Support', 'edit_theme_options', "admin.php?page=i3d-settings&tab=tabs-support");
		add_submenu_page(
        "i3d-settings",                //parent menu slug to attach to
        "",                          //page title (left blank)
                                     //menu title (inserted span with inline CSS)
       '<span class="admin-menu-divider"></span>',
        "edit_themes",              //capability (set to your requirement)
        "#"                          //slug (URL) shows Hash domain.com/# incase of mouse over
     );
		//print sizeof(I3D_Framework::getSliders());
		if (I3D_Framework::use_global_layout()) {
		  add_submenu_page("i3d-settings", 'Layout Editor', '<i class="fa fa-fw fa-sliders"></i> Layout Editor', 'edit_theme_options', "i3d_layouts", "i3d_layouts");
			
		}
		
		if (sizeof(I3D_Framework::getSliders()) > 0) {
		  add_submenu_page("i3d-settings", 'Manage Sliders', '<i class="fa fa-fw fa-photo"></i>  Sliders', 'edit_theme_options', "i3d_sliders", "i3d_sliders");
		}
		
		add_submenu_page("i3d-settings", 'Manage Contact Forms', '<i class="fa fa-fw fa-envelope"></i> Contact Forms', 'edit_theme_options', "i3d_contact_forms", "i3d_contact_forms");
		//add_submenu_page("{$templateName2}-settings", 'Manage Reservations', 'Reservations', 'edit_themes', "{$templateName2}-reservations");

		if (I3D_Framework::$focalBoxVersion == 0 ) { 
			add_submenu_page("i3d-settings", 'Manage Calls To Action', '<i class="fa fa-fw fa-bullhorn"></i>  Calls To Action', 'edit_theme_options', "i3d_calls_to_action", "i3d_calls_to_action");
		}
		if (I3D_Framework::$focalBoxVersion > 0 ) { 
			add_submenu_page("i3d-settings", 'Manage Focal Boxes', '<i class="fa fa-fw fa-bullhorn"></i>  Focal Boxes', 'edit_theme_options', "i3d_focal_boxes", "i3d_focal_boxes");
		}
		
		if (I3D_Framework::$optionalStyledBackgrounds > 0 ) { 
			add_submenu_page("i3d-settings", 'Manage Active Backgrounds', '<i class="fa fa-fw fa-map-marker"></i>  Active Backgrounds', 'edit_theme_options', "i3d_active_backgrounds", "i3d_active_backgrounds");
		}
		
		add_submenu_page("i3d-settings", 'Manage Content Panels', '<i class="fa fa-fw fa-pencil"></i>  Content Panels', 'edit_theme_options', "i3d_content_panels", "i3d_content_panels");
		if (post_type_exists("i3d-testimonial") ||
			post_type_exists("i3d-faq") ||
			post_type_exists("i3d-team-member") ||
			post_type_exists("i3d-portfolio-item")) {
		add_submenu_page(
        "i3d-settings",                //parent menu slug to attach to
        "",                          //page title (left blank)
                                     //menu title (inserted span with inline CSS)
       '<span class="admin-menu-divider"></span>',
        "edit_themes",              //capability (set to your requirement)
        "#"                          //slug (URL) shows Hash domain.com/# incase of mouse over
     );
		}
		if (post_type_exists("i3d-testimonial")) {
			add_submenu_page("i3d-settings", 'Manage Quotes', 			'<i class="fa fa-fw fa-quote-left"></i> Quotations', 		'edit_theme_options', 	"edit.php?post_type=i3d-testimonial");
			add_submenu_page("i3d-settings", 'Manage Quotation Categories', 	'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#8627; Categories', 	'edit_theme_options',  "edit-tags.php?taxonomy=i3d-quotation-category");
		}
		
		if (post_type_exists("i3d-faq")) {
			add_submenu_page("i3d-settings", 'Manage FAQs', 			'<i class="fa fa-fw fa-question-circle"></i> FAQs', 				'edit_theme_options',  "edit.php?post_type=i3d-faq");
			add_submenu_page("i3d-settings", 'Manage FAQs Categories', 	'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#8627; Categories', 	'edit_theme_options',  "edit-tags.php?taxonomy=i3d-faq-category");
		}

		if (post_type_exists("i3d-team-member")) {
			add_submenu_page("i3d-settings", 'Manage Team Members', '<i class="fa fa-fw fa-users"></i> Team Members', 'edit_theme_options', "edit.php?post_type=i3d-team-member");
			add_submenu_page("i3d-settings", 'Manage Team Depts', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#8627; Departments', 'edit_theme_options',  "edit-tags.php?taxonomy=i3d-team-member-department");
		}
		if (post_type_exists("i3d-portfolio-item")) {
			if (I3D_Framework::$isotopePortfolioVersion > 0) {
			add_submenu_page("i3d-settings", 'Manage Portfolio', '<i class="fa fa-fw fa-photo"></i> Portfolio', 'edit_theme_options', "edit-tags.php?taxonomy=i3d-portfolio");
			add_submenu_page("i3d-settings", 'Manage Porfolio Items', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#8627; Items', 'edit_theme_options',  "edit.php?post_type=i3d-portfolio-item");
			}
		}
		
		if ($lmUpdaterAvailable) {
		add_submenu_page(
        "i3d-settings",                //parent menu slug to attach to
        "",                          //page title (left blank)
                                     //menu title (inserted span with inline CSS)
       '<span class="admin-menu-divider"></span>',

        "edit_themes",              //capability (set to your requirement)
        "#"                          //slug (URL) shows Hash domain.com/# incase of mouse over
     );
		//add_submenu_page("i3d-settings", 'Manage Portfolio', 'Portfolio', 'edit_themes', "{$templateName2}-portfolio");
		
		
		  add_submenu_page('i3d-settings', 'Update Theme', '<i class="fa fa-fw fa-cloud-download '.(I3D_Framework::updateIsCurrent() ? '' : 'fa-warning').'"></i> Update Theme', 'edit_theme_options', 'i3d-update-theme', 'i3d_update_theme');
		}
	
		//add final separator back into the page
		//$menu[] = array( '', 'read', 'separator-last', '', 'wp-menu-separator-last' );
		

}

add_action('admin_menu', 'i3d_update_administrative_menu');
?>
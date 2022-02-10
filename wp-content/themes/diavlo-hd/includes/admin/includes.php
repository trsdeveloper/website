<?php

if (file_exists(get_template_directory()."/includes/theme/config.php")) {
	include(get_template_directory().'/includes/theme/config.php');
} else {
	include(get_template_directory().'/includes/config.php');
}
include(get_template_directory().'/includes/admin/install.php');


function i3d_admin_enqueue_scripts() {	
	global $templateName;
	global $pagenow;
	
	$templateName2 = str_replace(' ', '_', ucwords($templateName));
	//if ( 'post.php' != $pagenow && 'post-new.php' != $pagenow ) {
		//wp_deregister_script('heartbeat');
	//}
		
	wp_enqueue_script('jquery'); 
	wp_enqueue_script('utils'); 
	wp_enqueue_script('jquery-ui-core'); 
	wp_enqueue_script('jquery-ui-sortable'); 
	wp_enqueue_script('jquery-ui-tabs'); 
	wp_enqueue_script('jquery-ui-draggable'); 
	wp_enqueue_script('jquery-ui-dropable'); 
	wp_enqueue_script('jquery-ui-resizable'); 
	wp_enqueue_script('jquery-ui-selectable'); 
	wp_enqueue_script('jquery-ui-slider'); 
	wp_enqueue_script('media-upload'); 
	wp_enqueue_script('thickbox'); 
	wp_enqueue_media();

	wp_register_script('custom-post-types', get_template_directory_uri() .'/includes/admin/control-panel/js/custom-post-types.js', array('jquery', 'utils', 'jquery-ui-core', 'jquery-ui-sortable', 'media-upload', 'thickbox'), '1.0' );
	
	if (isset($_GET['post_type']) && ($_GET['post_type'] == "i3d-testimonials" || $_GET['post_type'] == "i3d-faq" || $_GET['post_type'] == "i3d-portfolio-item" || $_GET['post_type'] == "i3d-team-member") ) {
		wp_enqueue_script('custom-post-types');
	}

	if (isset($_GET['page']) && $_GET['page'] == "i3d_sliders") {
		wp_register_script('portfolio-rotator', get_template_directory_uri() .'/includes/admin/control-panel/js/portfolio-rotator.js', array('jquery', 'utils', 'jquery-ui-core', 'jquery-ui-sortable', 'media-upload', 'thickbox'), '1.0' );
		wp_enqueue_script('portfolio-rotator');
	}

	
	// enqueue the script
	wp_register_script('i3d-bootstrap', get_template_directory_uri() .'/includes/admin/control-panel/bootstrap/3.2.0/js/bootstrap.min.js', array('jquery'), '3.2', true );
	wp_register_script('i3d-widgets', get_template_directory_uri() .'/includes/admin/control-panel/js/widgets.js', array('jquery'), '1.0' );
	
	if (isset($_GET['page']) && $_GET['page'] == "i3d-settings") {
		wp_enqueue_script('bootstrap-datepicker', get_template_directory_uri()."/includes/user_view/datepicker/js/bootstrap-datepicker.js", array('jquery', 'i3d-bootstrap'), '1.0', true);
		wp_enqueue_style('bootstrap-datepicker', get_template_directory_uri()."/includes/user_view/datepicker/css/datepicker.css");
		wp_enqueue_script('bootstrap-datetimepicker-moment', get_template_directory_uri()."/includes/user_view/datetimepicker/js/moment.js", array('jquery', 'i3d-bootstrap'), '1.0', true);
		wp_enqueue_script('bootstrap-datetimepicker', get_template_directory_uri()."/includes/user_view/datetimepicker/js/bootstrap-datetimepicker.min.js", array('jquery', 'i3d-bootstrap'), '1.0', true);
		wp_enqueue_style('bootstrap-datetimepicker', get_template_directory_uri()."/includes/user_view/datetimepicker/css/bootstrap-datetimepicker.min.css");
		wp_enqueue_script('tabulous');
	}
	
	wp_enqueue_script('i3d-bootstrap');
	
	if ($pagenow == "widgets.php") {
		wp_enqueue_script('i3d-widgets');
	}
	
	wp_register_style( 'i3d-admin-style',  get_template_directory_uri()  . '/includes/admin/control-panel/css/styles.css');
	wp_register_style( 'i3d-fw-style',  get_template_directory_uri()  . '/includes/admin/control-panel/css/fw-styles.css');
	wp_register_style( 'i3d-fw-style2',  get_template_directory_uri()  . '/includes/admin/control-panel/css/fw-styles2.css');
	wp_register_style( 'i3d-tabulous-style',  get_template_directory_uri()  . '/includes/admin/control-panel/css/tabulous.css');
	wp_register_style( 'i3d-bootstrap', get_template_directory_uri() .'/includes/admin/control-panel/bootstrap/3.2.0/css/bootstrap-admin.css');
	wp_register_style( 'i3d-bootstrap-navonly', get_template_directory_uri() .'/includes/admin/control-panel/bootstrap-navonly/css/bootstrap.min.css');
	wp_register_style( 'i3d-font-awesome',  get_template_directory_uri() .'/includes/admin/control-panel/font-awesome/css/font-awesome.min.css');
	wp_register_style( 'i3d-font-awesome4',  get_template_directory_uri() .'/includes/admin/control-panel/font-awesome-4.4.0/css/font-awesome.min.css');
	
	wp_register_style( 'i3d-jquery-ui',  '//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');
	wp_register_script('i3d-theme-settings', 	get_template_directory_uri() .'/includes/admin/control-panel/js/settings.js', array('jquery'), '1.0' );
	wp_register_script('i3d-theme-settings-tf', 	get_template_directory_uri() .'/includes/admin/control-panel/js/settings-theme-forest.js', array('jquery'), '1.0' );
	
	if (isset($_GET['page']) && $_GET['page'] == "i3d-settings") {
		wp_register_style('i3d-hover-icons', 	get_template_directory_uri() .'/includes/user_view/hovericons/hovericons.css' );
		wp_register_script('i3d-hover-icons-components', 	get_template_directory_uri() .'/includes/user_view/hovericons/component.js', array('jquery'), '1.0' );
		wp_register_script('i3d-farbtastic-color-picker', 	get_template_directory_uri() .'/includes/admin/control-panel/js/farbtastic.js', array('jquery'), '1.0' );
		wp_register_style('i3d-farbtastic-color-picker-css', 	get_template_directory_uri() .'/includes/admin/control-panel/css/farbtastic.css' );
		wp_enqueue_style( 'i3d-fw-style' );	
		wp_enqueue_style( 'i3d-bootstrap' );
		wp_enqueue_style( 'thickbox' );
		wp_enqueue_style( 'i3d-hover-icons');
		wp_enqueue_script('i3d-hover-icons-components');
		wp_enqueue_script('i3d-theme-settings');
		wp_enqueue_script( 'i3d-farbtastic-color-picker' );
		wp_enqueue_style('i3d-farbtastic-color-picker-css');

	} else 	if (isset($_GET['page']) && $_GET['page'] == "i3d_sliders") {
		wp_enqueue_style( 'i3d-bootstrap' );
		wp_enqueue_style( 'i3d-fw-style2' );	

	} else if ($pagenow == "post.php" || $pagenow == "post-new.php") {
		wp_enqueue_style( 'i3d-fw-style2' );	
		wp_enqueue_style( 'i3d-bootstrap' );
		wp_enqueue_script('i3d-theme-settings');

	} else if (isset($_GET['page']) && ($_GET['page'] == "i3d_contact_forms" || 
										$_GET['page'] == "i3d_focal_boxes" || 
										$_GET['page'] == "i3d_calls_to_action" || 
										$_GET['page'] == "i3d_active_backgrounds" || 
										$_GET['page'] == "i3d_layouts" || 
										$_GET['page'] == "i3d_content_panels")) {
		wp_enqueue_style( 'i3d-bootstrap' );
		wp_enqueue_style( 'i3d-fw-style2' );	

	} else if (@$pagenow == "index.php" || @$_GET['page'] == "i3d-update-theme") {
		wp_enqueue_style( 'i3d-bootstrap' );
		wp_enqueue_style( 'i3d-fw-style2' );	
	
	} else if ($pagenow == "widgets.php") { 
		wp_enqueue_style( 'i3d-bootstrap-navonly' );
		wp_enqueue_style( 'i3d-fw-style2' );	
	} 
	
	wp_enqueue_style( 'i3d-admin-style' );
	wp_enqueue_style( 'i3d-jquery-ui' );	
	wp_enqueue_style( 'i3d-font-awesome' ); 
	wp_enqueue_style( 'i3d-font-awesome4' ); 
	
	if ((isset($_GET['page']) && $_GET['page'] == "i3d-settings") || $pagenow == "widgets.php" || $pagenow == "post.php" || $pagenow == "post-new.php") {
		wp_enqueue_style( 'i3d-layout-manager',   get_template_directory_uri(). "/includes/admin/control-panel/css/layout-manager.css");	
		wp_enqueue_script('i3d-jquery-slim-scrollbar', get_template_directory_uri()."/includes/admin/control-panel/js/jquery.slimscroll.min.js");
	}
	
	if (isset($_GET['page']) && $_GET['page'] == "i3d_layouts") {
		wp_enqueue_style( 'i3d-layout-manager',   get_template_directory_uri(). "/includes/admin/control-panel/css/layout-manager.css");	
		wp_enqueue_script('i3d-jquery-slim-scrollbar', get_template_directory_uri()."/includes/admin/control-panel/js/jquery.slimscroll.min.js");
	}
	
    if (isset($_GET['page']) && ($_GET['page'] == "i3d_sliders" || 
							     $_GET['page'] == "i3d_contact_forms" || 
								 $_GET['page'] == "i3d_calls_to_action" || 
								 $_GET['page'] == "i3d_content_panels" || 
								 $_GET['page'] == "i3d_active_backgrounds" || 
								 $_GET['page'] == "i3d_layouts" || 
								 $_GET['page'] == "i3d_focal_boxes")) {
			  wp_enqueue_style( 'i3d-font-awesome4' ); 
	 }
	 
	 if ($pagenow == "widgets.php" && I3D_Framework::$supportType != "i3d") {
		wp_register_style( 'i3d-admin-style-tf',  get_template_directory_uri()  . '/includes/admin/control-panel/css/styles-themeforest.css');
		wp_enqueue_style( 'i3d-admin-style-tf' );	
		wp_enqueue_script('i3d-theme-settings-tf');
	 } 
	 

}

function i3d_admin_body_class($classes) {
	if (@$_GET['page'] != "i3d-settings") {
		$classes .= " i3d-no-nagging";
	
	} 
	return $classes; 
}

add_filter( 'admin_body_class', 'i3d_admin_body_class' );

function i3d_font_awesome_picker_helper() {
	if ($_POST['groups'] == "") {
		$_POST['groups'] = array();
	} else {
		$_POST['groups'] = explode(",", $_POST['groups']);
	}
	I3D_Framework::renderFontAwesomeSelect($_POST['inputName'], $_POST['inputValue'], ($_POST['default'] == "true"), $_POST['defaultSelector'], $_POST['noIcon'], "", $_POST['groups'], 2);
	wp_die();
}

add_action( 'wp_ajax_i3d_get_font_awesome_picker', 'i3d_font_awesome_picker_helper' ); // Write our JS below here
add_action('admin_enqueue_scripts', 'i3d_admin_enqueue_scripts');

// this prevents the "cannot modify header information" on wp_redirect
function i3d_output_buffer() {
	  ob_start();
} 

add_action('init', 'i3d_output_buffer');


function order_testimonials( $query ) {
	global $pagenow;
    if ( array_key_exists("post_type", $query->query) && $query->query['post_type'] == "i3d-testimonial" ) {
        $query->set('orderby', 'menu_order');
		$query->set('order', 'ASC' );

	}
}

function order_faqs( $query ) {
	global $pagenow;
    if ( array_key_exists("post_type", $query->query) && $query->query['post_type'] == "i3d-faq" ) {
        $query->set('orderby', 'menu_order');
		$query->set('order', 'ASC' );

	}
}

function order_portfolio_items( $query ) {
	global $pagenow;
    if ( array_key_exists("post_type", $query->query) && $query->query['post_type'] == "i3d-portfolio-item" ) {
        $query->set('orderby', 'menu_order');
		$query->set('order', 'ASC' );
	}
}

function order_team_members( $query ) {
	global $pagenow;
	global $order_by_override;
    if ( array_key_exists("post_type", $query->query) && $query->query['post_type'] == "i3d-team-member" && !@$order_by_override) {
        $query->set('orderby', 'menu_order');
		$query->set('order', 'ASC' );
	}
}

function force_admin_menu() {
	  global $post;
	  global $_GET;
	  
	  if (@$post->post_type == "i3d-testimonial" || 
		  @$post->post_type == "i3d-faq" ||
		  @$post->post_type == "i3d-team-member" ||
		  @$post->post_type == "i3d-portfolio-item" ||
		  (array_key_exists("taxonomy", $_GET) && ($_GET['taxonomy'] == "i3d-faq-category" || $_GET['taxonomy'] == "i3d-team-member-department"))) {
		?>
       <script>
	   jQuery(document).ready(function() {
	jQuery("#toplevel_page_i3d-settings").addClass("wp-has-current-submenu");
	jQuery("#toplevel_page_i3d-settings").addClass("wp-menu-open");
	jQuery("#toplevel_page_i3d-settings").removeClass("wp-not-current-submenu");
	jQuery("#menu-posts").addClass("wp-not-current-submenu");
	jQuery("#menu-posts").removeClass("wp-has-current-submenu");
	jQuery("#menu-posts").removeClass("wp-menu-open");
	jQuery(window).resize();
									   });
	</script>
    <?php
    }
	
}

add_action('admin_footer-post.php', 'force_admin_menu');
add_action('admin_footer-edit-tags.php', 'force_admin_menu');

add_action( 'pre_get_posts', 'order_testimonials' );
add_action( 'pre_get_posts', 'order_faqs' );
add_action( 'pre_get_posts', 'order_team_members' );
add_action( 'pre_get_posts', 'order_portfolio_items' );

function js_stylesheet_url() {
	?>
    <script>
	var stylesheetDirectory = "<?php echo get_stylesheet_directory_uri() ; ?>";
	</script>
    <?php
}

add_action("admin_footer-edit.php", 'js_stylesheet_url');
require_once(ABSPATH . 'wp-admin/includes/plugin.php');
deactivate_plugins("i3d-theme-framework-extender/i3d-theme-framework-extender.php");
include(get_template_directory().'/includes/admin/menu.php');
include(get_template_directory().'/includes/admin/dashboard.php');
include(get_template_directory().'/includes/admin/page-layouts/post_meta_data.php');
include_once(get_template_directory().'/includes/admin/control-panel/settings.php');
include(get_template_directory().'/includes/admin/control-panel/request-configuration.php');
include(get_template_directory().'/includes/admin/control-panel/installation-progress.php');
include(get_template_directory().'/includes/admin/control-panel/sidebars.php');
include(get_template_directory().'/includes/admin/control-panel/_faqs.php');
include(get_template_directory().'/includes/admin/control-panel/_testimonials.php');
include(get_template_directory().'/includes/admin/control-panel/_team-members.php');
include(get_template_directory().'/includes/admin/control-panel/_portfolio.php');
include(get_template_directory().'/includes/admin/control-panel/_sliders.php');
include(get_template_directory().'/includes/admin/control-panel/_contact-forms.php');
include(get_template_directory().'/includes/admin/control-panel/_calls-to-action.php');
include(get_template_directory().'/includes/admin/control-panel/_content-panels.php');
include(get_template_directory().'/includes/admin/control-panel/_active-backgrounds.php');
if (I3D_Framework::$focalBoxVersion > 0 ) { 
include(get_template_directory().'/includes/admin/control-panel/_focal-boxes.php');
}
if (I3D_Framework::use_global_layout()) { 
include(get_template_directory().'/includes/admin/control-panel/_layouts.php');
}

if ($lmUpdaterAvailable) {
	include(get_template_directory().'/includes/admin/control-panel/update.php');
}
?>
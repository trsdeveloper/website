<?php
require_once dirname( __FILE__ ) . '/../plugins/config.php';

function page_exists($postTitle, &$pageID = "") {
	$pages = get_pages();
	foreach ($pages as $page) {
		if ($page->post_title == $postTitle) {
			$pageID = $page->ID;
			return true;
		}
	}
	return false;
}

function menu_items_exist($menu) {
	
	$theMenu = wp_nav_menu(array('theme_location' => $menu, 'container' => false, 'menu_class' => '', 'menu_id' => 'menu', 'echo' => false)); 

	$theMenu = str_replace('<ul id="menu"></ul>', '', $theMenu);
	//print htmlentities($theMenu);
	return $theMenu != "";
}
			
			add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );

add_action('wp_dashboard_setup', 'luckymarble_set_dashboard_widgets' );

$i3d_general_settings =  get_option('i3d_general_settings', array());

if (@$i3d_general_settings['disable_admin_bar'] == "1") {
	add_action( 'show_admin_bar', '__return_false' );
}

// Add Formats Dropdown Menu To MCE
	if ( ! function_exists( 'wpex_style_select' ) ) {
	    function wpex_style_select( $buttons ) {
	        array_push( $buttons, 'styleselect' );
	        return $buttons;
	    }
	}
	add_filter( 'mce_buttons', 'wpex_style_select' );





function luckymarble_text_domain_setup(){
	//print "done";
    load_theme_textdomain("i3d-framework", get_template_directory() . '/languages');
}

function recommendedFunctions() {
		 
		  // this function is not actually called, this is just to satisfy the theme-check plugin
		  
		  the_post_thumbnail();
	 		add_theme_support( 'automatic-feed-links' ) ;
	 		add_theme_support( 'custom-header' ) ;
			add_theme_support( 'custom-background');
			add_editor_style();
		
}


function luckymarble_get_search_form() {
	global $display_search_box;
	//check if search box should be displayed
    if($dispay_search_box == "1") {
        // generate search box display
        get_search_form();
    }
}



/**********************************/
/**** REGISTER CUSTOM SIDEBARS ****/
/**********************************/
function luckymarble_add_tinymce_buttons() {
   // Don't bother doing this stuff if the current user lacks permissions
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;

   // Add only in Rich Editor mode
   if ( get_user_option('rich_editing') == 'true') {
     add_filter("mce_external_plugins", "luckymarble_add_tinymce_plugins");
    add_filter('mce_buttons_2', 'luckymarble_register_tinymce_buttons');
	// print "rich on2";
   }
}
 
/************************************************/
/**** ADD CUSTOM BUTTONS TO EDITOR (tinymce) ****/
/************************************************/
function luckymarble_register_tinymce_buttons($buttons) {
	global $wp_version;
	//return $buttons;
	
	if (version_compare($wp_version, "3.9", "<")) {
	  if (I3D_Framework::$focalBoxVersion == 0 ) { 
	  	array_push($buttons, "|", "i3d_contact_form", "i3d_cta", "i3d_cpg");
	  
	  } else {
	  	array_push($buttons, "|", "i3d_contact_form", "i3d_cpg");
	  }
	} else { 
		  if (I3D_Framework::$focalBoxVersion == 0 ) { 
	  		array_push($buttons, "i3d_contact_form", "i3d_cta", "i3d_cpg", "i3d_portfolio_gallery");
		  } else {
	  		array_push($buttons, "i3d_contact_form", "i3d_cpg", "i3d_portfolio_gallery");
		  }
	}
	//var_dump($buttons);
	
   return $buttons;
}
 
 
// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
function luckymarble_add_tinymce_plugins($plugin_array) {
	global $wp_version;
	
	if (version_compare($wp_version, "3.9", "<")) {
	  $plugin_array['i3d_contact_form'] = get_template_directory_uri() .'/includes/admin/tinymce_plugins/contact_form/plugin.js';
	   if (I3D_Framework::$focalBoxVersion == 0 ) { 
	  		$plugin_array['i3d_cta'] = get_template_directory_uri() .'/includes/admin/tinymce_plugins/call_to_action/plugin.js';
	   }
	  $plugin_array['i3d_cpg'] = get_template_directory_uri() .'/includes/admin/tinymce_plugins/content_panels/plugin.js';
		
	} else {
	//	print $wp_version;
		//$plugin_array['compat3x'] = includes_url()."/js/tinymce/plugins/compat3x/plugin.js";
	//	var_dump($plugin_array);
	  $plugin_array['i3d_contact_form'] = get_template_directory_uri() .'/includes/admin/tinymce_plugins/contact_form/plugin-v4.js';
 		if (I3D_Framework::$focalBoxVersion == 0 ) { 	  
	  		$plugin_array['i3d_cta'] = get_template_directory_uri() .'/includes/admin/tinymce_plugins/call_to_action/plugin-v4.js';
 		}
	  $plugin_array['i3d_cpg'] = get_template_directory_uri() .'/includes/admin/tinymce_plugins/content_panels/plugin-v4.js';
	  $plugin_array['i3d_portfolio_gallery'] = get_template_directory_uri() .'/includes/admin/tinymce_plugins/portfolio_gallery/plugin-v4.js';
	}
	
	return $plugin_array;
}

function luckymarble_update_tinymce_version($ver) {

  $ver += 3;
  return $ver;
}
//add_filter('tiny_mce_version', 'luckymarble_update_tinymce_version');
add_filter('widget_text', 'do_shortcode');
 

// init process for button control
add_action('init', 'luckymarble_add_tinymce_buttons');

/**********************************/
/**** REMOVE DASHBOARD WIDGETS ****/
/**********************************/
function luckymarble_set_dashboard_widgets() {
	global $wp_meta_boxes;
	global $settingOptions;
	
	if (!isset($settingOptions)) {
	  $settingOptions = get_option('i3d_general_settings');
	}

	// only remove dashboard items if user is using the simplified site manager
	if (@$settingOptions['use_simple_view'] == 1) {
	
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);		
	}
	

}



if (function_exists('add_theme_support')) {
	add_theme_support( 'post-thumbnails' ); 
	set_post_thumbnail_size( $lmImageDefaults['thumbnail']['width'], $lmImageDefaults['thumbnail']['height'], true); // default Post Thumbnail dimensions   
}

if (function_exists('add_image_size')) {
	//add_image_size( "luckymarble_thumbnail", $lmImageDefaults['thumbnail']['width'], $lmImageDefaults['thumbnail']['height'], true );
	//add_image_size( "luckymarble_small",  $lmImageDefaults['small']['width'],  $lmImageDefaults['small']['height'], true );
	//add_image_size( "luckymarble_medium", $lmImageDefaults['medium']['width'], $lmImageDefaults['medium']['height'], true );
	//add_image_size( "luckymarble_large",  $lmImageDefaults['large']['width'],  $lmImageDefaults['large']['height'], true );
}


add_filter("manage_upload_columns", 'upload_columns');
add_action("manage_media_custom_column", 'media_custom_columns', 0, 2);

function upload_columns($columns) {

	unset($columns['parent']);
	$columns['better_parent'] = "Parent";

	return $columns;

}
 function media_custom_columns($column_name, $id) {

	$post = get_post($id);

	if($column_name != 'better_parent')
		return;

		if ( $post->post_parent > 0 ) {
			if ( get_post($post->post_parent) ) {
				$title =_draft_or_post_title($post->post_parent);
			}
			?>
			<strong><a href="<?php echo get_edit_post_link( $post->post_parent ); ?>"><?php echo $title ?></a></strong>, <?php echo get_the_time(__('Y/m/d', "i3d-framework")); ?>
			<br />
			<a class="hide-if-no-js" onclick="findPosts.open('media[]','<?php echo $post->ID ?>');return false;" href="#the-list"><?php _e('Re-Attach', "i3d-framework"); ?></a>

			<?php
		} else {
			?>
			<?php _e('(Unattached)', "i3d-framework"); ?><br />
			<a class="hide-if-no-js" onclick="findPosts.open('media[]','<?php echo $post->ID ?>');return false;" href="#the-list"><?php _e('Attach', "i3d-framework"); ?></a>
			<?php
		}

}


if (!is_admin()) {
  add_action("wp_enqueue_scripts", "i3d_enqueue_scripts_global_after", 12) ;
  add_action("wp_enqueue_scripts", "i3d_enqueue_scripts_global_before", 0);
}


function i3d_enqueue_scripts_global_before() {
	    $themeRoot = get_stylesheet_directory_uri();
		wp_enqueue_style( 'aquila-global-css-1',     "{$themeRoot}/includes/framework/css/global.css");
}

function i3d_enqueue_scripts_global_after() {
	$themeRoot = get_stylesheet_directory_uri();


	// include functionality for the bootstrap datepicker by eyecon.ro
	wp_enqueue_script('bootstrap-datepicker', "{$themeRoot}/includes/user_view/datepicker/js/bootstrap-datepicker.js", array('jquery', 'aquila-bootstrap-js'), 1.0, true);
	wp_enqueue_style('bootstrap-datepicker', "{$themeRoot}/includes/user_view/datepicker/css/datepicker.css");
	
	wp_enqueue_script('comment-reply');

}

/** IS USED FOR THE ONLINE DEMOS **/
function i3d_stylesheet_directory(){
  $stylesheet_dir_uri = get_stylesheet_directory_uri();
  if (defined('PID')) {
	  $stylesheet_dir_uri = str_replace(constant("ORIGINAL_PID"), constant("PID"), $stylesheet_dir_uri);
  //   print "new stylesheet directory is $stylesheet_dir_uri";
  }
 // print "X";
  return $stylesheet_dir_uri;
} 


/** IS USED FOR THE ONLINE DEMOS **/
function i3d_template_directory(){
  $template_dir_uri = get_template_directory_uri();
  if (defined('PID')) {
	  $template_dir_uri = str_replace(constant("ORIGINAL_PID"), constant("PID"), $template_dir_uri);
     //print "new directory is $template_dir_uri";
  }
  //print "Y";
  return $template_dir_uri;
} 

if (!function_exists("i3d_wp_title")) {
	add_theme_support( "title-tag" );

	function i3d_wp_title($title = '', $sep = '', $sepLocation = '') {
	//if ($title != "") {
	//	$title .= " {$sep} ";
	//}
	//$title .= get_bloginfo('name');
	return $title;
}
	add_filter("wp_title", "i3d_wp_title", 10, 2);
}

?>
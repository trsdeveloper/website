<?php
/************************************************** TEAM MEMBERS **************************************************/

if (!function_exists("display_team_member_meta_box")) { 

		  $supports = array( 'title', 'editor', 'thumbnail', 'excerpt');	

		register_post_type( 'i3d-team-member',
			array(
				'labels' => array(
					'name' => 'Team Members',
					'singular_name' => 'Team Member',
					'add_new' => 'Add New',
					'add_new_item' => 'Add Team Member',
					'edit' => 'Edit',
					'edit_item' => 'Edit Team Member',
					'new_item' => 'New Team Member',
					'view' => 'View',
					'view_item' => 'View Team Member',
					'search_items' => 'Search Team Members',
					'not_found' => 'No Team Members Found',
					'not_found_in_trash' => 'No Team Members found in Trash',
					'parent' => 'Parent Team Member'
				),
				 'public' => true, 
				'menu_position' => 15,
				'supports' => $supports,
	
				'show_in_nav_menus' => false,
				'show_in_menu' => false,
							
				'menu_icon' => null,
				'has_archive' => true,
	
	
				'taxonomies' => array( 'i3d-team-member-department' ),
				'rewrite' => array('slug' => 'team-member')
							
			)
		);

		register_taxonomy("i3d-team-member-department", "i3d-team-member", 
						  array("hierarchial" => false, 
								"labels" => array('name' => _x("Team Member Departments", "Team Member Departments", "i3d-framework"),
												  'signular_name' => _x("Team Member Department", "Team Member Departments", "i3d-framework"),
												  'search_items' => __("Search Departments", "Search Departments", "i3d-framework"),
												  'all_items' => __("All Departments", "All Departments", "i3d-framework"),
												  'parent_item' => __("Parent Department", "Parent Department", "i3d-framework"),
												  'parent_item_colon' => __("Parent Department:", "Parent Department", "i3d-framework"),
												  'edit_item' => __("Edit Department", "Edit Department", "i3d-framework"),
												  'update_item' => __("Update Department", "Update Department", "i3d-framework"),
												  "add_new_item" => __("Add New Department", "Add New Department", "i3d-framework"),
												  "new_item_name" => __("New Department Name", "New Department Name", "i3d-framework"),
												  "menu_name" => __("FAQ Departments", "FAQ Departments", "i3d-framework")
												  ),
								"query_var" => true, 
								"rewrite" => array("slug" => "team-member-department")
								));
function display_team_member_meta_box( $team_member ) {
    // Retrieve team member data and contact details based on team member ID
    $teamMemberData = get_post_meta($team_member->ID, 'team_member_data', true);
    $teamMemberContactPoints = get_post_meta($team_member->ID, 'team_member_contact_points', true);
		
//		var_dump($teamMemberContactPoints);
    $number_of_data_fields    = 3;
	$number_of_contact_fields = 5;
		?>
		<div id="team-member-meta-box">
		<h4>Data Fields</h4>
		<p>You can use these fields to describe such things as "position", "title", "rank", "since", "grade", "division", "interests" or whatever you want to quantify into point form data.</p>
		<p>The very first item tends to be displayed below the persons name, and is often used for "position" or "title".</p>
	<table class='table table-striped'>
	  <tr>
	    <th style='width: 175px;'>Field Label</td>
		<th>Field Value</td>
      </tr>
	<?php for ($i = 0; $i < $number_of_data_fields; $i++) {
		if (!is_array(@$teamMemberData["$i"])) {
			$teamMemberData["$i"] = array();
		}
		?>
		<tr>
			<td><input placeholder='Label' class='form-control' type="text" name="team_member_data__<?php echo $i; ?>__label" value="<?php echo addslashes(@$teamMemberData["{$i}"]['label']); ?>" /></td>
			<td><input placeholder='Value' class='form-control' type="text" name="team_member_data__<?php echo $i; ?>__value" value="<?php echo addslashes(@$teamMemberData["{$i}"]['value']); ?>" /></td>
		</tr>
    <?php } ?>
    </table>

		<h4>Contact Fields</h4>
		<p>You can use these fields to allow visitors to contact this person via such methods as "email", "twitter", "facebook", "blog", or "google+".</p>
 <script>
 function updatePlaceholder(selectBox) {
 	var selectedValue = jQuery(selectBox).val(); 
	<?php $domainName = get_site_url();
	      $domainName = str_replace(array("http://", "www."), array("", ""), $domainName);
		  $domainName = array_shift(explode("/", $domainName));
		  ?>
    var placeholder = "";
	if (selectedValue == "email") {
		
		placeholder = "mailto:name@<?php echo $domainName; ?>";
	} else if (selectedValue == "twitter") {
		placeholder = "http://twitter.com/somename";
	
	} else if (selectedValue == "linkedin") {
		placeholder = "http://linkedin.com/in/somename";
	
	} else if (selectedValue == "facebook") {
		placeholder = "http://facebook.com/somename";
	
	} else if (selectedValue == "googleplus") {
		placeholder = "http://plus.google.com/238013856935435";
	} else if (selectedValue == "website") {
		placeholder = "http://somewebsite.com";
	
	} else if (selectedValue == "blog") {
	 
		placeholder = "<?php echo get_site_url(); ?>/author/somename";
		
	} else {
		placeholder = "";
	}
	
	if (placeholder != "") {
	
	placeholder = "<?php _e("Example", "", "i3d-framework"); ?>: " + placeholder;
	}
	
	var inputControlID = selectBox.id.replace("type", "value");
	jQuery("#" + inputControlID).attr("placeholder", placeholder);
	jQuery("#" + inputControlID).attr("title", placeholder);
 }
 </script>
 	<table class='table table-striped'>
	  <tr>
	    <th style='width: 175px;'>Contact Type</td>
<?php if (I3D_Framework::$isotopePortfolioVersion == 2 && sizeof(I3D_Framework::$teamMemberContactIconColors) > 0) { ?>
		<th style='width: 175px;'>Highlight Color</td>

<?php } ?>		
		<th>URL/Address</td>
      </tr>
	<?php for ($i = 0; $i < $number_of_contact_fields; $i++) {
		if (!is_array(@$teamMemberContactPoints["$i"])) {
			$teamMemberContactPoints["$i"] = array();
		}
		?>
		<tr>
			<td>
			
			  <select onchange='updatePlaceholder(this)' class='form-control' name="team_member_contact_points__<?php echo $i; ?>__type"  id="team_member_contact_points__<?php echo $i; ?>__type">
			    <option value=""><?php _e("-- Select Type --", "", "i3d-framework"); ?></option>
				<option <?php if (@$teamMemberContactPoints["{$i}"]["type"] == "email") { print "selected"; } ?> value="email">Email</option>
				<option <?php if (@$teamMemberContactPoints["{$i}"]["type"] == "twitter") { print "selected"; } ?> value="twitter">Twitter</option>
				<option <?php if (@$teamMemberContactPoints["{$i}"]["type"] == "linkedin") { print "selected"; } ?> value="linkedin">LinkedIn</option>
				<option <?php if (@$teamMemberContactPoints["{$i}"]["type"] == "facebook") { print "selected"; } ?> value="facebook">Facebook</option>
				<option <?php if (@$teamMemberContactPoints["{$i}"]["type"] == "googleplus") { print "selected"; } ?> value="googleplus">Google+</option>
				<option <?php if (@$teamMemberContactPoints["{$i}"]["type"] == "website") { print "selected"; } ?> value="website">Website Address</option>
				<option <?php if (@$teamMemberContactPoints["{$i}"]["type"] == "blog") { print "selected"; } ?> value="blog">Blog</option>
		      </select></td>
<?php if (I3D_Framework::$isotopePortfolioVersion == 2 && sizeof(I3D_Framework::$teamMemberContactIconColors) > 0) { ?>
			<td>
			  <select class='form-control' name="team_member_contact_points__<?php echo $i; ?>__color"  id="team_member_contact_points__<?php echo $i; ?>__color">
			    <option value=""><?php _e("-- Select Color --", "", "i3d-framework"); ?></option>
				<?php foreach (I3D_Framework::$teamMemberContactIconColors as $color => $colorValue) { ?>
				<option <?php if (@$teamMemberContactPoints["{$i}"]["color"] == $color) { print "selected"; } ?> value="<?php echo $color; ?>"><?php echo $colorValue; ?></option>
				<?php } ?>
		      </select></td>
<?php } ?>
			<td><input placeholder='Value' class='form-control' type="url" id="team_member_contact_points__<?php echo $i; ?>__value"  name="team_member_contact_points__<?php echo $i; ?>__value" value="<?php echo addslashes(@$teamMemberContactPoints["{$i}"]['value']); ?>" /></td>
		</tr>
		<script>
		updatePlaceholder(document.getElementById("team_member_contact_points__<?php echo $i; ?>__type"));
		</script>
    <?php } ?>
    </table>	

	</div>
    <?php
}

function i3d_team_member_admin() {
    add_meta_box( 'team_member_admin_meta_box',
        'Team Member Details',
        'display_team_member_meta_box',
        'i3d-team-member', 'normal', 'high'
    );
}

		add_action( 'admin_init', 'i3d_team_member_admin' );

function add_team_member_fields( $team_member_id, $team_member ) {
   
   // Check post type for movie reviews
    if ( $team_member->post_type == 'i3d-team-member' ) {
		// Store data in post meta table if present in post data
		$teamMemberContactPoints = array();
		$teamMemberData = array();
		foreach ($_POST as $key => $value) {
			$keyData = explode("__", $key);
			if ($keyData[0] == "team_member_contact_points") {
				$i = $keyData[1];
				$field = $keyData[2];
				$teamMemberContactPoints["$i"]["$field"] = $value;
			} else if ($keyData[0] == "team_member_data") {
				$i = $keyData[1];
				$field = $keyData[2];
				$teamMemberData["$i"]["$field"] = $value;				
			}
		}
		//var_dump($teamMemberData);
		update_post_meta( $team_member_id, 'team_member_data', 	$teamMemberData );
		update_post_meta( $team_member_id, 'team_member_contact_points', 	$teamMemberContactPoints );
		//exit;
	}
}
add_action( 'save_post', 'add_team_member_fields', 10, 2 );

function include_template_function_i3d_team_member( $template_path ) {
	global $pageTemplate;
    if ( get_post_type() == 'i3d-team-member' ) {
        if ( is_single() ) {
				if (!I3D_Framework::use_global_layout()) {
				//	print "not using global layout";
			   $theme_file = locate_template( array ( 'template-team-members.php' ));
              
               $template_path = $theme_file;
				}
        }
    } else {
	}
	//print "template path: $template_path";
    return $template_path;
}

add_filter( 'template_include', 'include_template_function_i3d_team_member', 1 );

function team_members_contextual_help( $contextual_help, $screen_id, $screen ) { 
	if (I3D_Framework::$supportType == "i3d") { 
		if ( 'edit-i3d-team-member' == $screen->id ) {
	
			$contextual_help = '<h2>Team Members</h2><iframe width="420" height="315" src="//www.youtube.com/embed/2fWUSe6h-Eo" frameborder="0" allowfullscreen></iframe>';
	
		} elseif ( 'i3d-team-member' == $screen->id ) {
	
			$contextual_help = '<h2>Team Members</h2><iframe width="420" height="315" src="//www.youtube.com/embed/2fWUSe6h-Eo" frameborder="0" allowfullscreen></iframe>';
	
		}
	}
	return $contextual_help;
}

add_action( 'contextual_help', 'team_members_contextual_help', 10, 3 );
}
?>
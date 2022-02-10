<?php
//print "yeah";
/***********************************/
/**        SIDEBAR REGION         **/
/***********************************/
class I3D_Widget_ContactPanel extends WP_Widget {
	function __construct() {
	//function I3D_Widget_ContactPanel() {
		$widget_ops = array('classname' => 'i3d_contact_panel', 'description' => __( 'This renders a contact panel that contain widgets.', "i3d-framework") );
		parent::__construct('i3d_contactpanel', __('i3d:Contact Panel', "i3d-framework"), $widget_ops);
	}

	function widget( $args, $instance ) {		
		extract( $args );
		
		i3d_render_contact_panel($instance);
		
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}
	function get_property($property, $instance, $defaults, $row_id, $widget_id, $layout_id = "" ) {
	
	}
	

	
	function layout_configuration_preview( $instance, $defaults, $row_id, $widget_id, $layout_id = "" ) {
		
	}
	
	function layout_configuration_form( $instance, $defaults, $row_id, $widget_id, $layout_id, $page_level = false ) {
	  $instance =  wp_parse_args( (array) $instance, array( 'sidebar' => '', 'box_style' => '*'   ) );
	  global $wp_registered_sidebars;
	  global $post;
	  
	  $layouts = get_option('i3d_layouts');
	  if ($page_level) {
		  $prefix = "__i3d_layouts__{$layout_id}__";
			$page_layouts 		= (array)get_post_meta($post->ID, "layouts", true);
			
			
			if (!array_key_exists($layout_id, $page_layouts)) {
				$page_layouts["{$layout_id}"] = array();
			}
			if (!array_key_exists($row_id, $page_layouts["{$layout_id}"])) {
				$page_layouts["{$layout_id}"]["{$row_id}"] = array();
			}
			if (!array_key_exists("configuration", $page_layouts["{$layout_id}"]["{$row_id}"])) {
				$page_layouts["{$layout_id}"]["{$row_id}"]["configuration"] = array();
			}
			if (!array_key_exists($widget_id, $page_layouts["{$layout_id}"]["{$row_id}"]["configuration"])) {
				$page_layouts["{$layout_id}"]["{$row_id}"]["configuration"]["$widget_id"] = array();
			}
				$page_layouts["{$layout_id}"]["{$row_id}"]["configuration"]["{$widget_id}"] =  wp_parse_args( (array) $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"], array( 'sidebar' => '', 'box_style' => '*'   ) );
	        	$box_style = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["box_style"];
			
			// if box_style == "*" then it whatever the layout default is
			if ($box_style == "*") {
			  $instance['box_style'] = "*";
			  
			  // if the box style is blank, then it means there is no box_style
			} else if ($box_style == "") {
				$instance['box_style'] = "";
			
			} else if ($box_style != "") {
			    $instance['box_style'] = $box_style;	
			}
			$layoutID = $layout_id;
	  } else {
		//  global $layoutID;
		  
		  $prefix = "";
		  
	  }
	//  print "layoutID: $layoutID";
      	  $layoutName = $layouts["{$layout_id}"]["title"];

	  ?>
	<div class="input-group tt2" title="Choose Sidebar" >
  		<span class="input-group-addon detailed-addon"><i class="fa fa-link fa-fw"></i> <span class='detailed-label'>Sidebar</span></span>

	  <select class='form-control  sidebar-select' rel="<?php echo @$defaults['sidebar']; ?>" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__sidebar">
	    <?php 
		// if there is no prefix, then this is the layout manager level
		if ($prefix == "") { 
			$selected_sidebar = $instance['sidebar'];

		?>
        <option value="" rel="<?php echo @$wp_registered_sidebars["{$defaults['sidebar']}"]["name"]; ?>">-- <?php _e("Layout Default", "i3d-framework"); ?> (<?php echo @$wp_registered_sidebars["{$defaults['sidebar']}"]["name"]; ?>) --</option>
		<?php 
		// else, if there is a prefix, then this is the page level configurations
		} else {

			$selected_sidebar = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["sidebar"];
			//print "<option>$layout_id</option>";
			//print "<option>$selected_sidebar</option>";
			//print "<option>$widget_id</option>";
			?>
        <option value="" rel="something"><?php _e("-- Layout Default --", "i3d-framework"); ?></option>

		<?php } ?>
<?php
//var_dump($wp_registered_sidebars);
foreach ($wp_registered_sidebars as $sidebar_id => $sidebar) {
  	$option = '<option rel="'.addslashes($sidebar['name']).'" ';
		if ($sidebar_id == $selected_sidebar) { 
		  $option .= 'selected ';
		}
		$option .= 'value="'.$sidebar_id.'">';
	$option .= $sidebar['name'];
	$option .= '</option>';
	echo $option;
}
    ?>
                </select> 

				</div>


			<?php if (sizeof(I3D_Framework::$boxStyles) > 0 && false) { ?>
				<div class="input-group  tt2"  title='Choose Sidebar Box Style'>
  		<span class="input-group-addon detailed-addon"><i class="fa fa-paint-brush fa-fw"></i> <span class='detailed-label'>Box Style</span></span>

        	<!--<label class='label-100' for="<?php echo $this->get_field_id('box_style'); ?>"><?php _e('Box Style:', "i3d-framework"); ?></label>-->
			<select class='form-control' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__box_style">
        		<option <?php if ($instance['box_style'] == "*") { print "selected"; } ?> value="*"><?php echo $layoutName; ?> <?php _e("Layout Default", "i3d-framework"); ?></option>
				
				<?php foreach (I3D_Framework::$boxStyles as $className => $boxStyle) { ?>
				<option <?php if (@$instance['box_style'] == $className) { print "selected"; } ?> value="<?php echo $className; ?>"><?php echo $boxStyle; ?></option>
        		<?php } ?>
			</select> 
			</div>
			<?php }  ?>
					  <p class='small'>To edit the widgets for this sidebar, go to the <b>Appearance</b> <i class='fa fa-angle-right'></i> <b>Widgets</b> panel, after saving this page.</p>
	  <?php
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		global $wp_registered_sidebars;
		//var_dump($wp_registered_sidebars);
?>
<div class='i3d-widget-container'>

    </div>
<div class='i3d-widget-main-large'>
	<p>The "Sidebar" setting, below, can be very powerful.  Specifying this setting will import a sidebar into this region.</p>
		
        <label class='label-100' for="<?php echo $this->get_field_id('page'); ?>"><?php _e('Sidebar:', "i3d-framework"); ?></label>
		
        <select id="<?php echo $this->get_field_id('sidebar'); ?>" name="<?php echo $this->get_field_name('sidebar'); ?>">
        <option value=""><?php _e("-- Not Set --", "i3d-framework"); ?></option>
<?php
foreach ($wp_registered_sidebars as $sidebar) {
  	$option = '<option ';
		if (@$pagg->ID == $instance['sidebar']) { 
		  $option .= 'selected ';
		}
		$option .= 'value="'.$pagg->ID.'">';
	$option .= $pagg->post_title;
	$option .= '</option>';
	echo $option;
}
    ?>
                </select> 
      
        
        
</div>
<?php
	}
}


?>
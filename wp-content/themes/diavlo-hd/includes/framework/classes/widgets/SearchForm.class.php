<?php

/***********************************/
/**        HTML WIDGET BOX        **/
/***********************************/
class I3D_Widget_SearchForm extends WP_Widget {
	function __construct() {
	//function I3D_Widget_SearchForm() {
		$widget_ops = array('classname' => 'widget_text widget-i3d-google-search', 'description' => __( 'Renders a Search Form', "i3d-framework") );
		parent::__construct('i3d_search_form', __('i3d:Search Form', "i3d-framework"), $widget_ops);
	}

	function widget( $args, $instance ) {		
		extract( $args );
		global $settingOptions;
	//	var_dump($instance);
		if (@$instance['status'] == "enabled") { 

		} else if (@$instance['status'] == "disabled") { 
		?>
		<div id="search-box-removed"></div>
		<script>
		jQuery("#search-box-removed").parents(".logo-menu-search").removeClass("logo-menu-search");
		</script>
		<?php
		  return;
		} else if (@$instance['status'] == "*" && @$settingOptions['use_search_box'] == "0") { 
		?>
		<div id="search-box-removed"></div>
		<script>
		jQuery("#search-box-removed").parents(".logo-menu-search").removeClass("logo-menu-search");
		</script>
		<?php
		  return;

		} else if (@$instance['status'] == "x") {
			return;
		
		} else {
		  
		  if (@$settingOptions['use_search_box'] == "0") {
		?>
		<div id="search-box-removed"></div>
		<script>
		jQuery("#search-box-removed").parents(".logo-menu-search").removeClass("logo-menu-search");
		</script>
		<?php
		return;
		  }
		}
		if (I3D_Framework::$searchBoxVersion != "7") { // in version 7, the google-search class is used in the wrapper as well, which when the master stylesheet positions the box, pushes the box too low.
		  $before_widget = str_replace("i3d-opt-box-style", "google-search", $before_widget);
		}
		  echo $before_widget;
		 $justification = @$instance['justification'];
		  echo "<div class='i3d-wp-search-form google-search";
		  if ($justification == "right") {
			  echo " pull-right text-right";
		  } else if ($justification == "center") {
			  echo " text-center";
		  } else {
			  echo " text-left";
		  }
		  echo "'";
		  echo ">";
		//print "vA";
		  if (I3D_Framework::$searchBoxVersion == "2") { ?>
<form method="get" class="gsc-search-box gsc-search-box-tools" ><table class="gsc-search-box">
<tbody><tr><td class="gsc-input"><div class="gsc-input-box " id="gsc-iw-id1">
<table style="width: 100%; padding: 0px;" id="gs_id50" class="gstl_50 ">
<tbody><tr><td id="gs_tti50" class="gsib_a">
<input type="text" autocomplete="off" size="10" class="gsc-input" name="s" title="Search" style="width: 100%; padding: 0px; border: medium none; margin: 0px; height: auto; outline: medium none;" id="gsc-i-id1" dir="ltr"></td>
<td class="gsib_b"><div class="gsst_b" id="gs_st50" dir="ltr"><a class="gsst_a" href="javascript:void(0)" style="display: none;"><span class="gscb_a" id="gs_cb50"></span></a></div>
</td></tr></tbody></table></div></td><td class="gsc-search-button">
<input type="image" src="//www.google.com/uds/css/v2/search_box_icon.png" class="gsc-search-button gsc-search-button-v2" title="search"></td>
<td class="gsc-clear-button"><div class="gsc-clear-button" title="clear results">&nbsp;</div></td></tr></tbody>
</table></form>          
		 <?php } else if (I3D_Framework::$searchBoxVersion == "3") { ?>
<form method="get"  class="gsc-search-box gsc-search-box-tools" ><table class="gsc-search-box">
<tbody><tr><td class="gsc-input"><div class="gsc-input-box " id="gsc-iw-id1">
<table style="width: 100%; padding: 0px;" id="gs_id50" class="gstl_50 ">
<tbody><tr><td id="gs_tti50" class="gsib_a">
<input type="text" autocomplete="off" size="10" class="gsc-input" name="s" title="Search" style="width: 100%; padding: 0px; border: medium none; margin: 0px; height: auto; outline: medium none;" id="gsc-i-id1" dir="ltr"></td>
<td class="gsib_b"><div class="gsst_b" id="gs_st50" dir="ltr"><a class="gsst_a" href="javascript:void(0)" style="display: none;"><span class="gscb_a" id="gs_cb50"></span></a></div>
</td></tr></tbody></table></div></td><td class="gsc-search-button">
<button type='submit' class='btn btn-default btn-circle'><i class='fa fa-search'></i></button></td>
<td class="gsc-clear-button"><div class="gsc-clear-button" title="clear results">&nbsp;</div></td></tr></tbody>
</table></form>  
		 <?php } else if (I3D_Framework::$searchBoxVersion == "4") { ?>
         <div class='google-search-wrapper'>
			<div id="___gcse_0">
            	<div class="gsc-control-cse gsc-control-cse-en">
                	<div class="gsc-control-wrapper-cse" dir="ltr">         
<form method="get"  class="gsc-search-box gsc-search-box-tools" ><table class="gsc-search-box">
<tbody><tr><td class="gsc-input"><div class="gsc-input-box " id="gsc-iw-id1">
<table style="width: 100%; padding: 0px;" id="gs_id50" class="gstl_50 ">
<tbody><tr><td id="gs_tti50" class="gsib_a">
<input type="text" autocomplete="off" size="10" class="gsc-input" name="s" title="Search" style="width: 100%; padding: 0px; border: medium none; margin: 0px; height: auto; outline: medium none;" id="gsc-i-id1" dir="ltr"></td>
<td class="gsib_b"><div class="gsst_b" id="gs_st50" dir="ltr"><a class="gsst_a" href="javascript:void(0)" style="display: none;"><span class="gscb_a" id="gs_cb50"></span></a></div>
</td></tr></tbody></table></div></td><td class="gsc-search-button">
<button type='submit' class='btn btn-default btn-circle'><i class='fa fa-search'></i></button></td>
<td class="gsc-clear-button"><div class="gsc-clear-button" title="clear results">&nbsp;</div></td></tr></tbody>
</table></form>  
</div></div></div>  
</div>
		 <?php } else if (I3D_Framework::$searchBoxVersion == "5") { ?>
         <div class='google-search-wrapper'>
			<div id="___gcse_0">
            	<div class="gsc-control-cse gsc-control-cse-en">
                	<div class="gsc-control-wrapper-cse" dir="ltr">         
<form method="get" class="gsc-search-box gsc-search-box-tools" ><table class="gsc-search-box">
<tbody><tr><td class="gsc-input"><div class="gsc-input-box " id="gsc-iw-id1">
<table style="width: 100%; padding: 0px;" id="gs_id50" class="gstl_50 ">
<tbody><tr><td id="gs_tti50" class="gsib_a">
<input type="text" autocomplete="off" size="10" class="gsc-input" name="s"  title="Search" style="width: 100%; padding: 0px; border: medium none; margin: 0px; height: auto; outline: medium none;" id="gsc-i-id1" dir="ltr"></td>
<td class="gsib_b"><div class="gsst_b" id="gs_st50" dir="ltr"><a class="gsst_a" href="javascript:void(0)" style="display: none;"><span class="gscb_a" id="gs_cb50"></span></a></div>
</td></tr></tbody></table></div></td><td class="gsc-search-button">
<button type='submit' class="gsc-search-button gsc-search-button-v2"><i class='fa fa-search'></i></button></td>
<td class="gsc-clear-button"><div class="gsc-clear-button" title="clear results">&nbsp;</div></td></tr></tbody>
</table></form>  
</div></div></div>  
</div>
 		 <?php } else if (I3D_Framework::$searchBoxVersion == "6" || I3D_Framework::$searchBoxVersion == "7" ) { ?>
         <div class='google-search-wrapper'>
			<div id="___gcse_0">
            	<div class="gsc-control-cse gsc-control-cse-en">
                	<div class="gsc-control-wrapper-cse" dir="ltr">         
<form method="get" class="gsc-search-box gsc-search-box-tools" ><table class="gsc-search-box">
<tbody><tr><td class="gsc-input"><div class="gsc-input-box " id="gsc-iw-id1">
<table style="width: 100%; padding: 0px;" id="gs_id50" class="gstl_50 ">
<tbody><tr><td id="gs_tti50" class="gsib_a">
<input type="text" autocomplete="off" size="10" class="gsc-input" name="s"  title="Search" style="width: 100%; padding: 0px; border: medium none; margin: 0px; height: auto; outline: medium none;" id="gsc-i-id1" dir="ltr"></td>
<td class="gsib_b"><div class="gsst_b" id="gs_st50" dir="ltr"><a class="gsst_a" href="javascript:void(0)" style="display: none;"><span class="gscb_a" id="gs_cb50"></span></a></div>
</td></tr></tbody></table></div></td><td class="gsc-search-button">
<?php if ($instance['use_icon'] != "0") { ?>
<input type="image" src="https://www.google.com/uds/css/v2/search_box_icon.png" class="gsc-search-button gsc-search-button-v2" title="search">
<?php } ?></td>
<td class="gsc-clear-button"><div class="gsc-clear-button" title="clear results">&nbsp;</div></td></tr></tbody>
</table></form>  
</div></div></div>  
</div>
             
          <?php } else { ?>        
<form role="search" method="get" id="searchform" action="/" >
<input  name="s" type="text" /> <button class="btn btn-primary" onclick='this.form.submit();'><?php 
if ($instance['use_icon'] == "1") {
	?><i class='icon-search'></i> <?php 
} 
echo $instance['title']?></button>
</form>
         <?php } ?>
</div>
        <?php
        
		echo $after_widget;
	}
	public static function getPageInstance($pageID, $defaults = array()) {
		$instance        = $defaults;
		$new_instance    = array();
		$generalSettings = get_option('i3d_general_settings');
        
		$instance['status'] 			= get_post_meta($pageID, "i3d_search_form", true);
		//var_dump($instance);
		

		return $instance;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['title'])));
        $instance['use_icon'] = $new_instance['use_icon'];
        $instance['justification'] = $new_instance['justification'];
		return $instance;
	}
	function layout_configuration_form( $instance, $defaults, $row_id, $widget_id, $layout_id, $page_level = false ) {
	  $instance =  wp_parse_args( (array) $instance, array( 'title' => '', 'justification' => 'left', 'use_icon' => '', 'status' => '*'  ) );
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
			$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"] =  wp_parse_args( (array) $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"], array( 'sidebar' => '', 'box_style' => '*'   ) );
	        $box_style = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["box_style"];
	        
			$justification	 = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["justification"];
			$title = format_to_edit(@$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["title"]);
			$use_icon = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["use_icon"];
			$enabled = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["status"];

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
			$justification = strip_tags($instance['justification']);
		  	$title = format_to_edit($instance['title']);
		  	$use_icon = $instance['use_icon'];
		  	$enabled = $instance['status'];

	  }
	//  print "layoutID: $layoutID";
    
	  $layoutName = $layouts["{$layout_id}"]["title"];

if (I3D_Framework::$searchBoxVersion < 2) { 
?>
	<div class="input-group">
  		<span class="input-group-addon detailed-addon"><i class="fa fa-eye fa-fw"></i> <span class='detailed-label'>Enabled</span></span>
	  <select class='form-control tt2' title="Enabled" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__status">
          <option <?php if ($enabled == "*") { print "selected"; } ?> value="*"><?php _e('Default',"i3d-framework"); ?></option>
          <option <?php if ($enabled == "enabled") { print "selected"; } ?> value="enabled"><?php _e('Enabled',"i3d-framework"); ?></option>
          <option <?php if ($enabled == "disabled") { print "disabled"; } ?> value="disabled"><?php _e('Disabled',"i3d-framework"); ?></option>
	  </select>
	</div>

        		<div class="input-group">
  		<span class="input-group-addon detailed-addon"><i class="fa fa-font fa-fw"></i> 
				<span class='detailed-label'><?php _e('Button Label',"i3d-framework"); ?></span></span>
                <input class="form-control tt2 layout-form-control-text" title="Button Label" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__title" type="text" value="<?php echo esc_attr($title); ?>" /></div>

        		<div class="input-group">
  		<span class="input-group-addon detailed-addon"><i class="fa fa-search fa-fw"></i> 
				<span class='detailed-label'><?php _e('Use Icon',"i3d-framework"); ?></span></span>
	  <select class='form-control tt2' title="Use Icon" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__use_icon">
		 <?php if ($prefix != "") { ?>
				  <option <?php if ($justification == "default") { print "selected"; } ?> value="default"><?php _e('Default',"i3d-framework"); ?></option>
		 <?php } ?>
				
          <option <?php if ($use_icon == "") { print "selected"; } ?> value=""><?php _e('Use Icon',"i3d-framework"); ?></option>
          <option <?php if ($use_icon == "disabled") { print "selected"; } ?> value="disabled"><?php _e('No Icon',"i3d-framework"); ?></option>
	  </select>
    </div>


	<div class="input-group">
  		<span class="input-group-addon detailed-addon"><i class="fa fa-align-left fa-fw"></i> <span class='detailed-label'>Alignment</span></span>
	  <select class='form-control tt2' title="Justification" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__justification">
 <?php if ($prefix != "") { ?>
          <option <?php if ($justification == "default") { print "selected"; } ?> value="default"><?php _e('Default',"i3d-framework"); ?></option>
 <?php } ?>
          <option <?php if ($justification == "left") { print "selected"; } ?> value="left"><?php _e('Left',"i3d-framework"); ?></option>
          <option <?php if ($justification == "center") { print "selected"; } ?> value="center"><?php _e('Center',"i3d-framework"); ?></option>
     	  <option <?php if ($justification == "right") { print "selected"; } ?> value="right"><?php _e('Right',"i3d-framework"); ?></option>
	  </select>
	</div>
<?php } else { ?>
	<div class="input-group">
  		<span class="input-group-addon detailed-addon"><i class="fa fa-eye fa-fw"></i> <span class='detailed-label'>Enabled</span></span>
	  <select class='form-control tt2' title="Enabled" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__status">
          <option <?php if ($enabled == "*") { print "selected"; } ?> value="*"><?php _e('Default',"i3d-framework"); ?></option>
          <option <?php if ($enabled == "enabled") { print "selected"; } ?> value="enabled"><?php _e('Enabled',"i3d-framework"); ?></option>
          <option <?php if ($enabled == "disabled") { print "disabled"; } ?> value="disabled"><?php _e('Disabled',"i3d-framework"); ?></option>
	  </select>
	</div>
<?php } 
	}
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Search', 'use_icon' => '1' ) );
				$title = format_to_edit($instance['title']);
				$use_icon = $instance['use_icon'];
				$justification = @$instance['justification'];

		?>
        		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Button Label:',"i3d-framework"); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
    <p><input style='margin-top: 1px;' type='checkbox' id="<?php echo $this->get_field_id('use_icon'); ?>" name="<?php echo $this->get_field_name('use_icon'); ?>" value='1' <?php if ($use_icon == "1") { echo "checked"; } ?> /> <label for="<?php echo $this->get_field_id('use_icon'); ?>"><?php _e('Show Search Icon',"i3d-framework"); ?> <i class='icon-search'></i></label></p>

        <!-- justification -->
        
        <label class='label-90' for="<?php echo $this->get_field_id('justification'); ?>"><?php _e('Justification:',"i3d-framework"); ?></label>
		<select id="<?php echo $this->get_field_id('justification'); ?>" name="<?php echo $this->get_field_name('justification'); ?>">
          <option <?php if ($justification == "left") { print "selected"; } ?> value="left"><?php _e('Left',"i3d-framework"); ?></option>
          <option <?php if ($justification == "center") { print "selected"; } ?> value="center"><?php _e('Center',"i3d-framework"); ?></option>
     	  <option <?php if ($justification == "right") { print "selected"; } ?> value="right"><?php _e('Right',"i3d-framework"); ?></option>
        </select> 
        </p>

<?php


	}
}


?>
<?php

/***********************************/
/**        HTML WIDGET BOX        **/
/***********************************/
class I3D_Widget_ContentPanelGroup extends WP_Widget {
	protected static $pageWidgetCount = '0';
	
	function __construct() {
//	function I3D_Widget_ContentPanelGroup() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Displays a tab, pill, or content accordion menu controlled set of content regions.', "i3d-framework") );
		parent::__construct('i3d_cpg', __('i3d:Content Panel Group', "i3d-framework"), $widget_ops);
	}

    
	function widget( $args, $instance ) {
		self::$pageWidgetCount++;
		extract( $args );
		global $post;
		//print self::$pageWidgetCount;
						$before_widget = str_replace("i3d-opt-box-style", $instance['box_style'], $before_widget);

		echo $before_widget;
		
		$cpgID = $instance['id'];
		if ($cpgID != "") {
		//	print "yupx{$cpgID}";
			print do_shortcode("[i3d_cpg id={$cpgID}]");
		}
		
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['id'] = $new_instance['id'];
		$instance['box_style'] = $new_instance['box_style'];
		
		return $instance;
	}
	
	function layout_configuration_form( $instance, $defaults, $row_id, $widget_id, $layout_id, $page_level = false ) {
	  $instance =  wp_parse_args( (array) $instance, array( 'id' => '', 'box_style' => '') );
	  global $post;
	  global $i3dSupportedMenus;

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
			$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"] =  wp_parse_args( (array) @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"], array( 'id' => '', 'box_style' => '' ) );
	        
	        $box_style 	= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["box_style"];
	        $id 	= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["id"];

			// if box_style == "*" then it whatever the layout default is
			if ($id == "*") {
			  $instance['id'] = "*";
			  // if the box style is blank, then it means there is no box_style
			} else if ($id == "") {
				$instance['id'] = "";
			
			} else if ($id != "") {
			    $instance['id'] = $id;	
			}
			
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
       
		$cpgs = get_option("i3d_content_panel_groups");
		$adminPage = "admin.php?page=i3d_content_panels";
		if (!is_array($cpgs)) {
			?>
        <p><b>Note:</b> You have not yet created any "Content Panel Groups".  <a target="_blank" href="<?php echo $adminPage; ?>">Click here</a> to create one.</p>
        <?php } else { ?>
	<div class="input-group tt2" title="Choose Content Panel Group" >
  		<span class="input-group-addon detailed-addon"><i class="fa fa-folder-o fa-fw"></i> <span class='detailed-label'>Content Panel</span></span>

		<select class='form-control' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__id">
          <option  style='color: #cccccc;' value="">-- Choose Content Panel Group --</option>
	    <?php 
		// if there is no prefix, then this is the layout manager level
		if ($prefix == "") { 
			$selected_contact_box = $instance['id'];
            
		?>
		<?php 
		// else, if there is a prefix, then this is the page level configurations
		} else {

			$selected_contact_box = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["id"];
			//print "<option>$layout_id</option>";
			//print "<option>$selected_sidebar</option>";
			//print "<option>$widget_id</option>";
			?>
        <option value="*" ><?php _e("-- Layout Default --","i3d-framework"); ?></option>

		<?php } ?>

        <?php foreach ($cpgs as $id => $cpg) { ?>
          <option <?php if (@$instance['id'] == $id) { print "selected"; } ?> value="<?php echo $id; ?>"><?php echo $cpg['title']; ?></option>
        <?php } ?>
                </select> 
				</div>
				
				<?php if (sizeof(I3D_Framework::$boxStyles) > 0) { ?>
	<div class="input-group tt2" title="Choose Content Panel Group" >
  		<span class="input-group-addon detailed-addon"><i class="fa fa-paint-brush fa-fw"></i> <span class='detailed-label'>Box Style</span></span>
	<select class='form-control' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__box_style">
	<?php foreach (I3D_Framework::$boxStyles as $className => $boxStyle) { ?>
	  <option <?php if (@$instance['box_style'] == $className) { print "selected"; } ?> value="<?php echo $className; ?>"><?php echo $boxStyle; ?></option>
	<?php } ?>
			</select> 
			</div>
	<?php }  ?>
				
        <?php } ?>
	

		
 

        <?php
	}
	
	
	function form( $instance ) {
		?>
<div class='i3d-widget-container'>
    <div class='i3d-help-region'>
    <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://www.youtube.com/watch?v=l_SX5F1WSno"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>
<!--    <div class='i3d-help-region-opened i3d-help-region-hidden'>
    <div class='i3d-help-title-bar'>Hide</div>
<iframe width="420" height="315" src="//www.youtube.com/embed/l_SX5F1WSno" frameborder="0" allowfullscreen></iframe>
    </div>-->
    </div> 
<div class='i3d-widget-main-large'>

        <!-- justification -->
        <?php
		$cpgs = get_option("i3d_content_panel_groups");
		$adminPage = "admin.php?page=i3d_content_panels";
		if (!is_array($cpgs)) {
			?>
        <p><b>Note:</b> You have not yet created any "Content Panel Groups".  <a href="<?php echo $adminPage; ?>">Click here</a> to create one.</p>
        <?php } else { ?>
		<div class='widget-column-100'>
        <label class='label-regular' for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Content Panel',"i3d-framework"); ?></label>
		<select id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>">
          <option  style='color: #cccccc;' value="">-- Choose Content Panel Group --</option>
        <?php foreach ($cpgs as $id => $cpg) { ?>
          <option <?php if (@$instance['id'] == $id) { print "selected"; } ?> value="<?php echo $id; ?>"><?php echo $cpg['title']; ?></option>
        <?php } ?>
                </select> 
				</div>
				
				<?php if (sizeof(I3D_Framework::$boxStyles) > 0) { ?>
	<div class='widget-column-100'>
	<label class='label-regular' for="<?php echo $this->get_field_id('box_style'); ?>"><?php _e('Box Style',"i3d-framework"); ?></label>
	<select id="<?php echo $this->get_field_id('box_style'); ?>" name="<?php echo $this->get_field_name('box_style'); ?>">
	<?php foreach (I3D_Framework::$boxStyles as $className => $boxStyle) { ?>
	  <option <?php if (@$instance['box_style'] == $className) { print "selected"; } ?> value="<?php echo $className; ?>"><?php echo $boxStyle; ?></option>
	<?php } ?>
			</select> 
			</div>
	<?php }  ?>
				
        <?php } ?>
	

		
        </div>    
    
    </div>

        <?php
	}
}


?>
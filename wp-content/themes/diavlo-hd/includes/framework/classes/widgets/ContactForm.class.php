<?php

/***********************************/
/**        HTML WIDGET BOX        **/
/***********************************/
class I3D_Widget_ContactForm extends WP_Widget {
	function __construct() {
		//function I3D_Widget_ContactForm() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Render a contact form', "i3d-framework") );

		$control_ops = array();
		parent::__construct('i3d_contact_form', __('i3d:Contact Form', "i3d-framework"), $widget_ops, $control_ops);
	
	}

	function widget( $args, $instance ) {
		extract( $args );		
		//var_dump($instance);
		$before_widget = str_replace("i3d-opt-box-style", @$instance['box_style'], $before_widget);
		echo $before_widget;
		if (@$instance['form_id'] != "") {		
		// var_dump($instance);

		
		
			echo do_shortcode("[i3d_contact_form id={$instance['form_id']}]");
			
		}
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['form_id'] = $new_instance['form_id']; 
		$instance['box_style'] = $new_instance['box_style']; 
		return $instance;
	}


	function layout_configuration_form( $instance, $defaults, $row_id, $widget_id, $layout_id, $page_level = false ) {
	  $instance =  wp_parse_args( (array) $instance, array( 'form_id' => '*', 'box_style' => '*'  ) );
	  global $post;
	  
	//  var_dump($instance);
	//  var_dump($defaults);
	  
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

	        $box_style 	= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["box_style"];
	        $form_id 	= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["form_id"];

			// if box_style == "*" then it whatever the layout default is
			if ($form_id == "*") {
			  $instance['form_id'] = "*";
			  // if the box style is blank, then it means there is no box_style
			} else if ($form_id == "") {
				$instance['form_id'] = "";
			
			} else if ($form_id != "") {
			    $instance['form_id'] = $form_id;	
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
	//  print "layoutID: $layoutID";
      	//  $layoutName = $layouts["{$layout_id}"]["title"];
		$forms = get_option("i3d_contact_forms");
      	  $layoutName = $layouts["{$layout_id}"]["title"];
//var_dump($instance);
	  ?>
	<div class="input-group tt2" title="Choose Contact Form" >
  		<span class="input-group-addon detailed-addon"><i class="fa fa-envelope fa-fw"></i> <span class='detailed-label'>Contact Form</span></span>

	  <select class='form-control'  name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__form_id">
		<option  style='color: #cccccc;' value="">-- Choose Contact Form --</option>
	    <?php 
		// if there is no prefix, then this is the layout manager level
		if ($prefix == "") { 
			$selected_contact_box = $instance['form_id'];
            
		?>
		<?php 
		// else, if there is a prefix, then this is the page level configurations
		} else {

			$selected_contact_box = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["form_id"];
			//print "<option>$layout_id</option>";
			//print "<option>$selected_sidebar</option>";
			//print "<option>$widget_id</option>";
			?>
        <option value="*" ><?php _e("-- Layout Default --","i3d-framework"); ?></option>

		<?php } ?>
        <?php foreach ($forms as $id => $form) { ?>
          <option <?php if ($instance['form_id'] == $id) { print "selected"; } ?> value="<?php echo $id; ?>"><?php echo $form['form_title']; ?></option>
        <?php } ?>
		
		
                </select> 
				</div>
		
			<?php if (sizeof(I3D_Framework::$boxStyles) > 0) { ?>
				<div class="input-group  tt2"  title='Choose Sidebar Box Style'>
  		<span class="input-group-addon detailed-addon"><i class="fa fa-paint-brush fa-fw"></i> <span class='detailed-label'>Box Style</span></span>

        	<!--<label class='label-100' for="<?php echo $this->get_field_id('box_style'); ?>"><?php _e('Box Style:',"i3d-framework"); ?></label>-->
			<select class='form-control' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__box_style">
        		<?php if ($prefix != "") { ?>
				<option <?php if ($instance['box_style'] == "*") { print "selected"; } ?> value="*"><?php _e("-- Layout Default --","i3d-framework"); ?></option>
				<?php } ?>
				<?php foreach (I3D_Framework::$boxStyles as $className => $boxStyle) { ?>
				<option <?php if (@$instance['box_style'] == $className) { print "selected"; } ?> value="<?php echo $className; ?>"><?php echo $boxStyle; ?></option>
        		<?php } ?>
			</select> 
			</div>
			<?php }  
	  
	}


	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'form_id' => '', 'title' => '', 'text' => '', "box_style" => "" ) );
		$form_id = @$instance['form_id'];
		$forms = get_option("i3d_contact_forms");
?>
<script>

jQuery("a.widget-action").bind("click", function() {
		//		shrinkVideoRegion(this);									

});
 
jQuery("a.widget-control-close").bind("click", function() {
			//	shrinkVideoRegion(this);									

});
</script>
<div class='i3d-widget-container'>
    <div class='i3d-help-region'>
    <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://www.youtube.com/watch?v=t56xRHF5Mxc"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>

    </div>
<div class='i3d-widget-main-large'>

       
        
        <!-- justification -->
		<div class='widget-column-100'>
        <label class='label-regular' for="<?php echo $this->get_field_id('form_id'); ?>"><?php _e('Form',"i3d-framework"); ?></label>
		<select id="<?php echo $this->get_field_id('form_id'); ?>" name="<?php echo $this->get_field_name('form_id'); ?>">
          <option value="" disabled>-- Select Form --</option>
		<?php foreach ($forms as $formID => $formData) { ?>
          <option <?php if ($formID == $form_id) { print "selected"; } ?> value="<?php echo $formID; ?>"><?php echo $formData['form_title']; ?></option>
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
        </div>
        </div>        
<?php
	}
}


?>
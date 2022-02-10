<?php

/***********************************/
/**        CONTENT REGION         **/
/***********************************/
class I3D_Widget_SliderRegion extends WP_Widget {
	function __construct() {
	//function I3D_Widget_SliderRegion() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Renders the a slider, as defined on each page', "i3d-framework") );
		parent::__construct('i3d_slider_region', __('i3d:Slider Region', "i3d-framework"), $widget_ops);
	}

	function widget( $args, $instance ) {		
		extract( $args );
		global $post;
		global $pageID;
		global $page_id;
		$sliderID = get_post_meta($page_id, "i3d_page_slider", true);
		
		$generalSettings = get_option("i3d_general_settings", true);
		//var_dump($generalSettings);
		if (I3D_Framework::use_global_layout()) {
		
			$page_layouts 		= (array)get_post_meta($page_id, "layouts", true);
			$page_layout_id 	= get_post_meta($page_id, "selected_layout", true);
			$row_id = $instance['row_id'];
			$widget_id = $instance['widget_id'];
			
			if ($widget_id == "") {
			  $widget_id = "i3d_slider_region";
			}

		//print $page_layout_id;
		//print $row_id;
		//print $widget_id;
		
			$page_level_sidebar = @$page_layouts["$page_layout_id"]["$row_id"]["configuration"]["$widget_id"]["slider"];
			//var_dump($page_layouts["$page_layout_id"]["$row_id"]["configuration"]["$widget_id"]);
			if ($page_level_sidebar != "") {
				$sliderID = $page_level_sidebar;
			} else if (@$instance['slider'] != "") {
				
		  		$sliderID = $instance['slider'];
			} else {
				
				$sliderID = $generalSettings['default_slider'];
			}
		}
		//print $sliderID;
		//print $sliderID."v";
		if ($sliderID == "" || $sliderID == "x") {
			  return;
		}
		//echo $before_widget;
		
		//print "test [{$sliderID}]";
		//exit;
		//var_dump($instance);
		i3d_render_slider($sliderID, @$instance['styled_bg'] == 1);
		//echo $after_widget;
	}
	
	function layout_configuration_form( $instance, $defaults, $row_id, $widget_id, $layout_id, $page_level = false ) {
	 // $instance =  wp_parse_args( (array) $instance, array( 'slider' => '' ) );
	  global $post;
	  global $generalSettings;

	  $layouts = get_option('i3d_layouts');
	  if ($page_level) {
		  $prefix = "__i3d_layouts__{$layout_id}__";
			$page_layouts 		= (array)get_post_meta($post->ID, "layouts", true);

			$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"] =  wp_parse_args( (array) @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"], array( 'slider' => '' ) );
	        
			$slider = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["slider"];
			
			// if box_style == "*" then it whatever the layout default is
			if ($slider == "*") {
			  $instance['slider'] = "*";
			  
			  // if the box style is blank, then it means there is no box_style
			} else if ($slider == "") {
				
					$instance['slider'] = "";
			
			} else if ($slider != "") {
			    $instance['slider'] = $box_style;	
			}
			$layoutID = $layout_id;
	  } else {
		//  global $layoutID;
		  
		  $prefix = "";
		  
	  }
		if ($prefix == "") { 
			$selected_slider = @$instance['slider'];
			if ($selected_slider == "") {
				if (!@isset($instance['slider']) && @$defaults['slider'] != "") {
				//  print " existing ".$instance['slider'];	
				  $selected_slider = $defaults['slider'];
				} else {
				//print "selected_slider.".$selected_slider;
					$selected_slider = $generalSettings["default_slider"];
				}
			}
		} else {
			$selected_slider = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["slider"];		
			if ($selected_slider == "") {
				
				$selected_slider = $generalSettings["default_slider"];
			}
		}	
	//  print "layoutID: $layoutID";
      ?>
	<div class="input-group tt2 " title="Choose Slider" >
  		<span class="input-group-addon"><i class="fa fa-compass fa-fw"></i> <span class='detailed-label'>Slider</span></span>
	  <select class='form-control' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__slider">
	  <?php $this->display_slider_options($selected_slider, $page_level); ?>
	   
                </select> 
</div>
				<?php
	}
	
	
	function update( $new_instance, $old_instance ) {
		$instance['styled_bg'] = $new_instance['styled_bg']; 
		//print $instance['styled_bg']."c";
		//var_dump($instance);
		//exit; 
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'styled_bg' => '1' ) ); 
?>
        <script>

jQuery("a.widget-action").bind("click", function() {
				//shrinkVideoRegion(this);									

});
 
jQuery("a.widget-control-close").bind("click", function() {
				//shrinkVideoRegion(this);									

});
</script>

<div class='i3d-widget-container'>
    <div class='i3d-help-region'>
    <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://youtu.be/RmQKAht-dQ0"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>
   <!-- <div class='i3d-help-region-opened i3d-help-region-hidden'>
    <div class='i3d-help-title-bar'>Hide <i class='icon-chevron-right'></i></div>
<iframe width="420" height="315" src="//www.youtube.com/embed/PNa5Ixc7RII" frameborder="0" allowfullscreen></iframe>
    </div>-->
    </div>
<div class='i3d-widget-main-large'>

        <!-- justification -->
        
        <p><b>Note:</b> Not all sliders observe the <i>"Styled Background"</i> setting.  This is typically for the Amazing Slider, Nivo Slider, and Video Slider</p>
        <label class='label-regular' for="<?php echo $this->get_field_id('styled_bg'); ?>"><?php _e('Styled Background:',"i3d-framework"); ?></label>
		<select id="<?php echo $this->get_field_id('styled_bg'); ?>" name="<?php echo $this->get_field_name('styled_bg'); ?>">
          <option <?php if ($instance['styled_bg'] == "1") { print "selected"; } ?> value="1"><?php _e('If Available',"i3d-framework"); ?></option>
          <option <?php if ($instance['styled_bg'] == "0") { print "selected"; } ?> value="0"><?php _e('No',"i3d-framework"); ?></option>
        </select> 
        </p>
        </div></div>
        <?php
	}
	
	
function display_slider_options($currentValue, $pageLevel = false) {
	global $post;
	if ($pageLevel) { 
	echo '<option value="">-- Use Layout Default --</option>\n';
	} else {
	echo '<option value="">-- Use Site Default --</option>\n';
		
	}
	?>
    <option <?php if ($currentValue == "disabled") { print "selected"; } ?> value="disabled">-- Do Not Display Slider --</option>
    <?php
	
	$sliders = get_option('i3d_sliders');
	$i3dAvailableSliders = I3D_Framework::getSliders();
	//var_dump($i3dAvailableSliders);
	
	
	if(is_array($sliders) && !empty($sliders)){
		foreach($sliders as $sliderID => $slider){
			if (array_key_exists($slider['slider_type'], $i3dAvailableSliders)) {
				if($currentValue == $sliderID){
					echo "<option value='$sliderID' selected>{$slider['slider_title']} (".$i3dAvailableSliders[$slider['slider_type']]['title'].")</option>\n";
				} else{
					echo "<option value='$sliderID'>{$slider['slider_title']} (".$i3dAvailableSliders[$slider['slider_type']]['title'].")</option>\n";
				}
			}
		}
	}
}
	
}


?>
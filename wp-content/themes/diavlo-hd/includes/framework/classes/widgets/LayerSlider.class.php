<?php

/***********************************/
/**        PLACEHOLDER FOR LAYER SLIDER WIDGET **/
/***********************************/
// this is only used if the Layer Slider Plugin is not isntalled
class I3D_Widget_LayerSlider extends WP_Widget {
	function __construct() {
	//function I3D_Widget_LayerSlider() {
		$widget_ops = array('classname' => 'widget_text', 'description' => "" );
		parent::__construct('i3d_slider_region', __('i3d:Layer Slider Plugin', "i3d-framework"), $widget_ops);
	}

	function widget( $args, $instance ) {		
		echo "Layer Slider Plugin Not Yet Installed";
	}
	
	function layout_configuration_form( $instance, $defaults, $row_id, $widget_id, $layout_id, $page_level = false ) {
	  print "<p class='small'>Layer Slider Plugin Not Yet Installed.  Please install and activate the included Layer Slider plugin.</p>";
	}
	
	
	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function form( $instance ) {

	}


	
}


?>
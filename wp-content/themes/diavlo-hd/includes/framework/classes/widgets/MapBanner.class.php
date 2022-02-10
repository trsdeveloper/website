<?php

/***********************************/
/**        CONTENT REGION         **/
/***********************************/
class I3D_Widget_MapBanner extends WP_Widget {
	function __construct() {
	//function I3D_Widget_MapBanner() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Renders the map banner, as defined on a contact-us style page.', "i3d-framework") );
		parent::__construct('i3d_map_banner', __('i3d:Map Banner', "i3d-framework"), $widget_ops);
	}

	function widget( $args, $instance ) {		


		i3d_render_page_googlemap();
		

	}
	
	function layout_configuration_form( $instance, $defaults, $row_id, $widget_id, $layout_id, $page_level = false ) {
	?>
						  <p class='small'>The map settings for this component are modified by going the <b>Page</b> that is associated with this layout and choose the <b>Map</b> tab.</p>

	<?php
	}
	
	
	function update( $new_instance, $old_instance ) {

		return $new_instance;
	}

	function form( $instance ) {

	}
		
}


?>
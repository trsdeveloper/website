<?php

/***********************************/
/**        COLUMN BREAK        **/
/***********************************/
class I3D_Widget_RowBreak extends WP_Widget {
	function __construct() {
	//function I3D_Widget_RowBreak() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Creates a New Row', "i3d-framework") );
		parent::__construct('i3d_rowbreak', __('i3d:*Row Break', "i3d-framework"), $widget_ops);
	}

	function widget( $args, $instance ) {		
		extract( $args );
		echo $before_widget;
		
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		return $old_instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		?>
        
        <script>

</script><div class='i3d-widget-container'>

	<p style='margin-top: 10px; margin-bottom: 10px;'>A Row Break widget allows you to signify where you want a new row of widgets to begin.</p>
    </div>
    <?php


	}
}


?>
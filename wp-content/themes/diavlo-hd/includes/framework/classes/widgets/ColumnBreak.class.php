<?php

/***********************************/
/**        COLUMN BREAK        **/
/***********************************/
class I3D_Widget_ColumnBreak extends WP_Widget {
	function __construct() {
	//function I3D_Widget_ColumnBreak() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Creates a New Column', "i3d-framework") );
		parent::__construct('i3d_columnbreak', __('i3d:*Column Break', "i3d-framework"), $widget_ops);
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

jQuery("a.widget-action").bind("click", function() {
		//		shrinkVideoRegion(this);									

});
 
jQuery("a.widget-control-close").bind("click", function() {
			//	shrinkVideoRegion(this);									

});
</script><div class='i3d-widget-container'>
    <div class='i3d-help-region'>
    <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://www.youtube.com/watch?v=B_iWyMGvUv8"><i class='icon-youtube-play'></i> Watch Help Video &nbsp; <i  class='icon-external-link'></i></a></div></div>
   <!-- <div class='i3d-help-region-opened i3d-help-region-hidden'>
    <div class='i3d-help-title-bar'>Hide</div>
<iframe width="420" height="315" src="//www.youtube.com/embed/B_iWyMGvUv8" frameborder="0" allowfullscreen></iframe>
    </div>-->
    </div> 
	<p style='margin-top: 10px; margin-bottom: 10px;'>A Column Break widget allows you to signify where you want a new column of widgets to begin.</p>
    </div>
    <?php


	}
}


?>
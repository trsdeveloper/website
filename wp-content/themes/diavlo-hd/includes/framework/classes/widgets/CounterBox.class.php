<?php

/***********************************/
/**        HTML WIDGET BOX        **/
/***********************************/
class I3D_Widget_CounterBox extends WP_Widget {
	function __construct() {
	//function I3D_Widget_CounterBox() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Render a Counter Box.', "i3d-framework") );
		$control_ops = array();
		parent::__construct('i3d_counterbox', __('i3d:Counter Box', "i3d-framework"), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		wp_enqueue_script( 'aquila-appear-js');
		wp_enqueue_script( 'aquila-countTo-js');

		$instance = wp_parse_args( (array) $instance, array('count' => '',
															'title' => '',
															
															'vector_icon' => '',
															 ) );
		
		//$before_widget = str_replace("i3d-opt-box-style", $instance['box_style'], $before_widget);
	
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
		//$subtitle = apply_filters( 'widget_title', empty($instance['subtitle']) ? '' : $instance['subtitle'], $instance );
		//$title = I3D_Framework::conditionFontAwesomeIcon($instance['title']);
		//$instance['text'] = str_replace("[themeroot]", get_stylesheet_directory_uri(), $instance['text']);
		//$text = apply_filters( 'widget_text', $instance['text'], $instance );
		
		//$justification = $instance['justification'];
		echo $before_widget;
		echo "<div class='i3d-widget-counterbox counter1-info";

		  echo "'";
		  echo ">";
		  
		$iconCode = "";

		
		
			
			  $iconCode .= "<i class='";
			  if (strstr($instance['vector_icon'], "fa-")) {
				  $iconCode .= "fa ";
			  }
			  $iconCode .= $instance['vector_icon'];
			
			 
					 $iconCode .= " fa-fw fa-4x";  
			  
			
			  $iconCode .= "'></i> ";
	
		  	
		  
		?><div class="counter1-icon"><?php echo $iconCode; ?></div>
	<div class="counter1-num count appear-count" data-from="0" data-refresh-interval="50" data-speed="2000" data-to="<?php echo $instance['count']; ?>"></div>
	<?php 
		if ( !empty( $title ) ) { 
		
   
		    print "<p class='counter1-label'>";
			echo $title;
			echo "</p>";
		 } 
		 

                       
                        
           
		 
		 


	
		print "</div>";
		echo $after_widget."\n";
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array('count' => '',
															
															
															'vector_icon' => '',

															
															'title' => ''
															 ) );		
		
		$instance['title'] 					= stripslashes( wp_filter_post_kses( addslashes($new_instance['title'])));
		$instance['count'] 				= $new_instance['count'];

		$instance['vector_icon']  					= $new_instance['vector_icon']; 
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array('count' => '',
															'title' => '',
															
															'vector_icon' => '',
															 ) );
		$title = format_to_edit($instance['title']);
		$count = format_to_edit($instance['count']);
		$vector_icon = format_to_edit($instance['vector_icon']);

		$rand = rand();
?>


<div class='i3d-widget-container'>



	<div class='widget-section'>
	<label class='label-regular' for="<?php echo $this->get_field_id('icon'); ?>"><?php _e('Icon', "i3d-framework"); ?></label>
	<div style='display: inline-block; vertical-align: top;'>
		<div style='padding-left: 3px; font-size: 8px; margin-top: -8px;'><?php _e('icon', "i3d-framework"); ?></div>

	<?php I3D_Framework::renderFontAwesomeSelect($this->get_field_name('vector_icon'), @$instance['vector_icon'], false, __('-- No Icon --', "i3d-framework"), __('-- No Icon --', "i3d-framework"), ""); ?>
	</div>
	
	
	</div>
	
	<div class='widget-section'>
	<label class='label-regular' for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Count',"i3d-framework"); ?></label>
		<input style='width: 95%' id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="number" value="<?php echo esc_attr($count); ?>" />
	</div>
		
	<div class='widget-section'>
	<label class='label-regular' for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Heading',"i3d-framework"); ?></label>
		<input style='width: 95%' id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
	</div>
	
	


		

   
        </div>


<?php
	}
}


?>
<?php

/***********************************/
/**        HTML WIDGET BOX        **/
/***********************************/
class I3D_Widget_ProgressBar extends WP_Widget {
	function __construct() {
	//function I3D_Widget_ProgressBar() {
		$widget_ops = array('classname' => 'widget_text widget-i3d-progress-bar', 'description' => __( 'Renders a Progress Bar', "i3d-framework") );
		parent::__construct('i3d_progress_bar', __('i3d:Progress Bar', "i3d-framework"), $widget_ops);
	}

	function widget( $args, $instance ) {		
		extract( $args );
		global $settingOptions;

		
		 $before_widget = str_replace("i3d-opt-box-style", "i3d-progress-bar", $before_widget);
		 echo $before_widget;
		 $justification = @$instance['justification'];
		  echo "<div class='";
		  if ($justification == "right") {
			  echo " pull-right text-right";
		  } else if ($justification == "center") {
			  echo " text-center";
		  } else {
			  echo " text-left";
		  }
		  echo "'";
		  echo ">";
?>

 <!-- progress bar -->        
        <div class="progress">
            <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo @$instance['percentage']; ?>" class="progress-bar progress-bar-<?php echo @$instance['style']; ?> wow stretch<?php echo ucwords(@$instance['stretch']); ?>" data-wow-duration="<?php echo @$instance['duration']; ?>" data-wow-delay="<?php echo @$instance['delay']; ?>" role="progressbar" style="width: <?php echo @$instance['percentage']; ?>%">
                <span class="pb-left">
                    <?php echo @$instance['title']; ?>
                </span>
                <span class="pb-right">
                    <?php echo @$instance['percentage']; ?>%
                </span>
            </div>
        </div>
        <!-- progress bar -->
<?php
			echo '</div>';
        
        
		echo $after_widget;
	}

	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['title'])));
        $instance['percentage'] = $new_instance['percentage'];
        $instance['stretch'] = $new_instance['stretch'];
        $instance['delay'] = $new_instance['delay'];
        $instance['duration'] = $new_instance['duration'];
        $instance['style'] = $new_instance['style'];
		return $instance;
	}
	
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'percentage' => '100', 'duration' => '1.5s', 'delay' => '1.5s', 'stretch' => 'right', 'style' => 'themed' ) );
		$instance['title'] = format_to_edit($instance['title']);
		
		$delays = array ("0.25s", "0.5s", "0.75s", "1.0s", "1.25s", "1.50s", "1.75s", "2.0s", "2.25s", "2.50s", "2.75s");
		$durations = $delays;
		?>
		<div class='i3d-widget-container'>
			<div class='widget-section'>
				<label class='label-regular' for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Label',"i3d-framework"); ?></label>
				<input style='width: 95%'class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
			</div>
		
		<div class='widget-section'>
			<div class='widget-column-33'>
        	<label class='label-regular' for="<?php echo $this->get_field_id('percentage'); ?>"><?php _e('Percentage',"i3d-framework"); ?></label>
            <input style='width: 88%' min="0" max="100"  id="<?php echo $this->get_field_id('percentage'); ?>" name="<?php echo $this->get_field_name('percentage'); ?>" type="number" value="<?php echo esc_attr($instance['percentage']); ?>" />
			</div>
		
		<div class='widget-column-33'>	
        
		<label class='label-regular' for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Style',"i3d-framework"); ?></label>
           	  <select style='width: 100%' class='form-control'  name="<?php echo $this->get_field_name('style'); ?>">
          <option <?php if ($instance['style'] == "themed") { print "selected"; } ?> value="themed"><?php _e('Themed',"i3d-framework"); ?></option>
          <option <?php if ($instance['style'] == "primary") { print "selected"; } ?> value="primary"><?php _e('Primary',"i3d-framework"); ?></option>
          <option <?php if ($instance['style'] == "info") { print "selected"; } ?> value="info"><?php _e('Info',"i3d-framework"); ?></option>
          <option <?php if ($instance['style'] == "warning") { print "selected"; } ?> value="warning"><?php _e('Warning',"i3d-framework"); ?></option>
          <option <?php if ($instance['style'] == "danger") { print "selected"; } ?> value="danger"><?php _e('Danger',"i3d-framework"); ?></option>
          <option <?php if ($instance['style'] == "success") { print "selected"; } ?> value="success"><?php _e('Success',"i3d-framework"); ?></option>
	  </select>
		   
		   </div>

        <div class='widget-column-33'>
		<label class='label-regular' for="<?php echo $this->get_field_id('stretch'); ?>"><?php _e('Stretch',"i3d-framework"); ?></label>
           	  <select style='width: 100%'  class='form-control' name="<?php echo $this->get_field_name('stretch'); ?>">
          <option <?php if ($instance['stretch'] == "right") { print "selected"; } ?> value="right"><?php _e('Right',"i3d-framework"); ?></option>
	  </select>
		   
		   </div>
		   
		  </div>

		<div class='widget-section'>
			<div class='widget-column-50'>

		<label class='label-regular' for="<?php echo $this->get_field_id('stretch'); ?>"><?php _e('Delay',"i3d-framework"); ?></label>
           	  <select style='width: 100%' class='form-control' name="<?php echo $this->get_field_name('delay'); ?>">
			  <?php foreach ($delays as $delay) { ?>
          <option <?php if ($instance['delay'] == $delay) { print "selected"; } ?> value="<?php echo $delay; ?>"><?php echo $delay; ?></option>
		  <?php } ?>
	  </select>
	  </div>
		<div class='widget-column-50'>
		<label class='label-regular' for="<?php echo $this->get_field_id('stretch'); ?>"><?php _e('Duration',"i3d-framework"); ?></label>
           	  <select style='width: 100%' class='form-control' name="<?php echo $this->get_field_name('duration'); ?>">
			  <?php foreach ($durations as $duration) { ?>
          <option <?php if ($instance['duration'] == $duration) { print "selected"; } ?> value="<?php echo $duration; ?>"><?php echo $duration; ?></option>
		  <?php } ?>
	  </select>
		   
		   </div>
		   </div>		   
		</div>
<?php


	}
}


?>
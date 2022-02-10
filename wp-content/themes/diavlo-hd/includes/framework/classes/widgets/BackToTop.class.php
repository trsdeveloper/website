<?php

/***********************************/
/**        HTML WIDGET BOX        **/
/***********************************/
class I3D_Widget_BackToTop extends WP_Widget {
	//function I3D_Widget_BackToTop() {
	function __construct() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Render a back-to-top button', "i3d-framework") );
		$control_ops = array();
		parent::__construct('i3d_backtotop', __('i3d:Back-To-Top Button', "i3d-framework"), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
		$title = $instance['title'];
		$text = apply_filters( 'widget_text', $instance['text'], $instance );
		$justification = $instance['justification'];
		$style = $instance['style'];
		echo $before_widget;
		  echo "<div class='i3d-widget-backtotop";
		  if ($style == "light") {
			  echo " i3d-widget-backtotop-light";
		  } else if ($style == "dark") {
			  echo " i3d-widget-backtotop-dark";			  
		  } 
		  
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
			<span <?php 
			if ($style == 'btn') {
				echo "class='btn'";
			} else if ($style == 'btn-success') {
				echo "class='btn btn-success'";
				
			} else if ($style == 'btn-info') {
				echo "class='btn btn-info'";
				
			} ?>><?php echo $title; ?></span>
		<?php
		echo "</div>";
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = stripslashes( wp_filter_post_kses( $new_instance['title']));
		//$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
		$instance['style'] = $new_instance['style']; // wp_filter_post_kses() expects slashed
		$instance['justification'] = $new_instance['justification']; // wp_filter_post_kses() expects slashed
		//var_dump($instance);
		//exit;
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		$title = format_to_edit($instance['title']);
		$text = format_to_edit($instance['text']);
		$style = $instance['style'];
		$justification = $instance['justification'];
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Label:',"i3d-framework"); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>


        <p>
        <!-- justification -->
        <label for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Style:',"i3d-framework"); ?></label>
		<select id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>">
          <option <?php if ($style == "default") { print "selected"; } ?> value="default"><?php _e('Default',"i3d-framework"); ?></option>
          <option <?php if ($style == "light") { print "selected"; } ?> value="light"><?php _e('Light',"i3d-framework"); ?></option>
          <option <?php if ($style == "dark") { print "selected"; } ?> value="dark"><?php _e('Dark',"i3d-framework"); ?></option>
          <option <?php if ($style == "btn") { print "selected"; } ?> value="btn"><?php _e('Standard Button',"i3d-framework"); ?></option>
          <option <?php if ($style == "btn-success") { print "selected"; } ?> value="btn-success"><?php _e('Success Button',"i3d-framework"); ?></option>
          <option <?php if ($style == "btn-info") { print "selected"; } ?> value="btn-info"><?php _e('Info Button',"i3d-framework"); ?></option>
        </select> 
        </p>

        <p>
        
        <!-- justification -->
        <label for="<?php echo $this->get_field_id('justification'); ?>"><?php _e('Justification:',"i3d-framework"); ?></label>
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
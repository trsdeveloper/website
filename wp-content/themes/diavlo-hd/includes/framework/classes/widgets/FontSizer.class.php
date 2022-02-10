<?php

/***********************************/
/**        FONT SIZER WIDGET      **/
/***********************************/
class I3D_Widget_FontSizer extends WP_Widget {
	function __construct() {
	//function I3D_Widget_FontSizer() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Render a font sizer widget', "i3d-framework") );
		$control_ops = array();
		parent::__construct('i3d_fontsizer', __('i3d:Font Sizer', "i3d-framework"), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
		$title = $instance['title'];
		$text = apply_filters( 'widget_text', $instance['text'], $instance );
		$justification = $instance['justification'];
		$style = $instance['style'];
		echo $before_widget;
		  echo "<div class='i3d-widget-fontsizer";

		  
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
			<span><div class='i3d-fontsizer-button i3d-fontsizer-small i3d-fontsizer-selected'>A</div><div class='i3d-fontsizer-button i3d-fontsizer-medium'>A</div><div class='i3d-fontsizer-button i3d-fontsizer-large'>A</div></span>
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
	
<script>

jQuery("a.widget-action").bind("click", function() {
				shrinkVideoRegion(this);									

});
 
jQuery("a.widget-control-close").bind("click", function() {
				shrinkVideoRegion(this);									

});
</script>

<div class='i3d-widget-container'>
    <div class='i3d-help-region'>
    <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://www.youtube.com/watch?v=gxNEJqLBfII"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>
  <!--  <div class='i3d-help-region-opened i3d-help-region-hidden'>
    <div class='i3d-help-title-bar'>Hide <i class='icon-chevron-right'></i></div>
<iframe width="420" height="315" src="//www.youtube.com/embed/gxNEJqLBfII" frameborder="0" allowfullscreen></iframe>
    </div>-->
    </div>
<div class='i3d-widget-main'>

 

        <p>
        
        <!-- justification -->
        <label for="<?php echo $this->get_field_id('justification'); ?>"><?php _e('Justification:',"i3d-framework"); ?></label>
		<select id="<?php echo $this->get_field_id('justification'); ?>" name="<?php echo $this->get_field_name('justification'); ?>">
          <option <?php if ($justification == "left") { print "selected"; } ?> value="left"><?php _e('Left',"i3d-framework"); ?></option>
          <option <?php if ($justification == "center") { print "selected"; } ?> value="center"><?php _e('Center',"i3d-framework"); ?></option>
     	  <option <?php if ($justification == "right") { print "selected"; } ?> value="right"><?php _e('Right',"i3d-framework"); ?></option>
        </select> 
        </p>
        </div>
        </div>
<?php
	}
}


?>
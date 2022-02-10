<?php

/***********************************/
/**        HTML WIDGET BOX        **/
/***********************************/
class I3D_Widget_PhoneNumber extends WP_Widget {
	function __construct() {
	//function I3D_Widget_PhoneNumber() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Renders a phone number with phone icon.', "i3d-framework") );
		parent::__construct('i3d_phonenumber', __('i3d:Phone Number', "i3d-framework"), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		$instance = wp_parse_args( (array) $instance, array( 'title' => '','box_style' => '', 'text' => '', 'show_icon' => '', 'justification' => '', 'margin' => ''  ) );
		
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
		$text = apply_filters( 'widget_text', $instance['text'], $instance );
		$showIcon = $instance['show_icon'];
		$justification = $instance['justification'];
		$margin = $instance['margin'];


		if (I3D_Framework::use_global_layout()) {	
			global $page_id;
			$page_layouts 		= (array)get_post_meta($page_id, "layouts", true);
			
			$layout_id 	= get_post_meta($page_id, "selected_layout", true);
			$row_id 	= @$instance['row_id'];
			$widget_id 	= @$instance['widget_id'];


	        $l_showIcon 		= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["show_icon"];
	        $l_margin			= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["margin"];
	        $l_justification	= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["justification"];
	        $l_text			= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["text"];
			
			if ($l_showIcon != "default" && $l_showIcon != "") {
			  $showIcon = $l_showIcon;
			}
			if ($l_margin != "default" && $l_margin != "") {
			//  $margin = $l_margin;
			}
			if ($l_justification != "default" && $l_justification != "") {
			  $justification = $l_justification;
			}
			if ($l_text != "default"  && $l_text != "*" && $l_text != "") {
			  $text = $l_text;
			}
		}

		if ($text != "") {
		echo $before_widget;
		echo "<div ";
		if ($justification == "right") {
			echo "class='pull-right text-right phone'";
		} else if ($justification == "center") {
		    echo "class='text-center phone'";	
		} else {
			echo "class='phone text-left'";
		}
		  if ($margin != "") {
			  echo " style='margin: {$margin}'";
		  }
		
		
		echo ">";
		if ($showIcon == "" || $showIcon == "default") {
			
		}
		if ($showIcon == "1") { ?><i class='<?php echo I3D_Framework::conditionFontAwesomeIcon("icon-phone"); ?>'></i> <?php }
	    echo $text;
		echo "</div>";
		//var_dump($instance);
		echo $after_widget;
		}
	}


	function layout_configuration_form( $instance, $defaults, $row_id, $widget_id, $layout_id, $page_level = false ) {
		//var_dump($instance);
	  $defaults =  wp_parse_args( (array) $defaults, array( 'title' => '','box_style' => '', 'text' => '', 'show_icon' => '', 'justification' => '', 'margin' => ''  ) );
	  
	  $instance =  wp_parse_args( (array) $instance, array( 'title' => "", 'box_style' => '', 'text' => $defaults['text'], 'show_icon' => $defaults['show_icon'], 'justification' => $defaults['justification'], 'margin' => $defaults['margin'] ) );
	  global $post;
	  global $i3dTextLogoLines;

	  $layouts = get_option('i3d_layouts');
	  if ($page_level) {
		
		  $prefix = "__i3d_layouts__{$layout_id}__";
			$page_layouts 		= (array)get_post_meta($post->ID, "layouts", true);
			$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"] =  wp_parse_args( (array) @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"], array( 'text' => "*", 'show_icon' => '*', 'margin' => '*', 'justification' => '*' ) );
	        $text = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["text"];
	        $margin = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["margin"];
	        $show_icon = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["show_icon"];
	        $justification	 = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["justification"];
						
			//if ( !isset() ) { $font_awesome_icon = ""; } else { $font_awesome_icon = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]['vector_icon']; }
			$layoutID = $layout_id;
	  } else {
		//  global $layoutID;
		//  var_dump($instance);
		  $prefix = "";
		if ( !isset($instance['text']) )   { $text = "default"; } else { $text = $instance['text']; }
		if ( !isset($instance['show_icon']) )	{ $show_icon = "default"; } else { $show_icon = $instance['show_icon']; }
		if ( !isset($instance['vector_icon']) ) 	{ $font_awesome_icon = ""; } else { $font_awesome_icon = $instance['vector_icon']; }
		$margin = strip_tags($instance['margin']);

		$justification = strip_tags($instance['justification']);

	  }
	  $rand = rand();
	
      ?>


  
	<div class="input-group  tt2"  title="Phone Number" >
  		<span class="input-group-addon detailed-addon"><i class="fa fa-phone fa-fw"></i> <span class='detailed-label'>Phone Number</span></span>
	  <input type="text"  class='form-control'  name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__text" value="<?php echo esc_attr($text); ?>">
	</div>

	
	<div class="input-group  tt2" title="Show Icon">
  		<span class="input-group-addon detailed-addon"><i class="fa fa-eye fa-fw"></i> <span class='detailed-label'>Show Icon</span></span>
	  <select  class='form-control'  name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__show_icon">
 <?php if ($page_level) { ?>         <option <?php if ($show_icon == "" || $show_icon == "default")  { print "selected"; } ?> value="default"><?php _e('Default',"i3d-framework"); ?></option> <?php } ?>
           <option <?php if ($show_icon == "0") { print "selected"; } ?> value="0"><?php _e('Disabled',"i3d-framework"); ?></option>

     	  <option <?php if ($show_icon == "1")   { print "selected"; } ?> value="1"><?php _e('Show',"i3d-framework"); ?></option>
	  </select>
	</div>
	<?php if (!$page_level) { ?>
	<div class="input-group  tt2" title="Margin" >
  		<span class="input-group-addon detailed-addon"><i class="fa fa-arrows fa-fw"></i> <span class='detailed-label'>Margin</span></span>
	  <input type="text"  class='form-control'  name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__margin" value="<?php echo esc_attr($margin); ?>">
	</div>
	<?php } ?>

	<div class="input-group">
  		<span class="input-group-addon detailed-addon"><i class="fa fa-align-left fa-fw"></i> <span class='detailed-label'>Alignment</span></span>
	  <select class='form-control tt2' title="Justification" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__justification">
 <?php if ($prefix != "") { ?>
          <option <?php if ($justification == "default") { print "selected"; } ?> value="default"><?php _e('Default',"i3d-framework"); ?></option>
 
 <?php } ?>
          <option <?php if ($justification == "left") { print "selected"; } ?> value="left"><?php _e('Left',"i3d-framework"); ?></option>
          <option <?php if ($justification == "center") { print "selected"; } ?> value="center"><?php _e('Center',"i3d-framework"); ?></option>
     	  <option <?php if ($justification == "right") { print "selected"; } ?> value="right"><?php _e('Right',"i3d-framework"); ?></option>
	  </select>
	</div>

 	  
	  <?php
	}


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['justification'] = strip_tags($new_instance['justification']);
		$instance['text'] = strip_tags( $new_instance['text'] ); 
		$instance['show_icon'] = strip_tags( $new_instance['show_icon'] ); 
		$instance['margin'] = strip_tags( $new_instance['margin'] ); 
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'margin' => '', 'show_icon' => '1', 'justification' => 'left', 'text' => '' ) );
		$justification = strip_tags($instance['justification']);
		$text = strip_tags($instance['text']);
		$show_icon = $instance['show_icon'];
		$margin = strip_tags(@$instance['margin']);
?>
<script>

jQuery("a.widget-action").bind("click", function() {
				//shrinkVideoRegion(this);									

});
 
jQuery("a.widget-control-close").bind("click", function() {
			//	shrinkVideoRegion(this);									

});
</script>

<div class='i3d-widget-container'>
    <div class='i3d-help-region'>
    <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://www.youtube.com/watch?v=DGn5bE7vcY4"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>
   <!-- <div class='i3d-help-region-opened i3d-help-region-hidden'>
    <div class='i3d-help-title-bar'>Hide <i class='icon-chevron-right'></i></div>
<iframe width="420" height="315" src="//www.youtube.com/embed/DGn5bE7vcY4" frameborder="0" allowfullscreen></iframe>
    </div>-->
    </div>
<div class='i3d-widget-main-large'>
		<p><label class='label-135' for="<?php echo $this->get_field_id('show_icon'); ?>"><?php _e('Show Phone Icon:',"i3d-framework"); ?></label>
		<select  id="<?php echo $this->get_field_id('show_icon'); ?>" name="<?php echo $this->get_field_name('show_icon'); ?>">
          <option <?php if ($show_icon == "1") { print "selected"; } ?> value="1"><?php _e('Yes',"i3d-framework"); ?></option>
          <option <?php if ($show_icon == "0")  { print "selected"; } ?> value="0"><?php _e('No',"i3d-framework"); ?></option>
        </select> 
        </p>
<p>
<label class='label-135' for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Phone Number:',"i3d-framework"); ?></label>
		<input  id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo $text; ?>" /></p>
</p>

<p>
<label class='label-135' for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Margin:',"i3d-framework"); ?></label>
		<input  id="<?php echo $this->get_field_id('margin'); ?>" name="<?php echo $this->get_field_name('margin'); ?>" type="text" value="<?php echo $margin; ?>" /></p>
</p>
        <p>
        <!-- justification -->
        <label class='label-135' for="<?php echo $this->get_field_id('justification'); ?>"><?php _e('Justification:',"i3d-framework"); ?></label>
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
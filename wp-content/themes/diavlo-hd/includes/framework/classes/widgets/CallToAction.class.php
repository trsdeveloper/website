<?php

/***********************************/
/**        HTML WIDGET BOX        **/
/***********************************/
class I3D_Widget_CallToAction extends WP_Widget {
	protected static $pageWidgetCount = '0';
	
	function __construct() {
//	function I3D_Widget_CallToAction() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Animates text and buttons into a "Call To Action"', "i3d-framework") );
		parent::__construct('i3d_cta', __('i3d:Call To Action', "i3d-framework"), $widget_ops);
	}

    
	function widget( $args, $instance ) {
		self::$pageWidgetCount++;
		extract( $args );
		global $post;
		//print self::$pageWidgetCount;
		$instance = wp_parse_args( (array) $instance, array( 'is_short_tag' => '','id' => '', 'default_call_to_action_id' => '') );
	
		echo $before_widget;
		
	//	var_dump($instance);
			$ctas = get_option("i3d_calls_to_action");
		if ($instance['is_short_tag']) {
			$callToActionID = $instance['id'];
		} else {
			$callToActionID = $instance['default_call_to_action_id'];
		//	print $callToActionID;
			
			$pageLevelSettings = get_post_meta($post->ID, "i3d_call_to_action", true);

			$widgetCount = self::$pageWidgetCount;
			$pageLevelSettings = wp_parse_args( (array) $pageLevelSettings, array( "id_{$widgetCount}" => '') );
			$pageLevelCTA = $pageLevelSettings["id_{$widgetCount}"];
			//print $pageLevelCTA;
			if ($pageLevelSettings["id_{$widgetCount}"] == "") {
				// use page default
			} else if ($pageLevelSettings["id_{$widgetCount}"] == "x") {
				// do not use a call to action here
				$callToActionID = "";
			} else if ($pageLevelCTA != "" && is_array($ctas["{$pageLevelCTA}"]) != "") {
				$callToActionID = $pageLevelSettings["id_{$widgetCount}"];
				//print "yup";
			}
		}
	//	print $callToActionID;
		//print $callToActionID;
		$cta = @$ctas["$callToActionID"];
		//var_dump($cta);
		$html = "";
		$objects = @$cta['objects'];
		if (!is_array($objects)) {
			$objects = array();
		} else {
			$html .= "<div class='call-to-action'>";
		}
		// var_dump($objects);
	
		
		foreach ($objects as $object) {
			$object = wp_parse_args( (array) $object, array( "width" => 'span12', 'text' => '', "text_2" => "", "style_2" => "", 'size' => '', 'align' =>'', 'animate_action' => '', 'style' => '' ) );

			if ($object['text'] != "") {
			   $styleAdjust = "";
			   $width = I3D_Framework::conditionBootstrapSpan($object['width']);
			   if ($object['width'] == "span12") {
				 $wrapWithRow = true;   
			   } else {
				 $wrapWithRow = false;  
			   }
			   if ($wrapWithRow) {
				   $html .= "<div class='row' style='clear: both;'>";
			   }
			   if ($object['type'] == "text") { 
			    // $html .= "<div class=''>";
				   if ($object['size'] == "p.lead") {
					   $object['size'] = "p";
				       $styleAdjust = "lead";
				   }
			       $html .= "<{$object['size']} class='{$width} {$styleAdjust} {$object['align']} animated {$object['animate_action']}'>";
				   if ($object['style'] != "") {
					   $html .= "<span class='{$object['style']}'>";
				   }
				   $html .= "{$object['text']}";
				   if ($object['style'] != "") {
					   $html .= "</span>";
				   }
				   if ($object['style_2'] != "") {
					   $html .= "<span class='{$object['style_2']}'>";
				   }
				   $html .= " {$object['text_2']}";
				   if ($object['style_2'] != "") {
					   $html .= "</span>";
				   }
				   
				   
				   $html .= "</{$object['size']}>";
			    // $html .= "</div>";
			   } else if ($object['type'] == "button") { 
			   	   $html .= "<div class='{$width} {$object['align']}'><a class='btn btn-primary margin-top-20 margin-bottom-20 animated {$object['animate_action']}' href='";
				   if ($object['link'] == "**external**") { 
				     $html .= $object['external_link'];
				   } else {
					 $html .= get_permalink($object['link']);
				   }
				   $html .= "'>{$object['text']}</a></div>";

			   }
			   if ($wrapWithRow) {
				   $html .= "</div>";
			   }
			}		  	
		}
        if ($html != "") {
		  $html .= "</div>";	
		}
		echo $html;
		
		
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['default_call_to_action_id'] = $new_instance['default_call_to_action_id'];
		
		return $instance;
	}


	function layout_configuration_form( $instance, $defaults, $row_id, $widget_id, $layout_id, $page_level = false ) {
	  $instance =  wp_parse_args( (array) $instance, array( 'default_cta_id' => ''  ) );
	  global $post;
	  
	//  var_dump($instance);
	  
	  $layouts = get_option('i3d_layouts');
	  if ($page_level) {
		  $prefix = "__i3d_layouts__{$layout_id}__";
			$page_layouts 		= (array)get_post_meta($post->ID, "layouts", true);
/*
			if (!array_key_exists($widget_id, $page_layouts["$layout_id"]["$row_id"]["configuration"])) {
				$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"] = array();
			}
*/
	$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"] =  wp_parse_args( (array) @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"], array( 'sidebar' => '', 'box_style' => '*'   ) );
		//	print "no";
			$default_cta_id = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["default_call_to_action_id"];
			
			// if box_style == "*" then it whatever the layout default is
			if ($default_call_to_action_id == "*") {
			  $instance['default_call_to_action_id'] = "*";
			  
			  // if the box style is blank, then it means there is no box_style
			} else if ($default_call_to_action_id == "") {
				$instance['default_call_to_action_id'] = "";
			
			} else if ($default_call_to_action_id != "") {
			    $instance['default_call_to_action_id'] = $default_call_to_action_id;	
			}
			$layoutID = $layout_id;
	  } else {
		//  global $layoutID;
		  
		  $prefix = "";
		  
	  }
	//  print "layoutID: $layoutID";
      	//  $layoutName = $layouts["{$layout_id}"]["title"];
		$ctas = get_option("i3d_calls_to_action");

	  ?>
	<div class="input-group tt2" title="Choose Call To Action" >
  		<span class="input-group-addon detailed-addon"><i class="fa fa-bullhorn fa-fw"></i> <span class='detailed-label'>Call To Action</span></span>

	  <select class='form-control'  name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__default_call_to_action_id">
		<option  style='color: #cccccc;' value="">-- Choose CTA --</option>
	    <?php 
		// if there is no prefix, then this is the layout manager level
		if ($prefix == "") { 
			$selected_sidebar = @$instance['default_call_to_action_id'];
            
		?>
		<?php 
		// else, if there is a prefix, then this is the page level configurations
		} else {

			$selected_sidebar = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["sidebar"];
			//print "<option>$layout_id</option>";
			//print "<option>$selected_sidebar</option>";
			//print "<option>$widget_id</option>";
			?>
        <option value="*" ><?php _e("-- Layout Default --","i3d-framework"); ?></option>

		<?php } ?>
        <?php foreach ($ctas as $id => $cta) { ?>
          <option <?php if (@$instance['default_call_to_action_id'] == $id) { print "selected"; } ?> value="<?php echo $id; ?>"><?php echo $cta['title']; ?></option>
        <?php } ?>
		
		
                </select> 
				</div>
		
	  <?php
	}

	function form( $instance ) {
		$justification = strip_tags(@$instance['justification']);
		?>
        <script>
jQuery("a.widget-action").bind("click", function() {
				//shrinkVideoRegion(this);									

});
 
jQuery("a.widget-control-close").bind("click", function() {
			//	shrinkVideoRegion(this);									

});
</script><div class='i3d-widget-container'>
    <div class='i3d-help-region'>
    <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://www.youtube.com/watch?v=l_SX5F1WSno"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>
<!--    <div class='i3d-help-region-opened i3d-help-region-hidden'>
    <div class='i3d-help-title-bar'>Hide</div>
<iframe width="420" height="315" src="//www.youtube.com/embed/l_SX5F1WSno" frameborder="0" allowfullscreen></iframe>
    </div>-->
    </div> 
<div class='i3d-widget-main-large'>

        <!-- justification -->
        <?php
		$ctas = get_option("i3d_calls_to_action");
		$adminPage = "admin.php?page=i3d_calls_to_action";
		if (!is_array($ctas)) {
			?>
        <p><b>Note:</b> You have not yet created any "Calls To Action".  <a href="<?php echo $adminPage; ?>">Click here</a> to create one.</p>
        <?php } else { ?>
        <p><b>Note:</b> If you have a page with a Call To Action widget displayed on it, you can also use page-level configurations under the "General" tab in your page properties.</p>
        <label class='label-165' for="<?php echo $this->get_field_id('default_call_to_action_id'); ?>"><?php _e('Default Call To Action:',"i3d-framework"); ?></label>
		<select id="<?php echo $this->get_field_id('default_call_to_action_id'); ?>" name="<?php echo $this->get_field_name('default_call_to_action_id'); ?>">
          <option  style='color: #cccccc;' value="">-- Choose Call To Action --</option>
        <?php foreach ($ctas as $id => $cta) { ?>
          <option <?php if (@$instance['default_call_to_action_id'] == $id) { print "selected"; } ?> value="<?php echo $id; ?>"><?php echo $cta['title']; ?></option>
        <?php } ?>
                </select> 
        <?php } ?>
        </div>    
    
    </div>

        <?php
	}
}


?>
<?php

/***********************************/
/**        HTML WIDGET BOX        **/
/***********************************/
class I3D_Widget_FocalBox extends WP_Widget {
	protected static $pageWidgetCount = '0';
	
	function __construct() {
	//function I3D_Widget_FocalBox() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Animates images, text and buttons into a "Focal Box"', "i3d-framework") );
		parent::__construct('i3d_fb', __('i3d:Focal Box', "i3d-framework"), $widget_ops);
	}

    
	function widget( $args, $instance ) {
		
		self::$pageWidgetCount++;
		extract( $args );
		global $post;
		$instance = wp_parse_args( (array) $instance, array( 'is_short_tag' => '','id' => '', 'default_focal_box_id' => '') );
	
		echo $before_widget;
		$fbs = get_option("i3d_focal_boxes");
		
		if ($instance['is_short_tag']) {
			$focalBoxID = $instance['id'];
		} else {
			$focalBoxID = $instance['default_focal_box_id'];
			
			$pageLevelSettings = get_post_meta($post->ID, "i3d_focal_box", true);

			$widgetCount = self::$pageWidgetCount;
			$pageLevelSettings = wp_parse_args( (array) $pageLevelSettings, array( "id_{$widgetCount}" => '') );
			$pageLevelFB = $pageLevelSettings["id_{$widgetCount}"];
			
			
			if ($pageLevelSettings["id_{$widgetCount}"] == "") {
				// use page default
			} else if ($pageLevelSettings["id_{$widgetCount}"] == "x") {
				// do not use a call to action here
				$focalBoxID = "";
			} else if ($pageLevelFB != "" && is_array($fbs["{$pageLevelFB}"]) != "") {
				$focalBoxID = $pageLevelSettings["id_{$widgetCount}"];
			}
		}
		
		$fb = @$fbs["$focalBoxID"];
		$html = "";
		$html .= "<div class='focal-box'>";
		$images = $this->buildImages(@$fb['images']);
		$text   = $this->buildText(@$fb['objects']);
		
		if ($fb['layout'] == "image-left") {
		  $html .= "<div class='col-sm-6 ps-left' style='height: {$images['max_height']}px'>{$images['html']}</div>";
		  $html .= "<div class='col-sm-6 ps-right'>{$text}</div>";
		} else if ($fb['layout'] == "image-right") {
		  $html .= "<div class='col-sm-6 ps-left'>{$text}</div>";
		  $html .= "<div class='col-sm-6 ps-right' style='height: {$images['max_height']}px'>{$images['html']}</div>";
			
		} else if ($fb['layout'] == "image-only") {
		  $html .= "<div class='col-sm-12 text-center' ><div style='text-align: center;height: {$images['max_height']}px; width: {$images['max_width']}px; margin: auto; position: relative;'>{$images['html']}</div></div>";
			
		}
	
		
		
		  $html .= "</div>";	
		echo $html;
		
		
		echo $after_widget;
	}
	function buildText($objects) {
		if (!is_array($objects)) {
			$objects = array();
		}
		$html = "";
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
				   if ($object['size'] == "p.lead") {
					   $object['size'] = "p";
				       $styleAdjust = "lead";
				   }
			       $html .= "<div class='ps-{$object['size']} {$width} {$styleAdjust} {$object['align']} '>";
				   if ($object['style'] != "") {
					   $html .= "<span class='{$object['style']}'>";
				   }
				   $object['text'] = str_replace(array("[highlight]", "[/highlight]"), array("<span class='highlight'>", "</span>"), $object['text']); 
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
				   
				   
				   $html .= "</div>";
			   } else if ($object['type'] == "button") { 
			   	   $html .= "<div class='{$width} {$object['align']} ps-button1'><a class='btn btn-primary btn-lg btn-block ' href='";
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
		$html = "<div class='ps-content' data-bottom-top='opacity: 0' data-bottom='opacity: 1' data-top='opacity: 1' data-top-bottom='opacity: 0'>{$html}</div>";
		return $html;
	}
	
	function buildImages($images) {
		if (!is_array($images)) {
			$images = array();
		}
		
		
		$html = "";
		$maxHeight = 0;
		$maxWidth = 0;
		$fileNames = array();

	  foreach ($images as $i => $currentImage) {
		  //var_dump($currentImage);
		  $imageNumber = $i + 1;
		  if ($currentImage != "" && is_numeric($currentImage)) {
			$metaData = get_post_meta($currentImage, '_wp_attachment_metadata', true); 
			//var_dump($metaData);
			$large_image_url = wp_get_attachment_image_src( $currentImage, 'full');
			$image = $large_image_url[0];
			if ($metaData['height'] > $maxHeight) {
				$maxHeight = $metaData['height'];
			}
			if ($metaData['width'] > $maxWidth) {
				$maxWidth = $metaData['width'];
			}
			//$fileNames["$i"] = site_url().'/wp-content/uploads/'.$metaData['file']; 
			$fileNames["$i"] = $image;
		 } else {
			$fileNames["$i"] = "";
		 }
	  }


		foreach ($fileNames as $i => $fileName) {
		  $imageNumber = $i + 1;
		
		 if ($fileName != "") {
			$html .= "<img alt='Image {$i}' src='{$fileName}' class='ps-image{$imageNumber}' ";
			if ($i == 0) {
				$html .= "data-bottom-top='opacity:0;top:150px;transform:scale(0)' data-center-top='opacity:1;top:0px;transform:scale(1)' data-center='opacity:0;top:0px;transform:scale(1)'";
		
			} else if ($i == 1) {
				$html .= "data-bottom-top='opacity:0;top:0px;transform:scale(1)' data-center-top='opacity:0;top:0px;transform:scale(1)' data-center='opacity:1;top:0px;transform:scale(1)' data-center-bottom='opacity:0;top:0px;left:0px;transform:scale(1)'";
				
			} else if ($i == 2) {
				$html .= "data-bottom-top='opacity:0;top:0px;transform:scale(0)' data-center='opacity:0;top:0px;transform:scale(1)' data-center-bottom='opacity:1;top:0px;transform:scale(1)' data-top-bottom='opacity:0;top:250px;transform:scale(0)'";
				
			}
			$html .= ">";
		 }
		  
		  
		
	  }
	  return array('html' => $html, 'max_height' => $maxHeight, 'max_width' => $maxWidth);
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['default_focal_box_id'] = $new_instance['default_focal_box_id'];
		
		return $instance;
	}

	function layout_configuration_form( $instance, $defaults, $row_id, $widget_id, $layout_id, $page_level = false ) {
	  $instance =  wp_parse_args( (array) $instance, array( 'default_focal_box_id' => ''  ) );
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
			$default_focal_box_id = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["default_focal_box_id"];
			
			// if box_style == "*" then it whatever the layout default is
			if ($default_focal_box_id == "*") {
			  $instance['default_focal_box_id'] = "*";
			  
			  // if the box style is blank, then it means there is no box_style
			} else if ($default_focal_box_id == "") {
				$instance['default_focal_box_id'] = "";
			
			} else if ($default_focal_box_id != "") {
			    $instance['default_focal_box_id'] = $default_focal_box_id;	
			}
			$layoutID = $layout_id;
	  } else {
		//  global $layoutID;
		  
		  $prefix = "";
		  
	  }
	//  print "layoutID: $layoutID";
      	//  $layoutName = $layouts["{$layout_id}"]["title"];
		$fbs = get_option("i3d_focal_boxes");

	  ?>
	<div class="input-group tt2" title="Choose Focal Box" >
  		<span class="input-group-addon detailed-addon"><i class="fa fa-bullhorn fa-fw"></i> <span class='detailed-label'>Focal Box</span></span>

	  <select class='form-control'  name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__default_focal_box_id">
		<option  style='color: #cccccc;' value="">-- Choose Focal Box --</option>
	    <?php 
		// if there is no prefix, then this is the layout manager level
		if ($prefix == "") { 
			$selected_sidebar = $instance['default_focal_box_id'];
            
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
        <?php foreach ($fbs as $id => $fb) { ?>
          <option <?php if ($instance['default_focal_box_id'] == $id) { print "selected"; } ?> value="<?php echo $id; ?>"><?php echo $fb['title']; ?></option>
        <?php } ?>
		
		
                </select> 
				</div>
		
	  <?php
	}

	function form( $instance ) {
		//var_dump($instance);
		//$justification = strip_tags(@$instance['justification']);
		?>
<div class='i3d-widget-container'>
<!--
    <div class='i3d-help-region'>
    <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://www.youtube.com/watch?v=l_SX5F1WSno"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>

    </div> 
	-->
<div class='i3d-widget-main-large'>

        <!-- justification -->
        <?php
		$fbs = get_option("i3d_focal_boxes");
		$adminPage = "admin.php?page=i3d_focal_boxes";
		if (!is_array($fbs)) {
			?>
        <p><b>Note:</b> You have not yet created any "Focal Boxes".  <a href="<?php echo $adminPage; ?>">Click here</a> to create one.</p>
        <?php } else { ?>
        <p><b>Note:</b> If you have a page with a Focal Box widget displayed on it, you can also use page-level configurations under the "General" tab in your page properties.</p>
        <label class='label-165' for="<?php echo $this->get_field_id('default_focal_box_id'); ?>"><?php _e('Default Focal Box:',"i3d-framework"); ?></label>
		<select id="<?php echo $this->get_field_id('default_focal_box_id'); ?>" name="<?php echo $this->get_field_name('default_focal_box_id'); ?>">
          <option  style='color: #cccccc;' value="">-- Choose Focal Box --</option>
        <?php foreach ($fbs as $id => $fb) { ?>
          <option <?php if ($instance['default_focal_box_id'] == $id) { print "selected"; } ?> value="<?php echo $id; ?>"><?php echo $fb['title']; ?></option>
        <?php } ?>
                </select> 
        <?php } ?>
        </div>    
    
    </div>

        <?php
	}
}


?>
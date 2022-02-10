<?php

/***********************************/
/**        HTML WIDGET BOX        **/
/***********************************/
class I3D_Widget_HTMLBox extends WP_Widget {
	//function I3D_Widget_HTMLBox() {
	function __construct() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Render text or HTML.', "i3d-framework") );
		$control_ops = array('width' => "400px");
		parent::__construct('i3d_htmlbox', __('i3d:HTML Box', "i3d-framework"), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		$instance = wp_parse_args( (array) $instance, array('box_layout' => '',
															'box_style' => '',
															
															'vector_icon' => '',
															'vector_icon_animation' => '', 
															'vector_icon_animation_delay' => '',
															
															'title' => '', 
															'title_tag' => "h3", 
															'title_class' => '',
															'title_animation' => '',
															'title_animation_delay' => '',

															'subtitle' => '', 
															'subtitle_tag' => "h3", 
															'subtitle_class' => '',
															'subtitle_animation' => '',
															'subtitle_animation_delay' => '',

															'text' => '', 
															'text_class' => '',
															'text_animation' => '',
															'text_animation_delay' => '',

															'justification' => 'left' ) );
		
		$before_widget = str_replace("i3d-opt-box-style", $instance['box_style'], $before_widget);
	
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
		$subtitle = apply_filters( 'widget_title', empty($instance['subtitle']) ? '' : $instance['subtitle'], $instance );
	
		$title = I3D_Framework::conditionFontAwesomeIcon($instance['title']);
		$instance['text'] = str_replace("[themeroot]", get_stylesheet_directory_uri(), $instance['text']);
		$text = apply_filters( 'widget_text', $instance['text'], $instance );
		$title = apply_filters( 'widget_text', $instance['title'], $instance );
		$subtitle = apply_filters( 'widget_text',  $instance['subtitle'], $instance );

		$justification = $instance['justification'];
		echo $before_widget;
		echo "<div class='i3d-widget-htmlbox";
		  if ($justification == "right") {
			  echo " pull-right text-right";
		  } else if ($justification == "center") {
			  echo " text-center";
		  } else {
			  echo " text-left";
		  }
		  
		  if ($instance['box_layout'] == "section-list") {
			  echo " section-list";
		  }
		  echo "'";
		  echo ">";
		  
		$iconCode = "";

		if ($instance['vector_icon'] != "") {
 			if ($instance['box_layout'] == "section-list" && I3D_Framework::$sectionListVersion == "2") {
				$iconCode = "<span class='fa-stack fa-lg pull-left ".@$instance['vector_icon_animation'];
							$dataAttr = "";
			if ($instance['title_animation_delay'] != "") { 
				if (!strstr($instance['title_animation'], "wow ")) { 
					$iconCode .= " ".$instance['vector_icon_animation_delay'];
				} else {
					
					$instance['title_animation_delay'] = str_replace("delay-", "", $instance['title_animation_delay'])."ms";
					$dataAttr = "data-wow-delay='{$instance['title_animation_delay']}'";
					$iconCode .= "' {$dataAttr}";
				}
			}
			$iconCode .= "'>
	  					<i class='fa fa-circle fa-stack-2x highlight1'></i>
	  					<i class='fa ".$instance['vector_icon']." fa-stack-1x fa-inverse'></i>
					</span>";
				
			} else {			
			
			  $iconCode .= "<i class='";
			  if (strstr($instance['vector_icon'], "fa-")) {
				  $iconCode .= "fa ";
			  }
			  $iconCode .= $instance['vector_icon'];
			  $iconCode .= " ".$instance['vector_icon_animation'];
		      $iconCode .= " ".$instance['vector_icon_animation_delay'];
			  if ($instance['box_layout'] == "section-list") {
				 $iconCode .= " fa-fw fa-1x";  
			  }
			  if ($instance['box_layout'] == "highlight-title-box") {
					 $iconCode .= " fa-fw fa-3x";  
			  
			  }
			  $iconCode .= "'></i> ";
			}
		  }		
		  
		if ($instance['box_layout'] == "section-list" || $instance['box_layout'] == "highlight-title-box") {
			echo $iconCode;
		}
		
		if (array_key_exists($instance['box_style'], I3D_Framework::$boxStylesTitleWrap)) {
		  echo "<div class='".I3D_Framework::$boxStylesTitleWrap["{$instance['box_style']}"]."'>";
		}
		if ( !empty( $title ) ) { 
		    $titleClasses = "";
		    $titleClasses .= $instance['title_class']." ";
			$titleClasses .= $instance['title_animation']." ";
			$dataAttr = "";
			if ($instance['title_animation_delay'] != "") { 
				if (!strstr($instance['title_animation'], "wow ")) { 
					$titleClasses .= $instance['title_animation_delay']." ";
				} else {		
					$instance['title_animation_delay'] = str_replace("delay-", "", $instance['title_animation_delay'])."ms";
					$dataAttr = "data-wow-delay='{$instance['title_animation_delay']}'";
				}
			}
			
		    $before_title = str_replace("<h3>", "<h3 class='{$titleClasses}' {$dataAttr}>", $before_title);
			echo str_replace("h3", $instance['title_tag'], $before_title);
			if ($instance['box_layout'] == "") {
			echo $iconCode;
		    }	   
		  
			echo $title;
			echo str_replace("h3", $instance['title_tag'], $after_title);
		 } 
	//	 print ".";
		 if ( !empty( $subtitle )) { 
		    $titleClasses = "";
		    $titleClasses .= $instance['subtitle_class']." ";
			$titleClasses .= $instance['subtitle_animation']." ";
			$dataAttr = "";
			if ($instance['subtitle_animation_delay'] != "") { 
				if (!strstr($instance['subtitle_animation'], "wow ")) { 
					$titleClasses .= $instance['subtitle_animation_delay']." ";
				} else {		
					$instance['subtitle_animation_delay'] = str_replace("delay-", "", $instance['subtitle_animation_delay'])."ms";
					$dataAttr = "data-wow-delay='{$instance['subtitle_animation_delay']}'";
				}
			}
			
		    $before_title = str_replace("<h3>", "<h3 class='{$titleClasses}' {$dataAttr}>", $before_title);
			echo str_replace("h3", $instance['subtitle_tag'], $before_title);
			//if ($instance['box_layout'] == "") {
			//echo $iconCode;
		//}	   
		  //echo $instance['subtitle'];
		echo $subtitle;
		echo str_replace("h3", $instance['subtitle_tag'], $after_title);
		 }
		// print "!";
		 
		 

		if (array_key_exists($instance['box_style'], I3D_Framework::$boxStylesTitleWrap)) {
		  echo "</div>";
		}

		 $contentWrapperTag = "div";
		 if ($instance['box_layout'] == "section-list") { $contentWrapperTag = "p"; } 
		 if (!empty($text)) { 
		   echo "<{$contentWrapperTag} ";?>
			class="<?php echo $instance['text_class']; ?> <?php echo $instance['text_animation']; ?> <?php echo $instance['text_animation_delay']; ?>"><?php echo nl2br($text); ?>
		<?php
			echo "</{$contentWrapperTag}><!-- end of content wrapper -->\n";
			}
			?>
		</div><?php
		echo $after_widget."\n";
	}

	function layout_configuration_form( $instance, $defaults, $row_id, $widget_id, $layout_id, $page_level = false ) {
	//	var_dump($instance);
	//	var_dump($defaults);
	  $defaults =  wp_parse_args( (array) $defaults, array( 
														    'vector_icon' => '', 
														    'vector_icon_animation' => '', 
															'vector_icon_animation_delay' => '', 
															'title_setting' => '', 
															'title' => '',
															'title_tag' => 'h2', 
															'title_animation' => '', 
															'title_animation_delay' => '', 
															'subtitle_setting' => '', 
															'subtitle' => '',
															'subtitle_tag' => 'h2', 
															'subtitle_animation' => '', 
															'subtitle_animation_delay' => '', 
															'justification' => '', 
															'box_layout' => '', 
															'box_style' => ''
															) );
	  
	  $instance =  wp_parse_args( (array) $instance, array( 'vector_icon' => $defaults['vector_icon'], 
															'vector_icon_animation' => $defaults['vector_icon_animation'],  
															'vector_icon_animation_delay' => $defaults['vector_icon_animation_delay'],  														   
														    'title_setting' => $defaults['title_setting'], 
															'title' => $defaults['title'], 
															'title_tag' => $defaults['title_tag'],  
															'title_animation' => $defaults['title_animation'],  
															'title_animation_delay' => $defaults['title_animation_delay'],  
														    'subtitle_setting' => $defaults['subtitle_setting'], 
															'subtitle' => $defaults['subtitle'], 
															'subtitle_tag' => $defaults['subtitle_tag'],  
															'subtitle_animation' => $defaults['subtitle_animation'],  
															'subtitle_animation_delay' => $defaults['subtitle_animation_delay'],  
															'justification' => $defaults['justification'], 
															'box_layout' => $defaults['box_layout'], 
															'box_style' => $defaults['box_style']) );
	  global $post;
	  global $i3dTextLogoLines;
//var_dump($instance);
	  $layouts = get_option('i3d_layouts');
	  if ($page_level) {
		
		  $prefix = "__i3d_layouts__{$layout_id}__";
			$page_layouts 		= (array)get_post_meta($post->ID, "layouts", true);
			$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"] =  wp_parse_args( (array) @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"], 
																									array('vector_icon' => "default", 
																										  'vector_icon_animation' => 'default', 
																										  'vector_icon_animation_delay' => 'default', 
																										  'title_setting' => 'default', 
																										  'title' => '', 
																										  'title_tag' => 'default', 
																										  'title_animation' => 'default', 
																										  'title_animation_delay' => 'default', 
																										  'subtitle_setting' => 'default', 
																										  'subtitle' => '', 
																										  'subtitle_tag' => 'default', 
																										  'subtitle_animation' => 'default', 
																										  'subtitle_animation_delay' => 'default', 
																										  'justification' => 'default', 
																										  'box_layout' => 'default', 
																										  'box_style' => 'default' ) );
			
			$vector_icon = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]['vector_icon'];
	        $vector_icon_animation = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["vector_icon_animation"];
	        $vector_icon_animation_delay = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["vector_icon_animation_delay"];
	        
			$title_setting = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["title_setting"];
	        $title 		 = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["title"];
	        $title_tag 		 = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["title_tag"];
	        $title_animation 		 = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["title_animation"];
	        $title_animation_delay 		 = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["title_animation_delay"];


			$subtitle_setting = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["subtitle_setting"];
	        $subtitle 		 = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["subtitle"];
	        $subtitle_tag 		 = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["subtitle_tag"];
	        $subtitle_animation 		 = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["subtitle_animation"];
	        $subtitle_animation_delay 		 = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["subtitle_animation_delay"];


			$justification	 = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["justification"];
	        $box_style 			 = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["box_style"];
	        $box_layout 			 = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["box_layout"];
									
			$layoutID = $layout_id;
	  } else {
		  $prefix = "";
		if ( !isset($instance['vector_icon']) )   { $vector_icon = "default"; } else { $vector_icon = $instance['vector_icon']; }
		if ( !isset($instance['vector_icon_animation']) )   { $vector_icon_animation = "default"; } else { $vector_icon_animation = $instance['vector_icon_animation']; }
		if ( !isset($instance['vector_icon_animation_delay']) )   { $vector_icon_animation_delay = "default"; } else { $vector_icon_animation_delay = $instance['vector_icon_animation_delay']; }
		
		if ( !isset($instance['title_setting']) ){ $title_setting = ""; } else { $title_setting = $instance['title_setting']; }
		if ( !isset($instance['title']) ) 	{ $title = ""; } else { $title = ($instance['title']); }
		if ( !isset($instance['title_tag']) ){ $title_tag = "default"; } else { $title_tag = $instance['title_tag']; }
		if ( !isset($instance['title_animation']) ){ $title_animation = "default"; } else { $title_animation = $instance['title_animation']; }
		if ( !isset($instance['title_animation_delay']) ){ $title_animation_delay = "default"; } else { $title_animation_delay = $instance['title_animation_delay']; }


		if ( !isset($instance['subtitle_setting']) ){ $subtitle_setting = ""; } else { $subtitle_setting = $instance['subtitle_setting']; }
		if ( !isset($instance['subtitle']) ) 	{ $subtitle = ""; } else { $subtitle = ($instance['subtitle']); }
		if ( !isset($instance['subtitle_tag']) ){ $subtitle_tag = "default"; } else { $subtitle_tag = $instance['subtitle_tag']; }
		if ( !isset($instance['subtitle_animation']) ){ $subtitle_animation = "default"; } else { $subtitle_animation = $instance['subtitle_animation']; }
		if ( !isset($instance['subtitle_animation_delay']) ){ $subtitle_animation_delay = "default"; } else { $subtitle_animation_delay = $instance['subtitle_animation_delay']; }

		if ( !isset($instance['justification']) ){ $justification = "default"; } else { $justification = $instance['justification']; }
		if ( !isset($instance['box_style']) ){ $box_style = "default"; } else { $box_style = $instance['box_style']; }
		if ( !isset($instance['box_layout']) ){ $box_layout = "default"; } else { $box_layout = $instance['box_layout']; }

	  }
	  $rand = rand();
	  
	//  print $box_layout." -- ".$box_style."<br>";
?>
<h6 class='text-left'>Icon</h6>
         <div title="Vector Icon" class='vector-icons tt2'>
         <div class='input-group'>
  		<span class="input-group-addon detailed-addon"><i class="fa fa-flag fa-fw"></i> <span class='detailed-label'>Icon</span></span>
        <!-- Font Awesome Icons --> 
		<select class='form-control tt2' onChange="setVectorIcon<?php echo $rand; ?>(this)"  id="<?php echo $this->get_field_id('vector_icon'); ?>"  name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__vector_icon">
          <option <?php if ($vector_icon == "") { print "selected"; } ?> value=""><?php _e('Disabled', "i3d-framework"); ?></option>
          <option <?php if ($vector_icon == "global")  { print "selected"; } ?> value="global"><?php _e('Default', "i3d-framework"); ?></option>
     	  <option <?php if ($vector_icon != "" && $vector_icon != "global")   { print "selected"; } ?> value="custom"><?php _e('Custom', "i3d-framework"); ?></option>
        </select> 
		</div>
    
		<div class='available-fontawesome-icons'  style='vertical-align: top; <?php if ($vector_icon == "" || $vector_icon == "global" || $vector_icon == "disabled") { print 'display: none;'; } else { print "display: inline-block;"; } ?>'>
                  	<?php I3D_Framework::renderFontAwesomeSelect($prefix.$row_id."__configuration__".$widget_id."__font_awesome_icon", @$vector_icon); ?>

		  
		  <?php /* foreach ($fontAwesomeIcons as $icon) { ?>
          <div class='font-awesome-icon <?php if ($icon == $font_awesome_icon) { print "font-awesome-icon-selected"; } ?>' onclick='setFontAwesomeIcon(this, "<?php print $icon; ?>")'><i class='icon-<?php echo $icon; ?>'></i></div>
          <?php } */ ?>
        </div>
        </div>




	<?php if (sizeof(I3D_Framework::$animationClasses) > 0) { ?>
	    <div class="input-group title-custom">
		<span class="input-group-addon detailed-addon"><i class="fa fa-font fa-fw"></i> <span class='detailed-label'>Animation</span></span>
		<select onchange="handleVectorIconAnimationChange<?php echo $rand; ?>()" class='form-control tt2' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__vector_icon_animation">
          <?php if ($prefix != "") { ?><option <?php if ($title_animation == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option><?php } ?>
          <option value=""><?php _e("No Animation", "i3d-framework"); ?></option>
          <?php foreach (I3D_Framework::$animationClasses as $key => $value) { ?>
		  <option <?php if ($vector_icon_animation == $key) { print "selected"; } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
		  <?php } ?>
		</select>
		<select <?php if ($vector_icon_animation == "" || strstr($vector_icon_animation, "skrollr")) { echo "style='display: none;'"; }  ?> class='form-control tt' title='Animation Delay' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__vector_icon_animation_delay">
          <option value=""><?php _e("No Delay", "i3d-framework"); ?></option>
          <option <?php if ($vector_icon_animation_delay == "delay-250") { print "selected"; } ?> value="delay-250">250ms</option>
          <option <?php if ($vector_icon_animation_delay == "delay-500") { print "selected"; } ?> value="delay-500">500ms</option>
          <option <?php if ($vector_icon_animation_delay == "delay-750") { print "selected"; } ?> value="delay-750">750ms</option>
          <option <?php if ($vector_icon_animation_delay == "delay-1000") { print "selected"; } ?> value="delay-1000">1000ms</option>
          <option <?php if ($vector_icon_animation_delay == "delay-1250") { print "selected"; } ?> value="delay-1250">1250ms</option>
		</select>
	    </div>
	<?php } ?>	



<h6 class='text-left'>Text Line 1</h6>
	<div class="input-group">
  		<span class="input-group-addon detailed-addon"><i class="fa fa-code fa-fw"></i> <span class='detailed-label'>Tag</span></span>
		<select  class='form-control tt2' title="Tag" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__title_tag">
          <?php if ($prefix != "") { ?><option <?php if ($title_tag == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option><?php } ?>
          <option <?php if ($title_tag == "h1") { print "selected"; } ?> value="h1">H1</option>
          <option <?php if ($title_tag == "h2") { print "selected"; } ?> value="h2">H2</option>
          <option <?php if ($title_tag == "h3" || $title_tag == "") { print "selected"; } ?> value="h3">H3</option>
          <option <?php if ($title_tag == "h4") { print "selected"; } ?> value="h4">H4</option>
          <option <?php if ($title_tag == "h5") { print "selected"; } ?> value="h5">H5</option>
          <option <?php if ($title_tag == "p") { print "selected"; } ?> value="p">Paragraph</option>
          <option <?php if ($title_tag == "div") { print "selected"; } ?> value="div">DIV</option>
          <option <?php if ($title_tag == "span") { print "selected"; } ?> value="span">SPAN</option>
		</select>

	

	</div>


<?php if ($prefix != "") { ?>
	<div class="input-group">
  		<span class="input-group-addon detailed-addon"><i class="fa fa-gear fa-fw"></i> <span class='detailed-label'>Text Setting</span></span>
		<select onChange="setTitleSetting<?php echo $rand; ?>(this)" class='form-control tt2' title="Text Setting" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__title_setting">
          <option <?php if ($title_setting == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option>
     	  <option <?php if ($title_setting != "default")   { print "selected"; } ?> value="custom"><?php _e('Custom', "i3d-framework"); ?></option>
		</select>
	</div>
 	  
<?php } ?>
	     <div class="input-group title-custom" <?php if ($title_setting == "default") { print 'style="display: none;"'; } ?>>
		 <span class="input-group-addon detailed-addon"><i class="fa fa-font fa-fw"></i> <span class='detailed-label'>Text</span></span>
 		 <textarea placeholder="<?php _e("Example Text", "i3d-framework"); ?>" class='form-control' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__title"><?php echo $title; ?></textarea>
        </div> 

	<?php if (sizeof(I3D_Framework::$animationClasses) > 0) { ?>
	    <div class="input-group title-custom">
		<span class="input-group-addon detailed-addon"><i class="fa fa-font fa-fw"></i> <span class='detailed-label'>Animation</span></span>
		<select onchange="handleTitleAnimationChange<?php echo $rand; ?>()" class='form-control tt2' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__title_animation">
          <?php if ($prefix != "") { ?><option <?php if ($title_animation == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option><?php } ?>
          <option value=""><?php _e("No Animation", "i3d-framework"); ?></option>
          <?php foreach (I3D_Framework::$animationClasses as $key => $value) { ?>
		  <option <?php if ($title_animation == $key) { print "selected"; } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
		  <?php } ?>
		</select>
		<select <?php if ($title_animation == "" || strstr($title_animation, "skrollr")) { echo "style='display: none;'"; }  ?> class='form-control tt' title='Animation Delay' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__title_animation_delay">
          <option value=""><?php _e("No Delay", "i3d-framework"); ?></option>
          <option <?php if ($title_animation_delay == "delay-250") { print "selected"; } ?> value="delay-250">250ms</option>
          <option <?php if ($title_animation_delay == "delay-500") { print "selected"; } ?> value="delay-500">500ms</option>
          <option <?php if ($title_animation_delay == "delay-750") { print "selected"; } ?> value="delay-750">750ms</option>
          <option <?php if ($title_animation_delay == "delay-1000") { print "selected"; } ?> value="delay-1000">1000ms</option>
          <option <?php if ($title_animation_delay == "delay-1250") { print "selected"; } ?> value="delay-1250">1250ms</option>
		</select>
	    </div>
	<?php } ?>	

<!-- text 2 -->
<h6 class='text-left'>Text Line 2</h6>

	<div class="input-group">
  		<span class="input-group-addon detailed-addon"><i class="fa fa-code fa-fw"></i> <span class='detailed-label'>Tag</span></span>
		<select  class='form-control tt2' title="Tag" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__subtitle_tag">
          <?php if ($prefix != "") { ?><option <?php if ($title_tag == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option><?php } ?>
          <option <?php if ($subtitle_tag == "h1") { print "selected"; } ?> value="h1">H1</option>
          <option <?php if ($subtitle_tag == "h2") { print "selected"; } ?> value="h2">H2</option>
          <option <?php if ($subtitle_tag == "h3" || $title_tag == "") { print "selected"; } ?> value="h3">H3</option>
          <option <?php if ($subtitle_tag == "h4") { print "selected"; } ?> value="h4">H4</option>
          <option <?php if ($subtitle_tag == "h5") { print "selected"; } ?> value="h5">H5</option>
          <option <?php if ($subtitle_tag == "p") { print "selected"; } ?> value="p">Paragraph</option>
          <option <?php if ($subtitle_tag == "div") { print "selected"; } ?> value="div">DIV</option>
          <option <?php if ($subtitle_tag == "span") { print "selected"; } ?> value="span">SPAN</option>
		</select>

	

	</div>


<?php if ($prefix != "") { ?>
	<div class="input-group">
  		<span class="input-group-addon detailed-addon"><i class="fa fa-gear fa-fw"></i> <span class='detailed-label'>Text Setting</span></span>
		<select onChange="setSubTitleSetting<?php echo $rand; ?>(this)" class='form-control tt2' title="Text #2 Setting" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__subtitle_setting">
          <option <?php if ($subtitle_setting == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option>
     	  <option <?php if ($subtitle_setting != "default")   { print "selected"; } ?> value="custom"><?php _e('Custom', "i3d-framework"); ?></option>
		</select>
	</div>
 	  
<?php } ?>
	     <div class="input-group subtitle-custom" <?php if ($title_setting == "default") { print 'style="display: none;"'; } ?>>
		 <span class="input-group-addon detailed-addon"><i class="fa fa-font fa-fw"></i> <span class='detailed-label'>Text</span></span>
 		 <textarea placeholder="<?php _e("Example Text", "i3d-framework"); ?>" class='form-control' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__subtitle"><?php echo $subtitle; ?></textarea>
        </div> 

	<?php if (sizeof(I3D_Framework::$animationClasses) > 0) { ?>
	    <div class="input-group title-custom">
		<span class="input-group-addon detailed-addon"><i class="fa fa-font fa-fw"></i> <span class='detailed-label'>Animation </span></span>
		<select onchange="handleSubTitleAnimationChange<?php echo $rand; ?>()" class='form-control tt2' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__subtitle_animation">
          <?php if ($prefix != "") { ?><option <?php if ($subtitle_animation == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option><?php } ?>
          <option value=""><?php _e("No Animation", "i3d-framework"); ?></option>
          <?php foreach (I3D_Framework::$animationClasses as $key => $value) { ?>
		  <option <?php if ($subtitle_animation == $key) { print "selected"; } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
		  <?php } ?>
		</select>
		<select <?php if ($subtitle_animation == "" || strstr($subtitle_animation, "skrollr")) { echo "style='display: none;'"; }  ?> class='form-control tt' title='Animation Delay #2' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__subtitle_animation_delay">
          <option value=""><?php _e("No Delay", "i3d-framework"); ?></option>
          <option <?php if ($subtitle_animation_delay == "delay-250") { print "selected"; } ?> value="delay-250">250ms</option>
          <option <?php if ($subtitle_animation_delay == "delay-500") { print "selected"; } ?> value="delay-500">500ms</option>
          <option <?php if ($subtitle_animation_delay == "delay-750") { print "selected"; } ?> value="delay-750">750ms</option>
          <option <?php if ($subtitle_animation_delay == "delay-1000") { print "selected"; } ?> value="delay-1000">1000ms</option>
          <option <?php if ($subtitle_animation_delay == "delay-1250") { print "selected"; } ?> value="delay-1250">1250ms</option>
		</select>
	    </div>
	<?php } ?>	


<h6 class='text-left'>General</h6>



	<div class="input-group">
  		<span class="input-group-addon detailed-addon"><i class="fa fa-align-left fa-fw"></i> <span class='detailed-label'>Justification</span></span>
		<select  class='form-control tt2' title="Justification" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__justification">
          <?php if ($prefix != "") { ?><option <?php if ($justification == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option><?php } ?>
          <option <?php if ($justification == "left"  || $title_tag == "") { print "selected"; } ?> value="left">Left</option>
          <option <?php if ($justification == "center") { print "selected"; } ?> value="center">Center</option>
          <option <?php if ($justification == "right") { print "selected"; } ?> value="right">Right</option>
		</select>
	</div>	
	
<?php if (sizeof(I3D_Framework::$boxStyles) > 0) { ?>
	<div class="input-group">
  		<span class="input-group-addon detailed-addon"><i class="fa fa-paint-brush fa-fw"></i> <span class='detailed-label'>Box Style</span></span>
		<select  class='form-control tt2' title="Box Style" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__box_style">
          <?php if ($prefix != "") { ?><option <?php if ($box_style == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option><?php } ?>
		<?php foreach (I3D_Framework::$boxStyles as $className => $boxStyle) { ?>
		  <option <?php if (@$box_style == $className) { print "selected"; } ?> value="<?php echo $className; ?>"><?php echo $boxStyle; ?></option>
		<?php } ?>
			</select>
	</div>	
	

	<?php }  ?>

<?php if (sizeof(I3D_Framework::$htmlBoxWidgetLayouts) > 0) { ?>
	<div class="input-group">
  		<span class="input-group-addon detailed-addon"><i class="fa fa-object-ungroup fa-fw"></i> <span class='detailed-label'>Box Layout</span></span>
		<select  class='form-control tt2' title="Box Layout" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__box_layout">
          <?php if ($prefix != "") { ?><option <?php if (@$box_layout == "default")  { print "selected"; } ?> value="default"><?php _e('Layout Default', "i3d-framework"); ?></option><?php } ?>
		 <option <?php if (@$box_layout == "")  { print "selected"; } ?> value=""><?php _e("Default", "i3d-framework"); ?></option>

		<?php foreach (I3D_Framework::$htmlBoxWidgetLayouts as $className => $boxLayout) { ?>
		  <option <?php if (@$box_layout == $className) { print "selected"; } ?> value="<?php echo $className; ?>"><?php echo $boxLayout; ?></option>
		<?php } ?>
			</select>
	</div>	
	

	<?php }  ?>
	
	<script>
	
			function setVectorIcon<?php echo $rand; ?>(selectBox) {
		  if (selectBox.selectedIndex == 2) {
			 jQuery(selectBox).parent().parent().find("div.available-fontawesome-icons").css("display", "inline-block");  
		  } else {
			 jQuery(selectBox).parent().parent().find("div.available-fontawesome-icons").css("display", "none");  
		  }
	   }
	   function setTitleSetting<?php echo $rand; ?>(selectBox) {
		  if (selectBox.selectedIndex == 2) {
			 jQuery(selectBox).parent().parent().find("div.title-custom").css("display", "block");  
		  } else {
			 jQuery(selectBox).parent().parent().find("div.title-custom").css("display", "none");  
		  }
	   }

	   function setSubTitleSetting<?php echo $rand; ?>(selectBox) {
		  if (selectBox.selectedIndex == 2) {
			 jQuery(selectBox).parent().parent().find("div.subtitle-custom").css("display", "block");  
		  } else {
			 jQuery(selectBox).parent().parent().find("div.subtitle-custom").css("display", "none");  
		  }
	   }
	   function setFontAwesomeIcon(div, icon) {
		 jQuery(div).parent().find("div").removeClass("font-awesome-icon-selected");
		 jQuery(div).addClass("font-awesome-icon-selected");
		 //alert(jQuery(div).parent().parent().html());
		 jQuery(div).parent().parent().find("#<?php echo $this->get_field_id('font_awesome_icon'); ?>").val(icon);
	   }
	   
	function handleTitleAnimationChange<?php echo $rand; ?>(selectBox) {
		if (jQuery("select[name='<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__title_animation']").val() == "" || jQuery("select[name='<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__title_animation']").val().search("skrollr") > -1 ) { 
			jQuery("select[name='<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__title_animation_delay']").css("display", "none");

		} else {
			jQuery("select[name='<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__title_animation_delay']").css("display", "inline");	
			//jQuery("#<?php echo $this->get_field_id('title'); ?>").css("width", "95%");
			
		}
}


	function handleSubTitleAnimationChange<?php echo $rand; ?>(selectBox) {
		if (jQuery("select[name='<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__subtitle_animation']").val() == "" || jQuery("select[name='<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__subtitle_animation']").val().search("skrollr") > -1 ) { 
			jQuery("select[name='<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__subtitle_animation_delay']").css("display", "none");

		} else {
			jQuery("select[name='<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__subtitle_animation_delay']").css("display", "inline");	
			
		}
}


	function handleVectorIconAnimationChange<?php echo $rand; ?>(selectBox) {
		if (jQuery("select[name='<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__vector_icon_animation']").val() == "" || jQuery("select[name='<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__vector_icon_animation']").val().search("skrollr") > -1 ) { 
			jQuery("select[name='<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__vector_icon_animation_delay']").css("display", "none");

		} else {
			jQuery("select[name='<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__vector_icon_animation_delay']").css("display", "inline");	
			
		}
}

	</script>
	<?php
	
	
	}



	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array('box_layout' => '',
															'box_style' => '',
															
															'vector_icon' => '',
															'vector_icon_animation' => '', 
															'vector_icon_animation_delay' => '',
															
															'title' => '', 
															'title_tag' => "h3", 
															'title_animation' => '',
															'title_animation_delay' => '',

															'subtitle' => '', 
															'subtitle_tag' => "h3", 
															'subtitle_class' => '', 
															'subtitle_animation' => '',
															'subtitle_animation_delay' => '',

															'text' => '', 
															'text_class' => '',
															'text_animation' => '',
															'text_animation_delay' => '',

															'justification' => 'left' ) );		
		
		//$instance['title'] 					= stripslashes( wp_filter_post_kses( addslashes($new_instance['title'])));
		$instance['title'] 					=  $new_instance['title'];
		$instance['title_tag'] 				= $new_instance['title_tag'];
		$instance['title_class'] 			= $new_instance['title_class'];
		$instance['title_animation']   		= $new_instance['title_animation']; 
		$instance['title_animation_delay']	= $new_instance['title_animation_delay']; 

		$instance['subtitle'] 					= $new_instance['subtitle'];
		$instance['subtitle_tag'] 				= $new_instance['subtitle_tag'];
		$instance['subtitle_class'] 			= $new_instance['subtitle_class'];
		$instance['subtitle_animation']   		= $new_instance['subtitle_animation']; 
		$instance['subtitle_animation_delay']	= $new_instance['subtitle_animation_delay']; 

		$instance['vector_icon']  					= $new_instance['vector_icon']; 
		$instance['vector_icon_animation']   		= $new_instance['vector_icon_animation']; 
		$instance['vector_icon_animation_delay'] 	= $new_instance['vector_icon_animation_delay']; 
		
		//$instance['text'] 					= stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
		$instance['text'] 					= $new_instance['text']; // wp_filter_post_kses() disabled as it was filtering out <input> html tags December 22, 2014
		$instance['text_class']   			= $new_instance['text_class']; 
		$instance['text_animation']   		= $new_instance['text_animation']; 
		$instance['text_animation_delay'] 	= $new_instance['text_animation_delay']; 
		
		$instance['box_layout'] 	= $new_instance['box_layout'];
		$instance['box_style'] 		= $new_instance['box_style'];
		$instance['justification'] 	= $new_instance['justification'];
		//var_dump($instance);
		//exit;
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array('box_layout' => '',
															'box_style' => '',
															
															'vector_icon' => '',
															'vector_icon_animation' => '', 
															'vector_icon_animation_delay' => '',
															
															'title' => '', 
															'title_tag' => "h3", 
															'title_class' => '',
															'title_animation' => '',
															'title_animation_delay' => '',
															
															'subtitle' => '', 
															'subtitle_tag' => "h3", 
															'subtitle_class' => '',
															'subtitle_animation' => '',
															'subtitle_animation_delay' => '',
															
															'text' => '', 
															'text_class' => '',
															'text_animation' => '',
															'text_animation_delay' => '',

															'justification' => 'left' ) );
		$title = format_to_edit($instance['title']);
		$subtitle = format_to_edit($instance['subtitle']);
		$text = format_to_edit($instance['text']);
		$justification = $instance['justification'];
		$rand = rand();
		
?>

<script>

function handleIconChange<?php echo $rand; ?>() {
  	if (jQuery("input[name='<?php echo $this->get_field_name('vector_icon'); ?>']").val() == "") {
		jQuery("#div_<?php echo $this->get_field_id('vector_icon_animation'); ?>").css("display", "none");
		jQuery("#<?php echo $this->get_field_id('vector_icon_animation_delay'); ?>").css("display", "none");
	} else {
		jQuery("#div_<?php echo $this->get_field_id('vector_icon_animation'); ?>").css("display", "inline-block");
		<?php if (sizeof(I3D_Framework::$animationClasses) > 0) { ?>
		if (jQuery("select[name='<?php echo $this->get_field_name('vector_icon_animation'); ?>']").val() == "" || jQuery("select[name='<?php echo $this->get_field_name('vector_icon_animation'); ?>']").val().search("skrollr") > -1) { 
			jQuery("#<?php echo $this->get_field_id('vector_icon_animation_delay'); ?>").css("display", "none");
		} else {
			jQuery("#<?php echo $this->get_field_id('vector_icon_animation_delay'); ?>").css("display", "inline");
		}
		<?php } ?>
	}
}

function handleTitleAnimationChange<?php echo $rand; ?>() {
		if (jQuery("select[name='<?php echo $this->get_field_name('title_animation'); ?>']").val() == "" || jQuery("select[name='<?php echo $this->get_field_name('title_animation'); ?>']").val().search("skrollr") > -1 ) { 
			jQuery("#<?php echo $this->get_field_id('title_animation_delay'); ?>").css("display", "none");
			<?php if (sizeof(I3D_Framework::$htmlBoxWidgetLayouts) > 0) { ?>
			//jQuery("#<?php echo $this->get_field_id('title'); ?>").css("width", "43%");
			<?php } else { ?>
			//jQuery("#<?php echo $this->get_field_id('title'); ?>").css("width", "95%");
			<?php } ?>
		} else {
			jQuery("#<?php echo $this->get_field_id('title_animation_delay'); ?>").css("display", "inline");	
			//jQuery("#<?php echo $this->get_field_id('title'); ?>").css("width", "95%");
			
		}
}


function handleSubTitleAnimationChange<?php echo $rand; ?>() {
		if (jQuery("select[name='<?php echo $this->get_field_name('subtitle_animation'); ?>']").val() == "" || jQuery("select[name='<?php echo $this->get_field_name('subtitle_animation'); ?>']").val().search("skrollr") > -1 ) { 
			jQuery("#<?php echo $this->get_field_id('subtitle_animation_delay'); ?>").css("display", "none");
			<?php if (sizeof(I3D_Framework::$htmlBoxWidgetLayouts) > 0) { ?>
			//jQuery("#<?php echo $this->get_field_id('subtitle'); ?>").css("width", "43%");
			<?php } else { ?>
			//jQuery("#<?php echo $this->get_field_id('subtitle'); ?>").css("width", "95%");
			<?php } ?>
		} else {
			jQuery("#<?php echo $this->get_field_id('subtitle_animation_delay'); ?>").css("display", "inline");	
			//jQuery("#<?php echo $this->get_field_id('subtitle'); ?>").css("width", "95%");
			
		}
}

function handleTextAnimationChange<?php echo $rand; ?>() {

		if (jQuery("select[name='<?php echo $this->get_field_name('text_animation'); ?>']").val() == "" || jQuery("select[name='<?php echo $this->get_field_name('text_animation'); ?>']").val().search("skrollr") > -1) { 
			jQuery("#<?php echo $this->get_field_id('text_animation_delay'); ?>").css("display", "none");
		} else {
			jQuery("#<?php echo $this->get_field_id('text_animation_delay'); ?>").css("display", "inline");
		}
}
</script>
<div class='i3d-widget-container'>
    <div class='i3d-help-region'>
    <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://youtu.be/O6pWvXLc40g"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>
    </div>
<div class='i3d-widget-main-large'>

	<div class='widget-section'>
	<label class='label-regular' for="<?php echo $this->get_field_id('icon'); ?>"><?php _e('Icon', "i3d-framework"); ?></label>
	<div style='display: inline-block; vertical-align: top;'>
		<div style='padding-left: 3px; font-size: 8px; margin-top: -8px;'><?php _e('icon', "i3d-framework"); ?></div>

	<?php I3D_Framework::renderFontAwesomeSelect($this->get_field_name('vector_icon'), @$instance['vector_icon'], false, __('-- No Icon --', "i3d-framework"), __('-- No Icon --', "i3d-framework"), "handleIconChange{$rand}();"); ?>
	</div>
	<?php if (sizeof(I3D_Framework::$animationClasses) > 0) { ?>
	    <div style=' <?php if ($instance['vector_icon'] == "") { echo "display: none;"; } else { ?>display: inline-block;<?php } ?> vertical-align: top;' id="div_<?php echo $this->get_field_id('vector_icon_animation'); ?>">
		<div style='padding-left: 3px; font-size: 8px; margin-top: -8px;'><?php _e('animation', "i3d-framework"); ?></div>
		<select onchange="handleIconChange<?php echo $rand; ?>()"  class='input-medium-sm' id="<?php echo $this->get_field_id('vector_icon_animation'); ?>" name="<?php echo $this->get_field_name('vector_icon_animation'); ?>">
          <option value=""><?php _e("No Animation", "i3d-framework"); ?></option>
          <?php foreach (I3D_Framework::$animationClasses as $key => $value) { ?>
		  <option <?php if ($instance['vector_icon_animation'] == $key) { print "selected"; } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
		  <?php } ?>
		</select>
		<select <?php if ($instance['vector_icon'] == "" || $instance['vector_icon_animation'] == "") { echo "style='display: none;'"; }  ?> class='input-small' id="<?php echo $this->get_field_id('vector_icon_animation_delay'); ?>" name="<?php echo $this->get_field_name('vector_icon_animation_delay'); ?>">
          <option value=""><?php _e("No Delay", "i3d-framework"); ?></option>
          <option <?php if ($instance['vector_icon_animation_delay'] == "delay-250") { print "selected"; } ?> value="delay-250">250ms</option>
          <option <?php if ($instance['vector_icon_animation_delay'] == "delay-500") { print "selected"; } ?> value="delay-500">500ms</option>
          <option <?php if ($instance['vector_icon_animation_delay'] == "delay-750") { print "selected"; } ?> value="delay-750">750ms</option>
          <option <?php if ($instance['vector_icon_animation_delay'] == "delay-1000") { print "selected"; } ?> value="delay-1000">1000ms</option>
          <option <?php if ($instance['vector_icon_animation_delay'] == "delay-1250") { print "selected"; } ?> value="delay-1250">1250ms</option>
		</select>
	</div>
	<?php } ?>	
	</div>
	
	
	<div class='widget-section'>
	<label class='label-regular' for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title',"i3d-framework"); ?></label>
		<input style='width: 95%' id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />

	    <div style='display: inline-block'>
		<div style='padding-left: 3px; font-size: 8px; margin-top: -8px;'><?php _e('importance', "i3d-framework"); ?></div>

	<select style='display: inline-block' class='input-mini'  id="<?php echo $this->get_field_id('title_tag'); ?>" name="<?php echo $this->get_field_name('title_tag'); ?>">
          <option value="h1">H1</option>
          <option <?php if ($instance['title_tag'] == "h2") { print "selected"; } ?> value="h2">H2</option>
          <option <?php if ($instance['title_tag'] == "h3" || $instance['title_tag'] == "") { print "selected"; } ?> value="h3">H3</option>
          <option <?php if ($instance['title_tag'] == "h4") { print "selected"; } ?> value="h4">H4</option>
          <option <?php if ($instance['title_tag'] == "h5") { print "selected"; } ?> value="h5">H5</option>
        </select>
		</div>
 	<?php if (sizeof(I3D_Framework::$headerClasses) > 0) { ?>
	    <div style='display: inline-block'>
		<div style='padding-left: 3px; font-size: 8px; margin-top: -8px;'><?php _e('style', "i3d-framework"); ?></div>
		<select class='input-small' id="<?php echo $this->get_field_id('title_class'); ?>" name="<?php echo $this->get_field_name('title_class'); ?>">
          <option value=""><?php _e("Default", "i3d-framework"); ?></option>
          <?php foreach (I3D_Framework::$headerClasses as $key => $value) { ?>
		  <option <?php if ($instance['title_class'] == $key) { print "selected"; } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
		  <?php } ?>
		</select>
		</div>
	<?php } ?>	

	<?php if (sizeof(I3D_Framework::$animationClasses) > 0) { ?>
	    <div style='display: inline-block'>
		<div style='padding-left: 3px; font-size: 8px; margin-top: -8px;'><?php _e('animation', "i3d-framework"); ?></div>
		<select onchange="handleTitleAnimationChange<?php echo $rand; ?>()" class='input-medium-sm' id="<?php echo $this->get_field_id('title_animation'); ?>" name="<?php echo $this->get_field_name('title_animation'); ?>">
          <option value=""><?php _e("No Animation", "i3d-framework"); ?></option>
          <?php foreach (I3D_Framework::$animationClasses as $key => $value) { ?>
		  <option <?php if ($instance['title_animation'] == $key) { print "selected"; } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
		  <?php } ?>
		</select>
		<select <?php if ($instance['title_animation'] == "" || strstr($instance['title_animation'], "skrollr")) { echo "style='display: none;'"; }  ?> class='input-small' id="<?php echo $this->get_field_id('title_animation_delay'); ?>" name="<?php echo $this->get_field_name('title_animation_delay'); ?>">
          <option value=""><?php _e("No Delay", "i3d-framework"); ?></option>
          <option <?php if ($instance['title_animation_delay'] == "delay-250") { print "selected"; } ?> value="delay-250">250ms</option>
          <option <?php if ($instance['title_animation_delay'] == "delay-500") { print "selected"; } ?> value="delay-500">500ms</option>
          <option <?php if ($instance['title_animation_delay'] == "delay-750") { print "selected"; } ?> value="delay-750">750ms</option>
          <option <?php if ($instance['title_animation_delay'] == "delay-1000") { print "selected"; } ?> value="delay-1000">1000ms</option>
          <option <?php if ($instance['title_animation_delay'] == "delay-1250") { print "selected"; } ?> value="delay-1250">1250ms</option>
		</select>
	    </div>
	<?php } ?>	
       
	</div>
	
	
	<div class='widget-section'>
	<label class='label-regular' for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Subtitle',"i3d-framework"); ?></label>
		<input style='width: 95%' id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo esc_attr($subtitle); ?>" />

	    <div style='display: inline-block'>
		<div style='padding-left: 3px; font-size: 8px; margin-top: -8px;'><?php _e('importance', "i3d-framework"); ?></div>

	<select style='display: inline-block' class='input-mini'  id="<?php echo $this->get_field_id('subtitle_tag'); ?>" name="<?php echo $this->get_field_name('subtitle_tag'); ?>">
          <option value="h1">H1</option>
          <option <?php if ($instance['subtitle_tag'] == "h2") { print "selected"; } ?> value="h2">H2</option>
          <option <?php if ($instance['subtitle_tag'] == "h3" || $instance['title_tag'] == "") { print "selected"; } ?> value="h3">H3</option>
          <option <?php if ($instance['subtitle_tag'] == "h4") { print "selected"; } ?> value="h4">H4</option>
          <option <?php if ($instance['subtitle_tag'] == "h5") { print "selected"; } ?> value="h5">H5</option>
        </select>
		</div>
 	<?php if (sizeof(I3D_Framework::$headerClasses) > 0) { ?>
	    <div style='display: inline-block'>
		<div style='padding-left: 3px; font-size: 8px; margin-top: -8px;'><?php _e('style', "i3d-framework"); ?></div>
		<select class='input-small' id="<?php echo $this->get_field_id('subtitle_class'); ?>" name="<?php echo $this->get_field_name('subtitle_class'); ?>">
          <option value=""><?php _e("Default", "i3d-framework"); ?></option>
          <?php foreach (I3D_Framework::$headerClasses as $key => $value) { ?>
		  <option <?php if ($instance['subtitle_class'] == $key) { print "selected"; } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
		  <?php } ?>
		</select>
		</div>
	<?php } ?>	

	<?php if (sizeof(I3D_Framework::$animationClasses) > 0) { ?>
	    <div style='display: inline-block'>
		<div style='padding-left: 3px; font-size: 8px; margin-top: -8px;'><?php _e('animation', "i3d-framework"); ?></div>
		<select onchange="handleSubTitleAnimationChange<?php echo $rand; ?>()" class='input-medium-sm' id="<?php echo $this->get_field_id('subtitle_animation'); ?>" name="<?php echo $this->get_field_name('subtitle_animation'); ?>">
          <option value=""><?php _e("No Animation", "i3d-framework"); ?></option>
          <?php foreach (I3D_Framework::$animationClasses as $key => $value) { ?>
		  <option <?php if ($instance['subtitle_animation'] == $key) { print "selected"; } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
		  <?php } ?>
		</select>
		<select <?php if ($instance['subtitle_animation'] == "" || strstr($instance['subtitle_animation'], "skrollr")) { echo "style='display: none;'"; }  ?> class='input-small' id="<?php echo $this->get_field_id('subtitle_animation_delay'); ?>" name="<?php echo $this->get_field_name('title_animation_delay'); ?>">
          <option value=""><?php _e("No Delay", "i3d-framework"); ?></option>
          <option <?php if ($instance['subtitle_animation_delay'] == "delay-250") { print "selected"; } ?> value="delay-250">250ms</option>
          <option <?php if ($instance['subtitle_animation_delay'] == "delay-500") { print "selected"; } ?> value="delay-500">500ms</option>
          <option <?php if ($instance['subtitle_animation_delay'] == "delay-750") { print "selected"; } ?> value="delay-750">750ms</option>
          <option <?php if ($instance['subtitle_animation_delay'] == "delay-1000") { print "selected"; } ?> value="delay-1000">1000ms</option>
          <option <?php if ($instance['subtitle_animation_delay'] == "delay-1250") { print "selected"; } ?> value="delay-1250">1250ms</option>
		</select>
	    </div>
	<?php } ?>	
       
	</div>
	
		
        <div class='widget-section'>
	
	<label class='label-regular' for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text', "i3d-framework"); ?></label>
			<textarea style='width: 96% ' cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

	<div style='display: inline-block'>
		<div style='padding-left: 3px; font-size: 8px; margin-top: -8px;'><?php _e('style', "i3d-framework"); ?></div>
		<select class='input-small' id="<?php echo $this->get_field_id('text_class'); ?>" name="<?php echo $this->get_field_name('text_class'); ?>">
          <option value=""><?php _e("Default", "i3d-framework"); ?></option>
          <?php if (I3D_Framework::$paragraphClasses == 0) { ?>
		  <option <?php if ($instance['text_class'] == "lead") { print "selected"; } ?> value="lead"><?php _e("Lead", "i3d-framework"); ?></option>
		  <?php } 
		  foreach (I3D_Framework::$paragraphClasses as $key => $value) { ?>
		  <option <?php if ($instance['text_class'] == $key) { print "selected"; } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
		  <?php } ?>
          
		  
		</select>
	</div>
	<?php if (sizeof(I3D_Framework::$animationClasses) > 0) { ?>
	<div style='display: inline-block'>
		<div style='padding-left: 3px; font-size: 8px; margin-top: -8px;'><?php _e('animation', "i3d-framework"); ?></div>
		<select onchange="handleTextAnimationChange<?php echo $rand; ?>()" class='input-medium-sm' id="<?php echo $this->get_field_id('text_animation'); ?>" name="<?php echo $this->get_field_name('text_animation'); ?>">
          <option value=""><?php _e("No Animation", "i3d-framework"); ?></option>
          <?php foreach (I3D_Framework::$animationClasses as $key => $value) { ?>
		  <option <?php if ($instance['text_animation'] == $key) { print "selected"; } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
		  <?php } ?>
		</select>
		<select <?php if ($instance['text_animation'] == "" || strstr($instance['text_animation'], "skrollr")) { echo "style='display: none;'"; }  ?> class='input-small' id="<?php echo $this->get_field_id('text_animation_delay'); ?>" name="<?php echo $this->get_field_name('text_animation_delay'); ?>">
          <option value=""><?php _e("No Delay", "i3d-framework"); ?></option>
          <option <?php if ($instance['text_animation_delay'] == "delay-250") { print "selected"; } ?> value="delay-250">250ms</option>
          <option <?php if ($instance['text_animation_delay'] == "delay-500") { print "selected"; } ?> value="delay-500">500ms</option>
          <option <?php if ($instance['text_animation_delay'] == "delay-750") { print "selected"; } ?> value="delay-750">750ms</option>
          <option <?php if ($instance['text_animation_delay'] == "delay-1000") { print "selected"; } ?> value="delay-1000">1000ms</option>
          <option <?php if ($instance['text_animation_delay'] == "delay-1250") { print "selected"; } ?> value="delay-1250">1250ms</option>
		</select>
	</div>
	<?php } ?>	

        </div>
		
<div class='widget-section'>
	<?php if (sizeof(I3D_Framework::$boxStyles) > 0) { ?>
	<div class='widget-column-33'>
	<label class='label-regular' for="<?php echo $this->get_field_id('box_style'); ?>"><?php _e('Box Style', "i3d-framework"); ?></label>
	<select style='width: 100%' id="<?php echo $this->get_field_id('box_style'); ?>" name="<?php echo $this->get_field_name('box_style'); ?>">
	<?php foreach (I3D_Framework::$boxStyles as $className => $boxStyle) { ?>
	  <option <?php if (@$instance['box_style'] == $className) { print "selected"; } ?> value="<?php echo $className; ?>"><?php echo $boxStyle; ?></option>
	<?php } ?>
			</select> 
			</div>
	<?php }  ?>
<?php if (sizeof(I3D_Framework::$htmlBoxWidgetLayouts) > 0) { ?>
  <div class='widget-column-33'>
        <!-- box layouts -->
		<label class='label-regular' for="<?php echo $this->get_field_id('box_layout'); ?>"><?php _e('Layout', "i3d-framework"); ?></label>
		<select style='width: 100%;' id="<?php echo $this->get_field_id('title_tag'); ?>" name="<?php echo $this->get_field_name('box_layout'); ?>">
          <option value=""><?php _e("Default", "i3d-framework"); ?></option>
          <?php foreach (I3D_Framework::$htmlBoxWidgetLayouts as $key => $value) { ?>
		  <option <?php if ($instance['box_layout'] == $key) { print "selected"; } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
		  <?php } ?>
		</select>
	</div>
<?php } ?>        
		<div class='widget-column-33'>

        <!-- justification -->
        <label class='label-regular' for="<?php echo $this->get_field_id('justification'); ?>"><?php _e('Justification', "i3d-framework"); ?></label>
		<select style='width: 100%' id="<?php echo $this->get_field_id('justification'); ?>" name="<?php echo $this->get_field_name('justification'); ?>">
          <option <?php if ($justification == "left") { print "selected"; } ?> value="left"><?php _e('Left', "i3d-framework"); ?></option>
          <option <?php if ($justification == "center") { print "selected"; } ?> value="center"><?php _e('Center', "i3d-framework"); ?></option>
     	  <option <?php if ($justification == "right") { print "selected"; } ?> value="right"><?php _e('Right', "i3d-framework"); ?></option>
        </select> 
    </div>

		
</div>	
        
        </div>
        </div>
		<script>
		<?php if (sizeof(I3D_Framework::$animationClasses) > 0) { ?>
		 handleTitleAnimationChange<?php echo $rand; ?>();
		 handleTextAnimationChange<?php echo $rand; ?>();
		 <?php } ?>
/*		 
jQuery("textarea#<?php echo $this->get_field_id('text'); ?>").keyup(function(e) {
    while(jQuery(this).outerHeight() < this.scrollHeight + parseFloat(jQuery(this).css("borderTopWidth")) + parseFloat(jQuery(this).css("borderBottomWidth"))) {
        jQuery(this).height(jQuery(this).height()+1);
    };
});		
*/
		 </script>

<?php
	}
}


?>
<?php

/***********************************/
/**        Featured Post  BOX        **/
/***********************************/
class I3D_Widget_SocialMediaIconShortcuts extends WP_Widget {
	function __construct() {
	//function I3D_Widget_SocialMediaIconShortcuts() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Displays a list of linked social media icons.', "i3d-framework") );
		parent::__construct('i3d_social_icon_shortcuts', __('i3d:Social Media Icons', "i3d-framework"), $widget_ops);
	}

	function widget( $args, $instance ) {
		//var_dump($instance);
		extract( $args );
		$generalSettings = get_option('i3d_general_settings');
		global $page_id;
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'box_style' => '', 'title_icon' => '', 'icon_size' => '', 'justification' => '', 'max_icons' => '', 'version' => ''  ) );
//var_dump($instance);

		if ((isset($instance['status']) && $instance['status'] != "x")) {
		  //print "should try to output all";	
		  foreach ($generalSettings as $key => $value) {
			if (strstr($key, "social_media_")) { 
			$newKey = "social_icon__".str_replace("social_media_", "", str_replace("_url", "", $key));
			$instance["{$newKey}"] = $value;
			//print $newKey."<br>";
			}
		  }
		}	
		//print "status: ".$instance['status'];
		if (I3D_Framework::use_global_layout()) {	
//print $page_id;
			$page_layouts 		= (array)get_post_meta($page_id, "layouts", true);
			$layout_id 	= get_post_meta($page_id, "selected_layout", true);
			$row_id = @$instance['row_id'];
			$widget_id = @$instance['widget_id'];
			if ($widget_id != "") { 
		//var_dump($page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]);
	        $l_icon_size 		= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["icon_size"];
	        $l_version			= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["version"];
	        $l_justification	= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["justification"];
	        $l_box_style			= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["box_style"];
			
			if ($l_icon_size != "default" && sizeof(@$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]) > 0 ) {
			   $instance['icon_size'] = $l_icon_size;
			}
			if ($l_version != "default" && $l_version != "") {
			   $instance['version'] = $l_version;
			}
			if ($l_justification != "default" && $l_justification != "") {
			   $instance['justification'] = $l_justification;
			}
			if ($l_box_style != "default" && $l_box_style != "") {
			  //$text = $l_text;
			}		
			}
			if (@sizeof(@$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]) > 0) {
			  foreach (	$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"] as $k => $v) {
				if (strstr($k, "social_icon__") && $v != "default") {
				  	$instance["{$k}"] = $v;
				//	print "$k = $v <br>";
				}
			  }
			}
		}
		//var_dump($instance);
		echo $before_widget;
		//$pageData = get_page($pageID);
		// footer_social

		
		//print "test";
		$iconSize = $instance['icon_size'];
		//print $iconSize;
		
		
		if (I3D_Framework::$socialMediaIconVersion >= "2" && $instance['version'] == "2") {
		  if ($iconSize == "-m") {
			  $iconSize = "large"; 
		  } else if ($iconSize == "-s") {
			  $iconSize = "1x";
		  } else {
			  $iconSize = "large";
		  }
		}
		
		
		if ($instance['version'] == "owl") { ?>
	<div class='social-icon-wrapper'>
	  <div class="owl-carousel-social-icons social-icon owl-carousel">
		<?php
     		foreach ($instance as $key => $value) {
			//print $iconCount."<br>";
			if (strstr($key, "social_icon__") && $value == 1) {
				$sm = str_replace("social_icon__", "", $key);
				
				?>
        <!-- slide -->
        <div class="item">
            <div class="thumb-social-icon">
                <a href="<?php if ($sm == "rss") {
					echo site_url()."/?feed=rss2";
					} else {
					echo $generalSettings["social_media_{$sm}_url"];
					}?>">
				<?php 
				
												$sm = str_replace("googleplus", "google-plus", $sm);
				$title = ucwords(str_replace("-", " ", str_replace("-plus", "", $sm)));
?>
                    <i class="fa fa-<?php echo $sm; ?>-square fa-4x"></i>
                </a>
                <h4>
                    <?php echo $title; ?>
                </h4>
                <p>
                   
                </p>
            </div>
        </div>
        <!--slide -->
<?php }
			}
			?>



    </div>
	</div>		
			<?php
			
		} else {
		
		$justification = $instance['justification'];
		  echo "<div class='";
		  if ($justification == "right") {
			  echo "pull-right text-left";
		  } else if ($justification == "center") {
			  echo " text-center";
		  } else {
			  echo " text-left";
		  }
		  if (I3D_Framework::$socialMediaIconVersion >= "4") {
			echo " social-icons";  
		  }
		  echo "'";
		  echo ">";
		  echo "<div class='i3d-widget-socialmediaicons social-icon-fontawesome";

		  		  echo "'";
		  echo ">";
		  $title = $instance['title'];
			 if ($instance['title_icon'] != "") { 
			   $title = "<i class='fa ".I3D_Framework::conditionFontAwesomeIcon($instance['title_icon'])."'></i> ".$title;
			 }

		  if ($title != "") {
			if (strstr($instance['title_tag'], ".")) {
			  $classData = explode(".", $instance['title']);
			  $instance['title_tag'] = $classData[0];
			  array_push($classData);
			  $class = implode(".", $classData);
			  $before_title = str_replace(">", " class='{$class}'>", $before_title);
			} else {
				$class = "";
			}
			echo str_replace("h3", $instance['title_tag'], $before_title);
			echo $title;
			echo str_replace("h3", $instance['title_tag'], $after_title);

		  }
		
		if (I3D_Framework::$socialMediaIconVersion == "6" && $instance['version'] == "2") { 
				  echo "<ul>";
				}
		$iconCount = 0;
		//print $instance['max_icons'];
		//var_dump($instance);
		foreach ($instance as $key => $value) {
			//print $iconCount."<br>";
			if (strstr($key, "social_icon__") && $value == 1) {
		  	
				
				$sm = str_replace("social_icon__", "", $key);
			//	$sm = str_replace("googleplus", "google-plus", $sm);
				

				if (@array_key_exists("social_media_{$sm}_url", $generalSettings) && $generalSettings["social_media_{$sm}_url"] != "") {
 			$iconCount++;
			  if (isset($instance['max_icons']) && $instance['max_icons'] > 0 && $iconCount > $instance['max_icons']) {
				break;
			  }		
			    if (I3D_Framework::$socialMediaIconVersion == "5" && $instance['version'] == "2") { 
				echo "<div>"; 
				} else if (I3D_Framework::$socialMediaIconVersion == "6" && $instance['version'] == "2") { 
				  echo "<li>";
				}
				?><a target="_blank" href="<?php echo $generalSettings["social_media_{$sm}_url"]; ?>"><?php 
				if (I3D_Framework::$socialMediaIconVersion == "2" && $instance['version'] == "2") { 
				  if ($sm == "googleplus") {
					  $sm = "google-plus";
				  } else if ($sm == "rss") {
				  }
				  
				  if (I3D_Framework::$bootstrapVersion == "3" && I3D_Framework::$fontAwesomeVersion > 3) { 
				  ?><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="<?php if (I3D_Framework::$fontAwesomeVersion == "3") { ?>icon-<?php echo $sm; ?> icon-<?php echo $iconSize; ?><?php } else { ?>fa fa-<?php print $sm; ?> fa-stack-1x fa-inverse<?php } ?>"></i></span><?php
				  } else { 
				  ?><span class="icon-stack"><i class="icon-circle icon-stack-base"></i><i class="icon-<?php echo $sm; ?> icon-<?php echo $iconSize; ?>"></i></span><?php
				  }
				} else if (I3D_Framework::$socialMediaIconVersion >= 3 && $instance['version'] == "2") { 
								  if ($sm == "googleplus") {
					  $sm = "google-plus";
				  } else if ($sm == "rss") {
				  }

				?><i class="fa fa-<?php print $sm; ?> fa-fw fa-<?php echo ($iconSize == "1x" ? "1x" : "2x"); ?>"></i><?php

				} else { 
				?><img alt="<?php echo $sm; ?>" src="<?php echo get_template_directory_uri() ; ?>/Site/icons/images/fc-webicon-<?php echo $sm.$iconSize; ?>.png"><?php
				}?></a><?php
				 if (I3D_Framework::$socialMediaIconVersion == "5" && $instance['version'] == "2") { 
					echo "</div>"; 
				} else if (I3D_Framework::$socialMediaIconVersion == "6" && $instance['version'] == "2") { 
				  echo "</li>";
				}

			} else if ($sm == "rss") { 
						    if (I3D_Framework::$socialMediaIconVersion == "5" && $instance['version'] == "2") { 
								echo "<div>"; 
							} else if (I3D_Framework::$socialMediaIconVersion == "6" && $instance['version'] == "2") { 
				  echo "<li>";
							}

			?><a target="_blank" href="<?php echo site_url(); ?>/?feed=rss2"><?php
                if (I3D_Framework::$socialMediaIconVersion == "2" && $instance['version'] == "2") { 
				  
				  
				?><span class="icon-stack"><i class="icon-circle icon-stack-base "></i><i class="icon-<?php echo $sm; ?> icon-<?php echo $iconSize; ?>"></i></span><?php
				} else if (I3D_Framework::$socialMediaIconVersion >= 3 && $instance['version'] == "2") { 
								  if ($sm == "googleplus") {
					  $sm = "google-plus";
				  } else if ($sm == "rss") {
				  }

				?><i class="fa fa-<?php print $sm; ?> fa-fw fa-<?php echo ($iconSize == "1x" ? "1x" : "2x"); ?>"></i><?php

				
				} else { 
				
				?><img alt="<?php echo $sm; ?>" src="<?php echo get_template_directory_uri() ; ?>/Site/icons/images/fc-webicon-<?php echo $sm.$iconSize; ?>.png"><?php
				}?></a><?php 
									    if (I3D_Framework::$socialMediaIconVersion == "5" && $instance['version'] == "2") { echo "</div>"; }else if (I3D_Framework::$socialMediaIconVersion == "6" && $instance['version'] == "2") { 
				  echo "</li>";
				}
			}
			} 
			}
		}
		
		if (I3D_Framework::$socialMediaIconVersion == "6" && $instance['version'] == "2") { 
				  echo "</ul>";
				}

           		print "</div>";
           		print "</div>";

	
       
		echo $after_widget;
	}


	function layout_configuration_form( $instance, $defaults, $row_id, $widget_id, $layout_id, $page_level = false ) {
		$generalSettings = get_option('i3d_general_settings');
		//var_dump($defaults);
	  $defaults =  wp_parse_args( (array) $defaults, array( 'icon_size' => '-m', 'title_icon' => '', 'title' => '', 'justification' => ''  ) );
	  
	  $instance =  wp_parse_args( (array) $instance, array( 'icon_size' => $defaults['icon_size'], 'title_icon' => '', 'title' => $defaults['title'],  'title_tag' => @$defaults['title_tag'],  'justification' => $defaults['justification'], 'version' => @$defaults['version'], 'social_icon__facebook' => @$defaults['social_icon__facebook'], 'social_icon__youtube' => @$defaults['social_icon__youtube'], 'social_icon__rss' => @$defaults['social_icon__rss'], 'social_icon__twitter' => @$defaults['social_icon__twitter']  ) );
	  global $post;
	  global $i3dTextLogoLines;
//var_dump($defaults);
	  $layouts = get_option('i3d_layouts');
	  if ($page_level) {
		
		  $prefix = "__i3d_layouts__{$layout_id}__";
			$page_layouts 		= (array)get_post_meta($post->ID, "layouts", true);
			$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"] =  wp_parse_args( (array) @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"], array( 'text' => "*",'title' => "*",'title_tag' => "*", 'show_icon' => '*', 'margin' => '*', 'justification' => '*', 'icon_size' => '*', 'version' => "*" ) );
	        $text = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["text"];
	        $margin = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["margin"];
	        $icon_size = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["icon_size"];
	        $show_icon = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["show_icon"];
	        $justification	 = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["justification"];
	        $version	 = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["version"];
			
						
			//if ( !isset() ) { $font_awesome_icon = ""; } else { $font_awesome_icon = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]['vector_icon']; }
			$layoutID = $layout_id;
	  } else {
		//  global $layoutID;
		//  var_dump($instance);
		  $prefix = "";
		if ( !isset($instance['icon_size']) )   { $icon_size = $defaults['icon_size']; } else { $icon_size = $instance['icon_size']; }
		if ( !isset($instance['version']) ) 	{ $version = $defaults['versuion']; } else { $version = $instance['version']; }
		//$margin = strip_tags($instance['margin']);

		$justification = strip_tags($instance['justification']);

	  }
	  $rand = rand();
	
      ?>


  
	<div class="input-group  tt2" title="Title Tag">
  		<span class="input-group-addon detailed-addon"><i class="fa fa-font fa-fw"></i> <span class='detailed-label'>Title Tag</span></span>
	  <select class='form-control'  name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__title_tag">
 <?php if ($page_level) { ?><option <?php if ($show_icon == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option> <?php } ?>
		
          <option value="h1">H1</option>
          <option <?php if ($instance['title_tag'] == "h2") { print "selected"; } ?> value="h2">H2</option>
          <option <?php if ($instance['title_tag'] == "h3" || $instance['title_tag'] == "") { print "selected"; } ?> value="h3">H3</option>
          <option <?php if ($instance['title_tag'] == "h4") { print "selected"; } ?> value="h4">H4</option>
          <option <?php if ($instance['title_tag'] == "h5") { print "selected"; } ?> value="h5">H5</option>
          <option <?php if ($instance['title_tag'] == "span") { print "selected"; } ?> value="span">SPAN</option>
          <option <?php if ($instance['title_tag'] == "span.hidden-xs") { print "selected"; } ?> value="span">SPAN (Hidden on Mobile)</option>
        </select>
	</div>

	<div class="input-group  tt2"  title="Title" >
  		<span class="input-group-addon detailed-addon"><i class="fa fa-font fa-fw"></i> <span class='detailed-label'>Title</span></span>
	  <input type='text'  class='form-control'  name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__title" value="<?php echo $instance['title']; ?>"/>
	</div>
	<?php if (I3D_Framework::$socialMediaIconVersion >= 2) { ?>
	<div class="input-group  tt2" title="Icon Style"> 
  		<span class="input-group-addon detailed-addon"><i class="fa fa-eye fa-fw"></i> <span class='detailed-label'>Icon Style</span></span>
	  <select class='form-control'  name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__version">
 		<?php if ($page_level) { ?><option <?php if ($show_icon == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option> <?php } ?>
		
          <option <?php if (@$version == "" || $version == "1") { print "selected"; } ?> value="1"><?php _e('Bitmap Icons', "i3d-framework"); ?></option>
          <option <?php if (@$version == "2")  { print "selected"; } ?> value="2"><?php _e('Vector Icons', "i3d-framework"); ?></option>
 <?php if (I3D_Framework::$owlCarouselSocialMediaVersion > 0) { ?>
           <option <?php if (@$version == "owl")  { print "selected"; } ?> value="owl"><?php _e('Owl Carousel', "i3d-framework"); ?></option>

 <?php } ?>      
	  </select>
	</div>	
	<?php } ?>  
		
	<div class="input-group  tt2" title="Icon Size">
  		<span class="input-group-addon detailed-addon"><i class="fa fa-eye fa-fw"></i> <span class='detailed-label'>Icon Size</span></span>
	  <select class='form-control'  name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__icon_size">
 <?php if ($page_level) { ?><option <?php if ($show_icon == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option> <?php } ?>
		
          <option <?php if ($icon_size == "-s") { print "selected"; } ?> value="-s"><?php _e('Small', "i3d-framework"); ?> (20x20)</option>
          <option <?php if ($icon_size == "-m")  { print "selected"; } ?> value="-m"><?php _e('Medium', "i3d-framework"); ?>  (30x30)</option>
     	  <option <?php if ($icon_size == "")   { print "selected"; } ?> value=""><?php _e('Large', "i3d-framework"); ?>  (48x48)</option>
       
	  </select>
	</div>

	
   



	

	<div class="input-group">
  		<span class="input-group-addon detailed-addon"><i class="fa fa-align-left fa-fw"></i> <span class='detailed-label'>Alignment</span></span>
	  <select class='form-control tt2' title="Justification" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__justification">
 <?php if ($prefix != "") { ?>
          <option <?php if ($justification == "default") { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option>
 
 <?php } ?>
          <option <?php if ($justification == "left") { print "selected"; } ?> value="left"><?php _e('Left', "i3d-framework"); ?></option>
          <option <?php if ($justification == "center") { print "selected"; } ?> value="center"><?php _e('Center', "i3d-framework"); ?></option>
     	  <option <?php if ($justification == "right") { print "selected"; } ?> value="right"><?php _e('Right', "i3d-framework"); ?></option>
	  </select>
	</div>

               <ul>
              <?php foreach ($generalSettings as $key => $value) { 
			    if (strstr($key, "social_media_") && $value != "") {
					$sm = str_replace("social_media_", "", $key);
					$sm = str_replace("_url", "", $sm);
					$didRSS = ($sm == "rss");
					?>
                <li style='width: 60px; display: inline-block;'>
				<label for="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__social_media_icon__<?php echo $sm; ?>"><?php echo ucwords($sm);?></label>
				<select style='vertical-align: top; margin-top: 3px; margin-right: 5px;' id="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__social_media_icon__<?php echo $sm; ?>" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__social_media_icon__<?php echo $sm; ?>">
				<?php if ($page_level) { ?>
				<option value="default">Default</option>
				<?php } ?>
				<option value="0" <?php if (($page_level && @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["social_icon__{$sm}"] == "0") || (!$page_level && @$instance["social_icon__{$sm}"] == "0")) { echo "selected"; } ?>>Off</option>
				<option value="1" <?php if (($page_level && @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["social_icon__{$sm}"] == "1") || (!$page_level && @$instance["social_icon__{$sm}"] == "1")) { echo "selected"; } ?>>On</option></select></li>  
				   
                <?php } 
			  }
			  if (!$didRSS) {
			  ?>   
                <li style='width: 60px; display: inline-block;'><label for="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__social_media_icon__rss">RSS</label>
				<select  style='vertical-align: top; margin-top: 3px; margin-right: 5px;' id="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__social_media_icon__rss" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__social_media_icon__rss" />
				<?php if ($page_level) { ?>
				<option value="default">Default</option>
				<?php } ?>
				<option value="0" <?php if (($page_level && @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["social_icon__{$sm}"] == "0") || (!$page_level && @$instance["social_icon__{$sm}"] == "0")) { echo "selected"; } ?>>Off</option><option value="1" <?php if (($page_level && @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["social_icon__rss"] == "1") || (!$page_level && @$instance["social_icon__rss"] == "1")) { echo "selected"; } ?>>On</option></select></li>       
               <?php } ?>
             </ul>          
  
	  <?php
	}

	public static function getPageInstance($pageID, $defaults = array()) {
		$instance        = $defaults;
		$new_instance    = array();
		//$generalSettings = get_option('i3d_general_settings');
        
		$instance['status'] 			= get_post_meta($pageID, "i3d_social_media_icons_settings", true);
        
		return $instance;
	}

	function update( $new_instance, $old_instance ) {
	//	$instance = $old_instance;
		$instance = array();

		$instance['title'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['title'])));
		$instance['title_icon'] = $new_instance['title_icon'];
		$instance['title_tag'] = $new_instance['title_tag'];
		$instance['icon_size'] = strip_tags($new_instance['icon_size']);
		$instance['justification'] = strip_tags($new_instance['justification']);
		$instance['version'] = $new_instance['version'];
		
		foreach ($new_instance as $key => $value) {
			if (strstr($key, "social_media_icon__")) {
				$sm = str_replace("social_media_icon__", "", $key);
			    $instance["social_icon__$sm"] = $value;
			}
		}
			
		return $instance;
	}

	function form( $instance ) {
		$generalSettings = get_option('i3d_general_settings');
		global $templateName;
		
		$instance = wp_parse_args( (array) $instance, array( 'icon_size' => '-m', 'title_icon' => '', 'title' => '', 'justification' => '' ) );
		$title = format_to_edit(@$instance['title']);
		$templateName2 = str_replace(' ', '_', ucwords($templateName));
		$icon_size = $instance['icon_size'];
		$justification = $instance['justification'];
				$random = rand();

?>
        


<div class='i3d-widget-container'>
    <div class='i3d-help-region'>
    	<div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://www.youtube.com/watch?v=iVpQLb4gO10"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>
    </div>

	<div class='widget-section'>

		<label class='label-regular' for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', "i3d-framework"); ?></label>
		
		<select style='display: inline-block' class='input-mini'  id="<?php echo $this->get_field_id('title_tag'); ?>" name="<?php echo $this->get_field_name('title_tag'); ?>">
          <option value="h1">H1</option>
          <option <?php if ($instance['title_tag'] == "h2") { print "selected"; } ?> value="h2">H2</option>
          <option <?php if ($instance['title_tag'] == "h3" || $instance['title_tag'] == "") { print "selected"; } ?> value="h3">H3</option>
          <option <?php if ($instance['title_tag'] == "h4") { print "selected"; } ?> value="h4">H4</option>
          <option <?php if ($instance['title_tag'] == "h5") { print "selected"; } ?> value="h5">H5</option>
        </select>
		
		<?php I3D_Framework::renderFontAwesomeSelect($this->get_field_name('title_icon'), @$instance['title_icon'], false, __('-- No Icon --', "i3d-framework")); ?>

		
		<input style='width: 40%' id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		
		
	</div>

<div class='widget-section'>
<?php if (I3D_Framework::$socialMediaIconVersion >= 2) { ?>
<div class='widget-column-33'>
        <label class='label-regular' for="<?php echo $this->get_field_id('version'); ?>"><?php _e('Style', "i3d-framework"); ?></label>
		<select style='width: 100%'  onchange='selectSocialMedialType<?php echo $random; ?>(this)' id="<?php echo $this->get_field_id('version'); ?>" name="<?php echo $this->get_field_name('version'); ?>">
          <option <?php if (@$instance['version'] == "") { print "selected"; } ?> value=""><?php _e('Bitmap Icons', "i3d-framework"); ?></option>
          <option <?php if (@$instance['version'] == "2")  { print "selected"; } ?> value="2"><?php _e('Vector Icons', "i3d-framework"); ?></option>
 <?php if (I3D_Framework::$owlCarouselSocialMediaVersion > 0) { ?>
           <option <?php if (@$instance['version'] == "owl")  { print "selected"; } ?> value="owl"><?php _e('Owl Carousel', "i3d-framework"); ?></option>

 <?php } ?>      
        </select>
</div>


<?php } ?> 

<div class='widget-column-33'>
<div class='social_media_icons_size_container'  <?php if (@$instance['version'] != "") { ?>style='display: none;' <?php } ?>>
        <label class='label-regular' for="<?php echo $this->get_field_id('icon_size'); ?>"><?php _e('Icon Size', "i3d-framework"); ?></label>
		<select style='width: 100%' id="<?php echo $this->get_field_id('icon_size'); ?>" name="<?php echo $this->get_field_name('icon_size'); ?>">
          <option <?php if ($icon_size == "-s") { print "selected"; } ?> value="-s"><?php _e('Small', "i3d-framework"); ?> (20x20)</option>
          <option <?php if ($icon_size == "-m")  { print "selected"; } ?> value="-m"><?php _e('Medium', "i3d-framework"); ?>  (30x30)</option>
     	  <option <?php if ($icon_size == "")   { print "selected"; } ?> value=""><?php _e('Large', "i3d-framework"); ?>  (48x48)</option>
        </select>
</div>     
        </div>
        <!-- justification -->
		      <div class='widget-column-33'>
<div class='social_media_icons_justification_container'  <?php if (@$instance['version'] == "owl") { ?>style='display: none;' <?php } ?>>
  
        <label class='label-regular' for="<?php echo $this->get_field_id('justification'); ?>"><?php _e('Justification', "i3d-framework"); ?></label>
		<select style='width: 100%' id="<?php echo $this->get_field_id('justification'); ?>" name="<?php echo $this->get_field_name('justification'); ?>">
          <option <?php if ($justification == "left") { print "selected"; } ?> value="left"><?php _e('Left', "i3d-framework"); ?></option>
          <option <?php if ($justification == "center") { print "selected"; } ?> value="center"><?php _e('Center', "i3d-framework"); ?></option>
     	  <option <?php if ($justification == "right") { print "selected"; } ?> value="right"><?php _e('Right', "i3d-framework"); ?></option>
        </select> 
		</div>
</div>
</div>
<div class='widget-section'>

<p>If you don't see your social media service listed below, make sure to add your social media account on the <a href="admin.php?page=<?php echo $templateName2; ?>-settings&tab=tabs-general&subtab=social">settings page</a>.</p>

              <ul>
              <?php foreach ($generalSettings as $key => $value) { 
			    if (strstr($key, "social_media_") && $value != "") {
					$sm = str_replace("social_media_", "", $key);
					$sm = str_replace("_url", "", $sm);
					$didRSS = ($sm == "rss");
					?>
                <li style='width: 60px; display: inline-block;'><input style='vertical-align: top; margin-top: 3px; margin-right: 5px;' type="checkbox" id="<?php echo $this->get_field_id("social_media_icon__{$sm}__{$random}"); ?>" name="<?php echo $this->get_field_name("social_media_icon__{$sm}"); ?>" value="1" <?php if (@$instance["social_icon__{$sm}"] == "1") { echo "checked"; } ?> /><label for="<?php echo $this->get_field_id("social_media_icon__{$sm}__{$random}"); ?>"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-<?php echo $sm; ?>-s.png" /></label></li>       
                <?php } 
			  }
			  if (!$didRSS) {
			  ?>   
                <li style='width: 60px; display: inline-block;'><input style='vertical-align: top; margin-top: 3px; margin-right: 5px;' type="checkbox" id="<?php echo $this->get_field_id("social_media_icon__rss__{$random}"); ?>" name="<?php echo $this->get_field_name("social_media_icon__rss"); ?>" value="1" <?php if (@$instance["social_icon__rss"] == "1") { echo "checked"; } ?> /><label for="<?php echo $this->get_field_id("social_media_icon__rss__{$random}"); ?>"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-rss-s.png" /></label></li>       
               <?php } ?>
             </ul>          

			</div>
		   </div>
		   <script>
		   function selectSocialMedialType<?php echo $random; ?>(selectBox){
			   if (selectBox.options[selectBox.selectedIndex].value == "") {
				   jQuery(selectBox).parents(".i3d-widget-container").find(".social_media_icons_size_container").css("display", "block");
			   } else {
				   
				   jQuery(selectBox).parents(".i3d-widget-container").find(".social_media_icons_size_container").css("display", "none");
				   
			   }
			   
			   if (selectBox.options[selectBox.selectedIndex].value == "owl") {
				   jQuery(selectBox).parents(".i3d-widget-container").find(".social_media_icons_justification_container").css("display", "none");
			   } else {
				   
				   jQuery(selectBox).parents(".i3d-widget-container").find(".social_media_icons_justification_container").css("display", "block");
				   
			   }
			   
		   }
		   </script>
<?php
	}
}
?>
<?php

/***********************************/
/**        HTML WIDGET BOX        **/
/***********************************/
class I3D_Widget_InfoBoxSlider extends WP_Widget {
	function __construct() {
	//function I3D_Widget_InfoBoxSlider() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Renders a slider that references a sidebar containing info boxes.', "i3d-framework") );
		$control_ops = array('width' => "400px");
		parent::__construct('i3d_infobox_slider', __('i3d:Info Box Slider', "i3d-framework"), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		
		//$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
		//$title = I3D_Framework::conditionFontAwesomeIcon($instance['title']);
		//$text = apply_filters( 'widget_text', $instance['text'], $instance );
		//$justification = $instance['justification'];
		$sidebarWidgets = wp_get_sidebars_widgets();
		$sidebarWidgets = $sidebarWidgets["{$instance['sidebar']}"];
		$infoboxWidgets = array();
		foreach ($sidebarWidgets as $index => $widgetid) {
		  if (strstr($widgetid, "i3d_infobox-")) {
			  $infoboxWidgets[] = $widgetid;
		  }
		}
		$totalWidgets = count($infoboxWidgets);
		$maxWidgetsPerPanel = $instance['columns'];
		$totalPanels = ceil($totalWidgets/$maxWidgetsPerPanel);
		echo $before_widget;
	
		if (I3D_Framework::$infoBoxSliderVersion == 1) {
			wp_enqueue_style( 'info-box-slider-css',     get_stylesheet_directory_uri()."/Library/components/info-box-carousel/css/info-box-carousel.css");
		
			echo "<div class='i3d-widget-infobox-slider info-box-carousel-wrapper";
		  	echo "'";
		  	echo ">";
		  

		  ?><div id="articleCarousel" class="carousel slide">
						<ol class="carousel-indicators">
							<?php for ($i = 0; $i < $totalPanels; $i++) { ?>
							<li <?php if ($i == 0) { echo 'class="active"'; } ?> data-slide-to="<?php echo $i; ?>" data-target="#articleCarousel"></li>
							<?php } ?>
						</ol>
			
			<!-- Carousel items -->
			<div class="carousel-inner">
            <?php 
			  $panelCount = 0;
			  $widgetCount = 0;
               $doingOpening = false;
			   $infoBox = new I3D_Widget_InfoBox();
			   $infoBoxSettings = $infoBox->get_settings();
			   $colSpan = 12 / $maxWidgetsPerPanel;
				//print "total $totalWidgets <br>";
				foreach ($infoboxWidgets as $widgetid) {
						//
                  
				  if ($widgetCount % $maxWidgetsPerPanel  == 0) {
					  if ($widgetCount > 0) {
					  ?>
                      </div>
                      </div>
                      <?php } ?>
                    <div class="item <?php if ($widgetCount == 0) { ?>active<?php } ?>">
                      <div class='row'>
                   <?php } ?>
                   <div class="col-sm-<?php echo $colSpan; ?> col-xs-12">
                  <?php 
				  $theId = str_replace("i3d_infobox-", "", $widgetid);
				  //print $widgetid;
				  //var_dump($infoBoxSettings["{$theId}"]);
				  the_widget( 'I3D_Widget_InfoBox', $infoBoxSettings["{$theId}"]);
				   ?>
                   </div>
                   <?php
				   $widgetCount++;
				}
				print "</div></div>";
		  
		  ?>
          
          			</div>
			<!--/carousel-inner-->
			<a class="left article-carousel carousel-control" data-slide="prev" href="#articleCarousel"></a>
			<a class="right article-carousel carousel-control" data-slide="next" href="#articleCarousel"></a>
			
			<!--
		</div>
	</div>-->
</div>
<script>
      !function (jQuery) {
        jQuery(function(){
          // carousel demo
          jQuery('#articleCarousel').carousel({ interval: 8000 })
        })
      }(window.jQuery)
    </script>
<?php
		echo "</div>";
		
		} else if (I3D_Framework::$infoBoxSliderVersion == 2) {
			?><div id='ibc' class='carousel slide' data-bottom-top='transform: scale(.75)' data-center-top='transform: scale(1)' data-center-bottom='transform: scale(1)' data-top-bottom='transform: scale(.75)'><ol class="carousel-indicators"><?php
			if ($totalPanels > 1) { 
				for ($i = 0; $i < $totalPanels; $i++) { 
				?><li <?php if ($i == 0) { echo 'class="active"'; } ?> data-slide-to="<?php echo $i; ?>" data-target="#ibc"></li><?php 
				} 
			} 
			?></ol><div class="carousel-inner"><?php 
					$panelCount = 0;
					$widgetCount = 0;
					$doingOpening = false;
					$infoBox = new I3D_Widget_InfoBox();
					$infoBoxSettings = $infoBox->get_settings();
					$colSpan = 12 / $maxWidgetsPerPanel;
					foreach ($infoboxWidgets as $widgetid) {

						if ($widgetCount % $maxWidgetsPerPanel == 0) {
							if ($widgetCount > 0) { 
							  print "</div></div>";
							} 
							?><div class="item <?php if ($widgetCount == 0) { ?>active<?php } ?>"><div class='row'><?php 
							} 
							?><div class="col-sm-<?php echo $colSpan; ?> col-xs-12"><?php 
				  $theId = str_replace("i3d_infobox-", "", $widgetid);
											$infoBoxSettings["{$theId}"]['position'] = ($widgetCount % 4) +1;
				  
				  the_widget( 'I3D_Widget_InfoBox', $infoBoxSettings["{$theId}"]);
				   ?></div><?php
				   $widgetCount++;
				}
				print "</div></div>";
		  
		  		?></div><?php 
				if ($widgetCount > $maxWidgetsPerPanel) { ?><a class="left article-carousel carousel-control" data-slide="prev" href="#ibc"></a><a class="right article-carousel carousel-control" data-slide="next" href="#ibc"></a><?php } 
				?></div>
<script>
!function (jQuery) {
jQuery(function(){
	jQuery('#ibc').carousel({ interval: 8000 });
	jQuery('#ibc').parents(".content-wrapper").addClass("ibc-section");
})
}(window.jQuery)
</script><?php
		} else if (I3D_Framework::$infoBoxSliderVersion == 3) {
			?><div id='index-box-carousel' class='carousel slide' data-skrolr="index-box-carousel"><ol class="carousel-indicators"><?php
			if ($totalPanels > 1) { 
				for ($i = 0; $i < $totalPanels; $i++) { 
				?><li <?php if ($i == 0) { echo 'class="active"'; } ?> data-slide-to="<?php echo $i; ?>" data-target="#ibc"></li><?php 
				} 
			} 
			?></ol><div class="carousel-inner"><?php 
					$panelCount = 0;
					$widgetCount = 0;
					$doingOpening = false;
					$infoBox = new I3D_Widget_InfoBox();
					$infoBoxSettings = $infoBox->get_settings();
					$colSpan = 12 / $maxWidgetsPerPanel;
					foreach ($infoboxWidgets as $widgetid) {

						if ($widgetCount % $maxWidgetsPerPanel == 0) {
							if ($widgetCount > 0) { 
							  print "</div></div>";
							} 
							?><div class="item <?php if ($widgetCount == 0) { ?>active<?php } ?>"><div class='row'><?php 
							} 
							?><div class="col-sm-<?php echo $colSpan; ?> col-xs-12"><?php 
				  $theId = str_replace("i3d_infobox-", "", $widgetid);
											$infoBoxSettings["{$theId}"]['position'] = ($widgetCount % 4) +1;
				  
				  the_widget( 'I3D_Widget_InfoBox', $infoBoxSettings["{$theId}"]);
				   ?></div><?php
				   $widgetCount++;
				}
				print "</div></div>";
		  
		  		?></div><?php 
				if ($widgetCount > $maxWidgetsPerPanel) { ?><a class="left article-carousel carousel-control" data-slide="prev" href="#index-box-carousel"></a><a class="right article-carousel carousel-control" data-slide="next" href="#index-box-carousel"></a><?php } 
				?></div>
<script>
!function (jQuery) {
jQuery(function(){
	jQuery('#index-box-carousel').carousel({ interval: 8000 });
	//jQuery('#ibc').parents(".content-wrapper").addClass("ibc-section");
})
}(window.jQuery)
</script><?php
		}
		
		echo $after_widget;
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
																									array('sidebar' => "default", 
																										  'columns' => '' 
																										 ) );
			
			$sidebar = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]['sidebar'];
	        $columns = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["columns"];
									
			$layoutID = $layout_id;
	  } else {
		  $prefix = "";
		if ( !isset($instance['sidebar']) )   { $sidebar = "default"; } else { $sidebar = $instance['sidebar']; }
		if ( !isset($instance['columns']) )   { $columns = "default"; } else { $columns = $instance['columns']; }

	  }
	  $rand = rand();
		 $sidebarWidgets = wp_get_sidebars_widgets();
		 //var_dump($sidebarWidgets);
		 global $i3dSupportedSidebars;
	  
	//  print $box_layout." -- ".$box_style."<br>";
?>
<h6 class='text-left'>Sidebar Containing Info Boxes</h6>
         <div title="Sidebar" class='vector-icons tt2'>
         <div class='input-group'>
  		<span class="input-group-addon detailed-addon"><i class="fa fa-columns fa-fw"></i> <span class='detailed-label'>Sidebar</span></span>
        <!-- Font Awesome Icons --> 

		<select class='form-control tt2' id="<?php echo $this->get_field_id('sidebar'); ?>"  name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__sidebar">
          <?php
		  $renderedOption = false;
		  $lmSidebars = get_option('i3d_sidebar_options');
		  foreach ($sidebarWidgets as $sidebarx => $widgetids) {
			 $infoBoxCount = 0;
			// print $sidebar;
			if (is_array($widgetids)) {
			 foreach ($widgetids as $widgetid) {
				// print $widgetid."\n";
				if (strstr($widgetid, "i3d_infobox-")) {
					//print "have one\n";
					$infoBoxCount++;
				}
			 }
			}
			 if ($infoBoxCount > 0) {
				 $renderedOption = true;
				 $infoBoxName = $i3dSupportedSidebars["$sidebarx"]["name"];
				 if ($infoBoxName == "") {
					 $infoBoxName = $lmSidebars["$sidebarx"];
				 }
				 ?>
           <option <?php if ($sidebarx == $sidebar) { print "selected"; } ?> value="<?php echo $sidebarx; ?>"><?php echo $infoBoxName." ({$infoBoxCount})"; ?></option>     
                 <?php 
			 }
		  } 
		  ?>
        </select> 
		</div>
		</div>
<h6 class='text-left'>Columns Per Section</h6>
         <div title="Sidebar" class='vector-icons tt2'>
         <div class='input-group'>
  		<span class="input-group-addon detailed-addon"><i class="fa fa-columns fa-fw"></i> <span class='detailed-label'>Columns</span></span>
        <!-- Font Awesome Icons --> 
		<select class='form-control tt2' id="<?php echo $this->get_field_id('columns'); ?>"  name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__columns">
            <?php
		  for ($i = 1; $i <=4; $i++) { 
				 ?>
           <option <?php if ($i == $columns || ($i == 4 && $columns == "")) { print "selected"; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>     
                 <?php 
	
		  } 
		  ?>

        </select> 
		</div>
		</div>		
	<?php
	
	
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['columns'] = $new_instance['columns'];
		$instance['sidebar'] = $new_instance['sidebar'];
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
?>

<script>

jQuery("a.widget-action").bind("click", function() {
			//	shrinkVideoRegion(this);									

});
 
jQuery("a.widget-control-close").bind("click", function() {
				//shrinkVideoRegion(this);									

});
</script>
<div class='i3d-widget-container'>
    <div class='i3d-help-region'>
    <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://youtu.be/lfK0On8QkDQ"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>
   <!-- <div class='i3d-help-region-opened i3d-help-region-hidden'>
    <div class='i3d-help-title-bar'>Hide <i class='icon-chevron-right'></i></div>
<iframe width="420" height="315" src="//www.youtube.com/embed/PbIcN7UeQ4s" frameborder="0" allowfullscreen></iframe>
    </div>-->
    </div>
<div class='i3d-widget-main-large'>
<p>Choose the sidebar that contains 2 or more info boxes.  If no options are provided, it means you have not yet set up a sidebar containing those info boxes.</p>
        <p>
        <?php
		 $sidebarWidgets = wp_get_sidebars_widgets();
		 global $i3dSupportedSidebars;
		 //var_dump($sidebarWidgets);
		 ?>
<p>
        <label class='label-100' for="<?php echo $this->get_field_id('columns'); ?>"><?php _e('Columns:',"i3d-framework"); ?></label>
		<select style='margin-bottom: 0px;' id="<?php echo $this->get_field_id('columns'); ?>" name="<?php echo $this->get_field_name('columns'); ?>">
          <?php
		  for ($i = 1; $i <=4; $i++) { 
				 ?>
           <option <?php if ($i == $instance['columns'] || ($i == 4 && $instance['columns'] == "")) { print "selected"; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>     
                 <?php 
	
		  } 
		  ?>
        </select> 
   </p>     

        <!-- region -->
        <label  class='label-100' for="<?php echo $this->get_field_id('sidebar'); ?>"><?php _e("Sidebar:","i3d-framework"); ?></label>
		<select style='margin-bottom: 0px;' id="<?php echo $this->get_field_id('sidebar'); ?>" name="<?php echo $this->get_field_name('sidebar'); ?>">
          <?php
		  $renderedOption = false;
		  $lmSidebars = get_option('i3d_sidebar_options');
		  foreach ($sidebarWidgets as $sidebar => $widgetids) {
			 $infoBoxCount = 0;
			// print $sidebar;
			 foreach ($widgetids as $widgetid) {
				// print $widgetid."\n";
				if (strstr($widgetid, "i3d_infobox-")) {
					//print "have one\n";
					$infoBoxCount++;
				}
			 }
			 if ($infoBoxCount > 0) {
				 $renderedOption = true;
				 $infoBoxName = $i3dSupportedSidebars["$sidebar"]["name"];
				 if ($infoBoxName == "") {
					 $infoBoxName = $lmSidebars["$sidebar"];
				 }
				 ?>
           <option <?php if ($sidebar == $instance['sidebar']) { print "selected"; } ?> value="<?php echo $sidebar; ?>"><?php echo $infoBoxName." ({$infoBoxCount})"; ?></option>     
                 <?php 
			 }
		  } 
		  ?>
        </select> 
        </p>
        </div>
        </div>
<?php
	}
}


?>
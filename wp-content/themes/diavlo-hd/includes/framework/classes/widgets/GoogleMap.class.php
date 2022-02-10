<?php

/***********************************/
/**        HTML WIDGET BOX        **/
/***********************************/
class I3D_Widget_GoogleMap extends WP_Widget {
	function __construct() {
	//function I3D_Widget_GoogleMap() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Render google map.', "i3d-framework") );
		$control_ops = array();
		parent::__construct('i3d_googlemap', __('i3d:Google Map', "i3d-framework"), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		
		$map_location = $instance['map_location'];
		$justification = $instance['justification'];
		echo $before_widget;
		  echo "<div class='i3d-widget-googlemap";
		  if ($justification == "right") {
			  echo " pull-right text-right";
		  } else if ($justification == "center") {
			  echo " text-center";
		  } else {
			  echo " text-left";
		  }
		  echo "'";
		  echo ">";
		if ( !empty( $title ) ) { echo $before_title;
		  if ($instance['vector_icon'] != "") {
			  echo "<i class='";
			  if (strstr($instance['vector_icon'], "fa-")) {
				  echo "fa ";
			  }
			  echo $instance['vector_icon'];
			  echo "'></i> ";
		  }
		echo $title . $after_title; }
		//$map_location = urlencode($map_location);
		//$map_location =str_replace(" ", "+", $map_location);
		?>
        <?php
		$widgetRand = rand();
  $mapData = array();
  $mapData['primary_location'] = $map_location;
  $mapData['type'] = "roadmap";
  $mapData['markers'] = array(array('location' => $map_location, "label" => ""));
  $mapData['markerinfo'] = "hide";
  $mapData['zoom'] = 14;

    if ($mapData['markerinfo'] == "show") {
		$showMarkersHTML = ",oneInfoWindow:false";
	} else {
		$showMarkersHTML = "";
	}
	$markerHTML = "";
    if (is_array($mapData['markers'])) {
	  foreach ($mapData['markers'] as $markerData) {
		  if ($markerData['location'] != "") {
			  $markerHTML .= '{address:\''.$markerData['location'].'\'';
			  if ($markerData['label'] != "") {
				  $markerHTML .= ',html:{content:\''.str_replace(" ", "&nbsp;", $markerData['label']).'\',popup:'.($mapData['markerinfo'] == "hide" ? 'false' : 'true' ).'}';
			  }
			  $markerHTML .= '},';
		  }
	  }
	}
	if ($markerHTML != "") {
		$markerHTML = ",markers:[{$markerHTML}]";
	}
	
	wp_enqueue_script('aquila-google-maps');
	wp_enqueue_script('aquila-gomap');
	global $usesGoogleMaps;
	$usesGoogleMaps = true;
	//print "yes";
	$widgetRand = "";
	?>

    <script type="text/javascript">
function loadWidgetMap<?php echo $widgetRand; ?>(widgetID) { 
	if (jQuery(widgetID).parents("#contact-panel")) {} else {}
	jQuery(widgetID).goMap({address:'<?php echo $mapData['primary_location']; ?>',maptype:'<?php echo $mapData['type']; ?>',zoom:<?php echo $mapData['zoom']; ?>,scrollwheel:true,scaleControl:true,navigationControl:true<?php echo $markerHTML; ?><?php echo $showMarkersHTML; ?>});
}
jQuery(document).ready(function(){ if (jQuery("#googlemap-widget<?php echo $widgetRand; ?>").parents("#contact-panel").length > 0) {} else { loadWidgetMap<?php echo $widgetRand; ?>("#googlemap-widget<?php echo $widgetRand; ?>");}});
</script>
<div class='contact-google googlemap-widget' id="googlemap-widget<?php echo $widgetRand; ?>"></div><?php
		echo "</div>";
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['map_location'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['map_location'])));
		$instance['justification'] = $new_instance['justification']; // wp_filter_post_kses() expects slashed
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'justification' => '', 'map_location' => '' ) );
		$map_location = format_to_edit(@$instance['map_location']);
		$text = format_to_edit($instance['text']);
		$justification = $instance['justification']; 
?>

<div class='i3d-widget-container'>
    <div class='i3d-help-region'>
      <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://www.youtube.com/watch?v=PbIcN7UeQ4s"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>
    </div>
<div class='i3d-widget-main-large'>
		<p><label style='font-weight: bold; display: block;' for="<?php echo $this->get_field_id('map_location'); ?>"><?php _e('Map Location',"i3d-framework"); ?></label>
		<input class="" id="<?php echo $this->get_field_id('map_location'); ?>" name="<?php echo $this->get_field_name('map_location'); ?>" type="text" value="<?php echo esc_attr($map_location); ?>" /></p>
        <p>
        
        <!-- justification -->
        <label style='font-weight: bold; display: block;' for="<?php echo $this->get_field_id('justification'); ?>"><?php _e('Justification',"i3d-framework"); ?></label>
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
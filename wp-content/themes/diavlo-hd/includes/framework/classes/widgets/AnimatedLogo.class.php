<?php

/***********************************/
/**        Logo WIDGET         **/
/***********************************/
class I3D_Widget_AnimatedLogo extends WP_Widget {
	//function I3D_Widget_AnimatedLogo() {
	function __construct() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'An Animated Website Name Logo for your Intro Page', "i3d-framework") );
		parent::__construct('i3d_animatedlogo', __('i3d:Animated Logo', "i3d-framework"), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );


		
//		$justification = apply_filters( 'widget_title', empty($instance['justification']) ? '' : $instance['justification'], $instance );
//		$text = apply_filters( 'widget_text', $instance['text'], $instance );
		echo $before_widget;
		
		echo '<div class="animated-logo-wrapper">


	<div id="Stage" class="EDGE-202142810">
	</div>

</div>
<script type="text/javascript">
jQuery(".animated-logo-wrapper").parents(".container-wrapper").removeClass("container-wrapper").find(".section-inner").removeClass("section-inner").find(".container").removeClass("container").find(".row").removeClass("row");
</script>
';
		//i3d_render_logo($instance);
		echo $after_widget;
	}

	public static function getPageInstance($pageID, $defaults = array()) {
		$instance = $defaults;
		$new_instance = get_post_meta($pageID, "i3d_logo_settings", true);
		if (!is_array($new_instance)) {
			$new_instance = array();
		}
		$generalSettings = get_option('i3d_general_settings');
		if (array_key_exists("graphic_logo", $new_instance)) {
          $instance['graphic_logo'] 		= $new_instance['graphic_logo'];
		} else {
		  $instance['graphic_logo'] = "";
		}
		
		if ($instance['graphic_logo'] == "x") {
			$instance['graphic_logo'] = "";
		} else if ($instance['graphic_logo'] == "") {
			$instance['graphic_logo'] = "default";
		}
		


        $instance['website_name'] 		= $new_instance['website_name'];
		if ($instance['website_name'] == "x") {
			$instance['website_name'] = "";
		} else if ($instance['website_name'] == "") {
			$instance['website_name'] = "default";
		}
		
		
        $instance['text_1'] 			= $new_instance['text_1'];
        $instance['text_2'] 			= $new_instance['text_2'];
        $instance['tagline'] 		  	= $new_instance['tagline'];
		$instance['tagline_setting']  	= $new_instance['tagline_setting'];
		
		if ($instance['tagline_setting'] == "x") {
			$instance['tagline_setting'] = "";
		} else if ($instance['tagline_setting'] == "") {
			$instance['tagline_setting'] = "default";
		}

		$instance['tagline']       		= strip_tags($new_instance['tagline']);
		
		if ($new_instance['graphic_logo'] != "" && $new_instance['graphic_logo'] != "default") {
			$new_instance['graphic_logo'] = $new_instance['actual_graphic_logo'];
		}
		
		$instance['graphic_logo']  = strip_tags($new_instance['graphic_logo']);
		if ($instance['vector_icon'] == "x") {
			$instance['vector_icon'] = "";
		} else if ($instance['vector_icon'] == "") {
			$instance['vector_icon'] = "default";
		}		
		
		if ($new_instance['vector_icon'] != "" && $new_instance['vector_icon'] != "default") {
			$new_instance['vector_icon'] = $new_instance['font_awesome_icon'];
		}
		
		$instance['vector_icon']  = strip_tags($new_instance['vector_icon']);
		//		var_dump($instance);

		$instance['justification'] = $new_instance['justification'];
		return $instance;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['enter_link'] = strip_tags($new_instance['enter_link']);
		$instance['enter_label'] = strip_tags($new_instance['enter_label']);
		$instance['website_name']  = strip_tags($new_instance['website_name']);
		$instance['primary_tagline']  = strip_tags($new_instance['primary_tagline']);
		$instance['secondary_tagline']        = strip_tags($new_instance['secondary_tagline']);
		$instance['tertiary_tagline']        = strip_tags($new_instance['tertiary_tagline']);
		$instance['est_line']       = strip_tags($new_instance['est_line']);

		$instance['enter_label_text'] = strip_tags($new_instance['enter_label_text']);
		$instance['website_name_text']  = strip_tags($new_instance['website_name_text']);
		$instance['primary_tagline_text']  = strip_tags($new_instance['primary_tagline_text']);
		$instance['secondary_tagline_text']        = strip_tags($new_instance['secondary_tagline_text']);
		$instance['tertiary_tagline_text']        = strip_tags($new_instance['tertiary_tagline_text']);
		$instance['est_line_text']       = strip_tags($new_instance['est_line_text']);

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		
		if ( !isset($instance['enter_label']) )   { $enter_label = "default"; } else { $enter_label = $instance['enter_label']; }
		$enter_label_text = strip_tags($instance['enter_label_text']);
		
		if ( !isset($instance['website_name']) )   { $website_name = "default"; } else { $website_name = $instance['website_name']; }
		$website_name_text = strip_tags($instance['website_name_text']);
		
		if ( !isset($instance['primary_tagline']) ){ $primary_tagline = "default"; } else { $primary_tagline = $instance['primary_tagline']; }
		$primary_tagline_text = strip_tags($instance['primary_tagline_text']);
		
		if ( !isset($instance['secondary_tagline']) ) { $secondary_tagline = "default"; } else { $secondary_tagline = $instance['secondary_tagline']; }
		$secondary_tagline_text = strip_tags($instance['secondary_tagline_text']);
		
		if ( !isset($instance['tertiary_tagline']) ) { $tertiary_tagline = "default"; } else { $tertiary_tagline = $instance['tertiary_tagline']; }
		$tertiary_tagline_text = strip_tags($instance['tertiary_tagline_text']);
		
		if ( !isset($instance['est_line']) ) { $est_line = "default"; } else { $est_line = $instance['est_line']; }
		$est_line_text = strip_tags($instance['est_line_text']);

		$random = rand();

?>

<div class='i3d-widget-container'>
    <div class='i3d-help-region'>
		<div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://www.youtube.com/watch?v=Oow6R0eWd3M"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>
    </div>
<div class='i3d-widget-main'>
        
        
           <br/>
        <label class='label-100' for="<?php echo $this->get_field_id('enter_link'); ?>"><?php _e('Enter Button Link To:',"i3d-framework"); ?></label>
		
        <select id="<?php echo $this->get_field_id('enter_link'); ?>" name="<?php echo $this->get_field_name('enter_link'); ?>">
<?php
$pages = get_pages();
		$selectedImages = array();
foreach ($pages as $pagg) {
  	$option = '<option ';
		if ($pagg->ID == $instance['page']) { 
		  $option .= 'selected ';
		}
		$option .= 'value="'.$pagg->ID.'">';
	$option .= $pagg->post_title;
	$option .= '</option>';
	echo $option;
}
    ?>
                </select> 
      
       
       <script>
	   function setEnterLabelName<?php echo $rand; ?>(selectBox) {
		  if (selectBox.selectedIndex == 2) {
			 jQuery(selectBox).parent().parent().find("div.enter-label-custom").css("display", "block");  
		  } else {
			 jQuery(selectBox).parent().parent().find("div.enter-label-custom").css("display", "none");  
		  }
	   }

	   function setWebsiteName<?php echo $rand; ?>(selectBox) {
		  if (selectBox.selectedIndex == 2) {
			 jQuery(selectBox).parent().parent().find("div.animated-website-name-custom").css("display", "block");  
		  } else {
			 jQuery(selectBox).parent().parent().find("div.animated-website-name-custom").css("display", "none");  
		  }
	   }
	   function setPrimaryTagline<?php echo $rand; ?>(selectBox) {
		  if (selectBox.selectedIndex == 2) {
			 jQuery(selectBox).parent().parent().find("div.primary-tagline-custom").css("display", "block");  
		  } else {
			 jQuery(selectBox).parent().parent().find("div.primary-tagline-custom").css("display", "none");  
		  }
	   }	   
	   function setSecondaryTagline<?php echo $rand; ?>(selectBox) {
		  if (selectBox.selectedIndex == 2) {
			 jQuery(selectBox).parent().parent().find("div.secondary-tagline-custom").css("display", "block");  
		  } else {
			 jQuery(selectBox).parent().parent().find("div.secondary-tagline-custom").css("display", "none");  
		  }
	   }	
	   function setTertiaryTagline<?php echo $rand; ?>(selectBox) {
		  if (selectBox.selectedIndex == 2) {
			 jQuery(selectBox).parent().parent().find("div.tertiary-tagline-custom").css("display", "block");  
		  } else {
			 jQuery(selectBox).parent().parent().find("div.tertiary-tagline-custom").css("display", "none");  
		  }
	   }
	   function setEstLine<?php echo $rand; ?>(selectBox) {
		  if (selectBox.selectedIndex == 2) {
			 jQuery(selectBox).parent().parent().find("div.est-line-custom").css("display", "block");  
		  } else {
			 jQuery(selectBox).parent().parent().find("div.est-line-custom").css("display", "none");  
		  }
	   }
	</script>


        <!-- Text -->
        <label class='label-125' for="<?php echo $this->get_field_id('enter_label'); ?>"><?php _e('Enter Label:', "i3d-framework"); ?></label>
		<select onChange="setEnterLabelName<?php echo $rand; ?>(this)"  id="<?php echo $this->get_field_id('enter_label'); ?>" name="<?php echo $this->get_field_name('enter_label'); ?>">
          <option <?php if ($enter_label == "disabled") { print "selected"; } ?> value="disabled"><?php _e('Disabled', "i3d-framework"); ?></option>
          <option <?php if ($enter_label == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option>
     	  <option <?php if ($enter_label == "custom")   { print "selected"; } ?> value="custom"><?php _e('Custom', "i3d-framework"); ?></option>
        </select>        
         
         <div class="enter-label-custom" <?php if ($enter_label != "custom") { print 'style="display: none;"'; } ?>>
 		 <input class="widefat" id="<?php echo $this->get_field_id('enter_label_text'); ?>" name="<?php echo $this->get_field_name('enter_label_text'); ?>" type="text" value="<?php echo esc_attr($enter_label_text); ?>" />
         </div> 
       
        <!-- Text -->
        <label class='label-125' for="<?php echo $this->get_field_id('website_name'); ?>"><?php _e('Website Name:',  "i3d-framework"); ?></label>
		<select onChange="setWebsiteName(this)"  id="<?php echo $this->get_field_id('website_name'); ?>" name="<?php echo $this->get_field_name('website_name'); ?>">
          <option <?php if ($website_name == "disabled") { print "selected"; } ?> value="disabled"><?php _e('Disabled', "i3d-framework"); ?></option>
          <option <?php if ($website_name == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option>
     	  <option <?php if ($website_name == "custom")   { print "selected"; } ?> value="custom"><?php _e('Custom', "i3d-framework"); ?></option>
        </select>        
         
         <div class="animated-website-name-custom" <?php if ($website_name != "custom") { print 'style="display: none;"'; } ?>>
 		 <input class="widefat" id="<?php echo $this->get_field_id('website_name_text'); ?>" name="<?php echo $this->get_field_name('website_name_text'); ?>" type="text" value="<?php echo esc_attr($website_name_text); ?>" />

        </div> 
          
        

        <!-- primary tagline -->
        <label class='label-125' for="<?php echo $this->get_field_id('primary_tagline'); ?>"><?php _e('Primary Tagline:', "i3d-framework"); ?></label>
		<select onChange="setPrimaryTagline(this)"  id="<?php echo $this->get_field_id('primary_tagline'); ?>" name="<?php echo $this->get_field_name('primary_tagline'); ?>">
          <option <?php if ($primary_tagline == "disabled") { print "selected"; } ?> value="disabled"><?php _e('Disabled', "i3d-framework"); ?></option>
          <option <?php if ($primary_tagline == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option>
     	  <option <?php if ($primary_tagline == "custom")   { print "selected"; } ?> value="custom"><?php _e('Custom', "i3d-framework"); ?></option>
        </select>
         <div class="primary-tagline-custom" <?php if ($primary_tagline != "custom") { print 'style="display: none;"'; } ?>>
                
 		<input class="widefat" id="<?php echo $this->get_field_id('primary_tagline_text'); ?>" name="<?php echo $this->get_field_name('primary_tagline_text'); ?>" type="text" value="<?php echo esc_attr($primary_tagline_text); ?>" /> 
        </div>
        
        <!-- secondary tagline -->
        <label class='label-125' for="<?php echo $this->get_field_id('secondary_tagline'); ?>"><?php _e('Secondary Tagline:', "i3d-framework"); ?></label>
		<select onChange="setSecondaryTagline(this)"  id="<?php echo $this->get_field_id('secondary_tagline'); ?>" name="<?php echo $this->get_field_name('secondary_tagline'); ?>">
          <option <?php if ($secondary_tagline == "disabled") { print "selected"; } ?> value="disabled"><?php _e('Disabled', "i3d-framework"); ?></option>
          <option <?php if ($secondary_tagline == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option>
     	  <option <?php if ($secondary_tagline == "custom")   { print "selected"; } ?> value="custom"><?php _e('Custom', "i3d-framework"); ?></option>
        </select>
         <div class="secondary-tagline-custom" <?php if ($secondary_tagline != "custom") { print 'style="display: none;"'; } ?>>
                
 		<input class="widefat" id="<?php echo $this->get_field_id('secondary_tagline_text'); ?>" name="<?php echo $this->get_field_name('secondary_tagline_text'); ?>" type="text" value="<?php echo esc_attr($secondary_tagline_text); ?>" /> 
        </div>

        <!-- tertiary -->
        <label class='label-125' for="<?php echo $this->get_field_id('tertiary_tagline'); ?>"><?php _e('Tertiary Tagline:', "i3d-framework"); ?></label>
		<select onChange="setTertiaryTagline(this)"  id="<?php echo $this->get_field_id('tertiary_tagline'); ?>" name="<?php echo $this->get_field_name('tertiary_tagline'); ?>">
          <option <?php if ($tertiary_tagline == "disabled") { print "selected"; } ?> value="disabled"><?php _e('Disabled', "i3d-framework"); ?></option>
          <option <?php if ($tertiary_tagline == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option>
     	  <option <?php if ($tertiary_tagline == "custom")   { print "selected"; } ?> value="custom"><?php _e('Custom', "i3d-framework"); ?></option>
        </select>
         <div class="tertiary-tagline-custom" <?php if ($tertiary_tagline != "custom") { print 'style="display: none;"'; } ?>>
                
 		<input class="widefat" id="<?php echo $this->get_field_id('tertiary_tagline_text'); ?>" name="<?php echo $this->get_field_name('tertiary_tagline_text'); ?>" type="text" value="<?php echo esc_attr($tertiary_tagline_text); ?>" /> 
        </div>

        <!-- est line -->
        <label class='label-125' for="<?php echo $this->get_field_id('est_line'); ?>"><?php _e('Est. Line:', "i3d-framework"); ?></label>
		<select onChange="setEstLine(this)"  id="<?php echo $this->get_field_id('est_line'); ?>" name="<?php echo $this->get_field_name('est_line'); ?>">
          <option <?php if ($est_line == "disabled") { print "selected"; } ?> value="disabled"><?php _e('Disabled', "i3d-framework"); ?></option>
          <option <?php if ($est_line == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option>
     	  <option <?php if ($est_line == "custom")   { print "selected"; } ?> value="custom"><?php _e('Custom', "i3d-framework"); ?></option>
        </select>
         <div class="est-line-custom" <?php if ($primary_tagline != "custom") { print 'style="display: none;"'; } ?>>
                
 		<input class="widefat" id="<?php echo $this->get_field_id('est_line_text'); ?>" name="<?php echo $this->get_field_name('est_line_text'); ?>" type="text" value="<?php echo esc_attr($est_line_text); ?>" /> 
        </div>

		</div></div>       

<?php
	}
}


?>
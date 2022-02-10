<?php

/***********************************/
/**        i3d affiliate          **/
/***********************************/
class Luckymarble_Widget_I3DAffiliate extends WP_Widget {
	function __construct() {
	//function Luckymarble_Widget_I3DAffiliate() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Earn a commission on sales made by visitors referred to i3dTHEMES.  This component that displays an i3dTHEMES banner (or text link), that refers your visitors using your affiliate code, to i3dTHEMES.com', "i3d-framework") );
		parent::__construct('lm_i3daffiliate', __('*LM*I3D Affiliate', "i3d-framework"), $widget_ops);
		$this->images = array();
		$this->images["text"]                     = "Text Link";
		$this->images["i3dthemes-130x25-wp.png"]  = "130x25 Micro-Banner";
		$this->images["i3dthemes-130x35-wp.png"]  = "130x35 Micro-Banner 2";
		$this->images["i3dthemes-125x125-wp.png"] = "125x125 Block";
		$this->images["i3dthemes-120x240-wp.png"] = "120x240 Skyscraper";
		$this->images["i3dthemes-465x60-wp.png"]  = "465x60 Banner";
		$this->images["i3dthemes-250x250-wp.png"] = "250x250 Block";
		$this->images["i3dthemes-300x250-wp.png"] = "300x250 Block";
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
	
		$affiliateID = strip_tags($instance['affiliate_id']);
		$imgSrc = "http://www.i3dthemes.com/_images/ref/img/".$instance['img_src'];
		$wrap   = ($instance['wrap'] == 1);
		//echo $before_widget;
		if ($affiliateID != "") {
			$refCode = "?ref={$affiliateID}&source=wordpress_banner";
		} else {
			$refCode = "?source=wordpress_banner";
		}
		if ($wrap) {
		  echo $before_widget."<div style='text-align: center;'>";
		}
		if ($instance['img_src'] == "text") {
			echo "<a class='affiliate-i3d' href='http://www.i3dthemes.com/{$refCode}' target='_blank'>WordPress Themes from i3dTHEMES.com";
			echo "</a>";
			
		} else if ($instance['img_src'] != "") {
			echo "<a class='affiliate-i3d' href='http://www.i3dthemes.com/{$refCode}' target='_blank'>";
			echo "<img src='{$imgSrc}' border='0' alt='WordPress Themes from i3dTHEMES.com' title='WordPress Themes from i3dTHEMES.com' />";
			echo "</a>";
		}
		if ($wrap) {
		  echo "</div>".$after_widget;
		}	
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['affiliate_id'] = strip_tags($new_instance['affiliate_id']);
		$instance['img_src']      = strip_tags($new_instance['img_src']);
		$instance['wrap']         = $new_instance['wrap'] == "1" ? "1" : "0";
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'affiliate_id' => '', 'img_src' => 'i3dthemes-125x125-wp.png' ) );
		$affiliate_id = strip_tags($instance['affiliate_id']);
		$img_src = strip_tags($instance['img_src']);
?>
		<p><label for="<?php echo $this->get_field_id('affiliate_id'); ?>"><?php _e('Affiliate ID:',"i3d-framework"); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('affiliate_id'); ?>" name="<?php echo $this->get_field_name('affiliate_id'); ?>" type="text" value="<?php echo esc_attr($affiliate_id); ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('img_src'); ?>"><?php _e('Image:',"i3d-framework"); ?></label>
    <select class="widefat" id="<?php echo $this->get_field_id('img_src'); ?>" name="<?php echo $this->get_field_name('img_src'); ?>">
    
      <option value=""><?php _e('-- None Selected --',"i3d-framework"); ?></option>
<?php      foreach ($this->images as $imageSrc => $imageDesc) { ?>
      <option <?php if ($img_src == $imageSrc) { print "selected"; } ?> value="<?php echo $imageSrc; ?>"><?php echo $imageDesc; ?></option>
<?php } ?>
    </select></p>
		<p><label for="<?php echo $this->get_field_id('wrap'); ?>"><?php _e('Use Available Wrapper',"i3d-framework"); ?></label>
		<input type='checkbox' id="<?php echo $this->get_field_id('wrap'); ?>" name="<?php echo $this->get_field_name('wrap'); ?>" type="text" value="1" /></p>
    
    
<?php
	}
}

?>
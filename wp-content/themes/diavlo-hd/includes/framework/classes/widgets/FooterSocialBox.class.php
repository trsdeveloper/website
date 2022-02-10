<?php

/***********************************/
/**        Featured Post  BOX        **/
/***********************************/
class I3D_Widget_FooterSocialBox extends WP_Widget {
	function __construct() {
	//function I3D_Widget_FooterSocialBox() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Displays a styled box showing social media buttons.', "i3d-framework") );
		parent::__construct('i3d_footer_social_box', __('i3d:Footer Social Box', "i3d-framework"), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		echo $before_widget;
		//$pageData = get_page($pageID);
		// footer_social
		?>
		<span class='footer_social'>
<h3><?php echo (strip_tags($instance['title'])); ?></h3>
<?php
if ($instance['text'] != "") { 
  $textItems = explode("\n", strip_tags($instance['text']));
  foreach ($textItems as $line) {
	if (trim($line) != "") {
      echo "<p>".trim($line)."</p>";
	}
  }
} ?>
<p style="text-align: center">
<?php if (array_key_exists("facebook", $instance) && $instance['facebook'] != "") {	?><a title="Become our Facebook friend" href="http://www.facebook.com/<?php echo $instance['facebook']; ?>"><img src="<?php get_template_directory_uri(); ?>/Site/graphics/footer_facebook.png" 	class="social_icon" 	style="width: 40px; height: 40px; border-style: solid; border-width: 0px; margin-left: 2px; margin-right: 2px" alt="Be a Friend on Facebook" /></a><?php } ?>
<?php if (array_key_exists("twitter", $instance) && $instance['twitter'] != "") {	?><a title="Follow ME!" 				href="http://www.twitter.com/<?php echo $instance['twitter']; ?>"><img src="<?php get_template_directory_uri(); ?>/Site/graphics/footer_twitter.png" 	class="social_icon" 	style="width: 40px; height: 40px; border-style: solid; border-width: 0px; margin-left: 2px; margin-right: 2px" alt="Get LinkedIN" /></a><?php } ?>
<?php if (array_key_exists("linkedin", $instance) && $instance['linkedin'] != "") {	?><a title="Get LinkedIN" 	 href="http://www.linkedin.com/<?php echo $instance['linkedin']; ?>"><img src="<?php get_template_directory_uri(); ?>/Site/graphics/footer_linkedin.png" 	class="social_icon" 	style="width: 40px; height: 40px; border-style: solid; border-width: 0px; margin-left: 2px; margin-right: 2px" alt="Be a Friend on Facebook" /></a><?php } ?>
<?php if (array_key_exists("myspace", $instance) && $instance['myspace'] != "") {	?><a title="Check out Myspace" href="http://www.myspace.com/<?php echo $instance['myspace']; ?>"><img src="<?php get_template_directory_uri(); ?>/Site/graphics/footer_myspace.png" 	class="social_icon" 	style="width: 40px; height: 40px; border-style: solid; border-width: 0px; margin-left: 2px; margin-right: 2px" alt="MySpace" /></a><?php } ?>
<?php if (array_key_exists("rss", $instance) && $instance['rss'] == 1) {	?><a title="Link to RSS Feed" href="<?php echo site_url(); ?>/?feed=rss2"><img src="<?php get_template_directory_uri(); ?>/Site/graphics/footer_rss.png" 	class="social_icon" 	style="width: 40px; height: 40px; border-style: solid; border-width: 0px; margin-left: 2px; margin-right: 2px" alt="RSS Feeds" /></a><?php } ?>
</p>

            </span>
		<?php
       
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['text'] = strip_tags($new_instance['text']);
		$instance['facebook'] = strip_tags($new_instance['facebook']);
		$instance['twitter'] = strip_tags($new_instance['twitter']);
		$instance['linkedin'] = strip_tags($new_instance['linkedin']);
		$instance['myspace'] = strip_tags($new_instance['myspace']);
		$instance['rss'] = strip_tags($new_instance['rss']);
		return $instance;
	}

	function form( $instance ) {
		$generalSettings = get_option('i3d_general_settings');
		
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Let&#39;s Get Social!', 
															'text' => 'Follow us on Twitter or become our Facebook friend.', 
															'facebook' => $generalSettings['facebook_account'],
															'twitter' => $generalSettings['twitter_account'],
															'linkedin' => $generalSettings['linkedin_account'],
															'myspace' => '',
															'rss' => 0) );
?>
<p>If you leave a field blank, that element will be omitted from the contact box.</p>
		<p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', "i3d-framework"); ?></label>
		<input class='widefat' type="text"  id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo strip_tags($instance['title']); ?>" />
        </p>
		<p>
        <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:', "i3d-framework"); ?></label>
		<textarea class='widefat' id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo strip_tags($instance['text']); ?></textarea>
        </p>

		<p>
        <label  for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook Account:', "i3d-framework"); ?></label>
		<input class='widefat' type="text"  id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" value="<?php echo strip_tags($instance['facebook']); ?>" />
        </p>
		<p>
        <label  for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter Account:', "i3d-framework"); ?></label>
		<input class='widefat' type="text"  id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" value="<?php echo strip_tags($instance['twitter']); ?>" />
        </p>
		<p>
        <label  for="<?php echo $this->get_field_id('linkedin'); ?>"><?php _e('LinkedIn Account:', "i3d-framework"); ?></label>
		<input class='widefat' type="text"  id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" value="<?php echo strip_tags($instance['linkedin']); ?>" />
        </p>
		<p>
        <label  for="<?php echo $this->get_field_id('myspace'); ?>"><?php _e('MySpace Account:', "i3d-framework"); ?></label>
		<input class='widefat' type="text"  id="<?php echo $this->get_field_id('myspace'); ?>" name="<?php echo $this->get_field_name('contact'); ?>" value="<?php echo strip_tags($instance['myspace']); ?>" />
        </p>
		<p>
        <label for="<?php echo $this->get_field_id('rss'); ?>"><?php _e('RSS Feed Icon:', "i3d-framework"); ?></label>
		<select  id="<?php echo $this->get_field_id('rss'); ?>" name="<?php echo $this->get_field_name('rss'); ?>">
          <option value='0'>No</option>
          <option <?php if ($instance['rss'] == 1) { echo "selected='selected'"; } ?> value='1'>Yes</option>
        </select>
        </p>           
<?php
	}
}
?>
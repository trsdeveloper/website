<?php

/***********************************/
/**        Contact BOX		      **/
/***********************************/
class I3D_Widget_FooterContactBox extends WP_Widget {
	function __construct() {
	//function I3D_Widget_FooterContactBox() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Displays a box with contact details', "i3d-framework") );
		parent::__construct('i3d_footer_contact_box', __('i3d:Contact Details Box', "i3d-framework"), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		  $instance = wp_parse_args( (array) $instance, array( 'title_tag' => "h3", 'title_icon' => '', 'title' => '', 'show_field_labels' => '', 'show_field_icons' => '', 'form_email' => '', 'box_style' => "") );
		$before_widget = str_replace("i3d-opt-box-style", $instance['box_style'], $before_widget);

		echo $before_widget;
		global $lmFrameworkVersion;

				$title = I3D_Framework::conditionFontAwesomeIcon($instance['title']);

		//$pageData = get_page($pageID);
		// footer_social
		?>
<div class='i3d-contact-box'>

<?php
if ($title != "") { 
  echo str_replace("h3", $instance['title_tag'], $before_title);

if ($instance['title_icon'] != "") { ?><i class='fa <?php echo I3D_Framework::conditionFontAwesomeIcon($instance['title_icon']);?>'></i> <?php } 

echo $title;
			echo str_replace("h3", $instance['title_tag'], $after_title);

}

if ($instance['text'] != "") { 
  $textItems = explode("\n", strip_tags($instance['text']));
  foreach ($textItems as $line) {
	if (trim($line) != "") {
      echo "<p>".trim($line)."</p>";
	}
  }
} ?>
<ul <?php if ($instance['show_field_labels'] == "1") { ?>style='margin-left: 0px; padding-left: 0px;'<?php } ?>>
<?php if ($instance['address'] != "") {	?><li><?php if ($instance['show_field_labels'] == "1") { ?><p class='lead'><?php _e('Address',"i3d-framework"); ?></p><?php } ?><?php if ($instance['show_field_icons'] == "" || $instance['show_field_icons'] == "1") { ?><i class='<?php if (I3D_Framework::$fontAwesomeVersion >= 3) { echo "fa fa-book"; } else { echo "icon-book"; } ?>'></i> <?php } ?><?php echo $instance['address']; ?></li><?php } ?>
<?php if ($instance['phone'] != "") {	?><li><?php if ($instance['show_field_labels'] == "1") { ?><p class='lead'><?php _e('Phone Number',"i3d-framework"); ?></p><?php } ?><?php if ($instance['show_field_icons'] == "" || $instance['show_field_icons'] == "1") { ?><i class='<?php if (I3D_Framework::$fontAwesomeVersion >= 3) { echo "fa fa-phone"; } else { echo "icon-phone"; } ?>'></i> <?php } ?><?php echo $instance['phone']; ?></li><?php } ?>
<?php if ($instance['email'] != "") {	?><li><?php if ($instance['show_field_labels'] == "1") { ?><p class='lead'><?php _e('Email',"i3d-framework"); ?></p><?php } ?><?php if ($instance['show_field_icons'] == "" || $instance['show_field_icons'] == "1") { ?><i class='<?php if (I3D_Framework::$fontAwesomeVersion >= 3) { echo "fa fa-envelope-o"; } else { echo "icon-envelope-alt"; } ?>'></i> <?php } ?><a href="mailto:<?php echo $instance['email']; ?>"><?php echo $instance['email']; ?></a></li><?php } ?>
<?php if ($instance['contact'] != "") {	?><li><?php if ($instance['show_field_labels'] == "1") { ?><p class='lead'><?php _e('Contact',"i3d-framework"); ?></p><?php } ?><?php if ($instance['show_field_icons'] == "" || $instance['show_field_icons'] == "1") { ?><i class='<?php if (I3D_Framework::$fontAwesomeVersion >= 3) { echo "fa fa-envelope"; } else { echo "icon-envelope"; } ?>'></i> <?php } ?><?php echo $instance['contact']; ?></li><?php } ?>
</ul>
<?php if ($instance['form_email'] != "" && false) { 
	echo luckymarble_contact_form(array('send_to'=>$instance['form_email']));
} ?>		
</div>
<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		//$instance['title'] = $new_instance['title'];
		$instance['title'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['title']) ) ); // wp_filter_post_kses() expects slashed

		$instance['title_icon'] = strip_tags($new_instance['title_icon']);
		
		$instance['title_tag'] = $new_instance['title_tag'] ;
		
		$instance['text'] = strip_tags($new_instance['text']);
		$instance['address'] = strip_tags($new_instance['address']);
		$instance['phone'] = strip_tags($new_instance['phone']);
		$instance['email'] = strip_tags($new_instance['email']);
		$instance['contact'] = strip_tags($new_instance['contact']);
		$instance['box_style'] = strip_tags($new_instance['box_style']);
		$instance['show_field_labels'] = strip_tags($new_instance['show_field_labels']);
		$instance['show_field_icons'] = strip_tags($new_instance['show_field_icons']);
		return $instance;
	}


function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Get In Touch!', 'title_icon' => '', 'title_tag' => '', 'text' => 'Contact Information', 'address' => '123 My St. | Anytime | Anyplace US', 'phone' => '(555) 123-4567' ) );

		//$instance['title'] = apply_filters( 'widget_text', $instance['title'], $instance );
		$instance['title'] = format_to_edit($instance['title']);
		$title = $instance['title'];

?>
<script>

jQuery("a.widget-action").bind("click", function() {
			//	shrinkVideoRegion(this);									

});
 
jQuery("a.widget-control-close").bind("click", function() {
			//	shrinkVideoRegion(this);									

});
</script>
<div class='i3d-widget-container'>
    <div class='i3d-help-region'>
    <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://www.youtube.com/watch?v=meGDMofqpGQ"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>
    </div>
<div>
<div class='i3d-widget-main-large'>
<p>If you leave a field blank, that element will be omitted from the contact box.</p>
		
        <label class='label-regular' for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title',"i3d-framework"); ?></label>
		<select style='display: inline-block' class='input-mini'  id="<?php echo $this->get_field_id('title_tag'); ?>" name="<?php echo $this->get_field_name('title_tag'); ?>">
          <option value="h1">H1</option>
          <option <?php if ($instance['title_tag'] == "h2") { print "selected"; } ?> value="h2">H2</option>
          <option <?php if ($instance['title_tag'] == "h3" || $instance['title_tag'] == "") { print "selected"; } ?> value="h3">H3</option>
          <option <?php if ($instance['title_tag'] == "h4") { print "selected"; } ?> value="h4">H4</option>
          <option <?php if ($instance['title_tag'] == "h5") { print "selected"; } ?> value="h5">H5</option>
        </select>
		
		<?php I3D_Framework::renderFontAwesomeSelect($this->get_field_name('title_icon'), @$instance['title_icon'], false, __('-- No Icon --', "i3d-framework")); ?>
       		<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />

	   <br/>
		<p>
        <label class='label-regular' for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:',"i3d-framework"); ?></label>
		<textarea class='widefat' id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo strip_tags($instance['text']); ?></textarea>
        </p>

		<p>
        <label class='label-regular' for="<?php echo $this->get_field_id('address'); ?>"><?php _e('Address:',"i3d-framework"); ?></label>
		<input class='widefat' type="text"  id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" value="<?php echo strip_tags($instance['address']); ?>" />
        </p>
		<p>
        <label class='label-regular' for="<?php echo $this->get_field_id('address'); ?>"><?php _e('Phone:',"i3d-framework"); ?></label>
		<input class='widefat' type="text"  id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" value="<?php echo strip_tags($instance['phone']); ?>" />
        </p>
		<p>
        <label class='label-regular' for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Email:',"i3d-framework"); ?></label>
		<input class='widefat' type="text"  id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" value="<?php echo strip_tags($instance['email']); ?>" />
        </p>
		<p>
        <label class='label-regular'  for="<?php echo $this->get_field_id('contact'); ?>"><?php _e('Contact:',"i3d-framework"); ?></label>
		<input class='widefat' type="text"  id="<?php echo $this->get_field_id('contact'); ?>" name="<?php echo $this->get_field_name('contact'); ?>" value="<?php echo strip_tags($instance['contact']); ?>" />
        </p>

		
        <label class='label-125'  for="<?php echo $this->get_field_id('show_field_labels'); ?>"><?php _e('Show Field Labels:',"i3d-framework"); ?></label>
		<select class='input-mini'  name="<?php echo $this->get_field_name('show_field_labels'); ?>" id="<?php echo $this->get_field_id('show_field_labels'); ?>">
          <option value="0">No</option>
          <option <?php if ($instance['show_field_labels'] == "1") { print "selected"; } ?> value="1">Yes</option>
        </select>
     
<br/>
	
        <label class='label-125' style='' for="<?php echo $this->get_field_id('show_field_icons'); ?>"><?php _e('Show Field Icons:',"i3d-framework"); ?></label>
		<select class='input-mini' name="<?php echo $this->get_field_name('show_field_icons'); ?>" id="<?php echo $this->get_field_id('show_field_icons'); ?>">
          <option value="1">Yes</option>
          <option <?php if ($instance['show_field_icons'] == "0") { print "selected"; } ?> value="0">No</option>
        </select>
 
 		<!-- box style -->
        <div id='box-style-chooser' >
			<?php if (sizeof(I3D_Framework::$boxStyles) > 0) { ?>
        	<label class='label-100' for="<?php echo $this->get_field_id('box_style'); ?>"><?php _e('Box Style:',"i3d-framework"); ?></label>
			<select id="<?php echo $this->get_field_id('box_style'); ?>" name="<?php echo $this->get_field_name('box_style'); ?>">
        		<?php foreach (I3D_Framework::$boxStyles as $className => $boxStyle) { ?>
				<option <?php if (@$instance['box_style'] == $className) { print "selected"; } ?> value="<?php echo $className; ?>"><?php echo $boxStyle; ?></option>
        		<?php } ?>
			</select> 
			<?php }  ?>
		</div>         
             
             </div>
             </div>

</div>

<?php
	}
}
?>
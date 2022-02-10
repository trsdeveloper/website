
<div class='layout-manager-wrapper'>
<div class='alert alert-info' style='font-size: 9pt'>By updating any setting in this panel, you are overriding the associated layout's defined settings.  This is often a point of confusion when you later come back wondering where you had changed a setting.  We recommend only
changing the settings in this area if you are certain that you only want a change made to this one page.  Otherwise, you should make the change to the master layout via the "<a href="/admin.php?page=i3d_layouts">Layout Editor"</a> management panel.
</div> 
<?php
  global $post;
	$selected_layout =  get_post_meta($post->ID, "selected_layout", true);
	
	$layouts = get_option('i3d_layouts');
	if (!is_array($layouts)) {
		$layouts = array();
	}
	if ($selected_layout == "") {
	  $selected_layout = I3D_Framework::get_default_layout_id($post->ID);	
	}
	 foreach ($layouts as $layout) { 
	 ?>
	 <div class='layout-manager <?php if (($layout['is_default'] && $selected_layout == "") || ($selected_layout == $layout['id'])) { print ""; } else { print "non-visible"; } ?>' rel="<?php echo $layout['id']; ?>"><?php
     I3D_Framework::render_page_level_layout_manager($layout['id'], $post->ID); 
	 ?></div><?php
	 }
	 ?>
</div>

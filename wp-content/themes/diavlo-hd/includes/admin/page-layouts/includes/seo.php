<?php
global $post;
global $lmIncludedComponents;


?>
<?php if (!I3D_Framework::use_global_layout()) { ?>
<div class='row-fluid'>
<div class='well well-small'>
            <h4>SEO/Page Meta-Data</h4>
            <p>Ensuring that your page's meta data is defined correctly helps search engines identify the purpose of your page.  If they can properly identify
            the purpose of your page, you're more likely to be listed in the Search Engine Results Pages (SERPs).</p>
</div>
</div>
<?php } ?>
<div class='row-fluid'>
<div class='well span6'>
  <h4>On-Page Header Tags</h4>
  <p>These "Header" tags will appear if you use an SEO region on the page.</p>
<ul>


	<li>
		<label style="font-weight: bold;" for="i3d_page_title">Page Title (H1)</label>
		<input style="width: 100%;" type="text" name="__i3d_i3d_page_title" id="i3d_page_title" value="<?php echo get_post_meta($post->ID, 'i3d_page_title', true); ?>" />
	</li>
	<li>
		<label style="font-weight: bold;" for="i3d_page_description">Page Description (H2)</label>
		<textarea style="width: 100%;"  name="__i3d_i3d_page_description" id="i3d_page_description" ><?php echo get_post_meta($post->ID, 'i3d_page_description', true);?></textarea>
	</li>	
<?php if (is_array($lmIncludedComponents) && array_key_exists("optional_headers", $lmIncludedComponents) && $lmIncludedComponents["optional_headers"]) { ?>
	<li>
		<label style="font-weight: bold;" for="i3d_optional_title">Optional Title (H3)</label>
		<input style="width: 100%;" type="text" name="__i3d_i3d_optional_title" id="i3d_optional_title" value="<?php echo get_post_meta($post->ID, 'i3d_optional_title', true); ?>" />
	</li>
	<li>
		<label style="font-weight: bold;" for="i3d_optional_description">Optional Description (H4)</label>
		<textarea style="width: 100%;"  name="__i3d_i3d_optional_description" id="i3d_optional_description" ><?php echo get_post_meta($post->ID, 'i3d_optional_description', true);?></textarea>
  
	</li>
<?php } ?>    
</ul>
</div>
<?php if (!is_plugin_active("wordpress-seo")) { ?>
<div class='well span6'>
<h4>Page Meta-Data</h4>
<p>While this bit of information isn't actually displayed to the end user, it is often used by each engines to determine what the page is about.</p>	
<ul>
	<li>
		<label style="font-weight: bold;" for="i3d_page_meta_keywords">Page Meta Keywords</label>
		<input style="width: 100%;" type="text" name="__i3d_i3d_page_meta_keywords" id="i3d_page_meta_keywords" value="<?php echo get_post_meta($post->ID, 'i3d_page_meta_keywords', true); ?>" />
	</li>
	<li>
		<label style="font-weight: bold;" for="i3d_page_meta_description">Page Meta Description</label>
		<textarea style="width: 100%;"  name="__i3d_i3d_page_meta_description" id="i3d_page_meta_description" ><?php echo get_post_meta($post->ID, 'i3d_page_meta_description', true);?></textarea>
  
	</li>
    <?php if ($post->post_type == "post") { ?>	
	<li>
		<label style="font-weight: bold;" for="i3d_post_thumbnail">Post Thumbnail Type</label>
        <select  name="__i3d_i3d_post_thumbnail" id="i3d_post_thumbnail" >
		  <option <?php if (get_post_meta($post->ID, 'i3d_post_thumbnail', true) == "news-featured") { print "selected"; } ?> value="news-featured">Full Width Image</option>
		  <option <?php if (get_post_meta($post->ID, 'i3d_post_thumbnail', true) == "post-thumbnail") { print "selected"; } ?> value="post-thumbnail">Thumbnail</option>
		  <option <?php if (get_post_meta($post->ID, 'i3d_post_thumbnail', true) == "disabled") { print "selected"; } ?> value="disabled">Disabled</option>
		  </select>
		  
	</li>	
    <?php } ?>



</ul>
</div>
<?php } ?>
</div>
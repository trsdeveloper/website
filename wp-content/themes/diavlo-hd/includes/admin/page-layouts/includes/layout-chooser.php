<div class='content-chooser-wrapper'>
  <div class='content-chooser-label'>Page Type</div>
    <div rel="default" class='content-chooser <?php if ($selected_page_type == "" || $selected_page_type == "default") { print "selected"; } ?>'>
		<span class="fa-stack fa-2x">
			<i class="fa fa-circle fa-stack-2x"></i>
			<i class="fa fa-align-left fa-stack-1x fa-inverse"></i>
		</span>
		<div class='content-type'>Default</div>
	</div>

    <div rel="blog" class='content-chooser <?php if ($selected_page_type == "blog") { print "selected"; } ?>'>
		<span class="fa-stack fa-2x">
			<i class="fa fa-circle fa-stack-2x"></i>
			<i class="fa fa-rss fa-stack-1x fa-inverse"></i>
		</span>
		<div class='content-type'>Blog</div>
	</div>
	
    <div rel="faqs" class='content-chooser <?php if ($selected_page_type == "faqs") { print "selected"; } ?>'>
		<span class="fa-stack fa-2x">
			<i class="fa fa-circle fa-stack-2x"></i>
			<i class="fa fa-info fa-stack-1x fa-inverse"></i>
		</span>
		<div class='content-type'>FAQs</div>
	</div>	

    <div rel="contact" class='content-chooser <?php if ($selected_page_type == "contact") { print "selected"; } ?>'>
		<span class="fa-stack fa-2x">
			<i class="fa fa-circle fa-stack-2x"></i>
			<i class="fa fa-map-marker fa-stack-1x fa-inverse"></i>
		</span>
		<div class='content-type'>Map Banner</div>
	</div>	

    <div rel="team-members" class='content-chooser <?php if ($selected_page_type == "team-members") { print "selected"; } ?>'>
		<span class="fa-stack fa-2x">
			<i class="fa fa-circle fa-stack-2x"></i>
			<i class="fa fa-users fa-stack-1x fa-inverse"></i>
		</span>
		<div class='content-type'>Team Members</div>
	</div>	

    <div rel="sitemap" class='content-chooser <?php if ($selected_page_type == "sitemap") { print "selected"; } ?>'>
		<span class="fa-stack fa-2x">
			<i class="fa fa-circle fa-stack-2x"></i>
			<i class="fa fa-sitemap fa-stack-1x fa-inverse"></i>
		</span>
		<div class='content-type'>Sitemap</div>
	</div>	
<!--
    <div rel="under-construction" class='content-chooser <?php if ($selected_page_type == "under-construction") { print "selected"; } ?>'>
		<span class="fa-stack fa-2x">
			<i class="fa fa-circle fa-stack-2x"></i>
			<i class="fa fa-wrench fa-stack-1x fa-inverse"></i>
		</span>
		<div class='content-type'>Under Construction</div>
	</div>	
	-->
	
    <div rel="photo-slideshow" class='content-chooser <?php if ($selected_page_type == "photo-slideshow") { print "selected"; } ?>'>
		<span class="fa-stack fa-2x">
			<i class="fa fa-circle fa-stack-2x"></i>
			<i class="fa fa-image fa-stack-1x fa-inverse"></i>
		</span>
		<div class='content-type'>Photo Slideshow</div>
	</div>	

</div>



<div class='layout-chooser-wrapper'>
<div class='layout-chooser-label'>Page Layout</div>

<?php
  global $post;
    $selected_page_type = get_post_meta($post->ID, "selected_page_type", true);
	$selected_layout =  get_post_meta($post->ID, "selected_layout", true);
	if ($selected_page_type == "") {
		$pageMeta = get_post_meta($post->ID);
		if (@$pageMeta['_wp_page_template'][0] != "") {
		  $pageTemplate = str_replace("template-", "", str_replace(".php", "", $pageMeta['_wp_page_template'][0]));
		} else {
			$pageTemplate = "";
		}
		if ($pageTemplate == "blog") {
			$selected_page_type = "blog";
		} else if ($pageTemplate == "sitemap") {
			$selected_page_type = "sitemap";
		} else if ($pageTemplate == "faqs") {
			$selected_page_type = "faqs";
		} else if ($pageTemplate == "under-construction") {
			$selected_page_Type = "default";
		} else if ($pageTemplate == "minimized") {
			$selected_page_type = "default";
		} else if ($pageTemplate == "home") {
			$selected_page_type = "default";
		} else if ($pageTemplate == "advanced") {
			$selected_page_type = "default";
		} else if ($pageTemplate == "contact") {
		 	$selected_page_type = "contact";	
		} else if ($pageTemplate == "events-calendar") {
			$selected_page_type = "default";
		} else if ($pageTemplate == "team-members") {
			$selected_page_type = "team-members";
		} else if ($pageTemplate == "photo-slideshow") {
			$selected_page_type = "photo-slideshow";
		} else {
			$selected_page_type = "default";
		}
	}

	
	$layouts = get_option('i3d_layouts');
	if (!is_array($layouts)) {
		$layouts = array();
	}
	if ($selected_layout == "" || !array_key_exists($selected_layout, $layouts)) {
	  $selected_layout = I3D_Framework::get_default_layout_id($post->ID);	
	}
	//print $selected_layout;
	 foreach ($layouts as $layout) { 
	 ?>
	 <div class='layout-chooser text-center <?php if (($layout['is_default'] && $selected_layout == "") || ($selected_layout == $layout['id'])) { print "selected"; } ?>' rel="<?php echo $layout['id']; ?>"><?php
     I3D_Framework::render_layout_infographic($layout['id']); 
	 print "<div class='layout-name'>{$layout['title']}</div>";
	 ?></div><?php
	 }
	 ?>
</div>
<script>
jQuery(document).ready(function() {
								// init tabs
								
								
								jQuery(".layout-chooser").bind("click", function() {
																				 if (jQuery(this).hasClass("selected")) {
																					//jQuery(this).removeClass("selected");
																					
																				 } else {
																					// select this layout in the layout chooser
																					jQuery(this).parent().find(".layout-chooser").removeClass("selected");
																					jQuery(this).addClass("selected"); 
																					jQuery("#__i3d_selected_layout").val(jQuery(this).attr("rel"));
																					
																					// select this layout in the layout manager
																					jQuery("#tabs-layout-container .layout-manager").addClass("non-visible");
																					jQuery("#tabs-layout-container .layout-manager[rel='" + jQuery(this).attr("rel") + "']").removeClass("non-visible");
																				 }
																				// jQuery("#tab-layout-container").tab("show");
																				 setAvailablePageTypes();
																				 });

								jQuery(".content-chooser").bind("click", function() {
																				 if (jQuery(this).hasClass("selected")) {
																					//jQuery(this).removeClass("selected");
																					
																				 } else {
																					// select this layout in the layout chooser
																					jQuery(this).parent().find(".content-chooser").removeClass("selected");
																					jQuery(this).addClass("selected"); 
																					jQuery("#__i3d_selected_page_type").val(jQuery(this).attr("rel"));
																					
																					// select this layout in the layout manager
																					//jQuery("#tabs-layout-container .content-manager").addClass("non-visible");
																					//jQuery("#tabs-layout-container .layout-manager[rel='" + jQuery(this).attr("rel") + "']").removeClass("non-visible");
																				 }
																				// jQuery("#tab-layout-container").tab("show");
																				setPageTypeRegions(jQuery("#__i3d_selected_page_type").val());
																				 });


jQuery('.i3d-layout-infographic').slimScroll({
        height: 'auto',
		size: '5px',
		color: '#666'
		
    });
setAvailablePageTypes();																		
//alert("v");
jQuery(".content-chooser[rel=" + jQuery("#__i3d_selected_page_type").val() + "]").click();
setPageTypeRegions(jQuery("#__i3d_selected_page_type").val());
								  });
//alert("v");
function setAvailablePageTypes() {
	//alert("hmm");
	// assert appropriate page type icons based on special regions in the page layout infographic
	var special_regions = jQuery(".layout-chooser.selected .i3d-layout-infographic").attr("rel").split(" ");
	//alert(special_regions.length);
	//alert(special_regions);
		jQuery(".content-chooser").addClass("non-visible");
	
	for (i = 0; i < special_regions.length;  i++) {
	
		if (special_regions[i] == "content") {
			//alert(jQuery.inArray("map-banner", special_regions));
			if (jQuery.inArray("map-banner", special_regions) == -1 && jQuery.inArray("photo-slideshow", special_regions) == -1) {
			jQuery(".content-chooser[rel='default']").removeClass("non-visible");
			jQuery(".content-chooser[rel='blog']").removeClass("non-visible");
			jQuery(".content-chooser[rel='faqs']").removeClass("non-visible");
			jQuery(".content-chooser[rel='team-members']").removeClass("non-visible");
			jQuery(".content-chooser[rel='sitemap']").removeClass("non-visible");
			jQuery(".content-chooser[rel='under-construction']").removeClass("non-visible");
			}
		} else if (special_regions[i] == "photo-slideshow") {
			jQuery(".content-chooser[rel='photo-slideshow']").removeClass("non-visible");
		} else if (special_regions[i] == "map-banner") {
			jQuery(".content-chooser[rel='contact']").removeClass("non-visible");
		}
		
	}	
	
	if (jQuery(".content-chooser.selected").hasClass("non-visible")) {
	//	alert(jQuery(".content-chooser:not(.non-visible)").first().html());
		jQuery(".content-chooser:not(.non-visible)").first().click();
		/*
		if (layout == "blog") {
			jQuery("#tab-blog-settings").click();
		} else {
			jQuery("#tab-editor").click();
					jQuery('html, body').animate({scrollTop: jQuery(document).scrollTop() + 10}, 0);
			jQuery('html, body').animate({scrollTop: jQuery(document).scrollTop() - 10}, 0);
		}	  	
		*/
	}
	
	//setPageTypeRegions(jQuery("#__i3d_selected_page_type").val());

	
}
</script>
<input type='hidden' name='__i3d_selected_layout'  id='__i3d_selected_layout' value="<?php echo $selected_layout; ?>" />
<input type='hidden' name='__i3d_selected_page_type'  id='__i3d_selected_page_type' value="<?php echo $selected_page_type; ?>" />


<script>
function setPageTypeRegions(layout) {
	//alert(layout);
	jQuery(".special-region").addClass("non-visible");
	jQuery(".special-widgets").addClass("non-visible");
	jQuery(".special-widgets").each(function() {
											 if (jQuery(this).hasClass("layout")) {
												 jQuery(this).removeClass("non-visible");
											 }
											 });
//alert("new setSpecialRegions");
	var count = jQuery("." + layout).removeClass("non-visible");
	
	var mySelectedTab = jQuery("#page-options-tabs ul.setting-tabs li.active a").attr("id");
	if (typeof selectedTab == 'undefined') {
	  // alert(count);
	 // alert("x");
	}
	//alert(mySelectedTab);
	// if the currently selected tab is not visible, then we need to pick a new one
	if (jQuery("#" + mySelectedTab).parent().hasClass("non-visible")) {
	//	alert("hidden");
	//jQuery(".content-chooser:not(.non-visible)").first().click();
	//	alert(layout);
		if (layout == "blog") {
			jQuery("#tab-blog-settings").click();
		} else {
			jQuery("#tab-editor").click();
			jQuery('html, body').animate({scrollTop: jQuery(document).scrollTop() + 10}, 0);
		jQuery('html, body').animate({scrollTop: jQuery(document).scrollTop() - 10}, 0);

	
		}
	} else {
		//alert("not hidden");
	}



	
}	

</script>
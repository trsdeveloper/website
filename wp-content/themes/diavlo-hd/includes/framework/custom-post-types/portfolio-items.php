<?php
add_shortcode('i3d_default_portfolio', 'i3d_default_portfolio');
add_shortcode('i3d_isotope_portfolio', 'i3d_isotope_portfolio');
add_shortcode('i3d_portfolio_gallery', 'i3d_isotope_portfolio');





function i3d_default_portfolio($atts) {
  return i3d_isotope_portfolio($atts);
}



function i3d_isotope_portfolio($atts) {
	
	$atts = shortcode_atts(array(
			'categories' => '',
			'taxonomy' => '',
			'order' => '',
			'aspect_ratio' => ''
			), $atts);
	
	global $renderedIsotopePortfolio;
	$renderedIsotopePortfolio = true;
	foreach($atts as $key => $value) {
		//$atts[$key] = i3d_clean_shortcode_values($value);
	}
	extract($atts);
	if ($taxonomy == "") {
		$taxonomy = "i3d-portfolio";
	}
	$taxonomyData = get_taxonomy($taxonomy);
	$post_type = @$taxonomyData->object_type[0];
//print "teststest";
	if (@$categories == "") {
	  
	  $categories = get_terms($taxonomy, "hide_empty=1");
	  
	  
	} else { 
	  $cats = get_terms($taxonomy, "hide_empty=1");
	  
	
	  $catsArray = explode(",", $categories);
	  $categories = array();
	  foreach ($cats as $index => $category) {
		if (in_array($category->term_id, $catsArray)) {
			$categories[] = $category;
		}
	  }
	}
	

    ob_start();
	$terms = "";
	if (I3D_Framework::$isotopePortfolioVersion == "3" || I3D_Framework::$isotopePortfolioVersion == "4") { ?>
    
	  <div id="fullscreen-portfolio" class="section anchor clearfix">
		
		  
	<?php } else { 
	  print "<div class='container isotope-container'>";  // removed for kindercare, not rendering well using shortcode in a content region
	//  print "<div class='isotope-container'>";
	?>
	<?php } 
//print sizeof($categories);
	if (sizeof($categories) > 1) { 
	  if (I3D_Framework::$isotopePortfolioVersion == "3" || I3D_Framework::$isotopePortfolioVersion == "4") { ?>
		  <div>
		    <div class='filters'>
			  <ul>
			    <li  class="active"><a href="#" data-filter="*"><?php _e("View All", "i3d-framework"); ?></a></li>
        <?php 
		$terms = array();
		foreach ($categories as $index => $category) { 
		$terms[] = $category->slug;
		?>
		<li><a href="#" data-filter=".group-<?php echo $category->slug; ?>" class=""><?php echo $category->name; ?></a></li>
		<?php } ?>			
		</ul>
			</div>
		  </div>
	  <?php } else { ?>

	<div id="isotope-buttons">
		<a href="#" data-filter="*" class="active">Show All</a>
        <?php foreach ($categories as $index => $category) { 
		$terms[] = $category->slug;
		?>
		<a href="#" data-filter=".group-<?php echo $category->slug; ?>" class=""><?php echo $category->name; ?></a>
		<?php } ?>
	</div>
<?php 
	  } 
}

if (I3D_Framework::$isotopePortfolioVersion == "3" || I3D_Framework::$isotopePortfolioVersion == "4") { ?>
	<div class="fsp-wrapper">
		<div class="fsp-container">
			<div class="fsp-content">
				<div class="fsp-content-inner">
					<ul>
<?php } else { ?>
<div id="isotope-container" class="ufilter">
	<div class="col-sm-12">
		<div id="isotope-portfolio">
		  
<?php }

   if (sizeof($categories) == 0) {
	  
	  $wpq = array("post_type" => $post_type, "posts_per_page" => -1);
	  if ($order == "alpha") {
	//  print "yes1";
	    $wpq['orderby'] = "post_title";
	    $wpq['order'] = "ASC";
		$wqp['orderbyoverride'] = 1;
		global $order_by_override;
		$order_by_override = true;
	  } else {
	 // print "nope1";
	  }
   } else {

		$wpq = array("post_type" => $post_type, "posts_per_page" => -1, "taxonomy" => $taxonomy);
	  if ($order == "alpha") {
	 // print "yes2";
	    $wpq['orderby'] = "post_title";
	    $wpq['order'] = "ASC";
		global $order_by_override;
		$order_by_override = true;
		
		$wqp['orderbyoverride'] = 1;
	  }   else {
	 // print "nope2";
	  }
   }
   if (is_array(@$catsArray)) {
	//   unset($wpq['taxonomy']);
	$wpq['tax_query'] = array('relation' => 'AND', array('taxonomy' => $taxonomy, 'field' => 'id', 'terms' => $catsArray));   
   }
 //  var_dump($wpq);
	$categoryPosts = new WP_Query($wpq);
//	var_dump($categoryPosts);
	$alternateIconMapping = array("email" => "envelope-o", "googleplus" => "google-plus", "blog" => "rss", "website" => 'external-link');

	foreach ($categoryPosts->posts as $post) {
	//	var_dump($post);

		$postTerms = wp_get_post_terms( $post->ID, $taxonomy);
		$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
		if (I3D_Framework::$isotopePortfolioVersion == 3 || I3D_Framework::$isotopePortfolioVersion == 4) {
		  if ($post_type == "i3d-team-member") {
			  $postLinkOverride = "";
			$postData		= get_post_meta( $post->ID, 'team_member_data', true );
			$contactData 	= get_post_meta( $post->ID, 'team_member_contact_points', true);
		  } else {
			  $postLinkOverride = get_post_meta( $post->ID, 'portfolio_item_link_override', true );
			$postData		= get_post_meta( $post->ID, 'portfolio_item_data', true );
			$contactData 	= get_post_meta( $post->ID, 'portfolio_item_contact_points', true);
			  
		  }
		if (!is_array(@$postData)) {
		  $postData = array();	
		}
		if (!is_array(@$contactData)) {
		  $contactData = array();	
		}
		$contactCount = 0;
		?>
<!-- isotope image container -->
<li class="<?php foreach ($postTerms as $postTerm) { ?> group-<?php echo $postTerm->slug; ?><?php } ?><?php if ($aspect_ratio != "") { ?> aspect_ratio_<?php echo $aspect_ratio; ?><?php } ?>">
	<div class="fsp-image"><?php echo get_the_post_thumbnail($post->ID, 'full', array('class' => "")); ?></div>
	<div class="fsp-cover">
	  <div class="fsp-info">
	    <?php if (I3D_Framework::$isotopePortfolioVersion == 4) { ?>
		<h4><?php echo $post->post_title; ?></h4>
		<?php } else { ?>
		<h2><?php echo $post->post_title; ?></h2>
		<?php } ?>
		
		<?php if (@$postData[0] != "" && @$postData[0]['value'] != "") { ?>
					<p class="fsp-subtitle">
					<?php echo @$postData[0]['value']; ?>
					</p>
					<?php } ?>		
		<p class='fsp-description'><?php echo $post->post_excerpt; ?></p>
		<a class="fsp-readmore" href="<?php if (@$postLinkOverride == "") { echo get_permalink($post->ID); } else { print $postLinkOverride; } ?>">View web page </a> 
	  
		<?php ob_start(); ?>
				<div class="fsp-icons">
					
						<!-- icons -->
						<?php 
						
						foreach ($contactData as $position => $contactInfo) { 

							if (@$contactInfo['type'] != "") { 
								$contactCount++;
								$icon = $contactInfo['type'];
								if (array_key_exists($icon, $alternateIconMapping)) {
								  $icon = $alternateIconMapping["$icon"];	
								} 
								$color = @$contactInfo['color'];
								if ($color == "") {
								  $color = "blue";
								}
								?>
						<div><a <?php if ($contactInfo['type'] != "email") { ?>target="_blank"<?php } ?> class="fsp-readmore fsp-thumb-icon fsp-icon<?php echo $position+1; ?> fsp-size<?php echo $position+1; ?> fsp-icon-<?php echo $color; ?>" href="<?php echo $contactInfo['value']; ?>"><i class="fa fa-<?php echo $icon; ?>"></i></a></div>
						<?php }
						}
						?>
						<!-- icons -->
					
				</div>
				
<?php if ($contactCount > 0) { 
echo ob_get_clean();
} else {
	ob_end_clean();
}

?>	  
	  </div>
	  	  

	</div>

</li>
<!-- isotope image container -->		
		<?php
		} else if (I3D_Framework::$isotopePortfolioVersion == 2) { 
		  if ($post_type == "i3d-team-member") {
			$postData		= get_post_meta( $post->ID, 'team_member_data', true );
			$contactData 	= get_post_meta( $post->ID, 'team_member_contact_points', true);
		} else {
			  $postLinkOverride = get_post_meta( $post->ID, 'portfolio_item_link_override', true );
			$postData		= get_post_meta( $post->ID, 'portfolio_item_data', true );
			$contactData 	= get_post_meta( $post->ID, 'portfolio_item_contact_points', true);
			  
		  }
		if (!is_array(@$postData)) {
		  $postData = array();	
		}
		if (!is_array(@$contactData)) {
		  $contactData = array();	
		}
		$contactCount = 0;
		
		?>
<!-- isotope image container -->
<div class="col-sm-3  isotope-item thumb<?php foreach ($postTerms as $postTerm) { ?> group-<?php echo $postTerm->slug; ?><?php } ?><?php if ($aspect_ratio != "") { ?> aspect_ratio_<?php echo $aspect_ratio; ?><?php } ?>"><div class="img-container2"><div class="isotope-item-image-container"><div class="isotope-item-overlay ">
<div class="mts-isotope-caption"><div class="mts-isotope-caption-wrapper"><p class="mts-isotope-caption-description"><?php echo $post->post_excerpt; ?></p></div></div><?php
ob_start(); 
?><div class="inner" onclick='document.location="<?php echo get_permalink($post->ID); ?>"'><ul><?php 
						
						foreach ($contactData as $position => $contactInfo) { 

							if (@$contactInfo['type'] != "") { 
								$contactCount++;
								$icon = $contactInfo['type'];
								if (array_key_exists($icon, $alternateIconMapping)) {
								  $icon = $alternateIconMapping["$icon"];	
								} 
								$color = @$contactInfo['color'];
								if ($color == "") {
								  $color = "blue";
								}
								?><li><a <?php if ($contactInfo['type'] != "email") { ?>target="_blank"<?php } ?> class="mts-thumb-icon mts-icon<?php echo $position+1; ?> mts-size<?php echo $position+1; ?> mts-icon-<?php echo $color; ?>" href="<?php echo $contactInfo['value']; ?>"><i class="fa fa-<?php echo $icon; ?>"></i></a></li><?php
								}
						}
						?></ul></div><?php 
if ($contactCount > 0) { 
echo ob_get_clean();
} else {
	ob_end_clean();
}

?></div><?php
	$additional_class = "";
	if ($aspect_ratio == "constrained") {
		 $thumbnail_data = wp_get_attachment_image_src( get_post_meta($post->ID, '_thumbnail_id', true), 'full');
		 
		 if ($thumbnail_data[1] > $thumbnail_data[2]) {
			$additional_class = " is-horizontal-orientation";
		 } else {
			$additional_class = " is-vertical-orientation"; 
		 }
	}
		 
		 echo get_the_post_thumbnail($post->ID, 'full', array('class' => "img-circle{$additional_class}"));

if ($contactCount > 0) {
	?><div class="mts-item-bottom"><ul><li><a class="mts-circle1" href=""><i class="fa fa-circle"></i></a></li><li><a class="mts-circle2" href=""><i class="fa fa-circle"></i></a></li><li><a class="mts-circle3" href=""><i class="fa fa-circle"></i></a></li></ul></div><?php 
	} ?></div></div><div class="mts-isotope-caption-wrapper2"><h3 class="mts-isotope-caption-title2"><a href='<?php if (@$postLinkOverride == "") { echo get_permalink($post->ID); } else { print $postLinkOverride; } ?>'><?php echo $post->post_title; ?></a></h3><?php 
	if (@$postData[0] != "" && @$postData[0]['value'] != "") { ?><p class="mts-isotope-caption-description2"><?php 
	echo @$postData[0]['value']; ?></p><?php 
	} ?></div></div>
		<?php } else { 	
		
		 if ($post_type == "i3d-team-member") {
			$postData		= get_post_meta( $post->ID, 'team_member_data', true );
			$contactData 	= get_post_meta( $post->ID, 'team_member_contact_points', true);
		} else {
			  $postLinkOverride = get_post_meta( $post->ID, 'portfolio_item_link_override', true );
			$postData		= get_post_meta( $post->ID, 'portfolio_item_data', true );
			$contactData 	= get_post_meta( $post->ID, 'portfolio_item_contact_points', true);
			  
		  }
		if (!is_array(@$postData)) {
		  $postData = array();	
		}
		if (!is_array(@$contactData)) {
		  $contactData = array();	
		}
		$contactCount = 0;
		?>
<div class="col-sm-3 isotope-item thumb<?php foreach ($postTerms as $postTerm) { ?> group-<?php echo $postTerm->slug; ?><?php } ?>">
	<div class="img-container">
		<div class="isotope-item-image-container">
			<div class="isotope-item-overlay ">
				<div class="inner">
					<ul>
						<!-- large image / image link -->
						<li>
						<a class="thumb-icon" href="<?php echo $large_image_url[0]; ?>" rel="prettyPhoto[gallery]"><i class="fa fa-search-plus fa-2x"></i></a></li>
						<li><a class="thumb-icon" href="<?php if (@$postLinkOverride == "") { echo get_permalink($post->ID); } else { print $postLinkOverride; } ?>"><i class="fa fa-link fa-2x"></i></a></li>
						<!-- large image / image link -->
					</ul>
				</div>
			</div>

			<!-- thumb image -->
            <?php 
			echo get_the_post_thumbnail($post->ID, 'full', array('class' => "isotope-medium-image"));
			?>
			<!-- thumb image -->
			 </div>
		<div class="caption">
			<div class="caption-wrapper">
				<!-- title / description / read more link -->
				<h3 class="caption-title "><?php echo $post->post_title; ?></h3>
				<?php if ($post->post_excerpt != "") { ?><p class="caption-description"><?php echo $post->post_excerpt; ?></p><?php } ?>
                <?php ob_start(); ?>
						<div class="portfolio-contact-icons" onclick='document.location="<?php echo get_permalink($post->ID); ?>"'>
							<ul>
								<!-- icons -->
								<?php 
								
								foreach ($contactData as $position => $contactInfo) { 
		
									if (@$contactInfo['type'] != "") { 
										$contactCount++;
										$icon = $contactInfo['type'];
										if (array_key_exists($icon, $alternateIconMapping)) {
										  $icon = $alternateIconMapping["$icon"];	
										} 
										$color = @$contactInfo['color'];
										if ($color == "") {
										  $color = "blue";
										}
										?>
								<li><a <?php if ($contactInfo['type'] != "email") { ?>target="_blank"<?php } ?> class="mts-thumb-icon mts-icon<?php echo $position+1; ?> mts-size<?php echo $position+1; ?> mts-icon-<?php echo $color; ?>" href="<?php echo $contactInfo['value']; ?>"><i class="fa fa-<?php echo $icon; ?>"></i></a></li>
								<?php }
								}
								?>
								<!-- icons -->
							</ul>
						</div>
						
		<?php if ($contactCount > 0) { 
		echo ob_get_clean();
		} else {
			ob_end_clean();
		}
		
?>
                <?php if ($post->post_excerpt == "") { ?>
				<a href="<?php if (@$postLinkOverride == "") { echo get_permalink($post->ID); } else { print $postLinkOverride; } ?>" title="read more" class="read-more"><?php _e("read more &rarr;", "i3d-framework"); ?></a>
                <?php } ?>
				<!-- title / description / read more link -->
			</div>
		</div>
	</div>
</div>
<!-- isotope image container -->
<?php } // end of else ?>
<?php } ?>



<?php if (I3D_Framework::$isotopePortfolioVersion == "3" || I3D_Framework::$isotopePortfolioVersion == "4") { ?>
    </ul>
    		</div>
	  	</div>
    		</div>
	  	</div>
    		</div>
			<script type="text/javascript">
			//jQuery("#fullscreen-portfolio").parents(".container").removeClass("container");
			</script>
			<?php
		if (file_exists(get_template_directory()."/Site/javascript/vendor/jquery.easing.min.js")) {
		//	print "Yup";
		  if (file_exists(get_template_directory()."Library/components/portfolio-packages/js/portfolio-packages.js")) {
			 wp_enqueue_script( 'jquery-fullscreen-portfolio', 		get_stylesheet_directory_uri()."/Library/components/portfolio-packages/js/portfolio-packages.js", array('jquery'), '1.0' ); 
		  } else {
		 	 wp_enqueue_script( 'jquery-fullscreen-portfolio', 		get_stylesheet_directory_uri()."/Library/components/portfolio/js/portfolio.js", array('jquery'), '1.0' );
		  }
		  wp_enqueue_script( 'jquery-easing', 		 get_stylesheet_directory_uri()."/Site/javascript/vendor/jquery.easing.min.js", array('jquery'), '1.0' );
		  wp_enqueue_script( 'jquery-waitforimages', get_stylesheet_directory_uri()."/Site/javascript/vendor/jquery.waitforimages.min.js", array('jquery'), '1.0' );

		  if (file_exists(get_template_directory()."/Library/components/portfolio/css/portfolio.css")) {
			//  print "YES";
			 wp_enqueue_style( 'css-fullscreen-portfolio', 		get_stylesheet_directory_uri()."/Library/components/portfolio/css/portfolio.css" ); 
		  }	
		} else {
		//	print "Nope";
			
		  wp_enqueue_script( 'jquery-fullscreen-portfolio', 		get_stylesheet_directory_uri()."/Site/javascript/components/js/better-fullscreen-portfolio.js", array('jquery'), '1.0' );
		  wp_enqueue_script( 'jquery-easing', 		 get_stylesheet_directory_uri()."/Site/javascript/jquery/jquery.easing.1.3.js", array('jquery'), '1.0' );
		  wp_enqueue_script( 'jquery-waitforimages', get_stylesheet_directory_uri()."/Site/javascript/jquery/jquery.waitforimages.min.js", array('jquery'), '1.0' );
		}	
		} else { 
		?></div></div></div></div>
	<?php }
	if ($aspect_ratio == "constrained") { ?>
	<script>jQuery(document).ready(function() {
			jQuery('.aspect_ratio_constrained .img-container2 img').waitForImages(function() {
																						 // alert("loaded");
			var cw = jQuery('.aspect_ratio_constrained .img-container2').width();
			//alert(cw);
			jQuery('.aspect_ratio_constrained .img-container2').css({'height':cw+'px'});
			//alert(jQuery('#isotope-container').isotope.layout());
			var $container = jQuery("#isotope-container");
			$container.isotope({
			                itemSelector: '.thumb',
			                layoutMode: 'fitRows'
			            });
			/*
			alert($container.isotope);
			alert($container.isotope.layout());
jQuery('#isotope-container').isotope.layout();
*/
//alert("done2");
											});
											});
	
	</script>
	<?php } ?>
	<?php 
return ob_get_clean();
}

/************************************************** PORTFOLIO **************************************************/
if (!function_exists("i3d_include_template_function_portfolio_item")) { 
		register_post_type( 'i3d-portfolio-item',
			array(
				'labels' => array(
					'name' => 'Portfolio Item',
					'singular_name' => 'Portfolio Item',
					'add_new' => 'Add New',
					'add_new_item' => 'Add Portfolio Item',
					'edit' => 'Edit',
					'edit_item' => 'Edit Portfolio Item',
					'new_item' => 'New Portfolio Item',
					'view' => 'View',
					'view_item' => 'View Portfolio Item',
					'search_items' => 'Search Portfolio Item',
					'not_found' => 'No Portfolio Items Found',
					'not_found_in_trash' => 'No Potfolio Items found in Trash',
					'parent' => 'Parent Portfolio Item'
				),
				'public' => true, 
				'menu_position' => 15,
				'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt'),
				'taxonomies' => array( '' ),
				'rewrite' => array('slug' => 'portfolio-item'),
				'show_in_nav_menus' => false,
				'show_in_menu' => false,
				/* 'menu_icon' => plugins_url( 'images/image.png', __FILE__ ), */
				'has_archive' => true
			)
		);

	register_taxonomy("i3d-portfolio", "i3d-portfolio-item", 
						  array("hierarchial" => false, 
								"labels" => array('name' => _x("Portfolio", "Portfolio", "i3d-framework"),
												  'signular_name' => _x("Portfolio", "Portfolio", "i3d-framework"),
												  'search_items' => __("Search Portfolios", "Search Portfolio", "i3d-framework"),
												  'all_items' => __("All Portfolios", "All Portfolios", "i3d-framework"),
												  'parent_item' => __("Parent Portfolio", "Parent Portfolio", "i3d-framework"),
												  'parent_item_colon' => __("Parent Portfolio:", "Parent Portfolio", "i3d-framework"),
												  'edit_item' => __("Edit Portfolio", "Edit Portfolio", "i3d-framework"),
												  'update_item' => __("Update Portfolio", "Update Portfolio", "i3d-framework"),
												  "add_new_item" => __("Add New Portfolio", "Add New Portfolio", "i3d-framework"),
												  "new_item_name" => __("New Item Portfolio", "New Item Portfolio", "i3d-framework"),
												  "menu_name" => __("Portfolios", "Portfolios", "i3d-framework")
												  ),
								"query_var" => true, 
								"rewrite" => array("slug" => "portfolio")
								));
		
	


function display_portfolio_item_meta_box( $portfolio_item ) {
    // Retrieve team member data and contact details based on team member ID
    $portfolioItemLinkOverride = get_post_meta($portfolio_item->ID, 'portfolio_item_link_override', true);
    $portfolioItemData = get_post_meta($portfolio_item->ID, 'portfolio_item_data', true);
    $portfolioItemContactPoints = get_post_meta($portfolio_item->ID, 'portfolio_item_contact_points', true);
		
//		var_dump($teamMemberContactPoints);
    $number_of_data_fields    = 5;
	$number_of_contact_fields = 5;
		?>
		<div id="team-member-meta-box">
		<h4>Portfolio Item Link</h4>
		<p>You can choose to override the default portfolio page link to an external URL.  If this field is left blank, then the system will link to the default portfolio item page.</p>
		<input placeholder="http://www.somewebsite.com/somepage.htm" class='form-control' type='url' name="portfolio_item_link_override" value="<?php echo @$portfolioItemLinkOverride; ?>" />
    <br/>
		<h4>Data Fields</h4>
		<p>You can use these fields to describe such things as "position", "title", "rank", "since", "grade", "division", "interests" or whatever you want to quantify into point form data.</p>
		<p>The very first item tends to be displayed below the items name, and is often used for "position" or "title".</p>
	<table class='table table-striped'>
	  <tr>
	    <th style='width: 175px;'>Field Label</td>
		<th>Field Value</td>
      </tr>
	<?php for ($i = 0; $i < $number_of_data_fields; $i++) {
		if (!is_array(@$portfolioItemData["$i"])) {
			$portfolioItemData["$i"] = array();
		}
		?>
		<tr>
			<td><input placeholder='Label' class='form-control' type="text" name="portfolio_item_data__<?php echo $i; ?>__label" value="<?php echo addslashes(@$portfolioItemData["{$i}"]['label']); ?>" /></td>
			<td><input placeholder='Value' class='form-control' type="text" name="portfolio_item_data__<?php echo $i; ?>__value" value="<?php echo addslashes(@$portfolioItemData["{$i}"]['value']); ?>" /></td>
		</tr>
    <?php } ?>
    </table>

		<h4>Contact Fields</h4>
		<p>You can use these fields to allow visitors to contact this item via such methods as "email", "twitter", "facebook", "blog", or "google+".</p>
 <script>
 function updatePlaceholder(selectBox) {
 	var selectedValue = jQuery(selectBox).val(); 
	<?php $domainName = get_site_url();
	      $domainName = str_replace(array("http://", "www."), array("", ""), $domainName);
		  $domainName = array_shift(explode("/", $domainName));
		  ?>
    var placeholder = "";
	if (selectedValue == "email") {
		
		placeholder = "mailto:name@<?php echo $domainName; ?>";
	} else if (selectedValue == "twitter") {
		placeholder = "http://twitter.com/somename";
	
	} else if (selectedValue == "linkedin") {
		placeholder = "http://linkedin.com/in/somename";
	
	} else if (selectedValue == "facebook") {
		placeholder = "http://facebook.com/somename";
	
	} else if (selectedValue == "googleplus") {
		placeholder = "http://plus.google.com/238013856935435";
	
	} else if (selectedValue == "website") {
		placeholder = "http://somewebsite.com/";
	
	} else if (selectedValue == "blog") {
	 
		placeholder = "<?php echo get_site_url(); ?>/author/somename";
		
	} else {
		placeholder = "";
	}
	
	if (placeholder != "") {
	
	placeholder = "<?php _e("Example", "", "i3d-framework"); ?>: " + placeholder;
	}
	
	var inputControlID = selectBox.id.replace("type", "value");
	jQuery("#" + inputControlID).attr("placeholder", placeholder);
	jQuery("#" + inputControlID).attr("title", placeholder);
 }
 </script>
 	<table class='table table-striped'>
	  <tr>
	    <th style='width: 175px;'>Contact Type</td>
<?php if (I3D_Framework::$isotopePortfolioVersion == 2 && sizeof(I3D_Framework::$teamMemberContactIconColors) > 0) { ?>
		<th style='width: 175px;'>Highlight Color</td>

<?php } ?>		
		<th>URL/Address</td>
      </tr>
	<?php for ($i = 0; $i < $number_of_contact_fields; $i++) {
		if (!is_array(@$portfolioItemContactPoints["$i"])) {
			$portfolioItemContactPoints["$i"] = array();
		}
		?>
		<tr>
			<td>
			  <select onchange='updatePlaceholder(this)' class='form-control' name="portfolio_item_contact_points__<?php echo $i; ?>__type"  id="portfolio_item_contact_points__<?php echo $i; ?>__type">
			    <option value=""><?php _e("-- Select Type --", "", "i3d-framework"); ?></option>
				<option <?php if (@$portfolioItemContactPoints["{$i}"]["type"] == "email") { print "selected"; } ?> value="email">Email</option>
				<option <?php if (@$portfolioItemContactPoints["{$i}"]["type"] == "twitter") { print "selected"; } ?> value="twitter">Twitter</option>
				<option <?php if (@$portfolioItemContactPoints["{$i}"]["type"] == "linkedin") { print "selected"; } ?> value="linkedin">LinkedIn</option>
				<option <?php if (@$portfolioItemContactPoints["{$i}"]["type"] == "facebook") { print "selected"; } ?> value="facebook">Facebook</option>
				<option <?php if (@$portfolioItemContactPoints["{$i}"]["type"] == "google-plus") { print "selected"; } ?> value="googleplus">Google+</option>
				<option <?php if (@$portfolioItemContactPoints["{$i}"]["type"] == "website") { print "selected"; } ?> value="website">Website Address</option>
				<option <?php if (@$portfolioItemContactPoints["{$i}"]["type"] == "blog") { print "selected"; } ?> value="blog">Blog</option>
		      </select></td>
<?php if (I3D_Framework::$isotopePortfolioVersion == 2 && sizeof(I3D_Framework::$teamMemberContactIconColors) > 0) { ?>
			<td>
			  <select class='form-control' name="portfolio_item_contact_points__<?php echo $i; ?>__color"  id="portfolio_item_contact_points__<?php echo $i; ?>__color">
			    <option value=""><?php _e("-- Select Color --", "", "i3d-framework"); ?></option>
				<?php foreach (I3D_Framework::$teamMemberContactIconColors as $color => $colorValue) { ?>
				<option <?php if (@$portfolioItemContactPoints["{$i}"]["color"] == $color) { print "selected"; } ?> value="<?php echo $color; ?>"><?php echo $colorValue; ?></option>
				<?php } ?>
		      </select></td>
<?php } ?>
			<td><input placeholder='Value' class='form-control' type="url" id="portfolio_item_contact_points__<?php echo $i; ?>__value"  name="portfolio_item_contact_points__<?php echo $i; ?>__value" value="<?php echo addslashes(@$portfolioItemContactPoints["{$i}"]['value']); ?>" /></td>
		</tr>
		<script>
		updatePlaceholder(document.getElementById("portfolio_item_contact_points__<?php echo $i; ?>__type"));
		</script>
    <?php } ?>
    </table>	

	</div>
    <?php
}

function i3d_portfolio_item_admin() {
    add_meta_box( 'portfolio_item_admin_meta_box',
        'Portfolio Item Details',
        'display_portfolio_item_meta_box',
        'i3d-portfolio-item', 'normal', 'high'
    );
}

		add_action( 'admin_init', 'i3d_portfolio_item_admin' );

function add_portfolio_item_fields( $portfolio_item_id, $portfolio_item ) {
   
   // Check post type for movie reviews
    if ( $portfolio_item->post_type == 'i3d-portfolio-item' ) {
		// Store data in post meta table if present in post data
		$portfolioItemContactPoints = array();
		$portfolioItemData = array();
		foreach ($_POST as $key => $value) {
			$keyData = explode("__", $key);
			if ($keyData[0] == "portfolio_item_contact_points") {
				$i = $keyData[1];
				$field = $keyData[2];
				$portfolioItemContactPoints["$i"]["$field"] = $value;
			} else if ($keyData[0] == "portfolio_item_data") {
				$i = $keyData[1];
				$field = $keyData[2];
				$portfolioItemData["$i"]["$field"] = $value;				
			}
		}
		//var_dump($teamMemberData);
		update_post_meta( $portfolio_item_id, 'portfolio_item_link_override', 	$_POST['portfolio_item_link_override'] );
		update_post_meta( $portfolio_item_id, 'portfolio_item_data', 	$portfolioItemData );
		update_post_meta( $portfolio_item_id, 'portfolio_item_contact_points', 	$portfolioItemContactPoints );
		//exit;
	}
}
add_action( 'save_post', 'add_portfolio_item_fields', 10, 2 );

function i3d_include_template_function_portfolio_item( $template_path ) {
		if ( get_post_type() == 'i3d-portfolio-item' ) {
			if ( is_single() ) {
				// checks if the file exists in the theme first,
				// otherwise serve the file from the plugin
				if ( $theme_file = locate_template( array ( 'single-portfolio-item.php' ) ) ) {
					$template_path = $theme_file;
				} else {
					$template_path = plugin_dir_path( __FILE__ ) . '/single-portfolio-item.php';
				}
			}
		}
		return $template_path;
	}
}




?>
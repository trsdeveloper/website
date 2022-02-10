<?php

/***********************************/
/**        CONTENT REGION         **/
/***********************************/
class I3D_Widget_ImageCarousel extends WP_Widget {
	function __construct() {
	//function I3D_Widget_ImageCarousel() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Renders a given image carousel', "i3d-framework") );
		parent::__construct('i3d_image_carousel', __('i3d:Image Carousel', "i3d-framework"), $widget_ops);
	}

	function widget( $args, $instance ) {		
		extract( $args );
		echo $before_widget;
		$taxonomy = $instance['taxonomy'];
		if ($taxonomy == "") {
			$taxonomy = "i3d-portfolio";
		}
		$categories = "";
		$categoryStr = "";
		$orderStr = "";
		
		if (is_array(@$instance['categories__'.$taxonomy])) {
			$categories = implode(",", $instance['categories__'.$taxonomy]);
		}
		if ($categories != "") {
			$categoryStr = " categories='{$categories}'";
		}
		if (@$instance['order'] != "") {
		  $orderStr = " order='{$instance['order']}'";
		}
		
		if (@$instance['display'] == "") {
			$this->display_contained($instance, $categories);
		} else {
			$this->display_carousel($instance, $categories);
		}
		echo $after_widget;
	}



	function display_contained($instance, $categories) {
		$taxonomy = @$instance['taxonomy'];
		//$categories = @$instance['categories'];
		$order = @$instance['order'];
	//	var_dump($instance);
		
		if ($taxonomy == "") {
			$taxonomy = "i3d-portfolio";
		}
		$taxonomyData = get_taxonomy($taxonomy);
		$post_type = @$taxonomyData->object_type[0];
	//print "teststest";
		if (@$categories == "") {
		  
		  $categories = get_terms($taxonomy, "hide_empty=1");
		//  print "No";
		  
		} else { 
		//print "yes";
		  $cats = get_terms($taxonomy, "hide_empty=1");
		  
		
		  $catsArray = explode(",", $categories);
		  $categories = array();
		  foreach ($cats as $index => $category) {
			if (in_array($category->term_id, $catsArray)) {
				$categories[] = $category;
			}
		  }
		}
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
	
		?>
<div class="owl-carousel-contained about owl-carousel text-center">
<?php
		foreach ($categoryPosts->posts as $post) {
		//	var_dump($post);
	
			$postTerms = wp_get_post_terms( $post->ID, $taxonomy);
			$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
			
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

        <!-- slide -->
        <div class="item">
            <div class="thumb <?php echo @$instance['style']; ?>">
                <div class="thumb-hover">
                </div>
                <div class="thumb-inner">
                    <div class="thm content colored thm-hover1">
                        <div class="thm-img">
                            <img alt="thm-img" src="<?php echo $large_image_url[0]; ?>">
                        </div>
                        <div class="mask1">
                        </div>
                        <div class="mask2">
                        </div>
                        <div class="thm-corners top-corners">
                        </div>
                        <div class="thm-corners bottom-corners">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- slide -->
<?php } ?>


    </div>
	<?php
	}
	
	function display_carousel($instance, $categories) {
		$taxonomy = @$instance['taxonomy'];
		//$categories = @$instance['categories'];
		$order = @$instance['order'];
	//	var_dump($instance);
		
		if ($taxonomy == "") {
			$taxonomy = "i3d-portfolio";
		}
		$taxonomyData = get_taxonomy($taxonomy);
		$post_type = @$taxonomyData->object_type[0];
	//print "teststest";
		if (@$categories == "") {
		  
		  $categories = get_terms($taxonomy, "hide_empty=1");
		//  print "No";
		  
		} else { 
		//print "yes";
		  $cats = get_terms($taxonomy, "hide_empty=1");
		  
		
		  $catsArray = explode(",", $categories);
		  $categories = array();
		  foreach ($cats as $index => $category) {
			if (in_array($category->term_id, $catsArray)) {
				$categories[] = $category;
			}
		  }
		}
		if (sizeof($categories) == 0) {
	//  var_dump($instance);
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
	
		?>
<div class="owl-carousel-slider-<?php echo @$instance['number_of_items']; ?> about owl-carousel text-center">
<?php
		foreach ($categoryPosts->posts as $post) {
		//	var_dump($post);
	
			$postTerms = wp_get_post_terms( $post->ID, $taxonomy);
			$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
			
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

        <!-- slide -->
        <div class="item">
            <div class="thumb <?php echo @$instance['style']; ?>">
                <div class="thumb-hover">
                </div>
                <div class="thumb-inner">
                    <div class="thm content colored thm-hover1">
                        <div class="thm-img">
                            <img alt="thm-img" src="<?php echo $large_image_url[0]; ?>">
                        </div>
                        <div class="mask1">
                        </div>
                        <div class="mask2">
                        </div>
                        <div class="thm-corners top-corners">
                        </div>
                        <div class="thm-corners bottom-corners">
                        </div>
						
<div class="thm-title">
                            <h3>
                                <?php 
								$postTitle = $post->post_title;
								$postTitleBits = explode(" ", $postTitle);
								echo array_shift($postTitleBits);
								echo " <span>";
								echo implode(" ", $postTitleBits);
								echo "</span>";
								?>
								
								

                                
                            </h3>
                        </div>
                        <div class="thm-desc">
                            <span>
                                <?php echo $post->post_excerpt; ?>
                            </span>
                        </div>
                        <div class="thm-link">
                            <a href="<?php if (@$postLinkOverride == "") { echo get_permalink($post->ID); } else { print $postLinkOverride; } ?>">
                                <i class="fa fa-external-link fa-1x"></i>
                            </a>
                        </div>
                        <div class="thm-fancy">
                            <a class="fancybox" data-fancybox-group="group1" href="<?php echo $large_image_url[0]; ?>">
                                <i class="fa fa-picture-o fa-1x"></i>
                            </a>
                        </div>
						
						
						
                        <div class="thm-icon-wrapper">
						
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
										
								<div class="thm-icon<?php echo $position+1; ?>">
                                <a <?php if ($contactInfo['type'] != "email") { ?>target="_blank"<?php } ?> href="<?php echo $contactInfo['value']; ?>">
                                    <i class="fa fa-<?php echo $icon; ?> fa-1x"></i>
                                </a>
                            </div>		
										
								<?php }
								}
								?>
								
										
                        </div>						
                    </div>
                </div>
            </div>
        </div>
        <!-- slide -->
<?php } ?>


    </div>
	<?php

	}
	function update( $new_instance, $old_instance ) {
		//var_dump($new_instance);
		return $new_instance;
	}


	function layout_configuration_form( $instance, $defaults, $row_id, $widget_id, $layout_id, $page_level = false ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'taxonomy' => '', 'order' => '', 'portfolio_style' => '', 'categories' => array() ) );
	  global $post;

	  $layouts = get_option('i3d_layouts');
	  if ($page_level) {
		 
		  $prefix = "__i3d_layouts__{$layout_id}__";
			$page_layouts 		= (array)get_post_meta($post->ID, "layouts", true);
			if (!array_key_exists($layout_id, $page_layouts)) {
				$page_layouts["{$layout_id}"] = array();
			}
			if (!array_key_exists($row_id, $page_layouts["{$layout_id}"])) {
				$page_layouts["{$layout_id}"]["{$row_id}"] = array();
			}
			if (!array_key_exists("configuration", $page_layouts["{$layout_id}"]["{$row_id}"])) {
				$page_layouts["{$layout_id}"]["{$row_id}"]["configuration"] = array();
			}
			if (!array_key_exists($widget_id, $page_layouts["{$layout_id}"]["{$row_id}"]["configuration"])) {
				$page_layouts["{$layout_id}"]["{$row_id}"]["configuration"]["$widget_id"] = array();
			}			
			$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"] =   wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'taxonomy' => '', 'order' => '', 'portfolio_style' => '', 'categories' => array() ) );
	        
			/*
	        $box_style 	= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["box_style"];
	        $id 	= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["id"];

			// if box_style == "*" then it whatever the layout default is
			if ($id == "*") {
			  $instance['id'] = "*";
			  // if the box style is blank, then it means there is no box_style
			} else if ($id == "") {
				$instance['id'] = "";
			
			} else if ($id != "") {
			    $instance['id'] = $id;	
			}
			
			if ($box_style == "*") {
			  $instance['box_style'] = "*";
			  // if the box style is blank, then it means there is no box_style
			} else if ($box_style == "") {
				$instance['box_style'] = "";
			} else if ($box_style != "") {
			    $instance['box_style'] = $box_style;	
			}
			*/
			
			$layoutID = $layout_id;
	  } else {
		//  global $layoutID;
		  
		  $prefix = "";
		  
	  }
       $rand = rand();
	 $categories = array();
	 
	 		$taxonomies = array("i3d-portfolio" => __("Portfolio Items", "i3d-framework"), "i3d-team-member-department" => __("Team Members", "i3d-framework"));

	 ?>
	 


	<div class="input-group tt2" title="Display" >
  		<span class="input-group-addon detailed-addon"><i class="fa fa-file-image-o fa-fw"></i> <span class='detailed-label'>Display</span></span>

		<select class='form-control' id="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__display" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__display">
	    <?php 
		// if there is no prefix, then this is the layout manager level
		if ($prefix == "") { 
            
	
		// else, if there is a prefix, then this is the page level configurations
		} else {

			?>
        <option value="*" ><?php _e("-- Layout Default --","i3d-framework"); ?></option>

		<?php } ?>
		
          <option <?php if (@$instance['display'] == "") { print "selected"; } ?> value="">Contained</option>
		  <option <?php if (@$instance['display'] == "carousel") { print "selected"; } ?> value="carousel">Carousel</option>
        
                </select> 
</div>


	<div class="i3d-number-of-owl-items-<?php echo $rand; ?> input-group tt2 <?php if (@$instance['display'] != "carousel") { print "hidden-block"; } ?>" title="Items" >
  		<span class="input-group-addon detailed-addon"><i class="fa fa-file-ellipsis-h fa-fw"></i> <span class='detailed-label'>Items</span></span>
		<select class='form-control' id="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__number_of_items" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__number_of_items">
	    <?php 
		// if there is no prefix, then this is the layout manager level
		if ($prefix == "") { 
            
	
		// else, if there is a prefix, then this is the page level configurations
		} else {

			?>
        <option value="*" ><?php _e("-- Layout Default --","i3d-framework"); ?></option>

		<?php } ?>
				
		  <option  <?php if (@$instance['number_of_items'] == "2") { print "selected"; } ?> value="1">1</option>
		  <option  <?php if (@$instance['number_of_items'] == "2") { print "selected"; } ?> value="2">2</option>
		  <option <?php if (@$instance['number_of_items'] == "3") { print "selected"; } ?> value="3">3</option>
		  <option <?php if (@$instance['number_of_items'] == "4" || @$instance['number_of_items'] == "") { print "selected"; } ?> value="4">4</option>
		  <option <?php if (@$instance['number_of_items'] == "5") { print "selected"; } ?> value="5">5</option>
		  <option  <?php if (@$instance['number_of_items'] == "6") { print "selected"; } ?> value="6">6</option>
		</select>
	</div>
		
	<div class="input-group tt2" title="Post Type" >
  		<span class="input-group-addon detailed-addon"><i class="fa fa-archive fa-fw"></i> <span class='detailed-label'>Post Type</span></span>

		<select class='form-control' id="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__taxonomy" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__taxonomy">
	    <?php 
		// if there is no prefix, then this is the layout manager level
		if ($prefix == "") { 
            
	
		// else, if there is a prefix, then this is the page level configurations
		} else {

			?>
        <option value="*" ><?php _e("-- Layout Default --","i3d-framework"); ?></option>

		<?php } ?>
		 <?php foreach ($taxonomies as $taxonomy => $taxonomyName) { ?>
          <option <?php if (@$instance['taxonomy'] == $taxonomy) { print "selected"; } ?> value="<?php echo $taxonomy; ?>"><?php echo $taxonomyName; ?></option>
        <?php
		if ($taxonomy == "") {
		  $categories["i3d-portfolio"] = get_terms("i3d-portfolio", "hide_empty=1");
		} else {
		  $categories["$taxonomy"] = get_terms($taxonomy, "hide_empty=1");
		}
		
		} ?>
                </select> 
				
				</div>
        <script>
		jQuery("#<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__taxonomy").bind("change", function() {
																															  jQuery(".i3d-portfolio-item-category-<?php echo $rand; ?>").addClass("hidden-block");
																															  jQuery("#i3d-portfolio-item-category-" + jQuery(this).val() + "-<?php echo $rand; ?>").removeClass("hidden-block");
																															  //alert(jQuery(this).val());
																															  });

		jQuery("#<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__display").bind("change", function() {
																															 if (jQuery(this).val() == "") {
																																 jQuery(".i3d-number-of-owl-items-<?php echo $rand; ?>").addClass("hidden-block");
																															 } else {
																																 jQuery(".i3d-number-of-owl-items-<?php echo $rand; ?>").removeClass("hidden-block");
																															 }
																															 
																															 
																															
																															  });

	</script>
		<?php
		//var_dump($instance);
		foreach ($taxonomies as $taxonomy => $taxonomyName) { 
		      $taxn = ($taxonomy == "" ?  "i3d-portfolio" : $taxonomy);
			  ?>
        <div id="i3d-portfolio-item-category-<?php echo $taxonomy;?>-<?php echo $rand; ?>" class='i3d-portfolio-item-category-<?php echo $rand; ?> <?php if ($taxonomy != $instance['taxonomy']) { print "hidden-block"; } ?>'>
		  <?php if (sizeof($categories["$taxn"]) == 0) { ?>
		  
		  <?php } else { ?>
		  
		<div class="input-group tt2" title="Post Type" >
  			<span class="input-group-addon detailed-addon"><i class="fa fa-list fa-fw"></i> <span class='detailed-label'>Categories</span></span>
			<select class='form-control' multiple size=3 name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__categories__<?php echo $taxn; ?>[]">
        <?php
		
		$txn_cat =  @$instance['categories__'.$taxn];
		//var_dump($txn_cat);
		foreach ($categories["$taxn"] as $category => $categoryObj) { ?>
          <option <?php if (@in_array($categoryObj->term_id, @$txn_cat)) { print "selected"; } ?> value="<?php echo $categoryObj->term_id; ?>"><?php echo $categoryObj->name; ?></option>
        <?php } ?>
		    </select>
		</div>
				<p class="help-block">If none are selected, then all categories will be used.</p>

		  <?php } ?>
		
		</div>
		<?php } ?>
		
		
        <?php if (sizeof(I3D_Framework::$portfolioStyles) > 0) { ?>
		<div class="input-group tt2" title="Post Type" >
  			<span class="input-group-addon detailed-addon"><i class="fa fa-paint-brush fa-fw"></i> <span class='detailed-label'>Portfolio Style</span></span>
		<select class='form-control'  name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__portfolio_style">
	    <?php 
		// if there is no prefix, then this is the layout manager level
		if ($prefix == "") { 
            
	
		// else, if there is a prefix, then this is the page level configurations
		} else {

			?>
        <option value="*" ><?php _e("-- Layout Default --","i3d-framework"); ?></option>

		<?php } ?>
		<?php foreach (I3D_Framework::$portfolioStyles as $portfolioStyle => $porfolioStyleName) { ?>
          <option <?php if (@$instance['portfolio_style'] == $portfolioStyle) { print "selected"; } ?> value="<?php echo $portfolioStyle; ?>"><?php echo $porfolioStyleName; ?></option>
        <?php } ?>
                </select> 
				</div>
                <?php } 
?>
		
		
       
		<div class="input-group tt2" title="Order" >
  			<span class="input-group-addon detailed-addon"><i class="fa fa-sort-amount-desc fa-fw"></i> <span class='detailed-label'>Order</span></span>
		
		<select class='form-control' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__order">
		  <option value="">Most Recent</option>
		  <option <?php if (@$instance['order'] == "alpha") { print "selected"; } ?> value="alpha">Alphabetically</option>
		</select>
		</div>
		
		
	<div class="input-group tt2" title="Style" >
  		<span class="input-group-addon detailed-addon"><i class="fa fa-paint-brush fa-fw"></i> <span class='detailed-label'>Style</span></span>

		<select class='form-control' id="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__style" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__style">
	    <?php 
		// if there is no prefix, then this is the layout manager level
		if ($prefix == "") { 
            
	
		// else, if there is a prefix, then this is the page level configurations
		} else {

			?>
        <option value="*" ><?php _e("-- Layout Default --","i3d-framework"); ?></option>

		<?php } ?>
		
          <option <?php if (@$instance['style'] == "") { print "selected"; } ?> value="">Default</option>
		  <option <?php if (@$instance['style'] == "dark") { print "selected"; } ?> value="dark">Dark</option>
        
                </select> 
</div>
		
		
<?php
	}


	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'taxonomy' => '', 'order' => '', 'portfolio_style' => '', 'categories' => '', 'style' => '' ) );
		$taxonomies = array("" => __("Portfolio Items", "i3d-framework"), "i3d-team-member-department" => __("Team Members", "i3d-framework"));
		$rand = rand();
		//var_dump($instance);
?>
<script>
jQuery("a.widget-action").bind("click", function() {
				//shrinkVideoRegion(this);									

});
 
jQuery("a.widget-control-close").bind("click", function() {
				//shrinkVideoRegion(this);									

});

function i3d_change_owlcarousel_display_type<?php echo $rand ; ?>(selectBox) {
  if (selectBox.selectedIndex == 0) {
	jQuery(selectBox).parents('.widget-section').find("#<?php echo $this->get_field_id('number_of_items'); ?>_container").css("display", "none");
  } else {
	jQuery(selectBox).parents('.widget-section').find("#<?php echo $this->get_field_id('number_of_items'); ?>_container").css("display", "inline-block");
  }
}

function i3d_select_owlcarousel_resource<?php echo $rand ; ?>(selectBox) {
	jQuery(".i3d-portfolio-item-category-<?php echo $rand; ?>").css("display", "none");
	
	var selectedResource = selectBox.options[selectBox.selectedIndex].value;
	if (selectedResource == "") {
		selectedResource = "i3d-portfolio";
	}
	jQuery("#i3d-portfolio-item-category-" + selectedResource + "-<?php echo $rand; ?>").css("display", "block");
}
</script><div class='i3d-widget-container'>
   <!--
    <div class='i3d-help-region'>
    <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://youtu.be/JPKGhJgrbTk"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>
    </div>
	-->
    </div>
	<?php $categories = array(); ?>
	
    <div class='i3d-widget-container'>
	
		<div class='widget-section'>
		<div class='widget-column-33'>
        <label class='label-regular' for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Display',"i3d-framework"); ?></label>
		
		<select onchange='i3d_change_owlcarousel_display_type<?php echo $rand ; ?>(this)' style='width: 100%' id="<?php echo $this->get_field_id('display'); ?>" name="<?php echo $this->get_field_name('display'); ?>">
		  <option value="">Contained</option>
		  <option <?php if (@$instance['display'] == "carousel") { print "selected"; } ?> value="carousel">Carousel</option>
		</select>
		</div>
		<div class='widget-column-50' id="<?php echo $this->get_field_id('number_of_items'); ?>_container" <?php if (@$instance['display'] == "") { print "style='display: none'"; } ?>>
        <label class='label-regular' for="<?php echo $this->get_field_id('number_of_items'); ?>"><?php _e('Number of Items',"i3d-framework"); ?></label>
		
		<select style='width: 100%' id="<?php echo $this->get_field_id('number_of_items'); ?>" name="<?php echo $this->get_field_name('number_of_items'); ?>">
		  <option  <?php if (@$instance['number_of_items'] == "2") { print "selected"; } ?> value="1">1</option>
		  <option  <?php if (@$instance['number_of_items'] == "2") { print "selected"; } ?> value="2">2</option>
		  <option <?php if (@$instance['number_of_items'] == "3") { print "selected"; } ?> value="3">3</option>
		  <option <?php if (@$instance['number_of_items'] == "4" || @$instance['number_of_items'] == "") { print "selected"; } ?> value="4">4</option>
		  <option <?php if (@$instance['number_of_items'] == "5") { print "selected"; } ?> value="5">5</option>
		  <option  <?php if (@$instance['number_of_items'] == "6") { print "selected"; } ?> value="6">6</option>
		</select>
		</div>
		</div>	
	  <div class='widget-section'>
        <label class='label-regular' for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e('Resource',"i3d-framework"); ?></label>
		<select onchange='i3d_select_owlcarousel_resource<?php echo $rand; ?>(this)'  id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>">
        <?php foreach ($taxonomies as $taxonomy => $taxonomyName) { ?>
          <option <?php if (@$instance['taxonomy'] == $taxonomy) { print "selected"; } ?> value="<?php echo $taxonomy; ?>"><?php echo $taxonomyName; ?></option>
        <?php
		if ($taxonomy == "") {
		  $categories["i3d-portfolio"] = get_terms("i3d-portfolio", "hide_empty=1");
		} else {
		  $categories["$taxonomy"] = get_terms($taxonomy, "hide_empty=1");
		}
		
		} ?>
                </select> 
				</div>
				<div class='widget-section'>
        <?php 
		//$txnselected = $instance["taxonomy"];
		//if ($txnselected == "") {
		//	$txnselected = "i3d-potfolio";
		//}
		foreach ($taxonomies as $taxonomy => $taxonomyName) { 
	//	var_dump($categories); 
		      $taxn = ($taxonomy == "" ?  "i3d-portfolio" : $taxonomy);
			  
			  ?>
			  
        <div id="i3d-portfolio-item-category-<?php echo $taxn;?>-<?php echo $rand; ?>" class='i3d-portfolio-item-category-<?php echo $rand; ?>' <?php if (@$instance['taxonomy'] != $taxonomy) { print "style='display:none;'"; } ?> >
		  <?php if (sizeof($categories["$taxn"]) == 0) { ?>
		  
		  <?php } else { ?>
		  
		   
		<label class='label-regular' for="<?php echo $this->get_field_id('categories__'.$taxn); ?>"><?php _e('Categories',"i3d-framework"); ?></label>
		<p style='margin: 0px; font-size: 8pt;'>If none are selected, then all categories will be used.</p>
			<select multiple size=3 id="<?php echo $this->get_field_id('categories__'.$taxn); ?>" name="<?php echo $this->get_field_name('categories__'.$taxn); ?>[]">
        <?php
		$txn_cat =  @$instance['categories__'.$taxn];
		foreach ($categories["$taxn"] as $category => $categoryObj) { ?>
          <option <?php if (@in_array($categoryObj->term_id, @$txn_cat)) { print "selected"; } ?> value="<?php echo $categoryObj->term_id; ?>"><?php echo $categoryObj->name; ?></option>
        <?php } ?>
		    </select>
		  <?php } ?>
		</div>
		<?php } ?>
		</div> <!-- end of widget section -->
		
       
		<div class='widget-section'>
        <label class='label-regular' for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order',"i3d-framework"); ?></label>
		
		<select id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
		  <option value="">Most Recent</option>
		  <option <?php if (@$instance['order'] == "alpha") { print "selected"; } ?> value="alpha">Alphabetically</option>
		</select>
		</div>
		
		<div class='widget-section'>
        <label class='label-regular' for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Style',"i3d-framework"); ?></label>
		
		<select id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>">
		  <option value="">Default</option>
		  <option <?php if (@$instance['style'] == "dark") { print "selected"; } ?> value="dark">Dark</option>
		</select>
		</div>
		
</div>
	<?php
    }
}


?>
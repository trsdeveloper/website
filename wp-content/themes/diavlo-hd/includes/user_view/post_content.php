<?php
function i3d_post_content($page_id_override = "") {
	global $lmImageDefaults;
	global $post;  
	global $pageColumns;
	global $myPageID;
	global $page_id;
	global $postCat;
	global $pageTemplate;
	global $wp_query;
 	global $i3d_using_external_header_call, $i3d_external_page_body;
 

	if (@$i3d_using_external_header_call) {
	  echo $i3d_external_page_body;
	  return;
	}
	
    $single = false;

	// $page_id_override is defined when this function is called by the Content Region widget, when multiple content regions are placed in a page
	if ($page_id_override != "") {
		$temp_wp_query = $wp_query;
		$wp_query = new WP_Query('page_id='.$page_id_override);
	}	  
	  
	if (isset($postCat) && isset($postCat->taxonomy) && ($postCat->taxonomy == "i3d-faq-category" || $postCat->taxonomy == "i3d-team-member-department")) {
		echo "<h2>".$postCat->name."</h2>";
	}
	
	if (I3D_Framework::use_global_layout()) {
		$page_content_type 	= get_post_meta($page_id, "selected_page_type", true);	
		if ($page_content_type == "") {
			$pageMeta = get_post_meta($page_id);
			if (@$pageMeta['_wp_page_template'][0] != "") {
				$page_content_type = str_replace("template-", "", str_replace(".php", "", $pageMeta['_wp_page_template'][0]));
			}
		}
	} else {
		$page_content_type = "";
	}
	
	if ($pageTemplate == "blog" || $page_content_type == "blog" ) {
		$doBlogSummary 	= true;
		$blogData 		= get_post_meta($page_id, "blog", true);
		
		if (!is_array($blogData)) {
			$blogData = array();
		}
	} else {
		$blogData = array();
	}
			
	$blogData = wp_parse_args( (array) $blogData, array( 'style' => '', 'columns' => '' ) );

	// HANDLE CASE OF THIS BEING WOOCOMMERCE CONENT
	if (function_exists("is_woocommerce") && is_woocommerce() && I3D_Framework::hasExtension("woocommerce")) {
		global $woocommerce;
		
		// as of version 3.3, woo commerce now has built in injection into where the post content is
		if ( version_compare( $woocommerce->version, "3.3", "<" ) ) {
			woocommerce_content();
			return;	
		} 
	}
  
  	// HANDLE THE CASE OF THIS BEING TRIBE EVENTS CALENDAR CONTENT
	if (@$_GET['post_type'] == "tribe_events" || @$_POST['post_type'] == "tribe_events" || $postCat->name == "tribe_events") {
		print "<div id='tribe-events'>";
		tribe_get_view();
		print "</div>"; 
		return;
	}

	if ($wp_query->have_posts()) {
		$doneFirstPost 	= false;
		$doRowStart 	= true;
		$doRowEnd 		= false;
		$columnCount 	= 0;
		$galleryIDs 	= array();

		// configure settings if this is a search results page
		if (is_search()) {
	  		$doBlogSummary = true;
	  		$blogData['style'] = "search";
	  		echo "<h2 style='margin-top: 0px;'>".__("Search Results", "i3d-framework")."</h2>";
  		
		// if this is a single blog post, or the size of the post is a single, then do not display a blog post
		} else if (is_single() || $wp_query->post_count == 1) {
	  		$doBlogSummary = false;
  		    $single = true;
		}

		if ($wp_query->post_count == 1) {
			$single = true;	
		} 
		
        if (!$single && $blogData['style'] == "timeline") {
			echo "<div class='blog-type-timeline'>";	
		} else if (!$single && $blogData['style'] == "grid") {
			echo "<div class='blog-type-grid'>";	
		}
		
		
		$doMasonry = false;
		while ($wp_query->have_posts()) {
			$wp_query->the_post();
			
			$doRowBreak 	= false;
			$doPlaceholder 	= false;
			$imageURL 		= "";
			$youtubeURL 	= "";
			$postMonth 		= substr($post->post_date, 0, 7);
			$postClasses 	= "boxit ";
			
    		if ($blogData['style'] == "grid" || $blogData['style'] == "timeline") {
				if (($blogData['lead_with_full_width_post'] == "" || 
					 	$blogData['lead_with_full_width_post'] == "1") && 
					 	!$doneFirstPost && 
					 	$blogData['style'] != "timeline" && 
					 	@$_GET['paged'] == "") {
					
					$postClasses 	.= "span12";
					$doneFirstPost 	= true;
					$doneLeadPost 	= true;

				} else if ($blogData['columns'] == 3) {
					
					$postClasses 	.= "span4";
					$doMasonry 		= true;
					$columnCount++;
				
				} else if ($blogData['columns'] == 4) {
					
					$postClasses 	.= "span3";
					$doMasonry 		= true;
					$columnCount++;
				
				} else {
					$postClasses	.= "span6";
					$doMasonry 		= true;
					$columnCount++;
				}
				
			} else if ($blogData['style'] == "rows") {
	  			$postClasses .= "rowit ";
				
			} else if ($blogData['style'] == "") {
				$postClasses = "";
			}

  			if (strstr($postClasses, "span12")) {
				$doRowStart = true;
				$doRowEnd 	= true;
				
			} else if ($columnCount == $blogData['columns']) {
				$doRowEnd 	= false;
				$doRowStart = false;
				if (@$blogData['style'] == "timeline") {
					if ($postMonth != $currentTimelineMonth) {
						$currentTimelineMonth = $postMonth;
						$doRowBreak = true;
						$doPlaceholder = true;
					  	// $doRowEnd = true;
				   } 
				}					
				
			} else if ($columnCount == 1) {
				$doRowStart = true;
				$doRowEnd 	= false;

			} else {
				$doRowStart = false;
				$doRowEnd 	= false;
				if ($blogData['style'] == "timeline") {
				   if ($postMonth != $currentTimelineMonth) {					  
					   $currentTimelineMonth = $postMonth;
					   $doRowBreak = true;
					  // $doRowEnd = true;
				   } 
				}				
			}
			if (!isset($currentTimelineMonth) || $currentTimelineMonth == "") {
				$currentTimelineMonth = $postMonth;
			}

			if ($doRowStart) { 
				if ($blogData['style'] == "timeline" && !is_single()) {
					$currentTimelineMonth = $postMonth;
				?>
                <div class='row-fluid text-center'>
                <i class='fa fa-comments-o fa-4x'></i>
                <div class='timeline-date-block'><?php echo date("M Y", strtotime($post->post_date)); ?></div></div><?php  
			  } ?>
  <div class='row-fluid<?php if ($doMasonry && !is_single()) { ?> masonry-container<?php } else { ?> nomasonry<?php } ?>'>
      <div class='gutter-sizer<?php if ($blogData['columns'] > 2) {  echo "-".$blogData['columns']; } ?>'></div>

<?php 		} else if ($doRowBreak) { 
				$doneRowBreak = true;
				
				?>
	
    </div>
    <!-- close previous row -->
   
    <div class='row-fluid'><div class='timeline-date-block'><?php echo date("F Y", strtotime($post->post_date)); ?></div></div>
    <div class='row-fluid row-break masonry-container'>
    <div class='gutter-sizer'></div>

<?php 		
   if ($doPlaceholder) { ?>
       <div class='left-placeholder boxit span6'></div>
   <?php } 
} ?>
  <div id="post-<?php the_ID(); ?>" <?php post_class($postClasses); ?>>
  <?php

    if (get_the_content() != "" && $post->post_type == "post" || $post->post_type == "i3d-faq" || $post->post_type == "i3d-portfolio-item" || $post->post_type == "i3d-team-member" || is_search()) {
 		  
	  if (!is_single() && has_post_format("image")) {
		$matches = array();
		$theContent = get_the_content();
		preg_match('/(<img(.*?)\/>)/', $theContent, $matches);
		if (sizeof($matches) > 0) {
			preg_match('/src=[\'"](.*?)[\'"]/', $matches[1], $srcMatches);
			$imageURL = $srcMatches[1];
		}
		
	  } else if (!is_single() && has_post_format("gallery")) {
		$matches = array();
		$theContent = get_the_content();
		//print $theContent;
		$pattern = '/\[gallery(([\s]?(columns)="(.*?)")|([\s]?(link)="(.*?)")|([\s]?(ids)="(.*?)")|([\s]?(orderby)="(.*?)"))*\]/';
		preg_match($pattern, $theContent, $matches);
					foreach ($matches as $position => $match) {
						$nextPosition = $position + 1;
						if ($match == "columns") {
							$columns = $matches["{$nextPosition}"];
						} else if ($match == "ids") {
							$ids = $matches["{$nextPosition}"];
						} else if ($match == "link") {
							$link = $matches["{$nextPosition}"];
							
						} else if ($match == "orderby") {
							$orderby = $matches["{$nextPosition}"];
							
						}
					}
					$galleryIDs = explode(",", $ids);
		
		
		  
	  } else if (!is_single() && has_post_format("video")) {
			$theContent = get_the_content();
			

		preg_match('/(http[s]?:\/\/(www.)?youtu[^\/]*?\/(.*))/', $theContent, $matches);
		if (sizeof($matches) > 0) {
			$youtubeURL = $matches[0];
		}
						   
	  }
	  
	
	  if (has_post_thumbnail() && !is_search()) {
		  if (!is_single()) {
			echo '<a href="'.get_the_permalink().'">';  
		  }
		  $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
		  $thumbnailType = "posts-small";
		 // $thumbnailKind = get_post_meta($post->ID, 'luckymarble_post_thumbnail', true);
		 // print $thumbnailKind;
		  if (is_single() && false) {
			  if (false && ($thumbnailKind == "" || $thumbnailKind == "news-featured")) {
			    $thumbnailType =  "news-featured-{$pageColumns}";

			  } else {
				$thumbnailType = $thumbnailKind;
			  }
		  }
		  

		  if ($blogData['style'] == "grid" || $blogData['style'] == "timeline" || @$blogData['image_size'] == "full") {
		    the_post_thumbnail('full');
		  
		  } else  if ($blogData['style'] == "rows" && $blogData['image_size'] == "medium") {
		    the_post_thumbnail('full', array('class' => "post-medium-image pull-left"));


		  } else  if ($blogData['style'] == "rows" && $blogData['image_size'] == "small") {
		    the_post_thumbnail('full', array('class' => "post-small-image pull-left"));


		  } else if ($post->post_type == "i3d-team-member") {
		    the_post_thumbnail('full', array('class' => "post-team-member pull-left well"));

		  } 
		  if (!is_single()) {
			echo '</a>'; // close hyperlink  
		  }
	  } else if (has_post_format("gallery") && sizeof($galleryIDs) > 0) {
		  	   wp_register_style( 'i3d-nivo-slider',  get_template_directory_uri() .'/Library/sliders/nivo-slider/css/nivo-slider.css');
	   wp_register_script('i3d-nivo-slider-js', get_template_directory_uri() .'/Library/sliders/nivo-slider/js/jquery.nivo.slider.js', array('jquery'), '1.0' );

     wp_enqueue_style( 'i3d-nivo-slider' );
     wp_enqueue_script( 'i3d-nivo-slider-js' );
	 

		  
		  ?>
                    <?php echo wp_get_attachment_image( $galleryIDs[0], "full", "", array("class"	=> "attachment-full attachment-placeholder", "id" => "attachment-placeholder-".$post->ID)); ?>

   <?php
   $nivoClasses = "";
 if ($blogData['style'] == "grid" || $blogData['style'] == "timeline" || $blogData['image_size'] == "full") {
		    $nivoClasses = "";
		  
		  } else  if ($blogData['style'] == "rows" && $blogData['image_size'] == "medium") {
		       $nivoClasses = " post-medium-image pull-left";





		  } else  if ($blogData['style'] == "rows" && $blogData['image_size'] == "small") {
		       $nivoClasses = " post-small-image pull-left";

		  } 		
		  ?>
<div id="post-slider-<?php echo $post->ID; ?>" class="nivoSlider <?php echo $nivoClasses; ?>">

<?php

	  foreach ($galleryIDs as $imageID) {
			  //print $imageID."<br>";
			  ?>
              <a href="#"><?php
              echo wp_get_attachment_image( $imageID, "full" );
              ?></a>

              <?php
		  }
		  ?>
</div>

<script type="text/javascript">
jQuery(window).load(function() {
  // init the nivo slider on the #slider div
  jQuery('#post-slider-<?php echo $post->ID; ?>').nivoSlider({pauseTime: 5500, effect: 'fade', controlNav: false, prevText: '', nextText: '', afterLoad: function() { jQuery("#attachment-placeholder-<?php echo $post->ID; ?>").css("display", "none");  }});


});
</script>
	<?php
		  
	  } else if ($youtubeURL != "" && !is_search()) {
		  //<iframe width="853" height="480" src="//www.youtube.com/embed/ChTRkt8Ed5w?list=UUixO2aJr5za6HZ1Tg5JwBtA" frameborder="0" allowfullscreen></iframe>
		 $youtubeURL = trim(str_replace("https:", "", str_replace("http:", "", str_replace("youtu.be", "www.youtube.com/embed", $youtubeURL))));


		$youtubeCode =  '<iframe class="embed-responsive-item" src="'.$youtubeURL.'" frameborder="0" allowfullscreen></iframe>';
	    $youtubeCode = '<div class="embed-responsive embed-responsive-4by3">'.$youtubeCode."</div>";
 
	  
		  if ($blogData['style'] == "grid" || $blogData['style'] == "timeline" || $blogData['image_size'] == "full") {
		    echo $youtubeCode;
		  
		  } else  if ($blogData['style'] == "rows" && $blogData['image_size'] == "medium") {
		    echo "<div class='post-medium-image pull-left'>";
			echo $youtubeCode;
			echo "</div>";



		  } else  if ($blogData['style'] == "rows" && $blogData['image_size'] == "small") {
		    echo "<div class='post-small-image pull-left'>";
			echo $youtubeCode;
			echo "</div>";

		  } 
	    
	  } else if ($imageURL != "" && !is_search()) {
		  $attachmentID = i3d_get_attachment_id_from_url($imageURL);
		//  echo wp_get_attachment_image( $attachmentID, "full" );
		  
		  if ($blogData['style'] == "grid" || $blogData['style'] == "timeline" || $blogData['image_size'] == "full") {
		    echo wp_get_attachment_image( $attachmentID, "full" );
		  
		  } else  if ($blogData['style'] == "rows" && $blogData['image_size'] == "medium") {
		    echo wp_get_attachment_image( $attachmentID, "full", "", array('class' => "post-medium-image pull-left") );


		  } else  if ($blogData['style'] == "rows" && $blogData['image_size'] == "small") {
		    echo wp_get_attachment_image( $attachmentID, "full", "", array('class' => "post-small-image pull-left") );


		  } else if ($post->post_type == "i3d-team-member") {
		    echo wp_get_attachment_image( $attachmentID, "full", "", array('class' => "post-team-member pull-left") );

		  }
		  
		//  echo "<img src='{$imageURL}' alt='' class='attachment-full wp-post-image' width='100%' />";
	  
	  } else if (has_post_format("audio") && !is_search() && !is_single()) {
		$matches = array();
		$theContent = get_the_content();

		$pattern = '/\[audio(([\s]?(mp3)="(.*?)")|([\s]?(loop)="(.*?)")|([\s]?(autoplay)="(.*?)")|([\s]?(preload)="(.*?)"))*\]/';
		preg_match($pattern, $theContent, $matches);
					foreach ($matches as $position => $match) {
						$nextPosition = $position + 1;
						if ($match == "mp3") {
							$mp3 = $matches["{$nextPosition}"];
						} else if ($match == "loop") {
							$loop = $matches["{$nextPosition}"];
						} else if ($match == "autoplay") {
							$autoplay = $matches["{$nextPosition}"];
							
						} else if ($match == "preload") {
							$preload = $matches["{$nextPosition}"];
							
						}
					}
							$audioHTML = do_shortcode('[audio mp3="'.$mp3.'"][/audio]');

		  if ($blogData['style'] == "grid" || $blogData['style'] == "timeline" || $blogData['image_size'] == "full") {
		    echo $audioHTML;
		  
		  } else  if ($blogData['style'] == "rows" && $blogData['image_size'] == "medium") {
		    echo "<div class='post-medium-image pull-left'>";
			echo $audioHTML;
			echo "</div>";



		  } else  if ($blogData['style'] == "rows" && $blogData['image_size'] == "small") {
		    echo "<div class='post-small-image pull-left'>";
			echo $audioHTML;
			echo "</div>";

		  } 					
	} else { 
	}
	if ($blogData['style'] == "timeline") {
	  print "<div class='post-content-container'><div class='timeline-marker-circle'></div><div class='timeline-marker-arrow'></div>";	
	}
    ?>
    <?php edit_post_link('<i class="icon-pencil fa fa-pencil i3d-edit-post-link"></i>', '', ''); ?>
    <?php if ((!has_post_format( 'aside' ) && !has_post_format("status") && !has_post_format("quote")) || (is_single() && !has_post_format("quote"))) { ?>
    <?php if ($post->post_type == "i3d-team-member") {
		  
		  //var_dump($teamMemberData);
		  $teamMemberContactPoints = (array) get_post_meta($post->ID, "team_member_contact_points", true);	
		  if (sizeof($teamMemberContactPoints) > 0) {
	$alternateIconMapping = array("email" => "envelope-o", "googleplus" => "google-plus", "blog" => "rss", "website" => 'external-link');

			  echo "<ul class='team-member-contact-points'>";
		  			  foreach ($teamMemberContactPoints as $contactInfo) {
						  if ($contactInfo['type'] != "" && $contactInfo['value'] != "") {
			$icon = $contactInfo['type'];
						$iconsDisplayed = true;
						if (array_key_exists($icon, $alternateIconMapping)) {
						  //print "yes $icon";
						  $icon = $alternateIconMapping["$icon"];	
						} 
						?>
					<li><a <?php if (@$contactInfo['type'] != "email") { ?>target="_blank"<?php } ?> href='<?php echo @$contactInfo['value']; ?>'><span class="fa-stack fa-sm">
						  <i class="fa fa-circle fa-stack-2x"></i>
						  <i class="fa fa-<?php echo @$icon; ?> fa-stack-1x fa-inverse"></i>
						</span></a></li>
		    <?php 
		 			 }
					  }
			echo "</ul>";
			
		  
		  }

		} else if ($post->post_type == "i3d-portfolio-item") {
		  
		  //var_dump($teamMemberData);
		  $portfolioItemContactPoints = (array) get_post_meta($post->ID, "portfolio_item_contact_points", true);	
		  if (sizeof($portfolioItemContactPoints) > 0) {
	$alternateIconMapping = array("email" => "envelope-o", "googleplus" => "google-plus", "blog" => "rss", "website" => 'external-link');

			  echo "<ul class='team-member-contact-points'>";
		  			  foreach ($portfolioItemContactPoints as $contactInfo) {
						  if ($contactInfo['type'] != "" && $contactInfo['value'] != "") {
			$icon = $contactInfo['type'];
						$iconsDisplayed = true;
						if (array_key_exists($icon, $alternateIconMapping)) {
						  //print "yes $icon";
						  $icon = $alternateIconMapping["$icon"];	
						} 
						?>
					<li><a <?php if (@$icon['type'] != "email") { ?>target="_blank"<?php } ?> href='<?php echo @$contactInfo['value']; ?>'><span class="fa-stack fa-sm">
						  <i class="fa fa-circle fa-stack-2x"></i>
						  <i class="fa fa-<?php echo @$icon; ?> fa-stack-1x fa-inverse"></i>
						</span></a></li>
		    <?php 
		 			 }
					  }
			echo "</ul>";
			
		  
		  }
			
		}
?>
	
	<h3><a class='entry-title' href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><?php
	}
  }

  ?><div class="entry <?php if (get_the_content() == "") { echo 'no-content'; } ?>">
    
<?php


  if($post->post_type == "post" || is_search()) {
	i3d_render_blog_metadata($post, $blogData, 'top');

  }
      if (has_post_format("quote")) {
		echo "<blockquote>";
	}
  ?>
	<?php
	  if ($doBlogSummary) {
		  if (has_post_format("link")) { 
		    the_content($blogData['read_more']);
		  } else if (has_post_format("chat")) {
			ob_start();
			the_content("");
			$theContent = ob_get_clean();
			
			$theContent = preg_replace('/<li>(.*):/i', '<li class="chat-line"><span class="label label-default">$1</span>', $theContent);
			//print "<br><br>";
			print $theContent;
		
           
		  } else {
		    the_excerpt($blogData['read_more']);
		  }
		if (has_post_format("quote")) {
			echo "<footer>";
			  echo "<cite>";
			   the_title(); 
			  echo "</cite>";
			echo "</footer>";
			echo "</blockquote>";
		}
		  if ((@$blogData['show_comments_status'] == "1") && @$blogData['comments_status_location'] == "1") { 
		
			if (@$blogData['comments_status_style'] == "1") {
		$icon = "<i class='icon-comments fa fa-comments-o'></i>";
		$pullClass = "";
		if (@$blogData['read_more_location'] == "left" || @$blogData['read_more_location'] == "") {
		  $pullClass = "pull-right";	
		
		} else {
		  $pullClass = "pull-left";	
		}
		comments_popup_link("{$icon} 0", "{$icon} 1", "{$icon} %", "{$pullClass} i3d-comment-link", "");
	} else {
		if ($displayedOne) { $separator = " | "; } else {
			$separator = "";
		}
		 $displayedOne = true;
		if (comments_open()) {
			echo "{$separator}";
		}
		comments_popup_link(" ".__("No Comments", "i3d-framework"), " 1 ".__("Comment", "i3d-framework"), " % ".__("Comments", "i3d-framework"), '', '');
	}
		  }

		if (@$blogData['read_more_location'] == "left" || @$blogData['read_more_location'] == "") {
		  $pullClass = "pull-left";	
		
		} else {
		  $pullClass = "pull-right";	
		}
		if (!has_post_format("status") && !has_post_format("link")) {
		  ?>
          <a class='<?php echo $pullClass;  ?> read-more-link' href='<?php the_permalink(); ?>'><?php echo @$blogData['read_more']; ?><?php
		  if (@$blogData['read_more_arrow'] == "" || @$blogData['read_more_arrow'] == "0") { 
		 
		 } else if (@$blogData['read_more_arrow'] == "1") { 
		  	print " <i class='icon-angle-right fa fa-angle-right'></i>"; 
		  } else {
		  	print " <i class='fa {$blogData['read_more_arrow']}'></i>"; 
			  
		  }?></a><?php
		}
	 } else {
		ob_start();
		if ($post->post_type == "i3d-team-member") {
		  $teamMemberData = (array) get_post_meta($post->ID, "team_member_data", true);	
		  
		  //var_dump($teamMemberData);
		  $teamMemberContactPoints = (array) get_post_meta($post->ID, "team_member_contact_points", true);	
		  if (sizeof($teamMemberData) > 0) {
			  echo "<ul class='team-member-data'>";
			  
		  			  foreach ($teamMemberData as $data) {
						//  var_dump($data);
						if ($data['value'] != "") { 
			?>
		    <li><label><?php echo $data['label']; ?>:</label> <?php echo $data['value']; ?></li><?php 
		 			 }
					  }
		    echo "</ul>";
		  
		  }

		} else if ($post->post_type == "i3d-portfolio-item") {
		  $portfolioItemData = (array) get_post_meta($post->ID, "portfolio_item_data", true);	
		  
		  //var_dump($teamMemberData);
		  $portfolioItemContactPoints = (array) get_post_meta($post->ID, "portfolio_item_contact_points", true);	
		  if (sizeof($portfolioItemData) > 0) {
			  echo "<ul class='team-member-data'>";
			  
		  			  foreach ($portfolioItemData as $data) {
						//  var_dump($data);
						if ($data['value'] != "") { 
			?>
		    <li><label><?php echo $data['label']; ?>:</label> <?php echo $data['value']; ?></li><?php 
		 			 }
					  }
		    echo "</ul>";
		  
		  }
			
		}
		the_content();
		$output = ob_get_clean();
		if (has_post_format("chat")) {
					$output = preg_replace('/<li>(.*):/i', '<li class="chat-line"><span class="label label-default">$1</span>', $output);
	
		}
	    echo str_replace("Missing Attachment", "" ,$output);
		
		    if (has_post_format("quote")) {
			echo "<footer>";
			  echo "<cite>";
			   the_title(); 
			  echo "</cite>";
			echo "</footer>";
			echo "</blockquote>";
		
				  } 
			
			//$theContent = preg_replace('/<li>(.*):/i', '<li class="chat-line"><span class="label">$1</span>', $theContent);
			//print "<br><br>";
		//	print $theContent;
		
           
	  } ?>
      
    <?php


  if($post->post_type == "post") {
	i3d_render_blog_metadata($post, $blogData, 'bottom');

  }
  

  ?>
  
  </div><!-- end div.entry -->

  <?php
  if($post->post_type == "post") {
    ?>
<div id="comments">
	<?php comments_template(); ?>
</div><!-- end div#comments -->

	<?php } else  {?>
		<div id="comments">
		<?php comments_template();?>
		</div><!-- end div#comments -->
	<?php }	?>
    </div><!-- end of div#post-## -->
	
    <!-- commented out for masonry <div style='clear: both;'></div>-->

	<?php
      	if ($blogData['style'] == "timeline") {
	  		print "</div><!-- end of div.blog-type-timeline -->";	
		}
	?>
    <?php
  if ($doRowEnd || is_single()) {
  //if ($doRowEnd) { // re-enabled the above if statement as the two column was ending up as single column.  No detected bad side effects

  ?>
  </div><!-- row end -->
  <?php } 

		} // end while
 if (($blogData['style'] == "grid" || $blogData['style'] == "timeline") && !is_single()) { ?>
   </div>
  <!-- final row end -->
  <?php
 // if ($doneRowBreak) {
	//  print "</div>";
 // }
 // echo "</div> <!-- end of .masonryContainer --> ";
  }
  if (($blogData['style'] == "grid" || $blogData['style'] == "timeline") && !is_single()) {
  ?>
  <script>

  jQuery(document).ready(function(){
    //Init jQuery Masonry layout
	//alert("yes <?php echo $blogData['columns']; ?>");
    init_masonry(<?php echo $blogData['columns']; ?>);
});</script>
  <?php
  }
          if (!$single && ($blogData['style'] == "timeline" ||  $blogData['style'] == "grid")) {
		  echo "</div> <!-- end of timeline -->";	
		}

  // end of has posts
  } else if (!is_404()) {
   print "<p style='text-align: center; padding: 20px;'>".__("There are no results matching the search criteria","i3d-framework")."</p>";
 
  }
  ?>
  <div style="text-align:center;">
<?php posts_nav_link(' &#183; ', 'previous page', 'next page'); ?>
</div>
  
  <?php
 if (@$post->post_type == "page" && (@$pageTemplate == "team-members" || $page_content_type == "team-members")) {
	 i3d_render_team_members();
 } else if (@$post->post_type == "page" && (@$pageTemplate == "faqs"  || $page_content_type == "faqs")) {
	i3d_render_faqs();
 } else if (@$post->post_type == "page" && (@$pageTemplate == "sitemap" || $page_content_type == "sitemap")) {
// } else if (@$post->post_type == "page" && ($page_content_type == "sitemap")) {
	 i3d_sitemap_content(false);
	 echo "<div style='clear: both;'></div>";
 } else if (is_404()) {
	i3d_404_content();
 }
 if (false) {
 wp_link_pages();
 }

  if ($page_id_override != "") {
	  $wp_query = $temp_wp_query;
	  wp_reset_postdata();
  }
}

function i3d_get_post_format_icon_stack($postFormat, $postFormatSize) {
	if ($postFormat == "") {
		$postFormat = "standard";
	}
	$icons = array('standard' => 'thumb-tack',
				   'aside' => "comment", 
				   'gallery' => "th", 
				   'link' => "link", 
				   'image' => "picture-o", 
				   'quote' => "quote-left", 
				   'status' => "check", 
				   'video' => "film", 
				   'audio' => "music", 
				   'chat' => "comments-o");
    if ($postFormatSize == "0" || $postFormatSize == "") {
	} else if ($postFormatSize == "1") {
		
		$output = '<i class="fa fa-'.$icons["$postFormat"].'"></i>';	
	} else {
		$output = '<span class="fa-stack-post-format fa-stack fa-'.$postFormatSize.'" title="'.$postFormat.'">';
		$output .= '<i class="fa fa-square fa-stack-2x"></i>';
		$output .= '<i class="fa fa-'.$icons["$postFormat"].' fa-stack-1x fa-inverse"></i>';
		$output .= '</span>';
	}
	
	return $output;
}

function i3d_render_blog_metadata($post, $blogData, $location) {
	if (($location == 'top' && (@$blogData['meta_data_location'] == "" || @$blogData['meta_data_location'] == "above")) ||
	    ($location == 'bottom' && @$blogData['meta_data_location'] == "below")) {
		$displayedOne = false;

    	ob_start();
	 	$postType = get_post_format($post);
	    if ($postType == "") {
			//$postType = "standard";
		}
	   // print "x".$postType;
		if (@$blogData['show_post_format'] == "1") {
			
			echo i3d_get_post_format_icon_stack($postType, @$blogData['show_post_format']).' <a href="'.get_post_format_link($postType).'">'.ucwords($postType == "" ? "post" : $postType)."</a>";
			$displayedOne = true;
		} else if (@$blogData['show_post_format'] != "0" &&@ $blogData['show_post_format'] != "") {
			echo i3d_get_post_format_icon_stack($postType, @$blogData['show_post_format']);
		}
	

     	if (@$blogData['show_date'] == "" || @$blogData['show_date'] == 1) { 
			if ($displayedOne) { echo " | "; }
				?><span class='date-time'><i class='fa fa-clock-o'></i> <span class='updated'><?php the_time(get_option('date_format')) ?></span></span><?php
	 			$displayedOne = true;
	 		}

	 		if ((@$blogData['show_author'] == "" || @$blogData['show_author'] == 1) && $postType != "aside" && $postType != "link" && $postType != "status") {
	   			if ($displayedOne) { 
					echo " | "; 
				}
				$theAuthor = get_the_author();
				$authorDescription = get_the_author_meta("description");
				$authorRegistered    = get_the_author_meta("user_registered");
				$avatar = get_avatar( get_the_author_meta("user_email"), 50);
				$avatar = str_replace("<img ", "<img class='gravatar-img' ", $avatar);
				?><span class='author'><i class='fa fa-user'></i>
				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" data-toggle="tooltip" title="<div class='author-data-container'><?php echo $avatar; ?><b><?php the_author();?></b><br/><b><?php _e("Since","i3d-framework"); ?></b> <?php echo @date(get_option("date_format"), $authorRegistered); ?><br/><?php echo number_format_i18n( get_the_author_posts() ); ?> Posts<br/><?php echo $authorDescription; ?><div style='clear: both;'></div></div>"><span class='vcard author'><span class='fn'><?php the_author() ?></span></span></a>
				</span><?php 
			} 
	   
			if (@$blogData['show_tags'] == "" || @$blogData['show_tags'] == "1") { 
				the_tags(' | <i class="fa fa-tags"></i> ', ' &bull; ', ''); 
			}
				
	 		if (@$blogData['show_categories'] == "" || @$blogData['show_categories'] == 1) {
		 		ob_start();
		 		the_category(' &bull; ');
		 		$output = ob_get_clean();
				$theCategories = get_the_category();
				//print sizeof($theCategories);
				//var_dump($theCategories);
				if (sizeof($theCategories) == 1 && $theCategories[0]->cat_name == "Uncategorized") {
				} else {
		 		if ($output != "") {
					if ($displayedOne) { echo " | "; }
		 			$displayedOne = true;
					echo '<i class="fa fa-filter"></i> '.$output;
		 		}
			}
			}

			if ((@$blogData['show_comments_status'] == "" || @$blogData['show_comments_status'] == "1") && @$blogData['comments_status_location'] != "1") { 
				if (@$blogData['comments_status_style'] == "1") {
					$icon = "<i class='icon-comments fa fa-comments-o'></i>";
					comments_popup_link("{$icon} 0", "{$icon} 1", "{$icon} %", "pull-right i3d-comment-link", "");
				} else {
					if ($displayedOne) { 
						$separator = " | "; 
					} else {
						$separator = "";
					}
		 			$displayedOne = true;
					if (comments_open()) {
						echo "{$separator}";
					}
					comments_popup_link(" ".__("No Comments", "i3d-framework"), " 1 ".__("Comment", "i3d-framework"), " % ".__("Comments", "i3d-framework"), '', '');
				}
			}
	
	   	$output = ob_get_clean();
	    
		if ($output != "") {
			?>
            <div class='post-meta-data-<?php echo $location; ?>'>
    		<?php if (@$blogData['show_hr'] == "" || 
					  @$blogData['show_hr'] == "above" ||
					  @$blogData['show_hr'] == "above-below") { ?>
					  <hr class='i3d-hr-<?php echo @$blogData['hr_border']; ?>' / >
                   <?php 
				   } ?>
    		<small>
<?php
		   print $output;

		    ?>
     </small>
    		<?php if (@$blogData['show_hr'] == "" || 
					  @$blogData['show_hr'] == "below" ||
					  @$blogData['show_hr'] == "above-below") { ?>
					  <hr class='i3d-hr-<?php echo @$blogData['hr_border']; ?>' / >
                   <?php 
				   } ?>
	   </div><?php
		} else {

		}

	}


}

function i3d_404_content() {
	global $myPageID;
	$settingOptions = get_option('i3d_general_settings');
	echo "<div class='row-fluid text-center padding-bottom-20'>";
	echo "<div class='span12'>";
	echo nl2br($settingOptions["404_message"]);
	echo "</div>";
	echo "</div>";

	//echo "<div>";

	if (@$settingOptions['404_show_search_bar'] == 1) {
	?>
    <div class='container-wrapper'>
  	<div class='container'>
    <div class='row'>
      <div class='col-xs-12'>
            	 <?php the_widget( 'I3D_Widget_SearchForm', I3D_Widget_SearchForm::getPageInstance($myPageID, array()));  ?>

      </div>
    </div>


  </div>
</div>

    <?php
	}
	$showSitemap = $settingOptions["404_show_sitemap"] == 1;
	$showArchives = $settingOptions["404_show_archives"] == 1;
	$showRecent = $settingOptions["404_show_most_recent_posts"] == 1;

	$totalRegions = $settingOptions["404_show_sitemap"] + $settingOptions["404_show_archives"] + $settingOptions["404_show_most_recent_posts"];

	echo "<div class='row-fluid'>";
    if ($totalRegions == 3) {
		echo "<div class='span4 col-sm-4'>";
		   the_widget( 'WP_Widget_Pages');
		echo "</div>";
		
		echo "<div class='span4 col-sm-4'>";
		  the_widget( 'WP_Widget_Archives' );
		echo "</div>";
		
		echo "<div class='span4 col-sm-4'>";
		 the_widget( 'WP_Widget_Recent_Posts');
		echo "</div>";

	} else if ($totalRegions == 2) {
		echo "<div class='span6 col-sm-6'>";
		  if ($showSitemap) {
			   the_widget( 'WP_Widget_Pages');
		  } else if ($showArchives) {
			   the_widget( 'WP_Widget_Archives' );
		  }

		echo "</div>";
		
		echo "<div class='span6 col-sm-6'>";
		  if ($showSitemap) {
			  the_widget( 'WP_Widget_Archives' );
		  } else {
			   the_widget( 'WP_Widget_Recent_Posts');
		  }
		echo "</div>";

	} else if ($totalRegions == 1) {
		echo "<div class='span12 col-xs-12'>";
		  if ($showSitemap) {
			the_widget( 'WP_Widget_Pages');
			//echo do_shortcode("[sitemap]");

		  } else if ($showArchives) {
			  the_widget( 'WP_Widget_Archives' );
		  } else if ($showRecent) {
			  the_widget( 'WP_Widget_Recent_Posts');
		  }
		echo "</div>";

	}
	print "</div>";



}


function i3d_sitemap_content($call_post_content = true) {
	global $myPageID;
	$settingOptions = get_post_meta($myPageID, "sitemap", true);
 
    if ($call_post_content) {
		i3d_post_content();
	}


	echo "<div>";
	$showSitemap = $settingOptions["show_sitemap"] == 1;
	$showArchives = $settingOptions["show_archives"] == 1;
	$showRecent = $settingOptions["show_most_recent_posts"] == 1;

	$totalRegions = $settingOptions["show_sitemap"] + $settingOptions["show_archives"] + $settingOptions["show_most_recent_posts"];

	echo "<div class='row-fluid'>";
    if ($totalRegions == 3) {
		echo "<div class='span4 col-sm-4'>";
		   the_widget( 'WP_Widget_Pages');
		echo "</div>";
		echo "<div class='span4 col-sm-4'>";
		  the_widget( 'WP_Widget_Archives' );
		echo "</div>";
		echo "<div class='span4 col-sm-4'>";
		 the_widget( 'WP_Widget_Recent_Posts');
		echo "</div>";

	} else if ($totalRegions == 2) {
		echo "<div class='span6 col-sm-6'>";
		  if ($showSitemap) {
			   the_widget( 'WP_Widget_Pages');
		  } else if ($showArchives) {
			   the_widget( 'WP_Widget_Archives' );
		  }

		echo "</div>";
		echo "<div class='span6 col-sm-6'>";
		  if ($showRecent) {
			   the_widget( 'WP_Widget_Recent_Posts');
		  } else {
			  the_widget( 'WP_Widget_Archives' );
		  }
		echo "</div>";

	} else if ($totalRegions == 1) {
		echo "<div class='span12 col-xs-12'>";
		  if ($showSitemap) {
			the_widget( 'WP_Widget_Pages');

		  } else if ($showArchives) {
			  the_widget( 'WP_Widget_Archives' );
		  } else if ($showRecent) {
			  the_widget( 'WP_Widget_Recent_Posts');
		  }
		echo "</div>";

	}
	print "</div>";
	print "</div>";



}
function i3d_render_page_googlemap() {

	global $myPageID;
	if (I3D_Framework::use_global_layout()) {
		  wp_enqueue_script( 'aquila-google-maps',  "https://maps.google.com/maps/api/js?v=3.exp&amp;sensor=false&amp;language=en&libraries=common,util,geocoder,map,overlay,onion,marker,infowindow,controls", array('jquery'), '1.0' );
		  wp_enqueue_script( 'aquila-gomap', 		get_stylesheet_directory_uri()."/Site/javascript/gomap/jquery.gomap-1.3.2.min.js", array('jquery', 'aquila-google-maps'), '1.0' );
	}
	$mapData = get_post_meta($myPageID, "map", true);
  	$mapData = wp_parse_args( (array) $mapData, array( 'markerinfo' => '', 'markers' => '') );

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
	?>

    <script type="text/javascript">

jQuery(document).ready(function(){jQuery('#googlemap').goMap({address:'<?php echo $mapData['primary_location']; ?>',maptype:'<?php echo $mapData['type']; ?>',zoom:<?php echo $mapData['zoom']; ?>,scrollwheel:false,scaleControl:true,navigationControl:true<?php echo $markerHTML; ?><?php echo $showMarkersHTML; ?>});});


</script>
<?php
	 if ($mapData['width'] == "contained") {
		 echo "<div class='container'>";
	 } else {
		 echo "<div class='googlemap-container'>";
	 }
	//$googleMapCode = get_post_meta($myPageID, 'i3d_optional_region', true);
	echo '<div id="googlemap" style="height: '.$mapData['height'].'px;" ></div>';
	 if ($mapData['width'] == "contained") {
		 echo "</div>";
	 } else {
		 echo "</div><div class='container-fluid divider'></div>";

	 }


}

function i3d_render_faqs() {
	global $page_id;
	
	$categories = get_terms("i3d-faq-category", "hide_empty=1");
	$pageData 	= wp_parse_args( (array) get_post_meta($page_id, "faq", true), array( 'display_faqs_in_page' => '') );

	$rand = rand();
	// do not wrap in a LIST if using the ACCORDION panels
	if ($pageData['display_faqs_in_page'] != "2") {
		echo "<ul class='i3d-faq-categories'>";
	}
	
	foreach ($categories as $faqCategory) {
		// do not wrap in a LIST if using the ACCORDION panels
		if ($pageData['display_faqs_in_page'] != "2") {
			echo "<li>";
		}
		
		// only link it, if we're linking off to a new page
		if ($pageData['display_faqs_in_page'] != "1" && $pageData['display_faqs_in_page'] != "2") {
			echo "<a href='".get_term_link($faqCategory->slug, "i3d-faq-category")."'>";
		}
		if ($pageData['display_faqs_in_page'] == "2") {
			echo "<h4>{$faqCategory->name}</h4>";
		} else { 
			echo $faqCategory->name;
		}
		
		if ($pageData['display_faqs_in_page'] != "1" && $pageData['display_faqs_in_page'] != "2") {
			echo "</a>";
		}
		
		if ($faqCategory->description != "") {
			echo "<p>{$faqCategory->description}</p>";
		}
		if ($pageData['display_faqs_in_page'] == "2") {
			echo "<div class='accordion panel-group' id='accordion-".($faqCategory->term_id)."'>";
			
		} else {
			echo "<ul class='i3d-faq'>";
		}
		$wpq = array( "posts_per_page" => -1, "post_type" => "i3d-faq", "taxonomy" => "i3d-faq-category", "term" => $faqCategory->slug);
		$categoryPosts = new WP_Query($wpq);
		$shownActive = false;

		foreach ($categoryPosts->posts as $post) {
			if ($pageData['display_faqs_in_page'] == "2") {
				echo "<div class='panel panel-default'>";
				echo '<div class="panel-heading">';
				echo '<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion-'.($faqCategory->term_id).'" href="#collapse-'.($faqCategory->term_id).'-'.$post->ID.'">';		
				echo "{$post->post_title}</a></h4></div>";
				echo '<div id="collapse-'.($faqCategory->term_id).'-'.$post->ID.'" class="panel-collapse collapse '.(!$shownActive ? "in" : "").'">
				<div class="panel-body">';
				$shownActive = true;
			} else {
				echo "<li>";
				if ($pageData['display_faqs_in_page'] == "1") {
					echo "<a href='#".$post->ID."'>{$post->post_title}</a>";
				} else {
					echo "<a href='".get_permalink($post->ID)."'>{$post->post_title}</a>";
				}
				echo "<div class='entry'>";
			}
			print do_shortcode($post->post_content);
			
			if ($pageData['display_faqs_in_page'] == "2") {
				echo "</div></div></div>";
			} else { 
				echo "</div></li>";
			}			
		}
		
		if ($pageData['display_faqs_in_page'] == "2") {
			echo "</div>";
		} else {		
			echo "</ul>";
		}
		if ($pageData['display_faqs_in_page'] == "2") { 
		} else { 
			echo "</li>";
		}
		
		if ($pageData['display_faqs_in_page'] == "1") {
			echo "<ul class='i3d-faq'>";
			foreach ($categoryPosts->posts as $post) {
				$terms = wp_get_post_terms($post->ID, "i3d-faq-category");
				if (sizeof($terms) > 0) {
					continue;
				}
				$miscFAQs++;

				echo "<li><h4 id='{$post->ID}'>{$post->post_title}</h4>";
				print "<div class='entry'>".do_shortcode($post->post_content)."</div>";
				echo "</li>";
			}
			echo "</ul></li>";
		}

	}

	// organize miscellaneous FAQs
	ob_start();
	echo "<li>";   

	$wpq = array( "posts_per_page" => -1, "post_type" => "i3d-faq", "taxonomy" => "i3d-faq-category");
	$categoryPosts = new WP_Query($wpq);
    $miscFAQs = 0;
	
	echo "<ul class='i3d-faq'>";
	foreach ($categoryPosts->posts as $post) {
	
		$terms = wp_get_post_terms($post->ID, "i3d-faq-category");
		if (sizeof($terms) > 0) {
			continue;
		}
		$miscFAQs++;

		echo "<li>";
		if ($pageData['display_faqs_in_page'] == "1") {
			echo "<a href='#".$post->ID."'>{$post->post_title}</a>";
		} else {
			echo "<a href='".get_permalink($post->ID)."'>{$post->post_title}</a>";
		}
		echo "</li>";
	}
	echo "</ul>";
	echo "</li>";
	// display miscellaneous FAQs (those FAQs not categorized)
	if ($miscFAQs > 0 ) {
		if (sizeof($categories) > 0) {
			
			_e("Misc", "i3d-framework");
		}
		if ($pageData['display_faqs_in_page'] != "2") {
			echo ob_get_clean();
		} else {
			ob_end_clean();
			if (sizeof($categories) > 0) {
				echo "<h4>";
				_e("Miscellaneous", "i3d-framework");
				echo "</h4>";
			}
		}
	} else {
		ob_end_clean();
	}
	//print $miscFAQs;
	
    if ($pageData['display_faqs_in_page'] == "1" || ($pageData['display_faqs_in_page'] == "2" && (sizeof($categories) == 0 || $miscFAQs > 0))) { // was displaying duplicate accordion data
   // if ($pageData['display_faqs_in_page'] == "1" || $pageData['display_faqs_in_page'] == "2") {
  //  if ($pageData['display_faqs_in_page'] == "1" ) {
		if ($pageData['display_faqs_in_page'] == "2") {
			
			  echo "<div class='accordion panel-group' id='accordion-general'>";
			
		} else {
			echo "<ul class='i3d-faq'>";
		}
		$shownActive = false;
		foreach ($categoryPosts->posts as $post) {
			$terms = wp_get_post_terms($post->ID, "i3d-faq-category");
			if ($pageData['display_faqs_in_page'] == "2" && sizeof($terms) > 0) { continue; }
			//print sizeof($terms);
			
			if ($pageData['display_faqs_in_page'] == "2") {
					echo "<div class='panel panel-default'>";
					echo '<div class="panel-heading">';
					echo '<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion-general" href="#collapse-general-'.$post->ID.'">';		
					echo "{$post->post_title}</a></h4></div>";
					echo '<div id="collapse-general-'.$post->ID.'" class="panel-collapse collapse '.(!$shownActive ? "in" : "").'">
					<div class="panel-body">';
					$shownActive = true;
			} else {
				echo "<li><h4 id='{$post->ID}'>{$post->post_title}</h4>";
				echo "<div class='entry'>";
			}
			
			print do_shortcode($post->post_content);
			
			if ($pageData['display_faqs_in_page'] == "2" ) {
					echo "</div></div></div>";
			} else { 
				echo "</div></li>";
			}
		}
	
		if ($pageData['display_faqs_in_page'] == "2") {
				echo "</div>";
		} else {		
			echo "</ul>";
		}
		if ($pageData['display_faqs_in_page'] != "2") {
			echo "</li>";
		}
	}

	if ($pageData['display_faqs_in_page'] == "2") {
	} else {
		echo "</ul>";
	}

}

function i3d_render_team_members() {
	global $page_id;
	global $renderedIsotopePortfolio;
	$categories = get_terms("i3d-team-member-department", "hide_empty=1");
	$pageData 	= wp_parse_args( (array) get_post_meta($page_id, "team-member", true), array( 'display_style' => '0') );
		
	// isotope portfolio	
    if ($pageData['display_style'] == "1" && I3D_Framework::$isotopePortfolioVersion > 0) {
		$renderedIsotopePortfolio = true;
		//print "yes";
		if (I3D_Framework::$isotopePortfolioVersion == 3 || I3D_Framework::$isotopePortfolioVersion == 4) {
			//print "hmmm";
				echo str_replace("fsp-container", "fsp-container fsp-container-contained", do_shortcode("[i3d_default_portfolio taxonomy='i3d-team-member-department']"));
		  return;
			
		} else if (I3D_Framework::$isotopePortfolioVersion == 2) {
				echo str_replace("container isotope-container", "isotope-container", do_shortcode("[i3d_default_portfolio taxonomy='i3d-team-member-department']"));
		  return;
		}
		
    	ob_start();
		$terms = "";
	?>
    <div class=''>
	<?php
	if (sizeof($categories) > 1) { ?>

	<div id="isotope-buttons">
		<a href="#" data-filter="*" class="active">Show All</a>
        <?php foreach ($categories as $index => $category) { 
		$terms[] = $category->slug;
		?>
		<a href="#" data-filter=".group-<?php echo $category->slug; ?>" class=""><?php echo $category->name; ?></a>
		<?php } ?>
	</div>
<?php } ?>

<div id="isotope-container" class="ufilter">
	<div class="col-sm-12">
		<div id="isotope-portfolio">
 <?php
   if (sizeof($categories) == 0) {
	 //  print "Yeah";
	  $wpq = array("post_type" => "i3d-team-member", "posts_per_page" => -1, 'orderby' => 'menu_order title');
   } else {
	  $wpq = array("post_type" => "i3d-team-member", "posts_per_page" => -1, 'orderby' => 'menu_order title');
   
   }
 //  var_dump($wpq);
	$categoryPosts = new WP_Query($wpq);
	//var_dump($categoryPosts);
	foreach ($categoryPosts->posts as $post) {
		//var_dump($post);
		$iconsDisplayed = false;
		$postTerms = wp_get_post_terms( $post->ID, "i3d-team-member-department");
		
		$teamMemberData				= get_post_meta( $post->ID, 'team_member_data', true );
		$teamMemberContactPoints 	= get_post_meta( $post->ID, 'team_member_contact_points', true);
		if (!is_array($teamMemberData)) {
		  $teamMemberData = array();	
		}
		if (!is_array($teamMemberContactPoints)) {
		  $teamMemberContactPoints = array();	
		}
		
	$alternateIconMapping = array("email" => "envelope-o", "googleplus" => "google-plus", "blog" => "rss", "website" => 'external-link');
		?>

<!-- isotope image container -->
<div class="col-sm-3 team-member-isotope isotope-item thumb<?php foreach ($postTerms as $postTerm) { ?> group-<?php echo $postTerm->slug; ?><?php } ?>">
	<div class="img-container">
		<div class="isotope-item-image-container">
			<div class="isotope-item-overlay ">
				<div class="inner">
					<ul>
						<!-- large image / image link -->
						<li>
                        <?php 
						 $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
						 ?>
						<a class="thumb-icon" href="<?php echo $large_image_url[0]; ?>" rel="prettyPhoto[gallery]"><i class="fa fa-search-plus fa-2x"></i></a></li>
						<li><a class="thumb-icon" href="<?php echo get_permalink($post->ID); ?>"><i class="fa fa-link fa-2x"></i></a></li>
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
				<div class='caption-title'>
					<h3><?php echo $post->post_title; ?></h3>
					<?php if (@$teamMemberData[0] != "") { ?>
					<div class='team-member-title'><?php echo @$teamMemberData[0]['value']; ?></div>
					<?php } ?>
				</div>
				<div class='team-member-icons'>
				  <?php foreach ($teamMemberContactPoints as $contactType => $contactInfo) { 
				    if (@$contactInfo['type'] != "" && @$contactInfo['value'] != "") {
						//var_dump($contactInfo);
						$icon = $contactInfo['type'];
						$iconsDisplayed = true;
						if (array_key_exists($icon, $alternateIconMapping)) {
						  //print "yes $icon";
						  $icon = $alternateIconMapping["$icon"];	
						} 
						?>
					<a <?php if (@$icon['type'] != "email") { ?>target="_blank"<?php } ?> href='<?php echo @$contactInfo['value']; ?>'><span class="fa-stack fa-sm">
						  <i class="fa fa-circle fa-stack-2x"></i>
						  <i class="fa fa-<?php echo @$icon; ?> fa-stack-1x fa-inverse"></i>
						</span></a>
				  <?php
					}
				  } ?>

					
				</div> 
				<a href="<?php echo get_permalink($post->ID); ?>" title="read more" class="read-more<?php if ($iconsDisplayed) { ?> with-icons<?php } ?>"><?php _e("read more &rarr;","i3d-framework"); ?></a>
				<!-- title / description / read more link -->
			</div>
		</div>
	</div>
</div>
<!-- isotope image container -->

<?php } ?>


		</div>
	</div>
</div>
</div>
<?php
print ob_get_clean();


	// standard display
	} else {
		
	  echo "<ul class='i3d-team-member-departments'>";
	  foreach ($categories as $faqCategory) {
		echo "<li><a href='".get_term_link($faqCategory->slug, "i3d-team-member-department")."'>".$faqCategory->name."</a>";
		if ($faqCategory->description != "") {
			echo "<p>{$faqCategory->description}</p>";
		}
		echo "<ul class='i3d-team-member'>";
	
		$wpq = array("post_type" => "i3d-team-member", "taxonomy" => "i3d-team-member-department", "term" => $faqCategory->slug, "posts_per_page" => -1, 'orderby' => 'menu_order title');
		$categoryPosts = new WP_Query($wpq);
		foreach ($categoryPosts->posts as $post) {
					$teamMemberData				= get_post_meta( $post->ID, 'team_member_data', true );
			echo "<li class='well'>";
	
			  $teamMemberImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID));
			//  var_dump($teamMemberImg);
			//  $thumbnailType = "posts-small";
			 // $thumbnailKind = get_post_meta($post->ID, 'luckymarble_post_thumbnail', true);
			 // print $thumbnailKind;
			 echo "<a href='".get_permalink($post->ID)."'>";
			  echo "<img src='".$teamMemberImg[0]."' />";
	
			echo $post->post_title;
							
			
					if (@$teamMemberData[0] != "") { ?>
					<div class='team-member-title'><?php echo @$teamMemberData[0]['value']; ?></div>
					<?php } 
				

			echo "</a></li>";
		}
		echo "</ul></li>";
	  }
	
	  ob_start();
	   echo "<li>";
		if (sizeof($categories) > 0) {
			_e("Misc", "i3d-framework");
		}
		$wpq = array("post_type" => "i3d-team-member", "posts_per_page" => -1, 'orderby' => 'menu_order title');
		$categoryPosts = new WP_Query($wpq);
	//    var_dump($categoryPosts);
	
	//	if ($faqCategory->description != "") {
		//	echo "<p>{$faqCategory->description}</p>";
	//	}
		$miscTeamMembers = 0;
		echo "<ul class='i3d-team-member'>";
		foreach ($categoryPosts->posts as $post) {
								$teamMemberData				= get_post_meta( $post->ID, 'team_member_data', true );

			$terms = wp_get_post_terms($post->ID, "i3d-team-member-department");
			if (sizeof($terms) > 0) {
				continue;
			}
			$miscTeamMembers++;
	
			echo "<li  class='well'>";
	
			  $teamMemberImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID));
			 // var_dump($teamMemberImg);
			 // $thumbnailType = "posts-small";
			 // $thumbnailKind = get_post_meta($post->ID, 'luckymarble_post_thumbnail', true);
			 // print $thumbnailKind;
			 echo "<a href='".get_permalink($post->ID)."'>";
			  echo "<img src='".$teamMemberImg[0]."' />";
	
	
			echo $post->post_title;
							if (@$teamMemberData[0] != "") { ?>
					<div class='team-member-title'><?php echo @$teamMemberData[0]['value']; ?></div>
					<?php } 

			echo "</a></li>";
		}
		echo "</ul></li>";
	
		if ($miscTeamMembers > 0) {
		  echo ob_get_clean();
		} else {
			ob_end_clean();
		}
	  echo "</ul>";
	}
}


function i3d_get_attachment_id_from_url( $attachment_url = '' ) {
 
	global $wpdb;
	$attachment_id = false;
 
	// If there is no url, return.
	if ( '' == $attachment_url ) {
		return;
	}
 
	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();
 
	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
 
		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
 
		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
 
		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
 
	}
 
	return $attachment_id;
}
?>
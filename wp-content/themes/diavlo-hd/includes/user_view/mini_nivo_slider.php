<?php
function luckymarble_show_mini_nivo_slider() {
	global $lmPortfolioConfig;
	global $lmImageDefaults;
	global $page_id;

	$portfolioImages = get_option("luckymarble_secondary_image_portfolio-{$page_id}");
	if (!is_array($portfolioImages) || sizeof($portfolioImages) == 0) {
	  $portfolioImages = get_option('luckymarble_secondary_image_portfolio');
	}

	//$portfolioImages = get_option('luckymarble_secondary_image_portfolio');

if(is_array($portfolioImages)) {
?>
<div id="nivo_slider_small">
<div id="slider-wrapper2">



<?php
$postCount = 0;
foreach($portfolioImages as $index => $image) {
	//only show image if it still exists

	//		if(wp_attachment_is_image($image['id']) || $image['id'] == "default" || $image['id'] == "featured_image") {

		// if the image id is "default" then it should reside in the default location which is in the themed images folder
		if ($image['id'] == "default") {
			//print "default";
			// if the image url is not match the default-image-prefix, then it must be on the demo server
			if (strpos($image['image'], $lmPortfolioConfig['default-image-prefix-nivo-secondary']) === false) {
				$image['url'] =  htmlentities(str_replace("portfolio-large-", $lmPortfolioConfig['default-image-prefix-nivo-secondary'], $image['image']));
			} else {
				$image['url']  = htmlentities($image['image']);
			}
			//print ":".$image['url'];
			if (!strstr(get_option("siteurl"), $image['url'] )) {
				$image['url'] = get_option("siteurl")."/wp-content/themes/".get_template().$image['url'] ;
			}
		// otherwise, it will be stored in an uploads folder two levels above the [theme] folder
		} else if ($image['id'] == "featured_image") {

			if ($image['link_type'] == "post") {

				if ($image['link'] == "") {
					$posts = get_posts(array('numberposts' => 1, 'offset' => $postCount++));
					$post = array_shift($posts);
					$image['link'] = $post->ID;
				} else {
					$post = get_post($image['link']);
				}

			}

			$imageID = get_post_meta($image['link'], '_thumbnail_id', true);
			$large_image_url = wp_get_attachment_image_src( $imageID, 'full');
			if ($large_image_url != "") {
				$image['url'] =  $large_image_url[0];
			} else {
				continue;
			}
		} else {
			if ($image['link'] == "" && $image['link_type'] == "post") {
				if ($image['link'] == "") {
					$posts = get_posts(array('numberposts' => 1, 'offset' => $postCount++));
					$post = array_shift($posts);
					$image['link'] = $post->ID;
				} else {
					$post = get_post($image['link']);
				}

			}


			$large_image_url = wp_get_attachment_image_src( $image['id'], 'full' );
			$image['url'] =  $large_image_url[0];
		}
		//$imageURL = str_replace(
		//$imageURL = get_option("siteurl")."/wp-content/themes/".get_template()."/includes/user_view/thumb.php?src=".str_replace("-150x150", "", $imageURL)."&amp;w=".$lmImageDefaults['large']['width']."&amp;h=".$lmImageDefaults['large']['height']."&amp;zc=1&amp;q=90&amp;v=1";
		
		$image['url'] = str_replace("-".$large_image_url[1]."x".$large_image_url[2], "", $image['url']);
		$image['url'] = str_replace("/", "|", $image['url']); // this is used to resolve issue of urls being blocked by hosting platforms such as hostgator
		$image['url'] = get_option("siteurl")."/wp-content/themes/".get_template()."/includes/user_view/thumb.php?src=".$image['url']."&amp;w=".$lmImageDefaults['small']['width']."&amp;h=".$lmImageDefaults['small']['height']."&amp;zc=1&amp;q=90&amp;v=1";

		// define the link
		if ($image['link_type'] == "external") {
			$linkURL = $image['link'];
			//$linkTitle = $image['title'];

		} else if ($image['link_type'] == "page") {
			if ($image['title'] != "") {
			 // $linkTitle = $image['title'];
			} else {
			  $pageTitle =	get_post_meta($pageID, 'luckymarble_page_title', true);
			  if ($pageTitle != "") {
				  $image['title'] =  $pageTitle;
			  } else {
				 $image['title'] = get_the_title($pageID);
			  }
			}

			if ($image['link'] == "") {
			  $image['link'] = "../../../";
		  } else {
				$linkURL = str_replace(home_url().'/', '',get_page_link($image['link']));
				if ($linkURL == "" && $image['link'] != "") {
					$image['link'] = $image['link'];
				} else {
					$image['link'] = "../../../".$linkURL;
				}
			}

		} else if ($image['link_type'] == "post") {
			//$linkTitle = $image['title'];

			if ($image['description'] == "") {
				// if no id specified, then it's the newest post
				$image['description'] = $post->post_title;
			}

			$image['link'] = str_replace(home_url().'/', '',get_page_link($image['link']));

		}

		$portfolioImages["{$index}"] = $image;
	}
?>
<div id="slider2" class="nivoSlider2">
<?php

	$imageCount = 0;
	foreach($portfolioImages as $index => $image) {
		$imageCount++;
	    ?>
		<!-- image <?php echo $imageCount; ?>: --> <a href="<?php if ($image['link'] != "") { print $image['link']; } else { print '#'; } ?>"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['title']; ?>" title="#image<?php echo $imageCount; ?>" /></a>
		<?php

	}

?>
</div>
<div id="slidercover2"></div>
<?php
	$imageCount = 0;
	foreach($portfolioImages as $index => $image) {
		$imageCount++;
	    ?>
			<!-- image <?php echo $imageCount; ?>: title and captions -->
            <div id="image<?php echo $imageCount; ?>" class="nivo-html-caption">

            <h3><?php echo $image['title']; ?></h3>
            <p><?php echo $image['description']; ?></p>
       	<?php if ($image['link'] != "" && $image['link_label'] != "") {
			    ?>
        	<div class="slider_readmore"><a style='display: block !important;' target="<?php echo $image['link_target']; ?>" href="<?php echo $image['link']; ?>"><?php echo $image['link_label']; ?></a></div>
         <?php } ?>
            </div>
			<!-- /image <?php echo $imageCount; ?>: title and captions -->

		<?php

	}

?>
        </div>
</div>

<script type="text/javascript">
$(window).load(function() {
  // init the nivo slider on the #slider div
  $('#slider2').nivoSlider({manualAdvance:false});

  // override the hover effects for the bullets
  $('.nivo-control').hover(
    function() {$(this).animate({ opacity: 1.00 }, 300, 'linear')},
    function() {$(this).animate({ opacity: 0.50 }, 100, 'linear')});

});
</script>

<?php
}
}
?>
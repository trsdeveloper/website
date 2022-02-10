<?php
function i3d_show_parallax_slider($sliderID) {

	global $lmPortfolioConfig;
	global $lmImageDefaults;
	global $page_id;
   // print "a";
    $sliders = get_option("i3d_sliders");
	$slider = $sliders["{$sliderID}"];
	
	$portfolioImages = $slider['slides'];
	if (!is_array($portfolioImages) || sizeof($portfolioImages) == 0) {
	//	print "in it")
	//$portfolioImages = array();
	//  $portfolioImages = get_option('luckymarble_nonflash_image_portfolio');
	}
	if (file_exists(get_template_directory()."/Site/styles/sliders/css/parallax-slider.css")) {
	   wp_register_style( 'i3d-parallax-slider',  get_template_directory_uri() .'/Site/styles/sliders/css/parallax-slider.css');
	} else {

	   wp_register_style( 'i3d-parallax-slider',  get_template_directory_uri() .'/Library/sliders/parallax-slider/css/parallax-slider.css');
	}
	 
	 wp_register_script('i3d-parallax-slider-js2', get_template_directory_uri() .'/Library/sliders/parallax-slider/js/jquery.cslider.js', array('jquery'), '1.0' );

     wp_enqueue_style( 'i3d-parallax-slider' );
     wp_enqueue_script( 'i3d-modernizr-js' );
     wp_enqueue_script( 'i3d-parallax-slider-js2' );
	 

 
if(is_array($portfolioImages)) {
?>
<div class="parallax-container">
	<div id="da-slider" class="da-slider">
	
	

		
		


	
<?php
$postCount = 0;
$imageCount = 0;
foreach($portfolioImages as $image) {
		$imageCount++;

		// if the image id is "default" then it should reside in the default location which is in the themed images folder
		if($image['id'] == "default") {
			// if the image url is not match the default-image-prefix, then it must be on the demo server
			if (strpos($image['image'], $lmPortfolioConfig['default-image-prefix-nivo']) === false && false) {
				$imageURL = htmlentities(str_replace("portfolio-large-", $lmPortfolioConfig['default-image-prefix-nivo'], $image['image']));
			} else {
				$imageURL = htmlentities($image['image']);
			}

			if (!strstr(get_option("siteurl"), $imageURL )) {
				$imageURL = get_option("siteurl")."/wp-content/themes/".get_template().$imageURL;
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
				$imageURL = $large_image_url[0];
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
			$imageURL = $large_image_url[0];
		}
	//	var_dump($large_image_url);
		//$imageURL = str_replace("-".$large_image_url[1]."x".$large_image_url[2], "", $imageURL);
		//$imageURL = str_replace("/", "|", $imageURL); // this is used to resolve issue of urls being blocked by hosting platforms such as hostgator
		$sliderConfig = I3D_Framework::getSlider("parallax-slider");
		$imageDimension = $sliderConfig['dimensions'];
		//$imageURL = get_option("siteurl")."/wp-content/themes/".get_template()."/includes/user_view/thumb.php?src=".$imageURL."&amp;w=".$imageDimension['width']."&amp;h=".$imageDimension['height']."&amp;zc=1&amp;q=90&amp;v=1";

		// define the link
		if ($image['link_type'] == "external") {
			$linkURL = $image['link'];

		} else if ($image['link_type'] == "page") {
			if ($image['link'] == "") {
			 // $linkURL = "../../../";
				  $linkURL = home_url();

		  } else {/*
				$linkURL = str_replace(home_url().'/', '',get_page_link($image['link']));
				if ($linkURL == "" && $image['link'] != "") {
					$linkURL = $image['link'];
				} else {
					$linkURL = "../../../".$linkURL;
				}

				if ($image['link'] == get_option("page_on_front")) {
				  $linkURL = home_url();
				}
				*/
				$linkURL = get_page_link($image['link']);
				
				if ($image['link'] == get_option("page_on_front")) {
				  $linkURL = home_url();
				}
			}

		} else if ($image['link_type'] == "post") {

			if ($image['description'] == "") {
				// if no id specified, then it's the newest post
				$image['description'] = $post->post_title;
			}

			//$linkURL = str_replace(home_url().'/', '',get_page_link($image['link']));
				$linkURL = get_page_link($image['link']);

		}

			//$sliderCaption .= "<div id='image{$imageCount}' class='nivo-html-caption'>";
			//$sliderCaption .= "{$image['title']}";
			//$sliderCaption .= "{$image['description']}";

        if ($image['link'] == "") {
			$imageHTML =  '<img src="'.$imageURL.'" alt="" />';
		} else {
			$imageHTML =  '<img src="'.$imageURL.'" alt="" />';
		    if ($image['link_label'] != "") {

					$linkButton = "<a class='da-link' target='{$image['link_target']}' href='{$linkURL}'>{$image['link_label']}</a>";
			
			} else {
				$linkButton = "";
			}
		}
		

	

?>



	
	
<!-- slide <?php echo $imageCount; ?> -->
		
			

				<div class="da-slide">
					<h2><?php echo $image['title']; ?></h2>
					<p><?php echo $image['description']; ?></p>
					<?php echo $linkButton; ?>
                    <div class="da-img"><?php echo $imageHTML; ?>
					<div class='da-img-cover'></div>
					</div></div>				
			
			
		
<!--/slide <?php echo $imageCount; ?> -->
		
		<?php } // end of foreach ?>

	<nav class="da-arrows">
					<span class="da-arrows-prev"></span>
					<span class="da-arrows-next"></span>
				</nav>
	</div>
				</div>


<script>
<?php
if (I3D_Framework::$bootstrapVersion >= 3) { 
  if (I3D_Framework::$parallaxSliderVersion == 3) { ?>
jQuery(".parallax-container").parents(".slider-wrapper").addClass("parallax-slider");
	
  <?php } else { ?>
jQuery(".parallax-container").parents(".container-wrapper").addClass("parallax-slider-bg");
jQuery(".parallax-container").parents(".content-wrapper").addClass("parallax-slider-bg");
  <?php } ?>
<?php } else { ?>
jQuery(".parallax-container").parents(".container-fluid").addClass("parallax-slider-bg");
jQuery(".parallax-container").parents(".container").removeClass("container").addClass("container-fluid");
<?php } ?>
</script>
    

		<script type="text/javascript">
		<?php
			 if (!array_key_exists('slide_time', $slider) || $slider["slide_time"] == "") {
			$slider["slide_time"] = 10;
		}
		$slideTime = $slider['slide_time'] * 1000;
		?>
		jQuery(document).ready(function() {
				jQuery('#da-slider').cslider({
					autoplay	: true,
					bgincrement	: 450,
					current: 0,
					interval: <?php echo $slideTime; ?>
				});
			
			});
		</script>


<?php
}
}
?>
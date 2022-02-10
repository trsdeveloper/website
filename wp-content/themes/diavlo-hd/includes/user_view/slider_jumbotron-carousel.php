<?php
function i3d_show_jumbotron_carousel($sliderID) {

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
	if (file_exists(get_template_directory()."/Site/styles/sliders/css/nivo-slider.css")) {
	   wp_register_style( 'i3d-fullscreen-carousel',  get_template_directory_uri() .'/Site/styles/sliders/css/jumbotron-carousel.css');
	} else {
		
		
	   wp_register_style( 'i3d-fullscreen-carousel',  get_template_directory_uri() .'/Library/sliders/jumbotron-carousel/css/jumbotron-carousel.css');
	}
	  // wp_register_script('i3d-nivo-slider-js', get_template_directory_uri() .'/Library/sliders/nivo-slider/js/jquery.nivo.slider.js', array('jquery'), '1.0' );

     wp_enqueue_style( 'i3d-fullscreen-carousel' );
    // wp_enqueue_script( 'i3d-nivo-slider-js' );
	 

 
if(is_array($portfolioImages)) {
		 if (!array_key_exists('slide_time', $slider) || $slider["slide_time"] == "") {
			$slider["slide_time"] = 5;
		}
		$slideTime = $slider['slide_time'] * 1000;
		?>
<div id="myCarousel" class="carousel slide" data-interval="<?php echo $slideTime; ?>">

	<div class="carousel-inner">
	
	

		
		


	
<?php
$postCount = 0;
$imageCount = 0;
foreach($portfolioImages as $image) {
		$imageCount++;
		$imageURL = "";

		// if the image id is "default" then it should reside in the default location which is in the themed images folder
		if($image['id'] == "default") {
			// if the image url is not match the default-image-prefix, then it must be on the demo server
			if (strpos($image['image'], $lmPortfolioConfig['default-image-prefix-nivo']) === false) {
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
		$sliderConfig = I3D_Framework::getSlider("jumbotron-carousel");
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
				$linkButton = "<a class='btn btn-large btn-primary' target='{$image['link_target']}' href='{$linkURL}'>{$image['link_label']}</a>";
			} else {
				$linkButton = "";
			}
		}
		

	

?>



	
	
<!-- slide <?php echo $imageCount; ?> -->
		<div class="item <?php if ($imageCount == "1") { ?>active<?php } ?>">

			<div class="container">
			<div class="carousel-caption"><?php echo $imageHTML; ?>
			
				
					<h1><?php echo $image['title']; ?></h1>
					<p class="lead"><?php echo $image['description']; ?></p>
					<?php echo $linkButton; ?>
				</div>
			</div>
		</div>
<!--/slide <?php echo $imageCount; ?> -->
		
		<?php } // end of foreach ?>

	
	</div>
	<a class="left carousel-control" data-slide="prev" href="#myCarousel">&lsaquo;</a>
	<a class="right carousel-control" data-slide="next" href="#myCarousel">&rsaquo;</a>
</div>


<script>
<?php
if (I3D_Framework::$bootstrapVersion >= 3) {
	if (I3D_Framework::$jumbotronCarouselVersion == 3) { ?>
	jQuery("#myCarousel").parents(".container-wrapper").addClass("jumbotron-bg").removeClass("container-wrapper").addClass("content-wrapper");

	<?php } else if (I3D_Framework::$jumbotronCarouselVersion == 2) { ?>
jQuery("#myCarousel").parents(".container-wrapper").addClass("jumbotron-bg").removeClass("container-wrapper").addClass("content-wrapper");
		
		<?php } else { ?>
jQuery("#myCarousel").parents(".container-wrapper").addClass("jumbotron-bg").removeClass("container-wrapper").addClass("container");
        <?php } ?>

<?php } else { ?>

jQuery("#myCarousel").parents(".container-fluid").addClass("jumbotron-bg");
jQuery("#myCarousel").parents(".container").removeClass("container").addClass("container-fluid");
<?php } ?>

</script>

    




<?php
}
}
?>
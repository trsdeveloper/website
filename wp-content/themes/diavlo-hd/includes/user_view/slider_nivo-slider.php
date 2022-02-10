<?php
function i3d_show_nivo_slider($sliderID, $styledBG = true) {
	
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
	//print "b".sizeof($portfolioImages);
	//return;
	
	if (file_exists(get_template_directory()."/Site/styles/sliders/css/nivo-slider.css")) {
	   wp_register_style( 'i3d-nivo-slider',  get_template_directory_uri() .'/Site/styles/sliders/css/nivo-slider.css');
	   wp_register_script('i3d-nivo-slider-js', get_template_directory_uri() .'/Library/sliders/nivo-slider/js/jquery.nivo.slider.js', array('jquery'), '1.0' );

       wp_enqueue_style( 'i3d-nivo-slider' );
       wp_enqueue_script( 'i3d-nivo-slider-js' );
		
	} else {
	   wp_register_style( 'i3d-nivo-slider',  get_template_directory_uri() .'/Library/sliders/nivo-slider/css/nivo-slider.css');
	   wp_register_script('i3d-nivo-slider-js', get_template_directory_uri() .'/Library/sliders/nivo-slider/js/jquery.nivo.slider.js', array('jquery'), '1.0' );

       wp_enqueue_style( 'i3d-nivo-slider' );
       wp_enqueue_script( 'i3d-nivo-slider-js' );
	 
	}
 
if(is_array($portfolioImages)) {
?>

<div class="slider-wrapper theme-default">


<!-- images -->		
	<div id="slider" class="nivoSlider">
	
<?php
$postCount = 0;
$imageCount = 0;
$sliderCaption = "";
foreach($portfolioImages as $image) {
		$imageCount++;

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
	//	print $imageURL;
		$sliderConfig = I3D_Framework::getSlider("nivo-slider");
		$imageDimension = $sliderConfig['dimensions'];
		if (@$slider['height'] != "") {
			$imageDimension['height'] = $slider['height'];
		}
		if (@$slider['width'] != "") {
			$imageDimension['width'] = $slider['width'];
		}
		if (I3D_Framework::$useTimThumb) {
			$imageURL = str_replace("/", "|", $imageURL); // this is used to resolve issue of urls being blocked by hosting platforms such as hostgator

			$imageURL = get_option("siteurl")."/wp-content/themes/".get_template()."/includes/user_view/thumb.php?src=".$imageURL."&amp;w=".$imageDimension['width']."&amp;h=".$imageDimension['height']."&amp;zc=1&amp;q=90&amp;v=1";
		}
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

			$sliderCaption .= "<div id='image{$imageCount}' class='nivo-html-caption'>";
			$sliderCaption .= "{$image['title']}";
			$sliderCaption .= "{$image['description']}";

        if ($image['link'] == "") {
			echo '<a href="#"><img src="'.$imageURL.'" title="#image'.$imageCount.'" /></a>';
		    $sliderCaption .= "<br/>";
		} else {
			echo '<a target="'.$image['link_target'].'" href="'.$linkURL.'"><img src="'.$imageURL.'" title="#image'.$imageCount.'" /></a>';
		    if ($image['link_label'] != "") {
			  $sliderCaption .= "<div class='slider_readmore'><a target='".$image['link_target']."' href='".$linkURL."'>".$image['link_label']."</a></div>";
			}
		}
		$sliderCaption .= "</div>";

	}

?>
	</div>


	
<!-- captions -->	
<?php echo $sliderCaption; ?>
	
	
	
</div>



    
  <?php if (!$styledBG) { ?>
  <style>.nivoSlider { margin-top: 20px !important; }
         .nivo-controlNav { padding: 0px !important; }  </style>
  <?php } else { ?>
  <script type="text/javascript">
     
jQuery("#slider").parents(".container-fluid").addClass("nivo-slider-bg");

</script>
  <?php } ?>
    <script type="text/javascript">
    jQuery(window).load(function() {
		<?php if (!array_key_exists('slide_time', $slider) || $slider["slide_time"] == "") {
			$slider["slide_time"] = 3;
		}
		$slideTime = $slider['slide_time'] * 1000;
		?>
        jQuery('#slider').nivoSlider({pauseTime: <?php echo $slideTime; ?>});
    });

</script>

<?php
  return true;
} else {
	return false;
}
}
?>
<?php
function i3d_show_carousel_slider($sliderID) {
   
	global $lmPortfolioConfig;
	global $lmImageDefaults;
	global $page_id;
   // print "a";
    $sliders = get_option("i3d_sliders");
	//print $sliderID;
	$slider = $sliders["{$sliderID}"];
	//var_dump($slider);
	
	$portfolioImages = $slider['slides'];
	if (!is_array($portfolioImages) || sizeof($portfolioImages) == 0) {
	//	print "in it")
	//$portfolioImages = array();
	//  $portfolioImages = get_option('luckymarble_nonflash_image_portfolio');
	}

	  wp_register_style( 'i3d-fullscreen-slider',  get_template_directory_uri() .'/Library/sliders/fullscreen-slider/css/fs-slider.css');
	  
	//  wp_register_script('i3d-parallax-slider-js2', get_template_directory_uri() .'/Library/sliders/parallax-slider/js/jquery.cslider.js', array('jquery'), '1.0' );

     wp_enqueue_style( 'i3d-fullscreen-slider' );
     wp_enqueue_script( 'i3d-modernizr-79639-js' );
     wp_enqueue_script( 'i3d-fullscreen-jquery-ba-cond', get_template_directory_uri() .'/Library/sliders/fullscreen-slider/js/jquery.ba-cond.min.js', array('jquery') );
     wp_enqueue_script( 'i3d-fullscreen-slider-js', get_template_directory_uri() .'/Library/sliders/fullscreen-slider/js/jquery.fs-slider.js', array('jquery') );
	 $transitions = array();
	 $transitions[] = 'data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2"';
	 $transitions[] = 'data-orientation="horizontal" data-slice1-rotation="-5" data-slice2-rotation="10" data-slice1-scale="2" data-slice2-scale="1"';
	 $transitions[] = 'data-orientation="vertical" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5"';
	 $transitions[] = 'data-orientation="horizontal" data-slice1-rotation="3" data-slice2-rotation="3" data-slice1-scale="2" data-slice2-scale="1"';
	 $transitions[] = 'data-orientation="vertical" data-slice1-rotation="-5" data-slice2-rotation="25" data-slice1-scale="2" data-slice2-scale="1"';
	 

 
if(is_array($portfolioImages)) {
?>
<div id="carousel-slider" class="carousel slide carousel-fade">
	<div class="carousel-inner">
	
	

		
		


	
<?php
$postCount = 0;
$imageCount = 0;
$slides = array();
foreach($portfolioImages as $image) {
		$imageCount++;
		$linkButton = "";

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
	//	$imageURL = str_replace("-".$large_image_url[1]."x".$large_image_url[2], "", $imageURL);
		//$imageURL = str_replace("/", "|", $imageURL); // this is used to resolve issue of urls being blocked by hosting platforms such as hostgator
		//$sliderConfig = I3D_Framework::getSlider("fullscreen-carousel");
		//$imageDimension = $sliderConfig['dimensions'];
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

				$linkURL = get_page_link($image['link']);

		}

        if ($image['link'] == "") {
			$imageHTML =  '<img src="'.$imageURL.'" alt="" />';
		} else {
			$imageHTML =  '<img src="'.$imageURL.'" alt="" />';
		    if ($image['link_label'] != "") {
				$linkButton = "<a class='btn btn-default btn-lg animated pulse' target='{$image['link_target']}' href='{$linkURL}'>{$image['link_label']}</a>";
			} else {
				$linkButton = "";
			}
		}
?>



	
	
<!-- slide <?php echo $imageCount; ?> -->
		<div class="<?php if ($imageCount == 1) { ?>active<?php }?> item animated fadeIn" style="background:url('<?php echo $imageURL; ?>') no-repeat scroll center center / cover rgba(0,0,0,0);">
			<?php if (@$slider['background-overlay'] != "disabled") { ?><div class="cs_slider_image_overlay"></div><?php } ?>
			<div class="carousel-caption">
				<h1 class="animated flipInY"><?php echo $image['title']; ?></h1>
				<h2 class="animated fadeInDown"><?php echo @$image['subtitle']; ?></h2>
				<p class="animated fadeInRightBig"><?php echo $image['description']; ?></p>
				<?php echo $linkButton; ?>
				
			</div>
		</div>
<!--/slide <?php echo $imageCount; ?> -->
		
		<?php 
		  $slides["$imageCount"] = @$image['slide_label'];
		} // end of foreach ?>
		</div>
		
		<?php
		$generalSettings = get_option('i3d_general_settings');
		$tagline = "";
		$graphicLogoURL = "";
		$websiteName1	    = "";
		$websiteName2	    = "";
		
		// setup tagline
		if (@$generalSettings['tagline_setting'] == "custom") {
		  $tagline = @$generalSettings['tagline'];
		} else {
		  $tagline = get_bloginfo('description');
		}
		
		// setup graphic logo
		if (@$generalSettings['custom_logo_filename']) {
			$metaData = get_post_meta(@$generalSettings['custom_logo_filename'], '_wp_attachment_metadata', true);
        	$graphicLogoURL = site_url().'/wp-content/uploads/'.@$metaData['file']; 
		}
	
		// setup website name
					if (@$generalSettings['website_name'] == "custom") {

					  $websiteName1 = str_replace("  ", "&nbsp; ", str_replace("&nbsp;", " ", $generalSettings['text_1']));
					  $websiteName2 = str_replace("  ", "&nbsp; ", str_replace("&nbsp;", " ", $generalSettings['text_2']));
					} else {
						$websiteName1 = str_replace("  ", "&nbsp; ", str_replace("&nbsp;", " ", get_bloginfo('name')));
						$websiteName2 = "";
					}
					
		
	?>
					

		
		
	<div class="cs_slider_sidebar <?php if (@$slider['sidebar'] == "disabled") { ?>non-visible<?php } ?>">
    	<ol class="carousel-indicators">
		<?php foreach ($slides as $slideNumber => $label) { ?>
			<li data-target="#carousel-slider" data-slide-to="<?php echo ($slideNumber - 1); ?>" <?php if ($slideNumber == 1) { ?>class="active"<?php } ?>><span class='slide-label'><i class="fa fa-angle-left"></i> <?php echo $label; ?></span><span class='slide-number'> <?php echo $slideNumber; ?></span></li>
		<?php } ?>
		</ol>
		
		<!-- social media --> 
		<div class="ca_social">
		<?php if (@$slider['social-media-title'] != "") { ?>
		  <h4><?php echo $slider['social-media-title']; ?></h4>
		<?php } ?>
		  <div class='social-icon-fontawesome'>
		    <?php 
			if (is_array(@$slider['social-media-icons'])) { 
				foreach ($slider['social-media-icons'] as $socialPlatform => $enabled) {
						$socialPlatform = str_replace("_icon__", "_", $socialPlatform)."_url";
						if (@$generalSettings["{$socialPlatform}"] != "") {
							$faIcon = str_replace("googleplus", "google-plus", str_replace("social_media_", "", str_replace("_url", "", $socialPlatform)));
						?><div><a href="<?php echo $generalSettings["{$socialPlatform}"]; ?>"><i class="fa fa-1x fa-fw fa-<?php echo $faIcon; ?>"></i></a></div><?php
						}
					}
			} ?>
		  </div>
						  
		
		</div>
		
		<?php if (@$slider['secondary-logo'] == "default-graphic-logo" && @$graphicLogoURL != "") { ?>	
			<img src="<?php echo $graphicLogoURL; ?>" alt="slider sidebar logo" />
		<?php } else if  (@$slider['secondary-logo'] == "default-text-logo") { ?>
		<div class="carousel-slider-logo">
			<h1><?php echo $websiteName1; ?><span class="carousel-highlight1"><?php echo $websiteName2; ?></span></h1>

		</div>		
		<?php } ?>
		</div>
		<div class="cs_slider_sidebar_close <?php if (@$slider['sidebar'] == "disabled") { ?>non-visible<?php } ?>"></div>
		<div class="cs_slider_sidebar_open <?php if (@$slider['sidebar'] == "disabled") { ?>non-visible<?php } ?>"></div>
	    

		<?php if (@$slider['primary-logo'] =="default-graphic-logo" && @$graphicLogoURL != "") { ?>
		<div class="carousel-slider-graphic">
			<img src="<?php echo $graphicLogoURL; ?>" alt="" />
			<?php if (@$slider['primary-tagline'] =="default-tagline" && $tagline != "") { ?>
			<div class="carousel-slider-tagline">
				<h3><?php echo $tagline; ?></h3>
			</div>		
			<?php } ?>				
		</div>
		<?php } else if ($slider['primary-logo'] =="default-text-logo" && $websiteName1.$websiteName2 != "") { ?>
		<div class="carousel-slider-logo">
			<h1><?php echo $websiteName1; ?><span class="carousel-highlight1"><?php echo $websiteName2; ?></span></h1>

			<?php if ($slider['primary-tagline'] =="default-tagline" && $tagline != "") { ?>
			<div class="carousel-slider-tagline">
				<h3><?php echo $tagline; ?></h3>
			</div>		
			<?php } ?>
		</div>
				

		<?php } else { ?>
			<?php if ($slider['primary-tagline'] =="default-tagline" && $tagline != "") { ?>
			<div class="carousel-slider-tagline carousel-slider-tagline-standalone">
				<h3><?php echo $tagline; ?></h3>
			</div>		
			<?php } ?>
		
		<?php } ?>
	

	
	
	

	<!--logo / website name / tagline-->
</div>
<?php

		wp_enqueue_script( 'carousel-slider-jquery-easing', get_stylesheet_directory_uri()."/Site/javascript/jquery/jquery.easying.1.3.js", array('jquery'), '1.0' );
		wp_enqueue_script( 'carousel-slider', get_stylesheet_directory_uri()."/Library/sliders/carousel-slider/js/carousel-slider.js", array('jquery'), '1.0' );
?>
<script>
jQuery(".carousel-slider").parents(".container-wrapper").removeClass("container-wrapper");
jQuery(".carousel-slider").parents(".container").removeClass("container");
</script>
    <?php 
		 if (!array_key_exists('slide_time', $slider) || $slider["slide_time"] == "") {
			$slider["slide_time"] = 8; // default is 8 seconds
		}
		$slideTime = $slider['slide_time'] * 1000;
		?>
		<script type="text/javascript">
				
jQuery(function(){
			jQuery('#carousel-slider').carousel({
			  interval: <?php echo $slideTime; ?>
			});
	
});
		</script>
	

<?php
}
}
?>
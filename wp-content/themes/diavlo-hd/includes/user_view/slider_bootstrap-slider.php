<?php
function i3d_show_bootstrap_slider($sliderID) {
   
	global $lmPortfolioConfig;
	global $lmImageDefaults;
	global $page_id;
  
    $sliders = get_option("i3d_sliders");
	$slider = $sliders["{$sliderID}"];
	
	$portfolioImages = $slider['slides'];



     wp_enqueue_style( 'i3d-fullscreen-slider' );
     wp_enqueue_script( 'i3d-modernizr-79639-js' );
	 if (@$slider['background-type'] == "video" && @$slider['background-video-id'] != "") { 
	 
	 $videoMediaBackground = '<div id="background-video" class="background-video videoin"></div>'."\n".'<div class="background-video-cover"></div>';
	 		$outputBuffer = ob_get_clean();
		$outputBuffer = str_replace("<!-- bg-video-media -->", $videoMediaBackground, $outputBuffer);
		ob_start();
		print $outputBuffer;

	 ?>
	 <script>
	     jQuery(function($) {

      jQuery('#background-video').YTPlayer({
        fitToBackground: true,
        videoId: '<?php echo $slider['background-video-id']; ?>',
        <?php if (@$slider['background-video-pause-on-scroll'] == "0") { ?>
		pauseOnScroll: false,
		<?php } else { ?>
		pauseOnScroll: true,
		<?php } ?>
		<?php if (@$slider['background-video-repeat'] == "0") { ?>
		  repeat: false,
		<?php } ?>
		<?php if (@$slider['background-video-audio'] == "1") { ?>
		  mute: false,
		<?php } ?>		start: 3,
        callback: function() {
          var player = jQuery('#background-video').data('ytPlayer').player;
          console.log("callback", player);
        }
      });

    });
		 </script>
<?php
		 
	 } else if (@$slider['background-type'] == "image") {
	
                                            if(wp_attachment_is_image(@$slider['background-image-id'])) {
                                                $metaData = get_post_meta(@$slider['background-image-id'], '_wp_attachment_metadata', true);
                                                $fileName = I3D_Framework::get_image_upload_path($metaData['file']);			
                                                
                                            } else {
												$fileName = "";
                                            }
											$animation = "ken-burns";
											if ($slider['background-image-animation'] == "0") {
												$animation = "";
											}
											$imageMediaBackground = "
<div class='kbbg'>
  <div class='{$animation}'>
      <img src='{$fileName}' alt='welcome' />
  </div>
</div><div class='background-cover'></div>";


		$outputBuffer = ob_get_clean();
		$outputBuffer = str_replace("<!-- bg-image-media -->", $imageMediaBackground, $outputBuffer);
		$outputBuffer = str_replace("index.css", "index3.css", $outputBuffer);
		ob_start();
		print $outputBuffer;
	 
	 } else if (@$slider['background-type'] == "active") {
	$activeBackgroundID = @$slider['background-active-id'];
                                           
											$activeMediaBackground = "
<div class='kbbg kb-ab'>
  <div class='{$activeBackgroundID} active-background-full'></div>
</div><div class='background-cover'></div>";


		$outputBuffer = ob_get_clean();
		$outputBuffer = str_replace("<!-- bg-active-media -->", $activeMediaBackground, $outputBuffer);
		ob_start();
		print $outputBuffer;
	 }
	 
	 
	 	 if (@$slider['background-cover'] == "0") { ?>
	<style>
	.header-inner { background: none; }
	</style>
<?php } 




	 	 if (@$slider['background-attachment'] == "static") { ?>
	<style>
	.background-video { position: static; }
	.kb-ab { position: absolute; }
	</style>
<?php } else { ?>
	<style>
	.kbbg { position: fixed; 
	height: 100vh;}
	</style>

<?php } 
    // wp_enqueue_script( 'i3d-fullscreen-jquery-ba-cond', get_template_directory_uri() .'/Library/sliders/fullscreen-slider/js/jquery.ba-cond.min.js', array('jquery') );
     //wp_enqueue_script( 'i3d-fullscreen-slider-js', get_template_directory_uri() .'/Library/sliders/fullscreen-slider/js/jquery.fs-slider.js', array('jquery') );
	/*
	$transitions = array();
	 $transitions[] = 'data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2"';
	 $transitions[] = 'data-orientation="horizontal" data-slice1-rotation="-5" data-slice2-rotation="10" data-slice1-scale="2" data-slice2-scale="1"';
	 $transitions[] = 'data-orientation="vertical" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5"';
	 $transitions[] = 'data-orientation="horizontal" data-slice1-rotation="3" data-slice2-rotation="3" data-slice1-scale="2" data-slice2-scale="1"';
	 $transitions[] = 'data-orientation="vertical" data-slice1-rotation="-5" data-slice2-rotation="25" data-slice1-scale="2" data-slice2-scale="1"';
	 
*/
 
if(is_array($portfolioImages)) {
	
		 if (!array_key_exists('slide_time', $slider) || $slider["slide_time"] == "") {
			$slider["slide_time"] = 8; // default is 8 seconds
		}
		$slideTime = $slider['slide_time'] * 1000;
?>
<div id="bootstrap-slider" class="bs-animate carousel slide carousel-fade"  data-interval="<?php echo $slideTime; ?>">
	
	
	

		
		


	
<?php
$postCount = 0;
$imageCount = 0;
$slides = array();
ob_start();
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
				$linkButton = "<a class='btn btn-primary btn-lg active btn-left' data-animation='animated fadeInLeft' target='{$image['link_target']}' href='{$linkURL}'>{$image['link_label']}</a>";
			} else {
				$linkButton = "";
			}
		}
?>



	
	
<!-- slide <?php echo $imageCount; ?> -->
		<div class="<?php if ($imageCount == 1) { ?>active<?php }?> item bootstrap-slider-slide<?php echo $imageCount; ?>" style="background: url('<?php echo $imageURL; ?>'); background-size: cover;">
		            <div class="bs-slider-caption-bg"></div>
            <div class="bs-slider-top-right"></div>
            <div class="bs-slider-bottom-right"></div>
            <div class="bs-slider-bottom-left"></div>

			<?php if (@$slider['background-overlay'] != "disabled" && false) { ?><div class="cs_slider_image_overlay"></div><?php } ?>
			<div class="carousel-caption">
				<h2 data-animation="animated fadeInLeft"><?php echo $image['title']; ?></h2>
				<h3 data-animation="animated fadeInLeft"><?php echo @$image['subtitle']; ?></h3>
				<p class="carousel-caption-more delay-300" data-animation="animated fadeIn"><?php echo $image['description']; ?></p>
				<?php echo $linkButton; ?>
				
			</div>
		</div>
<!--/slide <?php echo $imageCount; ?> -->
		
		<?php 
		  $slides["$imageCount"] = @$image['slide_label'];
		} // end of foreach 
		$slidesHTML = ob_get_clean();
		?>
		

	
    	<ol class="carousel-indicators">
		<?php foreach ($slides as $slideNumber => $label) { ?>
			<li data-target="#bootstrap-slider" data-slide-to="<?php echo ($slideNumber - 1); ?>" <?php if ($slideNumber == 1) { ?>class="active"<?php } ?>></li>
		<?php } ?>
		</ol>
		
		<div class="carousel-inner" role="listbox">
						  <?php echo $slidesHTML; ?>
		
		</div>
		
		<?php if (is_array($slides) && sizeof($slides) > 1) { ?>
	<!-- Controls -->
        <a class="left carousel-control" href="#bootstrap-slider" role="button" data-slide="prev">
            <span>
                <i class="fa fa-chevron-left fa-3x"></i>
            </span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#bootstrap-slider" role="button" data-slide="next">
            <span>
                <i class="fa fa-chevron-right fa-3x"></i>
            </span>
            <span class="sr-only">Next</span>
        </a>
		<?php } ?>

</div>
<?php

		//wp_enqueue_script( 'carousel-slider-jquery-easing', get_stylesheet_directory_uri()."/Site/javascript/jquery/jquery.easying.1.3.js", array('jquery'), '1.0' );
		//wp_enqueue_script( 'carousel-slider', get_stylesheet_directory_uri()."/Library/sliders/carousel-slider/js/carousel-slider.js", array('jquery'), '1.0' );
?>
<script>
jQuery("#bs-slider").parents(".container-wrapper").removeClass("container-wrapper");
jQuery("#bs-slider").parents(".container").removeClass("container");
</script>


<?php
}
}
?>
<?php
function i3d_show_fullscreen_slider($sliderID) {

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
	//echo get_template_directory()."/Site/styles/sliders/css/fullscreen-slider.css";
	if (file_exists(get_template_directory()."/Site/styles/sliders/css/fullscreen-slider.css")) {
	   wp_register_style( 'i3d-fullscreen-slider',  get_template_directory_uri() .'/Site/styles/sliders/css/fullscreen-slider.css');
	} else {
	  wp_register_style( 'i3d-fullscreen-slider',  get_template_directory_uri() .'/Library/sliders/fullscreen-slider/css/fs-slider.css');
	}
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
<div class="fs-slider fs-wrapper">
	<div id="slider" class="sl-slider-wrapper">
	<div class="sl-slider">
	
	

		
		


	
<?php
$postCount = 0;
$imageCount = 0;
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
	//	$imageURL = str_replace("-".$large_image_url[1]."x".$large_image_url[2], "", $imageURL);
		//$imageURL = str_replace("/", "|", $imageURL); // this is used to resolve issue of urls being blocked by hosting platforms such as hostgator
		$sliderConfig = I3D_Framework::getSlider("fullscreen-carousel");
		$imageDimension = @$sliderConfig['dimensions'];
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
				$linkButton = "<blockquote class='text-center' style='margin-top: -10px; padding: 0px;'><a style='clear: both;' class='sa-link btn btn-default' target='{$image['link_target']}' href='{$linkURL}'>{$image['link_label']}</a></blockquote>";
			} else {
				$linkButton = "";
			}
		}
?>



	
	
<!-- slide <?php echo $imageCount; ?> -->
		<div class="sl-slide" <?php $transition = $imageCount % 5;
	
		echo $transitions[$transition]; ?>>
			<div class="sl-slide-inner">
<?php if (I3D_Framework::$fullScreenSliderVersion == 3 || I3D_Framework::$fullScreenSliderVersion == 2) { ?>			
			<div class="bg-img" style="background:url('<?php echo $imageURL; ?>') no-repeat center center fixed; background-size: cover;"></div>
<?php } else { ?>
<div class="bg-img<?php if (I3D_Framework::$fullScreenSliderVersion == 4) { ?>1<?php } ?>" style="background-image:url('<?php echo $imageURL; ?>')"></div>
<?php } ?>
<?php if (I3D_Framework::$fullScreenSliderVersion == 4) { ?>
			  <div class="sl-shadow"></div>
			  	 
<?php } else { ?>
			  <div class="top-shadow"></div>
<?php } ?>
              <div class="<?php echo $image['slide_cover']; ?>"></div>
			  <?php if (I3D_Framework::$fullScreenSliderVersion == 4) { ?>
			  <div class="sl-content-top"></div>
			  <?php } ?>
			  <?php if (I3D_Framework::$fullScreenSliderVersion == 3 || I3D_Framework::$fullScreenSliderVersion == 4) { ?>
					<?php if ($image['title'] != "") { ?><div class="sl-slide-title"><?php echo $image['title']; ?></div><?php } ?>
			        <cite><?php echo $image['citation']; ?></cite>
					<?php if ($image['description'] != "") { ?><div class="sl-description"><?php echo $image['description']; ?></div><?php } ?>
			  <?php } else { ?>
					<?php if ($image['title'] != "") { ?><h2><?php echo $image['title']; ?></h2><?php } ?>
					<?php if ($image['description'] != "" || $image['citation'] != "") { ?>
				   <blockquote><p><?php echo $image['description']; ?></p>
                    <cite><?php echo $image['citation']; ?></cite>
                   </blockquote>
				   <?php } ?>
			  <?php } ?>
              <?php if (I3D_Framework::$fullScreenSliderButtonEnabled) { ?>
                     				   <?php echo $linkButton; ?>
              <?php } ?>

			</div>
		</div>
<!--/slide <?php echo $imageCount; ?> -->
		
		<?php } // end of foreach ?>
<?php if (I3D_Framework::$fullScreenSliderVersion == 2 || I3D_Framework::$fullScreenSliderVersion == 3 || I3D_Framework::$fullScreenSliderVersion == 4) { ?>
</div>
</div>
<?php } ?>
	<nav id="nav-arrows" class="nav-arrows" >
					<span class="nav-arrow-prev"><?php _e("Previous", "i3d-framework") ?></span>
					<span class="nav-arrow-next"><?php _e("Next", "i3d-framework") ?></span>
				</nav>
                <?php if (I3D_Framework::$fullScreenSliderVersion == 4) { ?>
						<div class="sl-slider shadow-top"></div>
		<div class="sl-slider shadow-bottom"></div>
<?php } ?>
<nav id="nav-dots" class="nav-dots">
<?php for ($i = 0; $i < $imageCount; $i++) { ?>
					<span<?php if ($i == 0) { echo ' class="nav-dot-current"'; } ?>></span>
<?php } ?>
</nav> 
<?php if (I3D_Framework::$fullScreenSliderVersion < 2) { ?>
</div>
</div>
<?php } ?>               
	
	
</div>


<script>
jQuery(".fs-slider").parents(".fullscreen-maybe").addClass("fullscreen").removeClass("fullscreen-maybe");

jQuery(".fs-slider").parents(".container-wrapper").addClass("fs-slider-bg");
jQuery(".fs-slider").parents(".container-wrapper").removeClass("container-wrapper");
jQuery(".fs-slider").parents(".showcase-bg").find(".row.inner").parents(".container").removeClass("container").addClass("fullscreen-slider");
jQuery(".fs-slider").parents(".container").removeClass("container");

//jQuery(".fs-slider").parents(".showcase-bg").find(".row.inner").removeClass("inner");

</script>
    <?php 
		 if (!array_key_exists('slide_time', $slider) || $slider["slide_time"] == "") {
			$slider["slide_time"] = 10; // default is 10 seconds
		}
		$slideTime = $slider['slide_time'] * 1000;
		?>
		<script type="text/javascript">
jQuery(function() {

				var Page = (function() {

					var $navArrows = jQuery( '#nav-arrows' ),
						$nav = jQuery( '#nav-dots > span' ),
						slitslider = jQuery( '#slider' ).slitslider( {
							onBeforeChange : function( slide, pos ) {

								$nav.removeClass( 'nav-dot-current' );
								$nav.eq( pos ).addClass( 'nav-dot-current' );

							}
							,
							interval: <?php echo $slideTime; ?>
						} ),

						init = function() {

							initEvents();

						},
						initEvents = function() {

							// add navigation events
							$navArrows.children( ':last' ).on( 'click', function() {

								slitslider.next();
								return false;

							} );

							$navArrows.children( ':first' ).on( 'click', function() {

								slitslider.previous();
								return false;

							} );

							$nav.each( function( i ) {

								jQuery( this ).on( 'click', function( event ) {

									var $dot = jQuery( this );

									if( !slitslider.isActive() ) {

										$nav.removeClass( 'nav-dot-current' );
										$dot.addClass( 'nav-dot-current' );

									}

									slitslider.jump( i + 1 );
									return false;

								} );

							} );

						};

						return { init : init };

				})();

				Page.init();

				/**
				 * Notes:
				 *
				 * example how to add items:
				 */

				/*

				var $items  = $('<div class="sl-slide sl-slide-color-2" data-orientation="horizontal" data-slice1-rotation="-5" data-slice2-rotation="10" data-slice1-scale="2" data-slice2-scale="1"><div class="sl-slide-inner bg-1"><div class="sl-deco" data-icon="t"></div><h2>some text</h2><blockquote><p>bla bla</p><cite>Margi Clarke</cite></blockquote></div></div>');

				// call the plugin's add method
				ss.add($items);

				*/

			});
		</script>
	<?php if (@$slider['height'] != "") { ?>
    <style>
	.fs-wrapper .sl-slider-wrapper {
		height: <?php echo $slider['height']; ?>px !important;
	}
		</style>

	<?php } ?>

<?php
}
}
?>
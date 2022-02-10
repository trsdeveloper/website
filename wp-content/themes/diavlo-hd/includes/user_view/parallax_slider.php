<?php
function luckymarble_show_parallax_slider() {
	
	global $lmPortfolioConfig;
	global $lmImageDefaults;
	global $page_id;
   // print "a";
	$portfolioImages = get_option("luckymarble_parallax_slider-{$page_id}");
	if (!is_array($portfolioImages) || sizeof($portfolioImages) == 0) {
		//print "in it")
	  $portfolioImages = get_option('luckymarble_parallax_slider');
	}
	//print "b".sizeof($portfolioImages);
	//return;

if(is_array($portfolioImages)) {
?>
<div id="parallax_slider">
<div id="parallax_container" class="parallax_container">
<div class="parallax_bg">
				<div class="parallax_bg1"></div>
				<div class="parallax_bg2"></div>
				<div class="parallax_bg3"></div>
			</div>
			<div class="parallax_loading">Loading images...</div>
			
<?php
$postCount = 0;
$imageCount = 0;
$sliderHTML = "";
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

			if (!strstr(get_option("siteurl"), $image['image'])) {
				$imageURL = get_option("siteurl")."/wp-content/themes/".get_template().$image['image'];
			}

		// otherwise, it will be stored in an uploads folder two levels above the [theme] folder
		} else {
			$large_image_url = wp_get_attachment_image_src( $image['id'] );
			$imageURL = $large_image_url[0];
		}
		
		$imageURL = str_replace("-".$large_image_url[1]."x".$large_image_url[2], "", $imageURL);
		$imageURL = str_replace("/", "|", $imageURL); // this is used to resolve issue of urls being blocked by hosting platforms such as hostgator
		$imageURL = get_option("siteurl")."/wp-content/themes/".get_template()."/includes/user_view/thumb.php?src=".$imageURL."&amp;w=".$lmImageDefaults['medium']['width']."&amp;h=".$lmImageDefaults['medium']['height']."&amp;zc=1&amp;q=90&amp;v=1";

		$sliderHTML .= '<li><img src="'.$imageURL.'" alt="Image '.$imageCount.'" /></li>';
	

	}

?>
<div class="parallax_slider_wrapper">
            <ul class="parallax_slider">
            <?php echo $sliderHTML; ?>
            </ul>
<div class="parallax_navigation">
					<span class="parallax_next"></span>
					<span class="parallax_prev"></span>
				</div>
				<ul class="parallax_thumbnails">       
                            <?php echo $sliderHTML; ?>
            </ul>     
	</div>
		</div>
        <!-- The JavaScript -->
		<script type="text/javascript" src="<?php get_template_directory_uri(); ?>/Site/component-parallax-slider/js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="<?php get_template_directory_uri(); ?>/Site/component-parallax-slider/js/parallax-slider.js"></script>
        

		<script type="text/javascript">
			jQuery(function() {
				var $parallax_container	= $('#parallax_container');
				$parallax_container.parallaxSlider();
			});
			
			(function($) {
    			if(jQuery.browser.msie && jQuery.browser.version < 9) {
      			jQuery.fx.off = false;

				
			}


			$.fn.customFadeIn = function(speed, callback) {
				$(this).fadeIn(speed, function() {
					if(jQuery.browser.msie && jQuery.browser.version < 9)
						$(this).get(0).style.removeAttribute('filter');
					if(callback != undefined)
						callback();
				});
			};
			$.fn.customFadeOut = function(speed, callback) {
				$(this).fadeOut(speed, function() {
					if(jQuery.browser.msie && jQuery.browser.version < 9)
						$(this).get(0).style.removeAttribute('filter');
					if(callback != undefined)
						callback();
				});
			};
	
			$.fn.customAnimate = function(options, speed, easing, callback) {
	  		$(this).animate(options, speed, easing, function() { 
	  					if(jQuery.browser.msie && jQuery.browser.version < 9) {
						$(this).get(0).style.removeAttribute('filter');
						}
					if(callback != undefined)
						callback();
				});
			};
		})(jQuery);

        </script>
        </div>
<?php
}
}
?>
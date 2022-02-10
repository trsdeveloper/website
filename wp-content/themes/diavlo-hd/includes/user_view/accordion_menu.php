<?php
function luckymarble_show_accordion_menu() {
	
	global $lmPortfolioConfig;
	global $lmImageDefaults;
	global $page_id;
   // print "a";
	$portfolioImages = get_option("luckymarble_accordion_menu-{$page_id}");
	if (!is_array($portfolioImages) || sizeof($portfolioImages) == 0) {
		//print "in it")
	  $portfolioImages = get_option('luckymarble_accordion_menu');
	}
	
	$portfolioText = $portfolioImages['text'];
	$portfolioImages = $portfolioImages['images'];
	rsort($portfolioImages);
	//print "b".sizeof($portfolioImages);
	//return;

if(is_array($portfolioImages)) {
?>
<script type="text/javascript">
jQuery(window).load(function() {
  // init the nivo slider on the #slider div
  jQuery('#slider').nivoSlider();

  // override the hover effects for the bullets
  jQuery('.nivo-control').hover(
    function() {jQuery(this).customAnimate({ opacity: 1.00 }, 300, 'linear')},
    function() {jQuery(this).customAnimate({ opacity: 0.50 }, 100, 'linear')});

});</script>
<div id="accordian_menu">
<div id="lmc_accordion-menu">
<ul class="accordion_menu" id="accordion_menu">

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

			if (!strstr(get_option("siteurl"), $image['image'])) {
				$imageURL = get_option("siteurl")."/wp-content/themes/".get_template().$image['image'];
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
			$large_image_url = wp_get_attachment_image_src( $imageID);
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


			$large_image_url = wp_get_attachment_image_src( $image['id'] );
			$imageURL = $large_image_url[0];
		}
		
		$imageURL = str_replace("-".$large_image_url[1]."x".$large_image_url[2], "", $imageURL);
		$imageURL = str_replace("/", "|", $imageURL); // this is used to resolve issue of urls being blocked by hosting platforms such as hostgator
		$imageURL = get_option("siteurl")."/wp-content/themes/".get_template()."/includes/user_view/thumb.php?src=".$imageURL."&amp;w=".$lmImageDefaults['large']['width']."&amp;h=".$lmImageDefaults['large']['height']."&amp;zc=1&amp;q=90&amp;v=1";

		// define the link
		if ($image['link_type'] == "external") {
			$linkURL = $image['link'];

		} else if ($image['link_type'] == "page") {
			if ($image['link'] == "") {
			  $linkURL = "../../../";
		  } else {
				$linkURL = str_replace(home_url().'/', '',get_page_link($image['link']));
				if ($linkURL == "" && $image['link'] != "") {
					$linkURL = $image['link'];
				} else {
					$linkURL = "../../../".$linkURL;
				}

				if ($image['link'] == get_option("page_on_front")) {
				  $linkURL = home_url();
				}
			}

		} else if ($image['link_type'] == "post") {

			if ($image['description'] == "") {
				// if no id specified, then it's the newest post
				$image['description'] = $post->post_title;
			}

			$linkURL = str_replace(home_url().'/', '',get_page_link($image['link']));

		}
			$sliderCaption .= "<li class='bg{$imageCount}";
			if ($imageCount == 4) {
				$sliderCaption .= " bleft";
			} 
			$sliderCaption .= "'>\n";
			$sliderCaption .= "<div class='heading'>{$image['title']}</div><div class='bgDescription'></div>\n";
			$sliderCaption .= "<div class='description'><h4>{$image['title']}</h4><p>{$image['description']}</p>\n";

        if ($image['link'] == "") {
			//echo '<a href="#"><img src="'.$imageURL.'" title="#image'.$imageCount.'" /></a>';
		    $sliderCaption .= "";
		} else {
			//echo '<a target="'.$image['link_target'].'" href="'.$linkURL.'"><img src="'.$imageURL.'" title="#image'.$imageCount.'" /></a>';
		    $sliderCaption .= "<a target='".$image['link_target']."' href='".$linkURL."'>".$image['link_label']."</a>";
		}
		$sliderCaption .= "</div></li>\n";

	}

print $sliderCaption;
?>

            </ul>        

            
        </div>

 <!-- The JavaScript -->
        <script type="text/javascript">
            $(function() {
                $('#accordion_menu > li').hover(
                    function () {
                        var $this = $(this);
                        $this.stop().animate({'width':'476px'},500);
                        $('.heading',$this).stop(true,true).fadeOut(250);
                        $('.bgDescription',$this).stop(true,true).slideDown(500);
                        $('.description',$this).stop(true,true).fadeIn();
                    },
                    function () {
                        var $this = $(this);
                        $this.stop().animate({'width':'140px'},100);
                        $('.heading',$this).stop(true,true).fadeIn();
                        $('.description',$this).stop(true,true).fadeOut(500);
                        $('.bgDescription',$this).stop(true,true).slideUp(700);
                    }
                );
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
<?php
}
}
?>
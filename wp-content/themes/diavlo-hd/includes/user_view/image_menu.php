<?php
function luckymarble_show_image_menu() {
	
	global $lmPortfolioConfig;
	global $lmImageDefaults;
	global $page_id;
   // print "a";
	$portfolioImages = get_option("luckymarble_image_menu-{$page_id}");
	if (!is_array($portfolioImages) || sizeof($portfolioImages) == 0) {
		//print "in it")
	  $portfolioImages = get_option('luckymarble_image_menu');
	}
	//print "b".sizeof($portfolioImages);
	//return;

if(is_array($portfolioImages)) {
								$menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );

?>
<div id="image_menu">
<div class="lmc_image_menu">
<div id="lmc_image_menu_container" class="lmc_image_menu_container">
			
<?php
$postCount = 0;
$imageCount = 0;
$sliderHTML = "";
$firstImage;
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
		$imageURL = get_option("siteurl")."/wp-content/themes/".get_template()."/includes/user_view/thumb.php?src=".$imageURL."&amp;w=".$lmImageDefaults['large']['width']."&amp;h=".$lmImageDefaults['large']['height']."&amp;zc=1&amp;q=90&amp;v=1";
if ($firstImage == "") {
	$firstImage = $imageURL;
}
$sliderHTML .= '<div class="lmc_image_menu_panel" data-bg="'.$imageURL.'">';
						

		foreach ( $menus as $menu ) {
			if ($menu->term_id == $image['menu']) {
				$sliderHTML .= '<a href="#" class="lmc_image_menu_label">'.$menu->name.'</a>';
$sliderHTML .= '<div class="lmc_image_menu_content">';

			  $sliderHTML .= wp_nav_menu(array( 'menu' => $image['menu'], 'container' => false, 'items_wrap' => '<ul>%3$s</ul>', 'echo' => 0));
	$sliderHTML .= '</div>';
			}
			//$linkToTypes .= '<option '.($image['menu'] == $menu->term_id ? "selected='selected'" : "").' value="'.$menu->term_id.'">'.$menu->name.'</option>';
		}
	

$sliderHTML .= '</div>';
	

	}

?>

            <?php echo $sliderHTML; ?>
		</div>
		</div>
        </div>

<!-- parameters for image menu 

defaultBg: 	the default image shown when no label is hovered
pos: 		if no defaultBg set, pos will indicate the panel that should be shown/open
width: 		the width of the container and the images (they should all be of the same size)
height: 	the height of the container and the images
border: 	the width of the margin between the panels
menuSpeed: 	the speed with which the menu should slide up

mode: 		the type of animation; you can use def | fade | seqFade | horizontalSlide | seqHorizontalSlide | verticalSlide | seqVerticalSlide | verticalSlideAlt | seqVerticalSlideAlt
speed: 		the speed of the panel animation
easing: 	the easing effect for the animation, open the jquery.easing1.3.js file for all examples of this parameter
seqfactor: 	delay between each item animation for seqFade | seqHorizontalSlide | seqVerticalSlide | seqVerticalSlideAlt

examples of parameters 

defaultBg	: 'Site/themed_images/portfolio-very-large-1.jpg',
menuSpeed	: 300,
border		: 1,
mode		: 'verticalSlideAlt',
speed		: 450,
easing		: 'easeOutBack'
seqfactor	: 100

best modes to try out

mode		: 'seqFade',
mode		: 'horizontalSlide',
mode		: 'seqHorizontalSlide',
mode		: 'seqVerticalSlide',
mode		: 'seqVerticalSlideAlt',
mode		: 'seqVerticalSlide',
mode		: 'verticalSlide',
mode		: 'verticalSlideAlt',

-->
			
			
		<script type="text/javascript" src="<?php get_template_directory_uri(); ?>/Site/component-image-menu/js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="<?php get_template_directory_uri(); ?>/Site/component-image-menu/js/image-menu.js"></script>
		<script type="text/javascript">
			jQuery(function() {
				jQuery('#lmc_image_menu_container').bgImageMenu({
					defaultBg	: '<?php echo str_replace("&amp;", "&", $firstImage); ?>',
					menuSpeed	: 300,
					border		: 1,
					width		: 900,
					height		: 375,
					type		: {
						mode		: 'seqHorizontalSlide',
						speed		: 250,
						easing		: 'jswing',
						seqfactor	: 100
					}
				});
			});
		</script>
<?php
}
}
?>
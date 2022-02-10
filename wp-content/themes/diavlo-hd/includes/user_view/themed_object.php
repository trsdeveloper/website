<?php
function luckymarble_themed_object() {
	global $lmIncludedComponents, $pageTemplate;
    $lmThemedImage = get_option('luckymarble_themed_image');
    
	if ($lmThemedImage == "" && $lmIncludedComponents['themed_object']) {
	  $lmThemedImage['enabled'] = true;
      $fileName = get_template_directory_uri() ."/Site/themed_images/themed_object.png";
	  
	} else if($lmThemedImage['enabled']) {
        $metaData = get_post_meta($lmThemedImage['image_id'], '_wp_attachment_metadata', true);
        $fileName = site_url().'/wp-content/uploads/'.$metaData['file'];
	}
	if (array_key_exists("enabled", $lmThemedImage) && $lmThemedImage['enabled'] == true) {
    ?>
    <!--themed object-->
    <div id="themed_object" <?php if ($lmIncludedComponents['themed_object']) { ?>style="visibility:visible; display:block; position:absolute; top:<?php echo $lmThemedImage['position']["{$pageTemplate}"]['top']; ?>px; left:<?php echo $lmThemedImage['position'][$pageTemplate]['left'];?>px;"<?php } ?>>
    <img alt="themed_object" src="<?php echo $fileName?>">
    </div>
    <!--/themed object-->

    <?php
    }

}
?>
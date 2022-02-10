<?php

// this is normally set to 1 within the system, but as we don't want to do any switching with this XML file, even if mobile, we set it to zero
define("WPMP_SWITCHER_DESKTOP_PAGE", 0);

// load the wordpress system
include('../../../../../../wp-blog-header.php');
if (!$wpdb) {
  include($_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php');	
}
// explicitly set HTTP header to 200 (required on some godaddy servers)
header("HTTP/1.1 200 OK");

if(array_key_exists("cmd", $_POST) && $_POST['cmd'] == "refresh") {
	$selectedClass = "";
?>
	<?php
	$imageUploads = $wpdb->get_results("SELECT * FROM {$wpdb->posts} WHERE post_type='attachment' AND (post_mime_type='image/jpeg' OR post_mime_type='image/png')");
  if (array_key_exists("resource_type", $_POST) && $_POST['resource_type'] == "page") {
		if ($_POST['resource_id'] == "") {
		    echo '<div class="image-choice-featured'.$selectedClass.'">Use Featured Image<br/><a href="javascript:updatePortfolioImage(\''.$_POST['id'].'\', \'featured_image\', \''.I3D_Framework::getAuxIconSrc("featured-post").'\');">';
				echo "<img class='image-choice' src='".I3D_Framework::getAuxIconSrc("featured-post-lg")."' />";
        echo '</a></div>';
		} else {
			$imageID = get_post_meta($_POST['resource_id'], '_thumbnail_id', true);
			$pageData = get_page($_POST['resource_id']);
			$large_image_url = wp_get_attachment_image_src( $imageID);
			$large_image_url[0] = str_replace("-".$large_image_url[1]."x".$large_image_url[2], "", $large_image_url[0]);

			if ($_POST['selected'] == "featured_image") {
				$selectedClass = " image-selected";
			} else {
				$selectedClass = "";
			}
			if ($large_image_url != "") {
		    echo '<div class="image-choice-featured'.$selectedClass.'">"'.$pageData->post_title.'" Featured Image<br/><a href="javascript:updatePortfolioImage(\''.$_POST['id'].'\', \'featured_image\', \''.$large_image_url[0].'\');">';
				echo "<img class='image-choice' src='../wp-content/themes/".get_template()."/includes/user_view/thumb.php?src=".str_replace("-150x150", "", $large_image_url[0])."&amp;w=215&amp;h=129&amp;zc=1&amp;q=90&amp;v=1' />";
        echo '</a></div>';
			} else {
		    echo '<div class="image-choice-featured'.$selectedClass.'">Use Featured Image<br/><a href="javascript:updatePortfolioImage(\''.$_POST['id'].'\', \'featured_image\', \''.I3D_Framework::getAuxIconSrc("featured-post").'\');">';
				echo "<img class='image-choice' src='".I3D_Framework::getAuxIconSrc("featured-post-lg")."' />";
        echo '</a></div>';

			}
		}
	} else if (array_key_exists("resource_type", $_POST) &&  $_POST['resource_type'] == "post") {
		//print "selected: ".$_POST['selected'];
			if ($_POST['selected'] == "featured_image") {
				$selectedClass = " image-selected";
			} else {
				$selectedClass = "";
			}
		if ($_POST['resource_id'] == "") {
		    echo '<div class="image-choice-featured'.$selectedClass.'">Use Featured Image<br/><a href="javascript:updatePortfolioImage(\''.$_POST['id'].'\', \'featured_image\', \''.I3D_Framework::getAuxIconSrc("featured-post").'\');">';
				echo "<img class='image-choice' src='".I3D_Framework::getAuxIconSrc("featured-post-lg")."' />";
        echo '</a></div>';
		} else {
			$imageID = get_post_meta($_POST['resource_id'], '_thumbnail_id', true);
			$postData = get_post($_POST['resource_id']);
			$large_image_url = wp_get_attachment_image_src( $imageID);

			if ($_POST['selected'] == "featured_image") {
				$selectedClass = " image-selected";
			} else {
				$selectedClass = "";
			}
			if ($large_image_url != "") {
		    echo '<div class="image-choice-featured'.$selectedClass.'">"'.$postData->post_title.'" Featured Image<br/><a href="javascript:updatePortfolioImage(\''.$_POST['id'].'\', \'featured_image\', \''.$large_image_url[0].'\');">';
				echo "<img class='image-choice' src='../wp-content/themes/".get_template()."/includes/user_view/thumb.php?src=".str_replace("-150x150", "", $large_image_url[0])."&amp;w=215&amp;h=129&amp;zc=1&amp;q=90&amp;v=1' />";
        echo '</a></div>';
			} else {
		    echo '<div class="image-choice-featured'.$selectedClass.'">Use Featured Image<br/><a href="javascript:updatePortfolioImage(\''.$_POST['id'].'\', \'featured_image\', \''.I3D_Framework::getAuxIconSrc("featured-post").'\');">';
				echo "<img class='image-choice' src='".I3D_Framework::getAuxIconSrc("featured-post-lg")."' />";
        echo '</a></div>';
			}
		}


	}
	if (sizeof($imageUploads) == 0) {
	  print "You have not yet uploaded any images.  Please click the 'Upload New Image' button above.";
	}
	foreach($imageUploads as $image) {
		$imagePath = substr($image->guid,(strpos($image->guid,"/uploads/") +1));
			if ($_POST['selected'] == $image->ID) {
				$selectedClass = " image-selected";
			} else {
				$selectedClass = "";
			}
			$large_image_url = wp_get_attachment_image_src( $image->ID);

		echo '<div class="image-choice'.$selectedClass.'"><a class="image-choice" href="javascript:updatePortfolioImage(\''.$_POST['id'].'\', \''.$image->ID.'\', \''.$large_image_url[0].'\');">'.wp_get_attachment_image($image->ID, array(68, 68), false).'</a></div>';
	}
	?>
	<br />
<?php
} else if($_POST['cmd'] == "get_count") {
	
	$portfolioImages = $wpdb->get_results("SELECT COUNT(*) as 'count' FROM {$wpdb->posts} WHERE post_type='attachment' AND (post_mime_type='image/jpeg' OR post_mime_type='image/png')");

	foreach($portfolioImages as $image) {
		print $image->count;
	}
}
?>
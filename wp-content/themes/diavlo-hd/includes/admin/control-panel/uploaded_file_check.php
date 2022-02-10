<?php
include('../../../../../..//wp-blog-header.php');

if($_POST['cmd'] == "refresh") {
?>
	<?php
	$imageUploads = $wpdb->get_results("SELECT * FROM {$wpdb->posts} WHERE post_type='attachment' AND ".stripslashes($_POST['mime_restriction']));

	foreach($imageUploads as $image) {
		$imagePath = substr($image->guid,(strpos($image->guid,"/uploads/") +1));		

		echo '<a href="javascript:add_option(\''.$image->ID.'\',\''.$imagePath.'\',\''.$image->post_title.'\',\''.$image->post_excerpt.'\',\''.$image->post_content.'\');">'.wp_get_attachment_image($image->ID, array(80, 80), false).'</a><br />';
	}
	?>
<?php	
} else if($_POST['cmd'] == "get_count") {
	$portfolioImages = $wpdb->get_results("SELECT COUNT(*) as 'count' FROM {$wpdb->posts} WHERE post_type='attachment' AND ".stripslashes($_POST['mime_restriction']));

	foreach($portfolioImages as $image) {
		print $image->count;
	}
}
?>
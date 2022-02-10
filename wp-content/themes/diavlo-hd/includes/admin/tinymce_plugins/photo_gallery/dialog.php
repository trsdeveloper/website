<?php
$wp_include = "../../../wp-load.php";
$i = 0;

while (!file_exists($wp_include) && $i++ < 10) {
  $wp_include = "../".$wp_include;
}

//load wordpress info
require($wp_include);

//update_post_meta($postId, substr($key,7), $value);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel='stylesheet' href='<?php echo get_option("siteurl") ?>/wp-admin/load-styles.php?c=1&amp;dir=ltr&amp;load=global,wp-admin' type='text/css' media='all' />
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script type='text/javascript' src='<?php echo site_url() ;?>/wp-admin/load-scripts.php?c=1&amp;load=jquery,utils,swfupload-all,swfupload-handlers,jquery-ui-core,jquery-ui-sortable'></script>
	<script type="text/javascript">
	jQuery(function($) {
		$("#sortable").sortable();
	});
	
	function remove_option(id) {
		//get containing div element (container)
		var container = document.getElementById('sortable');

		//get div element to remove
		var olddiv = document.getElementById('image__'+id);

		//remove the div element from the container
		container.removeChild(olddiv);
	}	
		
	function add_option(id, source, title, caption, description) {
		jQuery("#sortable").append('<li id="image__new'+counter+'"><table class="portfolio_image" cellspacing="0"><tr><td valign="top"><img src="<?php echo site_url() ."/wp-content/";?>'+source+'" height="60" width="60" /></td><td><label for="new'+counter+'__name">Name</label><input type="text" class="text_input" id="new'+counter+'__name" name="new'+counter+'__name" value="" /><br /><label for="new'+counter+'__description">Description</label><textarea class="text_input" id="new'+counter+'__description" name="new'+counter+'__description"></textarea><input type="hidden" name="new'+counter+'__image_id" value="'+id+'" /><input type="hidden" name="images[]" value="new'+counter+'" /></td><td valign="top" style="width: 80px;"><input type="button" name="nocmd" value="Remove" onclick="remove_option(\'new'+counter+'\')" /></td></tr></table></li>');
		counter++;
	}
	
	var counter = 1;

	</script>
	<style>
	html, body {padding: 0px; margin: 0px;}
	#sortable label {width: 10em; display: inline-block; vertical-align: top;}
	#sortable input.text_input {width: 230px;font-size: 11px;}
	#sortable textarea.text_input {width: 230px; height: 50px;font-size: 11px;}
	table.portfolio_image img {border: 1px solid #ccc;}
	td.image_library {vertical-align: top; text-align: center; border-left: 1px solid #000;}
	td.image_library img, td.image_library div img {margin-bottom: 5px; border: 1px solid #ccc;}	
	</style>
</head>
<body onLoad="tinyMCEPopup.executeOnLoad('init();');">
<?php
if($_POST['cmd'] == "save") {
	$stagAttr = str_replace('lmgallery id="'.$_GET['post_id'].'"','',stripslashes($_GET['properties']));
	
	if(!get_magic_quotes_gpc()) {
		$stagAttr = str_replace('lmgallery id="'.$_GET['post_id'].'"','',$_GET['properties']);
	}
	
	$photoGallery = array();

	foreach($_POST['images'] as $id) {
			//get image file name
			$metaData = get_post_meta($_POST[$id.'__image_id'], '_wp_attachment_metadata', true);
			$fileName = "uploads/".$metaData['file'];

			$photoGallery[] = array('id' => $_POST[$id.'__image_id'], 'image' => $fileName,'name' => stripslashes($_POST[$id.'__name']),'description' => stripslashes($_POST[$id.'__description']));
	}

	update_post_meta($_GET['post_id'], "luckymarble_photo_gallery", $photoGallery);		
	?>
	<script>
	var returnStr = '<img src="'+tinymce.baseURL+'/plugins/wpgallery/img/t.gif" class="lmPhotoGallery mceItem" title="lmgallery'+tinymce.DOM.encode(' id="<?php echo $_GET['post_id'].'"'.$stagAttr;?>')+'" />';

	window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, returnStr);
	tinyMCEPopup.editor.execCommand('mceRepaint');
	tinyMCEPopup.close();	
	</script>
	<?php
}	
?>
	<div class="wrap">
		<h2>Manage Photo Gallery</h2>
		<form method="post">
		<table class="widefat" width="100%">
		<thead>
		<tr><th>Photo Gallery</th><th>Image Library</th></tr>
		</thead>
		<tbody>
		<tr>
		<td valign="top">
		<?php
			$photoGallery = get_post_meta($_GET['post_id'], 'luckymarble_photo_gallery', true);
			$counter = 0;
			
			echo '<ul id="sortable">';
			
			if(is_array($photoGallery)) {
			foreach($photoGallery as $image) {
				//only list image if it still exists
				if(wp_attachment_is_image($image['id'])) {
					echo '<li id="image__'.$counter.'"><table class="portfolio_image" cellspacing="0">
									<tr>
										<td valign="top" width="65px">'.wp_get_attachment_image($image['id'], array(60, 60), false).'</td>
										<td>								
											<label for="'.$counter.'__name">Name</label><input type="text" class="text_input" id="'.$counter.'__name" name="'.$counter.'__name" value="'.$image['name'].'" /><br />
											<label for="'.$counter.'__description">Description</label><textarea class="text_input" id="'.$counter.'__description" name="'.$counter.'__description">'.$image['description'].'</textarea><br />
											<input type="hidden" name="'.$counter.'__image_id" value="'.$image['id'].'" />
											<input type="hidden" name="images[]" value="'.$counter.'" />
										</td>
										<td valign="top"  width="80px">							
											<input type="button" name="nocmd" value="Remove" onclick="remove_option(\''.$counter.'\')" />
										</td>
									</tr>
								</table></li>';

					$counter++;
				}
			}
			}
		?>
			</ul>	
			<input type="hidden" name="cmd" value="save" />
			<input type="submit" name="nocmd" class="button" value="Save Changes" />					
		</td>		
		<td class="image_library" width="100px">
		<br /><a href="<?php echo home_url(); ?>/wp-admin/media-new.php" target="_blank" class="button add-new-h2">Add New</a><br /><br />
		<div class="uploaded_images">
		<?php
		
		$photoGallery = $wpdb->get_results("SELECT COUNT(*) as 'count' FROM $wpdb->posts WHERE post_type='attachment' AND post_mime_type='image/jpeg'");
		
		foreach($photoGallery as $image) {
			echo '<script>
							var imageLibraryCount = '.$image->count.';

							
							function check_image_library() {
								jQuery.post("'.get_stylesheet_directory_uri() .'/includes/admin/content/uploaded_file_check.php", { cmd: "get_count", mime_restriction: "post_mime_type=\'image/jpeg\'" }, function(newCount) {

										if(parseInt(imageLibraryCount) != parseInt(newCount)) {
											jQuery.post("'.get_stylesheet_directory_uri() .'/includes/admin/content/uploaded_file_check.php", { cmd: "refresh", mime_restriction: "post_mime_type=\'image/jpeg\'" }, function(data) {
												jQuery(".uploaded_images").html(data);
												setTimeout("check_image_library()",5000);
											});
										} else {
											//check again in 5 seconds
											setTimeout("check_image_library()",5000);
										}
									});							

							}
							setTimeout("check_image_library()",5000);
						</script>';
		}
		
		$imageUploads = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type='attachment' AND post_mime_type='image/jpeg'");

		foreach($imageUploads as $image) {
			$imagePath = substr($image->guid,(strpos($image->guid,"/uploads/") +1));		

			echo '<a href="javascript:add_option(\''.$image->ID.'\',\''.$imagePath.'\',\''.$image->post_title.'\',\''.$image->post_excerpt.'\',\''.$image->post_content.'\');">'.wp_get_attachment_image($image->ID, array(80, 80), false).'</a><br />';
		}
		?>
		</div>
		<br />
		<a href="<?php echo home_url(); ?>/wp-admin/media-new.php" class="button add-new-h2" target="_blank">Add New</a>
		</td>
		</tr>
		</tbody>
		</table>
	</form>
	</div>
</body>
</html>
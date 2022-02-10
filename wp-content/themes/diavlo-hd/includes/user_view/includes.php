<?php
if (file_exists(get_template_directory()."/includes/theme/config.php")) {
	include(get_template_directory().'/includes/theme/config.php');
} else {
	include(get_template_directory().'/includes/config.php');
}


foreach ($filesToInclude as $fileToInclude) {
	$filePath = get_template_directory().'/includes/'.$fileToInclude.'.php';
	if (file_exists($filePath)) {
		include($filePath);
	}
}
?>
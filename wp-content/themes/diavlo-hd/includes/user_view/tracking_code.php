<?php
function i3d_render_tracking_script() {
          
		$generalSettings = get_option('i3d_general_settings');
		if (isset($generalSettings['tracking_code'])) {
        	echo $generalSettings['tracking_code'];
		}

}
?>
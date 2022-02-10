<?php
if (get_option("i3d_license_key__".get_stylesheet()) == "") {
	update_option("i3d_license_key__".get_stylesheet(), "");
} else {
}
?>
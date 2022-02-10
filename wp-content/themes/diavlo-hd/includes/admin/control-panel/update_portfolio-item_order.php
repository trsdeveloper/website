<?php

// this is normally set to 1 within the system, but as we don't want to do any switching with this XML file, even if mobile, we set it to zero
define("WPMP_SWITCHER_DESKTOP_PAGE", 0);

// load the wordpress system
include('../../../../../../wp-blog-header.php');

// explicitly set HTTP header to 200 (required on some godaddy servers)
header("HTTP/1.1 200 OK");

global $wpdb;
$wpdb->query("UPDATE {$wpdb->posts} SET menu_order='{$_POST['order']}' WHERE ID='{$_POST['id']}'");

print "UPDATE {$wpdb->posts} SET menu_order='{$_POST['order']}' WHERE ID='{$_POST['id']}'";
?>
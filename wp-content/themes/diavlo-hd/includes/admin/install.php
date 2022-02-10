<?php
$debug = false;

// Setup theme options and redirect to settings page
if (!array_key_exists("install", $_GET) && array_key_exists("activated", $_GET) && $_GET['activated'] == "true" && !array_key_exists("config", $_GET) && !array_key_exists("configuration", $_GET)) {
	
	update_option("installation_status", "");
	update_option("installation_status_percent", 0);

	$existingPages = get_pages();
	if (!$debug) {
		if (I3D_Framework::$supportType == "tf") {
			wp_redirect(admin_url("admin.php?page=i3d-settings&install=start"));
		} else if (sizeof($existingPages) > 1) {
			wp_redirect(admin_url("admin.php?page=i3d-settings&config=requested"));		
		} else {
			wp_redirect(admin_url("admin.php?page=i3d-settings&install=start"));
		}
	} else {
		I3D_Framework::setDebug(true);
		$_GET['install'] = "start";
		I3D_Framework::set_config_status(7, "Debugging");
		add_action('init', array('I3D_Framework', 'init'), 1990);
		add_action('init', array('I3D_Framework', 'init_navigation'), 1996);
		
	}

// this is used for debug theme installation
} else if (array_key_exists("activated", $_GET) && array_key_exists("configuration", $_GET) && $_GET['activated'] && $_GET['configuration'] == "debug") {
	 I3D_Framework::setDebug(true);

	 I3D_Framework::set_config_status(7, "Debugging");
	 add_action('init', array('I3D_Framework', 'init'), 1990);
	 //add_action('init', array('I3D_Framework', 'activate'), 1995);
	// add_action('init', array('I3D_Framework', 'init_pages'), 1995);
	add_action('init', array('I3D_Framework', 'init_navigation'), 1996);

// this is what happens when the requested theme configuration is initiated
} else if (array_key_exists("activated", $_GET) && array_key_exists("configuration", $_GET) && $_GET['activated'] && $_GET['configuration'] != "") {
	 //I3D_Framework::setDebug(true);

	 I3D_Framework::set_config_status(7, "Initializing Configuration Routine");
	 add_action('init', array('I3D_Framework', 'init'), 1990);
	 add_action('init', array('I3D_Framework', 'activate'), 1995);
	


// this is what happens when a user activates the them
} else if(array_key_exists("activated", $_GET) && $_GET['activated'] && (!array_key_exists("configuration", $_GET) || $_GET['configuration'] == "")){
	I3D_Framework::set_config_status(2, "Commencing Initialization Routine");

	add_action('init', array('I3D_Framework', 'init'), 1990);
	add_action('init', array('I3D_Framework', 'pre_activate'), 1995);
	
} 
// localhost/wordpress-tempus/wp-admin/admin.php?activated=true&configuration=default
?>
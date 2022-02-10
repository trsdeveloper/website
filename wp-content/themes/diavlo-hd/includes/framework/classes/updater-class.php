<?php
// if the WordPress native WP_Upgrader class is not defined, load it
if (!class_exists('WP_Upgrader')) {
	require_once (ABSPATH.'wp-admin/includes/class-wp-upgrader.php');
}

// extend the native WP_Upgrader class
class Aquila_Updater extends Theme_Upgrader {
	public $themeLicenseID 	= "";
	public $themeName      	= "";
	private $updateURL 		= "http://wordpress.server-apps.com/update/";
	private $updates 		= array();
	private $oneDay			= 86400;
	private $oneMinute			= 1;

	public function __init() {
		$theme = wp_get_theme();
		$this->themeName = $theme->Name;
		$this->themeLicenseID = get_option("i3d_license_key__".get_stylesheet());
        $this->upgrader_skin = new AquilaUpgraderSkin();
        $this->upgrader_skin->set_option('title', sprintf('%s: Download and Upgrade', $this->themeName ) );
		if ($pagenow == "admin.php") {
			$this->update_available = $this->update_check();
		}
		if ($this->update_available) {
           add_action('admin_notices', array($this, 'show_update_nag')); 
        }

		
	}
	function update_check($checkNow = false) {
		if ($checkNow) {
			$updateTime = 0;
			
		} else {
			$updateTime = $this->oneDay;
			
		}
	//	$updateTime = $this->oneMinute;
		//$updateTime = 0;
		if (get_option("i3d_when_last_checked_for_update") + $updateTime < time() || $checkNow) {
		  $current = $this->checkForUpdate();
		 // var_dump($current); 
		//  update_option("i3d_when_last_checked_for_update", mktime());
		//print date_i18n("F j, Y g:i a")."<br>";
		//print strtotime(date_i18n("F j, Y g:i a"))."<br>";
		  update_option("i3d_when_last_checked_for_update", strtotime(date_i18n("F j, Y g:i a")));
		  
		  update_option("i3d_theme_update_version", @$current->response['theme_version']);
		  update_option("i3d_framework_update_version", @$current->response['framework_version']);
		} else {
			//$current = $this->checkForUpdate();
		}
		
		if (I3D_Framework::updateIsCurrent()) {
		  return false;	
		}
		
		return true; 
	}
    function show_update_nag() {
		?>
 <div class="update-nag">
    <?php 
	$adminPage = "admin.php?page=i3d-update-theme";
	echo sprintf(__('An update is available for the %s theme. Go to the %sUpdates%s page for more info.', "i3d-framework"), $this->themeName, '<a href="'.$adminPage.'">', '</a>'); ?>
</div>       
        <?php
       
    }	
	
	function bulk_upgrade($themes = array(), $args = array()) {
		global $wp_filesystem;
		@set_time_limit(0);
		
		$this->init();
		$this->bulk = true;
		$this->upgrade_strings();
		
		$this->upgrader_skin->header();
		
		// connect to the filesystem
		$fs = $this->fs_connect(array(WP_CONTENT_DIR));
		if (!$fs) {
            $this->upgrader_skin->error( '<br/>'.__('Could not connect to the filesystem.', "i3d-framework"), true );
			$this->upgrader_skin->footer();
			return false;
		}

	    if (!current_user_can('update_themes')){
            $this->upgrader_skin->error( '<br/>'.__('Current user does not have permissions to update themes', "i3d-framework"), true );
            return;
        }	
	    if(!($current = $this->checkForUpdate())){
            exit();
        }	
				
	    $package = $current->response['download_package'];
		
		if (isset($_POST['install_theme_files'])) {
			$package .= "/{$_POST['install_template_files']}/{$_POST['install_theme_files']}/";
		} 
		$options        = array(
			'package'           			=> $package,
			'destination'       			=> $wp_filesystem->wp_themes_dir() . $current->response['theme_folder'],
			'abort_if_destination_exists' 	=> false, // overwrite existing
			'clear_destination'				=> false,
			'clear_working'     			=> true  
		);	
		//	var_dump($options);
		//	exit;
		$result = $this->run($options);

		unset($this->skin->result);

		if(is_wp_error( $result ) || false === $result ){
          	$this->upgrader_skin->footer();
			$this->upgrader_skin->error( __('Error while installing package.', "i3d-framework"), true); 
		    return;
         }
		 $theme = wp_get_theme();
		 
		 if (is_child_theme() && strstr(get_stylesheet(), $current->response['theme_folder'])) {
			 //print "not switching";
		 } else {
			// print "switching";
          // deactivated Jan 22, 2016 as it was cuasing sidebars to drop their widgets upon some updates.  Seems to be okay with out.
		  // switch_theme($current->response['theme_folder'], $current->response['theme_folder']);	
		 }
		 //return;
		 
		 update_option("i3d_when_last_updated", mktime());		 
		 update_option("i3d_framework_update_version", $current->response['framework_version']);		 
		 update_option("i3d_theme_update_version",     $current->response['theme_version']);		 

		// $wp_filesystem->delete( trailingslashit( $wp_filesystem->wp_themes_dir() . $this->installerFolder ), true);				  
        // $this->upgrader_skin->done();
		 $this->upgrader_skin->footer(); 
							
            echo '<script type="text/javascript">';
			echo 'document.location="'.self_admin_url('admin.php?page=i3d-settings&show=whatsnew').'"';
            echo '</script>';							

}
	
    function updateParameters() {
        global $wp_version, $wpdb, $i3dParameterSettings;
		$theme = wp_get_theme();

        $params = array(
            'updater_version'   => '0.1',
			'theme_name'        => $theme->Name,
            'framework_version' => I3D_Framework::$version,
            'theme_version'     => $theme->Version,
            'theme_license'     => get_option("i3d_license_key__".get_stylesheet()),
            'wp_version'        => $wp_version,
            'php_version'       => phpversion(),
            'mysql_version'     => $wpdb->db_version(),
            'uri'               => network_home_url(),
            'locale'            => get_locale()       
			);
        return $params;
    }
	
    function checkForUpdate() {
        if (!current_user_can('update_themes')) {
            return false;
		} else if (get_option("i3d_license_key__".get_stylesheet()) == "") {
			return false;
		}

        $url               = $this->updateURL;
		//print $url;
        $updateParameters  = $this->updateParameters();
//var_dump($updateParameters);
        $options           = array(
            'body'  => $updateParameters
        );

        $request    = wp_remote_post($url, $options);
        $response   = wp_remote_retrieve_body($request);
		//var_dump($response);

        $update     = new stdClass();
        $update->timeLastChecked = time();
//var_dump($response);
        // if an error occurred, return false
        if ($response == 'error') {
                $this->upgrader_skin->error( __('Error while communicating with the server -- response states error.', "i3d-framework"), true );
			return false;
		} else if (is_wp_error($response)) {
                $this->updater_skin->error( __('Error while communicating with the server -- wordpress error.', "i3d-framework"), true );
			return false;
		} else if (!is_serialized($response)) {
                 $this->upgrader_skin->error( __('Error while communicating with the server -- response not serialized.', "i3d-framework"), true );
           return false;
        }
		
        $update->response = maybe_unserialize($response);
		
		// verify if updates are valid
        if (empty($update->response['is_valid'])) {
            $this->upgrader_skin->error( __('Error while communicating with the server -- invalid license key.', "i3d-framework"), true );
            return false;	
		}

        return $update;
    }
}

class AquilaUpgraderSkin { 
    
    private $done_header = false; // if header was set
    private $done_footer = false;
    private $options     = array();
    
    public function __construct() {}
	
    public function __destruct() {
        if( isset($this->options['components_header_done']) && !isset($this->options['components_footer_done']) ){
            $this->components_footer();
        }
        if( $this->done_header && !$this->done_footer ){
            $this->footer();
        }
    }
    
    public function set_option($id, $value){
        $this->options[$id] = $value;
    }
    
	public function header($title = '', $icon_type = 'tools') {
		if ( $this->done_header )
			return;
		$this->done_header = true;
        
        if( $title ){
            $this->options['title'] = $title;
        } else {
            $title = (string)@$this->options['title'];
        }
        
		echo '<div class="wrap">';
		echo '<h2>' . $title . '</h2>';
	}
	
	public function footer() {
		if ( !$this->done_header )
			return;
		if ( $this->done_footer )
			return;
		$this->done_footer = true;
		echo '</div>';
	}
    
    public function error($message, $mainError = false) {
		if (!$this->done_header) {
			$this->header();
        echo '
        <div class="aquila-error"><i class="icon icon-warning-sign"></i>
            <span>'.$message.'</span>
        </div>';
        
        if( $mainError ){
			$supportURL = "http://i3dthemes.com/codex/how-to-install-your-wordpress-theme-manually/";
			        echo '
        <div class="aquila-error-large"><i class="icon icon-warning-sign icon-4x pull-left"></i>
           Uh oh.  Well, this is embarassing.  Something did <b>NOT</b> go according to plan!<br/>  This was probably due to your server blocking our downloading and installation mechanism.<br/>
		   <b>Fear not!</b>  You can still install the theme but it needs to be done manually (what a drag!). 
		   <a href="'.$supportURL.'" target="_blank">Please follow this step by step tutorial</a> to learn how to do it.</span>
        </div>';

        }
		}
    }
}


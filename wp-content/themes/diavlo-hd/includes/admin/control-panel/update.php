<?php
function i3d_update_theme() {
	if (array_key_exists("cmd", $_GET) && $_GET['cmd'] == "reset_key") {
			update_option("i3d_license_key__".get_stylesheet(), "");											   
	}
	if(isset($_POST['aquila-installer'])){
		// then first check that the referer has permissions
		check_admin_referer('aquila-installer');

        // provided we get past the check, render the process page
        I3D_Framework::download_and_update();
		return;
	}
	if (isset($_POST['aquila-installer-check-version'])) {
		check_admin_referer('aquila-installer');
        
		I3D_Framework::check_update_version();
		
	}
	
	if (array_key_exists("cmd", $_POST) && $_POST['cmd'] == "Register") {
		if (($response = check_license_key($_POST['license_key'])) == "") {
			
			update_option("i3d_license_key__".get_stylesheet(), $_POST['license_key']);
		 
		} 
		
	}
	
	// when we go to the updates page, get the latest set of extensions included with this purchase
	I3D_Framework::fetchExtensions();
?>
	<style>
	input[type=submit] { cursor: pointer !important; } 
	.widefat td {vertical-align: middle;}
    div.file-list { background-color: #ffffff; font-size: 9px; height: 75px; overflow: auto; width: 300px; border: 1px solid #cccccc; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; }
div.file-list ul {  border-left: 1px solid #ccc; list-style-type: none; margin: 0px; padding: 0px; padding-left: 7px; margin-left: 7px;}
div.file-list li { padding: 0px; margin: 0px; }
div.file-list span.file { margin-left: 0px; font-family: "Courier New", Courier, monospace; }
div.file-list span.folder { display: block; margin-left: 0px; font-family: "Courier New", Courier, monospace; }
ul.installed-modules { font-size: 8pt; }
ul.to-be-deployed-modules { font-size: 8pt; } 
ul.licensed-modules { font-size: 8pt; } 
.unlicensed-message { font-style: italic; font-size: 8pt; }
.form-submit { float: none !important; }
.settings-option-box, div.settings-update-info-box { 
border: 1px solid #cccccc;
border-radius: 3px;
-webkit-border-radius: 3px;
-moz-border-radius: 3px;
margin: 4px;
width: 325px;
min-height: 100px;
display: inline-block;
vertical-align: top;
background-image: linear-gradient(bottom, rgb(153,153,153) 0%, rgb(252,252,252) 100%);
background-image: -o-linear-gradient(bottom, rgb(153,153,153) 0%, rgb(252,252,252) 100%);
background-image: -moz-linear-gradient(bottom, rgb(153,153,153) 0%, rgb(252,252,252) 100%);
background-image: -webkit-linear-gradient(bottom, rgb(153,153,153) 0%, rgb(252,252,252) 100%);
background-image: -ms-linear-gradient(bottom, rgb(153,153,153) 0%, rgb(252,252,252) 100%);

background-image: -webkit-gradient(
	linear,
	left bottom,
	left top,
	color-stop(0, rgb(153,153,153)),
	color-stop(1, rgb(252,252,252))
);

padding: 10px;
}
.settings-option-box h2, div.settings-update-info-box h2 {
	 font-size: 1em; text-transform:none;font-variant:normal; 
}
.settings-update-info-box p {  
	font-size: 8pt;
}
.settings-option-box input[type=submit] { float: right; }
.settings-update-info-box input[type=submit] { float: right; } 
fieldset {border: 1px solid #2A61BD; padding: 5px; margin: 0px 0px 5px 0px;}
fieldset legend {font-weight: bold; color: #2A61BD;}
label.optional_update {
  display: inline-block;	
  vertical-align: top;
  padding-top: 2px;
}
label.optional_update span {
	font-size: 8pt;
    font-style: italic;
	display: block;
}
div.install_section { }
div.install_section label { vertical-align: top;  padding-top: 1px; padding-left: 5px;}
.panel .fa-fw { font-size: 16pt; }
.panel .fa-check-circle-o { color: #009900; }
.panel .fa-toggle-on { color: #009900; }
.panel .fa-toggle-off { color: #cccccc; }
.panel .fa-status-toggle { cursor: pointer; }
.label-status { font-size: 9px; top: -3px; position: relative;}
.button-small { margin-top: -3px !important; }
    </style>
	
	<div class="wrap">
   <?php global $templateName;	   

	$submitButtonLabel = __('Download & Install Update', 'i3d-framework');
	$submitButtonLabel2 = __('Download & Refresh Installation Anyway', 'i3d-framework');
	$checkNowLabel = __('Check Now', 'i3d-framework');
	?>
    
    <h2><?php echo(sprintf( __('%s Theme Updater', 'i3d-framework'), $templateName)); ?></h2>
     <!-- <a style='margin: 5px 0px;' class='button button-primary' href="http://youtu.be/iUrzT01SmTk" target="_blank"><i class='icon-youtube'></i> Watch The Help Video</a> -->

    <form method="post">
        
             
		<?php
				// update_option_option("i3d_license_key__".$current->response['theme_folder'], $this->licenseID);

		$licenseKey = get_option("i3d_license_key__".get_stylesheet());
		
		if ($licenseKey == "") { ?>
                <h3>Registration</h3>
                <p>Register your theme for free updates!</p>
<?php
			if ($_POST['cmd'] == "Register" ) echo '<div style="width: 650px" id="message" class="error fade below-h2"><p><strong>'.$response.'</strong></p></div>';

			?>
        
			<table class="form-table">
        <tr>
          <th><label>License Key/ID</label></th>
          <td width="100px"><input type='text' id="license_key" name='license_key' value='<?php print $_POST['license_key']; ?>' /></td>
          <td>This is available from your account at <a href='http://my.i3dthemes.com/' target='_blank'>i3dthemes.com</a></td>
        </tr>
        </table>
                <br />

    	<input style='margin-left: 300px;' id='nocmd' type="submit" name="cmd" value="Register" />		
    
        <?php } else {
        			if (array_key_exists("cmd", $_POST) && $_POST['cmd'] == "Register" ) echo '<div style="width: 650px" id="message" class="updated fade below-h2"><p><strong>Registration Successful!</strong></p></div>';
 ?>
 <p>This theme updater checks with our servers for the very latest code available.</p>
	<div class='row'>
		<div class='col-sm-6'>
			<div class='panel panel-default'>
				<div class='panel-heading'>
   					Currently Installed
				</div>
				<div class='panel-body'>
   					<ul class='fa-ul'>
					  <li><i class='fa-li fa fa-clock-o'></i>Last Updated: <?php echo I3D_Framework::whenLastUpdated(); ?></li>
					  <li><i class='fa-li fa fa-code'></i>Framework Version Installed: <?php echo I3D_Framework::getFrameworkVersion(); ?>
					   <?php if (I3D_Framework::newerVersion(I3D_Framework::getFrameworkUpdateVersion(), I3D_Framework::getFrameworkVersion())) { ?>
					  <span class='label label-warning label-status'>UPDATE AVAILABLE</span>
					  <?php } else { ?>
					  <span class='label label-success label-status'><i class='fa fa-check'></i> OK</span>
					  <?php } ?>
					  </li>
					  <li><i class='fa-li fa fa-code-fork'></i>Theme Version Installed: <?php echo I3D_Framework::getThemeVersion(); ?> 
					  <?php if (I3D_Framework::newerVersion(I3D_Framework::getThemeUpdateVersion(), I3D_Framework::getThemeVersion())) { ?>
					  <span class='label label-warning label-status'>UPDATE AVAILABLE</span>
					  <?php } else { ?>
					  <span class='label label-success label-status'><i class='fa fa-check'></i> OK</span>
					  <?php } ?></li>
					</ul>
				</div>
			</div>
		</div>
		<div class='col-sm-6'>
			<div class='panel panel-default'>
				<div class='panel-heading'>
   					Source Available
				</div>
				<div class='panel-body'>
   					<ul class='fa-ul'>
					  <li><i class='fa-li fa fa-clock-o'></i>Last Checked: <?php echo I3D_Framework::whenLastChecked(); ?>  <?php submit_button($checkNowLabel, 'button small', 'aquila-installer-check-version', false); ?></li>
					  <li><i class='fa-li fa fa-code'></i>Framework Version Available: <?php echo I3D_Framework::getFrameworkUpdateVersion(); ?></li>
					  <li><i class='fa-li fa fa-code-fork'></i>Theme Version Available: <?php echo I3D_Framework::getThemeUpdateVersion(); ?></li>
					</ul>
				</div>
			</div>
		</div>
		
	</div>
	<?php /*
	if (I3D_Framework::newerVersion("4.3.10", "4.3.9.1")) {
		print "yes 4.3.10 is greater than 4.3.9.1<br>";
	} else {
		print "no 4.3.10 is smaller than 4.3.9.1<br>";
	}
	
	 if (I3D_Framework::newerVersion("4.3.8.2", "4.3.9.1")) {
		print "yes 4.3.8.2 is greater than 4.3.9.1<br>";
	} else {
		print "no 4.3.8.2 is smaller than 4.3.9.1<br>";
	} */
	?>
         <div class='panel panel-default'>
		
				
        <?php if (I3D_Framework::updateIsCurrent()) { ?>
		<div class='panel-body'>
        <p><b>Status:</b> You have the latest version!  No need to update.</p>
		  	  <div class="install_section"><input type="hidden" class="install_section" name="install_template_files" value="1" />
		 	  <i class='fa fa-fw fa-check-circle-o'></i><label>Update Framework Core</label> </div>
		 <?php if (get_option("i3d_license_type") == "developer") { ?>
			  <input type="hidden" name="install_template_files" class="install_section" value="0" />
		 <?php } else { ?>
		  	  <div class="install_section"><input type="hidden" class="install_section" name="install_template_files" value="0" />
		 	  <i class='fa fa-fw fa-status-toggle fa-toggle-off'></i><label>Update Design CSS/Graphics</label> </div>
		 <?php } ?>
		 		 <?php $updraftPluginURL = "plugin-install.php?tab=search&s=updraftplus"; ?>

		  	  <div class="install_section"><input type="hidden" class="install_section" name="install_theme_files" value="1" />
		 	  <i class='fa fa-fw fa-status-toggle fa-toggle-on'></i><label>Update Theme Code &amp; Configuration Files (includes style.css)</label> </div>
		 <p style='margin-top: 10px; font-size: 8pt;'>It is recommended that you make a backup of your theme prior to running an update.  You can do this by install and running a backup utility plugin, such as <a href="<?php echo $updraftPluginURL; ?>">UpdraftPlus</a>.</p>
		</div>
        <?php wp_nonce_field('aquila-installer') ?>
<div class='panel-footer text-right'>
        <?php submit_button($submitButtonLabel2, 'button', 'aquila-installer', false); ?>
</div>
        <?php } else { ?>
        <div class='panel-body'>
        <p><b>Status:</b> There is an update available.</p>

		  	  <div class="install_section"><input type="hidden" class="install_section" name="install_template_files" value="1" />
		 	  <i class='fa fa-fw fa-check-circle-o'></i><label>Update Framework Core</label> </div>
		 <?php if (get_option("i3d_license_type") == "developer") { ?>
			  <input type="hidden" name="install_template_files" class="install_section" value="0" />
		 <?php } else { ?>
		  	  <div class="install_section"><input type="hidden" class="install_section" name="install_template_files" value="0" />
		 	  <i class='fa fa-fw fa-status-toggle fa-toggle-off'></i><label>Update Design CSS/Graphics</label> </div>
		 <?php } ?>
		  	  <div class="install_section"><input type="hidden" class="install_section" name="install_theme_files" value="1" />
		 	  <i class='fa fa-fw fa-status-toggle fa-toggle-on'></i><label>Update Theme Code &amp; Configuration Files (includes style.css)</label> </div>
		 <?php $updraftPluginURL = "plugin-install.php?tab=search&s=updraftplus"; ?>
		 <p style='margin-top: 10px; font-size: 8pt;'>It is recommended that you make a backup of your theme prior to running an update.  You can do this by install and running a backup utility plugin, such as <a href="<?php echo $updraftPluginURL; ?>">UpdraftPlus</a>.</p>

       <!-- <p><b>Current Framework: </b> v<?php echo I3D_Framework::getFrameworkVersion(); ?> (v<?php echo I3D_Framework::getAvailableFrameworkVersion(); ?> available)</p>
        <p><b>Current Theme: </b> v<?php echo I3D_Framework::getThemeVersion(); ?> (v<?php echo I3D_Framework::getAvailableThemeVersion(); ?> available)</p>-->
		</div>
 

	

        <?php wp_nonce_field('aquila-installer') ?>
<div class='panel-footer text-right'>
        <?php submit_button($submitButtonLabel, 'button', 'aquila-installer', false); ?>
     </div>
        <?php } ?>
	
		
		
		
		</div>
		<script>
		jQuery(".fa-status-toggle").bind("click", function() {
					 					if (jQuery(this).hasClass("fa-toggle-on")) {
													jQuery(this).removeClass("fa-toggle-on");
													jQuery(this).addClass("fa-toggle-off");
													 
													 jQuery(this).parent().find("input[type=hidden].install_section").val("0");
												 } else {
													jQuery(this).removeClass("fa-toggle-off");
													jQuery(this).addClass("fa-toggle-on");
													 
													 jQuery(this).parent().find("input[type=hidden].install_section").val("1");
												 }									   
														   });

		jQuery("div.install_section label").bind("click", function() {
																   jQuery(this).parent().find(".fa-fw").click();
					 												   
														   });

	</script>
<!--
        <form method="get" id="check-for-updates-form">
 			<table class="form-table">
       <tr>
          <th><label>License Key/ID</label></th>
          <td width="100px"><input type='text' name='license_key' value="<?php echo $licenseKey; ?>" readonly/></td>
          <td><input id='nocmd' class='button button-primary' type="submit" name="cmd" value="Check for Updates" />	<input id='nocmd' class='button' type="submit" name="cmd" value="Update All Files" />	</td>
        </tr>
        </table>
-->
			
        <?php } ?>
        <!--
        </table>
        <h3>Connection Details</h3>
 		<table class="form-table">
        <tr>
          <th><label>FTP Host</label></th>
          <td width="100px"><input type='text' name='ftp_host' value="<?php echo get_option('luckymarble_ftp_host'); ?>" /></td>
          <td></td>
        </tr>
        <tr>
          <th><label>FTP Username</label></th>
          <td width="100px"><input type='text' name='ftp_username' value="<?php echo get_option('luckymarble_ftp_username'); ?>" /></td>
          <td></td>
        </tr>

        <tr>
          <th><label>FTP Password</label></th>
          <td width="100px"><input type='password' name='ftp_password' value="<?php echo get_option('luckymarble_ftp_password'); ?>" /></td>
          <td></td>
        </tr>
        -->
     
        <br/>
		</form>
        

	</div>
    
<script> 

jQuery("form#check-for-updates-form input[type=submit]").click(function() {
    jQuery("input[type=submit]", jQuery(this).parents("form")).removeAttr("clicked");
    jQuery(this).attr("clicked", "true");
});
jQuery("form#check-for-updates-form").submit(function(event) {
													var the_form = jQuery(this);
													var data = the_form.serialize();
													var url = the_form.attr( 'action' );
													var button = event.originalEvent.explicitOriginalTarget;
													//alert(button);
													var value = jQuery("input[type=submit][clicked=true]").val();
													//alert(value);
												    jQuery('input[type=submit]', this).attr('disabled', 'disabled');
													checkForUpdates(value); 

												  return false;
												  });

jQuery("form#register-form").submit(function(event) {
													var the_form = jQuery(this);
													var data = the_form.serialize();
													var url = the_form.attr( 'action' );
													var button = event.originalEvent.explicitOriginalTarget;
													//alert(button);
													var value = jQuery("input[type=submit][clicked=true]").val();
													//alert(value);
												   // jQuery('input[type=submit]', this).attr('disabled', 'disabled');
													registerLicense(value); 

												  return false;
												  });
function checkForUpdates(submitValue) { 
	args = "";
	if (submitValue == "Update All Files") {
		var lastUpdateTime = "";
	} else {
		var lastUpdateTime = "<?php print get_option('luckymarble_last_update'); ?>";
	}
	
			  args =  args + "&h=<?php print get_option("luckymarble_ftp_host"); ?>";
		args = args + "&u=<?php print get_option("luckymarble_ftp_user"); ?>";
		args =  args + "&p=<?php print get_option("luckymarble_ftp_password"); ?>";
		  
//alert(args);
	//alert(lastUpdateTime);
	jQuery.get("<?php get_template_directory_uri(); ?>/includes/admin/updater.php", args + "&last_update_time=" + lastUpdateTime, 
					function(data) {			
						jQuery("#progress-data").html(data);		
						jQuery("#progress-data2").html("");		
		  			    jQuery('form#check-for-updates-form input[type=submit]').removeAttr("disabled"); 

						   jQuery(".settings-update-info-box").each(function() {
																		if (jQuery(this).height() > maxDivHeight) {
																			//maxDivHeight = jQuery(this).height();
																			//alert($(this).height());
																		}
						  
						   });
						  //  jQuery(".settings-update-info-box").height(maxDivHeight);
						  				
                       // alert(data);

					}
					);
}


function registerLicense(submitValue) { 
	args = "cmd=register&license_key=" + jQuery("#license_key").val();
	if (submitValue == "Update All Files") {
		var lastUpdateTime = "";
	} else {
		var lastUpdateTime = "<?php print get_option('luckymarble_last_update'); ?>";
	}
		jQuery.get("<?php get_template_directory_uri(); ?>/includes/admin/updater.php", args + "&last_update_time=" + lastUpdateTime, 
					function(data) {			
						jQuery("#progress-data").html(data);		
		  			    jQuery(".form-submit").attr("disabled", false); 

						   jQuery(".settings-update-info-box").each(function() {
																		if (jQuery(this).height() > maxDivHeight) {
																			maxDivHeight = jQuery(this).height();
																			//alert($(this).height());
																		}
						  
						   });
						    jQuery(".settings-update-info-box").height(maxDivHeight);
						  				
                       // alert(data);

					}
					);
} 

var maxDivHeight = 0;
jQuery(document).ready(function() {
						   jQuery(".settings-update-info-box").each(function() {
																		if (jQuery(this).height() > maxDivHeight) {
																			maxDivHeight = jQuery(this).height();
																		}
						  
						   });
						    jQuery(".settings-update-info-box").height(maxDivHeight);
						   });
</script>

<div id='progress-data' style='display: inline-block; vertical-align: top;'></div>
<div id='progress-data-2' style='display: inline-block; vertical-align: top;'></div>

<?php
}

function check_license_key($productLicenseKey) {
	/*
	$ch = curl_init(); //init

	curl_setopt($ch, CURLOPT_URL, 'http://wordpress.server-apps.com/check/'); //setup request to website to check license key
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // return the response
	curl_setopt($ch, CURLOPT_POST, 1); //transfer information as a POST request
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'lpk='.urlencode($productLicenseKey).'&domain='.urlencode($_SERVER["HTTP_HOST"]).'&pid='.urlencode(get_template())); //pass product license key and domain name along to be checked

	//send request and save response to variable
	$response = @curl_exec($ch);
*/
	/*

	------------------------
	|||  RESPONSE CODES  |||
	------------------------

	-1 = License key is not valid for the product it was entered for (i.e. license code for members module provided when installing a blog module)
	-2 = License already used for an installation on a different domain name
	-3 = Invalid domain name passed along
	 0 = Product license key does not exist (could not be found)
	 1 = License already used for an installation for THIS domain name
	 2 = License never used, record created at LM

	*/
	//print "response: ".$response;
	$theme = wp_get_theme();
	/*
	// check to see if the curl request completed without error
	if(curl_errno($ch)) {

	  // error with license key provided
	} else if($response <= 0) {
		curl_close($ch); //close curl connection
		
		if($response == -1) {
			return "Product license key not valid for '".$theme->Name."'";

		} else if($response == -2) {
			return "Product license key already in use";

		} else {
			return "Invalid product license key";
		}
	}
	curl_close($ch); //close curl connection
	*/
	return ""; //success
}


?>
<?php
function i3d_show_installation_progress() {
		update_option("installation_status", "");
	update_option("installation_status_percent", 0);

	?>
    <style>
	#progress-box {
		width: 500px; 
		margin: auto; 
		margin-top: 50px;
	}
	#info-box {
		max-width: 750px; 
		margin: auto; 
		margin-top: 50px;
	}
	
	#progress-box h2, #progress-box h3 { font-weight: normal; }
	#percentage { font-size: 8pt; margin-bottom: 20px; }
	#progress-bar-wrapper { margin-bottom: 0px; }
	blockquote p { font-size: 11pt; }
	
	</style>
    <script>
	var statusTimeout = "";
	jQuery(document).ready(function() {
									// make call to ajax
									jQuery.ajax({ url: "themes.php?activated=true&configuration=" });
									checkStatus();
									//statusTimeout = setTimeout('checkStatus()', 2000);
								//	alert("done");
								    
												  
									});
	var installationStatus = 0;
	
	function checkStatus() {
		jQuery.ajax({ url: "admin.php?page=i3d-settings&install=progress" }).done( function(data) {
																																
		jQuery("#current-step").html(jQuery(data).find("#status").text());
		if (installationStatus >= 100) {
			clearTimeout(statusTimeout);
			jQuery("#cog-icon").removeClass("icon-spin");
			jQuery("#cog-icon").removeClass("icon-cog");
			jQuery("#cog-icon").addClass("icon-ok");
			
			jQuery("#progress-bar").css("width", "100%");
			jQuery("#percentage").html("100%");
			jQuery("#progress-bar").addClass("bar-success");	
			
			jQuery("#progress-bar-wrapper").removeClass("active");
			jQuery("#progress-bar-wrapper").removeClass("progress-striped");
			jQuery("#installation-complete").css("display", "block");
			jQuery("#current-step").html("Installation Complete!");
			
		    return;
		} else {
			installationStatus = parseInt(jQuery(data).find("#status-percent").text());

			//installationStatus += 10;
		}
		if (installationStatus > 25) {
			jQuery("#progress-bar").removeClass("progress-bar-danger");
			jQuery("#progress-bar").addClass("progress-bar-warning");

		}
		if (installationStatus > 65) {
			jQuery("#progress-bar").removeClass("progress-bar-warning");	
		}
		if (installationStatus > 85) {
			jQuery("#progress-bar").addClass("progress-bar-success");	
		}
		if (installationStatus == 100) {
			jQuery("#progress-bar").removeClass("progress-bar-striped");	
			jQuery("#progress-bar").removeClass("progress-bar-striped active");	
			
		}
		
		jQuery("#progress-bar").css("width", installationStatus + "%");
		jQuery("#percentage").html(installationStatus + "%");
		statusTimeout = setTimeout("checkStatus()", 2000);
		});	
		
	}

		
	</script>
    
      <div id="progress-box" class='text-center'>
        <h2>Theme Installation Progress</h2>
        <i id='cog-icon' class='icon-cog icon-spin'></i>
		<div id='progress-bar-wrapper' class='progress' >
           <div id='progress-bar' class='progress-bar progress-bar-danger progress-bar-striped active' roll='progressbar' style='width: 0%'></div>
        </div>
        <div id='percentage'>&nbsp;</div>
        <div id='current-step' class='current-step'>&nbsp;</div>
      </div>
      <div id="info-box">
        <div class='info-region well text-left' style='margin-top: 20px;'>
        <h3>Did You know?</h3>
        <blockquote>
        <p>WordPress started in 2003 with a single bit of code to enhance the typography of everyday writing and with fewer users than you can count on your fingers and toes. Since then it has grown to be the largest self-hosted blogging tool in the world, used on millions of sites and seen by tens of millions of people every day.</p>
        <small>WordPress.org</small>
        </blockquote>
        </div>
        <div id='installation-complete' class='text-right' style='display: none;'>
        <a class='btn btn-success' href="admin.php?page=i3d-settings&tab=tabs-initialization">Continue</a>
        </div>
      </div>
    <?php
}
?>
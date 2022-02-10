<?php
function i3d_render_soundcloud_player() {
	global $settingOptions;
	global $page_id;
	$pageSettings = get_post_meta($page_id, "soundcloud_player", true);
	$pageSettings 	= wp_parse_args( (array) $pageSettings, array( "show" => '', 'playlist'  => '', 'autoplay' => '') );
	$settingOptions 	= wp_parse_args( (array) $settingOptions, array( "soundcloud_player_enabled" => '', 'soundcloud_player_playlist' => '', 'soundcloud_player_autoplay' => '') );
	
	$playerOn = false;
	//print $settingOptions['soundcloud_player_enabled'];
	//print $pageSettings['show'];
	if ($settingOptions['soundcloud_player_enabled'] == "") {
		$playerOn = false;
	} else if ($settingOptions['soundcloud_player_enabled'] == "globally" && $pageSettings['show'] == "") {
		$playerOn = true;
	} else if ($pageSettings['show'] == "always") {
		$playerOn = true;
	}
	
	if ($playerOn) {
	  $playlist = $settingOptions['soundcloud_player_playlist'];
	  if ($pageSettings['playlist'] != "") {
		  $playlist = $pageSettings['playlist'];
	  }
	  $autoPlay = $settingOptions['soundcloud_player_autoplay'] == "1" ? "true" : "false";
	  if ($pageSettings['autoplay'] != "") {
		  $autoPlay = $pageSettings['autoplay'] == "1" ? "true" : "false";
	  }
	  
	}
	
	if ($playerOn) {
				
	  
	?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/Library/shared/soundcloud-mp3-player/js/soundcloud.player.api.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/Library/shared/soundcloud-mp3-player/js/stratus.js"></script>
				
<script type="text/javascript">

	jQuery(document).ready(function() {

		jQuery.stratus({
			color: '3D708B', 		// 	The color of the controls and waveform. Acceptable value: hex or name (from SVG color codes)
			align: 'bottom', 		//  Whether the player appears at the top of bottom of the page. Acceptable values: top or bottom
			animate: 'slide', 		//  Whether the player should 'fade' or 'slide' into.
			auto_play: <?php echo $autoPlay; ?>, 		//  Whether the player should start playing automatically.
			buying: false, 			//	Whether the buy button should appear on the player.
			download: true, 		//  Whether the download button should appear on the player.
			random: false, 			//	Whether the first played track is randomly chosen.
			user: true, 			//	Whether or not the track artist name is shown on player.
			stats: true, 			//	Whether or not the stats for comments, favorites, and plays appear on the player.
			theme: '', 				//	Pass a css url to theme the player. For example http://stratus.sc/themes/dark.css
			volume: '50', 			//  The default volume level. Acceptable value: 0 - 100
			links: [ { url: '<?php echo $playlist; ?>' } ] // A comma separated list of SoundCloud links. Can be a track, set, user, or group.
		});
		jQuery("body").css("margin-bottom", "30px");
		jQuery("#controls-wrapper").css("bottom", "30px");
		
	});
	
</script>

    <?php
	}
}
?>
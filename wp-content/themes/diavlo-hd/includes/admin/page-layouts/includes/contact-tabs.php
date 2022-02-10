<?php
if (I3D_Framework::use_global_layout()) { 

?>
<div class='tab-pane fade special-region non-visible contact' id="tabs-contact-layout">
<?php
global $post, $columnSelectedId,$lmFrameworkVersion;
global $lmUsesCustomComponentRegions;
global $customComponentSidebars;
global $lmUsesConfigurableDropDowns;
global $wp_registered_widgets; 
if (!isset($lmUsesConfigurableDropDowns)) {
	$lmUsesConfigurableDropDowns = false;
}
?>
<style>
  .input-prepend select { font-size: 14px; padding-top: 4px; height: 20px;	padding-bottom: 4px; -moz-box-sizing:content-box;
	-webkit-box-sizing:content-box;
	-ms-box-sizing:content-box;
	box-sizing:content-box; }
  
  .marginleftzero {
	  margin-left: 0px !important;
  }
  .slider-range { margin-bottom: 10px; background-color: #D9EDF7; background-image: none;}
  .ui-widget { font-size: 14px }
</style>

                    <h5>Your "Contact Page" Regions</h5>

<?php
//var_dump($pageRegions);
$template = "contact";
include("_layout.php");
?>
        

<div style='clear: both;'></div>

</div> <!-- end of tab content region -->

<?php
}
?>
<div class='tab-pane fade special-region non-visible contact' id="tabs-contact-settings">
<div class='well'>
  <h4>Map General Settings</h4>
  <p>Make sure to specify a Primary Location to center your map on (such as "City, State" or "123 Some St, City, Country"</p>
<ul class='map-settings'>
	<li>
		<label style="font-weight: bold;" for="map__api_key">Google Map API Key [<a target='_blank' href='https://developers.google.com/maps/documentation/javascript/get-api-key'>get api key</a>]</label>
		<input style="width: 250px" type="text" name="__global_aquila_google_map_api_key" id="map__api_key" value="<?php echo get_option("aquila_google_map_api_key", ""); ?>" />
	</li>	
	<li> 
		<label style="font-weight: bold;" for="map__primary_location">Primary Location</label>
		<input style="width: 250px" type="text" name="__i3d_map__primary_location" id="map__primary_location" value="<?php echo @$mapData['primary_location']; ?>" />
	</li>
	<li>
		<label style="font-weight: bold;" for="map__height">Height</label>
        <select  name="__i3d_map__height" id="map__height" >
        <?php for ($i = 100; $i <= 500; $i+=50) { ?>
		  <option <?php if (@$mapData['height'] == $i) { print "selected"; } ?> value="<?php echo $i; ?>"><?php echo $i; ?>px</option>
        <?php } ?>
		</select>
	</li>	
	<li>
		<label style="font-weight: bold;" for="map__width">Width</label>
        <select  name="__i3d_map__width" id="map__width" >
		  <option <?php if (@$mapData['width'] == "fullscreen") { print "selected"; } ?> value="fullscreen">Fullscreen</option>
		  <option <?php if (@$mapData['width'] == "contained") { print "selected"; } ?> value="contained">Contained</option>
		</select>
	</li>	
	<li>
		<label style="font-weight: bold;" for="map__markerinfo">Markers Info</label>
        <select  name="__i3d_map__markerinfo" id="map__markerinfo" >
		  <option <?php if (@$mapData['markerinfo'] == "show") { print "selected"; } ?> value="show">Show</option>
		  <option <?php if (@$mapData['markerinfo'] == "hide") { print "selected"; } ?> value="hide">Hide</option>
		</select>
	</li>	

	<li>
		<label style="font-weight: bold;" for="map__zoom">Zoom</label>
        <select  name="__i3d_map__zoom" id="map__zoom" >
        <?php for ($i = 0; $i <= 20; $i++) { ?>
		  <option <?php if (@$mapData['zoom'] == $i) { print "selected"; } ?> value="<?php echo $i; ?>"><?php echo $i; ?>x</option>
        <?php } ?>
		</select>
	</li>	
	<li>
		<label style="font-weight: bold;" for="map__type">Rendering</label>
        <select  name="__i3d_map__type" id="map__type" >
		  <option <?php if (@$mapData['type'] == "roadmap") { print "selected"; } ?> value="roadmap">Roadmap</option>
		  <option <?php if (@$mapData['type'] == "satellite") { print "selected"; } ?> value="satellite">Satellite</option>
		</select>
	</li>	
  </ul>
</div>
<div class='well'>
  <h4>Map Markers</h4>
  <p>You can have up to 6 map markers (with associated HTML coded labels) to pin different locations on the map.</p>
	
    <?php 
	for ($index = 0; $index <= 5; $index++) { 
	//  if (is_array($mapData['markers'])) {
	    $markerData = @$mapData['markers']["$index"];
	  //} else {
	//	  $mapData['markers'] = array();
	//	  $markerData = array();
	 // }
	 ?>
	
    <div class='row-fluid'>
      <h4>Marker <?php echo $index + 1; ?></h4>
      <div style='padding-left: 20px'>
     
		<label style="font-weight: bold;" for="map__markers__<?php echo $index; ?>__location">Location</label>
		<input style="width: 100%" type="text" name="__i3d_map__markers__<?php echo $index; ?>__location" id="map__markers__<?php echo $index; ?>__location" value="<?php echo $markerData['location']; ?>" />
      </div>
      <div style='padding-left: 20px'>
        <label style="font-weight: bold;" for="map__markers__<?php echo $index; ?>__label">Text Label</label>
		<textarea style="width: 100%" name="__i3d_map__markers__<?php echo $index; ?>__label" id="map__markers__<?php echo $index; ?>__label"><?php echo $markerData['label']; ?></textarea>
	</div>
    </div>
    <?php } ?>
    

</div>
</div>
<?php

?>
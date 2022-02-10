<?php 
if (!is_array(I3D_Framework::$templateRegions["events-calendar"])) {
	return;
} 
?>
<div class='tab-pane fade special-region non-visible events-calendar' id="tabs-events-calendar-layout">
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
<h5>Your "Events Calendar Page" Regions</h5>
<?php
//var_dump($pageRegions);
$template = "events-calendar";
include("_layout.php");
?>
        

<div style='clear: both;'></div>

</div> <!-- end of tab content region -->


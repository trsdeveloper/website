<?php 
if (!I3D_Framework::use_global_layout()) { 
?>
<div class='tab-pane fade special-region non-visible under-construction' id="tabs-under-construction-layout">
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

                    <h5>Your "Under Construction Page" Regions</h5>

<?php
//var_dump($pageRegions);
$template = "under-construction";
include("_layout.php");
?>
        
<div style='clear: both;'></div>

</div> <!-- end of tab content region -->
<?php } ?>
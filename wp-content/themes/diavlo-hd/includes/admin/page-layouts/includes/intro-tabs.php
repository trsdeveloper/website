<?php
global $post, $columnSelectedId, $lmTemplates, $lmColumns, $defaultTemplate, $lmNivoVersion, $templateName;

if (!I3D_Framework::use_global_layout()) { 
  
?>
<div class='tab-pane fade special-region non-visible intro' id="tabs-intro-layout">
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

                    <h5>Your "Intro Page" Desktop Layout Regions</h5>

<?php
//var_dump($pageRegions);
$template = "intro";
include("_layout.php");

?>
        

<div style='clear: both;'></div>

</div> <!-- end of tab content region -->
<?php } ?>
<div class='tab-pane special-region non-visible intro' id="tabs-intro-settings">
<div class='well'>
  <h4>Top Curtain Menu</h4>
  <p>Specify menu options for ech of your sections.  If you do not want a top menu, do not fill in any blanks.</p>
<ul class='curtain-menu-settings'>
	<li>
		<label style="font-weight: bold;" for="curtain_menu__intro-panel-1">Panel 1 Label</label>
		<input style="width: 250px" type="text" name="__i3d_curtain_menu__intro-panel-1" id="curtain_menu__intro-panel-1" value="<?php echo $curtainMenuData['intro-panel-1']; ?>" />
	</li>
	<li>
		<label style="font-weight: bold;" for="curtain_menu__intro-panel-2">Panel 2 Label</label>
		<input style="width: 250px" type="text" name="__i3d_curtain_menu__intro-panel-2" id="curtain_menu__intro-panel-2" value="<?php echo $curtainMenuData['intro-panel-2']; ?>" />
	</li>
	<li>
		<label style="font-weight: bold;" for="curtain_menu__intro-panel-3">Panel 3 Label</label>
		<input style="width: 250px" type="text" name="__i3d_curtain_menu__intro-panel-3" id="curtain_menu__intro-panel-3" value="<?php echo $curtainMenuData['intro-panel-3']; ?>" />
	</li>
	<li>
		<label style="font-weight: bold;" for="curtain_menu__intro-panel-4">Panel 4 Label</label>
		<input style="width: 250px" type="text" name="__i3d_curtain_menu__intro-panel-4" id="curtain_menu__intro-panel-4" value="<?php echo $curtainMenuData['intro-panel-4']; ?>" />
	</li>
	<li>
		<label style="font-weight: bold;" for="curtain_menu__intro-panel-5">Panel 5 Label</label>
		<input style="width: 250px" type="text" name="__i3d_curtain_menu__intro-panel-5" id="curtain_menu__intro-panel-5" value="<?php echo $curtainMenuData['intro-panel-5']; ?>" />
	</li>
	<li>
		<label style="font-weight: bold;" for="curtain_menu__intro-panel-6">Panel 6 Label</label>
		<input style="width: 250px" type="text" name="__i3d_curtain_menu__intro-panel-6" id="curtain_menu__intro-panel-6" value="<?php echo $curtainMenuData['intro-panel-6']; ?>" />
	</li>
	<li>
		<label style="font-weight: bold;" for="curtain_menu__intro-panel-7">Panel 7 Label</label>
		<input style="width: 250px" type="text" name="__i3d_curtain_menu__intro-panel-7" id="curtain_menu__intro-panel-7" value="<?php echo $curtainMenuData['intro-panel-7']; ?>" />
	</li>
	<li>
		<label style="font-weight: bold;" for="curtain_menu__intro-panel-8">Panel 8 Label</label>
		<input style="width: 250px" type="text" name="__i3d_curtain_menu__intro-panel-8" id="curtain_menu__intro-panel-8" value="<?php echo $curtainMenuData['intro-panel-8']; ?>" />
	</li>


  </ul>
</div>

</div>
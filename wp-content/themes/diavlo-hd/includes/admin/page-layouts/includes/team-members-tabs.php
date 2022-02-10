<?php 
if (!I3D_Framework::use_global_layout()) { 
?>
<div class='tab-pane fade special-region non-visible team-members' id="tabs-team-members-layout">
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


                    <h5>Your "Team Members Page" Regions</h5>

<?php
//var_dump($pageRegions);
$template = "team-members";
include("_layout.php");
?>
        

<div style='clear: both;'></div>

</div> <!-- end of tab content region -->

<?php } ?>

<div class='tab-pane fade special-region non-visible team-members' id="tabs-team-members-settings">
<div class='span6 well'>
<?php 


  $teamMemberData = get_post_meta($post->ID, "team-member", true);

  ?>
  <h4>Team Member Page Settings</h4>
    <ul class='faq-settings'>
	<li>
		<label style="font-weight: bold;" for="team-member__display_style"><?php _e("Display Style", "i3d-framework"); ?></label>
        <select  name="__i3d_team-member__display_style" id="team-member__display_style" >
		  <option <?php if (@$teamMemberData['display_style'] == "0") { print "selected"; } ?> value="0"><?php _e("Static", "i3d-framework"); ?></option>
		  <option <?php if (@$teamMemberData['display_style'] == "1") { print "selected"; } ?> value="1"><?php _e("Isotope Portfolio", "i3d-framework"); ?></option>
		</select>	</li>
	
  </ul>
</div>
    


</div>
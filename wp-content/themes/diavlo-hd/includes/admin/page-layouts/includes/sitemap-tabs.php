<?php 
if (!I3D_Framework::use_global_layout()) { 
?>
<div class='tab-pane fade special-region non-visible sitemap' id="tabs-sitemap-layout">
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

                    <h5>Your "Sitemap Page" Regions</h5>

<?php
//var_dump($pageRegions);
$template = "sitemap";
include("_layout.php");
?>
        
<div style='clear: both;'></div>

</div> <!-- end of tab content region -->
<?php } ?>
<div class='tab-pane fade special-region non-visible sitemap' id="tabs-sitemap-settings">

<ul class='sitemap-settings'>

 			<li class='inline-block-li'>
                <label class='primary-label' for="sitemap__show_sitemap">Show Sitemap</label>
                <select name="__i3d_sitemap__show_sitemap" id="sitemap__show_sitemap">
                  <option value="0"  <?php if(@$sitemapData['show_sitemap'] == "0") { echo 'selected'; }?>><?php _e("No","i3d-framework"); ?></option>
                  <option value="1"  <?php if(@$sitemapData['show_sitemap'] == "1") { echo 'selected'; }?>><?php _e("Yes","i3d-framework"); ?></option>
                </select>
            </li>
 			<li class='inline-block-li'>
                <label class='primary-label' for="sitemap__show_archives">Show Archives </label>
                <select name="__i3d_sitemap__show_archives" id="sitemap__show_archives">
                  <option value="0"  <?php if(@$sitemapData['show_archives'] == "0") { echo 'selected'; }?>><?php _e("No","i3d-framework"); ?></option>
                  <option value="1"  <?php if(@$sitemapData['show_archives'] == "1") { echo 'selected'; }?>><?php _e("Yes","i3d-framework"); ?></option>
                </select>
            </li>
            
 			<li class='inline-block-li'>
                <label class='primary-label'for="sitemap__show_most_recent_posts">Show Recent Posts </label>
                <select name="__i3d_sitemap__show_most_recent_posts" id="sitemap__show_most_recent_posts">
                  <option value="0"  <?php if(@$sitemapData['show_most_recent_posts'] == "0") { echo 'selected'; }?>><?php _e("No","i3d-framework"); ?></option>
                  <option value="1"  <?php if(@$sitemapData['show_most_recent_posts'] == "1") { echo 'selected'; }?>><?php _e("Yes","i3d-framework"); ?></option>
                </select>
            </li>
            


</ul>
</div>
<?php

?>
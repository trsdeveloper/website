<?php 
if (!I3D_Framework::use_global_layout()) { 
?>
<div class='tab-pane fade special-region non-visible faqs' id="tabs-faqs-layout">
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

                    <h5>Your "FAQs Page" Regions</h5>

<?php
//var_dump($pageRegions);
$template = "faqs";
include("_layout.php");

?>
        
<div style='clear: both;'></div>

</div> <!-- end of tab content region -->
<?php } ?>
<div class='tab-pane fade special-region non-visible faqs' id="tabs-faqs-settings">
<div class='span6 well'>
<?php 


  $faqData = get_post_meta($post->ID, "faq", true);

  ?>
  <h4>FAQ Page Settings</h4>
    <ul class='faq-settings'>
	<li>
		<label style="font-weight: bold;" for="faq__display_faqs_in_page"><?php _e("FAQ Display Style", "i3d-framework"); ?></label>
        <select  name="__i3d_faq__display_faqs_in_page" id="blog__lead_with_full_width_post" >
		  <option <?php if (@$faqData['display_faqs_in_page'] == "0") { print "selected"; } ?> value="0"><?php _e("Link To New Page", "i3d-framework"); ?></option>
		  <option <?php if (@$faqData['display_faqs_in_page'] == "1") { print "selected"; } ?> value="1"><?php _e("Link To Lower In The Page", "i3d-framework"); ?></option>
		  <option <?php if (@$faqData['display_faqs_in_page'] == "2") { print "selected"; } ?> value="2"><?php _e("Accordion Style", "i3d-framework"); ?></option>
		</select>	</li>
	
  </ul>
</div>
    


</div>
<?php 
if (!I3D_Framework::use_global_layout()) { 
?>
<div class='tab-pane fade special-region non-visible photo-slideshow' id="tabs-photo-slideshow-layout">
<?php
global $post, $columnSelectedId,$lmFrameworkVersion;
global $lmUsesCustomComponentRegions;
global $customComponentSidebars;
global $lmUsesConfigurableDropDowns;
global $wp_registered_widgets; 
if (!isset($lmUsesConfigurableDropDowns)) {
	$lmUsesConfigurableDropDowns = false;
}
  $slideShowData = get_post_meta($post->ID, "slideshow", true);
  if (!is_array($slideShowData)) {
	$slideShowData = array();  
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

                    <h5>Your "Photo Slideshow Page" Regions</h5>

<?php
//var_dump($pageRegions);
$template = "photo-slideshow";
include("_layout.php");
?>
        
<div style='clear: both;'></div>

</div> <!-- end of tab content region -->
<?php } ?>
<div class='tab-pane fade special-region non-visible photo-slideshow' id="tabs-photo-slideshow-settings">
<?php
//var_dump($slideShowData); 
?>
<ul class='slideshow-settings'>
	<li class='inline-block-li'>
		<label  class='primary-label' for="slideshow__slide_interval">Slide Interval</label>
        <select  name="__i3d_slideshow__slide_interval" id="slideshow__slide_interval" >
        <?php for ($i = 1; $i <= 10; $i+=1) { ?>
		  <option <?php if (@$slideShowData['slide_interval'] == $i || (@$slideShowData['slide_interval'] == "" && $i == 8)) { print "selected"; } ?> value="<?php echo $i; ?>"><?php echo $i; ?> seconds</option>
        <?php } ?>
		</select>
	</li>	
	<li class='inline-block-li'>
		<label class='primary-label' for="slideshow__autoplay">Auto Play</label>
        <select  name="__i3d_slideshow__autoplay" id="slideshow__autoplay" >
		  <option <?php if (@$slideShowData['autoplay'] == "1") { print "selected"; } ?> value="1">Yes</option>
		  <option <?php if (@$slideShowData['autoplay'] == "0") { print "selected"; } ?> value="0">No</option>
		</select>
	</li>	
	<li class='inline-block-li'>
		<label  class='primary-label'for="slideshow__transition">Transition</label>
        <select  name="__i3d_slideshow__transition" id="slideshow__transition" >
		  <option <?php if (@$slideShowData['transition'] == "0") { print "selected"; } ?> value="0">Normal</option>
		  <option <?php if (@$slideShowData['transition'] == "1") { print "selected"; } ?> value="1">Fade</option>
		  <option <?php if (@$slideShowData['transition'] == "2") { print "selected"; } ?> value="2">Slide Top</option>
		  <option <?php if (@$slideShowData['transition'] == "3") { print "selected"; } ?> value="3">Slide Right</option>
		  <option <?php if (@$slideShowData['transition'] == "4") { print "selected"; } ?> value="4">Slide Bottom</option>
		  <option <?php if (@$slideShowData['transition'] == "5") { print "selected"; } ?> value="5">Slide Left</option>
		  <option <?php if (@$slideShowData['transition'] == "6") { print "selected"; } ?> value="6">Slide Right</option>
		  <option <?php if (@$slideShowData['transition'] == "7") { print "selected"; } ?> value="7">Carousel Left</option>
		</select>
	</li>	
	<li class='inline-block-li'>
		<label class='primary-label' for="slideshow__transition_speed">Transition Speed</label>
        <select  name="__i3d_slideshow__transition_speed" id="slideshow__transition_speed" >
        <?php for ($i = 1; $i <= 3; $i+=1) { ?>
		  <option <?php if (@$slideShowData['transition_speed'] == $i) { print "selected"; } ?> value="<?php echo $i; ?>"><?php echo $i; ?> seconds</option>
        <?php } ?>
		</select>
	</li>	



</ul>
</div>
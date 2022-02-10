<?php
global $post;
global $lmIncludedComponents;

function display_slider_options($currentValue) {
	global $post;
	echo '<option value="">-- Use Site Default --</option>\n';
	?>
    <option <?php if (get_post_meta($post->ID, 'i3d_page_slider', true) == "x") { print "selected"; } ?> value="x">-- Do Not Display Slider --</option>
    <?php
	
	$sliders = get_option('i3d_sliders');
	$i3dAvailableSliders = I3D_Framework::getSliders();
	
	
	
	if(is_array($sliders) && !empty($sliders)){
		foreach($sliders as $sliderID => $slider){
			if($currentValue == $sliderID){
				echo "<option value='$sliderID' selected>{$slider['slider_title']} (".$i3dAvailableSliders[$slider['slider_type']]['title'].")</option>\n";
			}else{
				echo "<option value='$sliderID'>{$slider['slider_title']} (".$i3dAvailableSliders[$slider['slider_type']]['title'].")</option>\n";
			}
		}
	}
}

?>

<?php
/***********************************************
 * CONTACT PANEL 
 ***********************************************/
if (@$generalSettings['contact_panel_enabled'] != "" && I3D_Framework::$contactPanelVersion > 0) { ?>
<div class='row'  style='margin-left: 0px;'>
<div class='well'>
<h4><i class='icon icon-envelope'></i> Contact Panel</h4>
<p>Enable the drop-down contact panel settings on a page-by-page basis.</p>
<ul>
<?php
$i3dContactPanel = get_post_meta($post->ID, "contact_panel", true);
if (!is_array($i3dContactPanel)) {
  $i3dContactPanel = array();
} 
?>
 	<li class='inline-block-li'>
		<label class='primary-label' for="contact_panel__show"><i class='icon-eye'></i> Show Contact Panel</label>
        <select class='input-xlarge' name="__i3d_contact_panel__show" id="contact_panel__show" >
		  <option value="">-- Use Site Default --</option>
		  <option <?php if (@$i3dContactPanel['show'] == "never") { print "selected"; } ?> value="never">No </option>
		  <option <?php if (@$i3dContactPanel['show'] == "always") { print "selected"; } ?> value="always">Yes</option>
        </select>
	</li>

    <?php if (I3D_Framework::$contactPanelVersion == 1) { ?>
 	<li class='inline-block-li'>
		<label class='primary-label'for="i3d_contact_panel__icon"><i class='icon-asterisk'></i> Icon</label>
        <?php I3D_Framework::renderFontAwesomeSelect("__i3d_contact_panel__icon", @$i3dContactPanel['icon'], true); ?>

        
	</li>
 	<li class='inline-block-li'>
		<label class='primary-label' for="i3d_contact_panel__icon_close"><i class='icon-asterisk'></i> Close Icon</label>
        <?php I3D_Framework::renderFontAwesomeSelect("__i3d_contact_panel__icon_close", @$i3dContactPanel['icon_close'], true); ?>

        
	</li>    
    <?php } ?>

</ul>
<div class='clearfix'></div>
</div></div>
<div style='clear: both;'></div>
<?php } ?>

<div class='row'  style='margin-left: 0px;'>
<?php if (I3D_Framework::use_global_layout()) { 
} 
  //$section_I3D_Framework::
?>


<div class='well special-widgets <?php print I3D_Framework::getTemplatesForSpecialWidget("I3D_Widget_Menu") ?> '>
<h4><i class='icon icon-compass'></i> Navigation</h4>
<p>Making sure your visitor can get to the information they need, quickly, is an important part of your website.  Be sure to make sure you configure each
of these elements appropriately to help your visitors use your site more effectively.</p>
<ul>
 	<li class='special-widgets <?php print I3D_Framework::getTemplatesForSpecialWidget("I3D_Widget_Menu") ?> inline-block-li'>
		<label class='primary-label' for="i3d_drop_menu_id"><i class='icon-list'></i> Drop Down Menu</label>
        <select class='form-control' name="__i3d_i3d_drop_menu_id" id="i3d_drop_menu_id" >
		  <option value="default">-- Use Site Default --</option>
		  <option <?php if (get_post_meta($post->ID, 'i3d_drop_menu_id', true) == "x") { print "selected"; } ?> value="x">-- Do Not Use A Menu --</option>
        <?php
		$i3dMenus = get_option('i3d_menu_options');
		foreach ($i3dMenus as $menu_id => $menu_name) { ?>
		  <option <?php if (get_post_meta($post->ID, 'i3d_drop_menu_id', true) == $menu_id) { print "selected"; } ?> value="<?php echo $menu_id; ?>"><?php echo $menu_name; ?></option>
		<?php } ?>
        </select>
	</li>


 	<li class='special-widgets <?php print I3D_Framework::getTemplatesForSpecialWidget("I3D_Widget_ContactFormMenu") ?> inline-block-li'>
		<label class='primary-label' for="i3d_contact_menu_id"><i class='icon-envelope'></i> Drop Down Contact Form</label>
        <select class='form-control' name="__i3d_i3d_contact_menu_id" id="i3d_contact_menu_id" >
		  <option value="*">-- Use Site Default --</option>
		  <option <?php if (get_post_meta($post->ID, 'i3d_contact_menu_id', true) == "x") { print "selected"; } ?> value="x">-- Do Not Display A Contact Form --</option>
        <?php
		 $forms = get_option("i3d_contact_forms");
		//$i3dMenus =  I3D_Framework::getget_option('i3d_menu_options');
		foreach ($forms as $form_id => $formData) { ?>
		  <option <?php if (get_post_meta($post->ID, 'i3d_contact_menu_id', true) == $form_id) { print "selected"; } ?> value="<?php echo $form_id; ?>"><?php echo $formData['form_title']; ?></option>
		<?php } ?>
        </select>
	</li>

 	<li class='special-widgets <?php print I3D_Framework::getTemplatesForSpecialWidget("I3D_Widget_SocialMediaIconShortcuts") ?> inline-block-li'>
		<label class='primary-label' for="i3d_social_media_icons_settings"><i class='icon-twitter'></i> Social Media Icons</label>
        <select class='form-control' name="__i3d_i3d_social_media_icons_settings" id="i3d_social_media_icons_settings" >
		  <option value="default">-- Use Site Default --</option>
		  <option <?php if (get_post_meta($post->ID, 'i3d_social_media_icons_settings', true) == "x") { print "selected"; } ?> value="x">-- Do Not Display Social Media Icons --</option>
        </select>
	</li>


 	<li class='special-widgets <?php print I3D_Framework::getTemplatesForSpecialWidget("I3D_Widget_SearchForm") ?> inline-block-li'>
		<label class='primary-label' for="i3d_search_form"><i class='icon-search'></i> Search Form</label>
        <select class='form-control' name="__i3d_i3d_search_form" id="i3d_search_form" >
		  <option value="">-- Use Site Default --</option>
		  <option <?php if (get_post_meta($post->ID, 'i3d_search_form', true) == "x") { print "selected"; } ?> value="x">-- Do Not Display Search Form --</option>
        </select>
	</li>   
   </ul> 
</div>
</div>
<div class='row' style='margin-left: 0px;'>
<div class='well special-widgets <?php print I3D_Framework::getTemplatesForSpecialWidget("I3D_Widget_Logo") ?> advanced'>
<h4><i class='icon icon-star'></i> Branding</h4>
<p>Your Brand is what identifies you.  Make a lasting impression with a graphic logo or vector icon as well as your Website Title.  A succinct tagline is also
important to identify what it is you do.</p>
<ul>

<?php
$i3dLogoSettings = get_post_meta($post->ID, "i3d_logo_settings", true);
if (!is_array($i3dLogoSettings)) {
  $i3dLogoSettings = array();
} 
		$i3dLogoSettings = wp_parse_args( (array) $i3dLogoSettings, array( 'graphic_logo' => '',
																		  'vector_icon' => '',
																		  'website_name' => '',
																		  'text_1' => '',
																		  'text_2' => '',
																		  'tagline_setting' => '',
																		  'tagline' => '', 
																		  'justification' => '') );

?>
	<li class='special-widgets <?php print I3D_Framework::getTemplatesForSpecialWidget("I3D_Widget_Logo") ?> inline-block-li'>
		<label  class='primary-label' for="i3d_logo_settings_1"><i class='icon-home'></i> Logo/Website Name</label>
  <div class="input-group input-group-indented" >
        <span class="input-group-addon"><i class='fa fa-picture-o fa-fw'></i> Graphic Logo</span>
        <select onchange='useGraphicLogo(this)' class='form-control' name="__i3d_i3d_logo_settings__graphic_logo" id="i3d_logo_settings_1" >
		  <option <?php if ($i3dLogoSettings['graphic_logo'] == "") { print "selected"; } ?> value="">-- Use Site Default --</option>
		  <option <?php if ($i3dLogoSettings['graphic_logo'] == "x") { print "selected"; } ?> value="x">-- Do Not Display Graphic Logo --</option>
        </select>	
   </div>   
  <div class="input-group input-group-indented <?php if (@$i3dLogoSettings['graphic_logo'] != "") { print "non-visible"; } ?>" id='i3d_logo_settings_vector_logo'>
        <span class="input-group-addon"><i class='fa fa-fw fa-sun-o'></i> Vector Icon</span>
        <select class='form-control' name="__i3d_i3d_logo_settings__vector_icon" id="i3d_logo_settings_2" >
		  <option <?php if ($i3dLogoSettings['vector_icon'] == "default") { print "selected"; } ?> value="default">-- Use Site Default --</option>
		  <option <?php if ($i3dLogoSettings['vector_icon'] == "x") { print "selected"; } ?> value="">-- Do Not Display Vector Icon --</option>
        </select>	
   </div>   
  <div class="input-group input-group-indented">
        <span class="input-group-addon"><i class='fa fa-fw fa-font'></i> Website Title</span>
        <select onchange='useTextLogo(this)' class='form-control' name="__i3d_i3d_logo_settings__website_name" id="i3d_logo_settings_3" >
		  <option <?php if ($i3dLogoSettings['website_name'] == "default") { print "selected"; } ?> value="default">-- Use Site Default --</option>
		  <option <?php if ($i3dLogoSettings['website_name'] == "x") { print "selected"; } ?> value="x">-- Do Not Display Website Title --</option>
		  <option <?php if (isset($i3dLogoSettings['website_name']) &&
							$i3dLogoSettings['website_name'] != "" && 
							$i3dLogoSettings['website_name'] != "x" && 
							$i3dLogoSettings['website_name'] != "default") { print "selected"; } ?> value="custom">-- Custom --</option>
        </select>
   </div>
    <div id='i3d_logo_settings_text_logo' <?php if ($i3dLogoSettings['website_name'] != "custom") { print "class='non-visible'"; } ?>>
      <div class='input-group input-group-indented-2' >
         <span class="input-group-addon"> In First Color</span><input name="__i3d_i3d_logo_settings__text_1" value="<?php echo $i3dLogoSettings['text_1']; ?>" type='text' class='form-control'  placeholder='Website' />
      </div>
      <div class='input-group input-group-indented-2'>
		<span class="input-group-addon">In Second Color</span><input  name="__i3d_i3d_logo_settings__text_2" value="<?php echo $i3dLogoSettings['text_2']; ?>" type='text' class='form-control' placeholder='Name' />	
      </div>
    </div>
       <div class="input-group input-group-indented">
        <span class="input-group-addon"><i class='fa fa-fw fa-bullhorn'></i> Tagline</span>

		<select onChange="useTagline(this)" class='form-control'  name="__i3d_i3d_logo_settings__tagline_setting" id="i3d_logo_settings_4" >
          <option <?php if ($i3dLogoSettings['tagline_setting'] == "default")  { print "selected"; } ?> value="default">-- Use Site Default --</option>
          <option <?php if ($i3dLogoSettings['tagline_setting'] == "x") { print "selected"; } ?> value="x">-- Do Not Display Tagline --</option>
     	  <option <?php if ($i3dLogoSettings['tagline_setting'] == "custom")   { print "selected"; } ?> value="custom">-- Custom --</option>
        </select>
      </div>
		<div id='i3d_logo_settings_tagline' <?php if ($i3dLogoSettings['tagline_setting'] != "custom") { print "class='non-visible'"; } ?>>  
          <div class='input-group input-group-indented-2' >
                      
 		                <span class="input-group-addon"> Custom</span>

        <input name="__i3d_i3d_logo_settings__tagline" value="<?php echo $i3dLogoSettings['tagline']; ?>"  type="text" class="form-control" /> 
           </div>
         </div>
       <div class="input-group input-group-indented">
               <span class="input-group-addon"><i class='fa fa-fw fa-align-left'></i> Justification</span>
      

 		<select name="__i3d_i3d_logo_settings__justification" class='form-control' id="i3d_logo_settings_5" >
          <option <?php if ($i3dLogoSettings['justification'] == "left") { print "selected"; } ?> value="left"><?php _e('Left',"i3d-framework"); ?></option>
          <option <?php if ($i3dLogoSettings['justification'] == "center") { print "selected"; } ?> value="center"><?php _e('Center',"i3d-framework"); ?></option>
     	  <option <?php if ($i3dLogoSettings['justification'] == "right") { print "selected"; } ?> value="right"><?php _e('Right',"i3d-framework"); ?></option>
        </select> 
        </div> 
 
                          
</li>
 	<li class='special-widgets <?php print I3D_Framework::getTemplatesForSpecialWidget("I3D_Widget_SliderRegion") ?> advanced inline-block-li'>
		<label class='primary-label' for="i3d_page_slider"><i class='icon-ellipsis-horizontal'></i> Slider </label>
		<select class='form-control' name="__i3d_i3d_page_slider" id="i3d_page_slider"><?php display_slider_options(get_post_meta($post->ID, "i3d_page_slider", true)); ?></select>	
    </li>
</ul>

 	<?php if (count(I3D_Framework::$themeStyleOptions) > 0) { 
			$theme_counter 	= 0;
			
			$themeStyles = get_post_meta($post->ID, "i3d_theme_styles", true);
if (!is_array($themeStyles)) {
  $themeStyles = array();
} 
//$themeStyles = array();

		//	$themeStyles 	= @($generalSettings['theme_styles']);	  
		?>
          						<ul class='input-items'>
 		    						<li class='timed-theme' id='timed_theme__<?php echo $theme_counter; ?>'>
									
									<label class='primary-label' for="i3d_page_slider"><i class='icon-ellipsis-horizontal'></i> Primary Skin </label>
            						
										<?php 
			  							if (!isset($themeStyles["{$theme_counter}"]["style"])) {
			 	 							$themeStyles["{$theme_counter}"]["style"] = "";
			  							}
										
										echo i3d_render_select("__i3d_i3d_theme_styles__{$theme_counter}__style", "-- Default --", I3D_Framework::$themeStyleOptions, $themeStyles["{$theme_counter}"]["style"], "select2:array:name", "handleThemeStyleChange(this)", 'class="form-control" style="max-width: 150px; display: inline-block;"'); ?><?php
										
										foreach (I3D_Framework::$themeStyleOptions as $style => $styleInfo) { 
			  								if (!isset($themeStyles["{$theme_counter}"]["{$style}_color"])) {
			 	 								$themeStyles["{$theme_counter}"]["{$style}_color"] = "";
			  								}
											
			    							echo "<span class='theme-selection'";
				  							if ($style == $themeStyles["{$theme_counter}"]["style"]) {
				  							} else {
					  							echo "style='display: none;'";
				  							}
											echo ">";
											
											echo i3d_render_select("__i3d_i3d_theme_styles__{$theme_counter}__{$style}_color", "", $styleInfo['colors'], $themeStyles["{$theme_counter}"]["{$style}_color"], "select2", "handleThemeStyleColorChange(this)",  'class="form-control" style="max-width: 100px; display: inline-block;"'); 
			    							echo "</span>";
											
										} ?>
										
										<div class='theme-layers' id='theme-layers-<?php echo $theme_counter; ?>'>
										  
										  <?php 
										  foreach (I3D_Framework::$themeStyleOptions as $style => $styleInfo) { 
										    $availableLayers = array();
										   // var_dump($styleInfo);
											$allLayers = $styleInfo['layers'];
											
											if (!is_array($allLayers)) {
												$allLayers = array();
											}
											//var_dump($allLayers);
											foreach ($allLayers as $type => $layers) { ?>
											<div class='theme-layer-block theme-layers-<?php echo $style; ?>-<?php echo $type; ?>'>
												<ul>
											  	<?php foreach ($layers as $index => $layerData) {
													    
														if ($layerData) {
															$layerName = $layerData['name'];
															$layerAvailableStates = array_reverse($layerData['states'], true);
															if (!is_array($layerAvailableStates)) {
																//var_dump($layerAvailableStates);
															}
															$layerDefaultState = $layerData['default_state'];
															?>
											    	<li>
														<label style='line-height: 40px; margin-right: 10px;' ><?php echo $layerName; ?></label>
														<div class='pull-right' style='line-height: 35px;'>
															<div data-toggle="buttons" class="btn-group">
															    <?php 
																//var_dump($themeStyles["{$theme_counter}"]["$style"]["layers"]["$type"]);
																
																foreach ($layerAvailableStates as $state => $stateDescription) { 
																//print "a";
																      	$isSelectedState = false;
																		$buttonState = "btn-default";
																		//var_dump( $themeStyles["{$theme_counter}"]["$style"]);
																		//print $themeStyles["{$theme_counter}"]["$style"]["layers"]["$type"]["$index"];
																		if (@$themeStyles["{$theme_counter}"]["$style"]["layers"]["$type"]["$index"] == "" && $state == $layerDefaultState) {
																			$isSelectedState = true;
																		} else if (@$themeStyles["{$theme_counter}"]["$style"]["layers"]["$type"]["$index"] != "" && @$themeStyles["{$theme_counter}"]["$style"]["layers"]["$type"]["$index"] == $state) {
																		    $isSelectedState = true;
																		}
																//print "b";
																		
																		if ($state == "0" && $isSelectedState) {
																			$buttonState = "btn-default btn-disabled active";
																		} else if ($state == "0") {
																			$buttonState = "btn-default btn-disabled";
																		} else if ($isSelectedState) {
																			$buttonState = "btn-success btn-enabled active";
																		} else {
																		    $buttonState = "btn-enabled btn-default";	
																		}
																		//print "c";
																		?>
																<label class="btn btn-sm <?php echo $buttonState; ?>"><input type="radio" <?php if ($isSelectedState) { print "checked=''"; } ?> id="__i3d_i3d_theme_styles__<?php echo $theme_counter; ?>__<?php echo $style; ?>__layers__<?php echo $type; ?>__<?php echo $index; ?>-<?php echo $state; ?>" name="__i3d_i3d_theme_styles__<?php echo $theme_counter; ?>__<?php echo $style; ?>__layers__<?php echo $type; ?>__<?php echo $index; ?>" value="<?php echo $state; ?>"><?php echo $stateDescription ?></label>
																<?php } // end of foreach ?>
															</div>	
														</div>									
													</li>
											  	<?php } 
													} // end of foreach layers ?>
											    </ul>
											</div>
											<?php } ?>
										
										<?php } ?>
										</div>
										
										<a id='layer-selector-<?php echo $theme_counter; ?>' data-title="Available Layers" data-toggle="popover" data-placement="left" class='btn btn-xs btn-default pull-right layer-selector' style='margin-top: 3px;'><i class='fa fa-edit'></i> Layers</a>

              							<input type="hidden" name="timed_themes[]" value="<?php echo $theme_counter; ?>" />

									</li> 
																											
																											
          
          						</ul>
								
									<?php } ?>

</div>	
</div>
<?php 
if (I3D_Framework::$callToActionVersion > 0) { 
 ?>
<div class='row' style='margin-left: 0px;'>

<?php
/***********************************************
 * CALLS TO ACTION/ADVERTISING 
 ***********************************************/
 ?>
<div class='well special-widgets calls-to-action'>
<h4><i class='icon icon-bullhorn'></i> Advertising</h4>
<p>You can get your customers attention by adding animated "Calls To Action" to your page.  If you have a "Call To Action" widget on your page,
you can either use the default CTA associated with the widget, or specify a page-specific CTA.</p>
<?php 
$i3dCallToAction = get_post_meta($post->ID, "i3d_call_to_action", true);
if (!is_array($i3dCallToAction)) {
  $i3dCallToAction = array();
} 
//var_dump($i3dCallToAction);
		$i3dCallToAction = wp_parse_args( (array) $i3dCallToAction, array( 'id_1' => '',
																		  'id_2' => '',
																		  'id_3' => '',
																		  'id_4' => '') );



?>
<ul>
 	<li class='call-to-action_1 inline-block-li'>
		<label class='primary-label'  for="i3d_call_to_action_1"><i class='icon-bullhorn'></i> Call To Action</label>
        <select class='form-control' name="__i3d_i3d_call_to_action__id_1" id="i3d_call_to_action_1" >
		  <option value="">-- Use Widget Default --</option>
		  <option <?php if ($i3dCallToAction['id_1'] == "x") { print "selected"; } ?> value="x">-- Do Not Display A Call To Action --</option>
        <?php
		 $ctas = get_option("i3d_calls_to_action");
		foreach ($ctas as $ctaID => $cta) { ?>
		  <option <?php if ($i3dCallToAction['id_1'] == $ctaID) { print "selected"; } ?> value="<?php echo $ctaID; ?>"><?php echo $cta['title']; ?></option>
		<?php } ?>
        </select>
	</li>

 	<li class='call-to-action_2 non-visible inline-block-li'>
		<label class='primary-label' for="i3d_call_to_action_2"><i class='icon-bullhorn'></i> 2nd Call To Action</label>
        <select class='form-control' name="__i3d_i3d_call_to_action__id_2" id="i3d_call_to_action_2" >
		  <option value="">-- Use Widget Default --</option>
		  <option <?php if ($i3dCallToAction['id_2'] == "x") { print "selected"; } ?> value="x">-- Do Not Display A Call To Action --</option>
        <?php
		foreach ($ctas as $ctaID => $cta) { ?>
		  <option <?php if ($i3dCallToAction['id_2'] == $ctaID) { print "selected"; } ?> value="<?php echo $ctaID; ?>"><?php echo $cta['title']; ?></option>
		<?php } ?>
        </select>
	</li>
    
 	<li class='call-to-action_3 non-visible inline-block-li'>
		<label class='primary-label'  for="i3d_call_to_action_3"><i class='icon-bullhorn'></i> 3rd Call To Action</label>
        <select class='form-control' name="__i3d_i3d_call_to_action__id_3" id="i3d_call_to_action_3" >
		  <option value="">-- Use Widget Default --</option>
		  <option <?php if ($i3dCallToAction['id_3'] == "x") { print "selected"; } ?> value="x">-- Do Not Display A Call To Action --</option>
        <?php
		foreach ($ctas as $ctaID => $cta) { ?>
		  <option <?php if ($i3dCallToAction['id_3'] == $ctaID) { print "selected"; } ?> value="<?php echo $ctaID; ?>"><?php echo $cta['title']; ?></option>
		<?php } ?>
        </select>
	</li>

 	<li class='call-to-action_4 non-visible inline-block-li'>
		<label class='primary-label' for="i3d_call_to_action_4"><i class='icon-bullhorn'></i> 4th Call To Action</label>
        <select class='form-control' name="__i3d_i3d_call_to_action__id_4" id="i3d_call_to_action_4" >
		  <option value="">-- Use Widget Default --</option>
		  <option <?php if ($i3dCallToAction['id_4'] == "x") { print "selected"; } ?> value="x">-- Do Not Display A Call To Action --</option>
        <?php
		foreach ($ctas as $ctaID => $cta) { ?>
		  <option <?php if ($i3dCallToAction['id_4'] == $ctaID) { print "selected"; } ?> value="<?php echo $ctaID; ?>"><?php echo $cta['title']; ?></option>
		<?php } ?>
        </select>
	</li>


</ul>
</div>

</div>
<?php } ?>

<?php 
if (I3D_Framework::$focalBoxVersion > 0) { 
 ?>
<div class='row' style='margin-left: 0px;'>

<?php
/***********************************************
 * FOCAL BOXES/ADVERTISING 
 ***********************************************/
 ?>
<div class='well special-widgets focal-boxes'>
<h4><i class='icon icon-bullhorn'></i> Advertising</h4>
<p>You can get your customers attention by adding animated "Focal Boxes" to your page.  If you have a "Focal Box" widget on your page,
you can either use the default FB associated with the widget, or specify a page-specific FB.</p>
<?php 
$i3dFocalBox = get_post_meta($post->ID, "i3d_focal_box", true);
if (!is_array($i3dFocalBox)) {
  $i3dFocalBox = array();
} 
//var_dump($i3dCallToAction);
		$i3dFocalBox = wp_parse_args( (array) $i3dFocalBox, array( 'id_1' => '',
																		  'id_2' => '',
																		  'id_3' => '',
																		  'id_4' => '') );



?>
<ul>
 	<li class='focal-box_1 inline-block-li'>
		<label class='primary-label'  for="i3d_focal_box_1"><i class='icon-bullhorn'></i> Focal Box</label>
        <select class='form-control' name="__i3d_i3d_focal_box__id_1" id="i3d_focal_box_1" >
		  <option value="">-- Use Widget Default --</option>
		  <option <?php if ($i3dFocalBox['id_1'] == "x") { print "selected"; } ?> value="x">-- Do Not Display A Focal Box --</option>
        <?php
		 $fbs = get_option("i3d_focal_boxes");
		foreach ($fbs as $fbID => $fb) { ?>
		  <option <?php if ($i3dFocalBox['id_1'] == $fbID) { print "selected"; } ?> value="<?php echo $fbID; ?>"><?php echo $fb['title']; ?></option>
		<?php } ?>
        </select>
	</li>

 	<li class='focal-box_2 non-visible inline-block-li'>
		<label class='primary-label' for="i3d_focal_box_2"><i class='icon-bullhorn'></i> 2nd Focal Box</label>
        <select class='form-control' name="__i3d_i3d_focal_box__id_2" id="i3d_focal_box_2" >
		  <option value="">-- Use Widget Default --</option>
		  <option <?php if (@$i3dFocalBox['id_2'] == "x") { print "selected"; } ?> value="x">-- Do Not Display A Focal Box --</option>
        <?php
		foreach ($fbs as $fbID => $fb) { ?>
		  <option <?php if (@$i3dFocalBox['id_2'] == $fbID) { print "selected"; } ?> value="<?php echo $fbID; ?>"><?php echo $fb['title']; ?></option>
		<?php } ?>
        </select>
	</li>
    
 	<li class='focal-box_3 non-visible inline-block-li'>
		<label class='primary-label'  for="i3d_focal_box_3"><i class='icon-bullhorn'></i> 3rd Focal Box</label>
        <select class='form-control' name="__i3d_focal_box__id_3" id="i3d_focal_box_3" >
		  <option value="">-- Use Widget Default --</option>
		  <option <?php if (@$i3dFocalBox['id_3'] == "x") { print "selected"; } ?> value="x">-- Do Not Display A Focal Box --</option>
        <?php
		foreach ($fbs as $fbID => $fb) { ?>
		  <option <?php if (@$i3dFocalBox['id_3'] == $fbID) { print "selected"; } ?> value="<?php echo $fbID; ?>"><?php echo $fb['title']; ?></option>
		<?php } ?>
        </select>
	</li>

 	<li class='focal-box_4 non-visible inline-block-li'>
		<label class='primary-label' for="i3d_focal_box_4"><i class='icon-bullhorn'></i> 4th Focal Box</label>
        <select class='form-control' name="__i3d_i3d_focal_box__id_4" id="i3d_focal_box_4" >
		  <option value="">-- Use Widget Default --</option>
		  <option <?php if ($i3dFocalBox['id_4'] == "x") { print "selected"; } ?> value="x">-- Do Not Display A Focal Box --</option>
        <?php
		foreach ($fbs as $fbID => $fb) { ?>
		  <option <?php if ($i3dFocalBox['id_4'] == $fbID) { print "selected"; } ?> value="<?php echo $fbID; ?>"><?php echo $fb['title']; ?></option>
		<?php } ?>
        </select>
	</li>


</ul>
</div>

</div>
<?php } ?>
<?php
/***********************************************
 * SOUNDCLOUD 
 ***********************************************/
if (@$generalSettings['soundcloud_player_enabled'] != "") { ?>
<div class='row'  style='margin-left: 0px;'>
<div class='well'>
<h4><i class='icon icon-music'></i> Audio</h4>
<p>Enrich your page with the SoundCloud MP3 player.  SoundCloud is a free service that allows you to add audio streams to your site.</p>
<ul>
<?php
$i3dSoundCloudPlayer = get_post_meta($post->ID, "soundcloud_player", true);
if (!is_array($i3dSoundCloudPlayer)) {
  $i3dSoundCloudPlayer = array();
} 
		$i3dSoundCloudPlayer = wp_parse_args( (array) $i3dSoundCloudPlayer, array( 'show' => '',
																		  'playlist' => '',
																		  'website_name' => '',
																		  'autoplay' => '') );

?>
 	<li class='inline-block-li'>
		<label class="primary-label" for="soundcloud_player__show"><i class='icon-eye'></i> Show MP3 Player</label>
        <select class='form-control' name="__i3d_soundcloud_player__show" id="soundcloud_player__show" >
		  <option value="">-- Use Site Default --</option>
		  <option <?php if ($i3dSoundCloudPlayer['show'] == "never") { print "selected"; } ?> value="never">No </option>
		  <option <?php if ($i3dSoundCloudPlayer['show'] == "always") { print "selected"; } ?> value="always">Yes</option>
        </select>
	</li>

 	<li class='inline-block-li'>
		<label class="primary-label" for="i3d_soundcloud_player__playlist"><i class='icon-music'></i> Playlist <i class='icon-info-sign tt' title="If specified, this will override the default site setting"></i></label>
        <textarea class='form-control' name="__i3d_soundcloud_player__playlist" id="i3d_soundcloud_player__playlist" ><?php echo $i3dSoundCloudPlayer['playlist']; ?></textarea>
	</li>

 	<li class='inline-block-li'>
		<label class="primary-label" for="i3d_soundcloud_player__autoplay"><i class='icon-play'></i> AutoPlay</label>
        <select class='form-control' name="__i3d_soundcloud_player__autoplay" id="soundcloud_player__autoplay" >
		  <option value="">-- Use Site Default (<?php echo (@$generalSettings['soundcloud_player_autoplay'] == "1" ? "Enabled" : "Disabled"); ?>) --</option>
		  <option <?php if ($i3dSoundCloudPlayer['autoplay'] == "0") { print "selected"; } ?> value="0">No</option>
		  <option <?php if ($i3dSoundCloudPlayer['autoplay'] == "1") { print "selected"; } ?> value="1">Yes</option>
        </select>
	</li>
    


</ul>
</div></div>
<?php } ?>



<?php
/***********************************************
 * PAGE STYLES 
 ***********************************************/
if (sizeof(I3D_Framework::$optionalPageStyledEdges) > 0 ||
	sizeof(I3D_Framework::$optionalPageInnerBackground) > 0 ||
	sizeof(I3D_Framework::$optionalPageOuterBackground) > 0) {
  $theme = wp_get_theme();
?>
   
<div class='row' style='margin-left: 0px;'>
<div class='well'>
<h4><i class='icon icon-tint'></i> Page Styling</h4>
<p>The <?php echo $theme->Name; ?> theme allows you additional control to style different types of page styles.  These styles are set on a global level via the Framework control panel General tab, however, you may also set them differently on a page-by-page basis.</p>
<ul>
<?php

$pageStyle = get_post_meta($post->ID, 'page_styles', true);
//var_dump($pageStyle);
if (!is_array($pageStyle)) {
  $pageStyle = array();
} 
$pageStyle = wp_parse_args( (array) $pageStyle, array( 'edge' => '',
																  'inner' => '',
																  'outer' => '') );

?>
<?php if (sizeof(I3D_Framework::$optionalPageStyledEdges) > 0) { ?>
 	<li class='inline-block-li'>
		<label class="primary-label" for="page_styles__edge"><i class='icon-eye'></i> Edge Style</label>
        <select class='form-control' name="__i3d_page_styles__edge" id="page_styles__edge" >
		  <option value="default">-- Use Site Default --</option>
        <?php
		foreach (I3D_Framework::$optionalPageStyledEdges as $className => $description) { ?>
		  <option <?php if ($className == $pageStyle['edge']) { print "selected"; } ?> value="<?php echo $className; ?>"><?php echo $description; ?></option>
		<?php } ?>
        </select>
	</li>
<?php } ?>
<?php if (sizeof(I3D_Framework::$optionalPageInnerBackground) > 0) { ?>
 	<li class='inline-block-li'>
		<label class="primary-label" for="page_styles__inner"><i class='icon-eye'></i> Inner Box Style</label>
        <select class='form-control' name="__i3d_page_styles__inner" id="page_styles__inner" >
		  <option value="default">-- Use Site Default --</option>
        <?php
		foreach (I3D_Framework::$optionalPageInnerBackground as $className => $description) { ?>
		  <option <?php if ($className == $pageStyle['inner']) { print "selected"; } ?> value="<?php echo $className; ?>"><?php echo $description; ?></option>
		<?php } ?>
        </select>
	</li>
<?php } ?>
<?php if (sizeof(I3D_Framework::$optionalPageOuterBackground) > 0) { ?>
 	<li class='inline-block-li'>
		<label  class="primary-label"for="page_styles__outer"><i class='icon-eye'></i> Outer Box Style</label>
        <select class='form-control' name="__i3d_page_styles__outer" id="page_styles__outer" >
		  <option value="default">-- Use Site Default --</option>
        <?php
		foreach (I3D_Framework::$optionalPageOuterBackground as $className => $description) { ?>
		  <option <?php if ($className == $pageStyle['outer']) { print "selected"; } ?> value="<?php echo $className; ?>"><?php echo $description; ?></option>
		<?php } ?>
        </select>
	</li>
<?php } ?>    


</ul>
</div></div>
<?php } ?>


 <script>
	function useGraphicLogo(selectBox) {
	  if (selectBox.selectedIndex == 0) {
		  jQuery("#i3d_logo_settings_vector_logo").addClass("non-visible");
	  } else {
		  jQuery("#i3d_logo_settings_vector_logo").removeClass("non-visible");		  
	  }
	}
	
	function useTextLogo(selectBox) {
	  if (selectBox.selectedIndex == 2) {
		  jQuery("#i3d_logo_settings_text_logo").removeClass("non-visible");
	  } else {
		  jQuery("#i3d_logo_settings_text_logo").addClass("non-visible");		  
	  }
	}	
	function useTagline(selectBox) {
	  if (selectBox.selectedIndex == 2) {
		  jQuery("#i3d_logo_settings_tagline").removeClass("non-visible");
	  } else {
		  jQuery("#i3d_logo_settings_tagline").addClass("non-visible");		  
	  }
	}	

</script>



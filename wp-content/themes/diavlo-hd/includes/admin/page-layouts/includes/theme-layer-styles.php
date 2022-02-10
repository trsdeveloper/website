
<div class='row' style='margin-left: 0px;'>
<div class='well'>

 	<?php 
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
								
								
									
</div>	
</div>									
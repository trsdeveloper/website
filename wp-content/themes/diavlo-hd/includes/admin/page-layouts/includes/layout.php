<?php
global $post, $columnSelectedId,$lmFrameworkVersion;
global $lmUsesCustomComponentRegions;
global $customComponentSidebars;
global $lmUsesConfigurableDropDowns;

if (!isset($lmUsesConfigurableDropDowns)) {
	$lmUsesConfigurableDropDowns = false;
}
?>
<style>
  .row-height {height: 37px; }
  .row-height-2 {height: 48px; }
  .row-height-3 {height: 56px; }
  .row-height-center {height: 88px; }
  
  .header-region {
	  border: 1px solid #aaaaaa;
	  background-color: #dddddd;
      text-align: right;
  }
    .content-region {
	  border: 1px solid #aaaaaa;
	  background-color: #dddddd;
      text-align: center;
	  height: 56px;
	  font-weight: bold;
	margin-top: 2px;
	margin-bottom: 2px;
  }
  div.content-region {
    padding-top: 25px;

  }
  .regular-region {
	  border: 1px solid #aaaaaa;
	  text-align: center;
  }
  div.regular-region {
    padding-top: 15px;
  }
  .sub-region th{
	  font-size: 8pt;
  }
  .side-column {
	  width: 150px;
  }
  .sidebar-regions label, .custom-sidebar-regions label {
	  font-weight: bold;
	  font-size: 8pt;
  }
  .section-label {
	  font-weight: bold;
	  padding-right: 10px;
	  text-align: right;
  }
</style>
<p>The layout you've chosen has the following optional sidebar regions available.  Assign the desired sidebar to each region, as you require.</p>
<table class='sidebar-regions'>
<tr>
  <td valign="top">
	<table class='optional-sidebars'>
<?php global $i3dSupportedSidebars; ?>
<?php foreach ($i3dSupportedSidebars as $sidebarID => $sidebar) { ?>   
		<tr class='configurable <?php echo $sidebar['show_page_sidebar_configuration']; ?>'>
			<td class='row-height section-label'>
			<?php echo $sidebar['name']; ?> Region &#8594;
			</td>
			<td class='regular-region'>		
			<select name="__i3d_<?php echo $sidebarID; ?>"><?php display_sidebar_options(get_post_meta($post->ID, $sidebarID, true)); ?></select>
			</td>
		</tr>		
<?php } ?>

<?php if ($lmUsesCustomComponentRegions) {
	foreach ($customComponentSidebars as $sidebarID => $sidebarName) { ?>
		<tr>
			<td class='row-height section-label'>
			<?php echo $sidebarName; ?> &#8594;
			</td>
			<td class='header-region' style='text-align: left'>		
			<select name="__i3d_<?php echo $sidebarID; ?>"><?php display_sidebar_options(get_post_meta($post->ID, $sidebarID, true)); ?></select>
            
            <label style="margin-left: 30px;font-weight: bold;">Positioning (in px): &nbsp; &nbsp; Top</label>
			<input type="text" style='width: 40px; margin-right: 30px;'  name="__i3d_<?php echo $sidebarID; ?>_top" value="<?php echo get_post_meta($post->ID, $sidebarID."_top", true); ?>" />
            <select name="__i3d_<?php echo $sidebarID; ?>_hpositioning">
              <option  value='left'>Left</option>
              <option <?php if (get_post_meta($post->ID, $sidebarID."_hpositioning", true) == "right") { print "selected"; } ?> value='right'>Right</option>
             </select>
             
			<input type="text" style='width: 40px;' name="__i3d_<?php echo $sidebarID; ?>_hposition" value="<?php echo get_post_meta($post->ID, $sidebarID."_hposition", true); ?>" />

			</td>
		</tr>
    <?php } ?>	
<?php } ?>	

	</table>
</td>
<!--
<td style="vertical-align: top; padding-right: 10px;"><img src="<?php echo get_template_directory_uri() ;?>/includes/user_view/columns/<?php echo ($columnSelectedId); ?>/description.jpg" id="lm_sidebar_description" alt="sidebar locations" title="sidebar locations" /></td>
-->
</tr>
</table>
<style>
tr.non-editable {
	display: none;
}
</style>

<?php

function display_sidebar_options($currentValue) {
	echo "<option value=''>[NONE SELECTED]&nbsp;</option>\n";
	
	$sidebars = get_option('i3d_sidebar_options');
	
	if(is_array($sidebars) && !empty($sidebars)){
		foreach($sidebars as $sidebarID => $sidebarName){
			if($currentValue == $sidebarID){
				echo "<option value='$sidebarID' selected>$sidebarName</option>\n";
			}else{
				echo "<option value='$sidebarID'>$sidebarName</option>\n";
			}
		}
	}
}

function display_menu_options($currentValue) {
	
	$menusOptions = get_option('luckymarble_menu_options');
	
	if(is_array($menusOptions) && !empty($menusOptions)){
		foreach($menusOptions as $menuID => $menuName){
			if($currentValue == $menuID){
				echo "<option value='$menuID' selected>$menuName</option>\n";
			}else{
				echo "<option value='$menuID'>$menuName</option>\n";
			}
		}
	}
}
?>
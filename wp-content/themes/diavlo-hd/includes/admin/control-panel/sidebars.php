<?php
function i3d_admin_sidebar() {
?>
	<style>.widefat td {vertical-align: middle;}</style>
	
	<div class="wrap">
		<h2>Edit Sidebars</h2>
		<?php
			$widgetsPage = "widgets.php";
	
		if(@$_POST['cmd'] == "save") {
			$lmSidebars = array();
			$lmSidebarsStyles = array();
//var_dump($_POST['sidebars']);
//var_dump($_POST);
			//loop thru POST data
			foreach($_POST['sidebars'] as $id) {			
				//only add to update list if remove checkbox NOT checked
				$corrected_id = str_replace(".", "_", $id);
				if(!@$_POST['rm_sidebar__'.$id] && !@$_POST['rm_sidebar__'.$corrected_id] ) {
					//add to sidebar array for saving
					$lmSidebars[$id] = $_POST['sidebar__'.$id];
					$lmSidebarsStyles[$id] = @$_POST['sidebar_style__'.$id];
				}
			}

			//update sidebar list
			update_option('i3d_sidebar_options',$lmSidebars);
			update_option('i3d_sidebar_options_styles',$lmSidebarsStyles);
			echo '<div id="message" class="updated fade below-h2"><p><strong>Changes saved.  To manage your sidebar widgets please <a href="'.$widgetsPage.'">click here</a>.</strong></p></div>';
		
		} else {
			echo '<p style="font-style: italic;">To manage the widgets shown on your sidebars please <a href="'.$widgetsPage.'">click here</a>.</p>';
		}
		?>		
		
		<h3>Available Sidebars</h3>
		<form method="post">
			<table class="widefat" style="width: auto;" cellspacing="0">
				<thead>
				<tr><th class="manage-column">Name</th><!--<th class="manage-column">Widget Wrapping</th>--><th class="manage-column">&nbsp;</th></th>
				</thead>

				<tbody>
				<?php
				$lmSidebars = get_option('i3d_sidebar_options');
				$lmSidebarsStyles = get_option('i3d_sidebar_options_styles');
				$defaultStyles = array();
				$defaultStyles['luckymarble-top-widget-area']    = "infoBoxContent";
				$defaultStyles['luckymarble-left-widget-area']   = "sideBoxContent";
				$defaultStyles['luckymarble-right-widget-area']  = "sideBoxContent";
				$defaultStyles['luckymarble-lower-widget-area']  = "infoBoxContent";

				foreach($lmSidebars as $id => $sidebar){
					if (is_array($sidebar)) {
						$sidebar_name = $sidebar['name'];
					} else {
						$sidebar_name = $sidebar;
					}
					echo '<tr>';
					echo '<td>';
					$corrected_id = str_replace(".", "_", $id);
					echo '<input type="text" name="sidebar__'.$id.'" value="'.$sidebar_name.'" style="width: 300px;" /><input type="hidden" name="sidebars[]" value="'.$corrected_id.'" />';
					echo '</td>';
					//echo '<td>';
					//echo '<select style="width: 100%" name="sidebar_style__'.$id.'">';
					//echo '<option value=""> -- none -- </option>';
					//echo '<option '.(($defaultStyles["$id"] == "infoBoxContent" && $lmSidebarsStyles["$id"] == "") || $lmSidebarsStyles["$id"] == "infoBoxContent" ? "selected" : "").' value="infoBoxContent">Info Box</option>';
					//echo '<option '.(($defaultStyles["$id"] == "sideBoxContent" && $lmSidebarsStyles["$id"] == "") || $lmSidebarsStyles["$id"] == "sideBoxContent" ? "selected" : "").' value="sideBoxContent">Side Box</option>';
					//echo '</select>';
					//echo '</td>';
					echo '<td>';
					//echo '<input type="hidden" name="rm_sidebar__'.$corrected_id.'" value="'.$id.'" />';
					echo '<input class="button" type="submit" name="rm_sidebar__'.$corrected_id.'" value="Delete" />';
					echo '</td>';
					echo '</tr>';
				}
				?>
				</tbody>
			</table>		
			<input type="hidden" name="cmd" value="save" />
			<input name="nocmd" class="button button-primary" value="Save Changes" type="submit" style="margin-top: 8px;" />
		</form>
	</div>
	<?php
}

function i3d_admin_add_sidebar() {	
			$widgetsPage = "widgets.php";

	?>
	<div class="wrap">
		<h2>Add New Sidebar</h2>
		<?php
		if(@$_POST['cmd'] == "add") {
			//get current list of sidebars
			$lmSidebars = get_option('i3d_sidebar_options');
			//var_dump($lmSidebars);
            $sideBarName = "i3d-widget-area-".str_replace(".", "", str_replace("-", "_", str_replace('"', "", str_replace("'", "", str_replace(" ", "_", strtolower($_POST['sidebar_name']))))));
			
			
			if (@$lmSidebars["$sideBarName"] != "") {
				$sideBarName .= mktime();
			}
			
			//add new sidebar to the end of the list
			$lmSidebars["$sideBarName"] = @$_POST['sidebar_name'];

			//update sidebar list
			update_option('i3d_sidebar_options', $lmSidebars);

			echo '<div id="message" class="updated fade below-h2"><p><strong>Sidebar "'.$_POST['sidebar_name'].'" has been created.  To manage your sidebar widgets please <a href="'.$widgetsPage.'">click here</a>.</strong></p></div>';
		}		
		?>
		<form method="post">
			<label for="new_sidebar">Sidebar Name:</label> <input type="text" name="sidebar_name" id="new_sidebar" value="" />
			<input type="hidden" name="cmd" value="add" />
			<input name="nocmd" class="button button-primary" value="Add" type="submit" style="margin-top: 8px;" />
		</form>
	</div>
	<?php
}
?>
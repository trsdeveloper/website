<?php
add_shortcode('i3d_cpg', 	'i3d_cpg');

function i3d_cpg($atts) {
	global $page;
	global $i3dBootstrapVersion;
	
	extract($atts);	
	
	ob_start();
	
	$cpgs 	= get_option("i3d_content_panel_groups");
	$cpg 	= @$cpgs["$id"];
    $panels = @$cpg['panels'];
	
	if (@$cpg['title'] != "" && @$cpg['title_wrap'] != "x") {
		if ($cpg['title_wrap'] == "") {
			$cpg['title_wrap'] = "h3";
		}
	  	print "<{$cpg['title_wrap']} class='title'>{$cpg['title']}</{$cpg['title_wrap']}>";	
	}
	if (@$cpg['description'] != "") {
		print "<p class='description'>".nl2br($cpg['description'])."</p>";
	}

	if (is_array($panels)) {
	  	if ($cpg['content_type'] == "tabs") {
			?><ul class="nav nav-tabs"><?php
			
			foreach ($panels as $i => $panel) {
				print "<li class='".($i == 0 ? "active" : "")."'><a data-toggle='tab' href='#cpg_{$id}_{$i}'>";
				if ($panel['icon'] != "") {
					print "<i class='fa {$panel['icon']}'></i> ";
				}
				print $panel['label'];	
		    	print "</a></li>";
			}

			?></ul><?php
		  	?><div class="tab-content"><?php
			
			foreach ($panels as $i => $panel) {
				print "<div class='tab-pane fade".($i == 0 ? " in active" : "")."' id='cpg_{$id}_{$i}'>";
				echo nl2br(do_shortcode($panel['content'])); 
		    	print "</div>";
			}

		?></div><?php		
		
	  	} else if ($cpg['content_type'] == "pills") {
			?><ul class="nav nav-pills"><?php
			
			foreach ($panels as $i => $panel) {
				print "<li class='".($i == 0 ? "active" : "")."'><a data-toggle='tab' href='#cpg_{$id}_{$i}'>";
				if ($panel['icon'] != "") {
					print "<i class='fa {$panel['icon']}'></i> ";
				}
				print $panel['label'];	
		    	print "</a></li>";
			}

			?></ul><?php
			?><div class="tab-content"><?php
		
			foreach ($panels as $i => $panel) {
				print "<div class='tab-pane fade".($i == 0 ? " in active" : "")."' id='cpg_{$id}_{$i}'>";
				echo nl2br(do_shortcode($panel['content'])); 
				print "</div>";
			}

			?></div><?php			  
		
		} else if ($cpg['content_type'] == "accordion") {
			wp_enqueue_style( 'accordion-panels-css',     get_stylesheet_directory_uri()."/Library/components/accordion-panels/css/accordion-panels.css");
			?>
            <div class="accordion-panels-wrapper">
    			<div class="accordion-panels">
					<div class="panel-group" id="accordion">
			<?php
			foreach ($panels as $i => $panel) {
			?>
						<div class="panel panel-default">
    						<div class="panel-heading">
      							<h4 class="panel-title">
        							<a data-toggle="collapse" data-parent="#accordion" href="#<?php echo "cpg_{$id}_{$i}"; ?>">
         	<?php
		 		if ($panel['icon'] != "") {
					print "<i class='fa {$panel['icon']}'></i> ";
				}
				print $panel['label'];	
			?>
        							</a>
      							</h4>
    						</div>
    						<div id="<?php echo "cpg_{$id}_{$i}"; ?>" class="panel-collapse collapse<?php if ($i == 0) { echo " in"; } ?>">
      							<div class="panel-body">
        							<?php echo nl2br(do_shortcode($panel['content'])) ; ?>
      							</div>
    						</div>
  						</div>	
  			<?php
			}
			?></div></div></div><?php
      	}
	}

	return ob_get_clean();
}
?>
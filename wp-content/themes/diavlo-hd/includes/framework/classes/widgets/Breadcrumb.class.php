<?php

/***********************************/
/**        CONTENT REGION         **/
/***********************************/
class I3D_Widget_Breadcrumb extends WP_Widget {
	
	//function I3D_Widget_Breadcrumb() {
	function __construct() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Renders a breadcrumb trail set of links', "i3d-framework") );
		parent::__construct('i3d_breadcrumb', __('i3d:Breadcrumb', "i3d-framework"), $widget_ops);
	}

	function widget( $args, $instance ) {		
		extract( $args );
			  $instance =  wp_parse_args( (array) $instance, array( 'box_style' => 'no-box-style', 'box_margin_top' => '', 'box_margin_bottom' => ''  ) );
		if ($instance['box_style'] == "") {
			$instance['box_style'] = "no-box-style";
		}
		if ($instance['box_margin_top'] != "") {
			$instance['box_margin_top'] = " margin-top-".$instance['box_margin_top'];
		}
		if ($instance['box_margin_bottom'] != "") {
			$instance['box_margin_bottom'] = " margin-bottom-".$instance['box_margin_bottom'];
		}
		
		$before_widget = str_replace("i3d-opt-box-style", @$instance['box_style'].@$instance['box_margin_top'].@$instance['box_margin_bottom'], $before_widget);
		
		echo $before_widget;
		
		global $page_id;
		global $postCat;
		global $current_layout;
		print $current_layout;
		$post_cat = get_queried_object();
		$tree = array();
		
		if (@$post_cat->name != "") {
			//the_post();
			//$tree = array(@$post->ID);
			//rewind_posts();
			$page_title = $post_cat->labels->name;			
			
		} else 	if (have_posts() && is_single()) {
			
			//print "is single";
			the_post();
			$tree = array(@$post->ID);
			rewind_posts();
			$page_title = get_the_title();
	
		}	else {
//print $page_id;
								$pageInfo = get_page($page_id);
							$page_title = $pageInfo->post_title;			
		}
		

		$limbCount = 0;
		if (I3D_Framework::$breadcrumbVersion == "2") { ?>
			<span class="breadcrumb-title">
                                <a href="<?php echo get_permalink($page_id); ?>"><?php 
								print $page_title;
								//$pageInfo = get_page($page_id);
							//	echo $pageInfo->post_title;
								//the_title();
								?></a>
                            </span>
							<span class="breadcrumb-path">
		<?php } else { ?>
		
		<ul class='breadcrumb'>
		<?php
		}

		$tree = array_merge($tree, $this->getParentOfPage(intval($page_id), $post_cat));
		
		$tree = array_reverse($tree);
		
		foreach ($tree as $pageID) {
			$limbCount++;
			
			if (I3D_Framework::$breadcrumbVersion != 2) {
			print "<li";
			if ($limbCount == sizeof($tree)) {
				print " class='active'";
			}
			print ">";
			}

			//print $limbCount;
			$pageInfo = get_page($pageID);
			//print $postCat->taxonomy;
			if ($limbCount < sizeof($tree)) {
				
					print "<a href='".get_permalink($pageID)."'>";
			
			}
			
			//if ($pageID == 0 && $post_cat->name != "") {
			//	print $post_cat->label->name;
			//} else {
				print $pageInfo->post_title;
			//}
			if ($limbCount < sizeof($tree)) {
				print "</a>";
			}			
			if ($limbCount < sizeof($tree) && I3D_Framework::$bootstrapVersion < 3) {
				print " <span class='divider'><i class='icon-angle-right'></i></span>";
			}
			if ($limbCount < sizeof($tree) && I3D_Framework::$breadcrumbVersion == 2) {
				print " &gt;&gt; ";
			}
			if (I3D_Framework::$breadcrumbVersion != 2) {
			  print "</li>";
			}

		}
			if (I3D_Framework::$breadcrumbVersion == "2") { ?>
			</span>
			<?php } else { ?>
			</ul>
			<?php } 
		//$pages = get_pages(array('sort_order' => );
		

		echo $after_widget;
	}
	
	function getParentOfPage($page_id, $post_cat = "") {
		$page = get_post($page_id);
		
		
		$parentId = $page->post_parent;

		if ($parentId == 0) {
			//if ($post_cat->name != "") {
			 // print "yup";	
		//	  return
			//} else {
			////	print "nope";
			//}
		//	var_dump($post_cat);
			return array($page_id);
		} else {
			return array_merge(array($page_id), $this->getParentOfPage($parentId, $post_cat));
		}
		//$args = array('parent' => intval($page_id), 'hierarchial' => 0);
		//var_dump($args);
		//$args = array();
	  //$pages = get_pages($args);
	  //var_dump($pages);
	  
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance =  wp_parse_args( (array) $new_instance, array('box_style' => '', 'box_margin' => ''));
		
		$instance['box_style'] 		= $new_instance['box_style'];
		$instance['box_margin'] 	= $new_instance['box_margin'];

		return $instance;
	}



	function layout_configuration_form( $instance, $defaults, $row_id, $widget_id, $layout_id, $page_level = false ) {
	  $instance =  wp_parse_args( (array) $instance, array( 'box_style' => '', 'box_margin_top' => '', 'box_margin_bottom' => ''  ) );
	  global $post;
	  
	//  var_dump($instance);
	  
	  $layouts = get_option('i3d_layouts');
	        	  $layoutName = $layouts["{$layout_id}"]["title"];

	  if ($page_level) {
		  $prefix = "__i3d_layouts__{$layout_id}__";
			$page_layouts 		= (array)get_post_meta($post->ID, "layouts", array());
			if (!array_key_exists($layout_id, $page_layouts)) {
				$page_layouts["$layout_id"] = array();
			}
			if (!array_key_exists($row_id, $page_layouts["$layout_id"] )) {
				$page_layouts["$layout_id"]["$row_id"] = array();
			} 
			if (!array_key_exists("configuration", $page_layouts["$layout_id"]["$row_id"] )) {
				$page_layouts["$layout_id"]["$row_id"]["configuration"] = array();
			} 
			if (!array_key_exists($widget_id, $page_layouts["$layout_id"]["$row_id"]["configuration"] )) {
				$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"] = array();
			} 
			
			$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"] =  wp_parse_args( (array) $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"], array( 'sidebar' => '', 'box_style' => '*'   ) );
			$box_style = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["box_style"];
			
			// if box_style == "*" then it whatever the layout default is
			if ($box_style == "*") {
			  $instance['box_style'] = "*";
			  
			  // if the box style is blank, then it means there is no box_style
			} else if ($box_style == "") {
				$instance['box_style'] = "";
			
			} else if ($box_style != "") {
			    $instance['box_style'] = $box_style;	
			}

			$box_margin_top = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["box_margin_top"];
			
			// if box_margin_top == "*" then it whatever the layout default is
			if ($box_margin_top == "*") {
			  $instance['box_margin_top'] = "*";
			  
			  // if the box margin is blank, then it means there is no box_margin_top
			} else if ($box_margin_top == "") {
				$instance['box_margin_top'] = "";
			
			} else if ($box_margin_top != "") {
			    $instance['box_margin_top'] = $box_margin_top;	
			}
			
			$box_margin_bottom = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["box_margin_bottom"];
			
			// if box_margin_bottom == "*" then it whatever the layout default is
			if ($box_margin_bottom == "*") {
			  $instance['box_margin_bottom'] = "*";
			  
			  // if the box margin is blank, then it means there is no box_margin_bottom
			} else if ($box_margin_bottom == "") {
				$instance['box_margin_bottom'] = "";
			
			} else if ($box_margin_bottom != "") {
			    $instance['box_margin_bottom'] = $box_margin_bottom;	
			}

			$layoutID = $layout_id;
	  } else {
		//  global $layoutID;
		  
		  $prefix = "";
		  
	  }
	//  print "layoutID: $layoutID";
      	//  $layoutName = $layouts["{$layout_id}"]["title"];

	  ?>
			<?php if (sizeof(I3D_Framework::$boxStyles) > 0) { ?>
				<div class="input-group  tt2"  title='Choose Breadcrumb Box Style'>
  		<span class="input-group-addon detailed-addon"><i class="fa fa-paint-brush fa-fw"></i> <span class='detailed-label'>Box Style</span></span>

			<select class='form-control' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__box_style">
        		<?php if ($page_level) { ?><option <?php if ($instance['box_style'] == "*") { print "selected"; } ?> value="*"><?php echo "{$layoutName}"; ?> <?php _e("Layout Default", "i3d-framework"); ?></option> <?php } ?>
				
				<?php foreach (I3D_Framework::$boxStyles as $className => $boxStyle) { ?>
				<option <?php if (@$instance['box_style'] == $className) { print "selected"; } ?> value="<?php echo $className; ?>"><?php echo $boxStyle; ?></option>
        		<?php } ?>
			</select> 
			</div>
			<?php }  ?>
				<div class="input-group  tt2"  title='Choose Breadcrumb Box Top Margin'>
  		<span class="input-group-addon detailed-addon"><i class="fa fa-long-arrow-up fa-fw"></i> <span class='detailed-label'>Top Margin</span></span>

			<select class='form-control' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__box_margin_top">
        		<?php if ($page_level) { ?><option <?php if ($instance['box_margin_top'] == "*") { print "selected"; } ?> value="*"><?php echo "{$layoutName}"; ?> <?php _e("Layout Default", "i3d-framework"); ?></option> <?php 
				} else { ?>
				<option <?php if ($instance['box_margin_top'] == "") { print "selected"; } ?> value=""><?php _e("Default", "i3d-framework"); ?></option> 
				<?php } ?>
				
				<?php for ($margin = -40; $margin <= 60; $margin += 10) {  ?>
				<option <?php if (@$instance['box_margin_top'] === (string)$margin ) { print "selected"; } ?> value="<?php echo $margin; ?>"><?php echo $margin; ?>px</option>
        		<?php } ?>
			</select> 
			</div>
				<div class="input-group  tt2"  title='Choose Breadcrumb Box Bottom Margin'>
  		<span class="input-group-addon detailed-addon"><i class="fa fa-long-arrow-down fa-fw"></i> <span class='detailed-label'>Bottom Margin</span></span>

			<select class='form-control' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__box_margin_bottom">
        		<?php if ($page_level) { ?><option <?php if ($instance['box_margin_bottom'] == "*") { print "selected"; } ?> value="*"><?php echo "{$layoutName}"; ?> <?php _e("Layout Default", "i3d-framework"); ?></option> <?php 
				} else { ?>
				<option <?php if ($instance['box_margin_bottom'] == "") { print "selected"; } ?> value=""><?php _e("Default", "i3d-framework"); ?></option> 
				<?php } ?>
				<?php for ($margin = -40; $margin <= 60; $margin += 10) {  ?>
				
				<option <?php if (@$instance['box_margin_bottom'] === (string)$margin ) { print "selected"; } ?> value="<?php echo $margin; ?>"><?php echo $margin; ?>px</option>
				
        		<?php } ?>
			</select> 
			</div>

	  <?php
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'box_style' => '', 'box_margin_top' => '', 'box_margin_bottom' => '' ) );
?>
<script>
jQuery("a.widget-action").bind("click", function() {
				//shrinkVideoRegion(this);									

});
 
jQuery("a.widget-control-close").bind("click", function() {
				//shrinkVideoRegion(this);									

});
</script><div class='i3d-widget-container'>
    <div class='i3d-help-region'>
    <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://www.youtube.com/watch?v=kOeBvTKIMQA&feature=share&list=PLi4TPsYTqDJa7fOufE81XA2SKTYtjsYnn&index=10"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>
    </div>
	<div class='i3d-widget-main-large'>
	<p>The Breadcrumb widget displays a list of links that represent a path back to the highest point in the heirarchy of pages.  You must set your pages
	as child pages, on the Page settings panel (right hand side, just under the Update button) of another page in order to take advantage of this feature.
	</p>
	
<div class='widget-section'>
	<?php if (sizeof(I3D_Framework::$boxStyles) > 0) { ?>
	<div class='widget-column-33'>
	<label class='label-regular' for="<?php echo $this->get_field_id('box_style'); ?>"><?php _e('Box Style', "i3d-framework"); ?></label>
	<select style='width: 100%' id="<?php echo $this->get_field_id('box_style'); ?>" name="<?php echo $this->get_field_name('box_style'); ?>">
	
	<?php foreach (I3D_Framework::$boxStyles as $className => $boxStyle) { ?>
	  <option <?php if (@$instance['box_style'] == $className) { print "selected"; } ?> value="<?php echo $className; ?>"><?php echo $boxStyle; ?></option>
	<?php } ?>
			</select> 
			</div>
	<?php }  ?>

	<div class='widget-column-33'>
	<label class='label-regular' for="<?php echo $this->get_field_id('box_margin_top'); ?>"><?php _e('Box Top Margin', "i3d-framework"); ?></label>
	<select style='width: 100%' id="<?php echo $this->get_field_id('box_margin_top'); ?>" name="<?php echo $this->get_field_name('box_margin_top'); ?>">
	
				<option <?php if ($instance['box_margin_top'] == "") { print "selected"; } ?> value=""><?php _e("Default", "i3d-framework"); ?></option> 
			
							<?php for ($margin = -40; $margin <= 60; $margin += 10) {  ?>
				<option <?php if (@$instance['box_margin_top'] === (string)$margin ) { print "selected"; } ?> value="<?php echo $margin; ?>"><?php echo $margin; ?>px</option>
        		<?php } ?>

			</select> 
			</div>
	<div class='widget-column-33'>
	<label class='label-regular' for="<?php echo $this->get_field_id('box_margin_bottom'); ?>"><?php _e('Box Bottom Margin', "i3d-framework"); ?></label>
	<select style='width: 100%' id="<?php echo $this->get_field_id('box_margin_bottom'); ?>" name="<?php echo $this->get_field_name('box_margin_bottom'); ?>">

				<option <?php if ($instance['box_margin_bottom'] == "") { print "selected"; } ?> value=""><?php _e("Default", "i3d-framework"); ?></option> 
	
				
				<?php for ($margin = -40; $margin <= 60; $margin += 10) {  ?>
				<option <?php if (@$instance['box_margin_bottom'] === (string)$margin ) { print "selected"; } ?> value="<?php echo $margin; ?>"><?php echo $margin; ?>px</option>
        		<?php } ?>

			</select> 
			</div>


</div>	
	</div>
    </div>
<?php

	}
}


?>
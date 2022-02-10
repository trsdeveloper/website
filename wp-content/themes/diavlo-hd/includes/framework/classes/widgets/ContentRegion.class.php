<?php

/***********************************/
/**        CONTENT REGION         **/
/***********************************/
class I3D_Widget_ContentRegion extends WP_Widget {
	function __construct() {
	//function I3D_Widget_ContentRegion() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Renders the page content as defined in the TinyMCE editor, or your blog posts.', "i3d-framework") );
		parent::__construct('i3d_contentregion', __('i3d:Content Region', "i3d-framework"), $widget_ops);
	}

	function widget( $args, $instance ) {		
		extract( $args );
		$instance = wp_parse_args( (array) $instance, array( 'box_style' => '','page' => '', 'box_margin_top' => '' , 'box_margin_bottom' => ''  ) );
		//var_dump($instance);
		if ($instance['box_margin_top'] != "") {
			$instance['box_margin_top'] = " margin-top-".$instance['box_margin_top'];
		}
		if ($instance['box_margin_bottom'] != "") {
			$instance['box_margin_bottom'] = " margin-bottom-".$instance['box_margin_bottom'];
		}
		
		$before_widget = str_replace("i3d-opt-box-style", @$instance['box_style'].@$instance['box_margin_top'].@$instance['box_margin_bottom'], $before_widget);

		echo $before_widget;
		
		i3d_post_content($instance['page']);
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}
	function layout_configuration_form( $instance, $defaults, $row_id, $widget_id, $layout_id, $page_level = false ) {
	  global $post;
	  $defaults =  wp_parse_args( (array) $defaults, array( 'page' => '' ) );
	  $instance =  wp_parse_args( (array) $instance, array( 'page' => '', 'box_style' => '', 'box_margin_top' => '', 'box_margin_bottom' => ''  ) );

	  $layouts = get_option('i3d_layouts');
	  if ($page_level) {
		  $prefix = "__i3d_layouts__{$layout_id}__";
			$page_layouts 		= (array)get_post_meta($post->ID, "layouts", true);
			
			
			if (!array_key_exists($layout_id, $page_layouts)) {
				$page_layouts["{$layout_id}"] = array();
			}
			if (!array_key_exists($row_id, $page_layouts["{$layout_id}"])) {
				$page_layouts["{$layout_id}"]["{$row_id}"] = array();
			}
			if (!array_key_exists("configuration", $page_layouts["{$layout_id}"]["{$row_id}"])) {
				$page_layouts["{$layout_id}"]["{$row_id}"]["configuration"] = array();
			}
			if (!array_key_exists($widget_id, $page_layouts["{$layout_id}"]["{$row_id}"]["configuration"])) {
				$page_layouts["{$layout_id}"]["{$row_id}"]["configuration"]["$widget_id"] = array();
			}
				$page_layouts["{$layout_id}"]["{$row_id}"]["configuration"]["{$widget_id}"] =  wp_parse_args( (array) $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"], array( 'sidebar' => '', 'box_style' => '*'   ) );
	        	
				$page = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["page"];
			
			// if box_style == "*" then it whatever the layout default is
			if ($page == "*") {
			  $instance['page'] = "*";
			  
			  // if the box style is blank, then it means there is no box_style
			} else if ($page == "") {
				$instance['page'] = "";
			
			} else if ($page != "") {
			    $instance['page'] = $page;	
			}
			
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
	  } else {
		//  global $layoutID;
		  
		  $prefix = "";
		  
	  }		
	?>
	
		<div class="input-group tt2" title="Choose Page Content" >
  		<span class="input-group-addon detailed-addon"><i class="fa fa-link fa-fw"></i> <span class='detailed-label'>Page Content</span></span>

	  <select class='form-control  page-select' rel="<?php echo @$defaults['page']; ?>" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__page">
		<option value=""><?php _e("-- The Page Being Viewed --", "i3d-framework"); ?></option>
	    <?php 
		// if there is no prefix, then this is the layout manager level
		if ($prefix == "") { 
			$selected_page = $instance['page'];
		?>

		<?php 
		// else, if there is a prefix, then this is the page level configurations
		} else {

			$selected_page = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["page"];
			//print "<option>$layout_id</option>";
			//print "<option>$selected_sidebar</option>";
			//print "<option>$widget_id</option>";
			?>

		<?php } ?>
<?php
$pages = get_pages();
		$selectedImages = array();
foreach ($pages as $pagg) {
  	$option = '<option ';
		if ($pagg->ID == $instance['page']) { 
		  $option .= 'selected ';
		}
		$option .= 'value="'.$pagg->ID.'">';
	$option .= $pagg->post_title;
	$option .= '</option>';
	echo $option;
}
    ?>

                </select> 
				</div>
				
			<?php if (sizeof(I3D_Framework::$boxStyles) > 0) { ?>
				<div class="input-group  tt2"  title='Choose Sidebar Box Style'>
  		<span class="input-group-addon detailed-addon"><i class="fa fa-paint-brush fa-fw"></i> <span class='detailed-label'>Box Style</span></span>

        	<!--<label class='label-100' for="<?php echo $this->get_field_id('box_style'); ?>"><?php _e('Box Style:', "i3d-framework"); ?></label>-->
			<select class='form-control' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__box_style">
        		<?php if ($page_level) { ?><option <?php if ($instance['box_style'] == "*") { print "selected"; } ?> value="*"><?php _e("Layout Default", "i3d-framework"); ?></option> <?php } ?>
				
				<?php foreach (I3D_Framework::$boxStyles as $className => $boxStyle) { ?>
				<option <?php if (@$instance['box_style'] == $className) { print "selected"; } ?> value="<?php echo $className; ?>"><?php echo $boxStyle; ?></option>
        		<?php } ?>
			</select> 
			</div>
			<?php }   else { ?>
			<?php // echo sizeof(I3D_Framework::$boxStyles); ?>
			<?php } ?>
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
						  <p class='small'>The content for this region is edited by going  the <b>Page</b> that is associated with this layout and choose the <b>Content</b> tab.</p>

	<?php
	}
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'box_margin_top' => '', 'box_margin_bottom' => '', 'box_style' => '' ) );
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
    <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://www.youtube.com/watch?v=kOeBvTKIMQA"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>
 <!--   <div class='i3d-help-region-opened i3d-help-region-hidden'>
    <div class='i3d-help-title-bar'>Hide <i class='icon-chevron-right'></i></div>
<iframe width="420" height="315" src="//www.youtube.com/embed/62RXnLGcOC8" frameborder="0" allowfullscreen></iframe>
    </div>-->
    </div>
    </div>
<div class='i3d-widget-main-large'>
        <?php if (sizeof(I3D_Framework::$boxStyles) > 0) { ?>
        <br/>
        <label class='label-100' for="<?php echo $this->get_field_id('box_style'); ?>"><?php _e('Box Style:', "i3d-framework"); ?></label>
		<select id="<?php echo $this->get_field_id('box_style'); ?>" name="<?php echo $this->get_field_name('box_style'); ?>">
        <?php foreach (I3D_Framework::$boxStyles as $className => $boxStyle) { ?>
          <option <?php if (@$instance['box_style'] == $className) { print "selected"; } ?> value="<?php echo $className; ?>"><?php echo $boxStyle; ?></option>
        <?php } ?>
                </select> 
                <?php } 
		?>
		
	<div class='widget-column-33'>
	<label class='label-regular' for="<?php echo $this->get_field_id('box_margin_top'); ?>"><?php _e('Box Top Margin', "i3d-framework"); ?></label>
	<select style='width: 100%' id="<?php echo $this->get_field_id('box_margin_top'); ?>" name="<?php echo $this->get_field_name('box_margin_top'); ?>">

				<option <?php if ($instance['box_margin_top'] === "") { print "selected"; } ?> value=""><?php _e("Default", "i3d-framework"); ?></option> 
				
				<?php for ($margin = -40; $margin <= 60; $margin += 10) {  ?>
				<option <?php if (@$instance['box_margin_top'] == (string)$margin ) { print "selected"; } ?> value="<?php echo $margin; ?>"><?php echo $margin; ?>px</option>
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
		
          <br/>
		  <p>The "Page" setting, below, can be very powerful.  You change this setting if you would like to pull content from another page to render within a portion of your page.
		  </p>
		  <p><b>Important:</b>  You should not modify this
		  setting from <code style='white-space: nowrap'>"-- Current Page --"</code> if you plan for this region to be the primary content region within any page template that dynamically pulls content from posts, such as the 
		  "Blog", "FAQs", "Team Members" or "Portfolio" style layouts.
		  </p>
		  <p><b>TL;DR:</b> Use this with setting with caution!</p>
        <label class='label-100' for="<?php echo $this->get_field_id('page'); ?>"><?php _e('Page:', "i3d-framework"); ?></label>
		
        <select id="<?php echo $this->get_field_id('page'); ?>" name="<?php echo $this->get_field_name('page'); ?>"> 
        <option value=""><?php _e("-- Current Page --", "i3d-framework"); ?></option>
<?php
$pages = get_pages();
		$selectedImages = array();
foreach ($pages as $pagg) {
  	$option = '<option ';
		if ($pagg->ID == $instance['page']) { 
		  $option .= 'selected ';
		}
		$option .= 'value="'.$pagg->ID.'">';
	$option .= $pagg->post_title;
	$option .= '</option>';
	echo $option;
}
    ?>
                </select> 
      
        
        
</div>
<?php
	}
}


?>
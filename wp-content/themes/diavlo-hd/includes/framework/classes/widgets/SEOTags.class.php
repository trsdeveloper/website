<?php

/***********************************/
/**        HTML WIDGET BOX        **/
/***********************************/
class I3D_Widget_SEOTags extends WP_Widget {
	function __construct() {
	//function I3D_Widget_SEOTags() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Renders the H1, H2, H3, and H4 tags for your page.', "i3d-framework") );
		parent::__construct('i3d_seo', __('i3d:Page Header Title', "i3d-framework"), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		global $page_id;
			$instance = wp_parse_args( (array) $instance, array( 'box_style' => '','justification' => ''  ) );
			$page_layouts 		= (array)get_post_meta($page_id, "layouts", true);
			
			//var_dump($instance);
			//print "\n".__LINE__."\n<br>";
			$layout_id 	= get_post_meta($page_id, "selected_layout", true);
			//print "\n".__LINE__."\n<br>";
			$row_id = @$instance['row_id'];
			//print "\n".__LINE__."\n<br>";
			$widget_id = @$instance['widget_id'];	
			$justification 	= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["justification"];
			$box_style 	= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["box_style"];
		//	print "\n".__LINE__."\n<br>";
			if ($justification != "default" && $justification != "") {
		//	print "\n".__LINE__."\n<br>";
			  $instance['justification'] = $justification;	
			}
			if ($box_style != "default" && $box_style != "") {
		//	print "\n".__LINE__."\n<br>";
			  $instance['box_style'] = $box_style;	
			}
		//	print "\n".__LINE__."\n<br>";


		$before_widget = str_replace("i3d-opt-box-style", $instance['box_style'].($instance['justification'] != "" ? " text-".$instance['justification'] : ""), $before_widget);
		echo $before_widget;
		
		$h1Text = i3d_get_header_tag_content("h1");
		$h2Text = i3d_get_header_tag_content("h2");
		$h3Text = i3d_get_header_tag_content("h3");
		$h4Text = i3d_get_header_tag_content("h4");
		
		if ($h1Text != "") {
			echo "<h1 id='seo_1'>{$h1Text}</h1>";
		}
		if ($h2Text != "") {
			echo "<h2 id='seo_2'>{$h2Text}</h2>";
			
		}
		if ($h3Text != "") {
			echo "<h3 id='seo_3'>{$h3Text}</h3>";
			
		}
		
		if ($h4Text != "") {
			echo "<h4 id='seo_4'>{$h4Text}</h4>";
			
		}
		
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $new_instance;
		return $instance;
	}
	function layout_configuration_form( $instance, $defaults, $row_id, $widget_id, $layout_id, $page_level = false ) {
	  $layouts = get_option('i3d_layouts');
	  	  $instance =  wp_parse_args( (array) $instance, array( 'justification' => "", 'box_style' => "") );

	  if ($page_level) {
		  	  global $post;

		  $prefix = "__i3d_layouts__{$layout_id}__";
			$page_layouts 		= (array)get_post_meta($post->ID, "layouts", true);


			if (!@array_key_exists($layout_id, $page_layouts)) {
				$page_layouts["{$layout_id}"] = array();
			}
			if (!@array_key_exists($row_id, $page_layouts["{$layout_id}"])) {
				$page_layouts["{$layout_id}"]["{$row_id}"] = array();
			}
			if (!@array_key_exists("configuration", $page_layouts["{$layout_id}"]["{$row_id}"])) {
				$page_layouts["{$layout_id}"]["{$row_id}"]["configuration"] = array();
			}
			if (!@array_key_exists($widget_id, $page_layouts["{$layout_id}"]["{$row_id}"]["configuration"])) {
				$page_layouts["{$layout_id}"]["{$row_id}"]["configuration"]["$widget_id"] = array();
			}
			
			$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"] =  wp_parse_args( (array) $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"], array( 'justification' => '', 'box_style' => '*'   ) );
//var_dump($page_layouts["$layout_id"]["$row_id"]);
	        $box_style 		= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["box_style"];
	        $justification 	= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["justification"];

			// if box_style == "*" then it whatever the layout default is
			if ($justification == "*") {
			  $instance['justification'] = "*";
			  // if the box style is blank, then it means there is no box_style
			} else if ($justification == "") {
				$instance['justification'] = "";
			
			} else if ($justification != "") {
			    $instance['justification'] = $justification;	
			}


			// if box_style == "*" then it whatever the layout default is
			if ($box_style == "*") {
			  $instance['box_style'] = "*";
			  // if the box style is blank, then it means there is no box_style
			} else if ($box_style == "") {
				$instance['box_style'] = "";
			
			} else if ($box_style != "") {
			    $instance['box_style'] = $box_style;	
			}

	       // $justification	 = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["justification"];

			$layoutID = $layout_id;
	  } else {
		//  global $layoutID;
		  
		  $prefix = "";
		  	$justification = strip_tags($instance['justification']);
			if ($justification == "") {
				$justification = @$defaults['justification'];
			}
			//var_dump($defaults);
	  }
	 // var_dump($instance);
	

	  ?>

<!--	  <input type='hidden'  name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__placeholder-field" value="">-->
	<div class="input-group">
  		<span class="input-group-addon detailed-addon"><i class="fa fa-align-left fa-fw"></i> <span class='detailed-label'>Alignment</span></span>
	  <select class='form-control tt2' title="Justification" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__justification">
 <?php if ($prefix != "") { ?>
          <option <?php if ($justification == "default") { print "selected"; } ?> value="default"><?php _e('Default',"i3d-framework"); ?></option>
 
 <?php } else { ?>
           <option <?php if ($justification == "") { print "selected"; } ?> value=""><?php _e('Default',"i3d-framework"); ?></option>
 <?php } ?>
          <option <?php if ($justification == "left") { print "selected"; } ?> value="left"><?php _e('Left',"i3d-framework"); ?></option>
          <option <?php if ($justification == "center") { print "selected"; } ?> value="center"><?php _e('Center',"i3d-framework"); ?></option>
     	  <option <?php if ($justification == "right") { print "selected"; } ?> value="right"><?php _e('Right',"i3d-framework"); ?></option>
	  </select>
	</div>	
<?php if (sizeof(I3D_Framework::$boxStyles) > 0) { ?>
				<div class="input-group  tt2"  title='Choose Sidebar Box Style'>
  		<span class="input-group-addon detailed-addon"><i class="fa fa-paint-brush fa-fw"></i> <span class='detailed-label'>Box Style</span></span>

        	<!--<label class='label-100' for="<?php echo $this->get_field_id('box_style'); ?>"><?php _e('Box Style:',"i3d-framework"); ?></label>-->
			<select class='form-control' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__box_style">
        		<?php if ($prefix != "") { ?>
				<option <?php if ($instance['box_style'] == "*") { print "selected"; } ?> value="*"><?php _e("-- Layout Default --","i3d-framework"); ?></option>
				<?php } ?>
				<?php foreach (I3D_Framework::$boxStyles as $className => $boxStyle) { ?>
				<option <?php if (@$instance['box_style'] == $className) { print "selected"; } ?> value="<?php echo $className; ?>"><?php echo $boxStyle; ?></option>
        		<?php } ?>
			</select> 
			</div>
			<?php }  ?>
						  <p class='small'>To modify the <b>Page Header Title</b>, go to a <b>Page</b> associated with this layout and select <b>Page Header Title</b> tab.</p>

	<?php
	}
	function form( $instance ) {
		$justification = strip_tags(@$instance['justification']);
		
		?>
        <script>
jQuery("a.widget-action").bind("click", function() {
				//shrinkVideoRegion(this);									

});
 
jQuery("a.widget-control-close").bind("click", function() {
			//	shrinkVideoRegion(this);									

});
</script><div class='i3d-widget-container'>
    <div class='i3d-help-region'>
    <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://www.youtube.com/watch?v=l_SX5F1WSno"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>

    </div> 
    <div class='i3d-widget-main-large'>

        <?php if (sizeof(I3D_Framework::$boxStyles) > 0) { ?>
        <p>
        <label class='label-100' for="<?php echo $this->get_field_id('box_style'); ?>"><?php _e('Box Style:',"i3d-framework"); ?></label>
		<select id="<?php echo $this->get_field_id('box_style'); ?>" name="<?php echo $this->get_field_name('box_style'); ?>">
        <?php foreach (I3D_Framework::$boxStyles as $className => $boxStyle) { ?>
          <option <?php if (@$instance['box_style'] == $className) { print "selected"; } ?> value="<?php echo $className; ?>"><?php echo $boxStyle; ?></option>
        <?php } ?>
                </select> 
				</p>
                <?php } ?>
                        <p>
        
        <!-- justification -->
        <label  class='label-100' for="<?php echo $this->get_field_id('justification'); ?>"><?php _e('Justification:',"i3d-framework"); ?></label>
		<select id="<?php echo $this->get_field_id('justification'); ?>" name="<?php echo $this->get_field_name('justification'); ?>">
          <option <?php if ($justification == "left") { print "selected"; } ?> value="left"><?php _e('Left',"i3d-framework"); ?></option>
          <option <?php if ($justification == "center") { print "selected"; } ?> value="center"><?php _e('Center',"i3d-framework"); ?></option>
     	  <option <?php if ($justification == "right") { print "selected"; } ?> value="right"><?php _e('Right',"i3d-framework"); ?></option>
        </select> 
        </p>
</div>
</div>
                
                <?php
		
	}
}


?>
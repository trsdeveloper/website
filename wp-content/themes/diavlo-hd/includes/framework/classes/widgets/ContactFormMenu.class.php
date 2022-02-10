<?php

/***********************************/
/**        HTML WIDGET BOX        **/
/***********************************/
class I3D_Widget_ContactFormMenu extends WP_Widget {
	function __construct() {
	//function I3D_Widget_ContactFormMenu() {
		$widget_ops = array('classname' => 'widget_aquila', 'description' => __( 'Render a contact form menu', "i3d-framework") );
		//$control_ops = array('width' => "400px");
		$control_ops = array();
		parent::__construct('i3d_contact_form_menu', __('i3d:Contact Form Menu', "i3d-framework"), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		//var_dump($args);
		global $settingOptions;
		//$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
		//$title =  empty($instance['title']) ? '' : $instance['title'];
		$instance =  wp_parse_args( (array) $instance, array( "text" => "", "no_wrapper" => true, "justification" => "", "title" => "<i class='icon-envelope'></i>", "form_id" => "cf_default_cb", "resposition" => false  ) );
		$title = I3D_Framework::conditionFontAwesomeIcon($instance['title']);
	//	print "title is $title<br>";
//var_dump($instance);
		$text = apply_filters( 'widget_text', $instance['text'], $instance );
		$justification = $instance['justification'];
		$form_id  = $instance['form_id'];
		if ($form_id == "" || $form_id == "*") {
			
			$form_id = $settingOptions['contact_menu_id'];
		
		}
		
		if ($form_id == "" || $form_id == "x") {
			return;
		}
		if ($instance['no_wrapper']) {
		
		} else {
		  echo $before_widget;
		

		  echo "<div class='i3d-widget-menu";
		  if ($justification == "right") {
			  echo " text-right pull-right";
		  } else if ($justification == "center") {
			  echo " text-center";
		  } else {
			  echo " text-left";
		  }
		  echo "'";
		  echo ">";
		}
		
		 if (I3D_Framework::$navbarVersion == "2" || I3D_Framework::$navbarVersion == "2.1" || I3D_Framework::$navbarVersion == "2.2") {
			echo '<div class="collapse navbar-collapse navbar-ex1-collapse contactform contactformbox">';		 
		//  echo "<div class='navbar contactform'>";
		  	echo "<ul class='nav navbar-nav pull-right'>";
		  	echo "<li class='dropdown contactform'>";
			 
		 } else if (I3D_Framework::$navbarVersion == "3" || I3D_Framework::$navbarVersion == "4") {
			echo '<div class="collapse navbar-collapse navbar-ex1-collapse contactform contactformbox">';		 
		//  echo "<div class='navbar contactform'>";
		  echo "<ul class='nav navbar-nav'>";
		  echo "<li class='dropdown'>";

		} else {
		  echo "<div class='navbar contactform'>";
		  echo "<ul class='nav pull-right'>";
		  echo "<li class='dropdown'>";
			 
		 }
		  echo "<a class='dropdown-toggle' data-toggle='dropdown' href='#'>";
		  echo $title;
		 if (I3D_Framework::$navbarVersion != "2" && I3D_Framework::$navbarVersion != "2.1"  && I3D_Framework::$navbarVersion != "3" && I3D_Framework::$navbarVersion != "4") {
		  echo "<strong class='caret'></strong>";
		 }
		 echo "</a>";
		  echo "<div class='dropdown-menu form-menu-wrapper";
		  if (I3D_Framework::$navbarVersion == "3" || I3D_Framework::$navbarVersion == "4") {
			  echo " contactdrop";
		  }
		  echo "'>";
		  echo do_shortcode("[i3d_contact_form id={$form_id}]");
		  echo "</div>"; 
		  echo "</li>";
		  echo "</ul>";
		  echo "</div>";
		 if (I3D_Framework::$navbarVersion == "2" || I3D_Framework::$navbarVersion == "") {
		  echo "</div>";
		 }
		 if (I3D_Framework::$navbarVersion == "2.2") {
			echo "</div></div>";
		 }

		if ($instance['no_wrapper']) {
		
		} else {
		  echo "</div>";
		  echo $after_widget;
		}
		if ($instance['resposition']) {
			?>
			<script>
			jQuery(document).ready(function() {
											
											<?php if (I3D_Framework::$navbarVersion == "2.1") { ?>
			jQuery(".contactformbox").insertAfter("ul.menu.nav.navbar-nav");
											<?php } else if (I3D_Framework::$navbarVersion == "2.2") { ?>
			jQuery(".contactformbox").insertAfter("ul.menu.nav.navbar-nav");
											<?php } else { ?>
			jQuery(".contactformbox").insertBefore("nav.navbar.navbar-default #menu");
											<?php } ?>
											});
			</script>
			<?php
			
		}
	}


	function layout_configuration_form( $instance, $defaults, $row_id, $widget_id, $layout_id, $page_level = false ) {
	  $instance =  wp_parse_args( (array) $instance, array( 'form_id' => '*'  ) );
	  global $post;
	  
	//  var_dump($instance);
	  
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
			
			$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"] =  wp_parse_args( (array) $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"], array( 'form_id' => "*"   ) );

	        $form_id 	= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["form_id"];

			// if box_style == "*" then it whatever the layout default is
			if ($form_id == "*") {
			  $instance['form_id'] = "*";
			  // if the box style is blank, then it means there is no box_style
			} else if ($form_id == "") {
				$instance['form_id'] = "";
			
			} else if ($form_id != "") {
			    $instance['form_id'] = $form_id;	
			}

			$layoutID = $layout_id;
	  } else {
		//  global $layoutID;
		  if ($instance['form_id'] == "*") {
			  
			  $instance['form_id'] = $defaults['form_id'];
		  }
		  $prefix = "";
		  
	  }
	//  print "layoutID: $layoutID";
      	//  $layoutName = $layouts["{$layout_id}"]["title"];
		$forms = get_option("i3d_contact_forms");
      	  $layoutName = $layouts["{$layout_id}"]["title"];

	  ?>
	<div class="input-group tt2" title="Choose Contact Form" >
  		<span class="input-group-addon detailed-addon"><i class="fa fa-envelope fa-fw"></i> <span class='detailed-label'>Contact Form</span></span>

	  <select class='form-control'  name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__form_id">
		<option  style='color: #cccccc;' value="">-- Choose Contact Form --</option>
	    <?php 
		// if there is no prefix, then this is the layout manager level
		if ($prefix == "") { 
			$selected_contact_box = $instance['form_id'];
            
		?>
		<?php 
		// else, if there is a prefix, then this is the page level configurations
		} else {

			$selected_contact_box = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["form_id"];
			//print "<option>$layout_id</option>";
			//print "<option>$selected_sidebar</option>";
			//print "<option>$widget_id</option>";
			?>
        <option value="*" ><?php _e("-- Layout Default --","i3d-framework"); ?></option>

		<?php } ?>
        <?php foreach ($forms as $id => $form) { ?>
          <option <?php if ($instance['form_id'] == $id) { print "selected"; } ?> value="<?php echo $id; ?>"><?php echo $form['form_title']; ?></option>
        <?php } ?>
		
		
                </select> 
				</div>
		
			<?php
	//  var_dump($instance);
	//  var_dump($defaults);
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['title'])));
		//$instance['title'] = $new_instance['title'];
		$instance['justification'] = $new_instance['justification']; 
	//	$instance['orientation'] = $new_instance['orientation']; 
		$instance['form_id'] = $new_instance['form_id']; 
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = format_to_edit($instance['title']);
		$justification = $instance['justification'];
//		$orientation = $instance['orientation'];
		$form_id = $instance['form_id'];

		global $i3dSupportedMenus;

?>
<script>

jQuery("a.widget-action").bind("click", function() {
			//	shrinkVideoRegion(this);									

});
 
jQuery("a.widget-control-close").bind("click", function() {
				//shrinkVideoRegion(this);									

});
</script>

<div class='i3d-widget-container'>
    <div class='i3d-help-region'>
    <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://www.youtube.com/watch?v=62RXnLGcOC8"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>
 <!--   <div class='i3d-help-region-opened i3d-help-region-hidden'>
    <div class='i3d-help-title-bar'>Hide <i class='icon-chevron-right'></i></div>
<iframe width="420" height="315" src="//www.youtube.com/embed/62RXnLGcOC8" frameborder="0" allowfullscreen></iframe>
    </div>-->
    </div>
<div class='i3d-widget-main'>


		<!-- title -->
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:',"i3d-framework"); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
	

        <!-- choose form -->
		<p><label for="<?php echo $this->get_field_id('form_id'); ?>"><?php _e('Contact Form:',"i3d-framework"); ?></label>
<?php 
		  $forms = get_option('i3d_contact_forms');
		  ?>
        <select class='widefat' id="<?php echo $this->get_field_id('form_id'); ?>" name="<?php echo $this->get_field_name('form_id'); ?>" >
        
        <?php 

if (is_array($forms)) {
	?>
      <option value="*">-- Use Site Default --</option>
<?php
		foreach($forms as $form) { ?>

          <option <?php if ($form['id'] == $form_id ) { print "selected"; } ?> value="<?php echo $form['id']; ?>"><?php echo $form['form_title']; ?></option>
        <?php } ?>  
        <?php } else { ?>
        <option value="">There are no forms yet created!</option>
        <?php } ?>
        </select>
        </p>
        
       

        <p>  
        <!-- justification -->
        <label class='label-125' for="<?php echo $this->get_field_id('justification'); ?>"><?php _e('Justification:',"i3d-framework"); ?></label>
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
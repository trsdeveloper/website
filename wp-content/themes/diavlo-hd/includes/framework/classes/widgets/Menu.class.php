<?php

/***********************************/
/**        HTML WIDGET BOX        **/
/***********************************/
class I3D_Widget_Menu extends WP_Widget {
	function __construct() {
	//function I3D_Widget_Menu() {
		$widget_ops = array('classname' => 'widget-i3d-menu', 'description' => __( 'Render a menu', "i3d-framework") );
		$control_ops = array();
		parent::__construct('i3d_menu', __('i3d:Custom Menu', "i3d-framework"), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		global $myPageID;
		global $settingOptions;
		$instance = wp_parse_args( (array) $instance, array( 'menu_type' => 'primary-horizontal', 'title' => '', 'title_tag' => 'h3', 'no_wrapper' => '', 'box_style' => '', 'title_icon' => '', 'text' => '', 'justification' => '', 'theme_location' => '', 'menu' => '', 'suppress_icons' => '', 'default_icon' => ''  ) );

		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
		$title = I3D_Framework::conditionFontAwesomeIcon($instance['title']);
		if ($instance['title_icon'] != "") { 
		   $title = "<i class='fa ".I3D_Framework::conditionFontAwesomeIcon($instance['title_icon'])."'></i> ".$title;
		}


		$justification = $instance['justification'];
		$menuType = $instance['menu_type'];

		$menu_id = $instance['menu'];
		
		if (I3D_Framework::use_global_layout()) {	
			$page_layouts 		= (array)get_post_meta($myPageID, "layouts", true);
			$page_layout_id 	= get_post_meta($myPageID, "selected_layout", true);
			$row_id 			= @$instance['row_id'];
			$widget_id 			= @$instance['widget_id'];
		
			$page_level_menu = @$page_layouts["$page_layout_id"]["$row_id"]["configuration"]["$widget_id"]["menu"];
		  	
			if ($page_level_menu != "") {
			
				$menu_id = $page_level_menu;
				
				$theme_location_menus = get_option('i3d_menu_options');
		  	
				if (array_key_exists($menu_id, $theme_location_menus)) {
					$theme_location = $menu_id;
					$menu_id = "";
		  		}
				
			} else {
				$theme_location = "";
				$theme_location_menus = get_option('i3d_menu_options');
		  //	var_dump($instance);
				if (array_key_exists($menu_id, $theme_location_menus)) {
					$theme_location = $menu_id;
					$menu_id = "";
		  		} else if (@array_key_exists($instance['theme_location'], $theme_location_menus)) {
					$theme_location = $instance['theme_location'];
					$menu_id = "";
		  		}
			}
		//  var_dump($theme_location_menus);
		 // if ($theme_location == "" && $menu_id == "") {
//print "test {$menu_id}";
		  
		} else {
			$theme_location = $instance['theme_location'];
			if ($theme_location == "default" || $theme_location == "") {
				$theme_location = $settingOptions['drop_menu_id'];
			} else if ($theme_location == "x") {
				$theme_location = "";
			}
			
		}
		
			//print "Menu id: $menu_id <br>";

			//print "Theme Location: $theme_location <br>";
		if ($instance['no_wrapper']) {
			
		} else {
		  if (strstr($menuType, "vertical")) {
			$before_widget = str_replace("i3d-opt-box-style", $instance['box_style'], $before_widget);
		  
		  } else if ($menuType == "secondary-horizontal" && I3D_Framework::$textLinksVersion == 2) {
			  $before_widget = $before_widget.'<div class="tl-bg45-left"></div><div class="tl-bg45">';
		      $after_widget = '</div><div class="tl-bg45-right"></div>'.$after_widget;
			  
		
					

	
		
		  } else if ($menuType == "tertiary-horizontal") {
			  $before_widget = $before_widget.'<div data-wow-delay="2s" class="wow fadeIn copyright-links">';
			  $after_widget = '</div>'.$after_widget;
		  }
		  
		  
		  echo $before_widget;
		  
		  echo "<div class='i3d-widget-menu";
		  if ($justification == "right") {
			  echo " text-right pull-right";
		  } else if ($justification == "center") {
			  echo " text-center";
		  } else if ($justification == "none") {
			  echo "";
		  } else {
			  echo " text-left";
		  }
		  echo "'";
		  echo ">";
		}


		  $menuClass = "menu";
		$menuWrap = '<ul class="menu">%3$s</ul>';
		$containerWrap = "";
		  $walker = new I3D_Walker_Nav_Menu($menuType, $instance['suppress_icons'], @$instance['default_icon']);
		  
		if ($menuType == "secondary-horizontal") {
		  echo "<div id='textlinks' class='text-links secondary-horizontal'>";
		  if (I3D_Framework::$navbarVersion == "5") {
			$menuWrap = '<ul id="top-menu" class="menu nav navbar-nav">%3$s</ul>';
		   echo '
<nav class="navbar navbar-default cl-effect-1">
  <div class="collapse navbar-collapse navbar-ex1-collapse">';			  
		  } else {
			$menuWrap = '%3$s';  
		  }
		  
		  $walker = new I3D_Walker_Nav_Menu("secondary-horizontal", $instance['suppress_icons'],  @$instance['default_icon']);
		} else if ($menuType == "tertiary-horizontal") {
		  $menuWrap = '%3$s';
		  $walker = new I3D_Walker_Nav_Menu("tertiary-horizontal", $instance['suppress_icons'],  @$instance['default_icon']);
			
		} else if ($menuType == "sub-vertical") {
			$menuWrap = '<ul class="menuside">%3$s</ul>';
			//print "sub vertical";
			  $walker = new I3D_Walker_Nav_Menu("sub-vertical", $instance['suppress_icons'],  @$instance['default_icon']);
		
		} else if ($menuType == "primary-horizontal" || $menuType == "") {
		  //$pageMenu = get_post_meta($myPageID, 'i3d_page_menu_id', true);
		//  if ($pageMenu != "") { 
		//    $theme_location = $pageMenu;
		//  }
		 // print "theme location = $pageMenu";
		 if (I3D_Framework::$navbarVersion == "2" || I3D_Framework::$navbarVersion == "2.1" || I3D_Framework::$navbarVersion == "2.2") {
			 if (I3D_Framework::$navbarVersion == "2.1" ) {
					echo '<header class="large">
					<nav class="navbar"><div class="nav-bg"><div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						  <span class="sr-only">Toggle navigation</span>
						  <span class="menu-toggle">Main Menu</span>
						  <span class="icon-align-justify icon-large"></span>
						</button>
					
					  </div>
					<div class="collapse navbar-collapse navbar-ex1-collapse">';
				 
				 
				 
			 } else if (I3D_Framework::$navbarVersion == "2.2") {
						echo '<div class="navbar navbar-main"><div class="navbar-inner navbar-inner-plain"><button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex2-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="menu-toggle">'.__("Main Menu", "i3d-framework").'</span>
      <span class="fa fa-th-list icon-list"></span>
    </button><div class="collapse navbar-collapse navbar-ex2-collapse">';			 
				 
			 }
		   $menuWrap = '<ul id="menu" class="menu nav navbar-nav">%3$s</ul>';
		  // echo "<div class='primary-horizontal-navbar'>";
		  // echo "<header class='large'>";
		 //  echo "<div class='nav-bg'>";
		   if (I3D_Framework::$navbarVersion != "2.2") {
		   ?>
           <div id="mini-logo-container"></div>
           <script>jQuery(document).ready(function() { jQuery("#mini-logo-container").html(jQuery("#website-name-tagline-wrapper div.website-name").html());});</script>
           <!--<h3 class="animated bounceInDown"><i class="icon-leaf"></i>  test <span>HD</span></h3>-->
           <?php
		   }
		 } else if (I3D_Framework::$navbarVersion == "3") {
		   $menuWrap = '<ul id="menu" class="menu nav navbar-nav">%3$s</ul>';
		 } else if (I3D_Framework::$navbarVersion == "4" || I3D_Framework::$navbarVersion == "5" ) {
		   echo '<div class="menu-top">
<nav class="navbar navbar-default cl-effect-1">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="menu-toggle">'.__("Main Menu", "i3d-framework").'</span>
      <span class="fa fa-th-list"></span>
    </button>

  </div>

  <div class="collapse navbar-collapse navbar-ex1-collapse">';
		   $menuWrap = '<ul id="menu" class="menu nav navbar-nav">%3$s</ul>';
			 
		 } else {
		   echo "<div class='navbar'><div class='navbar-inner navbar-inner-plain'>";
		   echo '<a class="btn btn-navbar" data-target=".nav-collapse" data-toggle="collapse">
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</a>';
echo "<div class='nav nav-collapse'>";
		 }
		
		} else if ($menuType == "primary-vertical" || $menuType == "") {
		  echo "<div class='primary-vertical'>";
		  //$menuWrap = '%3$s';
			 $walker = new I3D_Walker_Nav_Menu("primary-vertical", $instance['suppress_icons'],  @$instance['default_icon']);

		} else if ($menuType == "primary-contact") {
		  echo "<div class='navbar contactform'>";
				  $walker = new I3D_Walker_Nav_Menu("primary-contact", $instance['suppress_icons'],  @$instance['default_icon']);
	
		} else if ($menuType == "secondary-vertical") {
			$menuWrap = '<ul>%3$s</ul>';
		 // $menuWrap = '%3$s';
		  		  $menuClass = "";

		  $walker = new I3D_Walker_Nav_Menu("secondary-vertical", $instance['suppress_icons'], $instance['default_icon']);

			
		} 
	
		if ( !empty( $title ) ) {
			
			echo str_replace("h3", $instance['title_tag'], $before_title);

			echo $title;
						
			echo str_replace("h3", $instance['title_tag'], $after_title);
		} 
	    if ($menu_id != "") {
			wp_nav_menu(array( 'menu' => $menu_id,  'menu_class' => $menuClass, 'container' => false, 'items_wrap' => $menuWrap, 'walker' => $walker));
		} else if ($theme_location != "") { 
			//print "yes";
			wp_nav_menu(array( 'theme_location' => $theme_location, 'menu_class' => $menuClass, 'container' => false, 'items_wrap' => $menuWrap, 'walker' => $walker));
		} 

		if ($menuType == "secondary-horizontal" && I3D_Framework::$navbarVersion == "5") {
		  echo "</div></nav>";	
		}
		if ($menuType == "secondary-horizontal" || $menuType == "primary-vertical") {
		  echo "</div>";
		} else if ($menuType == "sub-vertical") {
			?>
<script type="text/javascript">
	jQuery(function() {
	
	    var menuside_ul = jQuery('.menuside > li > ul'),
	           menuside_a  = jQuery('.menuside > li > a');
	    
	    menuside_ul.hide();
	
	    menuside_a.click(function(e) {
			if (jQuery(this).siblings("ul").length > 0) {
	        e.preventDefault();
	        if(!jQuery(this).hasClass('active')) {
	            menuside_a.removeClass('active');
	            menuside_ul.filter(':visible').slideUp('normal');
	            jQuery(this).addClass('active').next().stop(true,true).slideDown('normal');
	        } else {
	            jQuery(this).removeClass('active');
	            jQuery(this).next().stop(true,true).slideUp('normal');
	        }
			}
	    });
	
	});
</script>	
<?php		
			
		} else if ($menuType == "primary-horizontal" || $menuType == "") {
		 if (I3D_Framework::$navbarVersion == "2" || I3D_Framework::$navbarVersion == "2.1" || I3D_Framework::$navbarVersion == "2.2") {
			 if (I3D_Framework::$navbarVersion == "2.1") {
					echo '
					</div>

					</div>
					</nav>
					</header>';
				 
				 
				 
			 } else if (I3D_Framework::$navbarVersion == "2.2") {
				 echo '</div></div></div>';
			 }
		 } else if (I3D_Framework::$navbarVersion == "3") {
		//   echo "</div>";
		//   echo "</div>";
		  // echo "</nav>";
		 //  echo "</header>";
		 //  echo "</div>";
		 } else if (I3D_Framework::$navbarVersion == "4" || I3D_Framework::$navbarVersion == "5" ) {
			echo "</div></nav></div>";
			 
		 } else {
			echo "</div></div></div>";
		 }
		} else if ($menuType == "primary-contact") {
		  echo "</div>";
			
		} else if ($menuType == "secondary-vertical") {
			
		} else if ($menuType == "secondary-horizontal") {
			echo "</div></div>";
		}
		
		if ($instance['no_wrapper']) {
		} else {
		  echo "</div>"; // close widget menu wrap
		  echo $after_widget;
		}
	//	exit;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['title'])));
		$instance['title_icon'] = $new_instance['title_icon']; 
		$instance['title_tag'] = $new_instance['title_tag']; 
		$instance['box_style'] = $new_instance['box_style']; 
		$instance['justification'] = $new_instance['justification']; 
	//	$instance['orientation'] = $new_instance['orientation']; 
		$instance['menu'] = $new_instance['menu']; 
		$instance['menu_type'] = $new_instance['menu_type']; 
		$instance['suppress_icons'] = $new_instance['suppress_icons']; 
		$instance['default_icon'] = $new_instance['default_icon']; 
		return $instance;
	}

	function layout_configuration_form( $instance, $defaults, $row_id, $widget_id, $layout_id, $page_level = false ) {
	  $instance =  wp_parse_args( (array) $instance, array( 'menu' => '', 'theme_location' => '', 'menu_type' => 'primary-horizontal', 'suppress_icons' => false, 'default_icon' => '', 'justification' => 'left', 'box_style' => '', 'title' => '', 'title_tag' => ''   ) );
	  global $post;
	  global $i3dSupportedMenus;
		$menus = get_terms('nav_menu');

	  $layouts = get_option('i3d_layouts');
	  if ($page_level) {
		 
		  $prefix = "__i3d_layouts__{$layout_id}__";
			$page_layouts 		= (array)get_post_meta($post->ID, "layouts", true);
			$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"] =  wp_parse_args( (array) @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"], array( 'menu' => '' ) );
	        /*
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
			*/
			$layoutID = $layout_id;
	  } else {
		//  global $layoutID;
		  
		  $prefix = "";
		  
	  }
	
	//  print "layoutID: $layoutID";
      ?>
	<div class="input-group  tt2 "  title="Choose Menu" >
  		<span class="input-group-addon"><i class="fa fa-compass fa-fw"></i> <span class='detailed-label'>Menu</span></span>
	  <select class='form-control menu-select' name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__menu">
	    <?php 
		$selected_theme_location = "";
		if ($prefix == "") { 
			$selected_menu = $instance['menu'];
			if ($selected_menu == "") {
				$selected_menu = $defaults["theme_location"];
			}
		} else {
			$selected_menu = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["menu"];		
			if ($selected_menu == "") {
				$selected_menu = $instance['menu'];
				if ($selected_menu == "") {
					$selected_menu = $defaults["theme_location"];
				}
			}
		}
		
		$theme_location_menus = get_option('i3d_menu_options');
		
		foreach ($theme_location_menus as $theme_location => $menu_name) {
			if ($theme_location == $selected_menu) {
				$selected_theme_location = $selected_menu;
			}
			?>
        <option rel="theme_location" value="<?php echo $theme_location; ?>" <?php if ($theme_location == $selected_menu) { print "selected"; } ?>><?php _e("Global Menu: {$menu_name}", "Globla Menu", "i3d-framework"); ?> <?php if ($theme_location == @$defaults['theme_location']) { print "(Default)"; } ?></option>
			
			<?php
		}
		
       	 foreach($menus as $menu) { ?>
          		<option <?php if ($menu->term_id == $selected_menu ) { print "selected"; } ?> value="<?php echo $menu->term_id; ?>"><?php echo $menu->name; ?></option>
        		<?php } ?>  

                </select> 
</div>
				<?php
	}

	function form( $instance ) {
				//__("TestMainMenuForm", get_template());

		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'title_tag' => '' ) );
		$title = format_to_edit(@$instance['title']);
		$justification = @$instance['justification'];
//		$orientation = $instance['orientation'];
		$menu_id = @$instance['menu'];
		$menu_type = @$instance['menu_type'];
		
		$menus = get_terms('nav_menu');
		global $i3dSupportedMenus;
				$random = rand();
				$rand = $random;


?>
<script>

function checkBoxStyleDiv<?php echo $rand; ?>(selectBox) {
  	var selectedValue = selectBox.options[selectBox.selectedIndex].value;
	if (selectedValue.search("vertical") != -1) {
	  jQuery("#box-style-chooser<?php echo $rand; ?>").css("display", "block");
	  jQuery("#default-menu-icon<?php echo $rand; ?>").css("display", "block");
	
	
	} else {
	  jQuery("#box-style-chooser<?php echo $rand; ?>").css("display", "none");
	  jQuery("#default-menu-icon<?php echo $rand; ?>").css("display", "none");
	}
}
</script>

<div class='i3d-widget-container'>
    <div class='i3d-help-region'>
		<div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://www.youtube.com/watch?v=NkZI5tbnh7E"><i class='icon-youtube-play'></i> Watch Help Video &nbsp; <i  class='icon-external-link'></i></a></div></div>
    </div>
	<div style='padding-top: 20px;'>
		<!-- title -->
		<label class='label-regular' for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', "i3d-framework"); ?></label>
        
			<select style='display: inline-block' class='input-mini'  id="<?php echo $this->get_field_id('title_tag'); ?>" name="<?php echo $this->get_field_name('title_tag'); ?>">
          <option value="h1">H1</option>
          <option <?php if ($instance['title_tag'] == "h2") { print "selected"; } ?> value="h2">H2</option>
          <option <?php if ($instance['title_tag'] == "h3" || $instance['title_tag'] == "") { print "selected"; } ?> value="h3">H3</option>
          <option <?php if ($instance['title_tag'] == "h4") { print "selected"; } ?> value="h4">H4</option>
          <option <?php if ($instance['title_tag'] == "h5") { print "selected"; } ?> value="h5">H5</option>
        </select>

		<div style='display: inline-block; vertical-align: top;'><?php I3D_Framework::renderFontAwesomeSelect($this->get_field_name('title_icon'), @$instance['title_icon'], false, __("-- No Icon --", "i3d-framework")); ?></div>
		<input type="text"  id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		
        <!-- menu type -->
		<p>
			<label class='label-100' for="<?php echo $this->get_field_id('menu_type'); ?>"><?php _e('Menu Type:', "i3d-framework"); ?></label>
			<select onchange="checkBoxStyleDiv<?php echo $rand; ?>(this)" id="<?php echo $this->get_field_id('menu_type'); ?>" name="<?php echo $this->get_field_name('menu_type'); ?>">
				<?php if ($i3dSupportedMenus['primary-horizontal']) { ?><option <?php if ($menu_type == "primary-horizontal")   { print "selected"; } ?> value="primary-horizontal"><?php _e('Primary Horizontal', "i3d-framework"); ?></option><?php } ?>
				<?php if ($i3dSupportedMenus['primary-vertical']) { ?><option <?php if ($menu_type == "primary-vertical")     { print "selected"; } ?> value="primary-vertical"><?php _e('Primary Vertical', "i3d-framework"); ?></option><?php } ?>
				<?php if ($i3dSupportedMenus['sub-vertical']) { ?><option <?php if ($menu_type == "sub-vertical")     { print "selected"; } ?> value="sub-vertical"><?php _e('Vertical with Subs', "i3d-framework"); ?></option><?php } ?>
				<?php /* if ($i3dSupportedMenus['primary-contact']) { ?><option <?php if ($menu_type == "primary-contact")      { print "selected"; } ?> value="primary-contact"><?php _e('Primary Contact',"i3d-framework"); ?></option><?php } */ ?>
				<?php if ($i3dSupportedMenus['secondary-horizontal']) { ?><option <?php if ($menu_type == "secondary-horizontal") { print "selected"; } ?> value="secondary-horizontal"><?php _e('Secondary Horizontal', "i3d-framework"); ?></option><?php } ?>
				<?php if ($i3dSupportedMenus['secondary-vertical']) { ?><option <?php if ($menu_type == "secondary-vertical")   { print "selected"; } ?> value="secondary-vertical"><?php _e('Secondary Vertical', "i3d-framework"); ?></option><?php } ?>
				<?php if ($i3dSupportedMenus['tertiary-horizontal']) { ?><option <?php if ($menu_type == "tertiary-horizontal")   { print "selected"; } ?> value="tertiary-horizontal"><?php _e('Tertiary Horizontal', "i3d-framework"); ?></option><?php } ?>
			</select> 
		</p>

        <!-- choose menu -->
		<p>
			<label class='label-100' for="<?php echo $this->get_field_id('menu'); ?>"><?php _e('Select Menu:', "i3d-framework"); ?></label>
			<select  id="<?php echo $this->get_field_id('menu'); ?>" name="<?php echo $this->get_field_name('menu'); ?>" >
				<option value="">-- No Menu Chosen --</option>
       			<?php foreach($menus as $menu) { ?>
          		<option <?php if ($menu->term_id == $menu_id ) { print "selected"; } ?> value="<?php echo $menu->term_id; ?>"><?php echo $menu->name; ?></option>
        		<?php } ?>  
        	</select>
        </p>
		
		<!-- box style -->
        <div id='box-style-chooser<?php echo $random; ?>' <?php if (!strstr($menu_type,"vertical")) { print "style='display: none;'"; } ?> >
			<?php if (sizeof(I3D_Framework::$boxStyles) > 0) { ?>
        	<label class='label-100' for="<?php echo $this->get_field_id('box_style'); ?>"><?php _e('Box Style:', "i3d-framework"); ?></label>
			<select id="<?php echo $this->get_field_id('box_style'); ?>" name="<?php echo $this->get_field_name('box_style'); ?>">
        		<?php foreach (I3D_Framework::$boxStyles as $className => $boxStyle) { ?>
				<option <?php if (@$instance['box_style'] == $className) { print "selected"; } ?> value="<?php echo $className; ?>"><?php echo $boxStyle; ?></option>
        		<?php } ?>
			</select> 
			<?php }  ?>
		</div>
       
        <!-- justification -->
        <p>  
        	<label class='label-100' for="<?php echo $this->get_field_id('justification'); ?>"><?php _e('Justification:', "i3d-framework"); ?></label>
			<select id="<?php echo $this->get_field_id('justification'); ?>" name="<?php echo $this->get_field_name('justification'); ?>">
				<option <?php if ($justification == "left") { print "selected"; } ?> value="left"><?php _e('Left', "i3d-framework"); ?></option>
				<option <?php if ($justification == "center") { print "selected"; } ?> value="center"><?php _e('Center', "i3d-framework"); ?></option>
				<option <?php if ($justification == "right") { print "selected"; } ?> value="right"><?php _e('Right', "i3d-framework"); ?></option>
			</select> 
        </p>
		<h3><?php _e('Menu Item Icons',"i3d-framework"); ?></h3>
		<!-- default icon -->
		
        <div class='widget-column-50' id='default-menu-icon<?php echo $random; ?>' <?php if (!strstr($menu_type,"vertical")) { print "style='display: none;'"; } ?> >
        	<label class='label-regular'  for="<?php echo $this->get_field_id('default_icon'); ?>"><?php _e('Default Menu Item Icon', "i3d-framework"); ?></label>
        	<div style='clear: both;' ><?php I3D_Framework::renderFontAwesomeSelect($this->get_field_name('default_icon'), @$instance['default_icon']); ?></div>
		</div>

        <!-- suppress icons -->
		<!-- September 30, 2014: changed field label to "Display Menu Item Custom Icons" from "Suppress Icons" and reversed the option names -->
        <div class='widget-column-50'>  
			<label class='label-regular' for="<?php echo $this->get_field_id('suppress_icons'); ?>"><?php _e('Display Custom Icons', "i3d-framework"); ?></label>
			<select class='input-mini' id="<?php echo $this->get_field_id('suppress_icons'); ?>" name="<?php echo $this->get_field_name('suppress_icons'); ?>">
				<option <?php if (@$instance['suppress_icons'] == "0") { print "selected"; } ?> value="0"><?php _e('Yes', "i3d-framework"); ?></option>
				<option <?php if (@$instance['suppress_icons'] == "1") { print "selected"; } ?> value="1"><?php _e('No', "i3d-framework"); ?></option>
			</select> 
        </div>
	</div>
</div>
<?php
	}
}


?>